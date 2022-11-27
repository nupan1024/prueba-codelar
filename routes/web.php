<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PokemonController::class, 'main'])->name('inicio');
Route::post('/get-pokemon', [PokemonController::class, 'add'])->name('get-pokemon');
Route::get('/delete-pokemon', [PokemonController::class, 'delete'])->name('delete-pokemon');
Route::get('/evolution-pokemon', [PokemonController::class, 'evolution'])->name('evolution-pokemon');