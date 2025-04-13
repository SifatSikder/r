<?php

use App\Http\Controllers\Admin\Api\AuthController;
use App\Http\Controllers\Admin\Api\AwarenessController;
use App\Http\Controllers\Admin\Api\AwarenessQuestionController;
use App\Http\Controllers\Admin\Api\AwarenessEvaluationController;
use App\Http\Controllers\Admin\Api\CertificateController;
use App\Http\Controllers\Admin\Api\EvaluationSectorsController;
use App\Http\Controllers\Admin\Api\MediaController;
use App\Http\Controllers\Admin\Api\QuestionController;
use App\Http\Controllers\Admin\Api\BlogController;
use App\Http\Controllers\Admin\Api\ReportController;
use App\Http\Controllers\Admin\Api\RiskFactorController;
use App\Http\Controllers\Admin\Api\WebsiteSettingsController;
use App\Http\Controllers\Admin\Api\WorkshopController;
use App\Http\Controllers\Admin\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Group of routes related to authentication
Route::group(['prefix' => 'auth'], function () {
    // Authentication routes
    Route::post('login', [AuthController::class, 'Login'])->middleware('AdminAuthCheck');
    Route::post('logout', [AuthController::class, 'Logout'])->middleware('AdminAuthReqCheck');
    Route::post('forgot/request', [AuthController::class, 'Forgot'])->middleware('AdminAuthCheck');
    Route::post('reset/password', [AuthController::class, 'Reset'])->middleware('AdminAuthCheck');
});

