<?php

namespace App\Http\Models;


class MemberFav extends BaseModel
{
    public $table = 'member_fav';

    public $timestamps = false;

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id')
            ->select('id', 'name', 'price', 'stock', 'main_img');
    }
}
