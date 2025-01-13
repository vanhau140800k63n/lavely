@extends('layouts.master')
@section('meta')
@endsection

@section('content')
    <section class="first_section">
        <nav class="categorie">
            <a href="{{ route('home') }}"> Trang chủ </a>
            <img src={{ asset('image/common/right_arrow.svg') }}>
            <p>{{ $keyWord }}</p>
        </nav>
        <div class="product_list">
            @foreach ($products as $product)
                <a class="product_container" href="{{ route('product.detail', $product->id) }}">
                    <div class="product_card">
                        <p class="ribbon_shop">{{ $product->shop->name }}</p>
                        <div class="ribbon_sale">
                            <p>10% Giảm</p>
                        </div>
                        <img src="{{ $product->image_url() }}" alt="" class="product_img">
                        <div class="product_content">
                            <div class="product_title">
                                {{ $product->name }}
                            </div>
                            <div class="product_bottom">
                                <div class="product_price">
                                    <div class="price_default">
                                        {{ number_format($product->selling_price) }}₫
                                    </div>
                                    <div class="price_sale">
                                        {{ number_format($product->max_price) }}₫
                                    </div>
                                </div>
                                <div class="product_rating">
                                    @if ($product->rate > 0)
                                        <div class="number_rated">{{ $product->rate }}</div>
                                        <div class="star_rated">
                                            @for ($i = 1; $i <= $product->rate; ++$i)
                                                <i class="fa fa-star"></i>
                                            @endfor
                                            @if ($product->rate - $i + 1 > 0)
                                                <i class="fa fa-star-half-stroke"></i>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="sold_qty">| Đã bán {{ $product->sold }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
