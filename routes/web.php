<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [LoginController::class, 'index'])->name('login');

Auth::routes(['verify' => true]);

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/admin/judgements/create', [AdminController::class, 'create'])->name('judge.create');
Route::get('/admin/judgements', [AdminController::class, 'judgement'])->name('admin.judgement');
Route::get('/admin/judgements/subject-matter', [AdminController::class, 'sbjMatter'])->name('judgement.sbj-matter');
Route::get('/admin/judgements/legal-citation', [AdminController::class, 'legalCitation'])->name('judgement.citation');
Route::get('/admin/judgements/{id}', [AdminController::class, 'showJudgement'])->name('show.judgement');
Route::post('/admin/judgements', [AdminController::class, 'storeJudgement'])->name('store.judgement');
Route::get('/admin/judgements/edit/{id}', [AdminController::class, 'editJudgement'])->name('edit.judgement');
Route::patch('/admin/judgements/edit/{id}', [AdminController::class, 'updateJudgement'])->name('update.judgement');
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

Route::get('/admin/state-rules-of-court', [AdminController::class, 'state_rules'])->name('admin.state-rules-of-court');
Route::get('/admin/state-rules-of-court/{id}', [AdminController::class, 'showStateRule'])->name('show.state-rule');
Route::post('/admin/state-rules-of-court', [AdminController::class, 'storeStateRule'])->name('store.state-rule');
Route::get('/admin/state-rules-of-court/edit/{id}', [AdminController::class, 'editStateRule'])->name('edit.state-rule');
Route::patch('/admin/state-rules-of-court/edit/{id}', [AdminController::class, 'updateStateRule'])->name('update.state-rule');
Route::delete('/admin/state-rules-of-court/{id}', [AdminController::class, 'deleteStateRule'])->name('delete.state-rule');

Route::get('/admin/laws-of-federation', [AdminController::class, 'fed'])->name('admin.laws-of-federation');
Route::get('/admin/laws-of-federation/create', [AdminController::class, 'createFed'])->name('create.fed');
Route::post('/admin/laws-of-federation', [AdminController::class, 'storeFed'])->name('store.fed');
Route::get('/admin/laws-of-federation/edit-fed/{id}', [AdminController::class, 'editFed'])->name('edit.fed');
Route::get('/admin/laws-of-federation/{id}', [AdminController::class, 'showFed'])->name('show.fed');
Route::patch('/admin/laws-of-federation/edit-fed/{id}', [AdminController::class, 'updateFed'])->name('update.fed');
Route::delete('/admin/laws-of-federation/{id}', [AdminController::class, 'deleteFed'])->name('delete.fed');

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

Route::get('/admin/legal-articles', [AdminController::class, 'articles'])->name('admin.articles');
Route::post('/admin/legal-articles', [AdminController::class, 'storeArticle'])->name('store.article');
Route::get('/admin/legal-articles/edit-article/{id}', [AdminController::class, 'editArticle'])->name('edit.article');
Route::get('/admin/legal-articles/{id}', [AdminController::class, 'showArticle'])->name('show.article');
Route::patch('/admin/legal-articles/edit-article/{id}', [AdminController::class, 'updateArticle'])->name('update.article');
Route::delete('/admin/legal-articles/{id}', [AdminController::class, 'deleteArticle'])->name('delete.article');
Route::post('/admin/legal-articles/{id}', [AdminController::class, 'shareArticle'])->name('share.article');
Route::get('/articles/{id}', [ArticleController::class, 'viewArticle'])->name('articles');

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

Route::get('/admin/resources', [AdminController::class, 'resource'])->name('admin.resources');
Route::post('/admin/resources', [AdminController::class, 'storeResource'])->name('store.resource');
Route::get('/admin/resources/edit-resources/{id}', [AdminController::class, 'editResource'])->name('edit.resource');
Route::patch('/admin/resources/edit-resources/{id}', [AdminController::class, 'updateResource'])->name('update.resource');
Route::delete('/admin/resources/{id}', [AdminController::class, 'deleteResource'])->name('delete.resource');

Route::get('/admin/customers', [AdminUserController::class, 'index'])->name('admin.customers');
Route::get('/admin/customers/{id}', [AdminUserController::class, 'show'])->name('show.customer');
Route::get('/admin/customers/{id}/profile', [AdminUserController::class, 'edit'])->name('edit.customer');
Route::patch('/admin/customers/{id}/profile', [AdminUserController::class, 'update'])->name('update.customer');
Route::delete('/admin/customers/{id}', [AdminUserController::class, 'deleteCustomer'])->name('delete.customer   ');

