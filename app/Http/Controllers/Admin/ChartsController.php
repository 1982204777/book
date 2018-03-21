<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\stat\StatDailySite;

class ChartsController extends BaseController
{
    public function dashboard()
    {
        $date_from = request()->get('date_from', date('Y-m-d', strtotime('-30 days')));
        $date_to = request()->get('date_to', date('Y-m-d'));
        $list = StatDailySite::whereDate('date', '>=', $date_from)
                    ->whereDate('date', '<=', $date_to)
                    ->orderBy('id', 'asc')
                    ->get()
                    ->toArray();
        $data = [
            'categories' => [],
            'series' => [
                [
                    'name' => '会员总数',
                    'data' => []
                ],
                [
                    'name' => '订单总数',
                    'data' => []
                ]
            ]
        ];

        foreach ($list as $item) {
            $data['categories'][] = $item['date'];
            $data['series'][0]['data'][] = floatVal($item['total_member_count']);
            $data['series'][1]['data'][] = floatVal($item['total_order_count']);
        }

        return [
            'code' => 0,
            'data' => $data
        ];
    }

    public function finance()
    {
        $date_from = request()->get('date_from', date('Y-m-d', strtotime('-30 days')));
        $date_to = request()->get('date_to', date('Y-m-d'));
        $list = StatDailySite::whereDate('date', '>=', $date_from)
            ->whereDate('date', '<=', $date_to)
            ->get()
            ->toArray();
        $data = [
            'categories' => [],
            'series' => [
                [
                    'name' => '日营收报表',
                    'data' => []
                ]
            ]
        ];
        foreach ($list as $item) {
            $data['categories'][] = $item['date'];
            $data['series'][0]['data'][] = floatVal($item['total_pay_money']);
        }

        return [
            'code' => 0,
            'data' => $data
        ];
    }

    public function share()
    {
        $date_from = request()->get("date_from", date("Y-m-d",strtotime("-30 days") ) );
        $date_to = request()->get("date_to", date("Y-m-d" ) );
        $query = StatDailySite::query();
        $query->whereBetween('date', [$date_from, $date_to]);
        $list = $query->orderBy('id', 'desc')->get()->toArray();
        $data = [
            'categories' => [],
            'series' => [
                [
                    'name' => '日分享',
                    'data' => []
                ]
            ]
        ];


        foreach ($list as $_item) {
                $data['categories'][] = $_item['date'];
                $data['series'][0]['data'][] = floatval($_item['total_shared_count']);
            }

        return [
            'code' => 0,
            'data' => $data
        ];
    }
}
