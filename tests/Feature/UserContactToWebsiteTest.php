<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\{Message, User, Website};
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserContactToWebsiteTest extends TestCase
{
    use RefreshDatabase;

    private $website;

    private $user;

    private $messages = [
        'Hola tengo una pregunta',
        'Como puedo instalar laravel'
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->website = $this->create(Website::class, [], 2);
        $this->user = $this->create(User::class, [], 2);
    }

    /** @test */
    function an_user_can_contact_a_website()
    {
        $this->actingAs($this->user[0])
            ->messageTo($this->website[0], $this->messages);

        $this->messageIsSaved($this->user[0], $this->website[0], $this->messages);
    }

    /** @test */
    function an_user_can_contact_to_many_website()
    {
        $this->actingAs($this->user[0])
            ->messageTo($this->website[0], $this->messages)
            ->messageTo($this->website[1], $this->messages);

        $this->messageIsSaved($this->user[0], $this->website[0], $this->messages);

        $this->messageIsSaved($this->user[0], $this->website[1], $this->messages);
    }

    /** @test */
    function an_user_cannot_see_others_conversation_of_others_users()
    {
        $message = $this->create(Message::class, [], 2);

        $mensaje1 = $message[0]->conversation->user->conversation[0]->messages;

        $mensaje2 = $message[1]->conversation->user->conversation[0]->messages;

        $this->assertCount(1, $mensaje1);
        $this->assertCount(1, $mensaje2);

        $this->assertFalse($mensaje1[0]['message'] === $mensaje2[0]['message']);
    }

    /** @test */
    function unique_conversation_on_user_to_website()
    {
        $this->actingAs($this->user[0])
            ->messageTo($this->website[0], $this->messages)
            ->messageTo($this->website[0], $this->messages);

        $this->assertCount(1, $this->user[0]->conversation);
    }

    /** @test */
    function a_guest_cannot_contact_a_website()
    {
        $this->withExceptionHandling();

        $this->json('POST', route('messages.store', [
            'message' => 'Hola tengo una pregunta',
            'website_id' => $this->website[0]->id
        ]))->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param \App\Website $website
     * @param $messages
     * @return $this
     */
    protected function messageTo(Website $website, $messages)
    {
        if (is_array($messages)) {
            foreach ($messages as $message) {
                $this->json('POST', route('messages.store', [
                    'message' => $message,
                    'website_id' => $website->id
                ]))->assertSuccessful();
            }
        }else{
            $this->json('POST', route('messages.store', [
                'message' => $messages,
                'website_id' => $website->id
            ]))->assertSuccessful();
        }

        return $this;
    }

    protected function messageIsSaved(User $user, Website $website, $messages)
    {
        $this->assertDatabaseHas('conversations', [
            'user_id' => $user->id,
            'website_id' => $website->id
        ]);

        if (is_array($messages)) {
            foreach ($messages as $message) {
                $this->assertDatabaseHas('messages', [
                    'user_send' => $user->id,
                    'message' => $message,
                ]);
            }
        }else{
            $this->assertDatabaseHas('messages', [
                'user_send' => $user->id,
                'message' => $messages,
            ]);
        }
    }
}
