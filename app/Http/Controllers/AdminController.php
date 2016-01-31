<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\User;
use App\Services\ImageDownloadService;
use DB;



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
    
    public function postEditPodcast($id, ImageDownloadService $downloader)
    {
        $podcast = Podcast::where('id', $id)->firstOrFail();
        $podcast->name = Input::get('name');
        $podcast->url = Input::get('url');
        
        $imageurl = Input::get('coverimage');
        if ($podcast->coverimage != $imageurl) { // only download the image if it changed
            $path = $downloader->saveImage($imageurl, md5($podcast->feed), 600, 600);
            $podcast->coverimage = $path;
        }
        
        $podcast->save();
        return Redirect::route('getEditPodcast', compact('id'));
    }
}
