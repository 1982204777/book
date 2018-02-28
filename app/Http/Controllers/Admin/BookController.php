<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Book;
use App\Http\Models\BookCategory;
use App\Http\Models\BookImage;
use App\Http\Services\book\BookService;
use App\Http\Services\ConstantMapService;
use Illuminate\Http\Request;

class BookController extends BaseController
{
    public function index(Request $request)
    {
        $status = $request->get('status', -1);
        $cat_id = $request->get('cat_id', 0);
        $keywords = $request->get('mix_kw', '');
        $current_page = $request->get('p', 1);

        if ($current_page <= 0) {
            $current_page = 1;
        }
        $query = Book::query();

        if ($status != ConstantMapService::$default_status) {
            $query->where('status', $status);
        }
        if ($cat_id) {
            $query->where('category_id', $cat_id);
        }
        if ($keywords) {
            $query->where('name', 'like', '%' . $keywords . '%')
                ->orWhere('tags', 'like', '%' . $keywords . '%');
        }

        $page = config('common.page');
        $page['total_count'] = $query->count();

        $query->with('category');
        $books = $query->orderBy('created_at')
            ->offset(($current_page - 1) * $page['page_size'])
            ->limit($page['page_size'])
            ->get();
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);
        $page['current_page'] = $current_page;

        $status_mapping = ConstantMapService::$status_mapping;
        $categories = BookCategory::where('status', 1)
                ->orderBy('weight', 'desc')
                ->get();
        return view('admin/book/index', compact('status_mapping', 'categories', 'status', 'cat_id', 'books', 'page'));
    }

    public function create()
    {
        $categories = BookCategory::where('status', 1)
                ->get();

        return view('admin/book/add', compact('categories'));
    }

    public function store(Request $request)
    {
        $input = $request->post();
        $cat_id = array_get($input, 'cat_id', '');
        $name = array_get($input, 'name', '');
        $price = array_get($input, 'price', '');
        $main_img = array_get($input, 'main_img', '');
        $summary = array_get($input, 'summary', '');
        $stock = intval(array_get($input, 'stock', ''));
        $tags = array_get($input, 'tags', '');

        if (!$cat_id || !intval($cat_id)) {
            return ajaxReturn('请选择图书分类~~~', -1);
        }
        if (!$name) {
            return ajaxReturn('请输入符合规范的图书名称~~~', -1);
        }
        if (floatval($price) <= 0 || !$price || !is_numeric($price)) {
            return ajaxReturn('请输入符合规范的图书售卖价格~~~', -1);
        }
        if (!$main_img) {
            return ajaxReturn('请上传封面图~~~', -1);
        }
        if (!$summary || strlen($summary) < 10) {
            return ajaxReturn('请输入图书描述，并不能少于10个字符~~~', -1);
        }
        if ($stock <= 0 || !$stock) {
            return  ajaxReturn('请输入符合规范的库存量~~~', -1);
        }
        if (!$tags) {
            return ajaxReturn('请输入图书标签，便于搜索~~~', -1);
        }

        $price = number_format($price, 2, '.', '');

        $book = new Book();
        if (!$book::checkUnique($name, 'name')) {
            return ajaxReturn('该图书名称已存在~~~', -1);
        }

        $book->status = 1;
        $book->category_id = $cat_id;
        $book->name = $name;
        $book->price = $price;
        $book->main_img = $main_img;
        $book->summary = $summary;
        $book->stock = $stock;
        $book->tags = $tags;

        $book_img = new BookImage();
        $book_img->file_key = $main_img;
        $book_img->created_at = date('Y-m-d H:i:s');

        if ($book->save() && $book_img->save()) {
            BookService::setStockChangeLog($book->id, $book->stock, '添加图书');
        }

        return ajaxReturn('添加成功~~~');
    }

    public function show($id)
    {
        $book = Book::query()
            ->where('id', $id)
            ->with('category')
            ->with('stock_change_logs')
            ->first();

        return view('admin/book/info', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::find($id);
        $categories = BookCategory::where('status', 1)
            ->get();

        return view('admin/book/edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $input = $request->post();
        $cat_id = array_get($input, 'cat_id', '');
        $name = array_get($input, 'name', '');
        $price = array_get($input, 'price', '');
        $main_img = array_get($input, 'main_img', '');
        $summary = array_get($input, 'summary', '');
        $stock = intval(array_get($input, 'stock', ''));
        $tags = array_get($input, 'tags', '');

        if (!$cat_id || !intval($cat_id)) {
            return ajaxReturn('请选择图书分类~~~', -1);
        }
        if (!$name) {
            return ajaxReturn('请输入符合规范的图书名称~~~', -1);
        }
        if (floatval($price) <= 0 || !$price || !is_numeric($price)) {
            return ajaxReturn('请输入符合规范的图书售卖价格~~~', -1);
        }
        if (!$main_img) {
            return ajaxReturn('请上传封面图~~~', -1);
        }
        if (!$summary || strlen($summary) < 10) {
            return ajaxReturn('请输入图书描述，并不能少于10个字符~~~', -1);
        }
        if ($stock <= 0 || !$stock) {
            return  ajaxReturn('请输入符合规范的库存量~~~', -1);
        }
        if (!$tags) {
            return ajaxReturn('请输入图书标签，便于搜索~~~', -1);
        }

        $price = number_format($price, 2, '.', '');

        $book = Book::find($id);
        if (!$book) {
            return ajaxReturn('该图书不存在~~~', -1);
        }
        if (!$book::checkUnique($name, 'name', $book->name)) {
            return ajaxReturn('该图书名称已存在~~~', -1);
        }
        if ($main_img != $book->main_img) {
            $book_img = new BookImage();
            $book_img->file_key = $main_img;
            $book_img->created_at = date('Y-m-d H:i:s');
            $book_img->save();
        }

        $before_stock = $book->stock;
        $book->category_id = $cat_id;
        $book->name = $name;
        $book->price = $price;
        $book->main_img = $main_img;
        $book->summary = $summary;
        $book->stock = $stock;
        $book->tags = $tags;
        if ($book->save()) {
            BookService::setStockChangeLog($book->id, $book->stock - $before_stock, '修改图书');
        }

        return ajaxReturn('编辑成功~~~');
    }

    public function ops(Request $request)
    {
        $act = $request->post('act', '');
        $id = $request->post('id', '');

        if (!$act || !in_array($act, ['remove', 'recover'])) {
            return ajaxReturn('操作有误，请重试~~~', -1);
        }
        if (!$id) {
            return ajaxReturn('请选择要操作的图书~~~', -1);
        }
        $book = Book::find($id);
        if (!$book) {
            return ajaxReturn('您指定的图书不存在~~~');
        }

        switch ($act) {
            case 'remove':
                $book->status = 0;
                $act = '删除成功~~~';
                break;
            case 'recover':
                $book->status = 1;
                $act = '恢复成功~~~';
                break;
        }
        $book->save();

        return ajaxReturn($act);
    }

    public function images(Request $request)
    {
        $current_page = $request->get('p', 0);
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $query = BookImage::query();
        $page = config('common.page');
        $page['total_count'] = $query->count();

        $images = $query->orderBy('created_at', 'desc')
                ->offset(($current_page - 1) * $page['page_size'])
                ->limit($page['page_size'])
                ->get();
        $page['current_page'] = $current_page;
        $page['page_count'] = ceil($page['total_count'] / $page['page_size']);

        return view('admin/book/image', compact('images', 'page'));
    }

}
