<?php

namespace App\Http\Resources;

use App\Enums\NotificationType;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerNotification extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $notificationType = NotificationType::fromValue($this->type);

        return [
            'notification_id' => $this->id,
            'notification_title' => trim($this->title),
            'notification_content' => trim($this->content),
            'notification_is_read' => $this->is_read,
            'notification_created_at_readable' => $this->created_at->diffForHumans(),
            'notification_type' => [
                'name' => $notificationType->description,
                'key' => $notificationType->key,
                'value' => $notificationType->value
            ]
        ];
    }
}
