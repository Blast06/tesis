<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_cannot_see_notificaion()
    {
        $this->withExceptionHandling();

        $this->get('notifications')
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /** @test */
    function authenticated_users_can_see_notificaion()
    {
        $this->actingAs($this->create(User::class))->get('notifications')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('pages.notification');
    }

    /** @test */
    function user_can_mark_as_read_all_notification()
    {
        $this->be($user = $this->create(User::class));

        $this->create(DatabaseNotification::class,[], 5);

        $this->get('notifications/read-all')
            ->assertStatus(Response::HTTP_FOUND);

        $this->get('notifications')
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('bandeja de notificación vacía');

        $this->assertCount(0, $user->unreadNotifications);
    }

    /** @test */
    function a_user_can_mark_a_notification_as_read()
    {
        $this->be($user = $this->create(User::class));

        $notifications = $this->create(DatabaseNotification::class, [],5);

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

        $this->assertCount(4, $user->unreadNotifications);
    }

    /** @test */
    function user_cannot_see_read_notifications()
    {
        $this->be($user = $this->create(User::class));

        $notifications = $this->create(DatabaseNotification::class, ['read_at' => Carbon::now()],5);

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

        $this->assertCount(0, $user->unreadNotifications);
    }

}