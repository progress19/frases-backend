<?php
use App\Config;
use App\Fun;
use App\Helpers\Helpers;
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js bg-black">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow">
    <!-- for open graph social media -->
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <!-- for twitter sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="">
    <meta name="twitter:description" content="">
    <!-- favicon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- title -->
    <title>Frases</title>

    <!-- icon font from flaticon -->
    <link rel="stylesheet" href="{{ asset('css/front_css/styles.css') }}">

    <link href="{{ asset('css/front_css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/brands.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/solid.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="/site.webmanifest">

    

</head>

<body class="bg-[#2B2B2B]">

    @yield('content')

</body>

@yield('page-js-script')

</html>
