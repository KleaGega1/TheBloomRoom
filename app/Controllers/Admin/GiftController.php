<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\{CSRFToken, Request, RequestValidation, Session, View,FileUpload};
use App\Middlewares\Role;
use App\Models\Gift;
use App\Models\Category;
use Exception;

class GiftController extends Controller
{
    protected int $count;

    public function __construct()
    {
        Role::handle();
        $this->count = Gift::all()->count();
    }

    public function index(): View
    {
        ['items' => $gifts, 'links' => $links] = paginateData(Gift::class, 8);

        return View::render()->view('admin.gifts.index', compact('gifts', 'links'));
    }

    public function store(): void
    {
        $request = Request::get('post');

        CSRFToken::verify($request->csrf, false);

        RequestValidation::validate($request, [
            'name' => ['required' => true, 'unique' => 'products'],
            'price' => ['required' => true, 'number' => true, 'min' => 0],
            'quantity' => ['required' => true, 'number' => true, 'min' => 0],
            'category_id' => ['required' => true],
            'description' => ['required' => true],
            'occasion' => ['required' => true],
            'image_path' => ['required' => true, 'image' => true]
        ]);

        $image_path = $this->uploadProductImage();

        if (!$image_path) {
            Session::add('invalids', ['image' => 'The product image is invalid or missing']);
            redirect('/admin/products/create');
        }
        $product = Gift::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'image_path' => $image_path,
            'size' => $request->size ?? null,
            'occasion' => $request->occasion ?? null
        ]);
        Session::add('message', 'Gift created successfully');

        redirect('/admin/gifts');
    }

    public function edit($id): View
    {
        $gift = Gift::query()->where('id', $id)->first();
  
        $categories = Category::all();

        return View::render()->view('admin.gifts.edit', compact('gift', 'categories'));
    }

    public function update($id): void
    {
        $request = Request::get('post');
    
        CSRFToken::verify($request->csrf, false);
    
        RequestValidation::validate($request, [
            'name' => ['required' => true],
            'price' => ['required' => true, 'number' => true, 'min' => 0],
            'quantity' => ['required' => true, 'number' => true, 'min' => 0],
            'category_id' => ['required' => true],
            'description' => ['required' => true],
            'occasion' => ['required' => true],
            'size' => ['required' => true],
            'image_path' => ['image' => true] 
        ]);
    
        $gift = Gift::query()->where('id', $id)->first();
        $file = Request::get('file');
        $file_name = $file->image->name;
        if (!empty($file_name)) {
            if ($gift->image_path && file_exists($gift->image_path)) {
                unlink($gift->image_path);
            }
            $image_path = $this->uploadProductImage();
        } else {
            $image_path = $gift->image_path;
        }
        $gift->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'image_path' => $image_path,
            'size' => $request->size ?? null,
            'occasion' => $request->occasion ?? null
        ]);
    
        Session::add('message', 'Gift updated successfully');
        redirect('/admin/gifts');
    }
    

    public function delete($id): void
    {
        Gift::query()->where('id', $id)->delete();

        Session::add('message', 'Gift deleted successfully');
        redirect('/admin/gifts');
    }
    public function create(): View
    {
        $categories = Category::all();

        return View::render()->view('admin.gifts.create', compact('categories'));
}
    protected function uploadProductImage(): false|string
    {
        $file = Request::get('file');
        $file_name = $file->image->name;

        if (empty($file_name) || $file_name == "" || strlen($file_name) < 1) {
            return false;
        }

        if (!FileUpload::isImage($file_name)) {
            return false;
        }

        $file_temp = $file->image->tmp_name;

        return FileUpload::move($file_temp, 'images/products', $file_name)->getPath();
    }
}
