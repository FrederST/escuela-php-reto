<?php

namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckCurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_cant_execute_check_command()
    {
        $this->artisan('check:currency')->assertExitCode(0);
    }
}
