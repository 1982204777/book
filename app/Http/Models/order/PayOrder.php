<?php

namespace App\Http\Models\order;

use App\Http\Models\BaseModel;
use App\Http\Models\Member;

class PayOrder extends BaseModel
{
    public $table = 'pay_order';

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(PayOrderItem::class, 'pay_order_id', 'id');
    }
}
