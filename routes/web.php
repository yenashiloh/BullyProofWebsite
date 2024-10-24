<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ListController;
use App\Http\Middleware\PreventBackHistory;

Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware([PreventBackHistory::class, 'discipline'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showDisciplineDashboard'])->name('admin.dashboard');
    Route::get('/profile', [ProfileController::class, 'showDisciplineProfile'])->name('admin.profile');
    Route::post('/admin/update-profile', [ProfileController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::post('/admin-logout', [AdminAuthController::class, 'logoutAdmin'])->name('admin.logout');
    Route::get('/users', [UserController::class, 'showUsers'])->name('admin.users.users'); Route::get('/users', [UserController::class, 'showUsers'])->name('admin.users.users');
    Route::get('/admin/incident-reports', [ReportsController::class, 'showReportsDiscipline'])->name('admin.reports.incident-reports');
    Route::get('/cbfs/reports/view/{id}', [ReportsController::class, 'viewReportDiscipline'])->name('admin.reports.view');
    Route::put('/admin/incident-reports/{id}/change-status', [ReportsController::class, 'changeStatus'])->name('admin.reports.changeStatus');

    Route::get('/cbfs/list-of-perpetrators', [ListController::class, 'showListOfPerpetrators'])->name('admin.list.list-perpetrators');
    Route::get('/cbfs/list-of-perpetrators/view/{id}', [ListController::class, 'viewPerpetratorDiscipline'])->name('admin.list.view-perpertrators');
});


Route::middleware([PreventBackHistory::class, 'guidance'])->group(function () {
    Route::get('/guidance/dashboard', [DashboardController::class, 'showGuidanceDashboard'])->name('guidance.dashboard');
    Route::get('/guidance/profile', [ProfileController::class, 'showGuidanceProfile'])->name('guidance.profile');
    Route::post('/guidance/update-profile', [ProfileController::class, 'updateGuidanceProfile'])->name('guidance.update-profile');
    Route::get('/guidance/counselling', [UserController::class, 'showCounselling'])->name('guidance.counselling.counselling');
    Route::post('/guidance-logout', [AdminAuthController::class, 'logoutGuidance'])->name('guidance.logout');
    Route::get('/guidance/incident-reports', [ReportsController::class, 'showReportsGuidance'])->name('guidance.reports.incident-reports');
    Route::get('/guidance/reports/view/{id}', [ReportsController::class, 'viewReportGuidance'])->name('guidance.reports.view');
});