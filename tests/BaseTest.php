<?php

namespace MallardDuck\ExtendedValidator\Tests;

use Illuminate\Validation\Factory;
use MallardDuck\ExtendedValidator\ExtendedValidatorServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            ExtendedValidatorServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }

    protected function getValidator(): Factory
    {
        return $this->app->get('validator');
    }
}
