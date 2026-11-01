<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/projects/{slug}', [PortfolioController::class, 'project'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('project');
Route::get('/cv', [PortfolioController::class, 'cv'])->name('cv');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
