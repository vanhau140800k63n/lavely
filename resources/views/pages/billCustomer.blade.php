@extends('master')
@section('meta')
    <meta name="robots" content="noindex, nofollow">
    <title>ĐƠN HÀNG | DEVSNE SHOP</title>
@endsection
@section('content')
@if(Session::has('order'))
<section class="container">
    <div class= "row">
        <div class="col-md-12">
            <br><br>
            <div class="panel panel-primary">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h4 style="font-weight: 700">ĐƠN HÀNG CỦA BẠN</h4>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="bootstrap-table">
                        <div class="table-responsive">
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
                                    @foreach(Session('order')->items as $key)
                                    <?php $bill = App\Models\Bill::where('id',$key['id'])->first(); 
                                    $customer = App\Models\Customer::where('id',$bill->id_customer)->first()
                                    ?>
                                    <tr>
                                        <td>{{$bill->id}}</td>
                                        <td style="max-width: 100px; overflow: hidden;">{{$customer->name}}</td>
                                        <td style="max-width: 300px; overflow: hidden;">{{$customer->address}}</td>
                                        <td>{{$bill->date_order}}</td>
                                        <td>{{$bill->payment}}</td>
                                        
                                        <td>
                                            @if($bill->status=='Chưa xử lý')
                                            <a class="btn btn-danger" style="width: 100%;"><i class="fa fa-ban" aria-hidden="true" style="padding-right: 10px;"></i>Chưa xử lý</a>
                                            @else
                                            <button type="button" class="btn btn-success" style="width: 100%;" ><i class="fa fa-check" aria-hidden="true" style="padding-right: 10px;"></i>Đã xử lý</button>
                                            @endif 
                                        </td>
                                        <td>
                                            <div style="text-align: center">
                                                <a href="{{route('billdetailcustomer',$bill->id)}}" class="btn btn-warning" ><i class="fa fa-fa-th-list" aria-hidden="true"></i>Chi tiết</a>
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
@endif
<script type="text/javascript">
    var menu_bar = document.querySelector('.menu_bar .list:nth-child(3)');
    menu_bar.classList.toggle("active");
</script>
@endsection
