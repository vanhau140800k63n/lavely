@extends('layouts.master')
@section('meta')
    <title>Thanh Toán | Lavely</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
    <section class="payment_detail first_section">
        <div class="payment_title">
            THANH TOÁN
        </div>
        <div class="payment_container">
            <div class="payment_customer">
                <h4>THÔNG TIN KHÁCH HÀNG</h4>
                @if (!is_null($addressDefault))
                    <div class="address_container">
                        <div class="address_item address_default" address_id="{{ $addressDefault->id }}">
                            <div class="address_info">
                                <div class="name"> {{ $addressDefault->user_name }} <span>
                                        ({{ $addressDefault->phone }})</span></div>
                                <div class="location">
                                    {{ ($addressDefault->address_detail ? $addressDefault->address_detail . ', ' : '') . $addressDefault->path_with_type }}
                                </div>
                            </div>
                            <div class="action">
                                <button class="update_action"> Thay đổi</button>
                            </div>
                        </div>
                    </div>
                @else
                    <a class="primary_button update_action" href="{{ route('user.address.page') }}">Thêm địa chỉ</a>
                @endif
                <div class="payment_input">
                    <p>GHI CHÚ ĐƠN HÀNG</p>
                    <input type="text" name="note">
                </div>
            </div>
            <div class="payment_order">
                <h4>THÔNG TIN THANH TOÁN</h4>
                <div class="payment_product_list">
                    @foreach ($cartItems as $product)
                        <div class="payment_product" product_id="{{ $product->id }}">
                            <div class="payment_product_img">
                                <img src="{{ $product->prodItem->image }}" alt="">
                            </div>
                            <div class="payment_product_container">
                                <p>{{ $product->product->name }}</p>
                                <div class="payment_product_price">
                                    <div class="price_default">
                                        ₫{{ number_format($product->product->max_price) }}
                                    </div>
                                    <div class="price_sale">
                                        ₫{{ number_format($product->product->max_price) }} x {{ $product->quantity }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="payment_order_info">GIÁ TRỊ ĐƠN HÀNG
                    <span>{{ number_format($totalPrice) }}đ</span>
                </div>
                <div class="payment_order_info">PHÍ VẬN CHUYỂN <span>{{ number_format(35000) }}đ</span></div>
                <div class="payment_order_info">
                    VOUCHER SHOP
                    <span><button class="primary_button update_action" id="voucher_select">Chọn voucher</button></span>
                </div>
                <div class="payment_order_info">
                    PHƯƠNG THỨC THANH TOÁN
                    <span>Thanh toán khi nhận hàng</span>
                </div>
                <div class="payment_order_bottom">
                    <h3>TỔNG THANH TOÁN</h3>
                    <div class="payment_order_detail">
                    </div>
                </div>
                <button class="order_btn" id="order_submit">ĐẶT HÀNG</button>
            </div>
        </div>
        <div class="popup" id="popup_address">
            <div class="popup_content">
                <span class="close_btn" id="close_popup">&times;</span>
                <h2>Chọn địa chỉ</h2>
                <div class="address_container">
                    @foreach ($addresses as $address)
                        <div class="address_item" address_id="{{ $address->id }}">
                            <div class="address_info">
                                <div class="name"> {{ $address->user_name }} <span>
                                        ({{ $address->phone }})
                                    </span></div>
                                <div class="location">
                                    {{ ($address->address_detail ? $address->address_detail . ', ' : '') . $address->path_with_type }}
                                </div>
                            </div>
                            <div class="action">
                                <button class="update_action"> Chọn </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="common_btn" href="{{ route('user.address.page') }}"> Thêm địa chỉ </a>
            </div>
        </div>

        <div class="popup" id="popup_voucher">
            <div class="popup_content">
                <span class="close_btn">&times;</span>
                <h2>Chọn voucher</h2>
                <div class="voucher_list">
                    @foreach ($vouchers as $voucher)
                        <div class="voucher_card" voucher_id="{{ $voucher->id }}">
                            <div class="voucher_card_info">
                                <img class="voucher_card_img" src="{{ $voucher->voucherType()->image() }}"
                                    alt="" />
                                <div class="voucher_card_vertical"></div>
                                <div class="voucher_card_content">
                                    <h3>{{ $voucher->voucherType()->name() }}</h3>
                                    <div class="coupon_detail">
                                        {{ number_format($voucher->discount_amount) . $voucher->discountType()->unit() }}
                                        <span>Giảm</span>
                                    </div>
                                    <p>{{ date('d/m/Y', strtotime($voucher->start_date)) }} <i
                                            class="fa-solid fa-arrow-right"></i>
                                        {{ date('d/m/Y', strtotime($voucher->end_date)) }}</p>
                                </div>
                            </div>
                            <div class="voucher_card_bottom">
                                <input type="text" readonly value="{{ $voucher->code }}" />
                                <button class="apply_btn">Chọn</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="{{ asset(mix('assets/js/payment.js')) }}"></script>
@endsection
