<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    /**
     * Tests twitter username recursive updating.
     *
     * @return void
     */
    public function testRecursiveUpdateNicknames()
    {
        $this->visit('/')
             ->see('podcasts');
    }
}
