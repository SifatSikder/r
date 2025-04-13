<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AwarenessEvaluationController;
use App\Http\Controllers\BotEvaluationController;
use App\Http\Controllers\Admin\SpaController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\PortalController;

// Frontend portal routes
Route::get('/portal', [SpaController::class, 'portal'])->where('any', '.*')->name('front.portal')->middleware('UserAuthReq');
Route::get('/portal/{any}', [SpaController::class, 'portal'])->where('any', '.*')->name('front.portal.any')->middleware('UserAuthReq');

// API routes for user profile
Route::group(['prefix' => '/api/portal', 'middleware' => ['UserAuthReq']], function () {
    Route::group(['prefix' => 'profile', 'middleware' => ['UserAuthReq']], function () {
        // Update user profile
        Route::post('/update', [PortalController::class, 'profile_update_action'])->name('portal.user.profile.update.action');
        // Update user password
        Route::post('/update/password', [PortalController::class, 'profile_update_password_action'])->name('portal.user.profile.update.password.action');
    });

    // API routes for risk evaluation
    Route::group(['prefix' => 'evaluation', 'middleware' => ['UserAuthReq']], function () {
        // Get evaluation sectors
        Route::post('/sectors', [EvaluationController::class, 'evaluation_sectors'])->name('portal.evaluation.sectors');
        // Get fair decision evaluation sectors
        Route::post('/fd/sectors', [EvaluationController::class, 'evaluation_fd_sectors'])->name('portal.evaluation.fd.sectors');
        // Get Single fair decision evaluation sector
        Route::post('/fd/sector/details', [EvaluationController::class, 'evaluation_fd_sector_single'])->name('portal.evaluation.fd.sector.single');
        // Get evaluation question groups
        Route::post('/question/groups', [EvaluationController::class, 'evaluation_question_groups'])->name('portal.evaluation.question.groups');
        // Get technical evaluation questions
        Route::post('/technical/questions', [EvaluationController::class, 'evaluation_technical_questions'])->name('portal.evaluation.technical.questions');
        // Get non-technical evaluation questions
        Route::post('/non-technical/questions', [EvaluationController::class, 'evaluation_non_technical_questions'])->name('portal.evaluation.non.technical.questions');
        // Get fair decision evaluation questions
        Route::post('/fd/questions', [EvaluationController::class, 'evaluation_fd_questions'])->name('portal.evaluation.fd.questions');
        // Submit risk evaluation
        Route::post('/submit', [EvaluationController::class, 'risk_evaluation'])->name('portal.evaluation.submit');
    });

    // API routes for user-related actions
    Route::group(['prefix' => 'user', 'middleware' => ['UserAuthReq']], function () {
        // Get user evaluations
        Route::get('/evaluations', [PortalController::class, 'user_evaluations'])->name('portal.user.evaluations');
        // Delete user evaluation
        Route::post('/evaluation/delete', [EvaluationController::class, 'user_evaluation_delete'])->name('portal.user.evaluation.delete');
        // Get user evaluation details
        Route::post('/evaluation/details', [EvaluationController::class, 'user_evaluation_details'])->name('portal.user.evaluation.details');
        // Get user evaluation report
        Route::post('/evaluation/report', [EvaluationController::class, 'user_evaluation_report'])->name('portal.user.evaluation.report');
        // Get single user evaluation question
        Route::post('/evaluation/question/single', [EvaluationController::class, 'user_evaluation_question_single'])->name('portal.user.evaluation.question.single');
        // Get single user evaluation question with ChatGPT interaction
        Route::post('/evaluation/question/single/chatGPT', [EvaluationController::class, 'user_evaluation_question_single_chatGPT'])->name('portal.user.evaluation.question.single.chatGPT');
        // Update single user evaluation question
        Route::post('/evaluation/question/single/update', [EvaluationController::class, 'user_evaluation_question_single_update'])->name('portal.user.evaluation.question.single.update');
        // Get user evaluation certificate
        Route::get('/evaluation/certificate/{evaluation_id}', [EvaluationController::class, 'user_evaluation_certificate'])->name('portal.user.evaluation.certificate');
    });
});

// Frontend risk evaluation route
Route::get('/risk-evaluation/{any}', [SpaController::class, 'risk_evaluation'])->where('any', '.*')->name('front.risk.evaluation');

// Bot evaluation API routes
Route::post('/bot/evaluation/non-tech/questions', [BotEvaluationController::class, 'evaluation_non_tech_questions'])->name('api.bot.evaluation.fair.decision.questions');
Route::post('/bot/evaluation/submit', [BotEvaluationController::class, 'submit'])->name('api.bot.evaluation.submit');
Route::get('/bot/evaluation/report/{guest_id}', [BotEvaluationController::class, 'guest_report'])->name('api.bot.evaluation.report');
// Frontend bot evaluation route
Route::get('/bot-evaluation/{any}', [SpaController::class, 'bot_evaluation'])->where('any', '.*')->name('front.bot.evaluation');

// Awareness Evaluation route
Route::get('/awareness-evaluation/{any}', [SpaController::class, 'awareness_evaluation'])->where('any', '.*')->name('front.awareness.evaluation');
Route::get('/awareness/evaluation/sections/{type}', [AwarenessEvaluationController::class, 'get_awareness_evaluation']);
Route::post('/awareness/evaluation/sections/{type}', [AwarenessEvaluationController::class, 'post_awareness_evaluation']);
