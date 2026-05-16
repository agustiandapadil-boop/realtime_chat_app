<?php

namespace App\Http\Controllers;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class ChatController extends Controller
{
public function index()
    {
    $users = User::where(
    'id',
    '!=',
    auth()->id()
    )->get();

$groups = auth()
->user()
->groups;

return view(
    'chat.index',
    compact(
    'users',
    'groups'
)
);
}
public function send(Request $request)
{
    $request->validate([
    'receiver_id' => 'required',
    'message' => 'required'
]);
$message = Message::create([
    'sender_id' => auth()->id(),
    'receiver_id' =>
        $request->receiver_id,
    'message' =>
        $request->message
]);

broadcast(
    new MessageSent($message)
)->toOthers();
return response()->json([
    'success' => true,
    'message' => $message
]);
}

public function sendGroupMessage(
    Request $request
)
{
$request->validate([
    'group_id' => 'required',
    'message' => 'required'
]);

    $message = Message::create([
        'sender_id' => auth()->id(),
        'group_id' =>
            $request->group_id,
        'message' =>
            $request->message
        ]);
broadcast(
    new MessageSent($message)
    )->toOthers();

return response()->json([
    'success' => true,
    'message' => $message
]);
}
public function getPrivateMessages(User $user)
    {
        $messages = Message::where(function($query) use ($user) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', auth()->id());
        })->with('sender')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

public function getGroupMessages(Group $group)
    {
        $messages = Message::where('group_id', $group->id)
            ->with('sender')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }
}