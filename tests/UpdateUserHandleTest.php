<?php

use App\Jobs\UpdateUserHandle;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateUserHandleTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, DispatchesJobs;

    /**
     * Tests twitter username recursive updating.
     *
     * @return void
     */
    public function testUpdateHandles()
    {
        //TODO mock Twitter api request, change test data (twitter ids and handles)

        $user1 = factory(App\Models\User::class)->create(['twitter_id' => '78598098', 'handle' => 'maxfriedrich']);
        $user2 = factory(App\Models\User::class)->create(['twitter_id' => '14247082', 'handle' => 'florianletsch']);
        $user3 = factory(App\Models\User::class)->create(['twitter_id' => '183628109', 'handle' => 'rolfboom']);
        $new_nick = $user3->handle;

        if ($new_nick != $user1->handle) {
            if ($user2) {
                $user2->handle = $user2->twitter_id;
                $user2->save();
                // update user handle asynchronously
                $this->dispatch(new UpdateUserHandle($user2));
            }
            $user1->handle = $new_nick;
            $user1->save();
        }

        $this->seeInDatabase('users', ['twitter_id' => '78598098', 'handle' => 'rolfboom']);
        $this->seeInDatabase('users', ['twitter_id' => '14247082', 'handle' => 'maxfriedrich']);
        $this->seeInDatabase('users', ['twitter_id' => '183628109', 'handle' => 'FlorianLetsch']);
    }
}
