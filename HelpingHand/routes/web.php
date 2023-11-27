<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OrganizationTypeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SkillCategoryController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SkillTypeController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\SubscriptionController;
use App\Models\EmployeeDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::group([

    'middleware' => ['LoginCheck'],
    'namespace' => 'Admin',

], function () {
    Route::get('/', [HomeController::class,'index'])->name('index');
    Route::post('/read_notification', [HomeController::class,'read_notification'])->name('read_notification');

    Route::group([

        'middleware' => ['permission:Edit-Subscrition'],
        'namespace' => 'Admin',
        'prefix' => 'subscription'

    ], function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('subscription');
        Route::get('/create', [SubscriptionController::class, 'create'])->name('subscription-add');
        Route::post('/create', [SubscriptionController::class, 'store'])->name('subscription-store');
        Route::post('/update', [SubscriptionController::class, 'update'])->name('subscription-update');
        Route::get('/{id}/edit', [SubscriptionController::class, 'edit'])->name('subscription-edit');
        Route::post('/delete', [SubscriptionController::class, 'delete'])->name('subscription-delete')->middleware('permission:Delete-Subscrition');
        Route::post('/get_subscription', [SubscriptionController::class, 'get_subscription'])->name('get_subscription');
    });

    Route::group([

        'middleware' => ['permission:Edit-Client'],
        'namespace' => 'Admin',
        'prefix' => 'client'

    ], function () {
        Route::get('/', [ClientController::class, 'index'])->name('client');
        Route::get('/create', [ClientController::class, 'create'])->name('client-add');
        Route::post('/create', [ClientController::class, 'store'])->name('client-store');
        Route::post('/update', [ClientController::class, 'update'])->name('client-update');
        Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('client-edit');
        Route::post('/delete', [ClientController::class, 'delete'])->name('client-delete')->middleware('permission:Delete-Client');
        Route::post('/renew', [ClientController::class, 'renew'])->name('client-renew');
        Route::get('/get_organizationtype_specialization', [ClientController::class, 'get_organizationtype_specialization'])->name('get_organizationtype_specialization');
    });
    Route::group([

        'middleware' => ['permission:Edit-OrganizationType'],
        'namespace' => 'Admin',
        'prefix' => 'organizationtype'

    ], function () {
        Route::get('/', [OrganizationTypeController::class, 'index'])->name('organizationtype');

        Route::get('/create', [OrganizationTypeController::class, 'create'])->name('organizationtype-add');
        Route::post('/create', [OrganizationTypeController::class, 'store'])->name('organizationtype-store');
        Route::post('/update', [OrganizationTypeController::class, 'update'])->name('organizationtype-update');
        Route::get('/{id}/edit', [OrganizationTypeController::class, 'edit'])->name('organizationtype-edit');
        Route::post('/delete', [OrganizationTypeController::class, 'delete'])->name('organizationtype-delete')->middleware('permission:Delete-Client');
        Route::get('/specialization/suggest', [OrganizationTypeController::class, 'specialization_suggest'])->name('organizationtype-specialization_suggest');
    });

    Route::group([

        'middleware' => ['permission:Edit-OrganizationType'],
        'namespace' => 'Admin',
        'prefix' => 'specialization'

    ], function () {
        Route::get('/', [SpecializationController::class, 'index'])->name('specialization');

        Route::get('/create', [SpecializationController::class, 'create'])->name('specialization-add');
        Route::post('/create', [SpecializationController::class, 'store'])->name('specialization-store');
        Route::post('/update', [SpecializationController::class, 'update'])->name('specialization-update');
        Route::get('/{id}/edit', [SpecializationController::class, 'edit'])->name('specialization-edit');
        Route::post('/delete', [SpecializationController::class, 'delete'])->name('specialization-delete')->middleware('permission:Delete-OrganizationType');
        // Route::get('/specialization/suggest', [SpecializationController::class, 'specialization_suggest'])->name('organizationtype-specialization_suggest');
    });

    Route::group([

        'middleware' => ['permission:Edit-Skills'],
        'namespace' => 'Admin',
        'prefix' => 'skills'

    ], function () {
        Route::get('/', [SkillController::class, 'index'])->name('skills');

        Route::get('/create', [SkillController::class, 'create'])->name('skills-add');
        Route::post('/create', [SkillController::class, 'store'])->name('skills-store');
        Route::post('/update', [SkillController::class, 'update'])->name('skills-update');
        Route::get('/{id}/edit', [SkillController::class, 'edit'])->name('skills-edit');
        Route::post('/delete', [SkillController::class, 'delete'])->name('skills-delete')->middleware('permission:Delete-Skills');
        Route::get('/skills/suggest', [SkillController::class, 'skill_category_suggest'])->name('skill-category_suggest');
    });

    Route::group([

        'middleware' => ['permission:Edit-Skills'],
        'namespace' => 'Admin',
        'prefix' => 'skill_category'

    ], function () {
        Route::get('/', [SkillCategoryController::class, 'index'])->name('skill_category');

        Route::get('/create', [SkillCategoryController::class, 'create'])->name('skill_category-add');
        Route::post('/create', [SkillCategoryController::class, 'store'])->name('skill_category-store');
        Route::post('/update', [SkillCategoryController::class, 'update'])->name('skill_category-update');
        Route::get('/{id}/edit', [SkillCategoryController::class, 'edit'])->name('skill_category-edit');
        Route::post('/delete', [SkillCategoryController::class, 'delete'])->name('skill_category-delete')->middleware('permission:Delete-Skills');
        // Route::get('/skill_type/suggest', [SkillTypeController::class, 'skill_type_suggest'])->name('organizationtype-specialization_suggest');
    });

    
    Route::group([

        'middleware' => ['permission:Edit-Question'],
        'namespace' => 'Admin',
        'prefix' => 'question'

    ], function () {
        Route::get('/', [QuestionController::class, 'index'])->name('question');

        Route::get('/create', [QuestionController::class, 'create'])->name('question-add');
        Route::post('/create', [QuestionController::class, 'store'])->name('question-store');
        Route::post('/update', [QuestionController::class, 'update'])->name('question-update');
        Route::get('/{id}/edit', [QuestionController::class, 'edit'])->name('question-edit');
        Route::post('/delete', [QuestionController::class, 'delete'])->name('question-delete')->middleware('permission:Delete-Question');
        // Route::get('/skill_type/suggest', [SkillTypeController::class, 'skill_type_suggest'])->name('organizationtype-specialization_suggest');
    });

    Route::group([

        'middleware' => ['permission:Edit-Question','role:ClientAdmin'],
        'namespace' => 'Admin',
        'prefix' => 'department'

    ], function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department');

        Route::get('/create', [DepartmentController::class, 'create'])->name('department-add');
        Route::post('/create', [DepartmentController::class, 'store'])->name('department-store');
        Route::post('/update', [DepartmentController::class, 'update'])->name('department-update');
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('department-edit');
        Route::post('/delete', [DepartmentController::class, 'delete'])->name('department-delete')->middleware('permission:Delete-Question');
        // Route::get('/skill_type/suggest', [SkillTypeController::class, 'skill_type_suggest'])->name('organizationtype-specialization_suggest');
    });


    Route::group([

        'middleware' => ['permission:Edit-Jobs'],
        'namespace' => 'Admin',
        'prefix' => 'jobs'

    ], function () {
        Route::get('/', [JobController::class, 'index'])->name('jobs');

        Route::get('/create', [JobController::class, 'create'])->name('jobs-add');
        Route::post('/create', [JobController::class, 'store'])->name('jobs-store');
        Route::post('/create-step/{step}', [JobController::class, 'validate_step'])->name('job_validate_step');
        Route::post('/update', [JobController::class, 'update'])->name('jobs-update');
        Route::get('/{id}/edit', [JobController::class, 'edit'])->name('jobs-edit');
       
        Route::post('/delete', [JobController::class, 'delete'])->name('jobs-delete')->middleware('permission:Delete-Jobs');
        Route::post('/complete', [JobController::class, 'complete'])->name('jobs-complete');
        Route::get('/question/suggest', [JobController::class, 'question_suggest'])->name('question_suggest');
        // Route::get('/skill_type/suggest', [SkillTypeController::class, 'skill_type_suggest'])->name('organizationtype-specialization_suggest');
    });

    Route::group([

        'middleware' => ['permission:Edit-Candidate|Edit-JobApplicant'],
        'namespace' => 'Admin',
        'prefix' => 'candidates'

    ], function () {
        Route::get('/', [CandidateController::class, 'index'])->name('candidates');
        Route::get('/category/{cat}', [CandidateController::class, 'category_index'])->name('category_candidates')->middleware(['role:SuperAdmin|HIMSubUser']);
        Route::get('screening_candidates', [CandidateController::class, 'screening_candidates'])->name('screening_candidates');

       
        
        Route::get('/{id}/view', [CandidateController::class, 'show'])->name('candidates-view');
        Route::post('/update', [CandidateController::class, 'update'])->name('candidates-update');
        Route::post('/candidate_summary_update', [CandidateController::class, 'candidate_summary_update'])->name('candidate_summary_update');
        Route::get('/{id}/edit', [CandidateController::class, 'edit'])->name('candidates-edit');
        Route::post('/delete', [CandidateController::class, 'delete'])->name('candidates-delete')->middleware('permission:Delete-Candidate');
        Route::post('/send_registration_link', [CandidateController::class, 'send_registration_link'])->name('send_registration_link');
        Route::post('/refer_candidate', [CandidateController::class, 'refer_candidate'])->name('refer_candidate');
        
       
    });
    Route::post('/create_interview', [InterviewController::class, 'create_interview'])->name('create_interview');
    Route::post('/cancel_interview', [InterviewController::class, 'cancel_interview'])->name('cancel_interview');


    
   

    Route::group([

        'middleware' => ['permission:Edit-JobApplicant|Edit-Candidate'],
        'namespace' => 'Admin',
        'prefix' => '/applicants'


    ], function () {
        Route::get('completed',[ApplicantController::class,'completed'])->name('jobs-applicants-completed');
       
        Route::get('/{id}', [ApplicantController::class, 'index'])->name('jobs-applicants');        
        Route::get('/{id}/view', [ApplicantController::class, 'show'])->name('applicant-view');
        Route::get('stage/{id}/view', [ApplicantController::class, 'stage_view'])->name('applicant-stage_view');
        Route::get('stage/{id}/review', [ApplicantController::class, 'stage_review'])->name('applicant-stage_review');
        Route::post('/proceed', [ApplicantController::class, 'proceed'])->name('applicant-proceed');
        Route::post('/review_proceed', [ApplicantController::class, 'review_proceed'])->name('applicant-review_proceed');
        Route::post('/screen_pass', [ApplicantController::class, 'screen_pass'])->name('applicant_screen_pass');
        Route::post('/stage_reject', [ApplicantController::class, 'stage_reject'])->name('applicant_stage_reject');

        // Route::get('practical_evaluation',[EvaluationController::class,'practical_evaluation'])->name('jobs-applicants-practical_evaluation');
      
       
    });

    Route::group([
        'middleware' => ['permission:Edit-JobApplicant|Edit-Candidate'],
        'namespace' => 'Admin',
        'prefix' => '/applicant'
    ],function(){
       Route::get('practical_evaluation',[EvaluationController::class,'practical_evaluation'])->name('jobs-applicants-practical_evaluation');
        Route::post('/add_study_material', [EvaluationController::class, 'add_study_material'])->name('applicant_add_study_material');
        Route::post('/extend_submission_date', [EvaluationController::class, 'extend_submission_date'])->name('applicant_extend_submission_date');
        Route::post('/schedule_panel', [EvaluationController::class, 'schedule_panel'])->name('applicant_schedule_panel');
        Route::post('/reschedule_panel', [EvaluationController::class, 'reschedule_panel'])->name('applicant_reschedule_panel');
        Route::post('/schedule_applicant', [EvaluationController::class, 'schedule_applicant'])->name('applicant_schedule_applicant');
    });

    Route::group([

        'middleware' => ['role:SuperAdmin'],
        'namespace' => 'Admin',
        'prefix' => 'admin/user'

    ], function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin_user');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin_user_add');
        Route::post('/create', [AdminUserController::class, 'store'])->name('admin_user_store');
        Route::post('/update', [AdminUserController::class, 'update'])->name('admin_user_update');
        Route::get('/{id}/edit', [AdminUserController::class, 'edit'])->name('admin_user_edit');
        Route::post('/delete', [AdminUserController::class, 'delete'])->name('admin_user_delete');
       
    });

});



