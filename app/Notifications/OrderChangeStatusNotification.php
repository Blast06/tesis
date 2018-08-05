<?php

namespace App\Notifications;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderChangeStatusNotification extends Notification implements ShouldQueue
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
            ->subject("Orden No. [{$this->order->id}], ha cambiado su estado.")
            ->greeting("Hola {$notifiable->name}.")
            ->line("El vendedor {$this->order->website->name}, cambio el estado de tu orden a {$this->order->status}")
            ->action('Ver la orden', url('/orders'))
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
            'subject' => 'Cambio de estado del pedido',
            'body' => "{$this->order->id},  Ha cambiado el estado por {$this->order->status}.",
            'url' => url('/orders'),
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('User.'.$this->order->user->id);
    }

}
