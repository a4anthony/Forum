<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);
        $this->actingAs($user);

        return $this;
    }

    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(
            ExceptionHandler::class,
            new class extends Handler
            {
                public function __construct()
                {
                }
                public function report(\Throwable $exception)
                {
                }
                public function render($request, \Throwable $exception)
                {
                    throw $exception;
                }
            }
        );
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }
}
