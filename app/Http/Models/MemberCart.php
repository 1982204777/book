<?php

namespace App\Http\Models;


class MemberCart extends BaseModel
{
    public $table = 'member_cart';

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id')
            ->select('id', 'name', 'price', 'stock', 'main_img');
    }
}
