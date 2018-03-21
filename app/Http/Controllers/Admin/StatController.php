<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\stat\StatDailyBook;
use App\Http\Models\stat\StatDailyMember;
use App\Http\Models\stat\StatDailySite;
use Illuminate\Http\Request;

class StatController extends BaseController
{
    public function index(Request $request)
    {
        $date_from = $request->get('date_from', date('Y-m-d', strtotime('-30 days')));
        $date_to = $request->get('date_to', date('Y-m-d'));
        $current_page = intval($request->get('p', 1));
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $query = StatDailySite::query();
        $query->whereBetween('date', [$date_from, $date_to]);
        $page = config('common.page');
        $page['total_count'] = $query->count();
        $page['current_page'] = $current_page;
        $list = $query->orderBy('id', 'desc')
                    ->offset(($current_page - 1) * $page['page_size'])
                    ->take($page['page_size'])
                    ->get()
                    ->toArray();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $search_conditions = [
            'date_from' => $date_from,
            'date_to' => $date_to
        ];

        return view('admin/stat/index', compact('list', 'page', 'search_conditions'));
    }

    public function member(Request $request)
    {
        $date_from = $request->get('date_from', date('Y-m-d', strtotime('-30 days')));
        $date_to = $request->get('date_to', date('Y-m-d'));
        $current_page = intval($request->get('p', 1));
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $query = StatDailyMember::query();
        $query->whereBetween('date', [$date_from, $date_to]);
        $page = config('common.page');
        $page['current_page'] = $current_page;
        $page['total_count'] = $query->count();
        $list = $query->orderBy('id', 'desc')
                ->offset(($current_page - 1) * $page['page_size'])
                ->take($page['page_size'])
                ->with('member')
                ->get()
                ->toArray();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $search_conditions = [
            'date_from' => $date_from,
            'date_to' => $date_to
        ];

        return view('admin/stat/member', compact('list', 'search_conditions', 'page'));
    }

    public function product(Request $request)
    {
        $date_from = $request->get('date_from', date('Y-m-d', strtotime('-30 days')));
        $date_to = $request->get('date_to', date('Y-m-d'));
        $current_page = intval($request->get('p', 1));
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $query = StatDailyBook::query();
        $query->whereBetween('date', [$date_from, $date_to]);
        $page = config('common.page');
        $page['current_page'] = $current_page;
        $page['total_count'] = $query->count();
        $list = $query->orderBy('id', 'desc')
                ->offset(($page['current_page'] - 1) * $page['page_size'])
                ->take($page['page_size'])
                ->with('book')
                ->get()
                ->toArray();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $search_conditions = [
            'date_from' => $date_from,
            'date_to' => $date_to
        ];

        return view('admin/stat/product', compact('list', 'page', 'search_conditions'));
    }

    public function share(Request $request)
    {
        $date_from = $request->get('date_from', date('Y-m-d', strtotime('-30 days')));
        $date_to = $request->get('date_to', date('Y-m-d'));
        $current_page = intval($request->get('p', 1));
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $query = StatDailySite::query();
        $query->whereBetween('date', [$date_from, $date_to]);
        $page = config('common.page');
        $page['current_page'] = $current_page;
        $page['total_count'] = $query->count();
        $list = $query->orderBy('date', 'asc')
                ->offset(($page['current_page'] - 1) * $page['page_size'])
                ->take($page['page_size'])
                ->get()
                ->toArray();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $search_conditions = [
            'date_from' => $date_from,
            'date_to' => $date_to
        ];

        return view('admin/stat/share', compact('list', 'page', 'search_conditions'));
    }
}
