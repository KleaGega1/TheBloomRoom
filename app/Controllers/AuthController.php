<?php

namespace App\Controllers;

use App\Core\{CSRFToken, Request, RequestValidation, Session, View};
use App\Models\User;
use Exception;
//Handles user authentication: registration, login, logout.
class AuthController extends Controller
{
    public function __construct()
    {
	    !(is_logged_in()) ?: redirect('/');
    }

    public function register(): View
    {
        return View::render()->view('auth.register');
    }

    /**
     * @throws Exception
     */
    public function registerPost(): void
    {
        $request = Request::get('post');
        $file = $_FILES['profile_image'] ?? null;
        CSRFToken::verify($request->csrf, false);

        // Validate registration fields
        RequestValidation::validate($request, [
            'name' => ['required' => true],
            'surname' => ['required' => true],
            'email' => ['required' => true, 'unique' => 'users', 'email' => true],
            'password' => ['required' => true, 'min' => 6],
            'confirm_password' => ['required' => true, 'equals' => 'password'],
            'telephone'=>['required' => true],
        ]);

        $imagePath = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
    
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileName = basename($file['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
            if (!in_array($fileExtension, $allowedExtensions)) {
                Session::add('invalids', ['Invalid image type. Allowed types: jpg, jpeg, png, gif.']);
                redirect('/register');
                return;
            }
    
            $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
            $destination = __DIR__ . '/../../public/uploads/' . $newFileName;
    
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                Session::add('invalids', ['Failed to upload profile image.']);
                redirect('/register');
                return;
            }
    
            $imagePath = '/uploads/' . $newFileName;
        }
    
        // Create new user
        User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => sha1($request->password),
            'telephone'=> $request->telephone,
            'role' => 'user',
            'profile_image' => $imagePath
        ]);
         
        $user = User::where('email', $request->email)->first();
       
        try {
            $mail = new \App\Core\Mail();
            $subject = 'Welcome to our store';
            $htmlBody = "
                <h1>Welcome to our store, {$user->name}!</h1>
                <p>Thank you for registering. Your account has been created successfully.</p>
                <p>Your login details:</p>
                <ul>
                    <li>Email: {$user->email}</li>
                </ul>
                <p>You can now log in to your account and start shopping.</p>
                <p>Best regards,<br>The Store Team</p>
            ";
            
            $mail->sendHtml($user->email, $subject, $htmlBody);
        } catch (Exception $e) {
            // Log the error but don't stop the registration process
            error_log('Failed to send registration email: ' . $e->getMessage());
        }
    
    

        Session::add('message', 'You are successfully registered, now you can login!');
        redirect('/login');
    }
    //Show the login form.
    public function login(): View
    {
        return View::render()->view('auth.login');
    }

    /**
     * @throws Exception
     */
    //Handle user login.
    public function loginPost(): void
    {
        $request = Request::get('post');
    
        CSRFToken::verify($request->csrf, false);
    
        RequestValidation::validate($request, [
            'email' => ['required' => true],  // Make sure this is the correct input name in your login form
            'password' => ['required' => true, 'min' => 6]
        ]);
    
        // Query by email (assuming email is unique for each user)
        $userQuery = User::query()->where('email', $request->email);
    
        if (!$userQuery->exists()) {
            Session::add('invalids', ['User not found']);
            redirect('/login');
            return;
        }
    
        $user = $userQuery->first();
    
        // Compare hashed password
        if (sha1($request->password) !== $user->password) {
            Session::add('invalids', ['Password is invalid']);
            redirect('/login');
            return;
        }
    
        // Store user info in session
        Session::add('user_id', $user->id);
        Session::add('user_name', $user->name);
    
        // Redirect based on the role
        if ($user->role == 'admin') {
            redirect('/admin');  // Admin panel
        } else {
            redirect('/');  // Homepage for regular users
        }
    }
    

    //Log the user out and destroy session.
    public function logout(): void
    {
        if (is_logged_in()) {
            Session::remove('user_id');
            Session::remove('user_name');

            if (Session::has('cart')) {
                session_destroy();
            }
        }
        redirect('/login');
    }
}
