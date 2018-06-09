<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\{Conversation, Message, Website};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientCanAnswerMessagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_client_can_respond_to_a_users_message()
    {
        $message = $this->create(Message::class);

        $this->actingAs($message->conversation->website->user)
            ->json('POST', "/client/{$message->conversation->website->username}/messages", [
                'user_id' => $message->conversation->user_id,
                'message' => "Como puedo Ayudarle?"
            ])->assertStatus(Response::HTTP_CREATED);

        $this->actingAs($message->conversation->user)
            ->json('GET', "messages/conversations/{$message->conversation->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'message' => $message->message,
                'message' => "Como puedo Ayudarle?"
            ]);
    }

    /** @test */
    function a_client_cannot_send_message_to_users_if_they_do_no_write()
    {
        $this->withExceptionHandling();

        $website = $this->create(Website::class);
        $conversation = $this->create(Conversation::class);

        $this->actingAs($website->user)
            ->json('POST', "/client/{$website->username}/messages", [
                'user_id' => $conversation->user->id,
                'message' => "Hola le envio este mensaje"
            ])->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    function a_guest_cannot_answer_users_messages()
    {
        $this->withExceptionHandling();

        $website = $this->create(Website::class);

        $this->json('POST', "/client/{$website->username}/messages", [])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
