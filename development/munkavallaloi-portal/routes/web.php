<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController; // JAVÍTVA: Alias hozzáadása
use App\Http\Controllers\Admin\CommentController as AdminCommentController; // JAVÍTVA: Alias hozzáadása
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WorkplaceController as AdminWorkplaceController;
use App\Http\Controllers\DataChangeController;
use App\Http\Controllers\Admin\PreRegisteredUserController;
use App\Http\Controllers\Admin\DataChangeApprovalController;
use App\Http\Controllers\Api\CategoryFormController;

Route::get('locale/{locale}', function ($locale) {
    if (in_array($locale, ['hu', 'en', 'es'])) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('locale.change');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'check_first_login'])
    ->name('dashboard');

// First-time login routes
Route::get('/first-time-login', [App\Http\Controllers\Auth\FirstTimeLoginController::class, 'show'])
    ->name('first-time-login.show');
Route::post('/first-time-login', [App\Http\Controllers\Auth\FirstTimeLoginController::class, 'store'])
    ->name('first-time-login.store');

Route::middleware(['auth', 'check_first_login'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // === Másold be ezt a részt ===
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('tickets.comments.store');
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
    
    // Data Change Request Routes
    Route::get('/data-change', [DataChangeController::class, 'index'])->name('data-change.index');
    Route::post('/data-change', [DataChangeController::class, 'store'])->name('data-change.store');

    // API Routes for Dynamic Forms
    Route::get('/api/categories/{category}/form', [CategoryFormController::class, 'getForm'])->name('api.categories.form');

    // ============================
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{ticket}', [AdminTicketController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{ticket}/comments', [AdminCommentController::class, 'store'])->name('tickets.comments.store');
    Route::resource('articles', AdminArticleController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('roles', AdminRoleController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('workplaces', AdminWorkplaceController::class);
    
    // Pre-registered Users Routes
    Route::resource('pre-registered-users', PreRegisteredUserController::class)->only(['index', 'store', 'destroy']);
    Route::get('/pre-registered-users/template', [PreRegisteredUserController::class, 'downloadTemplate'])->name('pre-registered-users.template');
    
    // Data Change Approval Routes
    Route::get('/data-change-approval', [DataChangeApprovalController::class, 'index'])->name('data-change-approval.index');
    Route::get('/data-change-approval/{ticket}', [DataChangeApprovalController::class, 'show'])->name('data-change-approval.show');
    Route::post('/data-change-approval/{ticket}/approve', [DataChangeApprovalController::class, 'approve'])->name('data-change-approval.approve');
    Route::post('/data-change-approval/{ticket}/reject', [DataChangeApprovalController::class, 'reject'])->name('data-change-approval.reject');
});

require __DIR__.'/auth.php';