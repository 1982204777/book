<?php

namespace App\Http\Models\stat;

use App\Http\Models\BaseModel;
use App\Http\Models\Member;

class StatDailyMember extends BaseModel
{
    public $table = 'stat_daily_member';

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
