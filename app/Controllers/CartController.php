<?php

namespace App\Controllers;

use App\Core\{Request, View, Session, CSRFToken};
use App\Models\{Cart, CartItem, Product, Gift};

class CartController extends Controller
{
  public function index(): View
{
    $user = get_logged_in_user();
    if (!$user) {
        return redirect('/login');
    }

    $cart = $this->getUserCart($user['id']);

    if (!$cart) {
        return View::render()->view('client.cart.index', [
            'items' => [],
            'total' => 0,
            'products' => [],
            'gifts' => []
        ]);
    }

    $items = CartItem::query()
        ->where('cart_id', $cart->id)
        ->get();

    $productIds = [];
    $giftIds = [];

    foreach ($items as $item) {
        if ($item->item_type === 'product') {
            $productIds[] = $item->item_id;
        } elseif ($item->item_type === 'gift') {
            $giftIds[] = $item->item_id;
        }
    }

    $products = Product::all()->keyBy('id');
    $gifts = Gift::all()->keyBy('id');

return View::render()->view('client.cart.index', [
    'items' => $items,
    'products' => $products,
    'gifts' => $gifts,
    'total' => $this->calculateCartTotal($items->toArray())
]);
}

    public function addToCart(): void
    {
        $user = get_logged_in_user();
        if (!$user) {
            redirect('/login');
            return;
        }

        $itemId = Request::post('item_id');
        $itemType = Request::post('item_type'); 
        $quantity = (int) Request::post('quantity', 1);

        if (!$itemId || !$itemType || $quantity < 1) {
            Session::add('error', 'Invalid item information');
            redirect('/cart');
            return;
        }

        if (!in_array($itemType, ['product', 'gift'])) {
            Session::add('error', 'Invalid item type');
            redirect('/cart');
            return;
        }

        $item = $itemType === 'product'
            ? Product::find($itemId)
            : Gift::find($itemId);

        if (!$item) {
            Session::add('error', ucfirst($itemType) . ' not found');
            redirect('/cart');
            return;
        }

        if ($item->quantity < $quantity) {
            Session::add('error', 'Not enough items in stock. Only ' . $item->quantity . ' available.');
            redirect(Request::server('HTTP_REFERER', '/'));
            return;
        }

        $cart = $this->getUserCart($user['id'], true);

        $existingItem = CartItem::query()
            ->where('cart_id', $cart->id)
            ->where('item_id', $itemId)
            ->where('item_type', $itemType)
            ->first();

        if ($existingItem) {
            if ($existingItem->quantity + $quantity > $item->quantity) {
                Session::add('error', 'Cannot add more items. Maximum available: ' . $item->quantity);
                redirect(Request::server('HTTP_REFERER', '/'));
                return;
            }
            
            $existingItem->quantity += $quantity;
            $existingItem->save();
            Session::add('message', 'Item quantity updated in cart');
        } else {
            CartItem::create([
                'cart_id'   => $cart->id,
                'item_id'   => $itemId,
                'item_type' => $itemType,
                'quantity'  => $quantity,
                'price'     => $item->price
            ]);
            Session::add('message', 'Item added to cart');
        }

        redirect('/cart');
    }

    public function remove($id): void
    {
        $user = get_logged_in_user();
        if (!$user) {
            redirect('/login');
            return;
        }

        $cartItem = CartItem::find($id);
        if (!$cartItem) {
            Session::add('error', 'Item not found in cart');
            redirect('/cart');
            return;
        }
        $cart = Cart::find($cartItem->cart_id);

        if (!$cart || $cart->user_id !== $user['id']) {
            Session::add('error', 'You do not have permission to remove this item');
            redirect('/cart');
            return;
        }
        $cartItem->delete();
        Session::add('message', 'Item removed from cart');
        redirect('/cart');

    }

    public function updateQuantity(): void
    {
        $user =get_logged_in_user();
        if (!$user) {
            redirect('/login');
            return;
        }
        
        
        $itemId = Request::post('item_id');
        $quantity = (int) Request::post('quantity', 1);
        
        if ($quantity < 1) {
            Session::add('error', 'Quantity must be at least 1');
            redirect('/cart');
            return;
        }
        
        $cartItem = CartItem::find($itemId);
        
        if (!$cartItem) {
            Session::add('error', 'Cart item not found');
            redirect('/cart');
            return;
        }
        
        $cart = Cart::find($cartItem->cart_id);
        
        if (!$cart || $cart->user_id !== $user['id']) {
            Session::add('error', 'You do not have permission to update this item');
            redirect('/cart');
            return;
        }
        
        $item = $cartItem->item_type === 'product'
            ? Product::find($cartItem->item_id)
            : Gift::find($cartItem->item_id);
            
        if (!$item) {
            Session::add('error', 'Item not found');
            redirect('/cart');
            return;
        }
        
        if ($item->quantity < $quantity) {
            Session::add('error', 'Not enough items in stock. Only ' . $item->quantity . ' available.');
            redirect('/cart');
            return;
        }
        
        $cartItem->quantity = $quantity;
        $cartItem->save();
        
        Session::add('message', 'Cart updated');
        redirect('/cart');
    }

    private function getUserCart(int $userId, bool $createIfNotExists = false): ?Cart
    {
        $cart = Cart::query()->where('user_id', $userId)->first();
        
        if (!$cart && $createIfNotExists) {
            $cart = Cart::create(['user_id' => $userId]);
        }
        
        return $cart;
    }

private function calculateCartTotal($items): float
{
    $total = 0;
    
    foreach ($items as $item) {
        $price = is_array($item) ? $item['price'] : $item->price;
        $quantity = is_array($item) ? $item['quantity'] : $item->quantity;
        
        $total += $price * $quantity;
    }
    
    return $total;
}
}