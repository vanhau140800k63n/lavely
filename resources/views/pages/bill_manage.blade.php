@extends('master')
@section('content')

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading" style="font-weight: 700"> CTV SITE</div>
        <div class="list-group list-group-flush">
            <a href="./createbill" class="list-group-item list-group-item-action bg-light">TẠO ĐƠN</a>
            <a href="{{ Auth::user()->role == 'admin' ? route('bill') : route('billctv',Auth::user()->id) }}" class="list-group-item list-group-item-action bg-light">ĐƠN HÀNG</a>
            @if(Auth::user()->role == 'admin')
            <a href="./listproduct" class="list-group-item list-group-item-action bg-light">SẢN PHẨM</a>
            @endif
            @if(Auth::user()->role == 'managectv' || Auth::user()->role == 'ctv')
            <a href="./listproductctv" class="list-group-item list-group-item-action bg-light">SẢN PHẨM</a>
            @endif
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'managectv')
            <a href="./listctv" class="list-group-item list-group-item-action bg-light">QUẢN LÝ CTV</a>
            @endif
            <a href="./ctvinfo" class="list-group-item list-group-item-action bg-light">CTV INFO</a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <!-- <button class="btn btn-primary" id="menu-toggle" style="background-color: #000000; height: 20px;"> </button> -->
            <i class="fa fa-address-card" id="menu-toggle" style="cursor: pointer;"></i>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle menu_bar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{Auth::user()->full_name}}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="./ctvinfo">Thông tin</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="./logout">Đăng xuất</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <section class="container">
            <div class= "row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <br><br>
                    <div class="panel panel-primary">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title">
                                    <h4>Danh sách đơn hàng</h4>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="bootstrap-table">
                                <div class="table-responsive">
                            <!-- <div class="row">
                                <div class="col-lg-4">

                                </div>
                                <div class="col-lg-8" style="text-align: center;">

                                </div>
                            </div> -->
                            <table class="table table-bordered" style="margin-top:20px; text-align: center;">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="15%">Khách hàng</th>
                                        <th width="15%">Địa chỉ</th>
                                        <th width="10%">Ngày đặt</th>
                                        <th width="10%">Hình thức vận chuyển</th>
                                        <th width="10%">Trạng thái</th>
                                        <th width="10%">Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bill as $key)
                                    <?php $customer = App\Models\Customer::where('id',$key->id_customer)->first() ?>
                                    <tr>
                                        <td>{{$key->id}}</td>
                                        <td style="max-width: 100px; overflow: hidden;">{{$customer->name}}</td>
                                        <td style="max-width: 300px; overflow: hidden;">{{$customer->address}}</td>
                                        <td>{{$key->date_order}}</td>
                                        <td>{{$key->payment}}</td>
                                        
                                        <td>
                                            @if($key->status=='Chưa xử lý')
                                            <a href="{{route('update-bill',$key->id)}}" class="btn btn-danger" style="width: 100%;"><i class="fa fa-ban" aria-hidden="true" style="padding-right: 10px;"></i>Chưa xử lý</a>
                                            @else
                                            <button type="button" class="btn btn-success" style="width: 100%;" ><i class="fa fa-check" aria-hidden="true" style="padding-right: 10px;"></i>Đã xử lý</button>
                                            @endif 
                                        </td>
                                        <td>
                                            <div style="text-align: center">
                                                <a href="{{route('bill-detail',$key->id)}}" class="btn btn-warning" ><i class="fa fa-fa-th-list" aria-hidden="true"></i>Chi tiết</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="text-align: right">
                            <div class="row" style="display:inline-block">

                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<!-- /#page-content-wrapper -->

</div>
@endsection

@section('script')
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        // if($("#menu-toggle").text() == 'Thu gọn') {
        //  $("#menu-toggle").text('Mở rộng');
        // } else {
        //  $("#menu-toggle").text('Thu gọn');
        // }
    });
</script>
@endsection

