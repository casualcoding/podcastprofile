<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use App\Services\ImageDownloadService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserAvatar extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ImageDownloadService $downloader)
    {
        $filename = md5($this->user->twitter_id);
        $image_path = $downloader->saveImage($this->user->avatar, $filename, 400, 400);
        
        $this->user->avatar = $image_path;
        $this->user->save();
    }
}
