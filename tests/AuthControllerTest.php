<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;


class AuthControllerTest extends TestCase
{
    use App\Http\Controllers\Auth\TwitterApi {
        getNickFromTwitter as traitGetNickFromTwitter;
    }
    use DatabaseMigrations, DatabaseTransactions;

    /**
     * Tests twitter username recursive updating.
     *
     * @return void
     */
    public function testRecursiveUpdateNicknames()
    {
        $user1 = factory(App\Models\User::class)->create(['twitter_id' => '1', 'handle' => 'a']);
        $user2 = factory(App\Models\User::class)->create(['twitter_id' => '2', 'handle' => 'b']);
        $user3 = factory(App\Models\User::class)->make(['twitter_id' => '3', 'handle' => 'c']);

        $this->recursiveUpdateNicknames($user1);

        $this->seeInDatabase('users', ['twitter_id' => '1', 'handle' => 'b']);
        $this->seeInDatabase('users', ['twitter_id' => '2', 'handle' => 'c']);
        $this->seeInDatabase('users', ['twitter_id' => '3', 'handle' => 'a']);
    }

    private function getNickFromTwitter($twitter_id)
    {
        if ($twitter_id == '1') {
            return 'b';
        } else if ($twitter_id == '2') {
            return 'c';
        } else if ($twitter_id == '3') {
            return 'a';
        }
    }
}
