<?php

namespace App\Notifications;

use App\Conversation;
use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewClientMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    /**
     * @var \App\Conversation
     */
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
            ->subject("{$this->conversation->user->name} te envió un mensaje")
            ->greeting("Hola {$notifiable->name}.")
            ->line("El client {$this->conversation->user->name}, te envió el siguiente mensaje:")
            ->line("{$this->message->message}")
            ->action('Ver el mensaje', route('client.message', $this->conversation->website))
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
            'icon' => 'fas fa-comments',
            'subject' => "{$this->conversation->user->name} te envió un mensaje",
            'body' => "Para ver más detalles, haga clic aquí",
            'url' => route('client.message', $this->conversation->website),
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('User.'.$this->conversation->website->user->id);
    }
}
