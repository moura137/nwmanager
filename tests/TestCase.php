<?php

namespace Tests;

use Mockery as m;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
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

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
    
    /**
     * Assert Trait Exists
     * 
     * @param  string $expected
     * @param  Object $object
     * @param  string $message
     * 
     * @return void
     * @throws
     */
    public function assertTraitExists($expected, $object, $message = '')
    {
        $this->assertArrayHasKey(
            $expected,
            class_uses($object),
            !empty($message) ? $message :
            sprintf('Failed asserting not exists Trait instance of interface "%s".', $expected));
    }
}
