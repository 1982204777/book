<?php

namespace App\Http\Services\stat;

use App\Http\Models\BookSaleChangeLog;
use App\Http\Models\Member;
use App\Http\Models\order\PayOrder;
use App\Http\Models\stat\StatDailyBook;
use App\Http\Models\stat\StatDailyMember;
use App\Http\Models\stat\StatDailySite;
use App\Http\Models\WechatShareHistory;
use Illuminate\Support\Facades\DB;

class DailyService
{
    /**
     * 全站日统计
     */
    public static function siteCount($date = 'now')
    {
        $date = date('Y-m-d', strtotime($date));
        $date_now = date('Y-m-d H:i:s');
        $time_start = '00:00:00';
        $time_end = '23:59:59';

        $total_pay_money = PayOrder::whereBetween('created_at', [$time_start, $time_end])->sum('pay_price');
        $total_member_count = Member::where('created_at', '<=', $time_end)->count();
        $total_new_member_count = Member::whereBetween('created_at', [$time_start, $time_end])->count();
        $total_order_count = PayOrder::whereBetween('created_at', [$time_start, $time_end])->where('status', 1)->count();
        $total_share_count = WechatShareHistory::whereBetween('created_at', [$time_start, $time_end])->count();

        $stat_site_info = StatDailySite::where('date', $date)->first();
        if ($stat_site_info) {
            $model_stat_site = $stat_site_info;
        } else {
            $model_stat_site = new StatDailySite();
            $model_stat_site->date = $date;
            $model_stat_site->created_at = $date_now;
        }
        $model_stat_site->total_pay_money = $total_pay_money;
        $model_stat_site->total_member_count = $total_member_count;
        $model_stat_site->total_new_member_count = $total_new_member_count;
        $model_stat_site->total_order_count = $total_order_count;
        $model_stat_site->total_shared_count = $total_share_count;

        //伪造数据
        $model_stat_site->total_pay_money = mt_rand(1000,1010);
        $model_stat_site->total_new_member_count = mt_rand(50,100);
        $model_stat_site->total_member_count = $model_stat_site->total_member_count + $model_stat_site->total_new_member_count;
        $model_stat_site->total_order_count = mt_rand(900,1000);
        $model_stat_site->total_shared_count = mt_rand(1000,2000);

        $model_stat_site->updated_at = $date_now;
        $model_stat_site->save();

    }

    /**
     * 书籍售卖统计
     */
    public static function bookCount($date = 'now')
    {
        $date = date('Y-m-d', strtotime($date));
        $time_start = $date . ' 00:00:00';
        $time_end = $date . ' 23:59:59';

//        伪造数据
        $book_sale_change_log = new BookSaleChangeLog();
        $book_sale_change_log->book_id = 1;
        $book_sale_change_log->quantity = 1;
        $book_sale_change_log->price = sprintf('%.2f', 100);
        $book_sale_change_log->member_id = 15;
        $book_sale_change_log->created_at = date('Y-m-d H:i:s');
        $book_sale_change_log->save();
//        伪造数据end

        $stat_book_list = DB::table('book_sale_change_log')
                ->select(DB::raw('book_id, SUM(quantity) AS total_count, SUM(price) AS total_pay_money'))
                ->whereBetween('created_at', [$time_start, $time_end])
                ->groupBy('book_id')
                ->get()
                ->toArray();
        if (!$stat_book_list) {
            return true;
        }
        foreach ($stat_book_list as $item) {
            $stat_daily_book = StatDailyBook::where('date', $date)
                    ->where('book_id', $item->book_id)
                    ->first();
            if ($stat_daily_book) {
                $stat_daily_book_model = $stat_daily_book;
                $stat_daily_book_model->total_count = $item->total_count;
                $stat_daily_book_model->total_pay_money = $item->total_pay_money;
            } else {
                $stat_daily_book_model = new StatDailyBook();
                $stat_daily_book_model->date = $date;
                $stat_daily_book_model->book_id = $item->book_id;
                $stat_daily_book_model->total_count = $item->total_count;
                $stat_daily_book_model->total_pay_money = $item->total_pay_money;
            }
            //伪造数据
            $stat_daily_book_model->total_count = mt_rand(1000,1010);
            $stat_daily_book_model->total_pay_money = mt_rand(50,100);
            $stat_daily_book_model->save();
        }

    }

    public static function memberCount($date = 'now')
    {
        $date = date('Y-m-d', strtotime($date));
        $time_start = $date . ' 00:00:00';
        $time_end = $date . ' 23:59:59';
        $member_list = Member::all();
        if (!$member_list) {
            return true;
        }

        foreach ($member_list as $item) {
            $stat_daily_member = StatDailyMember::where('date', $date)
                        ->where('member_id', $item->id)
                        ->first();
            if ($stat_daily_member) {
                $stat_daily_member_model = $stat_daily_member;
            } else {
                $stat_daily_member_model = new StatDailyMember();
                $stat_daily_member_model->date = $date;
                $stat_daily_member_model->member_id = $item->id;
            }
            $total_share_count = WechatShareHistory::where('member_id', $item->id)
                    ->whereBetween('created_at', [$time_start, $time_end])
                    ->count();
            $total_pay_money = PayOrder::where('status', 1)
                        ->where('member_id', $item->id)
                        ->whereBetween('created_at', [$time_start, $time_end])
                        ->sum('pay_price');
            $stat_daily_member_model->total_shared_count = $total_share_count;
            $stat_daily_member_model->total_pay_money = $total_pay_money;

            //伪造数据
			$stat_daily_member_model->total_pay_money = mt_rand(1000,1010);
			$stat_daily_member_model->total_shared_count = mt_rand(50,100);
			$stat_daily_member_model->save();
        }

    }
}