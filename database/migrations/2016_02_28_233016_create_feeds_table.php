<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create the feeds table
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->integer('podcast_id')->unsigned();

            $table->timestamps();

            $table->foreign('podcast_id')->references('id')->on('podcasts')->onDelete('cascade');
        });

        // enter feed data into new table
        foreach(App\Models\Podcast::all() as $podcast) {
            $feed = new App\Models\Feed;
            $feed->url = $podcast->feed;
            $podcast->feeds()->save($feed);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // enter the feed data. This will only work properly if there is no
        // podcast with more than one feed.
        foreach(App\Models\Feed::all() as $feed) {
            $podcast = $feed->podcast;
            $podcast->feed = $feed->url;
            $podcast->save();
        }

        Schema::drop('feeds');
    }
}
