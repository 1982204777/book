<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Book;
use App\Http\Models\City;
use App\Http\Models\order\PayOrder;
use App\Http\Models\order\PayOrderItem;
use App\Http\Services\ConstantMapService;
use Illuminate\Http\Request;

class FinanceController extends BaseController
{
    public function index(Request $request)
    {
        $status = $request->get('status', -1);
        $current_page = $request->get('p', 1);
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $pay_status_mapping = ConstantMapService::$pay_status_mapping;
        $page = config('common.page');
        $query = PayOrder::query();
        if ($status > ConstantMapService::$default_status) {
            $query->where('status', $status);
        }

        $page['current_page'] = $current_page;
        $page['total_count'] = $query->count();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);

        $list = $query->orderBy('created_at', 'desc')
                ->offset(($current_page - 1) * $page['page_size'])
                ->limit($page['page_size'])
                ->get()
                ->toArray();
        
        $pay_order_list = [];
        if ($list) {
            $order_item_list = PayOrderItem::whereIn('pay_order_id', array_column($list, 'id'))
                    ->where('status', 1)
                    ->get()
                    ->toArray();
            $book_mapping = Book::whereIn('id', array_column($order_item_list, 'target_id'))
                    ->select('id', 'name')
                    ->where('status', 1)
                    ->get()
                    ->keyBy('id')
                    ->toArray();
            $pay_order_mapping = [];
            foreach ($order_item_list as $item) {
                if (!isset($pay_order_mapping[$item['pay_order_id']])) {
                    $pay_order_mapping[$item['pay_order_id']] = [];
                }
                $pay_order_mapping[$item['pay_order_id']][] = [
                    'name' => $book_mapping[$item['target_id']]['name'],
                    'quantity' => $item['quantity']
                ];
            }
            foreach ($list as $item) {
                $pay_order_list[] = [
                    'id' => $item['id'],
                    'order_sn' => $item['order_sn'],
                    'items' => $pay_order_mapping[$item['id']],
                    'pay_price' => $item['pay_price'],
                    'pay_time' => $item['pay_time'],
                    'status' => $item['status'],
                    'created_at' => $item['created_at']
                ];
            }
        }

        $search_conditions = [
            'status' => $status,
            'current_page' => $current_page
        ];

        return view('admin/finance/index', compact('pay_order_list', 'page', 'search_conditions', 'pay_status_mapping'));
    }

    public function show($id)
    {
        $pay_order = PayOrder::where('id', $id)
                ->with(['member' => function($query) {
                    return $query->with('address');
                }])
                ->with(['items' => function($query) {
                    return $query->with('book');
                }])
                ->first()
                ->toArray();

        $city_info = City::where('id', $pay_order['member']['address']['area_id'])
                    ->select('province', 'city', 'area')
                    ->first()
                    ->toArray();

        $pay_status_mapping = ConstantMapService::$pay_status_mapping;

        return view('admin/finance/info', compact('pay_order', 'pay_status_mapping', 'city_info'));
    }
}
