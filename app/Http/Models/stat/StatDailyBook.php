<?php

namespace App\Http\Models\stat;

use App\Http\Models\BaseModel;
use App\Http\Models\Book;

class StatDailyBook extends BaseModel
{
    public $table = 'stat_daily_book';

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

}
