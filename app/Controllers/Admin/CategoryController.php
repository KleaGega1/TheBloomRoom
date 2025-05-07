<?php
namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\{CSRFToken, Request, RequestValidation, Session, View};
use App\Middlewares\Role;
use App\Models\Category;
use Exception;

// Category Controller responsible for managing categories
class CategoryController extends Controller
{
    protected int $count;

    public function __construct()
    {
        Role::handle();

        $this->count = Category::all()->count();
    }

    public function index(): View
    {
        ['items' => $categories, 'links' => $links] = paginateData(Category::class, 8);

        return View::render()->view('admin.categories.index', compact('categories','links'));
    }

    public function store(): void
    {
        $request = Request::get('post');

        CSRFToken::verify($request->csrf, false);

        RequestValidation::validate($request, [
            'name' => ['unique' => 'categories', 'required' => true]
        ]);

        Category::query()->create(['name' => $request->name]);

        Session::add('message', 'Category created successfully');
        redirect('/admin/categories');
    }

    public function edit($id): View
    {
        $category = Category::query()->where('id', $id)->first();

        return View::render()->view('admin.categories.edit', compact('category'));
    }

    public function update($id): void
    {
        $request = Request::get('post');
        CSRFToken::verify($request->csrf);

        RequestValidation::validate($request, [
            'name' => ['required' => true],
        ]);

        $category = Category::query()->where('id', $id)->first();

        $category->update(['name' => $request->name,]);

        Session::add('message', 'Category updated successfully');
        redirect('/admin/categories');
    }

    public function delete( $id): void
    {
        Category::query()->where('id', $id)->delete();

        Session::add('message', 'Category deleted successfully');

        redirect('/admin/categories');
    }
}