<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\InstansiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Mail;
use App\Mail\KirimEmailTest;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email', function() {
    try {
        $emailTujuan = 'uzik3580@gmail.com';
        Mail::to($emailTujuan)->send(new KirimEmailTest());
        return "Testin email ke {$emailTujuan}. cek inbox";
    } catch (\Exception $e) {
        return "Terjadi kesalahan saat mengirim email:" . $e->getMessage();
    }
});


Route::get('/login', [AuthController::class, 'login_form'])->name('login');
Route::post('/login', [AuthController::class, 'login_proses'])->middleware('throttle:5,1');

Route::get('/register', [AuthController::class, 'register_form'])->name('register');
Route::post('/register', [AuthController::class, 'register_proses'])->middleware('throttle:5,1');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/lupa-password', [AuthController::class, 'forgot_password_form'])->name('password.request');
Route::post('/lupa-password', [AuthController::class, 'forgot_password_proses'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'reset_password_form'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset_password_proses'])->name('password.update');

Route::view('/cek-status', 'cek-status')->name('cek-status.index');

Route::middleware('throttle:5,1')->group(function () {
    Route::post('/cek-status', [PendaftaranController::class, 'cekStatusPublic']);
});


//Route ke Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index_admin'])->name('admin.dashboard');

    Route::resource('/admin/instansi', InstansiController::class)->names('admin.instansi');

    Route::get('/admin/kelola-pendaftaran', [AdminController::class, 'index'])->name('admin.pendaftaran.index');
    Route::get('/admin/kelola-pendaftaran/{id}', [AdminController::class, 'show'])->name('admin.pendaftaran.show');
    Route::get('/admin/kelola-pendaftaran/{id}/edit', [AdminController::class, 'edit'])->name('admin.pendaftaran.edit');
    Route::put('/admin/kelola-pendaftaran/{id}', [AdminController::class, 'update'])->name('admin.pendaftaran.update');
    Route::delete('/admin/kelola-pendaftaran/bulk-delete', [AdminController::class, 'bulkDestroy'])->name('admin.pendaftaran.bulkDestroy');
    Route::delete('/admin/kelola-pendaftaran/{id}', [AdminController::class, 'destroy'])->name('admin.pendaftaran.destroy');
    Route::post('/admin/kelola-pendaftaran/{id}/update-status', [AdminController::class, 'updateStatus'])->name('admin.pendaftaran.updateStatus');

    Route::get('/admin/users', [ProfileController::class, 'index_admin'])->name('admin.users.index');
    Route::get('/admin/users/{id}/edit', [ProfileController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [ProfileController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/users', [ProfileController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [ProfileController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/export/excel', [AdminController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/admin/export/pdf', [AdminController::class, 'exportPdf'])->name('admin.export.pdf');

    Route::get('/admin/audit-logs', [AdminController::class, 'auditLogs'])->name('admin.audit-logs.index');
});

//Route ke Pengguna
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'index_user'])->name('user.dashboard');
    Route::get('/user/daftar', [PendaftaranController::class, 'index'])->name('user.daftar');
    Route::post('/user/daftar/submit', [PendaftaranController::class, 'storeOrUpdate'])->name('user.daftar.submit');

    Route::get('/profile', [ProfileController::class, 'index_user'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/user/cetak-surat', [DashboardController::class, 'cetakSurat'])->name('user.cetak-surat');
});
