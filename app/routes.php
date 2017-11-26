<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

App::bind('LaravelRealtimeChat\Repositories\Team\TeamRepository', 'LaravelRealtimeChat\Repositories\Team\DbTeamRepository');
App::bind('LaravelRealtimeChat\Repositories\Task\TaskRepository', 'LaravelRealtimeChat\Repositories\Task\DbTaskRepository');
//App::bind('LaravelRealtimeChat\Repositories\User\UserRepository', 'LaravelRealtimeChat\Repositories\User\DbUserRepository');


Route::get('/', array(
	'as'   => 'main',
	'uses' => 'MainController@welcome'
));
Route::get('/drive', array(
	'as'   => 'drive',
	'uses' => 'DriveController@drive'
));

Route::get('/home', array(
    'before' => 'auth',
	'as'   => 'home',
	'uses' => 'HomeController@showWelcome'
));
Route::get('/reset', array(
    
	'as'   => 'getRemind',
	'uses' => 'RemindersController@getRemind'
));
Route::post('/post_remind', array(
    
	'as'   => 'postRemind',
	'uses' => 'RemindersController@postRemind'
));
Route::post('/post_reset', array(
    
	'as'   => 'postReset',
	'uses' => 'RemindersController@postReset'
));
Route::get('/password/reset/{token}', array(
    
	'as'   => 'getReset',
	'uses' => 'RemindersController@getReset'
));
Route::post('/login', array(
	'as'   => 'auth.postLogin',
	'uses' => 'AuthController@postLogin'
));
Route::post('/update_login_status', array(
    'before' => 'auth',
	'as'   => 'login_status',
	'uses' => 'AuthController@updateStatus'
));
Route::get('/logout', array(
	'as'   => 'logout',
	'uses' => 'AuthController@logout'
));
//Route::get('/login', array(
//	'as'   => 'auth.getLogin',
//	'uses' => 'AuthController@getLogin'
//));

Route::get('/register', array(
	'as'   => 'register_user',
	'uses' => 'RegisterController@registerUser'
));



Route::get('/chat/', array(
	'before' => 'auth',
	'as'     => 'chat.index',
	'uses'   => 'ChatController@index'
));

Route::post('/getmessages/', array(
	'before' => 'auth',
	'as'     => 'messages.index',
	'uses'   => 'MessageController@index'
));

Route::post('/messages/', array(
	'before' => 'auth',
	'as'     => 'messages.send_message',
	'uses'   => 'MessageController@send_message'
));
Route::post('/typing/', array(
	'before' => 'auth',
	//'as'     => 'messages.store',
	'uses'   => 'MessageType@index'
));

Route::post('users/{user_id}/conversations', array(
	'before' => 'auth',
	'as'	 => 'conversations_users.index',
	'uses'	 => 'ConversationUserController@index'
));

Route::post('/conversations/', array(
	'before' => 'auth',
	'as' 	 => 'conversations.store',
	'uses'   => 'ConversationController@store'
));
Route::get('/personal_conversations/', array(
	'before' => 'auth',
	'as' 	 => 'conversations.personal_conversations',
	'uses'   => 'ConversationController@personal_conversations'
));
Route::get('/conversations/', array(
	'before' => 'auth',
	'as' 	 => 'conversations',
	'uses'   => 'ConversationController@conversations'
));

Route::post('/create_team', array(
	'before' => 'auth',
	'as' 	 => 'createTeam',
	'uses'   => 'TeamController@create_team_channels'
));

Route::post('/create_team_member', array(
	'before' => 'auth',
	'as' 	 => 'createTeamMember',
	'uses'   => 'TeamController@create_team_members'
));


Route::post('/get_teams', array(
	'before' => 'auth',
	'as' 	 => 'getTeam',
	'uses'   => 'TeamController@get_teams'
));

Route::get('/list_teams', array(
	'before' => 'auth',
	'as' 	 => 'list_teams_and_team_memebers',
	'uses'   => 'TeamController@list_teams_and_team_memebers'
));

Route::post('/unread_notifications', array(
	'before' => 'auth',
	'as' 	 => 'get_unread_notifications',
	'uses'   => 'NotificationController@unread_notifications'
));

Route::post('/update_read_status', array(
	'before' => 'auth',
	'as' 	 => 'update_read_status',
	'uses'   => 'NotificationController@update_status'
));

