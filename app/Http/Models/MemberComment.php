<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MemberComment extends Model
{
    public $timestamps = false;

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
