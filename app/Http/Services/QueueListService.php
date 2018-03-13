<?php

namespace App\Http\Services;


use App\Http\Models\QueueList;

class QueueListService
{
    public static function addQueue($queue_name, $data = []){
        $model = new QueueList();
        $model->queue_name = $queue_name;
        $model->data = json_encode($data);
        $model->status = -1;

        return $model->save();
    }
}