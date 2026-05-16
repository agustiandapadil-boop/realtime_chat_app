<?php

use Illuminate\Support\Facades\Broadcast;
Broadcast::channel(
    'chat.{id}',
    function ($user, $id) {
        return (int)$user->id === (int)$id;
}
);
Broadcast::channel(
    'group.{id}',
    function ($user, $id) {

        return $user
            ->groups()
            ->where('groups.id', $id)
            ->exists();
}
);
Broadcast::channel(
    'online',
    function ($user) {

        return [
            'id' => $user->id,
            'name' => $user->name
];
}
);