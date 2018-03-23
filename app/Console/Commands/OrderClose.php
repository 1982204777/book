<?php

namespace App\Console\Commands;

use App\Http\Models\order\PayOrder;
use App\Http\Services\pay\PayOrderService;
use Illuminate\Console\Command;

class OrderClose extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:orderClose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'close the expired order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
         * 库存处理
         * 释放30分钟前的订单
         * php artisan schedule:run
         * */
        $thirty_minutes_before = date('Y-m-d H:i:s', time() - 30 * 60);
        $order_thirty_minutes_before = PayOrder::where('target_type', 1)
                ->where('status', -8)
                ->where('created_at', '<=', $thirty_minutes_before)
                ->get()
                ->toArray();
        foreach ($order_thirty_minutes_before as $item) {
            PayOrderService::closeOrder($item['id']);
        }
    }
}
