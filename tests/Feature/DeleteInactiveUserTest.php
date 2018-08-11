<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteInactiveUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function inactive_user_its_deletes_when_7_days_pass()
    {
        $this->create(User::class, [
            'created_at' => Carbon::now()->addDay(7),
            'verified_at' => null
        ]);

        $this->create(User::class, [
            'created_at' => Carbon::now(),
            'verified_at' => null
        ]);

        $this->create(User::class);

        $this->assertCount(3, collect(User::get()));

        Artisan::call('delete:users');

        $this->assertCount(2, collect(User::get()));
    }
}
