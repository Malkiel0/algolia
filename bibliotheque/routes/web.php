<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivreController;

Route::get('/', function () {
    return redirect()->route('livres.index');
});

Route::resource('livres', LivreController::class);
