<?php

use Illuminate\Support\Facades\Route;
use Ninja\Sentinel\Actions\AnalyzeAction;

Route::post('sentinel/analyze', AnalyzeAction::class)
    ->name('sentinel.analyze');
