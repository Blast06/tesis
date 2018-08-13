<?php

namespace App\Notifications;

use App\Message;
use App\Conversation;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewWebsiteMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $conversation;

    public $message;

    /**
     * Create a new notification instance.
     *
     * @param \App\Conversation $conversation
     * @param \App\Message $message
     */
    public function __construct(Conversation $conversation, Message $message)
    {
        $this->conversation = $conversation;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("{$this->conversation->website->name} te envió un mensaje")
            ->greeting("Hola {$notifiable->name}.")
            ->line("{$this->conversation->website->name}, te envió el siguiente mensaje:")
            ->line("{$this->message->message}")
            ->action('Ver el mensaje', route('messages.index'))
            ->line('¡Gracias por usar nuestra aplicación!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'icon' => 'far fa-comment',
            'subject' => "{$this->conversation->website->name} te envió un mensaje",
            'body' => "Para ver más detalles, haga clic aquí",
            'url' => route('messages.index'),
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('User.'.$this->conversation->user->id);
    }
}
