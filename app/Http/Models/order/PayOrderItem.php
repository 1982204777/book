<?php

namespace App\Http\Models\order;

use App\Http\Models\BaseModel;
use App\Http\Models\Book;

class PayOrderItem extends BaseModel
{
    protected $table = 'pay_order_item';

    public function book()
    {
        return $this->belongsTo(Book::class, 'target_id', 'id');
    }
}
