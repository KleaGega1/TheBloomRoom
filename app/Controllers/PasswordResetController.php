<?php

namespace App\Controllers;

use App\Core\{CSRFToken, Mail, Request, RequestValidation, Session, View};
use App\Models\User;
use App\Models\PasswordReset;
use Exception;

class PasswordResetController extends Controller
{
    public function showForgotForm(): View
    {
        return View::render()->view('auth.forgot-password');
    }

    public function sendResetLink(): void
    {
        $request = Request::get('post');
        CSRFToken::verify($request->csrf, false);

        RequestValidation::validate($request, [
            'email' => ['required' => true, 'email' => true]
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Session::add('message', 'If your email is in our system, you will receive a password reset link.');
            redirect('/forgot-password');
            return;
        }

        $token = bin2hex(random_bytes(32));
        
        // Set expiration time (1 hour from now)
        $expirationTime = date('Y-m-d H:i:s', strtotime('+1 hour'));
        PasswordReset::query()->where('user_id', $user->id)->delete();
        
        // Store the token in the password_resets table
        PasswordReset::create([
            'user_id' => $user->id,
            'token' => $token,
            'expired_time' => $expirationTime
        ]);

        $resetUrl = url('/reset-password' . '?token='.$token);

        try {
            $mail = new Mail();
            $subject = 'Reset Your Password';
            $htmlBody = "
                <h1>Reset Your Password</h1>
                <p>Hello {$user->name},</p>
                <p>You are receiving this email because we received a password reset request for your account.</p>
                <p>Please click the link below to reset your password:</p>
                <p><a href=\"{$resetUrl}\" style=\"padding: 10px 20px; background-color: #3490dc; color: white; text-decoration: none; border-radius: 5px;\">Reset Password</a></p>
                <p>This password reset link will expire in 60 minutes.</p>
                <p>If you did not request a password reset, no further action is required.</p>
                <p>Best regards,<br>The Bloom Room Team</p>
            ";
            
            $mail->sendHtml($user->email, $subject, $htmlBody);
            
            Session::add('message', 'If your email is in our system, you will receive a password reset link.');
            redirect('/login');
        } catch (Exception $e) {
            error_log('Failed to send password reset email: ' . $e->getMessage());
            Session::add('invalids', ['We encountered an error sending your password reset email. Please try again later.']);
            redirect('/forgot-password');
            }
        }

    public function showResetForm(): View
    {
        $request = Request::get('get');
        $token = $request->token;
        if (!$token) {
            Session::add('invalids', ['Invalid password reset token.']);
            redirect('/forgot-password');
        }
        
        // Check if the token exists and is valid
        $reset = PasswordReset::where('token', $token)
            ->where('used', 0)
            ->where('expired_time', '>', date('Y-m-d H:i:s'))
            ->first();
            
        if (!$reset) {
            Session::add('invalids', ['The password reset token is invalid or has expired.']);
            redirect('/forgot-password');
        }
        
        return View::render()->view('auth.reset-password', [
            'token' => $token
        ]);
    }
    
    public function resetPassword(): void
    {
        $request = Request::get('post');
        CSRFToken::verify($request->csrf, false);

        RequestValidation::validate($request, [
            'token' => ['required' => true],
            'password' => ['required' => true, 'min' => 6],
            'confirm_password' => ['required' => true, 'equals' => 'password']
        ]);

        // Check if the token exists and is valid
        $reset = PasswordReset::where('token', $request->token)
            ->where('used', 0)
            ->where('expired_time', '>', date('Y-m-d H:i:s'))
            ->first();
            
        if (!$reset) {
            Session::add('invalids', ['The password reset token is invalid or has expired.']);
            redirect('/forgot-password');
            return;
        }

        // Find the user by user_id from the reset token
        $user = User::find($reset->user_id);
            
        if (!$user) {
            Session::add('invalids', ['We could not find a user associated with this reset token.']);
            redirect('/forgot-password');
            return;
        }

        // Update the password
        $user->password = sha1($request->password);
        $user->save();

        // Mark the token as used
        $reset->used = 1;
        $reset->save();

        try {
            $mail = new Mail();
            $subject = 'Your Password Has Been Reset';
            $htmlBody = "
                <h1>Password Reset Successful</h1>
                <p>Hello {$user->name},</p>
                <p>Your password has been successfully reset.</p>
                <p>If you did not make this change, please contact support immediately.</p>
                <p>Best regards,<br>The Bloom Room Team</p>
            ";
            
            $mail->sendHtml($user->email, $subject, $htmlBody);
        } catch (Exception $e) {
            error_log('Failed to send password reset confirmation email: ' . $e->getMessage());
        }

        Session::add('message', 'Your password has been reset successfully. You can now login with your new password.');
        redirect('/login');
    }
}