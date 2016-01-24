<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    public function setUp(){
        parent::setUp();

        $this->prepareForTests();
    }
    
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function prepareForTests(){
        Config::set('database.default', 'sqlite');
        Artisan::call('migrate');
    }
}
