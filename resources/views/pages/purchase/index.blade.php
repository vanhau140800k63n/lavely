@extends('layouts.user_master')
@section('meta')
    <title> Đơn hàng | Lavely Shop</title>
@endsection

@section('content')
    <div class="title purchase_title">
        Thông tin đơn hàng
    </div>
    <div class="purchase_container">
        <div class="purchase_search">
            <div class="purchase_search_item" data-filter="all">Tất cả</div>
            <div class="purchase_search_item" data-filter="pending">Chờ xử lý</div>
            <div class="purchase_search_item" data-filter="processing">Đang xử lý</div>
            <div class="purchase_search_item" data-filter="completed">Hoàn thành</div>
            <div class="purchase_search_item" data-filter="canceled">Đã hủy</div>
        </div>
        <div class="purchase_list">
            @foreach ($purchaseList as $purchase)
                <div class="purchase_item">
                    <div class="purchase_header">
                        <div class="purchase_address">{{ $purchase->district . ', ' . $purchase->province }}</div>
                        <div class="purchase_status">{{ $purchase->status }}</div>
                    </div>
                    <div class="purchase_product_list">
                        @foreach ($purchase->orderProducts as $orderPruduct)
                            <div class="purchase_product">
                                <img class="purchase_product_img" src="{{ $orderPruduct->prodItem->image }}">
                                <div class="purchase_product_name"> {{ $orderPruduct->product->name }} x
                                    {{ $orderPruduct->quantity }}</div>
                                <div class="purchase_product_price">{{ number_format($orderPruduct->price) }}đ</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="purchase_bottom">
                        <div class="purchase_date">{{ $purchase->created_at }}</div>
                        <div class="purchase_price">Thành tiền: <span>{{ number_format($purchase->actual_price) }}đ</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script type="text/javascript" src="{{ asset(mix('assets/js/user_purchase.js')) }}"></script>
@endsection
