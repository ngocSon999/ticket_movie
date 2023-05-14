<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- datatable-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- datatable-->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.13.4/sorting/date-dd-MMM-yyyy.js"></script>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/css/form.css') }}">
    @yield('style')
</head>
<body>
<div class="container" id="main">
    <div class="row mt-4">
        @include('admins.layouts.header')
    </div>
    <div class="row">
        <div class="col-md-2 d-none d-md-block mt-4">
            @section('sidebar')
                @include('admins.layouts.component.sidebar')
            @show
        </div>
        <div class="col-md-10 col-12">
            <div class="row d-flex justify-content-center mb-4">
                @include('admins.layouts.message')
            </div>
            <div class="row">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="row">
        @include('admins.layouts.footer')
    </div>
</div>
<script src="{{ asset('/admin/js/page-app.js') }}"></script>
@yield('js')
</body>
</html>
