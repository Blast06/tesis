<?php

namespace App\Console\Commands;

use App\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CancelOrderWhenFourDaysHavePassed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel Order when 4 days have passed';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Order::where([
            ['status', Order::STATUS_CURRENT],
            ['status', Order::STATUS_WAIT]
        ])->get() as $order) {
            if((New Carbon($order->created_at))->diffInDays(Carbon::now()) >= 4){
                $this->info("Orden [{$order->id}] cancelada por inactividad");
                $order->delete();
            }
        }
    }
}
