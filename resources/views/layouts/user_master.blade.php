<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    @yield('meta')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- style -->
    <link rel="shortcut icon" href="{{ asset('source/img/logodevsnevn.png') }}" />
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">
    @yield('style')
    <!-- style -->

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="{{ asset('source/jquery-3.7.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset(mix('assets/js/domain.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(mix('assets/js/swal.js')) }}"></script>
    <script type="text/javascript" src="{{ asset(mix('assets/js/user_sidebar.js')) }}"></script>
    <script type="text/javascript">
        var _token = $('input[name="_token"]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('head_script')
    <!-- script -->
</head>

<body>
    @include('partials.header')
    <section class="user_detail first_section">
        @include('partials.user_sidebar')
        <div class="user_container">
            @yield('content')
        </div>
    </section>
    @include('partials.footer')
    @include('partials.menu')
</body>

</html>
