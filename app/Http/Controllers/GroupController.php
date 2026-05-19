<?php

namespace App\Http\Controllers;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\GroupCreated;

class GroupController extends Controller
{
public function store(Request $request)
    {
$request->validate([
    'name' => 'required',
    'members' => 'required|array'
]);
    $group = Group::create([
    'name' => $request->name
]);
    $group->users()->attach(
        auth()->id()
);

    $group->users()->attach(
    $request->members
);
event(new GroupCreated($group));
return response()->json([
    'success' => true,
    'group' => $group
]);
}
public function leave(Group $group)
    {
    $group->users()->detach(auth()->id());
    return response()->json([
        'success' => true
]);
}
}