<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/filmlist', function () {
    return view('filmlist');
})->middleware(['auth', 'verified'])->name('filmlist');

Route::get('/filmdetail', function () {
    return view('filmdetail');
})->middleware(['auth', 'verified'])->name('filmdetail');

Route::get('/rentalstats', function () {
    return view('rentalstats');
})->middleware(['auth', 'verified'])->name('rentalstats');

Route::get('/style.css', function () {
    return response()
        ->file(resource_path('css/style.css'), [
            'Content-Type' => 'text/css'
        ]);
})->name('style.css');

Route::get('/research', function () {
    return view('components.research-component');
})->middleware(['auth', 'verified'])->name('research');

Route::get('/search-filter', function () {
    return view('components.search-filter');
})->middleware(['auth', 'verified'])->name('search-filter');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
