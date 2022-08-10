<?php

namespace App\Events;

use App\Models\DialogMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageAdmin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dialog;
    public $dialogMessage;
    public $accountImage;
    public $lastMessageDate;
    public $unreadMessagesCount;
    public $allUnreadedMessages;
    public $authUserId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->dialog = $data['dialog'];
        $this->dialogMessage = $data['dialogMessage'];
        $this->accountImage = $data['accountImage'];
        $this->lastMessageDate = $data['lastMessageDate'];
        $this->unreadMessagesCount = $data['unreadMessagesCount'];
        $this->allUnreadedMessages = DialogMessage::allAdminUnreadedMessagesCount();
        $this->authUserId = $data['authUserId'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('new-admin-message');
    }
}
