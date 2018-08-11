<?php

namespace App\Notifications;

use App\Order;
use App\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RateArticleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    /**
     * @var \App\Order
     */
    public $order;

    /**
     * @var \App\Article
     */
    private $article;

    /**
     * Create a new notification instance.
     *
     * @param \App\Order $order
     * @param \App\Article $article
     */
    public function __construct(Order $order, Article $article)
    {
        $this->order = $order;
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
            ->subject("Danos tu opinion sobre {$this->order->article->name}")
            ->greeting("Hola {$notifiable->name}.")
            ->line("Cuéntale a los demás lo que piensas sobre {$this->order->article->name}. ¿Lo recomendarías y por qué?")
            ->action('Ver el enlace', $this->article->url->show)
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
            'icon' => 'fas fa-star-half-alt',
            'subject' => "Danos tu opinion sobre {$this->order->article->name}",
            'body' => "Cuéntale a los demás lo que piensas sobre {$this->order->article->name}. ¿Lo recomendarías y por qué?",
            'url' => $this->article->url->show,
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('User.'.$this->order->user->id);
    }
}
