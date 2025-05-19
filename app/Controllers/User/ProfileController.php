<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Core\{CSRFToken, Request, RequestValidation, Session, View};
use App\Middlewares\Auth;
use Exception;
use App\Models\{Order, User};

//Handles user profile functionalities like viewing, editing, updating info and password.
class ProfileController extends Controller
{
    public function __construct()
    {
        Auth::check();
    }

    public function index(): View
    {
        $user = get_logged_in_user();
        return View::render()->view('user.profile.index', compact('user'));
    }

    public function edit($id): View
    {
        $user = get_logged_in_user();
        return View::render()->view('user.profile.edit', compact('user'));
    }

    public function update($id): void
    {
        $request = Request::get('post');
        $file = $_FILES['profile_image'] ?? null;
        CSRFToken::verify($request->csrf, false);

        RequestValidation::validate($request, [
            'email' => ['required' => true, 'email' => true],
            'name' => ['required' => true],
            'surname' => ['required' => true],
            'telephone'=>['required' => true],
            'address'=>['required' => true],
            'city'=>['required' => true],
            'postal_code'=>['required' => true],
            'profile_image' => ['image' => true, 'maxSize' => 2 * 1024 * 1024] 
        ]);

        $user = User::query()->whereId($id)->first();

        $user->update([
            'email' => $request->email,
            'name' => $request->name,
            'surname' => $request->surname,
            'telephone' => $request->telephone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'profile_image' => $file ? FileUpload::upload($file, 'profile_images') : $user->profile_image
        ]);

        Session::add('message', 'profile updated successfully');
        redirect('/profile');
    }

    public function editPassword($id): View
    {
        $user = User::query()->whereId($id)->first();

        return View::render()->view('user.profile.password', compact('user'));
    }

    public function updatePassword($id): void
    {
        $request = Request::get('post');

        CSRFToken::verify($request->csrf, false);

        RequestValidation::validate($request, [
            'oldPassword' => ['required' => true, 'minLength' => 4],
            'newPassword' => ['required' => true, 'minLength' => 4],
            'confirm_password' => ['required' => true, 'equals' => 'newPassword'],
        ]);

        $user = User::query()->where('id', $id)->first();

        if (sha1($request->oldPassword) !== $user->password) {
            Session::add('invalids', ['old password incorrect']);
            redirect("/profile/{$id['id']}/edit/password");
            return;
        }

        $user->update([
            'password' => sha1($request->newPassword)
        ]);

        Session::add('message', 'password updated');
        redirect("/profile");
    }

    public function orders()
    {
        $user = get_logged_in_user();
        if (!$user) {
            return redirect('/login');
        }
        $orders = \App\Models\Order::query()->where('user_id', $user->id)->orderBy('created_at', 'desc')->with('items')->get();
        return \App\Core\View::render()->view('user.profile.orders', [
            'orders' => $orders,
            'user' => $user
        ]);
    }

    public function orderDetails($orderId)
    {
        $user = get_logged_in_user();
        if (!$user) {
            return redirect('/login');
        }
        $order = \App\Models\Order::query()->where('id', $orderId)->where('user_id', $user->id)->with('items')->first();
        if (!$order) {
            abort(404, 'Order not found');
        }
        return \App\Core\View::render()->view('user.profile.order_details', [
            'order' => $order,
            'user' => $user
        ]);
    }

    public function cancelOrder($orderId)
    {
        $user = get_logged_in_user();
        if (!$user) {
            return redirect('/login');
        }
        $order = \App\Models\Order::query()->where('id', $orderId)->where('user_id', $user->id)->first();
        if (!$order) {
            \App\Core\Session::add('invalids', ['Order not found.']);
            return redirect('/profile/orders');
        }
        if (in_array($order->status, ['cancelled', 'shipped', 'delivered', 'processing'])) {
            \App\Core\Session::add('invalids', ['Order cannot be cancelled.']);
            return redirect('/profile/orders');
        }
        $createdAt = strtotime($order->created_at);
        if (time() - $createdAt > 3600) {
            \App\Core\Session::add('invalids', ['Order can only be cancelled within 1 hour of placement.']);
            return redirect('/profile/orders');
        }
        $order->status = 'cancelled';
        $order->save();
        \App\Core\Session::add('message', 'Order cancelled successfully.');
        return redirect('/profile/orders');
    }
}