<?php

use App\Http\Controllers\ApiLoginController;
use App\Http\Controllers\ApiRegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiAdminController;
use App\Http\Controllers\v1\General\GeneralApiController;
use App\Http\Controllers\v1\Paid\PaidApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function () {
    // Fetch Judgement Detals
    Route::group(['prefix' => 'judgement'], function () {
        Route::get('/show/details', [GeneralApiController::class, 'showJudgement']);
    });
    // Fetch Law Of Federation Detals
    Route::group(['prefix' => 'law_of_fed'], function () {
        Route::get('/show/details', [GeneralApiController::class, 'showLawOfFed']);
    });
    // Fetch Rule of Court Detals
    Route::group(['prefix' => 'rule_of_court'], function () {
        Route::get('/show/details', [GeneralApiController::class, 'showRuleOfCourt']);
    });
});

Route::group(['middleware' => ['cors', 'json.response', 'XSS']], function () {
    // public routes
    Route::post('/register', [ApiRegisterController::class, "register"]);
    Route::post('/login', [ApiLoginController::class, "login"]);
    // Route::get('/admin/all-judgements', [ApiAdminController::class, 'allJudgement']);
    Route::get('/admin/all-judgements', [ApiAdminController::class, 'allJudgement']);
    Route::get('/admin/judgements/allsubject-matter', [ApiAdminController::class, 'allSbjMatter']);
    Route::get('/admin/judgements/all-legal-citation', [ApiAdminController::class, 'allLegalCitation']);
    Route::get('/admin/judgements/subject-matter-indices', [ApiAdminController::class, 'subject_matter_indices']);
    Route::get('/admin/all-rules-of-court', [ApiAdminController::class, 'allRules']);
    Route::get('/admin/all-legal-maxims', [ApiAdminController::class, 'allMaxim']);
    Route::get('/admin/all-law-dictionary', [ApiAdmincontroller::class, 'allDictionary']);
    Route::get('/admin/all-law-of-fed', [ApiAdmincontroller::class, 'allFed']);
    Route::get('/admin/all-forms', [ApiAdmincontroller::class, 'allForms']);
    Route::get('/admin/all-rule-categories', [ApiAdmincontroller::class, 'allRuleCategorie']);
    Route::get('/admin/all-articles', [ApiAdmincontroller::class, 'allArticles']);
    Route::get('/admin/all-foreign-resources', [ApiAdmincontroller::class, 'allForeignResources']);
    Route::get('/admin/judgements/details', [ApiAdminController::class, 'judgementDetails']);
    // Route::get('/admin/all-state', [ApiAdmincontroller::class, 'allState']);
    Route::get('/admin/judgements/by', [ApiAdminController::class, 'judgementDetailsByDate']);

});

Route::middleware(['auth:sanctum', 'XSS'])->group(function () {
    // Protected Routes are in here
    Route::post('/logout', [ApiLoginController::class, "logout"]);

    Route::get('/admin/dashboard', [ApiAdminController::class, 'index']);

    //court
    Route::get('/admin/judgements/courts', [ApiAdminController::class, 'court']);

    //subject matter index
    Route::get('/admin/judgements/subject-matter-index', [ApiAdminController::class, 'getSbj']);

    //Judgement routes
    Route::get('/admin/judgements', [ApiAdminController::class, 'judgement']);
    Route::get('/admin/judgements/legal-citation', [ApiAdminController::class, 'legalCitation']);
    Route::get('/admin/judgements/subject-matter', [ApiAdminController::class, 'sbjMatter']);
    Route::get('/admin/judgements/no-summary', [ApiAdminController::class, 'noSummary']);
    Route::get('/admin/judgements/create', [ApiAdminController::class, 'create']);
    Route::post('/admin/judgements', [ApiAdminController::class, 'storeJudgement']);
    Route::get('/admin/judgements/{id}', [ApiAdminController::class, 'showJudgement']);
    Route::get('/admin/judgements/edit/{id}', [ApiAdminController::class, 'editJudgement']);
    Route::patch('/admin/judgements/edit/{id}', [ApiAdminController::class, 'updateJudgement']);
    Route::delete('/admin/judgements/{id}', [ApiAdminController::class, 'deleteJudgement']);

    Route::get('/admin/rules-of-court', [ApiAdminController::class, 'rules']);

    Route::get('/admin/rules-of-court/categories', [ApiAdminController::class, 'ruleCat']);

    Route::get('/admin/rules-of-court/{id}', [ApiAdminController::class, 'showRule']);

    Route::get('/admin/rules-of-court/fetch-annotations/{id}', [ApiAdminController::class, 'fetchRuleAnote']);

    Route::get('/admin/state-rules-of-court', [ApiAdminController::class, 'state_rules']);
    Route::get('/admin/state-rules-of-court/{id}', [ApiAdminController::class, 'showStateRule']);
    Route::get('/admin/state-rules-of-court/fetch-annotations/{id}', [ApiAdminController::class, 'fetchStateRuleAnote']);

    Route::get('/admin/laws-of-federation', [ApiAdminController::class, 'fed']);
    Route::get('/admin/laws-of-federation/{id}', [ApiAdminController::class, 'showFed']);
    Route::get('/admin/laws-of-federation/fetch-annotations/{id}', [ApiAdminController::class, 'fetchLawAnote']);

    Route::get('/admin/areas-of-laws', [ApiAdminController::class, 'area_of_law']);

    Route::get('/admin/categories', [ApiAdminController::class, 'category']);

    Route::get('/admin/forms-and-precedents', [ApiAdminController::class, 'forms']);
    Route::get('/admin/forms-and-precedents/{id}', [ApiAdminController::class, 'showForm']);
    Route::get('/admin/forms-and-precedents/fetch-annotations/{id}', [ApiAdminController::class, 'fetchFormAnote']);

    Route::get('/admin/legal-articles/fetch-annotations/{id}', [ApiAdminController::class, 'fetchArticleAnote']);
    Route::get('/admin/legal-articles', [ApiAdminController::class, 'articles'])->name('admin.articles');
    Route::post('/admin/legal-articles/create', [ApiAdminController::class, 'storeArticle']);
    Route::get('/admin/legal-articles/{id}', [ApiAdminController::class, 'showArticle']);
    Route::post('/admin/legal-articles/rate-article/{id}', [ApiAdminController::class, 'rateArticle']);

    Route::get('/admin/law-dictionary', [ApiAdmincontroller::class, 'dictionary']);

    Route::get('/admin/legal-maxims', [ApiAdminController::class, 'maxim']);

    Route::get('/admin/resources', [ApiAdminController::class, 'resource']);

    Route::get('/admin/featured-content', [ApiAdminController::class, 'featuredContent']);

    Route::get('/admin/subscriptions', [ApiAdminController::class, 'subscription']);

    Route::get('/admin/discount', [ApiAdminController::class, 'discount']);

    Route::patch('/checkout/{id}', [ApiAdminController::class, 'useDiscount']);

    Route::get('/admin/transactions', [ApiAdmincontroller::class, 'transaction']);

    Route::get('/admin/teams', [ApiAdminController::class, 'team']);

    Route::get('/admin/teams/{id}', [ApiAdminController::class, 'showTeam']);

    Route::get('/admin/teams/{id}/join', [ApiAdminController::class, 'joinTeam']);

    Route::get('/admin/search', [ApiAdminController::class, 'search']);

    Route::get('/admin/year', [ApiAdminController::class, 'years']);

    Route::get('/admin/filter-sbj', [ApiAdminController::class, 'filterSbj']);

    Route::get('/admin/notes', [ApiAdminController::class, 'note']);

    // Route::apiResource('/employee', EmployeeController::class)->middleware('api.authenticate');
});

