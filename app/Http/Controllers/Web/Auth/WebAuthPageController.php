<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\Auth\AuthController;
use Illuminate\Http\Response;

class WebAuthPageController extends Controller
{
    public function displayLoginPage()
    {
        return view('auth.login');
    }

    public function displaySignupPage()
    {
        return view('auth.signup');
    }

    public function verifyEmailPage($user_id)
    {
        $response = AuthController::verifyEmail($user_id);

        if ($response['status_code'] == Response::HTTP_OK) {
            session()->flash('response_type', 'success');
            session()->flash('message', $response['message']);
        } else {
            session()->flash('response_type', 'error');
            session()->flash('message', $response['message'] . ' ' . $response['error']['message']);
        }

        return view('auth.verify_email');
    }
}
