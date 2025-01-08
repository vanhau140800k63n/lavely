<div class="menu_bar">
    <div class="menu_item">
        <a href="">
            <span class="text">Trang Chủ</span>
        </a>
    </div>
    <div class="menu_item">
        <a href="{{ route('user.purchase') }}">
            <img class="h_u_svg" src="{{ asset(mix('image/header/order.svg')) }}">
        </a>
    </div>
    <div class="menu_item">
        <a href="{{ route('cart.detail') }}">
            <img class="h_u_svg" src="{{ asset(mix('image/header/cart.svg')) }}">
            @if (session()->has('cart_quantity') && session('cart_quantity') > 0 )
                <div class="h_u_quantity">{{ session('cart_quantity') < 100 ? session('cart_quantity') : 99 }}</div>
            @endif
        </a>
    </div>
    <div class="menu_item">
        <a href="{{ route('user.info') }}">
            <img class="h_u_svg"
                src="{{ Auth::check() ? asset(mix('image/header/user.svg')) : asset(mix('image/header/login.svg')) }}">
        </a>
    </div>
</div>
