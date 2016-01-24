<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Podcast;
use App\Services\FeedService;
use App\Services\ImageDownloadService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePodcastFromRss extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     *
     * @param  Podcast $podcast
     * @return void
     */
    public function __construct(Podcast $podcast)
    {
        $this->podcast = $podcast;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FeedService $parser, ImageDownloadService $downloader)
    {
        $feed = $parser->loadDetailsFromRss($this->podcast->feed);
        $this->podcast->name = $feed['title'];
        $this->podcast->url = $feed['link'];
        $this->podcast->description = $feed['summary'];

        $image_path = $downloader->saveImage($feed['image'], md5($this->podcast->url), 600, 600);
        if ($image_path != null) {
            $this->podcast->coverimage = $image_path;
        }

        if ($this->podcast->name == null) {
            $this->podcast->error = 17; // podcast could not be parsed error
        }

        $this->podcast->save();
    }
}
