<?php

namespace App\Http\Models;


use App\Http\Models\order\PayOrder;

class Member extends BaseModel
{
    public function address()
    {
        return $this->hasOne(MemberAddress::class, 'member_id', 'id');
    }

    public function pay_orders()
    {
        return $this->hasMany(PayOrder::class, 'member_id', 'id');
    }
}
