<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Conversation;

Broadcast::channel('User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Conversation.{conversation}', function ($user, Conversation $conversation) {
    return (int) $user->id === (int) $conversation->user_id;
});

Broadcast::channel('Cart.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});