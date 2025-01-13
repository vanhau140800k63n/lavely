@extends('layouts.master')
@section('meta')
    <meta name="description"
        content="DEVSNE là thương hiệu local brand độc quyền của được thành lập năm 2019, hoạt động trong lĩnh vực sản xuất, kinh doanh các sản phẩm thời trang nam nữ (áo thun nam, áo polo nam, áo thể thao nam, áo thun hình,...). Devsne sẽ đem lại cho khách hàng những trải nghiệm sản phẩm và phong cách thời trang được thiết kế cực đẹp, mang đến nhiều mẫu áo chất lượng cho nhiều độ tuổi khác nhau.">
    <meta name="keywords"
        content="devsne, devsnevn, quần áo devsne, giày devsne, DEVSNE.VN, thời trang nam nữ devsne, áo thun nam devsne, thời trang devsne, áo thun nam nữ, áo giá rẻ">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="https://devsne.vn/">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="website">
    <meta property="og:title" content="DEVSNE.VN - SNEAKERSHOP">
    <meta property="og:description"
        content="DEVSNE là thương hiệu local brand độc quyền của được thành lập năm 2019, hoạt động trong lĩnh vực sản xuất, kinh doanh các sản phẩm thời trang nam nữ (áo thun nam, áo polo nam, áo thể thao nam, áo thun in hình,...). Devsne sẽ đem lại cho khách hàng những trải nghiệm sản phẩm và phong cách thời trang được thiết kế cực đẹp, mang đến nhiều mẫu áo chất lượng cho nhiều độ tuổi khác nhau.">
    <meta property="og:url" content="https://devsne.vn/">
    <meta property="og:site_name" content="DEVSNE.VN">
    <meta property="article:publisher" content="https://www.facebook.com/devsne.official">
    <meta property="og:image" content="source/img/devsne-thoi-trang-nam-nu.jpg">
    <title>Trang chủ | Lavely</title>
@endsection
@section('content')
    <section class="first_section">

    </section>
    <section class="home_category">
        <h2 class="section_title">Danh mục</h2>
        <div class="home_categories">
            @foreach ($categories as $category)
                <a class="home_category_item" href="{{ route('search.category', ['categoryId' => $category->id]) }}">
                    <img src="{{ $category->image }}">
                    <p>{{ $category->name }}</p>
                </a>
            @endforeach
        </div>
    </section>
    <section class="">
        @foreach ($categories as $category)
            <h2 class="product_list_title">{{ $category->name }}</h2>
            <div class="product_list">
                @foreach ($products[$category->id] as $product)
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
        @endforeach
    </section>
@endsection
