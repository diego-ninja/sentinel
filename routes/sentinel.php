<?php

use Illuminate\Support\Facades\Route;
use Ninja\Sentinel\Actions\CheckAction;

Route::post('sentinel/check', CheckAction::class)
    ->name('sentinel.check');
