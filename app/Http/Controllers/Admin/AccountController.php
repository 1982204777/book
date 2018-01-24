<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\User;
use Illuminate\Http\Request;

class AccountController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->input();
        $query = User::query();
        $status = array_get($input, 'status', -1);
        $keywords = array_get($input, 'keywords', '');
        $current_page = intval(array_get($input, 'p', 1));
        if ($status > -1) {
            $query->where('status', $status);
        }
        if ($keywords) {
            $query->where('nickname', 'like', '%' . $keywords . '%')
                ->orWhere('mobile', 'like', '%' . $keywords . '%');
        }
        $page = config('common.page');
        //分页
        $page['total_count'] = $query->count();
        $accounts = $query->orderBy('uid', 'desc')
            ->offset(($current_page - 1) * $page['page_size'])
            ->limit($page['page_size'])
            ->get();
        $status_mapping = config('common.status_mapping');
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $page['current_page'] = $current_page;

        return view('admin/account/index', compact('accounts', 'status_mapping', 'page', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/account/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