// Routes that require authentication
Route::middleware('AdminAuthReqCheck')->group(function () {
    // General routes
    Route::prefix('general')->group(function () {
        Route::post('me', [AuthController::class, 'GetProfile']);
        Route::post('profile/update', [AuthController::class, 'UpdateProfile']);
        Route::post('change/password', [AuthController::class, 'ChangePassword']);
    });

    // Dashboard and report routes
    Route::prefix('dashboard/report')->group(function () {
        Route::post('evaluations', [ReportController::class, 'evaluation_report']);
        Route::post('fair-decision', [ReportController::class, 'fair_decision_report']);
        Route::post('registered-users', [ReportController::class, 'registered_users_report']);
    });

    // Evaluation routes
    Route::prefix('evaluation')->group(function () {
        // Risk Factors routes
        Route::prefix('risk-factor')->group(function () {
            Route::post('get/all', [RiskFactorController::class, 'GetAll']);
            Route::post('manage', [RiskFactorController::class, 'Manage']);
        });

        // Evaluation Sectors routes
        Route::prefix('sector')->group(function () {
            Route::post('get/all', [EvaluationSectorsController::class, 'GetAll']);
            Route::post('manage', [EvaluationSectorsController::class, 'Manage']);
        });

        // Fair Decision Sectors routes
        Route::prefix('fd/sector')->group(function () {
            Route::post('get/all', [EvaluationSectorsController::class, 'GetAllFdSectors']);
            Route::post('manage', [EvaluationSectorsController::class, 'ManageFdSectors']);
        });

        // Question Groups routes
        Route::prefix('question/groups')->group(function () {
            Route::post('get/all', [EvaluationSectorsController::class, 'GetAllQuestionGroups']);
            Route::post('manage', [EvaluationSectorsController::class, 'ManageQuestionGroups']);
        });

        // Awareness Evaluation routes
        Route::prefix('awareness')->group(function () {

            Route::post('list', [AwarenessController::class, 'list']);
            Route::post('create', [AwarenessController::class, 'create']);
            Route::get('single/{id}', [AwarenessController::class, 'single']);
            Route::post('update/{id}', [AwarenessController::class, 'update']);
            Route::delete('delete/{id}', [AwarenessController::class, 'delete']);
            Route::prefix('{awareness_id}/topic')->group(function () {
                Route::get('list', [AwarenessController::class, 'topic_list']);
                Route::post('create', [AwarenessController::class, 'topic_create']);
                Route::post('update/{id}', [AwarenessController::class, 'topic_update']);
                Route::delete('delete/{id}', [AwarenessController::class, 'topic_delete']);
                Route::prefix('{topic_id}/lesson')->group(function () {
                    Route::get('list', [AwarenessController::class, 'topic_lesson_list']);
                    Route::post('create', [AwarenessController::class, 'topic_lesson_create']);
                    Route::get('single/{id}', [AwarenessController::class, 'topic_lesson_single']);
                    Route::post('update/{id}', [AwarenessController::class, 'topic_lesson_update']);
                    Route::delete('delete/{id}', [AwarenessController::class, 'topic_lesson_delete']);
                    Route::prefix('{lesson_id}/question')->group(function () {
                        Route::post('manage', [AwarenessQuestionController::class, 'manage']);
                        Route::delete('delete/{id}', [AwarenessQuestionController::class, 'delete']);
                    });
                });
            });


            Route::prefix('section')->group(function () {
                Route::get('list/{type}', [AwarenessEvaluationController::class, 'section_list']);
                Route::post('create', [AwarenessEvaluationController::class, 'section_create']);
                Route::post('update/{id}', [AwarenessEvaluationController::class, 'section_update']);
                Route::get('delete/{id}', [AwarenessEvaluationController::class, 'section_delete']);

                Route::prefix('question')->group(function () {
                    Route::post('manage', [AwarenessEvaluationController::class, 'section_question_manage']);
                    Route::post('delete/{id}', [AwarenessEvaluationController::class, 'section_question_delete']);
                });

            });
        });
    });

    // Website Settings routes
    Route::prefix('website_settings')->group(function () {
        Route::post('store', [WebsiteSettingsController::class, 'StoreSettings']);
        Route::post('/{type}', [WebsiteSettingsController::class, 'GetSettings']);
    });

    // Question routes
    Route::prefix('question')->group(function () {
        Route::post('list', [QuestionController::class, 'List']);
        Route::post('manage', [QuestionController::class, 'Manage']);
        Route::post('delete', [QuestionController::class, 'Delete']);
    });

    // Blog routes
    Route::prefix('blog')->group(function () {
        Route::post('', [BlogController::class, 'upsert']);
        Route::get('', [BlogController::class, 'list']);
        Route::get('/{blog_id}', [BlogController::class, 'getBlog']);
        Route::put('/{blog_id}', [BlogController::class, 'upsert']);
        Route::delete('/delete/{blog_id}', [BlogController::class, 'delete']);
    });

    // User routes
    Route::prefix('user')->group(function () {
        Route::post('list', [UserController::class, 'list']);
        Route::post('create', [UserController::class, 'create']);
        Route::post('single', [UserController::class, 'single']);
        Route::post('update', [UserController::class, 'update']);
        Route::post('delete', [UserController::class, 'delete']);
    });

    // Workshop routes
    Route::prefix('workshop')->group(function () {
        Route::post('list', [WorkshopController::class, 'list']);
        Route::post('create', [WorkshopController::class, 'create']);
        Route::post('single', [WorkshopController::class, 'single']);
        Route::post('certificates', [WorkshopController::class, 'certificates']);
        Route::post('update', [WorkshopController::class, 'update']);
        Route::post('delete', [WorkshopController::class, 'delete']);
    });

    // Evaluation Certificate routes
    Route::prefix('evaluation/certificate')->group(function () {
        Route::post('settings', [CertificateController::class, 'evaluation_certificate_settings']);
        Route::post('settings/update', [CertificateController::class, 'evaluation_certificate_settings_update']);
        Route::post('list', [CertificateController::class, 'evaluation_certificates']);
    });

    // Participant Certificate routes
    Route::prefix('participant/certificate')->group(function () {
        Route::post('list', [CertificateController::class, 'participant_certificates']);
    });

    // Media routes
    Route::prefix('media')->group(function () {
        Route::post('upload', [MediaController::class, 'Upload']);
    });
});
