<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicAnnouncementsController;
use App\Http\Controllers\PublicAnnouncementSubscriptionController;
use App\Http\Controllers\PublicAppointmentController;
use App\Http\Controllers\PublicDoctorsController;
use App\Http\Controllers\PublicFaqsController;
use App\Http\Controllers\PublicMediaController;
use App\Http\Controllers\PublicServicesController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UserRolesAndPermissionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\PermissionRegistrar;

Route::get('/', PublicSiteController::class)->name('home');
Route::view('/about-us', 'public.about')->name('about');
Route::get('/services', PublicServicesController::class)->name('services');
Route::get('/doctors', PublicDoctorsController::class)->name('doctors');
Route::view('/clinic-schedule', 'public.schedule')->name('schedule');
Route::get('/announcements', PublicAnnouncementsController::class)->name('announcements');
Route::view('/gallery', 'public.gallery')->name('gallery');
Route::get('/faqs', PublicFaqsController::class)->name('faqs');
Route::view('/contact-us', 'public.contact')->name('contact');

Route::get('/media/{path}', PublicMediaController::class)
    ->where('path', '.*')
    ->name('public.media');

Route::post('/appointments/request', PublicAppointmentController::class)
    ->middleware('throttle:5,1')
    ->name('appointments.request');

Route::post('/announcements/subscribe', PublicAnnouncementSubscriptionController::class)
    ->name('announcements.subscribe');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // TEMPORARY: Test whether new routes are being deployed
    Route::get('/test-deployment', function () {
        return 'NEW CODE IS LIVE';
    })->name('test-deployment');

    Route::resource('services', ServicesController::class);
    Route::resource('doctors', DoctorsController::class)->except('show');
    Route::resource('faqs', FaqsController::class)->except('show');

    Route::patch('appointments/{appointment}/decision', [AppointmentsController::class, 'decision'])
        ->name('appointments.decision');

    Route::resource('appointments', AppointmentsController::class);

    Route::resource('announcements', AnnouncementsController::class)->except('show');

    Route::resource('users', UsersController::class);

    Route::put('users/activate/{id}', [UsersController::class, 'activate'])
        ->name('users.activate');

    Route::put('users/deactivate/{id}', [UsersController::class, 'deactivate'])
        ->name('users.deactivate');

    Route::resource('roles', RolesAndPermissionsController::class)
        ->only(['index', 'show']);

    Route::put('user/{user}/update-permissions', [UserRolesAndPermissionsController::class, 'changePermissions'])
        ->name('user.update-permissions');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';