<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getProfileInfoPage()
    {
        $user = Auth::user();
        return view('pages.user.info', compact('user'));
    }

    public function getChangePasswordPage()
    {
        return view('pages.user.change_password');
    }
}
