<?php

namespace App\Http\Controllers\Admin;

use App\Model\Volunteer\Department;
use App\Model\Volunteer\Note;
use App\Model\Volunteer\Skill;
use App\Model\Volunteer\Timesheet;
use App\Model\Volunteer\Type;
use App\Model\Volunteer\Volunteer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class AdminController extends Controller
{
    //

    public function homepage()
    {
        return view('admin.home');
    }

    public function volunteerProfile($id)
    {
        $volunteer = Volunteer::find($id);
        $departments = Department::orderBy('name', 'ASC')->pluck('name', 'id');
        $types = Type::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.volunteer.profile', compact('volunteer', 'departments', 'types'));
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

    public function updateVolunteer(Request $request)
    {
        $volunteer = Volunteer::findOrFail($request->id);
        $volunteer->update($request->all());
        $volunteer->department_id = $request->department;
        $volunteer->type_id = $request->type;

        // Handling the note & skill updating
        $this->updateNote($request, $volunteer);
        $this->updateSkill($request, $volunteer);

        $volunteer->save();
        return redirect()->action('Admin\AdminController@volunteerProfile', ['id' => $volunteer->id]);
    }


    private function updateNote(Request $request, Volunteer $volunteer)
    {
        if ($request->note_id != 1) {
            $note = Note::find($request->note_id);
            $note->value = $request->note;
            $note->save();
        } else if ($request->note_id == 1 && strcmp(trim($request->note), 'default') != 0) {
            $note = Note::create(['value' => $request->note]);
            $note->save();
            $volunteer->note_id = $note->id;
        }
    }

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
}
