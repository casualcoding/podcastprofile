<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToPodcastUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('podcast_user', function (Blueprint $table) {
            // Set the foreign key columns to unsigned to match the unsigned
            // primary keys created by `increments`.
            $table->integer('podcast_id')->unsigned()->change();
            $table->integer('user_id')->unsigned()->change();

            $table->foreign('podcast_id')->references('id')->on('podcasts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('podcast_user', function (Blueprint $table) {
            // Making the columns unsigned can not be undone.
            $table->dropForeign('podcast_user_podcast_id_foreign');
            $table->dropForeign('podcast_user_user_id_foreign');
        });
    }
}
