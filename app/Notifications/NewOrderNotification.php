<?php

namespace App\Notifications;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    /**
     * @var \App\Order
     */
    public $order;

    /**
     * Create a new notification instance.
     *
     * @param \App\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
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
            ->subject("[{$this->order->website->name}] Nuevo articulo")
            ->greeting("Hola {$notifiable->name}.")
            ->line("El client {$this->order->user->name}, ordeno el articulo {$this->order->article->name}")
            ->action('Ver la orden', '#')
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
            'icon' => 'fas fa-shipping-fast',
            'subject' => 'Nueva orden',
            'body' => "{$this->order->user->name},  Ha realizado un pedido.",
            'url' => '',
        ];
    }
}
