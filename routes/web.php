<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/chat');
    }
    return redirect('/login');
});
Route::middleware('auth')->group(function () {

Route::get('/dashboard', function () {
        return redirect('/chat');
    })->name('dashboard');

Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

Route::patch(
    '/profile',
    [ProfileController::class, 'update']
    )->name('profile.update');

Route::delete(
    '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

Route::get(
    '/chat',
        [ChatController::class, 'index']
    )->name('chat');

Route::post(
    '/send-message',
        [ChatController::class, 'send']
    )->name('send.message');

Route::post(
    '/send-group-message',
        [ChatController::class, 'sendGroupMessage']
    )->name('send.group.message');
Route::post(
    '/groups',
        [GroupController::class, 'store']
    )->name('groups.store');

Route::delete(
    '/groups/{group}/leave',
        [GroupController::class, 'leave']
    )->name('groups.leave');

Route::get(
    '/chat/private/{user}',
        [ChatController::class, 'getPrivateMessages']
    )->name('chat.private.history');

Route::get(
    '/chat/group/{group}',
        [ChatController::class, 'getGroupMessages']
    )->name('chat.group.history');

});
require __DIR__.'/auth.php';