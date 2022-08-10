<div class="chat-list">
    @foreach ($dialogs as $item)
        <div class="chat-user animate fadeUp delay-1"
        id="dialogItem{{ $item->id }}"   onclick="getDialogMessages({{ $item->id }});">
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

<script>
    $('html, body').animate({
        scrollTop: $('.chat-list').offset().top - 20
    }, 'slow');
</script>
