{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- Page title --}}
@section('title','Chat')

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-chat.css')}}">
@endsection

{{-- main page content --}}
@section('content')
<div class="chat-application">
    <div class="chat-content-head">
        <div class="header-details">
            <h5 class="m-0 sidebar-title" onclick="playSound();"><i
                    class="material-icons app-header-icon text-top">mail_outline</i> Chat</h5>
        </div>
    </div>
    <div class="app-chat">
        <div class="content-area content-right">
            <div class="app-wrapper">
                <!-- Sidebar menu for small screen -->
                <a href="#" data-target="chat-sidenav" class="sidenav-trigger hide-on-large-only">
                    <i class="material-icons">menu</i>
                </a>
                <!--/ Sidebar menu for small screen -->

                <div class="card card card-default scrollspy border-radius-6 fixed-width">
                    <div class="card-content chat-content p-0">
                        <!-- Sidebar Area -->
                        <div class="sidebar-left sidebar-fixed animate fadeUp animation-fast">
                            <div class="sidebar animate fadeUp">
                                <div class="sidebar-content">
                                    <div id="sidebar-list"
                                        class="sidebar-menu chat-sidebar list-group position-relative">
                                        <div class="sidebar-list-padding app-sidebar sidenav" id="chat-sidenav">
                                            <!-- Sidebar Header -->
                                            <div class="sidebar-header">
                                                <div class="row valign-wrapper">
                                                    <div class="col s2 media-image pr-0">
                                                        <img src="{{asset('images/placeholders/user.png')}}" alt=""
                                                            class="circle z-depth-2 responsive-img">
                                                    </div>
                                                    <div class="col s10">
                                                        <p class="m-0 blue-grey-text text-darken-4 font-weight-700">
                                                            Dance 2 Beat</p>
                                                        <p class="m-0 info-text">Admin</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/ Sidebar Header -->

                                            <!-- Sidebar Search -->
                                            <div class="sidebar-search animate fadeUp">
                                                <div class="search-area" style="width: 100%;">
                                                    <i class="material-icons search-icon">search</i>
                                                    <input type="text" placeholder="Search Chat" class="app-filter"
                                                        id="chat_filter">
                                                </div>
                                            </div>
                                            <!--/ Sidebar Search -->

                                            <!-- Sidebar Content List -->
                                            <div class="sidebar-content sidebar-chat animate fadeUp"
                                                id="dialogsSidebar">
                                                <div class="chat-list">
                                                    @foreach ($dialogs as $item)
                                                        <div class="chat-user animate fadeUp delay-1"
                                                        id="dialogItem{{ $item->id }}" onclick="getDialogMessages({{ $item->id }});">
                                                        <div class="user-section">
                                                            <div class="row valign-wrapper">
                                                                <div class="col s2 media-image online pr-0">
                                                                    <img src="{{$item->account->profile->getProfileImage() ? asset($item->account->profile->getProfileImage()) : asset('images/placeholders/user.png') }}"
                                                                        alt="" class="circle z-depth-2 responsive-img">
                                                                </div>
                                                                <div class="col s10">
                                                                    <p
                                                                        class="m-0 blue-grey-text text-darken-4 font-weight-700">
                                                                        {{ $item->account->profile->fullName }}</p>
                                                                        @if ($item->messages()->count())
                                                                        <p
                                                                        class="m-0 info-text lastTextMessage{{$item->id}}">
                                                                        {{
                                                                        $item->messages()->orderBy('created_at',
                                                                        'desc')->first()->message }}</p>
                                                                        @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="info-section">
                                                            @if ($item->messages()->count())
                                                            <div class="star-timing">
                                                                <div class="time">
                                                                    <span id="lastMessageTime{{$item->id}}">{{
                                                                        $item->updated_at->format('g:i A') }}</span>
                                                                </div>
                                                            </div>
                                                            @endif

                                                            <span
                                                                class="badge badge pill red unreadMessagesCount{{$item->id}}"
                                                                @if(!$item->unreadMessages())
                                                                style="visibility: hidden; "
                                                                @endif
                                                                >{{
                                                                $item->unreadMessages() }}</span>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @if (!count($dialogs))
                                                <div class="no-data-found">
                                                    <h6 class="center">No Results Found</h6>
                                                </div>
                                                @endif
                                            </div>
                                            <!--/ Sidebar Content List -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Sidebar Area -->

                        <!-- Content Area -->
                        <div class="chat-content-area animate fadeUp" id="dialog-content-area">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/app-chat.js')}}"></script>
<script>
    var active = null;
    let getDialogMessages = (dialogId) => {
        let url = '{{ route("admin.chat.messages", ":id") }}';
        url = url.replace(':id', dialogId);

        activePlaySound();

        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                $('.unreadMessagesCount' + dialogId).hide();
                $('#dialog-content-area').html(response);
                $(".chat-area").scrollTop($(".chat-area > .chats").height());
                active = dialogId;
            }
        });
    };

    newMessageChannel.bind('App\\Events\\NewMessage', function (data) {
        let html = '<div class="chat"><div class="chat-avatar"><a class="avatar"><img src="' + data.accountImage + '" class="circle" alt="avatar" /></a></div><div class="chat-body">  <div class="chat-text">' + "<p>" + data.dialogMessage.message + "</p>" + "</div></div></div>";
        $("#activeChatArea" + data.dialog.id + ":last-child").append(html);
        $(".message").val("");
        $(".chat-area").scrollTop($(".chat-area > .chats").height());
        if (active != data.dialog.id) {
            reloadSidebar();
            playSound("{{ asset('tone/whatsapp.mp3') }}");
        } else {
            $(".lastTextMessage" + data.dialog.id).text(data.dialogMessage.message);
            $("#lastMessageTime" + data.dialog.id).text(data.lastMessageDate);
            readDialogMessage(data.dialog.id);
            $(".unreadMessagesMenu").text(data.allUnreadedMessages);
        }
    });

    let reloadSidebar = () => {
        let url = '{{ route("admin.chat.sidebar") }}';
        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                $('#dialogsSidebar').empty();
                $('#dialogsSidebar').html(response);
            }
        });
    }

    let readDialogMessage = (dialogId) => {
        let url = '{{ route("admin.chat.messages", ":id") }}';
        url = url.replace(':id', dialogId);

        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                return;
            }
        });
    }

    // Add message to chat
    let send = dialogId => {
        let url = "{{ route('admin.chat.send.message', ':id') }}";
        url = url.replace(':id', dialogId);

        let message = $(".message").val();

        let data = {
            "_token": "{{ csrf_token() }}",
            message: message,
        }

        if (message) {
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    let html = '<div class="chat chat-right"><div class="chat-body">  <div class="chat-text">' + "<p>" + message + "</p>" + "</div></div></div>";
                    $(".chats:last-child").append(html);
                    $(".message").val("");
                    $(".chat-area").scrollTop($(".chat-area > .chats").height());
                    $(".lastTextMessage" + dialogId).text(message);
                }
            });
        }
    };

    let playSound = (sound) => {
        var myAudio = new Audio(sound);
        myAudio.play();
    }

    let activePlaySound = () => {
        var myAudio = new Audio("{{ asset('tone/1-second-of-silence.mp3') }}");
        myAudio.play();
    }
</script>
@endsection
