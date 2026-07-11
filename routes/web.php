<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicAppointmentController;
use App\Http\Controllers\PublicAnnouncementSubscriptionController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UserRolesAndPermissionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicSiteController::class)->name('home');
Route::view('/about-us', 'public.about')->name('about');
Route::view('/services', 'public.services')->name('services');
Route::view('/doctors', 'public.doctors')->name('doctors');
Route::view('/clinic-schedule', 'public.schedule')->name('schedule');
Route::view('/announcements', 'public.announcements')->name('announcements');
Route::view('/gallery', 'public.gallery')->name('gallery');
Route::view('/faqs', 'public.faqs')->name('faqs');
Route::view('/contact-us', 'public.contact')->name('contact');
Route::post('/appointments/request', PublicAppointmentController::class)->name('appointments.request');
Route::post('/announcements/subscribe', PublicAnnouncementSubscriptionController::class)->name('announcements.subscribe');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('services', ServicesController::class);
    Route::resource('appointments', AppointmentsController::class);

    Route::resource('users', UsersController::class);
    Route::put('users/activate/{id}', [UsersController::class, 'activate'])->name('users.activate');
    Route::put('users/deactivate/{id}', [UsersController::class, 'deactivate'])->name('users.deactivate');

    Route::resource('roles', RolesAndPermissionsController::class);
    Route::put('user/{user}/update-role', [UserRolesAndPermissionsController::class, 'changeRole'])
            ->name('user.update-role');
    Route::put('user/{user}/update-permissions', [UserRolesAndPermissionsController::class, 'changePermissions'])
            ->name('user.update-permissions');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
