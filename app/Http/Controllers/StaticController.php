<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

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

    public function postUpload(Request $request)
    {
        $file = $request->file('upload');
        $xml = simplexml_load_file($file);

        foreach ($xml->body->outline as $outline) {
            print_r((string) $outline['xmlUrl'].'<br>');
            // send feed url to the queue
        }

        // TODO render view or redirect
        return "<br>DONE";
    }


}
