<?php
//resources//
Route::resources([
    'invoice' => 'InvoiceController',

]);
//


//Home //

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);
//EndHome//

//Package Ajax//

Route::get('/packageData/{id}', function ($id){
    $package = Vanguard\Package::find($id);

    return $package->toJson();
});



/**
 * Authentication
 */
Route::get('login', 'Auth\LoginController@show');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['middleware' => ['registration', 'guest']], function () {
    Route::get('register', 'Auth\RegisterController@show');
    Route::post('register', 'Auth\RegisterController@register');
});

Route::emailVerification();

Route::group(['middleware' => ['password-reset', 'guest']], function () {
    Route::resetPassword();
});

/**
 * Two-Factor Authentication
 */
Route::group(['middleware' => 'two-factor'], function () {
    Route::get('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@show')->name('auth.token');
    Route::post('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@update')->name('auth.token.validate');
});

/**
 * Social Login
 */
Route::get('auth/{provider}/login', 'Auth\SocialAuthController@redirectToProvider')->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

Route::group(['middleware' => ['auth', 'verified']], function () {

    /**
     * Impersonate Routes
     */
    Route::impersonate();

    /**
     * Dashboard
     */

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    /**
     * User Profile
     */

    Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {
        Route::get('/', 'ProfileController@show')->name('profile');
        Route::get('activity', 'ActivityController@show')->name('profile.activity');
        Route::put('details', 'DetailsController@update')->name('profile.update.details');

        Route::post('avatar', 'AvatarController@update')->name('profile.update.avatar');
        Route::post('avatar/external', 'AvatarController@updateExternal')
            ->name('profile.update.avatar-external');

        Route::put('login-details', 'LoginDetailsController@update')
            ->name('profile.update.login-details');

        Route::get('sessions', 'SessionsController@index')
            ->name('profile.sessions')
            ->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'SessionsController@destroy')
            ->name('profile.sessions.invalidate')
            ->middleware('session.database');
    });

    /**
     * Two-Factor Authentication Setup
     */

    Route::group(['middleware' => 'two-factor'], function () {
        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('two-factor.enable');

        Route::get('two-factor/verification', 'TwoFactorController@verification')
            ->name('two-factor.verification')
            ->middleware('verify-2fa-phone');

        Route::post('two-factor/resend', 'TwoFactorController@resend')
            ->name('two-factor.resend')
            ->middleware('throttle:1,1', 'verify-2fa-phone');

        Route::post('two-factor/verify', 'TwoFactorController@verify')
            ->name('two-factor.verify')
            ->middleware('verify-2fa-phone');

        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('two-factor.disable');
    });



    /**
     * User Management
     */
    Route::resource('users', 'Users\UsersController')
        ->except('update')->middleware('permission:users.manage');

    Route::group(['prefix' => 'users/{user}', 'middleware' => 'permission:users.manage'], function () {
        Route::put('update/details', 'Users\DetailsController@update')->name('users.update.details');
        Route::put('update/login-details', 'Users\LoginDetailsController@update')
            ->name('users.update.login-details');

        Route::post('update/avatar', 'Users\AvatarController@update')->name('user.update.avatar');
        Route::post('update/avatar/external', 'Users\AvatarController@updateExternal')
            ->name('user.update.avatar.external');

        Route::get('sessions', 'Users\SessionsController@index')
            ->name('user.sessions')->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'Users\SessionsController@destroy')
            ->name('user.sessions.invalidate')->middleware('session.database');

        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('user.two-factor.enable');
        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('user.two-factor.disable');
    });

    /**
     * Roles & Permissions
     */
    Route::group(['namespace' => 'Authorization'], function () {
        Route::resource('roles', 'RolesController')->except('show')->middleware('permission:roles.manage');

        Route::post('permissions/save', 'RolePermissionsController@update')
            ->name('permissions.save')
            ->middleware('permission:permissions.manage');

        Route::resource('permissions', 'PermissionsController')->middleware('permission:permissions.manage');
    });


    /**
     * Settings
     */

    Route::get('settings', 'SettingsController@general')->name('settings.general')
        ->middleware('permission:settings.general');

    Route::post('settings/general', 'SettingsController@update')->name('settings.general.update')
        ->middleware('permission:settings.general');

    Route::get('settings/auth', 'SettingsController@auth')->name('settings.auth')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth', 'SettingsController@update')->name('settings.auth.update')
        ->middleware('permission:settings.auth');

    if (config('services.authy.key')) {
        Route::post('settings/auth/2fa/enable', 'SettingsController@enableTwoFactor')
            ->name('settings.auth.2fa.enable')
            ->middleware('permission:settings.auth');

        Route::post('settings/auth/2fa/disable', 'SettingsController@disableTwoFactor')
            ->name('settings.auth.2fa.disable')
            ->middleware('permission:settings.auth');
    }

    Route::post('settings/auth/registration/captcha/enable', 'SettingsController@enableCaptcha')
        ->name('settings.registration.captcha.enable')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth/registration/captcha/disable', 'SettingsController@disableCaptcha')
        ->name('settings.registration.captcha.disable')
        ->middleware('permission:settings.auth');

    Route::get('settings/notifications', 'SettingsController@notifications')
        ->name('settings.notifications')
        ->middleware('permission:settings.notifications');

    Route::post('settings/notifications', 'SettingsController@update')
        ->name('settings.notifications.update')
        ->middleware('permission:settings.notifications');

    /**
     * Activity Log
     */

    Route::get('activity', 'ActivityController@index')->name('activity.index')
        ->middleware('permission:users.activity');

    Route::get('activity/user/{user}/log', 'Users\ActivityController@index')->name('activity.user')
        ->middleware('permission:users.activity');
});


    /**
    * Packages
     */

    Route::get('packages', 'PackageController@index')->name('packages');
    Route::get('packages/create', 'PackageController@create');
    Route::post('package/store', 'PackageController@store');
    Route::get('package/edit/{id}', 'PackageController@edit');
    Route::put('package/store/{id}', 'PackageController@update');