Route::get('/admin/subscriptions', [AdminController::class, 'subscription'])->name('admin.subscriptions');
Route::post('/admin/subscriptions', [AdminController::class, 'storePackage'])->name('store.package');
Route::patch('/admin/subscriptions', [AdminController::class, 'updatePackage'])->name('update.package');
Route::get('/admin/subscriptions/edit-package/{id}', [AdminController::class, 'editPackage'])->name('edit.package');
Route::delete('/admin/subscriptions/{id}', [AdminController::class, 'deletePackage'])->name('delete.package');
Route::get('/admin/transactions', [AdminController::class, 'transaction'])->name('admin.transaction');
Route::patch('/admin/transactions', [AdminController::class, 'updateTransaction'])->name('update.transaction');
Route::delete('/admin/transactions/{id}', [AdminController::class, 'deleteTransaction'])->name('delete.transaction');

Route::get('/subscription-package', [PackageController::class, 'sub_pack'])->name('subscription');
Route::get('/checkout/{id}', [AdminController::class, 'checkout'])->name('checkout');
Route::get('/checkout/discount/{id}', [AdminController::class, 'checkoutDiscount'])->name('checkout.discount');
Route::get('/subscription-package/{slug}', [PackageController::class, 'subPack'])->name('sub.pack');
Route::post('/subscription-package/pay', [PaymentController::class, 'redirectToGateway'])->name('sub.pay');
Route::get('/subscription-package/payment/callback/{reference}', [PaymentController::class, 'handleGatewayCallback'])->name('sub.paid');
Route::post('/subscription-package/payment/{reference}', [PaymentController::class, 'savePayment']);

Route::get('/admin/discount', [AdminController::class, 'discount'])->name('admin.discount');
Route::post('/admin/discount', [AdminController::class, 'storeDiscount'])->name('store.discount');
Route::patch('/admin/discount', [AdminController::class, 'updateDiscount'])->name('update.discount');
Route::delete('/admin/discount/{id}', [AdminController::class, 'deleteDiscount'])->name('delete.discount');
Route::patch('/checkout/{id}', [AdminController::class, 'useDiscount'])->name('use.discount');

Route::post('/admin/teams/comment', [AdminController::class, 'comment'])->name('post.comment');
Route::post('/admin/teams/reply', [AdminController::class, 'reply'])->name('reply.comment');
Route::delete('/admin/teams/comment/{id}', [AdminController::class, 'deleteComment'])->name('delete.comment');
Route::delete('/admin/teams/reply/{id}', [AdminController::class, 'deleteReply'])->name('delete.reply');

Route::get('/admin/teams', [AdminController::class, 'team'])->name('admin.teams');
Route::post('/admin/teams', [AdminController::class, 'storeTeam'])->name('store.team');
Route::patch('/admin/teams', [AdminController::class, 'updateTeam'])->name('update.team');
Route::patch('/admin/teams/{id}', [AdminController::class, 'settingsTeam'])->name('settings.team');
Route::get('/admin/teams/{id}', [AdminController::class, 'showTeam'])->name('show.team');
Route::post('/admin/teams/send-request', [AdminController::class, 'sendRequest'])->name('send.request');
Route::get('/admin/teams/member/approve', [AdminController::class, 'approveMember'])->name('approve.member');
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
Route::get('/admin/judgements/fetch-annotations/{id}', [AdminController::class, 'fetchAnote'])->name('fetch.anote');

Route::get('/admin/messages', [AdminController::class, 'message'])->name('admin.messages');
Route::get('/admin/messages/create', [AdminController::class, 'createMessage'])->name('create.message');
Route::post('/admin/messages', [AdminController::class, 'storeMessage'])->name('store.message');
Route::get('/admin/messages/edit/{id}', [AdminController::class, 'editMessage'])->name('edit.message');
Route::patch('/admin/messages/{id}', [AdminController::class, 'updateMessage'])->name('update.message');
Route::delete('/admin/messages/{id}', [AdminController::class, 'deleteMessage'])->name('delete.message');
Route::post('/admin/messages/send', [AdminController::class, 'sendMessage'])->name('send.message');

Route::get('/admin/licenses', [AdminController::class, 'license'])->name('admin.licenses');
Route::post('/admin/licenses', [AdminController::class, 'storeLicense'])->name('store.license');
Route::patch('/admin/licenses', [AdminController::class, 'updateLicense'])->name('update.license');
Route::delete('/admin/licenses/{id}', [AdminController::class, 'deleteLicense'])->name('delete.license');



