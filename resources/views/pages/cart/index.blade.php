@extends('layouts.master')
@section('meta')
    <title>Giỏ Hàng | Lavely</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
    @if (session()->has('cart_quantity') && session('cart_quantity'))
        <section class="cart_detail first_section" style="">
            <h1 class="cart_banner">
                GIỎ HÀNG
            </h1>
            <div class="cart_container">
                <div class="cart_header">
                    <div></div>
                    <div>Sản Phẩm</div>
                    <div>Đơn giá</div>
                    <div>Số lượng</div>
                    <div>Số tiền</div>
                    <div>Thao tác</div>
                </div>
                @foreach ($cart as $cart_item)
                    <div class="cart_item" id="{{ $cart_item->id }}">
                        <div class="cart_shop">
                            <?php $shop = App\Models\Shop::where('id', $cart_item->product->shop->id)->first(); ?>
                            <div class="cart_shop_name">{{ $shop->name }}</div>
                        </div>
                        <div class="cart_product">
                            <div class="cart_product_checkbox">
                                <input class="product_checkbox" type="checkbox" name="cart_product_input"
                                    value="{{ $cart_item->id }}">
                            </div>
                            <div class="cart_product_info">
                                <img src="{{ $cart_item->prodItem->image }}" alt="">
                                <a class="cart_product_name" href="{{ route('product.detail', $cart_item->product->id) }}">
                                    <p>{{ $cart_item->product->name }}</p>
                                    @foreach ($cart_item->prodItem->prodAttrVals() as $prodAttr)
                                        <span>{{ $prodAttr->value }}</span>
                                    @endforeach
                                </a>
                            </div>
                            <div class="cart_product_price">
                                <div class="price_default">
                                    {{ number_format($cart_item->product->max_price) }}₫
                                </div>
                                <div class="price_sale">
                                    {{ number_format($cart_item->product->max_price) }}₫
                                </div>
                            </div>
                            <div class="cart_product_qty">
                                <button type="button" class="quantity_btn" action="1">-</button>
                                <input name="quantity_input" type="number" value="{{ $cart_item->quantity }}" readonly
                                    min="1">
                                <button type="button" class="quantity_btn" action="2">+</button>
                            </div>
                            <div class="cart_product_price_total">
                                {{ number_format($cart_item->product->max_price * $cart_item->quantity) }}<u>đ</u>
                            </div>
                            <div class="cart_product_del">
                                <button class="del_action">Xóa</button>
                            </div>
                        </div>
                        <div class="cart_product_ship_info">
                            Tiến hành thanh toán để áp dụng nhiều mã khuyễn mãi từ shop
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="cart_bottom">
                <div class="cart_total">
                    <span class="total_label">Tổng thanh toán</span>
                    <span class="total_quantity">0</span> sản phẩm:
                    <span class="total_price">0</span><u>đ</u>
                </div>
                <button class="cart_payment_btn" id="cart_payment">
                    THANH TOÁN
                </button>
            </div>
        </section>
        <script type="text/javascript" src="{{ asset(mix('assets/js/cart.js')) }}"></script>
    @else
        <section class="cart_empty first_section" style="text-align: center;">
            <img src="{{ asset('image/cart/cart_empty.png') }}">
        </section>
    @endif
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.menu_bar').css('display', 'none');
        });

        function reduce($id) {
            document.location.href = "./reduceByOne/" + $id;
        }

        function increase($id) {
            document.location.href = "./plusByOne/" + $id;
        }
    </script>
@endsection
