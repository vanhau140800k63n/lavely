@extends('layouts.auth_master')
@section('meta')
    <title>Đăng nhập | Lavely Shop</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset(mix('assets/css/auth.css')) }}" type="text/css">
@endsection

@section('content')
    <div class="login">
        <div class="auth_header">
            <img src="{{ asset('image/logo/header_logo.png') }}">
        </div>
        <div class="container_auth">
            <div class="wrap_auth">
                <form class="auth_form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="auth_form_title">
                        ĐĂNG NHẬP
                    </span>

                    <div class="wrap_input">
                        <span class="label_input">Email / Số điện thoại</span>
                        <input class="input" type="text" name="account" placeholder="Nhập email / số điện thoại">
                        <span class="focus_input" data-symbol="∙"></span>
                    </div>

                    <div class="wrap_input">
                        <span class="label_input">Mật khẩu</span>
                        <input class="input" type="password" name="password" placeholder="Nhập mật khẩu">
                        <span class="focus_input" data-symbol="∙"></span>
                    </div>

                    <a href="" class="fg_password">
                        Quên mật khẩu?
                    </a>

                    <button class="auth_form_btn" type="submit">
                        Đăng nhập
                    </button>


                    <a href="{{ url('auth/google') }}" class="google_btn">
                        <div class="google_btn_box">
                            <img class="google_icon" src="https://cdn-icons-png.flaticon.com/128/300/300221.png" />
                            <p class="google_btn_text">Đăng nhập với Google</p>
                        </div>
                    </a>

                    <div class="auth_more">
                        <span class="auth_more_title">
                            Nếu bạn chưa có tài khoản,
                        </span>

                        <a href="{{ route('register_page') }}" class="auth_more_button">
                            Đăng ký
                        </a>
                    </div>

                    @if (count($errors) > 0)
                        <div class="error_text">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @if (session()->get('alert'))
                        <div class="error_text">
                            Thông tin đăng nhập không đúng
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
