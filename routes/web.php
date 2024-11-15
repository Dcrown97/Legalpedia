<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AutomatedController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SendBulkMessageController;
use App\Models\Article;
use App\Models\Judgement;
use App\Models\JudgementSummary;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect("/login");
});

Auth::routes();
// Auth::routes(['verify' => true]);

Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPasswordPost'])->name('forgot.password.post');
Route::get('password-reset', [ForgotPasswordController::class, 'passwordReset'])->name('password.reset');
Route::post('password-reset', [ForgotPasswordController::class, 'passwordResetPost'])->name('password.reset.post');

Route::group(['middleware' => 'auth'], function () {
    // Route::group(['middleware'=>['auth', 'verified']], function(){

    Route::post("/ask", [AdminController::class, 'summarize'])->name('admin.ask');
    Route::get('/admin/ai-assistant', [AdminController::class, 'aiAssistant'])->name('admin.ai');
    Route::post('/admin/ai-assistant', [AdminController::class, 'aiAssistant'])->name('admin.ai');

    Route::post('/admin/ai-assistant-summary', [AdminController::class, 'aiAssistantSummary'])->name('admin.aiSummary');
    Route::get('/admin/ai-assistant-judgement-summary/{id}', [AdminController::class, 'aiAssistantJudgementSummary'])->name('admin.aiJudgementSummary');
    Route::get('/admin/ai-assistant-laws-of-fed/{id}', [AdminController::class, 'aiAssistantLawsOfFedSummary'])->name('admin.aiLawsOfFedSummary');



    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/judgements/courts', [AdminController::class, 'court'])->name('admin.court');
    Route::post('/admin/judgements/courts', [AdminController::class, 'storeCourt'])->name('store.court');
    Route::patch('/admin/judgements/courts', [AdminController::class, 'updateCourt'])->name('update.court');
    Route::delete('/admin/judgements/courts/{id}', [AdminController::class, 'deleteCourt'])->name('delete.court');

    Route::get('/admin/judgements/subject-matter-index', [AdminController::class, 'getSbj'])->name('get.sbj');
    Route::post('/admin/judgements/subject-matter-index', [AdminController::class, 'storeSbj'])->name('store.sbj');
    Route::patch('/admin/judgements/subject-matter-index', [AdminController::class, 'updateSbj'])->name('update.sbj');
    Route::delete('/admin/judgements/subject-matter-index/{id}', [AdminController::class, 'deleteSbj'])->name('delete.sbj');

    Route::get('/admin/judgements/create', [AdminController::class, 'create'])->name('judge.create');
    Route::get('/admin/judgements', [AdminController::class, 'judgement'])->name('admin.judgement');
    Route::get('/admin/judgements/subject-matter', [AdminController::class, 'sbjMatter'])->name('judgement.sbj-matter');
    Route::get('/admin/judgements/legal-citation', [AdminController::class, 'legalCitation'])->name('judgement.citation');
    Route::get('/admin/judgements/no-summary', [AdminController::class, 'noSummary'])->name('judgement.no-summary');
    Route::get('/admin/judgements/{id}', [AdminController::class, 'showJudgement'])->name('show.judgement');
    Route::post('/admin/judgements', [AdminController::class, 'storeJudgement'])->name('store.judgement');
    Route::get('/admin/judgements/edit/{id}', [AdminController::class, 'editJudgement'])->name('edit.judgement');
    Route::get('/admin/judgements/show/{title}', [AdminController::class, 'showJudgementByTitle'])->name('title.judgement');
    Route::patch('/admin/judgements/edit/{id}', [AdminController::class, 'updateJudgement'])->name('update.judgement');
    Route::POST('/admin/judgements/remove/coram', [AdminController::class, 'removeCoram']);
    Route::POST('/admin/judgements/remove/ratio', [AdminController::class, 'removeRatio']);
    Route::POST('/admin/judgements/remove/subMatter', [AdminController::class, 'removeSubMatter']);
    Route::delete('/admin/judgements/{id}', [AdminController::class, 'deleteJudgement'])->name('delete.judgement');

    Route::get('/admin/rules-of-court', [AdminController::class, 'rules'])->name('admin.rules-of-court');
    Route::get('/admin/rules-of-court/categories', [AdminController::class, 'ruleCat'])->name('admin.rule_cat');
    Route::post('/admin/rules-of-court/categories', [AdminController::class, 'storeRuleCat'])->name('store.rule_cat');
    Route::patch('/admin/rules-of-court/categories', [AdminController::class, 'updateRuleCat'])->name('update.rule_cat');
    Route::delete('/admin/rules-of-court/categories/{id}', [AdminController::class, 'deleteRuleCat'])->name('delete.rule_cat');

    Route::get('/admin/rules-of-court/{id}', [AdminController::class, 'showRule'])->name('show.rule');
    Route::post('/admin/rules-of-court', [AdminController::class, 'storeRule'])->name('store.rule');
    Route::get('/admin/rules-of-court/edit/{id}', [AdminController::class, 'editRule'])->name('edit.rule');
    Route::patch('/admin/rules-of-court/edit/{id}', [AdminController::class, 'updateRule'])->name('update.rule');
    Route::delete('/admin/rules-of-court/{id}', [AdminController::class, 'deleteRule'])->name('delete.rule');
    Route::get('/admin/rules-of-court/fetch-annotations/{id}', [AdminController::class, 'fetchRuleAnote'])->name('fetch.rule-anote');


    Route::get('/admin/state-rules-of-court', [AdminController::class, 'state_rules'])->name('admin.state-rules-of-court');
    Route::get('/admin/state-rules-of-court/{id}', [AdminController::class, 'showStateRule'])->name('show.state-rule');
    Route::post('/admin/state-rules-of-court', [AdminController::class, 'storeStateRule'])->name('store.state-rule');
    Route::get('/admin/state-rules-of-court/edit/{id}', [AdminController::class, 'editStateRule'])->name('edit.state-rule');
    Route::patch('/admin/state-rules-of-court/edit/{id}', [AdminController::class, 'updateStateRule'])->name('update.state-rule');
    Route::delete('/admin/state-rules-of-court/{id}', [AdminController::class, 'deleteStateRule'])->name('delete.state-rule');
    Route::get('/admin/state-rules-of-court/fetch-annotations/{id}', [AdminController::class, 'fetchStateRuleAnote'])->name('fetch.state-rule-anote');


    Route::get('/admin/laws-of-federation', [AdminController::class, 'fed'])->name('admin.laws-of-federation');
    Route::post('/fed/post_order_change', [AdminController::class, 'fed_order_change'])->name('fed.order_change');
    Route::post('/fed/section_order_change', [AdminController::class, 'fed_section_order_change'])->name('fedSection.order_change');
    Route::get('/admin/laws-of-federation/create', [AdminController::class, 'createFed'])->name('create.fed');
    Route::post('/admin/laws-of-federation', [AdminController::class, 'storeFed'])->name('store.fed');
    Route::get('/admin/laws-of-federation/edit-fed/{id}', [AdminController::class, 'editFed'])->name('edit.fed');
    Route::get('/admin/laws-of-federation/{id}', [AdminController::class, 'showFed'])->name('show.fed');
    Route::patch('/admin/laws-of-federation/edit-fed/{id}', [AdminController::class, 'updateFed'])->name('update.fed');
    Route::post('/admin/laws-of-federation/edit-fed/remove-section/{sectionId}', [AdminController::class, 'removeSection'])->name('remove.section');
    Route::post('/admin/laws-of-federation/edit-fed/remove-part/{partId}', [AdminController::class, 'removePart'])->name('remove.part');
    Route::delete('/admin/laws-of-federation/{id}', [AdminController::class, 'deleteFed'])->name('delete.fed');
    Route::get('/admin/laws-of-federation/fetch-annotations/{id}', [AdminController::class, 'fetchLawAnote'])->name('fetch.law-anote');


    Route::get('/admin/areas-of-laws', [AdminController::class, 'area_of_law']);
    Route::post('/admin/areas-of-laws', [AdminController::class, 'storeArea'])->name('store.area');
    Route::patch('/admin/areas-of-laws', [AdminController::class, 'updateArea'])->name('update.area');
    Route::delete('/admin/areas-of-laws/{id}', [AdminController::class, 'deleteArea'])->name('delete.area');

    Route::get('/admin/categories', [AdminController::class, 'category'])->name('admin.categories');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('store.category');
    Route::patch('/admin/categories', [AdminController::class, 'updateCategory'])->name('update.category');
    Route::delete('/admin/categories/{id}', [AdminController::class, 'deleteCategory'])->name('delete.category');

    Route::get('/admin/forms-and-precedents', [AdminController::class, 'forms'])->name('admin.forms');
    Route::post('/admin/forms-and-precedents', [AdminController::class, 'storeForm'])->name('store.form');
    Route::get('/admin/forms-and-precedents/edit-form/{id}', [AdminController::class, 'editForm'])->name('edit.form');
    Route::get('/admin/forms-and-precedents/{id}', [AdminController::class, 'showForm'])->name('show.form');
    Route::patch('/admin/forms-and-precedents/edit-form/{id}', [AdminController::class, 'updateForm'])->name('update.form');
    Route::delete('/admin/forms-and-precedents/{id}', [AdminController::class, 'deleteForm'])->name('delete.form');
    Route::post('/admin/forms-and-precedents/feature/{id}', [AdminController::class, 'featureForm'])->name('feature.form');
    Route::post('/admin/forms-and-precedents/rate-form', [AdminController::class, 'rateForm'])->name('rate.form');
    Route::post('/admin/forms-and-precedents/like', [AdminController::class, 'likeForm'])->name('like.article');
    Route::post('/admin/forms-and-precedents/{id}', [AdminController::class, 'shareForm'])->name('share.form');
    Route::get('/admin/forms-and-precedents/fetch-annotations/{id}', [AdminController::class, 'fetchFormAnote'])->name('fetch.form-anote');



    Route::get('/admin/legal-articles/fetch-annotations/{id}', [AdminController::class, 'fetchArticleAnote'])->name('fetch.article-anote');

    Route::post('/admin/legal-articles/like', [AdminController::class, 'likeArticle'])->name('like.article');
    Route::get('/admin/legal-articles', [AdminController::class, 'articles'])->name('admin.articles');
    Route::post('/admin/legal-articles', [AdminController::class, 'storeArticle'])->name('store.article');
    Route::get('/admin/legal-articles/edit-article/{id}', [AdminController::class, 'editArticle'])->name('edit.article');
    Route::get('/admin/legal-articles/{id}', [AdminController::class, 'showArticle'])->name('show.article');
    Route::patch('/admin/legal-articles/edit-article/{id}', [AdminController::class, 'updateArticle'])->name('update.article');
    Route::delete('/admin/legal-articles/{id}', [AdminController::class, 'deleteArticle'])->name('delete.article');
    Route::post('/admin/legal-articles/{id}', [AdminController::class, 'shareArticle'])->name('share.article');
    Route::post('/admin/legal-articles/feature/{id}', [AdminController::class, 'featureArticle'])->name('feature.article');
    Route::post('/admin/legal-articles/rate-article/{id}', [AdminController::class, 'rateArticle'])->name('rate.article');


    Route::get('/admin/law-dictionary', [AdminController::class, 'dictionary'])->name('admin.law-dictionary');
    Route::post('/admin/law-dictionary', [AdminController::class, 'storeDictionary'])->name('store.dictionary');
    Route::get('/admin/law-dictionary/edit-dictionary/{id}', [AdminController::class, 'editDictionary'])->name('edit.dictionary');
    Route::patch('/admin/law-dictionary/edit-dictionary/{id}', [AdminController::class, 'updateDictionary'])->name('update.dictionary');
    Route::delete('/admin/law-dictionary/{id}', [AdminController::class, 'deleteDictionary'])->name('delete.dictionary');

    Route::get('/admin/legal-maxims', [AdminController::class, 'maxim'])->name('admin.legal-maxims');
    Route::get('/admin/legal-maxims/p', [AdminController::class, 'fetch_maxim']);
    Route::post('/admin/legal-maxims', [AdminController::class, 'storeMaxim'])->name('store.maxim');
    Route::get('/admin/legal-maxims/edit-maxims/{id}', [AdminController::class, 'editMaxim'])->name('edit.maxim');
    Route::patch('/admin/legal-maxims/edit-maxims/{id}', [AdminController::class, 'updateMaxim'])->name('update.maxim');
    Route::delete('/admin/legal-maxims/{id}', [AdminController::class, 'deleteMaxim'])->name('delete.maxim');

    Route::get('/admin/legal-prompts', [AdminController::class, 'prompt'])->name('admin.legal-prompts');
    Route::get('/admin/legal-prompts/p', [AdminController::class, 'fetch_prompt']);
    Route::post('/admin/legal-prompts', [AdminController::class, 'storePrompt'])->name('store.prompt');
    Route::get('/admin/legal-prompts/edit-prompts/{id}', [AdminController::class, 'editPrompt'])->name('edit.prompt');
    Route::patch('/admin/legal-prompts/edit-prompts/{id}', [AdminController::class, 'updatePrompt'])->name('update.prompt');
    Route::delete('/admin/legal-prompts/{id}', [AdminController::class, 'deletePrompt'])->name('delete.prompt');

    Route::get('/admin/resources', [AdminController::class, 'resource'])->name('admin.resources');
    Route::post('/admin/resources', [AdminController::class, 'storeResource'])->name('store.resource');
    Route::get('/admin/resources/edit-resources/{id}', [AdminController::class, 'editResource'])->name('edit.resource');
    Route::patch('/admin/resources/edit-resources/{id}', [AdminController::class, 'updateResource'])->name('update.resource');
    Route::delete('/admin/resources/{id}', [AdminController::class, 'deleteResource'])->name('delete.resource');


    Route::get('/admin/featured-content', [AdminController::class, 'featuredContent'])->name('admin.featured-content');
    Route::post('/admin/featured-content/feature/{id}', [AdminController::class, 'saveFeature'])->name('admin.save-feature');


    Route::get('/admin/user/profile/{id}', [AdminUserController::class, 'userProfile'])->name('user.profile');
    Route::get('/admin/customers', [AdminUserController::class, 'index'])->name('admin.customers');
    Route::post('/admin/user/profile/rate-user', [AdminUserController::class, 'rateUser'])->name('rate.user');


    ////////////////////////////////////////////////datatables//////////////////////////////////////////////
    Route::get('/admin/customers/custom', [AdminUserController::class, 'indexDatables'])->name('admin.custom');
    // Route::get('/admin/customers/custom', [AdminUserController::class, 'customerDataSource'])->name('user.custom');;
    Route::get('/admin/customers/custom', [AdminUserController::class, 'userTable'])->name('user.custom');
    ////////////////////////////////////////////////datatables//////////////////////////////////////////////

    Route::get('/admin/customers/{id}', [AdminUserController::class, 'show'])->name('show.customer');
    Route::get('/admin/customers/{id}/profile', [AdminUserController::class, 'edit'])->name('edit.customer');
    Route::patch('/admin/customers/{id}/profile', [AdminUserController::class, 'update'])->name('update.customer');
    Route::post('/admin/customer/api_token', [AdminUserController::class, 'apiAccess'])->name('api.access');
    Route::patch('/admin/customers', [AdminUserController::class, 'updateRole'])->name('update.role');
    Route::delete('/admin/customers/{id}', [AdminUserController::class, 'deleteCustomer'])->name('delete.customer');
    Route::post('/admin/customers/export', [AdminUserController::class, 'exportCustomer'])->name('export.customer');
    Route::post('/admin/customers/feature/{id}', [AdminUserController::class, 'featureCustomer'])->name('feature.customer');

    Route::get('/admin/subscriptions', [AdminController::class, 'subscription'])->name('admin.subscriptions');
    Route::post('/admin/subscriptions', [AdminController::class, 'storePackage'])->name('store.package');
    Route::get('/admin/subscriptions/edit-package/{id}', [AdminController::class, 'editPackage'])->name('edit.package');
    Route::patch('/admin/subscriptions/edit-package/{id}', [AdminController::class, 'updatePackage'])->name('update.package');
    Route::delete('/admin/subscriptions/{id}', [AdminController::class, 'deletePackage'])->name('delete.package');
    Route::get('/admin/transactions', [AdminController::class, 'transaction'])->name('admin.transaction');
    Route::patch('/admin/transactions', [AdminController::class, 'updateTransaction'])->name('update.transaction');
    Route::delete('/admin/transactions/{id}', [AdminController::class, 'deleteTransaction'])->name('delete.transaction');

    Route::get('/admin/pricing', [AdminController::class, 'pricing'])->name('admin.pricing');
    Route::get('/subscription-package', [PackageController::class, 'sub_pack'])->name('subscription'); //not in use
    Route::get('/checkout/{id}', [AdminController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/discount/{id}', [AdminController::class, 'checkoutDiscount'])->name('checkout.discount');
    Route::post('/subscription-package/pay', [PaymentController::class, 'redirectToGateway'])->name('sub.pay');
    Route::get('/subscription-package/payment/callback/{reference}', [PaymentController::class, 'handleGatewayCallback'])->name('sub.paid');
    Route::post('/subscription-package/payment/{reference}', [PaymentController::class, 'savePayment']);

    Route::get('/payment-success/{reference}', [PaymentController::class, 'paymentSuccessful'])->name('payment.successful');
    Route::post('/payment-success/{reference}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

    Route::get('/admin/discount', [AdminController::class, 'discount'])->name('admin.discount');
    Route::post('/admin/discount', [AdminController::class, 'storeDiscount'])->name('store.discount');
    Route::patch('/admin/discount', [AdminController::class, 'updateDiscount'])->name('update.discount');
    Route::delete('/admin/discount/{id}', [AdminController::class, 'deleteDiscount'])->name('delete.discount');
    Route::patch('/checkout/{id}', [AdminController::class, 'useDiscount'])->name('use.discount');

    Route::post('/admin/teams/comment', [AdminController::class, 'comment'])->name('post.comment');
    Route::post('/admin/teams/comment-api', [AdminController::class, 'commentApi'])->name('post.commentApi');


    Route::patch('/admin/teams/comment', [AdminController::class, 'updateComment'])->name('update.comment');
    Route::post('/admin/teams/reply', [AdminController::class, 'reply'])->name('reply.comment');
    Route::delete('/admin/teams/comment/{id}', [AdminController::class, 'deleteComment'])->name('delete.comment');
    Route::delete('/admin/teams/reply/{id}', [AdminController::class, 'deleteReply'])->name('delete.reply');

    Route::get('/admin/teams', [AdminController::class, 'team'])->name('admin.teams');
    Route::post('/admin/teams', [AdminController::class, 'storeTeam'])->name('store.team');
    Route::patch('/admin/teams', [AdminController::class, 'updateTeam'])->name('update.team');
    Route::patch('/admin/teams/{id}', [AdminController::class, 'settingsTeam'])->name('settings.team');
    Route::get('/admin/teams/{id}', [AdminController::class, 'showTeam'])->name('show.team');
    Route::get('/admin/teams/{id}/meeting', [AdminController::class, 'teamMeeting'])->name('team.meeting'); // start a meeting
    Route::post('/admin/teams/feature/{id}', [AdminController::class, 'featureTeam'])->name('feature.team');
    Route::post('/admin/teams/rate-team', [AdminController::class, 'rateTeam'])->name('rate.team');


    Route::post('/admin/teams/post/like', [AdminController::class, 'likeTeamPost'])->name('like.post');
    Route::post('/admin/teams/post/save', [AdminController::class, 'saveTeamPost'])->name('save.post');

    Route::get('/admin/teams/{id}/join', [AdminController::class, 'joinTeam'])->name('join.team');
    Route::post('/admin/teams/{id}/join', [AdminController::class, 'joinedTeam'])->name('joined.team');
    Route::post('/admin/teams/send-request', [AdminController::class, 'sendRequest'])->name('send.request');
    Route::get('/admin/teams/member/approve/{id}', [AdminController::class, 'approveMember'])->name('approve.member');
    Route::patch('/admin/teams/approve/{id}', [AdminController::class, 'approveRequest'])->name('approve.request');
    Route::patch('/admin/teams/decline/{id}', [AdminController::class, 'declineRequest'])->name('decline.request');
    Route::delete('/admin/teams/remove/{id}', [AdminController::class, 'remove'])->name('remove.member');
    Route::delete('/admin/teams/leave/{id}', [AdminController::class, 'leave'])->name('leave.member');
    Route::post('/admin/teams/{id}', [InviteController::class, 'sendInvite'])->name('send.invite');
    Route::get('/invite/register/{token}', [InviteController::class, 'registration_view'])->name('registration');
    Route::post('/invite/register', [RegisterController::class, 'register'])->name('accept');
    Route::delete('/admin/teams/{id}', [AdminController::class, 'deleteTeam'])->name('delete.team');

    Route::get('/admin/search', [AdminController::class, 'search'])->name('search');
    Route::get('autocomplete-search', [AdminController::class, 'autocomplete'])->name('autocomplete');

    Route::post('/admin/annotations', [AdminController::class, 'anote'])->name('store.anote');
    Route::patch('/admin/annotations', [AdminController::class, 'updateAnote'])->name('update.anote');
    Route::get('/admin/judgements/fetch-annotations/{id}', [AdminController::class, 'fetchAnote'])->name('fetch.anote');
    Route::post('/admin/annotations/teams', [AdminController::class, 'shareAnote'])->name('share.anote');

    Route::get('/admin/notes', [AdminController::class, 'note'])->name('admin.notes');
    Route::post('/admin/notes', [AdminController::class, 'storeNote'])->name('store.note');
    Route::patch('/admin/notes', [AdminController::class, 'updateNote'])->name('update.note');
    Route::delete('/admin/notes/{id}', [AdminController::class, 'deleteNote'])->name('delete.note');
    Route::post('/admin/notes/feature/{id}', [AdminController::class, 'featureNote'])->name('feature.note');
    Route::post('/admin/notes/like', [AdminController::class, 'likeNote'])->name('like.note');
    Route::post('/admin/notes/rate-note', [AdminController::class, 'rateNote'])->name('rate.note');


    Route::get('/admin/messages', [AdminController::class, 'message'])->name('admin.messages');
    Route::get('/admin/messages/create', [AdminController::class, 'createMessage'])->name('create.message');
    Route::post('/admin/messages', [AdminController::class, 'storeMessage'])->name('store.message');
    Route::get('/admin/messages/edit/{id}', [AdminController::class, 'editMessage'])->name('edit.message');
    Route::patch('/admin/messages/{id}', [AdminController::class, 'updateMessage'])->name('update.message');
    Route::delete('/admin/messages/{id}', [AdminController::class, 'deleteMessage'])->name('delete.message');
    Route::post('/admin/messages/send', [AdminController::class, 'sendMessages'])->name('send.messages');


    Route::get('/admin/licenses', [AdminController::class, 'license'])->name('admin.licenses');
    Route::post('/admin/licenses', [AdminController::class, 'storeLicense'])->name('store.license');
    Route::patch('/admin/licenses', [AdminController::class, 'updateLicense'])->name('update.license');
    Route::delete('/admin/licenses/{id}', [AdminController::class, 'deleteLicense'])->name('delete.license');



    Route::post('/admin/reports', [AdminController::class, 'sendReport'])->name('send.report');
});

Route::get('/articles/{id}', [ArticleController::class, 'viewArticle'])->name('articles');

Route::get('/forms/{id}', [ArticleController::class, 'viewForm'])->name('forms');

Route::get('/subscription-package/{slug}', [PackageController::class, 'subPack'])->name('sub.pack');

Route::get('/messages/sent', [SendBulkMessageController::class, 'sendBulk'])->name('send.bulk');

Route::get('/package-expiration', [PackageController::class, 'expiredPackage'])->name('expired.package');

Route::get('/send-birthday-message', [AutomatedController::class, 'birthdayMessage'])->name('birthday.message');

Route::get('/clear-license-session', [AutomatedController::class, 'clearSession'])->name('clear.session');

Route::get('execute', function () {
    Artisan::call('schedule:run');
});


Route::get('agolia-search', function() {
    $query = 'NIGERIA'; // <-- Change the query for testing.

    $articles = Article::search($query)->get();

    return $articles;
});