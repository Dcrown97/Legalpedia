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

Route::middleware(['auth:api', 'XSS'])->group(function () {
    // Protected Routes are in here
    Route::post('/logout', [ApiLoginController::class, "logout"]);

    Route::get('/admin/dashboard', [ApiAdminController::class, 'index'])->name('admin.dashboard');

    //court
    Route::get('/admin/judgements/courts', [ApiAdminController::class, 'court'])->name('admin.court');

    //subject matter index
    Route::get('/admin/judgements/subject-matter-index', [ApiAdminController::class, 'getSbj'])->name('get.sbj');

    //Judgement routes
    Route::get('/admin/judgements', [ApiAdminController::class, 'judgement'])->name('admin.judgement');
    Route::get('/admin/judgements/legal-citation', [ApiAdminController::class, 'legalCitation'])->name('judgement.citation');
    Route::get('/admin/judgements/subject-matter', [ApiAdminController::class, 'sbjMatter']);
    Route::get('/admin/judgements/no-summary', [ApiAdminController::class, 'noSummary'])->name('judgement.no-summary');
    Route::get('/admin/judgements/create', [ApiAdminController::class, 'create'])->name('judge.create');
    Route::post('/admin/judgements', [ApiAdminController::class, 'storeJudgement'])->name('store.judgement');
    Route::get('/admin/judgements/{id}', [ApiAdminController::class, 'showJudgement'])->name('show.judgement');
    Route::get('/admin/judgements/edit/{id}', [ApiAdminController::class, 'editJudgement'])->name('edit.judgement');
    Route::patch('/admin/judgements/edit/{id}', [ApiAdminController::class, 'updateJudgement'])->name('update.judgement');
    Route::delete('/admin/judgements/{id}', [ApiAdminController::class, 'deleteJudgement'])->name('delete.judgement');

    Route::get('/admin/rules-of-court', [ApiAdminController::class, 'rules'])->name('admin.rules-of-court');

    Route::get('/admin/rules-of-court/categories', [ApiAdminController::class, 'ruleCat'])->name('admin.rule_cat');

    Route::get('/admin/rules-of-court/{id}', [ApiAdminController::class, 'showRule'])->name('show.rule');

    Route::get('/admin/rules-of-court/fetch-annotations/{id}', [ApiAdminController::class, 'fetchRuleAnote'])->name('fetch.rule-anote');

    Route::get('/admin/state-rules-of-court', [ApiAdminController::class, 'state_rules'])->name('admin.state-rules-of-court');
    Route::get('/admin/state-rules-of-court/{id}', [ApiAdminController::class, 'showStateRule'])->name('show.state-rule');
    Route::get('/admin/state-rules-of-court/fetch-annotations/{id}', [ApiAdminController::class, 'fetchStateRuleAnote'])->name('fetch.state-rule-anote');

    Route::get('/admin/laws-of-federation', [ApiAdminController::class, 'fed'])->name('admin.laws-of-federation');
    Route::get('/admin/laws-of-federation/{id}', [ApiAdminController::class, 'showFed'])->name('show.fed');
    Route::get('/admin/laws-of-federation/fetch-annotations/{id}', [ApiAdminController::class, 'fetchLawAnote'])->name('fetch.law-anote');

    Route::get('/admin/areas-of-laws', [ApiAdminController::class, 'area_of_law']);

    Route::get('/admin/categories', [ApiAdminController::class, 'category'])->name('admin.categories');

    Route::get('/admin/forms-and-precedents', [ApiAdminController::class, 'forms'])->name('admin.forms');
    Route::get('/admin/forms-and-precedents/{id}', [ApiAdminController::class, 'showForm'])->name('show.form');
    Route::get('/admin/forms-and-precedents/fetch-annotations/{id}', [ApiAdminController::class, 'fetchFormAnote'])->name('fetch.form-anote');

    Route::get('/admin/legal-articles/fetch-annotations/{id}', [ApiAdminController::class, 'fetchArticleAnote'])->name('fetch.article-anote');
    Route::get('/admin/legal-articles', [ApiAdminController::class, 'articles'])->name('admin.articles');
    Route::post('/admin/legal-articles/create', [ApiAdminController::class, 'storeArticle'])->name('store.article');
    Route::get('/admin/legal-articles/{id}', [ApiAdminController::class, 'showArticle'])->name('show.article');
    Route::post('/admin/legal-articles/rate-article/{id}', [ApiAdminController::class, 'rateArticle'])->name('rate.article');

    Route::get('/admin/law-dictionary', [ApiAdmincontroller::class, 'dictionary'])->name('admin.law-dictionary');

    Route::get('/admin/legal-maxims', [ApiAdminController::class, 'maxim'])->name('admin.legal-maxims');

    Route::get('/admin/resources', [ApiAdminController::class, 'resource'])->name('admin.resources');

    Route::get('/admin/featured-content', [ApiAdminController::class, 'featuredContent'])->name('admin.featured-content');

    Route::get('/admin/subscriptions', [ApiAdminController::class, 'subscription'])->name('admin.subscriptions');

    Route::get('/admin/discount', [ApiAdminController::class, 'discount'])->name('admin.discount');

    Route::patch('/checkout/{id}', [ApiAdminController::class, 'useDiscount'])->name('use.discount');

    Route::get('/admin/transactions', [ApiAdmincontroller::class, 'transaction'])->name('admin.transaction');

    Route::get('/admin/teams', [ApiAdminController::class, 'team'])->name('admin.teams');

    Route::get('/admin/teams/{id}', [ApiAdminController::class, 'showTeam'])->name('show.team');

    Route::get('/admin/teams/{id}/join', [ApiAdminController::class, 'joinTeam'])->name('join.team');

    Route::get('/admin/search', [ApiAdminController::class, 'search'])->name('search');

    Route::get('/admin/year', [ApiAdminController::class, 'years']);

    Route::get('/admin/filter-sbj', [ApiAdminController::class, 'filterSbj'])->name('judgement.sbj-matter');

    Route::get('/admin/notes', [ApiAdminController::class, 'note'])->name('admin.notes');

    Route::apiResource('/employee', EmployeeController::class)->middleware('api.authenticate');
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
