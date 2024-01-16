<?php

use App\Livewire\Purposes\AllData;
use App\Livewire\Purposes\IncomingData;
use App\Livewire\Purposes\OutgoingData;
use App\Livewire\Purposes\Responsible;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('all-data'));
});

Route::prefix('dashboard')->group(function () {
    Route::get('/all-data', AllData::class)->name('all-data');
    Route::get('/incoming-data', IncomingData::class)->name('incoming-data');
    Route::get('/outgoing-data', OutgoingData::class)->name('outgoing-data');
    Route::get('/responsible', Responsible::class)->name('responsible');
});
