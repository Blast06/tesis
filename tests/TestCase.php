<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser()
    {
        return factory(User::class)->create();
    }

    public function createAdmin()
    {
        return factory(User::class)->create([
            'role' => User::ROLE_ADMIN
        ]);
    }
}
