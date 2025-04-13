<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Admin\SpaController;

// Admin Route
// ===================
Route::middleware('AdminLoginCheck')->get('/secure/administration/auth/{any}', [SpaController::class, 'index'])->where('any', '.*')->name('lvs.auth');
Route::middleware('AdminLoginCheck')->get('/secure/administration', [SpaController::class, 'index'])->where('any', '.*')->name('lvs.home');
Route::middleware('AdminLoginCheck')->get('/secure/administration/{any}', [SpaController::class, 'index'])->where('any', '.*')->name('lvs.home.any');

// Portal Route
// ===================
include_once 'portal.php';

// Front Route
// ===================
Route::get('/', [FrontController::class, 'home'])->name('front.home');
Route::get('/ai-safety-Risks', [FrontController::class, 'ai_safety_Risks'])->name('front.ai.safety.risks');
Route::get('/manage-ai-risk', [FrontController::class, 'manage_ai_risk'])->name('front.manage.ai.risk');
Route::get('/fair-decision-analysis', [FrontController::class, 'fair_decision_analysis'])->name('front.fair.decision.analysis');
Route::get('/training', [FrontController::class, 'training'])->name('front.training');
Route::get('/awareness', [FrontController::class, 'awareness'])->name('front.awareness');
Route::get('/certification', [FrontController::class, 'certification'])->name('front.certification');
Route::get('/certification/workshops', [FrontController::class, 'certification_workshops'])->name('front.certification.workshops');
Route::post('/certification/workshops/download', [FrontController::class, 'certification_workshops_download'])->name('front.certification.workshops.download');
Route::get('/team', [FrontController::class, 'team'])->name('front.team');
Route::get('/blog', [FrontController::class, 'blog_home'])->name('front.blog.home');
Route::get('/blog/{id}', [FrontController::class, 'blog'])->name('front.blog');
Route::get('/contact-us', [FrontController::class, 'contact_us'])->name('front.contact.us');
Route::post('/contact-us', [AuthController::class, 'contact_us_action'])->name('front.contact.us.action');
Route::get('/privacy-policy', [FrontController::class, 'privacy_policy'])->name('front.privacy.policy');
Route::get('/cookie-policy', [FrontController::class, 'cookie_policy'])->name('front.cookie.policy');
Route::get('/terms-and-policy', [FrontController::class, 'terms_conditions'])->name('front.terms.policy');

Route::get('/pricing', [FrontController::class, 'pricing'])->name('front.pricing');
Route::get('/subscribe/success', [FrontController::class, 'subscribe_success'])->name('front.subscribe.success')->middleware('UserAuthReq');
Route::get('/subscribe/error', [FrontController::class, 'subscribe_error'])->name('front.subscribe.error')->middleware('UserAuthReq');
Route::get('/subscribe/{type}', [FrontController::class, 'subscribe_make'])->name('front.subscribe.make')->middleware('UserAuthReq');

Route::group(['middleware' => ['UserAuthCheck']], function () {
    Route::get('login', [FrontController::class, 'Login'])->name('front.login')->middleware('UserAuthCheck');
    Route::post('login', [AuthController::class, 'Login'])->name('front.login.action')->middleware('UserAuthCheck');
    Route::post('login-api', [AuthController::class, 'LoginApi'])->name('front.login.action.api')->middleware('UserAuthCheck');
    Route::get('register', [FrontController::class, 'Register'])->name('front.register')->middleware('UserAuthCheck');
    Route::post('register', [AuthController::class, 'Register'])->name('front.register.action')->middleware('UserAuthCheck');
    Route::post('register-api', [AuthController::class, 'RegisterApi'])->name('front.register.action.api')->middleware('UserAuthCheck');
    Route::get('forgot/password', [FrontController::class, 'Forgot'])->name('front.forgot')->middleware('UserAuthCheck');
    Route::post('forgot/password', [AuthController::class, 'Forgot'])->name('front.forgot.action')->middleware('UserAuthCheck');
    Route::get('reset/password/{reset_code}', [FrontController::class, 'Reset'])->name('front.reset')->middleware('UserAuthCheck');
    Route::post('reset/password/{reset_code}', [AuthController::class, 'Reset'])->name('front.reset.action')->middleware('UserAuthCheck');
});

Route::group(['prefix' => ''], function () {
    Route::post('training_attendees', [GeneralController::class, 'training_attendees'])->name('front.training.attendees.action');
    Route::get('logout', [AuthController::class, 'Logout'])->name('front.logout');
});
