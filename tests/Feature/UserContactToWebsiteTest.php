<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\{Message, User, Website};
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserContactToWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_user_can_contact_a_website()
    {
        $website = $this->create(Website::class);

        $messages = [
            'Hola tengo una pregunta',
            'hahahahahha oky....'
        ];

        $this->actingAs($user = $this->create(User::class))
            ->messageTo($website, $messages);

        $this->messageIsSaved($user, $website, $messages);
    }

    /** @test */
    function an_user_can_contact_to_many_website()
    {
        $websites = $this->create(Website::class, [], 2);

        $messages = [
            'Hola tengo una pregunta',
            'Puedo comprar el articulo',
        ];

        $this->actingAs($user = $this->create(User::class))
            ->messageTo($websites[0], $messages)
            ->messageTo($websites[1], $messages);

        $this->messageIsSaved($user, $websites[0], $messages);

        $this->messageIsSaved($user, $websites[1], $messages);
    }

    /** @test */
    function an_user_cannot_see_others_conversation_of_others_users()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    function unique_conversation_on_user_to_website()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    function a_guest_cannot_contact_a_website()
    {
        $this->withExceptionHandling();
        
        $website = $this->create(Website::class);

        $this->json('POST', route('messages.store', [
            'message' => 'Hola tengo una pregunta',
            'website_id' => $website->id
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
