@extends('layouts.user_master')
@section('meta')
    <title> Đổi mật khẩu | Lavely</title>
@endsection

@section('content')
    <div class="title">
        Đổi mật khẩu
    </div>
    <div class="user_info">
        <div class="item">
            <div class="label">Mật khẩu cũ</div>
            <div class="detail">
                <input name="old_password">
            </div>
        </div>
        <div class="item">
            <div class="label">Mật khẩu mới</div>
            <div class="detail">
                <input name="new_password">
            </div>
        </div>
        <div class="item">
            <div class="label">Nhập lại mật khẩu</div>
            <div class="detail">
                <input name="retype_password">
            </div>
        </div>
        <div class="item">
            <div class="label"></div>
            <div class="detail">
                <button id="save_info_btn">Đổi mật khẩu</button>
            </div>
        </div>
    </div>
@endsection
