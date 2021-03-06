<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (\Sentry::getUser()){
    return Redirect::route('admin.home');
	}
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/**
* Sentry filters
* http://laravelsnippets.com/snippets/sentry-route-filters
* 
* Checks if the user is logged in
*/
Route::filter('loggedIn', function()
{
 if(Sentry::check() != 1) {
 	return Redirect::to('login');
 }
});
 
/**
* hasAccess filter (permissions)
*
* Check if the user has permission (group/user)
*/
Route::filter('hasAccess', function($route, $request, $value) {
	$user = Sentry::getUser();

	if( ! $user->hasAccess($value)){
	 return Redirect::to('login')->withErrors(array('message' => 'You do not have access to view this page'));
	}
 
});
 
/**
* InGroup filter
*
* Check if the user belongs to a group
*/
Route::filter('inGroup', function($route, $request, $value)
{
 try
 {
$user = Sentry::getUser();
 
$group = Sentry::findGroupByName($value);
 
 if( ! $user->inGroup($group))
 {
 return Redirect::route('cms.login')->withErrors(array(Lang::get('user.noaccess')));
 }
 }
 catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
 {
 return Redirect::route('cms.login')->withErrors(array(Lang::get('user.notfound')));
 }
 
 catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
 {
 return Redirect::route('cms.login')->withErrors(array(Lang::get('group.notfound')));
 }
});
