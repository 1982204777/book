<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\stat\StatDailySite;

class HomeController extends BaseController
{
    public function index()
    {
        $data = [
            'finance' => [
                'today' => 0,
                'month' => 0
            ],
            'order' => [
                'today' => 0,
                'month' => 0
            ],
            'member' => [
                'today' => 0,
                'month' => 0,
                'total' => 0
            ],
            'shared' => [
                'today' => 0,
                'month' => 0
            ]
        ];

        $date_from = date('Y-m-d', strtotime('-30 days'));
        $date_now = date('Y-m-d');
        $stat_daily_site_info = StatDailySite::whereBetween('date', [$date_from, $date_now])->orderBy('id', 'desc')->get()->toArray();
        foreach ($stat_daily_site_info as $item) {
            $data['finance']['month'] += intval($item['total_pay_money']);
            $data['order']['month'] += $item['total_order_count'];
            $data['member']['month'] += $item['total_new_member_count'];
            $data['shared']['month'] += $item['total_shared_count'];
            $data['member']['total'] = $item['total_member_count'];
            if ($date_now == $item['date']) {
                $data['finance']['today'] = $item['total_pay_money'];
                $data['order']['today'] = $item['total_order_count'];
                $data['member']['today'] = $item['total_new_member_count'];
                $data['shared']['today'] = $item['total_shared_count'];
            }
        }

        return view('admin/index', compact('data'));
    }
}
