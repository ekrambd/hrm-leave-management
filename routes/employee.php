<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;

Route::middleware([
    'prevent-back-history',
    'can:employee'
])->group(function () {
   //leaves
   Route::get('leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
   Route::get('leaves', [LeaveController::class, 'index'])->name('leaves.index');
	Route::post('leaves', [LeaveController::class, 'store'])->name('leaves.store');
	Route::get('leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
	
	Route::delete('leaves/{leave}', [LeaveController::class, 'destroy'])->name('leaves.delete');

});