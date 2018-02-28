<?php

namespace App\Http\Services\book;


use App\Http\Models\Book;
use App\Http\Models\BookStockLog;
use App\Http\Services\BaseService;

class BookService extends BaseService
{
    public static function setStockChangeLog($book_id = 0, $unit = 0, $note = '')
    {
        if (!$book_id || !$unit) {
            return false;
        }

        $info = Book::find($book_id);
        if (!$info) {
            return false;
        }

        $stock_log_model = new BookStockLog();
        $stock_log_model->book_id = $book_id;
        $stock_log_model->unit = $unit;
        $stock_log_model->note = $note;
        $stock_log_model->total_stock = $info->stock;
        $stock_log_model->created_at = date('Y-m-d H:i:s');
        $stock_log_model->save();

        return $stock_log_model;
    }
}