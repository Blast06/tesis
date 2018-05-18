<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AdminCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un usuario administrador';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       User::create([
            'name' => 'Admin',
            'email' => 'admin@system.com',
            'password' => $this->secret('What is the password?'),
            'role' => User::ROLE_ADMIN,
        ]);

        $this->info('Usuario admin creado correctamente!');
    }
}
