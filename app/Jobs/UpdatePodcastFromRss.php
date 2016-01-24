<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Podcast;
use App\Services\FeedService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePodcastFromRss extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

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
    public function handle(FeedService $parser)
    {
        $feed = $parser->loadDetailsFromRss($this->podcast->feed);
        $this->podcast->name = $feed['title'];
        $this->podcast->url = $feed['link'];
        $this->podcast->coverimage = $feed['iamge'];
        $this->podcast->description = $feed['summary'];
        $this->podcast->save();
    }
}
