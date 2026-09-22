<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Inertia's SsrState is a scoped instance — without a per-request flush,
     * repeated HTTP calls inside one test process reuse the first SSR render.
     * Flushing scoped instances before each call mirrors real php-fpm behavior.
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $this->app->forgetScopedInstances();

        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }
}
