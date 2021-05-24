<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('pages.home');
})->name('hp');

Route::get('/cf', function () {
    return view('pages.homepage');
})->name('welcome');

Auth::routes();


Route::get('pricing', 'PageController@pricing')->name('page.pricing');
Route::get('lock', 'PageController@lock')->name('page.lock');

Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', 'HomeController@index')->name('home');
    Route::post('dashboard', 'HomeController@show')->name('home.show');

    Route::resource('category', 'CategoryController', ['except' => ['show']]);
    Route::resource('tag', 'TagController', ['except' => ['show']]);
    Route::resource('item', 'ItemController', ['except' => ['show']]);
    Route::resource('role', 'RoleController', ['except' => ['show', 'destroy']]);
    Route::resource('user', 'UserController', ['except' => ['show']]);

    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::get('/admin/{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);

    /** Leads */
    Route::get('/leads', 'LeadController@index')->name('leads');
    Route::get('/leads/create', 'LeadController@create')->name('leads.create');
    Route::get('/leads/{lead}', 'LeadController@show')->name('leads.show');

    /** Campaigns */
    Route::get('/campaigns/facebook', 'CampaignInsightController@facebook')->name('campaigns.facebook');
    Route::get('/campaigns/create', 'CampaignInsightController@create')->name('campaigns.create');
    Route::get('/campaigns/{campaign}', 'CampaignInsightController@show')->name('campaigns.show');

    /** Products */
    Route::get('/products', 'ProductController@index')->name('products');
    Route::get('/products/create', 'ProductController@create')->name('products.create');
    Route::get('/products/{product}', 'ProductController@show')->name('products.show');

    /** Sales */
    Route::get('/sales', 'SaleController@index')->name('sales');
    Route::get('/sales/create', 'SaleController@create')->name('sales.create');
    Route::get('/sales/{sale}', 'SaleController@show')->name('sales.show');

    /** Notificações */
    Route::get('/messages', 'IntegrationController@index')->name('messages');
    Route::get('/messages/create', 'IntegrationController@create')->name('messages.create');
    Route::get('/messages/{sale}', 'IntegrationController@show')->name('messages.show');

    /** Integrations */
    Route::get('/integrations', 'IntegrationController@index')->name('integrations');
    Route::delete('/integrations/{integration}', 'IntegrationController@destroy')->name('integrations.destroy');
    Route::get('integrations/google', 'IntegrationController@createGoogleIntegration')->name('integrations.google');

    Route::get('/integrations/create', 'IntegrationController@create')->name('integrations.create');
    Route::get('/integrations/create/get', 'IntegrationController@store')->name('integrations.create.get');
    Route::post('/integrations/create/do', 'IntegrationController@store')->name('integrations.create.do');
    Route::get('/integrations/{integration}', 'IntegrationController@show')->name('integrations.show');

    /** SocialLogin */
    Route::get('/ln/facebook', 'SocialiteController@redirectToProvider')->name('facebook.start');
    Route::get('/ln/facebook/callback', 'SocialiteController@handleProviderCallback')->name('facebook.callback');
    Route::get('/ln/google', 'SocialiteController@redirectToProvider')->name('google.start');
    Route::get('/ln/google/callback', 'SocialiteController@handleProviderCallback')->name('google.callback');

    /** Projects */
    Route::resource('projects', ProjectController::class);
//    Route::get('/projects/{project}/edit', 'ProjectController@edit')->middleware('model.protection');

    /** Sheets */
    Route::resource('sheets', SheetController::class);

    /** Debriefings */
    Route::get('debriefings', 'DebriefingController@index')->name('debriefings.index');
    Route::get('debriefings/{project}/edit', 'DebriefingController@edit')->name('debriefings.edit');
    Route::put('debriefings/{project}/update', 'DebriefingController@update')->name('debriefings.update');


    /** Videos */
    Route::resource('videos', VideoController::class);
    Route::get('/videos', 'VideoController@getVideoStats')->name('videos.stats');

    /** Deeplinks */
    Route::get('/links', 'LinkController@index')->name('links.index');

    /** LeadsTags */
    Route::resource('leadtag', LeadTagController::class);

    /** Test */
//    Route::get('hw', 'TestController@helloWorld');
//    Route::get('/alert', 'TestController@alert');
//    Route::get('/sts', 'TestController@changeSaleStatus');
//    Route::get('/lt/{act}/dp/{datePreset}', 'TestController@leadTag');
//    Route::get('/tag', 'TestController@leadTag');

});

/** Reports */
Route::get('projects/{project:uuid}', 'ProjectController@show')->name('projects.show');
Route::get('conceptions/{project:uuid}', 'ProjectController@conception')->name('projects.conception');
Route::get('debriefings/{project:uuid}', 'DebriefingController@show')->name('debriefings.show');

/** Webhooks */
Route::webhooks('webhook');

/** Deeplinks */
Route::get('/go/{link}', 'LinkController@shortLink')->name('links.show');
Route::get('/l', 'LinkController@urlParam')->name('links.param');

/** Legal */

Route::get('privacy-policy', function () {
    return view('pages.privacy');
});

Route::get('terms', function () {
    return view('pages.terms');
});

Route::get('google', function () {
    return view('pages.google');
});


