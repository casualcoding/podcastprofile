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
        return Redirect::route('admin::getPodcasts');
    }

    public function getUsers()
    {
        $users = User::paginate(20);
        return view('admin.users', $this->mergeModelCounts(compact('users')));
    }

    public function getPodcasts()
    {
        $podcasts = Podcast::paginate(20);
        return view('admin.podcasts', $this->mergeModelCounts(compact('podcasts')));
    }

    public function getJobs()
    {
        $jobs = DB::table('jobs')->paginate(20);
        return view('admin.jobs', $this->mergeModelCounts(compact('jobs')));
    }

    public function getFailedJobs()
    {
        $failed_jobs = DB::table('failed_jobs')->paginate(20);
        return view('admin.failedjobs', $this->mergeModelCounts(compact('failed_jobs')));
    }

    public function getEditPodcast($id)
    {
        $podcast = Podcast::where('id', $id)->firstOrFail();
        return view('admin.editpodcast', $this->mergeModelCounts(compact('podcast')));
    }

    private function mergeModelCounts(array $array)
    {
        $counts = $this->getModelCounts();
        return array_merge(['counts' => $counts], $array);
    }

    /**
     * Returns the counts of the models, e.g.
     * ['podcasts' => 10, 'users' => 2, ...]
     *
     * @return array
     */
    private function getModelCounts()
    {
        $podcasts = Podcast::all()->count();
        $users = User::all()->count();
        $jobs = DB::table('jobs')->count();
        $failed_jobs = DB::table('failed_jobs')->count();
        return compact('podcasts', 'users', 'jobs', 'failed_jobs');
    }
}
