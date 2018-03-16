<?php

namespace App\Http\Services\book;


use App\Http\Models\Book;
use App\Http\Models\BookSaleChangeLog;
use App\Http\Models\BookStockLog;
use App\Http\Models\order\PayOrder;
use App\Http\Models\order\PayOrderItem;
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

    public static function confirmOrderItem($order_item_id)
    {
        $order_item_info = PayOrderItem::where('id', $order_item_id)
                ->where('status', 1)
                ->first();
        if (!$order_item_info) {
            return false;
        }

        $order_info = PayOrder::where('id', $order_item_info->pay_order_id)
                ->first();
        if(!$order_info){
            return false;
        }

        $model_book_sale_change_log = new BookSaleChangeLog();
        $model_book_sale_change_log->book_id = $order_item_info->target_id;
        $model_book_sale_change_log->quantity = $order_item_info->quantity;
        $model_book_sale_change_log->price = $order_item_info->price;
        $model_book_sale_change_log->member_id = $order_item_info->member_id;
        $model_book_sale_change_log->created_at = date("Y-m-d H:i:s");

        return $model_book_sale_change_log->save();
    }
}