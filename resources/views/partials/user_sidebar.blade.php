<nav class="user_sidebar">
    <ul>
        <li>
            <div class="main_menu"><img src="{{ asset(mix('image/sidebar/profile.svg')) }}"> Hồ sơ</div>
            <ul>
                <li>
                    <a href="{{ route('user.info') }}" class="sub_menu">
                        <img src="{{ asset(mix('image/sidebar/info.svg')) }}"> Thông tin
                    </a>
                </li>
                <li><a href="{{ route('user.address.page') }}" class="sub_menu"><img
                            src="{{ asset(mix('image/sidebar/address.svg')) }}">
                        Địa chỉ</a></li>
                <li><a href="{{ route('user.change_password') }}" class="sub_menu"><img
                            src="{{ asset(mix('image/sidebar/change_password.svg')) }}"> Đổi mật khẩu</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('user.purchase') }}" class="main_menu"><img
                    src="{{ asset(mix('image/sidebar/purchase.svg')) }}">
                Đơn hàng</a>
        </li>
        <li>
            <a href="{{ route('user.voucher.page') }}" class="main_menu"><img
                    src="{{ asset(mix('image/sidebar/voucher.svg')) }}"> Voucher</a>
        </li>
        <li>
            <a href="{{ route('logout') }}" class="main_menu"><img src="{{ asset(mix('image/sidebar/logout.svg')) }}">
                Đăng xuất</a>
        </li>
    </ul>
</nav>
