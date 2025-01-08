@extends('pages.admin.layouts.master')
@section('head')
    <title> Voucher List </title>
@endsection
@section('content')
    <div class="content-wrapper">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form class="row" method="POST"
            action="{{ isset($voucher) ? route('admin.voucher.update', $voucher->id) : route('admin.voucher.create') }}">
            @csrf
            @if (isset($voucher))
                @method('PUT')
            @endif

            <div class="admin_action_btn">
                <a href="{{ route('admin.voucher.list') }}" class="btn btn-warning" style="margin-right: 10px">
                    Trở lại
                </a>
                <button class="btn btn-primary" type="submit">
                    {{ isset($voucher) ? 'Cập nhật' : 'Lưu' }}
                </button>
            </div>

            <div class="voucher_form">
                <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" id="code" name="code"
                        value="{{ $voucher->code ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ $voucher->description ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="shipping" {{ isset($voucher) && $voucher->type == 'shipping' ? 'selected' : '' }}>
                            Shipping</option>
                        <option value="product" {{ isset($voucher) && $voucher->type == 'product' ? 'selected' : '' }}>
                            Product</option>
                        <option value="order" {{ isset($voucher) && $voucher->type == 'order' ? 'selected' : '' }}>Order
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="discount_type">Discount Type</label>
                    <select class="form-control" id="discount_type" name="discount_type" required>
                        <option value="fixed"
                            {{ isset($voucher) && $voucher->discount_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        <option value="percent"
                            {{ isset($voucher) && $voucher->discount_type == 'percent' ? 'selected' : '' }}>Percent
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="discount_amount">Discount Amount</label>
                    <input type="number" class="form-control" id="discount_amount" name="discount_amount" step="0.01"
                        value="{{ $voucher->discount_amount ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="minimum_spend">Minimum Spend</label>
                    <input type="number" class="form-control" id="minimum_spend" name="minimum_spend" step="0.01"
                        value="{{ $voucher->minimum_spend ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="maximum_discount">Maximum Discount</label>
                    <input type="number" class="form-control" id="maximum_discount" name="maximum_discount" step="0.01"
                        value="{{ $voucher->maximum_discount ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity"
                        value="{{ $voucher->quantity ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                        value="{{ isset($voucher) ? $voucher->start_date : '' }}" required>
                </div>

                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                        value="{{ isset($voucher) ? $voucher->end_date : '' }}" required>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" {{ isset($voucher) && $voucher->status == 'active' ? 'selected' : '' }}>
                            Active</option>
                        <option value="expired" {{ isset($voucher) && $voucher->status == 'expired' ? 'selected' : '' }}>
                            Expired</option>
                        <option value="used" {{ isset($voucher) && $voucher->status == 'used' ? 'selected' : '' }}>Used
                        </option>
                    </select>
                </div>
            </div>
        </form>
    </div>
@endsection
