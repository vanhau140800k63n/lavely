<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function getLoginPage()
    {
        return view('pages.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('home');
    }

    public function getRegisterPage()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('pages.auth.register');
        }
    }

    public function login(Request $req)
    {
        $this->validate(
            $req,
            [
                'account' => [
                    'required',
                    'regex:/^([0-9]{10,11}|[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+)$/'
                ],
                'password' => 'required'
            ],
            [
                'account.regex' => 'Tài khoản không đúng định dạng',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'account.required' => 'Bạn chưa nhập email hoặc số điện thoại',
            ]
        );

        $credentials = [];
        if (filter_var($req->account, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $req->account;
        } else {
            $credentials['phone'] = $req->account;
        }
        $credentials['password'] = $req->password;

        if (Auth::attempt($credentials)) {
            if ($req->has('prev_url')) {
                return redirect()->to($req->prev_url);
            }
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('alert', 'Thông tin đăng nhập không đúng!');
        }
    }

    public function register(Request $req)
    {
        $this->validate(
            $req,
            [
                'account' => 'required|email|unique:user,email',
                'password' => 'required'
            ],
            [
                'account.required' => 'Vui lòng nhập email',
                'account.email' => 'Email không hợp lệ',
                'account.unique' => 'Email đã được đăng ký, bạn có thể bấm quên mật khẩu để lấy lại tài khoản',
                'password.required' => 'Bạn chưa nhập mật khẩu',
            ]
        );

        DB::beginTransaction();
        try {
            $user = User::firstOrCreate(
                ['email' => $req->account],
                [
                    'email' => $req->account,
                    'password' => Hash::make($req->password)
                ]
            );

            if (!$user->wasRecentlyCreated) {
                return back()->withErrors('Tài khoản đã tồn tại.');
            }
            DB::commit();
        } catch (Throwable $ex) {
            DB::rollBack();
            return back()->withErrors('Có lỗi xảy ra');
        }

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập.');
    }
}
