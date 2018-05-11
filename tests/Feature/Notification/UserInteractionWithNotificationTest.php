<?php

namespace Tests\Feature\Notification;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserInteractionWithNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_see_notificaion()
    {
        $this->get('notifications')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_see_notificaion()
    {
        $this->actingAs($this->createUser())->get('notifications')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('pages.notification');
    }

    /** @test */
    public function user_can_mark_as_read_all_notification()
    {
        $user = $this->createUser();

        $this->be($user);

        $this->createUnReadNotification($user);

        $this->get('notifications/read-all')
            ->assertStatus(Response::HTTP_FOUND);

        $this->get('notifications')
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('bandeja de notificación vacía');

        $this->assertTrue(
            $user->unreadNotifications->count() === 0
        );
    }

    /** @test */
    public function user_can_mark_as_read_one_notification()
    {
        $user = $this->createUser();

        $this->be($user);

        $this->createUnReadNotification($user);

        $notifications = DatabaseNotification::all();

        $this->get("notifications/{$notifications[0]->id}")
            ->assertStatus(Response::HTTP_FOUND);

        $this->get('notifications')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('pages.notification')
            ->assertViewHas('notifications', function ($allNotifications) use ($notifications) {
                return !$allNotifications->contains($notifications[0])
                && $allNotifications->contains($notifications[1])
                && $allNotifications->contains($notifications[2])
                && $allNotifications->contains($notifications[3])
                && $allNotifications->contains($notifications[4]);
            });

        $this->assertTrue(
            $user->unreadNotifications->count() === 4
        );
    }

    /** @test */
    public function user_cannot_see_read_notifications()
    {
        $user = $this->createUser();

        $this->be($user);

        $this->createReadNotification($user);

        $notifications = DatabaseNotification::all();

        $this->get('notifications')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('pages.notification')
            ->assertViewHas('notifications', function ($allNotifications) use ($notifications) {
                return !$allNotifications->contains($notifications[0])
                    && !$allNotifications->contains($notifications[1])
                    && !$allNotifications->contains($notifications[2])
                    && !$allNotifications->contains($notifications[3])
                    && !$allNotifications->contains($notifications[4]);
            });

        $this->assertTrue(
            $user->unreadNotifications->count() === 0
        );
    }

    protected function createUnReadNotification(User $user, $times = 5)
    {
        for ($index = 0; $index < $times; $index++) {
            DatabaseNotification::create([
                'id' =>  (string) Str::uuid(),
                'type' => "Notification\Test",
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $user->id,
                'data' => [
                    'body' => 'Test Body'
                ]
            ]);
        }
    }

    protected function createReadNotification(User $user, $times = 5)
    {
        for ($index = 0; $index < $times; $index++) {
            DatabaseNotification::create([
                'id' =>  (string) Str::uuid(),
                'type' => "Notification\Test",
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $user->id,
                'data' => [
                    'body' => 'Test Body'
                ],
                'read_at' => Carbon::now()
            ]);
        }
    }
}