Route::get('/create/{id}', [CandidateController::class, 'create'])->name('candidates-add');
Route::post('/create', [CandidateController::class, 'store'])->name('candidates-store');
Route::get('/interview/option/candidate/{user_id}/{candidate_id}', [InterviewController::class, 'interview_option_candidate'])->name('interview_option_candidate');
Route::get('/interview/option/job_applicant/{job_applicant_id}', [InterviewController::class, 'interview_option_applicant'])->name('interview_option_applicant');
Route::post('/interview/confirm/candidate', [InterviewController::class, 'interview_option_confirm'])->name('interview_option_confirm');
Route::get('/test/mail', [CandidateController::class, 'test'])->name('test-mail');

Route::get('panel_interview/{job_applicant_id}/confirm/{panel_id}/',[EvaluationController::class,'panel_interview_confirm'])->name('panel_interview_confirm');
Route::post('panel_interview/',[EvaluationController::class,'panel_interview_confirm_post'])->name('panel_interview_confirm_post');
Route::get('panel_scoring/{job_applicant_id}/{panel_id}/{expiration_date}',[EvaluationController::class,'panel_scoring_page'])->name('jobs-applicants-panel_scoring');
Route::post('panel_scoring/submit',[EvaluationController::class,'panel_score_submit'])->name('jobs-applicants-panel_score_submit');

