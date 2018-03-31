<?php

namespace App\Http\Models\order;

use App\Http\Models\BaseModel;
use App\Http\Models\Book;
use App\Http\Models\Member;

class PayOrderItem extends BaseModel
{
    protected $table = 'pay_order_item';

    public function book()
    {
        return $this->belongsTo(Book::class, 'target_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function order()
    {
        return $this->hasOne(PayOrder::class, 'id', 'pay_order_id');
    }
}
