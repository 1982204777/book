<?php

namespace App\Http\Models;


use App\Http\Models\order\PayOrderItem;

class Book extends BaseModel
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'category_id', 'id');
    }

    public function stock_change_logs()
    {
        return $this->hasMany(BookStockLog::class, 'book_id', 'id');
    }

    public function payOrderItems()
    {
        return $this->hasMany(PayOrderItem::class, 'target_id', 'id');
    }
}
