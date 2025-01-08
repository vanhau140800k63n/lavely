<header>
    <a class="header_logo" href="{{ route('home') }}">
        <img src="{{ asset(mix('image/logo/header_logo.png')) }}" alt="DEVSNE.VN">
    </a>
    <div class="header_search">
        <input type="text" class="search_input" placeholder="Tìm kiếm" id="search_input">
        <button class="search_btn">Tìm kiếm</button>
        <div class="search_dropdown" id="search_suggestions">
            <ul>

            </ul>
        </div>
        <div class="search-blur">
        </div>
    </div>
    <div class="header_utils">
        <a class="h_u_item" href="{{ route('user.purchase') }}">
            <img class="h_u_svg" src="{{ asset(mix('image/header/order.svg')) }}">
            <div class="h_u_i_name"> Đơn hàng</div>
        </a>
        <div class="h_u_item">
            <img class="h_u_svg" src="{{ asset(mix('image/header/notification.svg')) }}">
        </div>
        <a class="h_u_item" href="{{ route('cart.detail') }}">
            <img class="h_u_svg" src="{{ asset(mix('image/header/cart.svg')) }}">
            @if (session()->has('cart_quantity') && session('cart_quantity') > 0 )
                <div class="h_u_quantity">{{ session('cart_quantity') < 100 ? session('cart_quantity') : 99 }}</div>
            @endif
        </a>
        <a class="h_u_item" href="{{ route('user.info') }}">
            <img class="h_u_svg"
                src="{{ Auth::check() ? asset(mix('image/header/user.svg')) : asset(mix('image/header/login.svg')) }}">
        </a>
    </div>
</header>
