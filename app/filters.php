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

use LaravelRealtimeChat\Repositories\Task\TaskRepository;
App::before(function($request) {
        //
});


App::after(function($request, $response) {
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

Route::filter('auth', function() {
        if (Auth::guest()) {
                if (Request::ajax()) {
                        return Response::make('Unauthorized', 401);
                }
                else {
                        return Redirect::to('/');
                }
        }
});


Route::filter('auth.basic', function() {
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

Route::filter('guest', function() {
        if (Auth::check())
                return Redirect::to('/');
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

Route::filter('csrf', function() {
        if (Session::token() !== Input::get('_token')) {
                throw new Illuminate\Session\TokenMismatchException;
        }
});


Route::filter('security_check', function($route, $request, $check_name, $check_type) {
        
        if ($check_type == "write") {
                switch ($check_name) {
                        case "create_project":$check = SecurityHelper::authorizeWrite("create_project");
                                if ($check == "notAllowed")
                                        return Response::json(array(
                                                       'errors' => "You are not authorized to perform this operation!",
                                                       400
                                        ));
                                break;

                        case "create_task":$check = SecurityHelper::authorizeWrite("create_task");
                                if ($check == "notAllowed")
                                        return json_encode (array('success' => false));
                                if(\Request::segment(2)=='validate_create_task' && $check=="allowed")
                                         return Response::json(array(
                                                       'success' => true,
                                                       200
                                        )); 
                               break;
                                
                }
        }
});
