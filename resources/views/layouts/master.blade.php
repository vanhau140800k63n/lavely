<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    @yield('meta')
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- style -->
    <link rel="shortcut icon" href="source/img/logodevsnevn.png" />
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- style -->

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('source/css/owl.carousel.min.css') }}" type="text/css">
    <!-- Css Styles -->

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="{{ asset('source/jquery-3.7.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('source/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset(mix('assets/js/domain.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(mix('assets/js/swal.js')) }}"></script>
    <script type="text/javascript">
        var _token = $('input[name="_token"]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- script -->
</head>

<body>

    @include('partials.header')
    @yield('content')
    @include('partials.footer')
    @include('partials.menu')

</body>

</html>
