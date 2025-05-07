<?php
namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\{CSRFToken, FileUpload, RequestValidation, Request, Session, View};
use App\Middlewares\Role;
use App\Models\{Category, Product,BouquetFlower};
use Exception;

class ProductController extends Controller
{
    protected ?int $count = null;

    public function __construct()
    {
        Role::handle();
        $this->count = Product::all()->count();
    }


    public function index(): View
    {
        ['items' => $products, 'links' => $links] = paginateData(Product::class, 8);
    
        return View::render()->view('admin.products.index', compact('products', 'links'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $flowers = Product::query()->where('is_bouquet', 0)->get();
        return View::render()->view('admin.products.create', compact('categories', 'flowers'));
    }

    public function store(): void
    {
        $request = Request::get('post');

        CSRFToken::verify($request->csrf, false);

        RequestValidation::validate($request, [
            'name' => ['required' => true, 'unique' => 'products'],
            'sku' => ['required' => true, 'unique' => 'products'],
            'price' => ['required' => true, 'number' => true, 'min' => 0],
            'quantity' => ['required' => true, 'number' => true, 'min' => 0],
            'category_id' => ['required' => true],
            'description' => ['required' => true],
            'is_bouquet' => ['required' => true],
            'color' => ['required' => true],
            'length' => ['required' => true],
            'occasion' => ['required' => true],
            'image_path' => ['required' => true, 'image' => true]
        ]);

        $image_path = $this->uploadProductImage();

        if (!$image_path) {
            Session::add('invalids', ['image' => 'The product image is invalid or missing']);
            redirect('/admin/products/create');
        }

        $is_bouquet = isset($request->is_bouquet) ? 1 : 0;

        $product = Product::query()->create([
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'image_path' => $image_path,
            'is_bouquet' => $is_bouquet,
            'color' => $request->color ?? null,
            'length' => $request->length ?? null,
            'occasion' => $request->occasion ?? null
        ]);

        if ($is_bouquet && isset($request->flower) && is_array($request->flower)) {
            $this->saveBouquetComposition($product->id, $request->flower);
        }

        Session::add('message', 'Product created successfully');

        redirect('/admin/products');
    }

    protected function saveBouquetComposition(int $bouquet_id, array $flowerData): void
    {
        foreach ($flowerData as $flower_id => $quantity) {
            if (intval($quantity) > 0) {
                \App\Models\BouquetFlower::query()->create([
                    'bouquet_id' => $bouquet_id,
                    'flower_id' => $flower_id,
                    'quantity' => $quantity
                ]);
            }
        }
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

    public function edit($id): View
    {

    $product = Product::query()->where('id', $id)->first();
    $categories = Category::all();
    
    $bouquetFlowers = [];
    $flowers = [];
    
    if ($product->is_bouquet) {
        $flowers = Product::query()->where('is_bouquet', 0)->get();
        
        $bouquetFlowers = \App\Models\BouquetFlower::query()
            ->where('bouquet_id', $id)
            ->get()
            ->pluck('quantity', 'flower_id')
            ->toArray();
    }
    
    return View::render()->view('admin.products.edit', compact('product', 'categories', 'flowers', 'bouquetFlowers'));
}

    public function update($id): void
    {
        $request = Request::get('post');
        CSRFToken::verify($request->csrf, false);
    
        RequestValidation::validate($request, [
            'name' => ['required' => true],
            'sku' => ['required' => true],
            'price' => ['required' => true, 'number' => true, 'min' => 0],
            'quantity' => ['required' => true, 'number' => true, 'min' => 0],
            'category_id' => ['required' => true],
            'description' => ['required' => true],
            'is_bouquet' => ['required' => true],
            'color' => ['required' => true],
            'length' => ['required' => true],
            'occasion' => ['required' => true],
            'image_path' => ['image' => true] 
        ]);
    
        $product = Product::query()->where('id', $id)->first();
    
        $file = Request::get('file');
        $file_name = $file->image->name;
        if (!empty($file_name)) {
            if ($product->image_path && file_exists($product->image_path)) {
                unlink($product->image_path);
            }
            $image_path = $this->uploadProductImage();
        } else {
            $image_path = $product->image_path;
        }
    
        $is_bouquet = isset($request->is_bouquet) ? 1 : 0;
    
        $product->update([
            'name' => $request->name,
            'sku' => $request->sku, 
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'image_path' => $image_path,
            'is_bouquet' => $is_bouquet,
            'color' => $request->color ?? null,
            'length' => $request->length ?? null,
            'occasion' => $request->occasion ?? null
        ]);
    
        if ($is_bouquet && isset($request->flower) && is_array($request->flower)) {
            \App\Models\BouquetFlower::query()->where('bouquet_id', $id)->delete();
            $this->saveBouquetComposition($id, $request->flower);
        }
        Session::add('message', 'Product updated successfully');
        redirect('/admin/products');
    }
    

    public function delete($id): void
    {
        $product = Product::query()->where('id', $id)->first();

        if ($product->is_bouquet) {
            \App\Models\BouquetFlower::query()->where('bouquet_id', $id)->delete();
        }
        
        if ($product->image_path && file_exists($product->image_path)) {
            unlink($product->image_path);
        }

        $product->delete();

        Session::add('message', 'Product deleted successfully');

        redirect('/admin/products');
    }
    
    public function lowStock(): View
    {
        $threshold = 5;
        
        $lowStockProducts = Product::query()
            ->where('quantity', '<=', $threshold)
            ->where('quantity', '>', 0)
            ->get();
            
        return View::render()->view('admin.products.low-stock', compact('lowStockProducts', 'threshold'));
    }

    public function outOfStock(): View
    {
        $outOfStockProducts = Product::query()
            ->where('quantity', '=', 0)
            ->get();
            
        return View::render()->view('admin.products.out-of-stock', compact('outOfStockProducts'));
    }

    public function manageComposition($id): View
    {
        $bouquet = Product::query()->where('id', $id)->first();
        $product = Product::find($id);
    
        if (!$bouquet->is_bouquet) {
            Session::add('error', 'The selected product is not a bouquet');
            redirect('/admin/products');
        }
    
        $flowers = Product::query()->where('is_bouquet', 0)->get();
    
        $compositionItems = \App\Models\BouquetFlower::query()
            ->where('bouquet_id', $id)
            ->get();
            
        $composition = [];
        foreach ($compositionItems as $item) {
            $composition[$item->flower_id] = $item->quantity;
        }
    
        return View::render()->view('admin.products.composition', compact('product', 'bouquet', 'flowers', 'composition'));
    }
    

    public function updateComposition($id): void
    {
        $request = Request::get('post');
        $flowers = (array) $request->flower;
    
        CSRFToken::verify($request->csrf, false);
        
        $bouquet = Product::query()->where('id', $id)->first();
        
        if (!$bouquet || !$bouquet->is_bouquet) {
            Session::add('error', 'The selected product is not a bouquet');
            redirect('/admin/products');
            return;
        }
        
        $existingFlowers = BouquetFlower::query()
            ->where('bouquet_id', $id)
            ->get()
            ->keyBy('flower_id');
        
        if (isset($flowers) && is_array($flowers)) {
            foreach ($flowers as $flowerId => $quantity) {
                $flowerId = (int)$flowerId;
                $quantity = (int)$quantity;
                
                if (!$flowerId || $quantity <= 0) {
                    continue;
                }
                
                if (isset($existingFlowers[$flowerId])) {
                    if ($existingFlowers[$flowerId]->quantity !== $quantity) {
                        BouquetFlower::query()
                            ->where('bouquet_id', $id)
                            ->where('flower_id', $flowerId)
                            ->update([
                                'quantity' => $quantity,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                    }
                    $existingFlowers->forget($flowerId);
                } else {
                    BouquetFlower::query()->create([
                        'bouquet_id' => $id,
                        'flower_id' => $flowerId,
                        'quantity' => $quantity,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
        
        if ($existingFlowers->count() > 0) {
            BouquetFlower::query()
                ->where('bouquet_id', $id)
                ->whereIn('flower_id', $existingFlowers->pluck('flower_id')->toArray())
                ->delete();
        }
    
        Session::add('message', 'Bouquet composition updated successfully');
        redirect('/admin/products');
    }
}