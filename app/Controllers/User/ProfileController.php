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

    /**
     * @throws Exception
     */
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
        ]);

        $user = User::query()->whereId($id)->first();

        $user->update([
            'email' => $request->email,
            'name' => $request->name,
            'surname' => $request->surname,
            'telephone' => $request->telephone,
        ]);

        Session::add('message', 'profile updated successfully');
        redirect('/profile');
    }

    public function editPassword($id): View
    {
        $user = User::query()->whereId($id)->first();

        return View::render()->view('user.profile.password', compact('user'));
    }

    /**
     * @throws Exception
     */
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
}