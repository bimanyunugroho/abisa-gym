<?php

use App\Http\Controllers\Admin\Gym\GymVisitController;
use App\Http\Controllers\Admin\Master\EquipmentCategoryController;
use App\Http\Controllers\Admin\Master\EquipmentController;
use App\Http\Controllers\Admin\Member\MemberController;
use App\Http\Controllers\Admin\Member\MemberInductionController;
use App\Http\Controllers\Admin\Member\MemberLevelController;
use App\Http\Controllers\Admin\Member\MemberRegistrationController;
use App\Http\Controllers\Admin\Member\MembershipPlanController;
use App\Http\Controllers\Admin\Payment\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
    ], function () {
        Route::resource('equipment-categories', EquipmentCategoryController::class);
        Route::resource('equipments', EquipmentController::class);
        Route::resource('member-inductions', MemberInductionController::class);
        Route::resource('member-levels', MemberLevelController::class);
        Route::resource('membership-plans', MembershipPlanController::class);
        Route::resource('member-registrations', MemberRegistrationController::class);
        Route::resource('members', MemberController::class);
        Route::resource('gym-visits', GymVisitController::class);
        Route::resource('payments', PaymentController::class);
    });

});

require __DIR__.'/auth.php';
