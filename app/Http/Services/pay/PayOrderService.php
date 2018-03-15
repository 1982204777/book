<?php

namespace App\Http\Services\pay;


use App\Http\Models\order\PayOrder;
use App\Http\Models\order\PayOrderItem;
use App\Http\Services\BaseService;
use App\Http\Services\book\BookService;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class PayOrderService extends BaseService
{
    public static function placePayOrder($member_id, $items = [], $params = [])
    {
        $total_price = 0;
        $continue_count = 0;
        foreach ($items as $item) {
            if ($item['price'] < 0) {
                $continue_count += 1;
                continue;
            }
            $total_price += $item['price'] * $item['quantity'];
        }
        if ($continue_count >= count($items)) {
            return self::err('商品items不存在~~~', -1);
        }
        $discount = isset($params['discount']) ? $params['discount'] : "";
        $total_price = sprintf('%.2f', $total_price);
        $discount = sprintf('%.2f', $discount);
        $pay_price = sprintf('%.2f', $total_price - $discount);
        DB::beginTransaction();
        try {
            //1、并发控制，select for update 悲观锁 mysql自带 并发控制用这种
            //stock = 5
            //2、update book set stock = 2 where id = 1 and stock = 5; 乐观锁 高并发用这种
            $tmp_book_ids = array_column($items, 'target_id');
            $tmp_book_list = DB::table('books')->select('id', 'stock')
                ->whereIn('id', $tmp_book_ids)
                ->lockForUpdate()
                ->get()
                ->toArray();
            $tmp_book_unit_mapping = [];

            foreach ($tmp_book_list as $book) {
                $tmp_book_unit_mapping[$book->id] = $book->stock;
            }

            $pay_order = new PayOrder();

            $pay_order->order_sn = self::generate_order_sn();
            $pay_order->member_id = $member_id;
            $pay_order->target_type = isset($params['target_type']) ? $params['target_type'] : '';
            $pay_order->pay_type = isset($params['pay_type']) ? $params['pay_type'] : '';
            $pay_order->pay_source = isset($params['pay_source']) ? $params['pay_source'] : '';
            $pay_order->total_price = $total_price;
            $pay_order->discount = $discount;
            $pay_order->pay_price = $pay_price;
            $pay_order->note = isset($params['note']) ? $params['note'] : '';
            $pay_order->status = isset($params['status']) ? $params['status'] : -8;
            $pay_order->express_status = isset($params['express_status']) ? $params['express_status'] : -8;
            $pay_order->express_address_id = isset($params['express_address_id']) ? $params['express_address_id'] : '';
            if (!$pay_order->save()) {
                throw new Exception('创建订单失败~~~');
            }

            foreach ($items as $item) {
                $tmp_left_stock = $tmp_book_unit_mapping[$item['target_id']];
                if ($tmp_left_stock < $item['quantity']) {
                    $tmp_book_name = isset($item['name']) ? '《' . $item['name'] . '》' : '';
                    throw new Exception("{$tmp_book_name}库存不足，当前剩余库存：{$tmp_left_stock}，你购买的数量：{$item['quantity']}");
                }
                if (!DB::table('books')->where('id', $item['target_id'])->update(['stock' => $tmp_book_unit_mapping[$item['target_id']] - $item['quantity']])) {
                    throw new Exception('下单失败，请重新下单~~~');
                }
                $pay_order_item = new PayOrderItem();
                $pay_order_item->pay_order_id = $pay_order->id;
                $pay_order_item->member_id = $member_id;
                $pay_order_item->quantity = $item['quantity'];
                $pay_order_item->price = $item['price'] * $item['quantity'];
                $pay_order_item->target_type = $item['target_type'];
                $pay_order_item->target_id = $item['target_id'];
                $pay_order_item->status = isset($item['status']) ? $item['status'] : 1;
                $pay_order_item->note = isset($item['note']) ? $item['note'] : '';
                if (!$pay_order_item->save()) {
                    throw new Exception('创建订单失败~~~');
                }
                BookService::setStockChangeLog($item['target_id'], -$item['quantity'], '在线购买');
            }
            DB::commit();

            return [
                'id' => $pay_order->id,
                'order_sn' => $pay_order->order_sn,
                'pay_money' => $pay_order->pay_price,
            ];
        } catch (Exception $exception) {
            DB::rollback();
            return self::err($exception->getMessage(), -1);
        }
    }

    public static function generate_order_sn()
    {
        do {
            $order_sn = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        } while (PayOrder::where('order_sn', $order_sn)->count());

        return $order_sn;
    }
}