Route::group(['prefix' => 'v1', "middleware" => ["auth:api", "paidapi", "XSS"]], function () {

    //Judgement Routes
    Route::group(['prefix' => 'judgements'], function () {
        Route::post('/', [PaidApiController::class, 'judgement']);
        Route::post('/court', [PaidApiController::class, 'court']);
        Route::post('/subject_matter_index', [PaidApiController::class, 'subjectMatterIndex']);
        Route::post('/legal_citation', [PaidApiController::class, 'legalCitation']);
        Route::post('/subject_matter', [PaidApiController::class, 'sbjMatter']);
        Route::post('/no_summary', [PaidApiController::class, 'noSummary']);
        Route::get('/{id}', [PaidApiController::class, 'showJudgement']);
    });

    //Laws of Federation Routes
    Route::group(['prefix' => 'laws_of_federation'], function () {
        Route::post('/', [PaidApiController::class, 'fed']);
        Route::post('/category', [PaidApiController::class, 'fedCategory']);
        Route::get('/{id}', [PaidApiController::class, 'showFed']);
    });

    //Rules Of Court Routes
    Route::group(['prefix' => 'rules_of_court'], function () {
        Route::post('/', [PaidApiController::class, 'rules']);
        Route::post('/state_rules', [PaidApiController::class, 'stateRules']);
        Route::post('/rule_category', [PaidApiController::class, 'ruleCategory']);
        Route::post('/states', [PaidApiController::class, 'states']);
        Route::get('/{id}', [PaidApiController::class, 'showRule']);
        Route::post('/categories', [PaidApiController::class, 'ruleCat']);
    });

    //Forms And Precedents Routes
    Route::group(['prefix' => 'forms_and_precedents'], function () {
        Route::post('/', [PaidApiController::class, 'forms']);
        Route::post('/category', [PaidApiController::class, 'formCategory']);
        Route::get('/{id}', [PaidApiController::class, 'showForm']);
    });

    //Articles And Journal Routes
    Route::group(['prefix' => 'articles_and_journals'], function () {
        Route::post('/', [PaidApiController::class, 'articles']);
        Route::post('/category', [PaidApiController::class, 'articleCategory']);
        Route::get('/{id}', [PaidApiController::class, 'showArticle']);
    });

    //Law and Dictionary Routes
    Route::group(['prefix' => 'law_dictionary'], function () {
        Route::post('/', [PaidApiController::class, 'dictionary']);
        Route::post('/category', [PaidApiController::class, 'dictionaryCategory']);
        Route::get('/{id}', [PaidApiController::class, 'showDictionary']);
    });

    //Law and Dictionary Routes
    Route::group(['prefix' => 'legal_maxims'], function () {
        Route::post('/', [PaidApiController::class, 'maxim']);
        Route::post('/category', [PaidApiController::class, 'legalMaximCategory']);
        Route::get('/{id}', [PaidApiController::class, 'showLegalMaxim']);
    });
});


// Route::post('/register', [ApiRegisterController::class, "register"]);
// Route::post('/login', [ApiLoginController::class, "login"]);
// Route::get('/login', [ApiLoginController::class, "login"]);
// Route::post('/logout', [ApiLoginController::class, "logout"]);
