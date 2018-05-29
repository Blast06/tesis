<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\{User, Article};
use App\Notifications\NewArticleNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Messages\MailMessage;

class NewArticleNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_builds_a_mail_message()
    {
        $user = new User();

        $article =  $this->create(Article::class);

        $notification = new NewArticleNotification($user, $article);

        $message = $notification->toMail($user);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
            "[{$article->website->name}] Nuevo articulo",
            $message->subject
        );

        $this->assertSame(
            "Hola {$user->name}.",
            $message->greeting
        );

        $this->assertSame(
            "{$article->website->name}, añadido un nuevo articulo {$article->name}",
            $message->introLines[0]
        );

        $this->assertSame(
            'Ver el articulo',
            $message->actionText
        );

        $this->assertSame(
            $article->url->article,
            $message->actionUrl
        );
    }
}
