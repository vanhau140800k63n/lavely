@extends('layouts.master')
@section('content')
    <div id="content"></div>

    <script>
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "http://localhost:8005/" + "get_content_url",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            type: "POST",
            dataType: 'json',
            data: {
                url: "https://shopee.vn/TWS-Tai-Nghe-Bluetooth-Kh%C3%B4ng-D%C3%A2y-M10-Bluetooth-Dung-L%C6%B0%E1%BB%A3ng-Pin-L%E1%BB%9Bn-C%E1%BA%A3m-%E1%BB%A8ng-1-Ch%E1%BA%A1m-Ch%E1%BB%91ng-N%C6%B0%E1%BB%9Bc-i.1058254066.22984824449?sp_atk=e6d0987c-6f63-4a0a-9776-0865efbb7a12&xptdk=e6d0987c-6f63-4a0a-9776-0865efbb7a12",
                _token: _token
            }
        }).done(function(data) {
            $("#content").html(data);
        })
    </script>
@endsection
