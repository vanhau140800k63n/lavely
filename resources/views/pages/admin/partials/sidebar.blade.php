<style>
    .sidebar .nav.sub-menu .nav-item .nav-link:hover {
        transform: scale(1.05);
        transition: 0.2s;
    }
</style>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle " src="{{ asset('assets/admin/lib/images/face.png') }}"
                            alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ $user->name }}</h5>
                        <span>Admin</span>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.product.page') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-view-list"></i>
                </span>
                <span class="menu-title">Sản phẩm</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('admin.voucher.list') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-ticket-percent"></i>
                </span>
                <span class="menu-title">Mã khuyến mãi</span>
            </a>
        </li>
    </ul>
</nav>
