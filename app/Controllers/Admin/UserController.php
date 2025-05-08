<?php
namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\{CSRFToken, Request, RequestValidation, Session, View};
use App\Middlewares\Role;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    protected int $count;

    public function __construct()
    {
        Role::handle();

        $this->count = User::all()->count();
    }

    public function index(): View
    {
        ['items' => $users, 'links' => $links] = paginateData(User::class, 10);
        return View::render()->view('admin.users.index', compact('users', 'links'));
    }

    public function edit($id): View
    {
        $user = User::query()->where('id', $id)->first();

        return View::render()->view('admin.users.edit', compact('user'));
    }

    public function update($id): void
    {
        $request = Request::get('post');
        CSRFToken::verify($request->csrf, false);
    
        // Validate the input fields
        RequestValidation::validate($request, [
            'name' => ['required' => true],
            'surname' => ['required' => true],
            'role' => ['required' => true],
            'email' => ['required' => true, 'email' => true],
            'telephone' => ['required' => true],
            'address' => ['required' => true],
            'city' => ['required' => true],
            'postal_code' => ['required' => true],

        ]);
    
        $users = User::query()->where('id', $id)->first();
        $users->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'role' => $request->role,
            'email'=> $request->email,
            'address' =>$request->address,
            'city' =>$request->city,
            'postal_code'=>$request->postal_code
        ]);
        Session::add('message', 'User updated successfully');
        redirect('/admin/users');
    }

    public function delete($id): void
    {
        User::query()->where('id', $id)->delete();

        Session::add('message', 'User deleted successfully');
        redirect('/admin/users');
    }
}