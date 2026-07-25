<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;

//ajax requests
Route::get('designations-by-department', [AjaxController::class, 'designationsByDepartment']);
Route::get('/notification-read/{id}', [AjaxController::class, 'notificationRead']);