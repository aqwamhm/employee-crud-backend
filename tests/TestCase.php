<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM employees");
        DB::delete("DELETE FROM positions");
        DB::delete("DELETE FROM users");
    }
}
