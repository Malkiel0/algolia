<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;

// Route principale du dashboard Digit All
// Route principale du dashboard
Route::get('/', Dashboard::class)->name('dashboard');

// Route pour la gestion des utilisateurs (page utilisateurs Digit All)
Route::get('/utilisateurs', \App\Livewire\Users::class)->name('users');

// Route pour la page Statistiques Digit All
Route::get('/statistiques', \App\Livewire\Stats::class)->name('stats');

// Route pour la page Paramètres Digit All
Route::get('/parametres', \App\Livewire\Settings::class)->name('settings');
