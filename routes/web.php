<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChannelController;

Route::get('/', function () {
    return redirect('create-channel');
});

Route::get('/create-channel', [ChannelController::class,'view_create']);
Route::post('/create-channel', [ChannelController::class,'store'])->name('channels.store');

Route::get('/edit-channel/{id}', [ChannelController::class,'view_edit'])->name('channels.edit');
Route::put('/edit-channel/{id}', [ChannelController::class,'update'])->name('channels.update');

Route::post('/delete-channels', [ChannelController::class,'delete'])->name('channels.delete');