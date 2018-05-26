<?php

namespace App\Notifications;

use App\Article;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewArticleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    /**
     * @var \App\User
     */
    public $user;

    /**
     * @var \App\Article
     */
    public $article;

    /**
     * Create a new notification instance.
     *
     * @param \App\User $user
     * @param \App\Article $article
     */
    public function __construct(User $user,Article $article)
    {
        $this->user = $user;
        $this->article = $article;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast  '];
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
            ->subject('Verificación de correo electrónico')
            ->greeting("Hola {$notifiable->name}, Un último paso.")
            ->line("Solo necesitamos que confirmes tu dirección de correo electrónico para demostrar que eres humano. Lo entiendes, ¿verdad? Coo.")
            ->action('Confirmar correo electrónico', '' )
            ->line('¡Gracias por usar nuestra aplicación!');
    }

    public function toArray($notifiable)
    {
        return [
            'icon' => 'far fa-envelope',
            'subject' => 'Verificación de correo electrónico',
            'body' => "necesitamos que confirmes tu dirección de correo electrónico...",
            'url' => $this->article->slug,
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('User.'.$this->user->id);
    }

}
