<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\User;
use Image;
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
    public function handle()
    {
        $public_path = '/images/' . $this->user->twitter_id . '.jpg';
        $path = __DIR__ . '/../../public' . $public_path;
        file_put_contents($path, fopen($this->user->avatar, 'r'));

        Image::make($path, array(
            'width' => 400,
            'height' => 400
        ))->save($path);
        
        $this->user->avatar = $public_path;
        $this->user->save();
    }
}
