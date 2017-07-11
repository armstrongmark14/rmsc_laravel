<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Volunteer\TimesheetController;
use App\Model\Volunteer\Department;
use App\Model\Volunteer\Note;
use App\Model\Volunteer\Photo;
use App\Model\Volunteer\Skill;
use App\Model\Volunteer\Timesheet;
use App\Model\Volunteer\Type;
use App\Model\Volunteer\Volunteer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //



    /**
     * Shows a profile page for a volunteer, and allows you to edit their values
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateVolunteer(Request $request)
    {
        $volunteer = Volunteer::findOrFail($request->id);
        $this->validate($request, [
            'first_name' => 'required',
            'email' => 'nullable|email'
        ]);
        $volunteer->update($request->all());

        // Handling the file upload
        if ($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            $file->move('images/volunteers', $name);
            $photo = Photo::create(['filename' => $name]);
            $volunteer->photo_id = $photo->id;
        }

        // Handling the note & skill updating
        $this->updateNote($request, $volunteer);
        $this->updateSkill($request, $volunteer);
        $this->updateCheckbox('limited', $request, $volunteer);
        $this->updateCheckbox('background', $request, $volunteer);
        $this->updateCheckbox('edit_time', $request, $volunteer);

        $volunteer->save();

        session()->flash('admin-success', 'Volunteer record updated for Badge: ' . $volunteer->badge . ' Name: ' . $volunteer->first_name);

        return redirect()->route('volunteer-profile', ['id' => $volunteer->id]);
    }

    /**
     * Creates a Volunteer object from scratch and saves it to the database
     */
    public function createVolunteer(Request $request)
    {
        $this->validate($request, [
            'badge' => 'bail|required|unique:volunteers',
            'first_name' => 'required',
            'email' => 'nullable|email'
        ]);

        $volunteer = Volunteer::create($request->all());

        if ($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            $file->move('images/volunteers', $name);
            $photo = Photo::create(['filename' => $name]);
            $volunteer->photo_id = $photo->id;
        }

        // Handling the note/skill/location/background updating
//        $this->updateLimited($request, $volunteer);
        $this->createNote($request, $volunteer);
        $this->createSkill($request, $volunteer);

        $volunteer->save();

        session()->flash('admin-success', 'Volunteer record created for Badge: ' . $volunteer->badge . ' Name: ' . $volunteer->first_name);

        return redirect()->route('volunteer-profile', ['id' => $volunteer->id]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Goes to admin/home
     */
    public function homepage()
    {
        $weekHours = DB::select(DB::raw("
            SELECT DATE(timesheets.in) as day,
              ROUND(SUM(TIMESTAMPDIFF(MINUTE, timesheets.in, timesheets.out ) / 60 ), 2) as hours
            FROM timesheets
            WHERE DATE(timesheets.in) > CURDATE() - INTERVAL 7 DAY
            GROUP BY DATE(timesheets.in);"));

        return view('admin.home', compact('weekHours'));
    }

    /**
     * Displays the add a volunteer page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addVolunteer()
    {
        $departments = Department::orderBy('name', 'ASC')->pluck('name', 'id');
        $types = Type::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.volunteer.profile', compact('departments', 'types'));
    }

    /**
     * @param $id - The volunteer id from the database.... not the badge #
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View returns profile of this volunteer
     */
    public function volunteerProfile($id)
    {
        $volunteer = Volunteer::find($id);
        $departments = Department::orderBy('name', 'ASC')->pluck('name', 'id');
        $types = Type::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.volunteer.profile', compact('volunteer', 'departments', 'types'));
    }

    /**
     * Page for admins to edit timesheets
     */
    public function editTimesheet($id)
    {
        $timesheet = Timesheet::find($id);
        $volunteer= $timesheet->volunteer;
        return view('admin.volunteer.edit.timesheet', compact('volunteer', 'timesheet'));
    }

    public function createTimesheetPage($id)
    {
        $volunteer = Volunteer::find($id);
        $date = Timesheet::now();
        return view('admin.page.create-timesheet', compact('volunteer', 'date'));
    }

    public function createTimesheet(Request $request)
    {
        // Using our other controller to validate instead of copying code
        $timesheetController = new TimesheetController();
        $timesheetController->validateTimesheet($request);

        // Validating the date and times the user entered as valid timestamps
        if (! $timesheetController->regexTimesheet($request, true)) {
            return redirect('admin/create/timesheet/'.$request->id);
        }

        if (!Volunteer::where('badge', '=', $request->badge)->exists()) {
            session()->flash('admin-error', 'You must enter a valid badge number.');
            return redirect('/admin/create/timesheet/'.$request->id);
        }

        $volunteer = Volunteer::where('badge', '=', $request->badge)->get()[0];

        Timesheet::create([
            'volunteer_id' => $volunteer->id,
            'in' => $request->date . ' ' . $request->in,
            'out' => $request->date . ' ' . $request->out
        ]);

        return redirect()->route('admin-volunteer-timesheet', $volunteer->id);
    }

    /**
     * This will be called after an edit timesheet form is submitted
     */
    public function updateTimesheet(Request $request)
    {
        // Using our other controller to validate instead of copying code
        $timesheetController = new TimesheetController();
        $timesheetController->validateTimesheet($request);

        $timesheet = Timesheet::find($request->id);
        $date = $request->date;

        // Validating the date and times the user entered as valid timestamps
        if (! $timesheetController->regexTimesheet($request, true)) {
            return redirect('admin/edit/timesheet/'.$request->id);
        }

        $timesheet->in = $date . ' ' . $request->in;
        $timesheet->out = $date . ' ' . $request->out;
        $timesheet->save();
        return redirect()->route('admin-volunteer-timesheet', $request->volunteerID);
    }

    /**
     * Will delete a timesheet record from the database
     */
    public function removeTimesheet($id)
    {
        $timesheet = Timesheet::find($id);
        $volID = $timesheet->volunteer_id;
        $timesheet->delete();
        session()->flash('admin-success', 'Timesheet deleted successfully');
        return redirect()->route('admin-volunteer-timesheet', $volID);
    }

    /**
     * @param $id - The volunteer id - NOT BADGE #
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View A list of this volunteers timesheets
     */
    public function volunteerTimesheet($id)
    {
        $volunteer = Volunteer::find($id);
        $timesheets = Timesheet::where('volunteer_id', '=', $volunteer->id)->orderBy('timesheets.in', 'DESC')->get();
        $editTimesheets = true;
        return view('admin.volunteer.timesheet', compact('volunteer', 'timesheets', 'editTimesheets'));
    }

    /**
     * This will display a table of all the un-clocked-out timesheets
     */
    public function openTimesheets()
    {
        $timesheets = Timesheet::whereRaw('timesheets.in = timesheets.out')->orderBy('timesheets.in', 'DESC')->get();
        $editTimesheets = true;
        return view('admin.page.open-timesheets', compact('timesheets', 'editTimesheets'));
    }

    /**
     * @param $id volunteer id from database
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The confirmation page to delete vol
     */
    public function volunteerDelete($id)
    {
        $volunteer = Volunteer::find($id);
        return view('admin.volunteer.delete', compact('volunteer'));
    }

    /**
     * This is the page where the Admin has to confirm they want to delete that volunteer
     *
     * @param $id - The id of the vol that we're deleting
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector Deletes the vol and redirects
     */
    public function volunteerDeleteConfirmed($id)
    {
        Volunteer::destroy($id);
        return redirect('/admin/home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View the view with all the volunteers
     */
    public function fullVolunteerList()
    {
        // This works much faster than just getting all records laravel style. Much, much faster.
        $volunteers = DB::table('volunteers')
            ->join('departments', 'departments.id', 'volunteers.department_id')
            ->join('types', 'types.id', 'volunteers.type_id')
            ->join('notes', 'notes.id', 'volunteers.note_id')
            ->join('skills', 'skills.id', 'volunteers.skill_id')
            ->join('photos', 'photos.id', 'volunteers.photo_id')
            ->select('volunteers.*', 'departments.name as department', 'types.name as type', 'notes.value as note', 'skills.value as skill', 'photos.filename as filename')
            ->orderBy('badge', 'ASC')
            ->get();

        return view('admin.page.volunteer-list', compact('volunteers'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The volunteers currently here
     */
    public function currentlyHere()
    {
        $volunteers = [];
        $timesheets = Timesheet::where('in', '>=', Carbon::today())->whereRaw('timesheets.in = timesheets.out')->get();
        foreach ($timesheets as $timesheet) {
            array_push($volunteers, $timesheet->volunteer);
        }
        return view('admin.page.currently-here', compact('volunteers'));
    }

    /**
     * Will create a skill
     */
    private function createNote(Request $request, Volunteer $volunteer)
    {
        if ($request->note != null && strcmp(trim($request->note), 'default') != 0) {
            $note = Note::create(['value' => $request->note]);
            $note->save();
            $volunteer->note_id = $note->id;
        }
    }

    public function createSkill(Request $request, Volunteer $volunteer)
    {
        if ($request->skill != null && strcmp(trim($request->skill), 'default') != 0) {
            $skill = Skill::create(['value' => $request->skill]);
            $skill->save();
            $volunteer->skill_id = $skill->id;
        }
    }





    /**
     * Uses the inputs to update a note if needed when editing volunteer info
     * @param Request $request
     * @param Volunteer $volunteer
     */
    private function updateNote(Request $request, Volunteer $volunteer)
    {
        if (isset($request->note_id)) {
            $note = Note::find($request->note_id);
            $note->value = $request->note;
            $note->save();
        } else if ($request->note_id == 1 && strcmp(trim($request->note), 'default') != 0) {
            $note = Note::create(['value' => $request->note]);
            $note->save();
            $volunteer->note_id = $note->id;
        }
    }

    /**
     * @param $variable - The checkbox id field that you're updating on Volunteer
     * @param Request $request - The request with the data from the form
     * @param Volunteer $volunteer - The volunteer object you want to update values on
     */
    private function updateCheckbox($variable, Request $request, Volunteer $volunteer)
    {
        $volunteer->$variable = 0;

        if ($request->$variable == 1) {
            $volunteer->$variable = 1;
        }
    }

    /**
     * Uses the inputs to update a skill if needed when editing volunteer info
     * @param Request $request
     * @param Volunteer $volunteer
     */
    private function updateSkill(Request $request, Volunteer $volunteer)
    {
        if ($request->skill_id != 1) {
            $skill = Skill::find($request->skill_id);
            $skill->value = $request->skill;
            $skill->save();
        } else if ($request->skill_id == 1 && strcmp(trim($request->skill), 'default') != 0) {
            $skill = Skill::create(['value' => $request->skill]);
            $skill->save();
            $volunteer->skill_id = $skill->id;
        }
    }

    /**
     * Displays the admin change password page
     */
    public function changePassword()
    {
        return view('admin.page.change-password');
    }

    /**
     * This will be called after user submits a password change
     */
    public function updatePassword(Request $request)
    {
        $user = User::find($request->user_id);

        // Check if old password != current one in DB
        if (! Hash::check($request->old_password, $user->password)) {
            session()->flash('admin-error', 'Old password does not match.');
            return redirect('/admin/change-password');
        }

        // Check if new and confirmed password don't match && are not null
        if (strcmp($request->new_password, $request->confirm_password) != 0
                || $request->new_password == null) {
            session()->flash('admin-error', 'New passwords do not match.');
            if ($request->new_password == null) {
                session()->flash('admin-error', 'New password cannot be blank');
            }
            return redirect('/admin/change-password');
        }

        // Now we can update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        session()->flash('admin-success', 'Password updated successfully.');

        return redirect('admin/home');
    }



    /*
     * Below are functions for adding a new badge when one is swiped that isn't in the database.
     * These functions are pretty ghetto because I doubt they'll be used often.
     */

    public function rejectAddSwipe()
    {
        session()->flash('login-status', 'You do not have access to that page without admin credentials.');
        return redirect('/');
    }

    public function newBadgeSwiped(Request $request)
    {
        $badgeValue = $request->badge;
        return view('admin.volunteer.swipe-add.admin-login', compact('badgeValue'));
    }

    /**
     * This will happen when a badge that doesn't exist in database is swiped On Location.
     * It will go to a page to create a new volunteer entry without logging in as admin, but still requires
     * admin credentials.
     */
    public function newBadge(Request $request)
    {
        echo $request->alreadyValidated;
        /*
         * First have to check if the admin login is correct
         * I'm using a ghetto version of the admin login and not creating a user since I don't want them to
         * be logged in for more than just this one page when they do this.
        */
        try {
            $user = User::where('name', '=', $request->username)->firstOrFail();
        }
        catch (\Exception $e) {
            session()->flash('login-status', 'Please enter a valid username.');
            return redirect('/admin/volunteer/add-new?badge=' . $request->badgeValue);
        }

        if (! $user->checkPassword($request->password)) {
            session()->flash('login-status', 'Please enter a correct password.');
            return redirect('/admin/volunteer/add-new?badge=' . $request->badgeValue);
        }

        // Since admin credentials check out, we can show the add volunteer page
        $departments = Department::orderBy('name', 'ASC')->pluck('name', 'id');
        $types = Type::orderBy('name', 'ASC')->pluck('name', 'id');
        $badgeValue = $request->badgeValue;
        return view('admin.volunteer.swipe-add.add', compact('types', 'departments', 'badgeValue'));
    }

    /**
     * The new badge swipe page has been submitted and must be checked and handled.
     * Only checking that there's a first name, because nobody cares about having complete data :(
     */
    public function newBadgeSubmitted(Request $request)
    {
        // Doing my own validation since the ghetto login breaks laravel validation methods
        if ($request->first_name == null) {
            session()->flash('login-status', 'First Name is required.');
            return redirect('/admin/volunteer/add-new?badge=' . $request->badge);
        }

        $this->createVolunteer($request);
        session()->forget('admin-success');
        session()->flash('volunteer-success', "Volunteer record created successfully! Badge: ". $request->badge ."\nName: ". $request->first_name);
        return redirect('/');
    }

    public function volListQuickLinks($id)
    {
        return 5;
    }

}
