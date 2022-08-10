{{-- pageConfigs variable pass to Helper's updatePageConfig function to update page configuration --}}
@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
@php
// confiData variable layoutClasses array in Helper.php file.
$configData = Helper::applClasses();
@endphp

<html class="loading"
    lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
    data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}">
<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Artist Panel </title>
    <link rel="apple-touch-icon" href="{{asset('images/favicon/apple-touch-icon-152x152.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon/favicon-32x32.png')}}">

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('953b01093493a984b9ea', {
            cluster: 'mt1'
        });

        var newMessageChannel = pusher.subscribe('new-admin-message');
    </script>
    @include('panels-artist.styles')
</head>

@if(!empty($configData['mainLayoutType']) && isset($configData['mainLayoutType']))
@include(($configData['mainLayoutType'] === 'horizontal-menu') ?
'layouts-artist.horizontalLayoutMaster':'layouts-artist.verticalLayoutMaster')
@else
{{-- if mainLaoutType is empty or not set then its print below line --}}
<h1>{{'mainLayoutType Option is empty in config custom.php file.'}}</h1>
@endif
<script>
    newMessageChannel.bind('App\\Events\\NewMessageAdmin', function (data) {
        auth = "{{ auth('artist')->user()->id }}";
        if(data.authUserId == auth)
        {
            $(".unreadMessagesMenu").text(data.allUnreadedMessages);
            M.toast({
                html: "New message arrived.",
            })
        }
    });
</script>
</html>
