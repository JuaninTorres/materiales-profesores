<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Livewire\Materials\Index as MaterialsIndex;
use App\Livewire\Materials\Show as MaterialShow;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::view('/sobre-mi', 'pages.about')->name('about');
Route::view('/servicios', 'pages.services')->name('services');
Route::get('/materiales', MaterialsIndex::class)->name('materials.index');
Route::get('/materiales/{material:code}', MaterialShow::class)->name('materials.show');
Route::view('/contacto', 'pages.contact')->name('contact');
