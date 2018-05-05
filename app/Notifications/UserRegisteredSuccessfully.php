<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisteredSuccessfully extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Models\User
     */
    public $user;

    public $url;

    public $tries = 5;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->url = URL::temporarySignedRoute(
            'account.activate', now()->addMinutes(30), ['token' => $this->user->activation_code]
        );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->greeting("Hola {$this->user->name}")
            ->line("Usted se ha registrado exitosamente en ". config('app.name') .". Por favor active su cuenta")
            ->action('activar la cuenta', $this->url)
            ->line('¡Gracias por usar nuestra aplicación!');
    }

}
