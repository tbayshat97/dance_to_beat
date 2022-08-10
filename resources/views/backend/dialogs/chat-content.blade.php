<!-- Chat header -->
@php
$accountImage = $account->profile->getProfileImage() ? asset($account->profile->getProfileImage()) :
asset('images/placeholders/user.png');
@endphp
<div class="chat-header animate fadeUp">
    <div class="row valign-wrapper">
        <div class="col media-image online pr-0">
            <img src="{{ $accountImage }}" alt="" class="circle z-depth-2 responsive-img">
        </div>
        <div class="col">
            <p class="m-0 blue-grey-text text-darken-4 font-weight-700">{{ $account->profile->fullName }}</p>
            <p class="m-0 chat-text truncate">{{ $account->profile->bio }}</p>
        </div>
    </div>
    <span class="option-icon">
    </span>
</div>
<div class="chat-area animate fadeUp" style="overflow-y: visible; overflow-x: hidden;">
    <div class="chats" id="activeChatArea{{ $dialog->id }}">
        @foreach ($messages as $item)
        @if ($item->from_accountable_type === App\Models\User::class)
        <div class="chat chat-right">
            <div class="chat-body">
                <div class="chat-text">
                    <p>{{ $item->message }}</p>
                </div>
            </div>
        </div>
        @else
        <div class="chat">
            <div class="chat-avatar">
                <a class="avatar">
                    <img src="{{ $accountImage }}" class="circle" alt="avatar" />
                </a>
            </div>
            <div class="chat-body">
                <div class="chat-text">
                    <p>{{ $item->message }}</p>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
<!--/ Chat content area -->

<!-- Chat footer <-->
<div class="chat-footer">
    <form action="javascript:void(0);" class="chat-input">
        <input type="text" placeholder="Type message here.." class="message mb-0">
        <a class="btn waves-effect waves-light send" onclick="send({{ $dialog->id }});">Send</a>
    </form>
</div>
<!--/ Chat footer -->

<script>
    $(".chat-area").scrollTop($(".chat-area > .chats").height());
</script>
