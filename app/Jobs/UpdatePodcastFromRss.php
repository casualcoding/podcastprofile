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
        // At this point, a podcast has exactly one feed
        $feed_url = $this->podcast->feeds->first()->url;

        $feed_data = $parser->loadDetailsFromRss($feed_url);
        $this->podcast->name = $feed_data['title'];
        $this->podcast->url = $feed_data['link'];
        $this->podcast->description = $feed_data['summary'];

        $image_path = $downloader->saveImage($feed_data['image'], md5($feed_url), 600, 600);
        if ($image_path != null) {
            $this->podcast->coverimage = $image_path;
        }

        if ($this->podcast->name == null) {
            $this->podcast->error = config('errors.rss_parsing_error');;
        }

        $this->podcast->save();
    }
}
