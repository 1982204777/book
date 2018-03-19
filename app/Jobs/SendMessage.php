<?php

namespace App\Jobs;

use App\Http\Models\QueueList;
use App\Http\Services\wechat\TemplateMsg;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $list = QueueList::where('status', -1)
                ->orderBy('id', 'asc')
                ->get();

        if ($list->isEmpty()) {
            return true;
        }
        foreach ($list as $item) {
            switch ($item['queue_name']) {
                case 'pay':
                    $this->handlePay($item->data);
                    break;
            }
            $item->status = 1;
            $item->save();
        }

        return true;
    }

    private function handlePay($item)
    {
        $data = json_decode($item, true);
        if (!isset($data['member_id']) || !isset($data['pay_order_id'])) {
            return false;
        }
        if (!$data['member_id'] || !$data['pay_order_id']) {
            return false;
        }

        TemplateMsg::payNotice($data['pay_order_id']);

        return true;
    }
}
