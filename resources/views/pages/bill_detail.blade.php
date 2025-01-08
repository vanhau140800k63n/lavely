@extends('master')
@section('content')


<section class="payment spad">
    <div class="container">
        {{-- <div class="row">
            <div class="col-lg-12">
                <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                </h6>
            </div>
        </div> --}}
        <div class="payment_container" >
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <h4>Thông tin về khách hàng</h4>
                </div>
                <div class="col-lg-8 col-md-8">
                    <h4>Danh sách sản phẩm</h4>
                </div>
            </div>
            <form action="#" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="payment_input">
                                    <h5 class="mb-2">Họ và tên: {{$customer->name}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="payment_input">
                            <h5 class="mb-2">Địa chỉ: {{$customer->address}}</h5>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="payment_input">
                                    <h5 class="mb-2">Số điện thoại: {{$customer->phone_number}}</h5>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="payment_input">
                                    <h5>Hình thức thanh toán: {{$bill->payment}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="payment_input">
                                    <h5>Tổng thanh toán: {{$bill->total}}</h5>
                                </div>
                            </div>
                        </div>
                        <div>

                            <div class="col-lg-12" >
                                <div class="row">
                    
                                    <div class="col-lg-12" style="text-align: right">
                                        @if($bill->status=='Chưa xử lý')
                                        <a href="{{route('update-bill',$bill->id)}}" class="btn btn-danger" style="width: 100%;"><i class="fa fa-ban" aria-hidden="true" style="padding-right: 10px;"></i>Chưa xử lý</a>
                                        @else
                                        <button type="button" class="btn btn-success" style="width: 100%;" ><i class="fa fa-check" aria-hidden="true" style="padding-right: 10px;"></i>Đã xử lý</button>
                                        @endif
                                </div>
                                <div class="col-lg-7"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="payment_order">
                        <table class="table table-bordered" style="margin-top:20px; text-align: center;">
                            <thead>
                                <tr class="bg-primary">
                                    <th width="3%">ID</th>
                                    <th width="10%">Tên Sản phẩm</th>
                                    <th width="15%">Hình ảnh</th>
                                    <th width="10%">Giá</th>
                                    <th width="3%">Size</th>
                                    <th width="1%">Số lượng</th>
                                    <th width="10%">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($billDetail as $key)
                                <?php $product = App\Models\Product::where('id',$key->id_product)->first()
                                ?>
                                <tr>
                                    <td>{{$key->id}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>
                                        <div style="text-align: center">
                                            <img width="100px" src="{{$product->image}}" class="thumbnail">
                                        </div>
                                    </td>
                                    <td>{{number_format($key->price)}}<u>đ</u></td>
                                    <td>{{$key->size}}</td>
                                    <td>{{$key->quantity}}</td>
                                    <td>{{number_format($key->price*$key->quantity)}}<u>đ</u></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <!-- <h4>Tổng: {{number_format($bill->total)}}<u>đ</u></h4> -->
                        </table>
                        <div style="text-align: right">
                            <div class="row" style="display:inline-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</section>
@endsection