Route::post('/get_team_members', array(
	'before' => 'auth',
	'as' 	 => 'team_members',
	'uses'   => 'TeamController@getTeamMembers'
));


Route::get('/invitation/{token}', array(
	
	'as' 	 => 'invitation',
	'uses'   => 'TeamController@activate_invited_member'
));

Route::get('/login/{email}/{password}/{token}', array(
	
	'as' 	 => 'invitation_account_creation',
	'uses'   => 'AuthController@getSignup'
));


Route::get('/user_profile', array(
	'as'   => 'user_profile',
	'uses' => 'UserProfileController@userProfile'
));

Route::post('/updateprofile', array(
	'as'   => 'upadte_profile',
	'uses' => 'UserProfileController@updateProfile'
));

Route::post('/updateprofilepicture', array(
	'as'   => 'update_profile_picture',
	'uses' => 'UserProfileController@updateProfilePicture'
));

Route::get('/view_profile/{userId}', array(
	'as'   => 'view_profile',
	'uses' => 'UserProfileController@viewProfile'
));

Route::post('/update_timezone/', array(
    'before' => 'auth',
	'as'   => 'update_tz',
	'uses' => 'AuthController@updateTimeZone'
));

/*
 * Task routes
 * 
 */
Route::group(array('prefix' => 'task','before' => 'auth'), function()
{
    Route::post('/get_project_teams', 'TaskController@get_project_teams');
     Route::post('/get_members', 'TaskController@get_members');
    Route::post('/create_project', array('before' => 'security_check:create_project,write', 'as'=>'createProject','uses' => 'TaskController@create_project'));
     Route::post('/create_task', array('before' => 'security_check:create_task,write', 'as'=>'createTask','uses' => 'TaskController@create_task'));
    Route::post('/dashboard', 'TaskController@dashboard');
     Route::post('/validate_create_task', array('before' => 'security_check:create_task,write'));
          Route::post('/rollback_saved_task', array('as'=>'rollbackTask','uses' => 'TaskController@rollback_task'));
Route::post('/filter_grid', array( 'as'=>'filterGrid','uses' => 'TaskController@filter_grid'));
  Route::post('/filter_all_dashboard_data', array( 'as'=>'filterAllDashboard','uses' => 'TaskController@filter_dashboard'));
Route::post('/view_assignment', array( 'as'=>'viewAssignment','uses' => 'TaskController@view_assignment'));
Route::get('/updates/{task_id}', array( 'as'=>'recentUpdates','uses' => 'TaskController@recent_updates'));
});

Route::post('/delete_team', array(
	'before' => 'auth',
	'as' 	 => 'delete_team',
	'uses'   => 'TeamController@deleteTeam'
));

Route::post('/update_team_name', array(
	'before' => 'auth',
	'as' 	 => 'update_team_name',
	'uses'   => 'TeamController@update_team_name'
));

Route::post('/update_team_head', array(
	'before' => 'auth',
	'as' 	 => 'update_team_head',
	'uses'   => 'TeamController@update_team_head'
));
Route::post('/get_team_name', array(
	'before' => 'auth',
	'as' 	 => 'get_team_name',
	'uses'   => 'TeamController@get_team_name'
));
Route::get('/list_teams_memebers', array(
	'before' => 'auth',
	'as' 	 => 'list_teams_memebers',
	'uses'   => 'TeamController@list_teams_memebers'
));

Route::post('/upload_user_files/{name?}', array(
	'as'   => 'upload_user_files',
	'uses' => 'FileUploadController@uploadFiles'
));
Route::post('/fileUploadStatus', array(
	'as'   => 'fileUploadStatus',
	'uses' => 'FileUploadController@fileUploadStatus'
));
Route::post('/get_snippet_code', array(
	'before' => 'auth',
	'as' 	 => 'get_snippet_code',
	'uses'   => 'ConversationController@get_snippet_code'
));

Route::get('/video', array(
	'as'   => 'video',
	'uses' => 'VideoChatController@video'
));

Route::get('/settings', array(
	'as'   => 'settings',
	'uses' => 'UserProfileController@settings'
));

Route::post('/updatePassword', array(
	'as'   => 'update_password',
	'uses' => 'UserProfileController@updatePassword'
));

Route::post('/deactivateAccount', array(
	'as'   => 'deactivate',
	'uses' => 'UserProfileController@deactivateAccount'
));
