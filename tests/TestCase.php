<?php

namespace CLNQCDRS\Blueprint\Macro\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/factories');
        $this->loadLaravelMigrations(['--database' => 'testbench']);
        // $this->artisan('migrate', ['--database' => 'testbench']);
    }

    protected function getPackageProviders($app)
    {
        return [
            \CLNQCDRS\Blueprint\Macro\BlueprintMacroServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
