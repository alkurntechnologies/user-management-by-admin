<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        //window.auth = {!!auth()->user()!!}
    </script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <meta name="twitter:card" content="summary_large_image">
    @if(@$rink->main_photo!='')
    <meta property="twitter:image" content="{{ URL::asset('storage/app') }}/{{@$rink->main_photo}}" />
    <meta property="og:image" content="{{ URL::asset('storage/app') }}/{{@$rink->main_photo}}" />
    @else
    <meta property="twitter:image" content="{{ URL::asset('/assets/front-end/images/default-img.jpg')}}" />
    <meta property="og:image" content="{{ URL::asset('/assets/front-end/images/default-img.jpg')}}" />
    @endif
    <meta property="og:title" content="{{config('app.name')}} | {{@$rink->rink_name}}" />
    <meta property="twitter:text" content="{!! @$rink->description !!}" />
    <meta property="og:description" content="{!! @$rink->description !!}" />
    <meta property="og:site_name" content="{{config('app.name')}}" />

    

    <title>{{env('APP_NAME')}}</title>

    <!-- <link rel="icon" type="image/png" sizes="45x45" href="{{ asset('/') }}/assets/frontend/images/logo.png"> -->

    <link rel="shortcut icon" href="{{ asset('/') }}/assets/front-end/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <link rel="shortcode icon" type="image/png" href="{{ asset('/') }}/assets/front-end/images/logo.png"/>
    <!-- Scripts -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> 

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto|Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet"> 
    

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/front-end/css/custom.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/front-end/css/custom_theme.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/front-end/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/front-end/css/bootstrap-select.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/front-end/css/animate.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}/assets/front-end/css/responsive.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" rel="stylesheet"/>
    
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <link href="{{asset('/assets/admin/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('/assets/admin/plugins/toastr/toastr.min.css') }}" rel="stylesheet"/>
          <!-- Styles -->
    <script src="{{ asset('/') }}/assets/front-end/js/jquery.min.js"></script>
    <script src="{{ asset('/') }}/assets/front-end/js/wow.min.js"></script>

    <script src="{{ URL::asset('/assets/admin/plugins/toastr/toastr.min.js') }}"></script>
    <script>
      new WOW().init();
    </script>

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5f4cb344dc8707001906e0e5&product=inline-share-buttons" async="async"></script>
    @yield('style')
</head>

@if(Auth::check())
<body class="{{Request::segment(1)}}-layout logedin">
@else
<body class="{{Request::segment(1)}}-layout">  
@endif
    
<!-- <body class="{{Request::segment(1)}}-layout "> -->