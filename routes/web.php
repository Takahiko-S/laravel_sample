<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\UserPicsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'top'])->name('index');
Route::get('/about', function () {return view('contents.about');})->name('about');
Route::get('/kojin', function () {return view('contents.kojin');})->name('kojin');
Route::get('/inquiry', function () {return view('contents.inquiry');})->name('inquiry');
Route::get('/show_album', function () {return redirect(route('index'));});//再読み込みで元のページに戻る処理
Route::post('/show_album', [PageController::class, 'showAlbum']);
Route::post('/user_pics', [PageController::class, 'userPics']);
Route::post('/show_master', [PageController::class, 'showMaster']);

Route::post('/guest_inquiry', [MailController::class, 'inquiryMail']);
Route::get('/guest_inquiry', function () {return redirect(route('inquiry'));});


Route::get('/dashboard', function () {return view('users.dashboard');})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/modify', [MembersController::class, 'modify'])->middleware(['auth', 'verified'])->name('modify');
Route::get('/pic_upload', function () {return view('users.pic_upload');})->middleware(['auth', 'verified'])->name('pic_upload');
Route::post('/save_data', [MembersController::class, 'saveData'])->middleware(['auth', 'verified']);
Route::get('/save_data', function () {return view('users.dashboard');})->middleware(['auth', 'verified']);


Route::post('/save_pics', [UserPicsController::class,'savePics'])->middleware(['auth', 'verified']);
Route::post('/get_pics', [UserPicsController::class,'getPics'])->middleware(['auth', 'verified']);
Route::post('/get_master', [UserPicsController::class,'getMaster'])->middleware(['auth', 'verified']);
Route::post('/delete_pic', [UserPicsController::class,'deletePic'])->middleware(['auth', 'verified']);
Route::post('/save_title', [UserPicsController::class,'saveTitle'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/admin_login',[AdminAuthController::class,'showLoginForm'])->name('admin_login');
Route::post('/admin_login',[AdminAuthController::class,'login']);
Route::post('/admin_login/logout',[AdminAuthController::class,'logout'])->middleware(['auth:admins'])->name('admin_logout');

Route::prefix('admins')->middleware('auth:admins')->group(function () {
    Route::get('/', function(){return redirect(route('kanri_top'));});
    Route::get('/kanri_main', function(){return view('admin.kanri_top');})->name('kanri_top');
    Route::get('/user_list', [AdminController::class,'userList'])->name('user_list');
    Route::get('/admin_profile', function(){return view('admin.admin_profile');})->name('admin_profile');
    Route::post('/admin_profile', function(){return view('admin.admin_profile');});
    Route::post('/change_user',[AdminController::class,'changeUser']);
    Route::post('/delete_user',[AdminController::class,'deleteUser']);
    Route::get('/admin_list', [AdminController::class,'adminList'])->name('admin_list');
    Route::post('/save_admin', [AdminController::class,'saveAdmin']);
    Route::post('/change_admin',[AdminController::class,'changeAdmin']);
    Route::post('/delete_admin',[AdminController::class,'deleteAdmin']);
});

require __DIR__.'/auth.php';



