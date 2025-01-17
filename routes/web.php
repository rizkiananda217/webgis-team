<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\list_pariwisata_controller;
use App\Http\Controllers\auth_controller;
use App\Http\Controllers\user_controller;
use App\Http\Livewire\LocationPoint;
use App\Models\list_pariwisata;
use App\Http\Livewire\MapLocation;


// route::get('peta/{id}', [list_pariwisata_controller::class, 'show']);

route::get('/login', [auth_controller::class, 'login'])->name('login');
route::post('/login', [auth_controller::class, 'masuk'])->name('masuk');
Route::post('/logout', [auth_controller::class, 'logout'])->name('logout');

// route::get('/', [list_pariwisata_controller::class, 'index']);
route::get('/', [list_pariwisata_controller::class, 'index']);

route::get('/detail/{id}', [list_pariwisata_controller::class, 'show']);

// route::get('/json/{id}', [list_pariwisata_controller::class, 'json']);

Route::get('/map', MapLocation::class)->middleware('auth');
Route::get('/location/{id}', MapLocation::class);

Route::delete('/pariwisata/{id}', [list_pariwisata_controller::class, 'destroy'])->name('pariwisata.destroy');


