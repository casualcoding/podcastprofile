<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Services\ImageDownloadService;
use DB;



class AdminApiController extends Controller
{
    public function postEditPodcast($id, ImageDownloadService $downloader)
    {
        $podcast = Podcast::where('id', $id)->firstOrFail();
        $podcast->name = Input::get('name');
        $podcast->url = Input::get('url');
        $podcast->error = Input::get('error');

        $imageurl = Input::get('coverimage');
        if ($podcast->coverimage != $imageurl) { // only download the image if it changed
            $path = $downloader->saveImage($imageurl, md5($podcast->feed), 600, 600);
            $podcast->coverimage = $path;
        }

        $podcast->edited_manually = true;
        $podcast->save();
        return Redirect::route('admin::getEditPodcast', compact('id'));
    }

    public function postDeleteJob($id)
    {
        DB::table('jobs')->where('id', '=', $id)->delete();
        return Redirect::route('admin::getJobs');
    }
}
