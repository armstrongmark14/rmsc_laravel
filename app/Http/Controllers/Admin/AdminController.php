<?php

namespace App\Http\Controllers\Admin;

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
        $volunteer->department_id = $request->department;
        $volunteer->type_id = $request->type;


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

    public function editTimesheet($id)
    {
        $timesheet = Timesheet::find($id);
        $volunteer= $timesheet->volunteer;
        return view('admin.volunteer.edit.timesheet', compact('volunteer', 'timesheet'));
    }

    public function updateTimesheet(Request $request)
    {
        $timesheet = Timesheet::find($request->id);
        $date = $request->date;
        $timesheet->in = $date . ' ' . $request->in;
        $timesheet->out = $date . ' ' . $request->out;
        $timesheet->save();
        return redirect()->route('admin-volunteer-timesheet', $request->volunteerID);
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
        $volunteers = Volunteer::all();
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

    private function updateLocationLimited(Request $request, Volunteer $volunteer)
    {
        if (strcmp('yes', $request->limited) == 0) {
            $limited = Limited::find($request->skill_id);
            $limited->volunteer_id = $request->skill;
            $limited->save();
        } else if ($request->skill_id == 1 && strcmp(trim($request->skill), 'default') != 0) {
            $skill = Skill::create(['value' => $request->skill]);
            $skill->save();
            $volunteer->skill_id = $skill->id;
        }
    }

    public function changePassword()
    {
        return view('admin.page.change-password');
    }

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

}
