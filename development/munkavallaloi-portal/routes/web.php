<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
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
use App\Http\Controllers\Admin\DataChangeRequestController;
use App\Http\Controllers\Admin\FieldMappingController;
use App\Http\Controllers\Admin\DataChangeTypeController;
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

// User Dashboard
Route::get('/dashboard', [DashboardController::class, 'userDashboard'])
    ->middleware(['auth', 'verified', 'check_first_login', 'check_profile_complete'])
    ->name('dashboard');

// Admin Dashboard redirect
Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])
    ->middleware(['auth', 'verified', 'check_first_login'])
    ->name('admin-dashboard');

// First-time login routes
Route::get('/first-time-login', [App\Http\Controllers\Auth\FirstTimeLoginController::class, 'show'])
    ->name('first-time-login.show');
Route::post('/first-time-login', [App\Http\Controllers\Auth\FirstTimeLoginController::class, 'store'])
    ->name('first-time-login.store');

// Complete profile routes (for new users)
Route::middleware('auth')->group(function () {
    Route::get('/complete-profile', [App\Http\Controllers\CompleteProfileController::class, 'show'])
        ->name('complete-profile.show');
    Route::post('/complete-profile', [App\Http\Controllers\CompleteProfileController::class, 'store'])
        ->name('complete-profile.store');
});

Route::middleware(['auth', 'check_first_login', 'check_profile_complete'])->group(function () {
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
    Route::get('/comments/{comment}/download', [CommentController::class, 'downloadAttachment'])->name('comments.download');
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/{article}/pdf', [ArticleController::class, 'downloadPdf'])->name('articles.pdf');
    
    // Data Change Routes
    Route::get('/data-change', [DataChangeController::class, 'index'])->name('data-change.index');
    Route::get('/data-change/my-requests', [DataChangeController::class, 'myRequests'])->name('data-change.my-requests');
    Route::get('/data-change/{dataChangeType}', [DataChangeController::class, 'show'])->name('data-change.show');
    Route::post('/data-change/{dataChangeType}', [DataChangeController::class, 'store'])->name('data-change.store');
    Route::get('/data-change/request/{dataChangeRequest}', [DataChangeController::class, 'showRequest'])->name('data-change.show-request');

    // API Routes for Dynamic Forms
    Route::get('/api/categories/{category}/form', [CategoryFormController::class, 'getForm'])->name('api.categories.form');

    // ============================
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::put('/tickets/{ticket}', [AdminTicketController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{ticket}/comments', [AdminCommentController::class, 'store'])->name('tickets.comments.store');
    Route::resource('articles', AdminArticleController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('roles', AdminRoleController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('workplaces', AdminWorkplaceController::class);
    
    // Data Change Requests Management
    Route::get('/data-change-requests', [DataChangeRequestController::class, 'index'])->name('data-change-requests.index');
    Route::get('/data-change-requests/{dataChangeRequest}', [DataChangeRequestController::class, 'show'])->name('data-change-requests.show');
    Route::put('/data-change-requests/{dataChangeRequest}', [DataChangeRequestController::class, 'update'])->name('data-change-requests.update');
    Route::post('/data-change-requests/{dataChangeRequest}/apply', [DataChangeRequestController::class, 'apply'])->name('data-change-requests.apply');
    
    // Field Mapping Management
    Route::get('/field-mapping', [FieldMappingController::class, 'index'])->name('field-mapping.index');
    Route::get('/field-mapping/preview/{dataChangeRequest}', [FieldMappingController::class, 'preview'])->name('field-mapping.preview');
    Route::post('/field-mapping/update', [FieldMappingController::class, 'update'])->name('field-mapping.update');
    Route::delete('/field-mapping/{field}', [FieldMappingController::class, 'delete'])->name('field-mapping.delete');
    
    // Data Change Types Management (Custom Forms)
    Route::resource('data-change-types', DataChangeTypeController::class);
    
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