Route::get('submit/casestudy/{job_applicant_id}/',[EvaluationController::class,'add_case_study'])->name('add_case_study');
Route::post('submit/casestudy//',[EvaluationController::class,'store_case_study'])->name('store_case_study');


Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/RoleCreate',[AuthController::class, 'RoleCreate'])->name('RoleCreate');
Route::get('/assignEmployeePermission', [AuthController::class, 'assignEmployeePermission'])->name('assignEmployeePermission');
Route::get('/assignSubPermission', [AuthController::class, 'assignSubPermission'])->name('assignSubPermission');
Route::get('/assignStagePermission', [AuthController::class, 'assignStagePermission'])->name('assignStagePermission');
Route::get('/PermissionCreate', [AuthController::class, 'PermissionCreate'])->name('PermissionCreate');
Route::get('/assignRole', [AuthController::class, 'assignRole'])->name('assignRole');
Route::post('/login', [AuthController::class, 'post_login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'login'])->name('register');

include(base_path('routes/client.php'));






Route::get('table/basic', function () {
    return view('tables-basic');
});
Route::get('table/datatable', function () {
    return view('tables-datatable');
});
Route::get('table/editable', function () {
    return view('tables-editable');
});
Route::get('table/responsive', function () {
    return view('tables-responsive');
});
Route::get('icon/fontawesome', function () {
    return view('icons-fontawesome');
});
Route::get('icon/dripicons', function () {
    return view('icons-dripicons');
});
Route::get('icon/materialdesign', function () {
    return view('icons-materialdesign');
});
Route::get('icon/feather', function () {
    return view('icons-feather');
});
Route::get('forms/advanced', function () {
    return view('forms-advanced');
});
Route::get('forms/editors', function () {
    return view('forms-editors');
});
Route::get('forms/elements', function () {
    return view('forms-elements');
});
Route::get('forms/repeater', function () {
    return view('forms-repeater');
});
Route::get('forms/uploads', function () {
    return view('forms-uploads');
});
Route::get('forms/validation', function () {
    return view('forms-validation');
});
Route::get('forms/x', function () {
    return view('forms-x-editable');
});
Route::get('sweetalert', function () {
    return view('advanced-sweetalerts');
});

Route::get('/clear-cache',function(){
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return redirect()->route('index');
});
Route::get('/migrate',function(){
    Artisan::call('migrate');
    return redirect()->route('index');
});