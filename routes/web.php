<?php

use App\Http\Livewire\Alpine;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShowPost;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', ShowPost::class)->name('dashboard'); 

Route::middleware(['auth:sanctum', 'verified'])->get('/alpine', Alpine::class)->name('alpine'); 
