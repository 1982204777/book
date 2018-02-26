<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\BookCategory;
use App\Http\Services\ConstantMapService;
use Illuminate\Http\Request;

class BookCategoryController extends BaseController
{
    public function index(Request $request)
    {
        $status = $request->get('status', ConstantMapService::$default_status);
        $query = BookCategory::query();
        if ($status > ConstantMapService::$default_status) {
            $query->where('status', $status);
        }
        $query->orderBy('weight', 'desc')
            ->orderBy('id', 'desc');
        $categories = $query->get();
        $status_mapping = ConstantMapService::$status_mapping;

        return view('admin/bookCategory/index', compact('categories', 'status_mapping'));
    }

    public function create()
    {
        return view('admin/bookCategory/add');
    }

    public function store(Request $request)
    {
        $name = $request->post('name', '');
        $weight = intval($request->post('weight', ''));
        if (!$name) {
            return ajaxReturn('请输入符合规范的分类名称~~~', -1);
        }
        if (!$weight) {
            return ajaxReturn('请输入符合规范的权重~~~', -1);
        }
        $book_category = new BookCategory();
        if (!$book_category::checkUnique($name, 'name')) {
            return ajaxReturn('分类名称已存在~~请重新输入', -2);
        }
        $book_category->name = $name;
        $book_category->weight = $weight;
        $book_category->save();

        return ajaxReturn('添加成功~~~');
    }

    public function edit($id)
    {
        $category = BookCategory::find($id);

        return view('admin/bookCategory/edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $name = $request->post('name', '');
        $weight = intval($request->post('weight', ''));
        if (!$name) {
            return ajaxReturn('请输入符合规范的分类名称~~~', -1);
        }
        if (!$weight) {
            return ajaxReturn('请输入符合规范的权重~~~', -1);
        }
        $category = BookCategory::find($id);
        if (!$category) {
            return ajaxReturn('该分类不存在~~~', -1);
        }
        if (!$category::checkUnique($name, 'name', $category->name)) {
            return ajaxReturn('分类名称已存在~~请重新输入', -2);
        }
        $category->name = $name;
        $category->weight = $weight;
        $category->save();

        return ajaxReturn('编辑成功~~~');
    }

    public function ops(Request $request)
    {
        $act = $request->post('act', '');
        $id = $request->post('id', '');
        if (!$id) {
            return ajaxReturn('请选择要操作的分类~~~', -1);
        }
        if (!in_array($act, ['recover', 'remove'])) {
            return ajaxReturn('操作有误，请重试~~~');
        }
        $category = BookCategory::find($id);
        if (!$category) {
            return ajaxReturn('您指定的分类不存在~~~');
        }
        switch ($act) {
            case 'recover':
                $category->status = 1;
                $act = '恢复成功~~~';
                break;
            case 'remove':
                $category->status = 0;
                $act = '删除成功~~~';
                break;
        }
        $category->save();

        return ajaxReturn($act);
    }
}
