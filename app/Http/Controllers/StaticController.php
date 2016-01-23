<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class StaticController extends Controller
{

    public function getIndex()
    {
        return view('index');
    }

    public function getProfile()
    {
        return view('profile');
    }

    public function getSettings()
    {
        return view('settings');
    }

    public function postUpload()
    {
        // process uploaded XML...

        echo "processing xml";

        // TODO render view or redirect
        return "<br>DONE";
    }


}
