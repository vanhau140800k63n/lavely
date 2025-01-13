@extends('layouts.master')
@section('meta')
    <title> {{ $keyword }} | Lavely</title>
@endsection

@section('content')
    <section class="first_section">
        <nav class="categorie">
            <a href="{{ route('home') }}"> Trang chủ </a>
            <img src={{ asset('image/common/right_arrow.svg') }}>
            <p>{{ $keyword }}</p>
        </nav>

        <nav class="filter_container">
            @php
                $routeName = 'search.keyword';
                $routeParams = [];

                if ($searchInfo['type'] === 'brand') {
                    $routeName = 'search.brand';
                    $routeParams = ['brandId' => $searchInfo['info']->id];
                } elseif ($searchInfo['type'] === 'category') {
                    $routeName = 'search.category';
                    $routeParams = ['categoryId' => $searchInfo['info']->id];
                } elseif ($searchInfo['type'] === 'shop') {
                    $routeName = 'search.shop';
                    $routeParams = ['shopId' => $searchInfo['info']->id];
                }

                $currentPriceSort = $searchInfo['price'] ?? null;
                $currentSoldSort = $searchInfo['sold'] ?? null;
                $currentRatedSort = $searchInfo['rated'] ?? null;

                $baseQuery = array_filter(
                    $searchInfo,
                    function ($value, $key) {
                        return !in_array($key, ['price', 'sold', 'rated', 'type', 'info']);
                    },
                    ARRAY_FILTER_USE_BOTH,
                );

                if ($searchInfo['type'] === 'keyword') {
                    $baseQuery['keyword'] = $searchInfo['info'];
                }
            @endphp

            <a class="filter_item {{ $currentPriceSort ? 'active' : '' }}"
                href="{{ route($routeName, $routeParams) . '?' . http_build_query(array_merge($baseQuery, ['price' => $currentPriceSort === 'asc' ? 'desc' : 'asc'])) }}">
                <p>Giá bán</p>
                <img src="{{ asset('image/filter/' . ($currentPriceSort === 'asc' ? 'asc.svg' : 'desc.svg')) }}"
                    alt="{{ $currentPriceSort === 'asc' ? 'Ascending' : 'Descending' }}">
            </a>

            <a class="filter_item {{ $currentSoldSort ? 'active' : '' }}"
                href="{{ route($routeName, $routeParams) . '?' . http_build_query(array_merge($baseQuery, ['sold' => $currentSoldSort === 'asc' ? 'desc' : 'asc'])) }}">
                <p>Lượt bán</p>
                <img src="{{ asset('image/filter/' . ($currentSoldSort === 'asc' ? 'asc.svg' : 'desc.svg')) }}"
                    alt="{{ $currentSoldSort === 'asc' ? 'Ascending' : 'Descending' }}">
            </a>

            <a class="filter_item {{ $currentRatedSort ? 'active' : '' }}"
                href="{{ route($routeName, $routeParams) . '?' . http_build_query(array_merge($baseQuery, ['rated' => $currentRatedSort === 'asc' ? 'desc' : 'asc'])) }}">
                <p>Đánh giá</p>
                <img src="{{ asset('image/filter/' . ($currentRatedSort === 'asc' ? 'asc.svg' : 'desc.svg')) }}"
                    alt="{{ $currentRatedSort === 'asc' ? 'Ascending' : 'Descending' }}">
            </a>
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
