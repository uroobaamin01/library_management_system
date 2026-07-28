<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookCopyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\RackController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShelfController;

// Librarian Controllers
use App\Http\Controllers\Librarian\BookRequestController;
use App\Http\Controllers\Librarian\FineController;
use App\Http\Controllers\Librarian\IssueBookController;
use App\Http\Controllers\Librarian\LibrarianDashboardController;
use App\Http\Controllers\Librarian\ProfileController as LibrarianProfileController;
use App\Http\Controllers\Librarian\RenewBookController;
use App\Http\Controllers\Librarian\ReportController as LibrarianReportController;
use App\Http\Controllers\Librarian\ReservationController;
use App\Http\Controllers\Librarian\ReturnBookController;
use App\Http\Controllers\Librarian\StudentController;

// Public & Student Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BookCatalogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\RegisterController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentBorrowController;
use App\Http\Controllers\Student\StudentReservationController;
use App\Http\Controllers\Student\StudentFineController;
use App\Http\Controllers\Student\StudentProfileController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website Routes (Accessible by Everyone)
|--------------------------------------------------------------------------
*/

// Direct Main Landing Page (Direct Public Access)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Book Catalog Pages
Route::get('/catalog', [BookCatalogController::class, 'index'])->name('books.index');
Route::get('/catalog/{book}', [BookCatalogController::class, 'show'])->name('books.show');

// Contact Us Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Shared Authentication Routes (Login & Registration)
|--------------------------------------------------------------------------
*/

// Guest Routes (Login & Student Registration)
Route::middleware('guest')->group(function () {
    // Single Unified Login Page
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    
    // Student Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    // Alias for old forms referring to admin.login.submit
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Shared Logout Route
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| Student Portal Routes (Accessible by Students)
|--------------------------------------------------------------------------
*/
Route::prefix('student')->name('student.')->middleware(['auth', 'student'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    // Borrow & Request Operations
    Route::get('/borrows', [StudentBorrowController::class, 'index'])->name('borrows.index');
    Route::post('/request-book/{book}', [StudentBorrowController::class, 'storeRequest'])->name('borrows.request');
    
    // Reservations
    Route::get('/reservations', [StudentReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reserve-book/{book}', [StudentReservationController::class, 'store'])->name('reservations.store');

    // Fines History
    Route::get('/fines', [StudentFineController::class, 'index'])->name('fines.index');

    // Profile Settings
    Route::get('/profile', [StudentProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Accessible by Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Book Catalog Management
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('authors', AuthorController::class)->except(['show']);
    Route::resource('publishers', PublisherController::class)->only(['index', 'store', 'destroy']);
    Route::resource('languages', LanguageController::class)->only(['index', 'store']);
    
    // Books & Physical Copies
    Route::resource('books', BookController::class);
    Route::patch('/book-copies/{copy}/status', [BookCopyController::class, 'updateStatus'])->name('book-copies.update-status');

    // Location Management (Racks & Shelves)
    Route::resource('racks', RackController::class)->only(['index', 'store']);
    Route::resource('shelves', ShelfController::class)->only(['index', 'store']);

    // Profile & Account Settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // System Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Activity Audit Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});

/*
|--------------------------------------------------------------------------
| Librarian Panel Routes (Accessible by Librarian & Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('librarian')->name('librarian.')->middleware(['auth', 'librarian'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [LibrarianDashboardController::class, 'index'])->name('dashboard');

    // Issue Book Routes
    Route::get('/issue', [IssueBookController::class, 'index'])->name('issue.index');
    Route::post('/issue', [IssueBookController::class, 'store'])->name('issue.store');

    // Return Book Routes
    Route::get('/return', [ReturnBookController::class, 'index'])->name('return.index');
    Route::post('/return', [ReturnBookController::class, 'store'])->name('return.store');

    // Renew Book Routes
    Route::get('/renew', [RenewBookController::class, 'index'])->name('renew.index');
    Route::put('/renew/{transaction}', [RenewBookController::class, 'update'])->name('renew.update');

    // Book Requests Operations
    Route::get('/requests', [BookRequestController::class, 'index'])->name('requests.index');
    Route::post('/requests/{bookRequest}/approve', [BookRequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{bookRequest}/reject', [BookRequestController::class, 'reject'])->name('requests.reject');

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Student Accounts Management
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::post('/students/{student}/toggle-status', [StudentController::class, 'toggleStatus'])->name('students.toggle-status');

    // Fine Operations
    Route::get('/fines', [FineController::class, 'index'])->name('fines.index');
    Route::post('/fines/{fine}/pay', [FineController::class, 'markAsPaid'])->name('fines.pay');

    // Operational Reports
    Route::get('/reports', [LibrarianReportController::class, 'index'])->name('reports.index');

    // Librarian Profile Management
    Route::get('/profile', [LibrarianProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [LibrarianProfileController::class, 'update'])->name('profile.update');
});