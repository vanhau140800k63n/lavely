@extends('layouts.master')
@section('meta')
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="author" content="{{ $product->shop->name }}">
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $productImages->first()->url }}">
    <meta property="og:url" content="{{ route('product.detail', $product->id) }}">
    <meta property="og:type" content="product">
    <link rel="canonical" href="{{ route('product.detail', $product->id) }}">
    <title> {{ $product->name }} | Lavely</title>
@endsection

@section('content')
    <section class="product_detail first_section" product_id="{{ $product->id }}">
        <nav class="categorie">
            <a href="{{ route('home') }}"> Trang chủ </a>
            <img src={{ asset('image/common/right_arrow.svg') }}>
            <a href="{{ route('search.category', ['categoryId' => $product->category->id]) }}">{{ $product->category->name }}</a>
            <img src={{ asset('image/common/right_arrow.svg') }}>
            <p class="categorie_product_name" href="">{{ $product->name }}</p>
        </nav>
        <div class="info">
            <div class="product_image">
                <img class="image_detail" src="{{ $productImages->first()->url }}" alt="">
                <div class="image_slider owl-carousel">
                    @foreach ($productImages as $key)
                        <img class="image_slider_item" data-imgbigurl="{{ $key->url }}" src="{{ $key->url }}">
                    @endforeach
                </div>
            </div>
            <div class="product_detail_contain">
                <h1> {{ $product->name }}</h1>

                <div class="price">
                    <div class="default">
                        {{ number_format($product->selling_price) }} ₫
                    </div>
                    <div class="sale">
                        {{ number_format($product->max_price) }} ₫
                    </div>
                </div>

                @if ($product->rate > 0)
                    <div class="rated">
                        <div class="star_rated">
                            @for ($i = 1; $i <= $product->rate; ++$i)
                                <i class="fa fa-star"></i>
                            @endfor
                            @if ($product->rate - $i + 1 > 0)
                                <i class="fa fa-star-half-stroke"></i>
                            @endif
                        </div>
                        <div class="number_rated">{{ $product->rate }} / 5</div>
                    </div>
                @endif

                <div class="sold">
                    <h4 class="product_attr_name">Đã bán</h4>
                    <span> {{ $product->sold }} sản phẩm </span>
                </div>

                @if ($prodAttr->count() > 0)
                    @foreach ($prodAttr as $prodAttrItem)
                        <div class="product_attr">
                            <h4 class="product_attr_name">{{ $prodAttrItem->name }}</h4>
                            <div class="product_attr_val">
                                @foreach ($prodAttrItem->values as $prodAttrValItem)
                                    <div class="form_check">
                                        <input type="radio" name="attr_{{ $prodAttrItem->id }}"
                                            id="attr_val_{{ $prodAttrValItem->id }}" value="{{ $prodAttrValItem->id }}"
                                            class="form_check_input" @if ($loop->first) checked @endif>
                                        <label class="form_check_label" for="attr_val_{{ $prodAttrValItem->id }}">
                                            {{ $prodAttrValItem->value }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="product_detail_btn">
                    <div class="quantity">
                        <button type="button" class="dec quantity_btn">-</button>
                        <input id="quantity_input" type="number" value="1" min="1" readonly>
                        <button type="button" class="inc quantity_btn">+</button>
                    </div>
                    <button type="submit" class="add_btn" id="add_to_cart">THÊM VÀO GIỎ</button>
                </div>
                <button class="buy_btn" id="buy_now" href="" target="_blank">Mua ngay</button>
            </div>
        </div>
    </section>

    <section class="product_detail_supplier">
        <a class="shop" href="{{ route('search.shop', ['shopId' => $product->shop->id]) }}">
            <img src="{{ $product->shop->image }}">
            <div class="info">
                <h4 class="name">{{ $product->shop->name }}</h4>
                <div class="product_total"><span>{{ $product->shop->product_count }}</span> sản phẩm</div>
                <div class="sold"><span>{{ $product->shop->sold_count }}</span> đã bán</div>
            </div>
        </a>
        <div class="other_info">
            @if ($product->brand)
                <div class="info">
                    <div class="title">Thương hiệu</div>
                    <a class="content" href="{{ route('search.brand', ['brandId' => $product->brand->id]) }}">{{ $product->brand->name }}</a>
                </div>
            @endif
            @if ($product->category)
                <div class="info">
                    <div class="title">Danh mục</div>
                    <a class="content" href="{{ route('search.category', ['categoryId' => $product->category->id]) }}">{{ $product->category->name }}</a>
                </div>
            @endif
        </div>
    </section>

    <section class="product_description">
        <h2 class="title"> Mô tả sản phẩm </h2>
        <pre class="content">{!! $product->description !!}</pre>
    </section>


    {{-- <section class="related-product">
        <div class="container">
            <div class="related__product__title">
                <h2>SẢN PHẨM TƯƠNG TỰ</h2>
            </div>
            <div class="row">
                <div class="product_list">

                </div>
            </div>
        </div>
    </section> --}}
    <script type="text/javascript" src="{{ asset(mix('assets/js/product_detail.js')) }}"></script>
@endsection
