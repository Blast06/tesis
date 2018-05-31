<?php

namespace App\Notifications;

use App\{Article, User};
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
    public function __construct(User $user, Article $article)
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
            ->subject("[{$this->article->website->name}] Nuevo articulo")
            ->greeting("Hola {$notifiable->name}.")
            ->line("{$this->article->website->name}, añadido un nuevo articulo {$this->article->name}")
            ->action('Ver el articulo', $this->article->url->article)
            ->line('¡Gracias por usar nuestra aplicación!');
    }

    public function toArray($notifiable)
    {
        return [
            'icon' => 'fas fa-newspaper',
            'subject' => 'Nuevo articulo',
            'body' => "{$this->article->website->name},  Ha a añadido un nuevo articulo.",
            'url' => $this->article->url->article,
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('User.'.$this->user->id);
    }

}
