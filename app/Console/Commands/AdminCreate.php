<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
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
        tap(User::create([
            'name' => 'Admin',
            'email' => 'admin@system.com',
            'password' => $this->secret('What is the password?'),
            'verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]),function ($user) {
            $this->info("Usuario admin [{$user->email}] creado correctamente!");
        });
    }
}
