<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;

Route::group(['middleware' => 'prevent-back-history'],function(){
   //leaves
   Route::get('leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
   Route::get('leaves', [LeaveController::class, 'index'])->name('leaves.index');
	Route::post('leaves', [LeaveController::class, 'store'])->name('leaves.store');
	Route::get('leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');
	Route::patch('leaves/{leave}', [LeaveController::class, 'update'])->name('leaves.update');
	Route::delete('leaves/{leave}', [LeaveController::class, 'destroy'])->name('leaves.delete');

});