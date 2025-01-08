@extends('layouts.user_master')
@section('meta')
    <title> Thông tin | Lavely Shop</title>
@endsection

@section('content')
    <div class="title">
        Thông tin người dùng
    </div>
    <div class="user_info">
        <div class="item">
            <div class="label">Tên</div>
            <div class="detail">
                <input value="{{ $user->name }}">
            </div>
        </div>
        <div class="item">
            <div class="label">Email</div>
            <div class="detail">
                {{ $user->email }}
            </div>
        </div>
        <div class="item">
            <div class="label">Số điện thoại</div>
            <div class="detail">
                {{ $user->phone }}
            </div>
        </div>
        <div class="item">
            <div class="label"></div>
            <div class="detail">
                <button id="save_info_btn">Lưu thông tin</button>
            </div>
        </div>
    </div>
@endsection
