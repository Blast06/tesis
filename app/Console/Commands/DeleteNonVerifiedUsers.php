<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteNonVerifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete non verified users';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (User::all() as $user) {
            if(! $user->verified_at
                && (New Carbon($user->created_at))->diffInDays(Carbon::now()) >= 7){

                $this->info("Usuario [{$user->name}] eliminado por no verificar su cuenta");
                $user->delete();
            }
        }
    }
}
