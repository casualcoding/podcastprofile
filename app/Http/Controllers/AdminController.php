<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\User;
use DB;
use Image;


class AdminController extends Controller
{
    public function getAdmin()
    {
        $users = User::all();
        $podcasts = Podcast::all();
        $jobs = DB::select('select * from jobs');
        $failed_jobs = DB::select('select * from failed_jobs');
        return view('admin', compact('users', 'podcasts', 'jobs', 'failed_jobs'));
    }
    
    public function getEditPodcast($id)
    {
        $podcast = Podcast::where('id', $id)->firstOrFail();
        return view('editpodcast', compact('podcast'));
    }
    
    public function postEditPodcast($id)
    {
        $podcast = Podcast::where('id', $id)->firstOrFail();
        $podcast->name = Input::get('name');
        $podcast->url = Input::get('url');
        
        if ($podcast->coverimage != Input::get('coverimage')) {
            $public_path = '/images/';
            $internal_path = __DIR__ . '/../../../public';
            $path = $internal_path . $public_path;
            $filename = md5($podcast->feed).'.jpg';

            try {
                unlink($internal_path . $podcast->coverimage);
            } catch (\Exception $e) {
                // if old image not there do nothing
            }
            Image::make(Input::get('coverimage'))->fit(600, 600)->save($path.$filename);
            $podcast->coverimage = $public_path.$filename;
        }
        
        $podcast->save();
        return Redirect::route('getEditPodcast', compact('id'));
    }
}
