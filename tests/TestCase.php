<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Views reference compiled assets via @vite; the test suite doesn't
        // build them (a separate CI job does), so stub Vite out to avoid a
        // "manifest not found" error when rendering pages.
        $this->withoutVite();
    }
}
