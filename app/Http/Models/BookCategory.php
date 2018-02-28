<?php

namespace App\Http\Models;


class BookCategory extends BaseModel
{
    protected $guarded = [];

    public function books()
    {
        return $this->hasMany(Book::class, 'category_id', 'id');
    }
}
