<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NouveauMessage extends Notification
{
    use Queueable;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'nouveau_message',
            'titre' => 'Nouveau message',
            'message' => "{$this->message->expediteur->name} vous a envoyé un message.",
            'message_id' => $this->message->id,
            'url' => route('messages.show', $this->message->conversation_id ?? $this->message->id),
            'icon' => 'bi-chat-dots',
            'color' => 'info',
        ];
    }
}