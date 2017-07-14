<?php

namespace App\Http\Controllers\Admin;

use App\Model\Volunteer\OldVol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OldSystem extends Controller
{
    //

    public function volunteerList()
    {
        $oldVols = OldVol::all();
        return view('admin.old-sys.vol-list', compact('oldVols'));
    }

    public function profile($id)
    {
        $vol = OldVol::find($id);
        $attributes = $vol->getAttributes();
//        dd($attributes);
        return view('admin.old-sys.profile', compact('vol', 'attributes'));
    }
}
