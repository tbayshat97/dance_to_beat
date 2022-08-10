{{-- layout extend --}}
@extends('layouts-artist.contentLayoutMaster')

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
            <h5 class="m-0 sidebar-title"><i
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

    $(document).ready(function () {
        dialogId = "{{ $dialog->id  }}"
        getDialogMessages(dialogId);
    });

    var active = null;
    let getDialogMessages = (dialogId) => {
        let url = '{{ route("artist.chat.messages", ":id") }}';
        url = url.replace(':id', dialogId);

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

    newMessageChannel.bind('App\\Events\\NewMessageAdmin', function (data) {
        auth = "{{ auth('artist')->user()->id }}";
        if(data.authUserId == auth)
        {
            let html = '<div class="chat"><div class="chat-avatar"><a class="avatar"><img src="' + data.accountImage + '" class="circle" alt="avatar" /></a></div><div class="chat-body">  <div class="chat-text">' + "<p>" + data.dialogMessage.message + "</p>" + "</div></div></div>";
            $("#activeChatArea" + data.dialog.id + ":last-child").append(html);
            $(".message").val("");
            $(".chat-area").scrollTop($(".chat-area > .chats").height());
        }
    });

    // Add message to chat
    let send = dialogId => {
        let url = "{{ route('artist.chat.send.message', ':id') }}";
        url = url.replace(':id', dialogId);

        let message = $(".message").val();

        let data = {
            "_token": "{{ csrf_token() }}",
            message: message,
        }

        if (message) {
            let html = '<div class="chat chat-right"><div class="chat-body">  <div class="chat-text">' + "<p>" + message + "</p>" + "</div></div></div>";
                    $(".chats:last-child").append(html);

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    $(".message").val("");
                    $(".chat-area").scrollTop($(".chat-area > .chats").height());
                    $(".lastTextMessage" + dialogId).text(message);
                }
            });
        }
    };
</script>
@endsection
