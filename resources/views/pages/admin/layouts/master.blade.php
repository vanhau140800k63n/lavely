<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head')
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/admin/lib/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/lib/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

    <script src="{{ asset('js/assets/jquery.min.js') }}"></script>
</head>

<body>
    <?php
    $user = \Illuminate\Support\Facades\Auth::user();
    ?>
    <div class="container-scroller">
        @include('pages.admin.partials.sidebar')
        <div class="container-fluid page-body-wrapper">
            @include('pages.admin.partials.navbar')
            <div class="main-panel">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/admin/lib/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/admin/lib/js/misc.js') }}"></script>
    <script src="{{ asset('assets/admin/lib/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/admin/lib/vendors/select2/select2.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>

</html>
