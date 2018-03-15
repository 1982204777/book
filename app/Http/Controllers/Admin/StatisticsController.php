<?php

namespace App\Http\Controllers\Admin;

class StatisticsController extends BaseController
{
    public function index()
    {
        return view('admin/statistics/index');
    }
}