/**
 *Estimates
 */
    Route::post('estimate/store', 'EstimateController@store');
    Route::get('/customer/form', 'CustomerController@customerForm');
    Route::get('/estimate/{id}/show', 'EstimateController@show')->name('estimate.show');
    Route::post('/estimate/{id}/addPackage', 'EstimateController@addPackage');
    Route::post('/estimate/addVehicle/{cid}/{eid}', 'EstimateController@addVehicle');
    Route::get('/estimate/workOrder/{id}', 'EstimateController@estimateMakeWorkOrder');
    Route::get('/estimate', 'EstimateController@index')->name('estimates');
    Route::get('/estimate/mail/{id}', 'EstimateController@estimateEmail');

/**
 * Work Orders
 */
    Route::get('workorder/{id}/show', 'WorkOrderController@show');
    Route::get('workorder/techenroute/{id}', 'WorkOrderController@techEnroute');

    ROUTE::get('email', function (){
        $title= 'Test';
        $content = 'Content';

       return view('emails.estimate', compact('title', 'content'));
    });

    ROUTE::get('/wo', function (){
        $wo = Vanguard\WorkOrder::get();

        foreach ($wo as $row )
        {
            $e = Vanguard\Estimate::find($row->estimateId);

            $row->totalCharge = $e->total;
            $row->save();
        }
    });
Route::post('/updateVehicle/{id}', 'WorkOrderController@updateVehicle');
/**
 *
 */

/**
 *
 * Calander
 */
    Route::get('/ical/{cid}', 'IcalController@getEventsICalObject');


/**
 * Invoices
 */
    Route::get('/estimate/invoice/{id}', 'InvoiceController@estimateConvert');

use GuzzleHttp\Client;

Route::get('/vin-api/{vin}', function($vin) {
    //dd($vin);
    $headers = [
       'Content-Type' => 'application/json',
       'x-rapidapi-host' => 'vindecoder.p.rapidapi.com',
       'x-rapidapi-key' => '6797e8dda6msh238d7561690a0e3p1c0cb0jsn907db54b4db9',
    ];
    $params = [
    'Content-Type' => 'application/json',
       'vin' => $vin,

    ];

    $client = new Client([
        'headers' => $headers,
        'query' => $params
    ]);

    $response = $client->request('GET', "https://vindecoder.p.rapidapi.com/decode_vin");
    //dd($response);
    $statusCode = $response->getStatusCode();
    $body = $response->getBody()->getContents();

    //dd($body);

    return $body;
});

    /**
 * Installation
 */

Route::group(['prefix' => 'install'], function () {
    Route::get('/', 'InstallController@index')->name('install.start');
    Route::get('requirements', 'InstallController@requirements')->name('install.requirements');
    Route::get('permissions', 'InstallController@permissions')->name('install.permissions');
    Route::get('database', 'InstallController@databaseInfo')->name('install.database');
    Route::get('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('install-app', 'InstallController@install')->name('install.install');
    Route::get('complete', 'InstallController@complete')->name('install.complete');
    Route::get('error', 'InstallController@error')->name('install.error');
});
