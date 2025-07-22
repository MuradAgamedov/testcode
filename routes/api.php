<?php

use App\Http\Controllers\Api\AuthInfoController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\HrVacancyController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\TaskAnswerController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserEducationController;
use App\Http\Controllers\Api\UserInfoController;
use App\Http\Controllers\Api\UserInterviewController;
use App\Http\Controllers\Api\UserSocialController;
use App\Http\Controllers\Api\UserWorkExperienceController;
use App\Http\Controllers\Api\VacancyApplicationController;
use App\Http\Controllers\Api\VacancyApplicationInterviewController;
use App\Http\Controllers\Api\VacancyApplicationTaskController;
use App\Http\Controllers\Api\VacancyController;
use App\Http\Controllers\Api\VacancyTechnicalTaskController;
use App\Http\Controllers\Api\WishlistJobController;
use App\Http\Controllers\Api\UserQuestionScoreController;
use App\Http\Controllers\Api\UserTopicScoreController;
use App\Http\Controllers\Api\VacancySkillController;
use App\Http\Controllers\Api\WorkerVacancyApplyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionAnswerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Handle OPTIONS requests for CORS preflight
Route::options('/register', function () {
    return response()->json([], 200);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//
//// Authenticated routes
//Route::middleware('auth:api')->group(function () {
//    Route::get('/me', fn () => response()->json(auth()->user()));
//    Route::post('/logout', [AuthController::class, 'logout']);
//    Route::post('/questions/{id}/answer', [QuestionAnswerController::class, 'submit']);
//    Route::apiResource('vacancies', VacancyController::class);
//    Route::post('/vacancies/{vacancy}/technical-task', [\App\Http\Controllers\Api\VacancyTechnicalTaskController::class, 'store']);
//    Route::middleware('auth:api')->put('/user-info/{user}', [\App\Http\Controllers\Api\UserInfoController::class, 'update']);
//    Route::get('/skills', [SkillController::class, 'index']);
//    Route::post('/skills/assign', [SkillController::class, 'assignSkill']);
//    Route::post('/skills/remove', [SkillController::class, 'removeSkill']);
//    Route::get('/users/{id}/skills', [SkillController::class, 'getUserSkills']);
//    Route::apiResource('vacancy-applications', VacancyApplicationController::class);
//    Route::apiResource('application-interviews', VacancyApplicationInterviewController::class);
//    Route::get('wishlist-jobs', [WishlistJobController::class, 'index']);
//    Route::post('wishlist-jobs', [WishlistJobController::class, 'store']);
//    Route::delete('wishlist-jobs/{id}', [WishlistJobController::class, 'destroy']);
//    Route::get('vacancy/intern', [\App\Http\Controllers\Api\VacancyController::class, 'internVacancies']);
//    Route::apiResource('task-answers', TaskAnswerController::class);
//    Route::post('/vacancy-application-tasks', [VacancyApplicationTaskController::class, 'store']);
//});
//

Route::post('/auth/refresh', function (Request $request) {
    try {
        $guard = $request->header('X-Auth-Guard', 'api'); // default api

        auth()->shouldUse($guard); // bu sətir vacibdir!

        $newToken = JWTAuth::parseToken()->refresh();

        return response()->json([
            'access_token' => $newToken,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    } catch (JWTException $e) {
        return response()->json(['error' => 'Token yenilənmədi'], 401);
    }
});

Route::prefix('hr')->middleware('auth:hr')->group(function () {
    Route::get('/me', fn () => response()->json(auth('hr')->user()));
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);

    Route::get('/vacancies', [VacancyController::class, 'index']);
    Route::post('/vacancies', [VacancyController::class, 'store']);
    // Route::get('/vacancy/{id}', [VacancyController::class, 'show']);
    Route::put('/vacancies/{vacancy}', [VacancyController::class, 'update']);
    Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'destroy']);
    Route::post('/vacancies/{vacancy}/technical-task', [VacancyTechnicalTaskController::class, 'store']);
    Route::apiResource('application-interviews', VacancyApplicationInterviewController::class);
    Route::apiResource('task-answers', TaskAnswerController::class);
    Route::patch('users/{user}/vacancies/{vacancy}/status', [VacancyApplicationController::class, 'updateUserApplicationStatus']);
    // Route::get('/hr/vacancy-applications', [VacancyApplicationController::class, 'index']);
    Route::get('/vacancy-applications', [VacancyApplicationController::class, 'getVacancyApplications']);
    Route::put('/vacancy-applications/{id}', [VacancyApplicationController::class, 'update']);


    Route::get('/user-question-scores', [UserQuestionScoreController::class, 'filterByScore']);
    Route::get('/vacancies/{vacancy}/skills', [VacancySkillController::class, 'index']);
    Route::post('/vacancies/{vacancy}/skills', [VacancySkillController::class, 'store']);
    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/skills', [SkillController::class, 'index']);

    Route::get('/employees', [EmployeeController::class, 'index']);

    Route::post('/change-password', [UserController::class, 'changePassword']);
Route::get('/user-topic-scores', [UserTopicScoreController::class, 'index']); // token-based
Route::get('/user-topic-scores/{user}', [UserTopicScoreController::class, 'show']); // ID-based


    
});


Route::apiResource('questions', QuestionController::class);
Route::post('questions/{question}/options', [QuestionOptionController::class, 'store']);


Route::get('/test-vacancy-skills/{vacancy}', [VacancySkillController::class, 'index']);
Route::get('/skills', [SkillController::class, 'index']);






Route::middleware(['auth:worker', 'worker'])->group(function () {
    Route::get('/me', fn () => response()->json(auth('worker')->user()));
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/questions/{id}/answer', [QuestionAnswerController::class, 'submit']);
    Route::put('/user-info/{user}', [UserInfoController::class, 'update']);


    Route::post('/skills/assign', [SkillController::class, 'assignSkill']);
    Route::post('/skills/remove', [SkillController::class, 'removeSkill']);
    Route::get('/users/{id}/skills', [SkillController::class, 'getUserSkills']);

    Route::apiResource('vacancy-applications', VacancyApplicationController::class);
    Route::post('/vacancy-application-tasks', [VacancyApplicationTaskController::class, 'store']);
    Route::get('wishlist-jobs', [WishlistJobController::class, 'index']);
    Route::post('wishlist-jobs', [WishlistJobController::class, 'store']);
    Route::delete('wishlist-jobs/{vacancy}', [WishlistJobController::class, 'destroy']);


    Route::apiResource('application-interviews', VacancyApplicationInterviewController::class);
    
    Route::get('/vacancies', [VacancyController::class, 'indexForWorker']);
    Route::get('vacancy/intern', [VacancyController::class, 'internVacancies']);
    Route::get('/vacancies/matched', [VacancyController::class, 'matchedVacancies']);
    Route::apiResource('user-socials', UserSocialController::class);



    Route::post('/user-education', [UserEducationController::class, 'store']);
    Route::put('/user-education/{id}', [UserEducationController::class, 'update']);
    Route::delete('/user-education/{id}', [UserEducationController::class, 'destroy']);
    Route::get('/user/interviews', [UserInterviewController::class, 'index']);

    //Topics
    Route::get('topics', [TopicController::class, 'index']);

    //Category
    Route::get('categories', [CategoryController::class, 'index']);

    //Roles
    Route::get('roles', [RoleController::class, 'index']);

    Route::apiResource('task-answers', TaskAnswerController::class);

    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/vacancy-apply', [WorkerVacancyApplyController::class, 'apply']);
    // Route::get('/vacancy/{id}', [VacancyController::class, 'show']);
    Route::post('/vacancies/{id}/increment-view', [VacancyController::class, 'incrementView']);
    Route::get('/vacancies/{vacancy}/applicants-count', [VacancyController::class, 'applicantsCount']);

    Route::get('/user-work-experience', [UserWorkExperienceController::class, 'index']);
    Route::post('/user-work-experience', [UserWorkExperienceController::class, 'store']);
    Route::put('/user-work-experience/{id}', [UserWorkExperienceController::class, 'update']);
    Route::delete('/user-work-experience/{id}', [UserWorkExperienceController::class, 'destroy']);

    Route::get('/user/skills', [SkillController::class, 'index']);
    Route::post('/user/skills', [SkillController::class, 'assignSkill']);
    Route::delete('/user/skills/remove', [SkillController::class, 'removeSkill']);
    Route::get('/user/skills', [SkillController::class, 'getUserSkills']);

    Route::post('/user/educations', [UserEducationController::class, 'store']);
    Route::put('/user/educations/{id}', [UserEducationController::class, 'update']);
    Route::delete('/user/educations/{id}', [UserEducationController::class, 'destroy']);

    Route::get('/user/social-links', [UserSocialController::class, 'index']);
    Route::post('/user/social-links', [UserSocialController::class, 'store']);
    Route::get('/user/social-links/{id}', [UserSocialController::class, 'show']);
    Route::put('/user/social-links/{id}', [UserSocialController::class, 'update']);
    Route::delete('/user/social-links/{id}', [UserSocialController::class, 'destroy']);

    Route::post('/contact', [ContactController::class, 'store']);

    Route::post('/feedback', [FeedbackController::class, 'store']);

    Route::post('/questions/{id}/submit', [QuestionAnswerController::class, 'submit']);
    Route::get('/user-topic-scores', [UserTopicScoreController::class, 'index']);


    });



Route::get('/auth-info', [AuthInfoController::class, 'show']);
Route::middleware('auth:worker')->get('/me', fn () => response()->json(auth('worker')->user()));
Route::get('/leaderboard', [LeaderboardController::class, 'index']);
Route::middleware(['auth:hr,worker'])->get('/vacancy/{id}', [VacancyController::class, 'show']);
