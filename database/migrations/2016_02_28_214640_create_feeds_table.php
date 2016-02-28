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
        // 1. create the feeds table
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->integer('podcast_id')->unsigned();

            $table->timestamps();

            $table->foreign('podcast_id')->references('id')->on('podcasts')->onDelete('cascade');
        });

        // 2. enter feed data into new table
        foreach(App\Models\Podcast::all() as $podcast) {
            $feed = new App\Models\Feed;
            $feed->url = $podcast->feed;
            $podcast->feeds()->save($feed);
        }

        // 3. drop the feed column
        Schema::table('podcasts', function (Blueprint $table) {
            $table->dropColumn('feed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1. put back the feed column
        Schema::table('podcasts', function (Blueprint $table) {
            $table->string('feed');
        });

        // 2. enter the feed data. This will only work properly if there is no
        // podcast with more than one feed.
        foreach(App\Models\Feed::all() as $feed) {
            $podcast = $feed->podcast;
            $podcast->feed = $feed->url;
            $podcast->save();
        }

        // 3. drop the feeds table
        Schema::drop('feeds');
    }
}
