@extends('pages.admin.layouts.master')
@section('head')
    <title> Voucher List </title>
@endsection
@section('content')
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between;">
                        <h4 class="card-title">Post</h4>
                        <a class="btn btn-primary" style="display: flex; align-items: center; justify-content: center;"
                            href="{{ route('admin.voucher.create') }}"> Thêm </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="10%"> ID </th>
                                    <th width="70%"> Tên </th>
                                    <th width="10%"> </th>
                                    <th width="10%"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $voucher)
                                    <tr>
                                        <td> {{ $voucher->id }} </td>
                                        <td> {{ $voucher->code }} </td>
                                        <td> <a class="btn btn-info"
                                                style="display: flex; align-items: center; justify-content: center;"
                                                href="{{ route('admin.voucher.update', $voucher->id) }}">Sửa</a>
                                        </td>
                                        <td> <a class="btn btn-danger"
                                                style="display: flex; align-items: center; justify-content: center;"
                                                href="">Xóa</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
