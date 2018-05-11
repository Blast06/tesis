<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PleaseConfirmYourEmail extends Notification implements ShouldQueue
{

    use Queueable;

    /**
     * @var \App\Models\User
     */
    public $user;

    public $tries = 5;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
            ->greeting("Hola {$this->user->name}, Un último paso.")
            ->line("Solo necesitamos que confirmes tu dirección de correo electrónico para demostrar que eres humano. Lo entiendes, ¿verdad? Coo.")
            ->action('Confirmar correo electrónico', $this->user->signedTokenUrl() )
            ->line('¡Gracias por usar nuestra aplicación!');
    }

    public function toArray($notifiable)
    {
        return [
            'icon' => 'far fa-envelope',
            'subject' => 'Verificación de correo electrónico',
            'body' => "necesitamos que confirmes tu dirección de correo electrónico...",
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('User.'.$this->user->id);
    }
}
