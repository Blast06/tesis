<?php

namespace Tests;

trait TestHelpers
{
    protected function assertDatabaseEmpty($table, $connection = null)
    {
        $total = $this->getConnection($connection)->table($table)->count();
        $this->assertSame(0, $total, sprintf(
           "Failed asserting the table [%s] is empty. %s %s found", $table, $total, str_plural('row', $total)
        ));
    }

    protected function create($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->create($attributes);
    }

    protected function createAdmin()
    {
        return factory(\App\User::class)->create([
            'email' => config('tesis.administrators')[0] ?? 'admin@system.com'
        ]);
    }

    protected function withData($data = [])
    {
        return array_filter(array_merge($this->defaultData,$data));
    }
}