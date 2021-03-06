<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\{Conversation, User, Website};
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserContactBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function a_website_can_response_user_message()
    {
        $conversation = $this->create(Conversation::class);

        $user_message_to_website = $conversation->messages()->create([
            'user_send' => $conversation->user->id,
            'message' => 'Hola, '.$conversation->website->name,
        ]);

        $this->browse(function (Browser $browser) use($conversation, $user_message_to_website){
            $website_message_to_user = 'Saludos, '.$conversation->user->name;

            $browser->loginAs($conversation->website->user)
                ->visit("/client/{$conversation->website->username}/messages")
                ->clickLink($conversation->user->name, 'h1')
                ->type('.message input', $website_message_to_user)
                ->click('.fa-play')
                ->pause($this->pause_time)
                ->assertSee($user_message_to_website->message)
                ->assertSee($website_message_to_user);

            $browser->loginAs($conversation->user)
                ->visit('/messages')
                ->clickLink($conversation->website->name, 'h1')
                ->assertSee($website_message_to_user)
                ->assertSee($user_message_to_website->message);
        });
    }

    /**
     * @test
     * @return void
     * @throws \Throwable
     */
    function an_user_can_contact_to_website()
    {
        $user = $this->create(User::class);

        $website = $this->create(Website::class, [
            'name' => 'Cristian'
        ]);

        $message = 'Esto es una prueba';

        $this->browse(function (Browser $browser) use($user, $website, $message){

            $browser->loginAs($user)
                ->visit('/messages/create')
                ->type('.v-select input', $website->username)
                ->click('.v-select ul li', $website->username)
                ->type('message', $message)
                ->press('Enviar Mensaje')
                ->pause($this->pause_time)
                ->assertPathIs('/messages')
                ->assertSee($website->name)
                ->assertSee($message);

            $browser->loginAs($website->user)
                ->visit("/client/{$website->username}/messages")
                ->assertSee($website->name)
                ->assertSee($message);
        });
    }
}
