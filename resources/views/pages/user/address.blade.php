@extends('layouts.user_master')
@section('meta')
    <title> Địa chỉ người dùng | Lavely Shop</title>
@endsection

@section('content')
    <div class="title address_title">
        Địa chỉ <button id="add_address">+ Thêm địa chỉ</button>
    </div>
    <div class="address_container">
        @if ($addresses->count() > 0)
            @foreach ($addresses as $address)
                <div class="address_item" data-id="{{ $address->id }}">
                    <div class="address_info">
                        <div class="name"> {{ $address->user_name }} <span> ({{ $address->phone }})</span></div>
                        <div class="location">
                            {{ ($address->address_detail ? $address->address_detail . ', ' : '') . $address->path_with_type }}
                        </div>
                    </div>
                    <div class="action">
                        <button class="update_action" data-id="{{ $address->id }}">Cập nhật</button>
                        <button class="del_action" data-id="{{ $address->id }}">Xóa</button>
                    </div>
                </div>
            @endforeach
        @else
            <p class="noti">Chưa có địa chỉ. Vui lòng thêm địa chỉ mới.</p>
        @endif
        <div class="popup" id="popup_form">
            <div class="popup_content">
                <span class="close_btn" id="close_popup">&times;</span>
                <h2>Thêm địa chỉ</h2>
                <div class="address_form">
                    <input type="text" name="name" placeholder="Nhập tên người nhận">
                    <input type="text" name="phone" placeholder="Nhập số điện thoại">

                    <select id="province_select">
                        <option value="0">Chọn tỉnh thành phố</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province['code'] }}">{{ $province['name_with_type'] }}</option>
                        @endforeach
                    </select>

                    <select id="district_select">
                        <option value="0">Chọn quận huyện</option>
                    </select>

                    <select id="commune_select">
                        <option value="0">Chọn xã phường</option>
                    </select>

                    <input type="text" name="address_detail" placeholder="Địa chỉ chi tiết">
                    <p class="error_text"></p>
                    <button type="button" id="add_address_btn">Thêm địa chỉ</button>
                    <button type="button" id="update_address_btn">Cập nhật địa chỉ</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset(mix('assets/js/user_address.js')) }}"></script>
@endsection
