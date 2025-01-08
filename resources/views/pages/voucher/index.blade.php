@extends('layouts.user_master')
@section('meta')
    <title> Mã khuyến mãi | Lavely Shop</title>
@endsection

@section('content')
    <div class="voucher_list">
        @foreach ($vouchers as $voucher)
            <div class="voucher_card">
                <div class="voucher_card_info">
                    <img class="voucher_card_img" src="{{ $voucher->voucherType()->image() }}" alt="" />
                    <div class="voucher_card_vertical"></div>
                    <div class="voucher_card_content">
                        <h3>{{ $voucher->voucherType()->name() }}</h3>
                        <div class="coupon_detail">
                            {{ number_format($voucher->discount_amount) . $voucher->discountType()->unit() }}
                            <span>Giảm</span>
                        </div>
                        <p>Hạn đến {{ date('d/m/Y', strtotime($voucher->end_date)) }}</p>
                    </div>
                </div>
                <div class="voucher_card_bottom">
                    <input type="text" readonly value="{{ $voucher->code }}" />
                    <button onclick="copyIt()" class="copybtn">Sao chép</button>
                </div>
            </div>
        @endforeach
    </div>
@endsection
