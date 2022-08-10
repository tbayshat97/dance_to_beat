{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration --}}
@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
<!DOCTYPE html>
@php
$configData = Helper::applClasses();
@endphp
<!--
Template Name: Qiotic - Qiotic Admin Template
Author: Qiotic
Website: https://www.qiotic.com/
Contact: hello@qiotic.com
Follow: www.twitter.com/qiotic
Like: www.facebook.com/qiotic

-->
        <html lang="{{App::getLocale()}}" @if(App::getLocale()=='ar' ) dir="rtl" @endif>
        <!-- BEGIN: Head-->

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>@yield('title') | Dance 2 Beat</title>
            <link rel="apple-touch-icon" href="{{ asset('frontend/images/favicon.png') }}">
            <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/favicon.png') }}">
            <!-- Include core + vendor Styles -->
            @include('website.panels.styles')
        </head>
        <!-- END: Head-->
        <body>
            <div id="app">
                @include('website.panels.header')
                <!--  main content -->
                @yield('content')
                @include('website.panels.footer')
                @include('website.panels.bottom-menu')
            </div>
               
                {{-- vendor scripts and page scripts included --}}
                @include('website.panels.scripts')

        </body>

</html>
