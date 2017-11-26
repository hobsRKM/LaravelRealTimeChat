<?php
use LaravelRealtimeChat\Repositories\Team\TeamRepository;
class AuthController extends \BaseController {
        
    
    private $teamRepository;
    /**
     * @var LaravelRealtimeChat\Repositories\TaskRepository
     */
      

    public function __construct(TeamRepository $teamRepository) {
            $this->teamRepository = $teamRepository;

    }
    public function updateStatus() {
        $currentTimeStamp = Carbon\Carbon::now();
        $currentTimeStamp = $currentTimeStamp->toDateTimeString();

        $status = Input::get('data');


        $exists = DB::table('login_status')->select('user_id')->where('user_id', Auth::user()->id)->get();

        if ($status == "online" && count($exists) == 0) {

            $id = DB::table('login_status')->insertGetId(
                    ['user_id' => Auth::user()->id, 'status' => $status, 'created_at' => $currentTimeStamp, 'updated_at' => $currentTimeStamp]
            );
        }
        if ($status == "online" && count($exists) > 0) {
            DB::table('login_status')
                    ->where('user_id', Auth::user()->id)
                    ->update(array('status' => "online", 'created_at' => $currentTimeStamp, 'updated_at' => $currentTimeStamp));
        }

        if ($status == "offline") {
            DB::table('login_status')
                    ->where('user_id', Auth::user()->id)
                    ->update(array('status' => "offline", 'updated_at' => $currentTimeStamp));
        }

        $this->notifyTeamMemebers($status);
    }

    public function postLogin() {


//        $input = Input::only(array(
//                    'email',
//                    'password'
//        ));

       
        if(Input::get('token')!=''){
			 $rules = array(
			'email' => 'required|email',
			'password' => 'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{1,}$/'
		);
         $messages = array(
            'password.regex' => 'The password must containt atleast 1 Upper Case letters[A-Z],1 Lower Case Letter[a-z],1 numeric letter [0-9] and 1 special character.',
           
        );}
        else{
			 $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );
          $messages = array(
            'password.regex' => 'Invalid Username/Password',
           
        );   
        }
        

        $validator = Validator::make(Input::all(), $rules,$messages);

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(), 
                400
                )); // 400 being the HTTP code for an invalid request. 
        } else {
            $token = Input::get('token'); // for invited account
            if ($token != '') {
               
                $result = DB::table('invitation_token')->where('token', '=', $token)->first();
                if (count($result)>0) {//token was valid and was deleted
                    //Create invited account
                    $userInfo=explode('@',$result['email']);
                    $id = DB::table('users')->insertGetId(
                            ['first_name' => $userInfo[0], 'last_name' => '', 'email' => $result['email'], 'password' => Hash::make(Input::get('password'))]
                    );
                    DB::table('user_roles')->insert(
                            ['user_id' => $id, 'role_id' => "3"]
                    );
                    DB::table('team_channel_users')->insert(
                            ['team_channel_name_id' => $result['team_id'], 'user_id' => $id]
                    );
                     //delete token from database before creating invited account
                    DB::table('invitation_token')->where('token', '=', $token)->delete();
                    $this->teamRepository->updateNewMemberJoinNotification($result['team_id'],$id);
                }
                else{
                    return Response::json(array(
                'success' => false,
                'errors' => "Invalid Request", 
                400
                ));
                }
            }
        }

        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')))) {

            /* Store basic information in session of logged in user  */
            $role = DB::table('roles')
                            ->leftJoin('user_roles', 'roles.id', '=', 'user_roles.role_id')
                            ->where('user_id', '=', Auth::user()->id)->first();


            $channelName = DB::table('channels')
                            ->where('author_id', '=', Auth::user()->id)->first();

            Session::put('userId', Auth::user()->id);
            Session::put('firstName', Auth::user()->first_name);
            Session::put('lastName', Auth::user()->last_name);
            Session::put('profilePic', Auth::user()->profile_pic);
            Session::put('role', $role['role_id']);
            Session::put('channelId', $channelName['id']);

            return Response::json(array(
                        'success' => true
                            ), 200);
        }
        else{
             $errorMsg = array(
            'errormsg' => 'Invalid Email or Password'
        );
             return Response::json(array(
                'success' => false,
                'errors' => $errorMsg, 
                400
                )); // 400 being the HTTP code for an invalid request. 
        }
    }

    public function logout() {
   

Auth::logout();
sleep(1);
Auth::logout();

       
        
        return Redirect::to('/');
    }

    public function getSignup($email, $password, $token) {
        //Delete token
        //Create Account
    }

    /**
     * called functions
     */
    public function notifyTeamMemebers($status) {
        /**
         * 
         * Get all team details where the user is a memeber
         * 
         * 
         * 
         */
        $teamArr = array();
        $teamName = DB::table('team_channels')
                        ->select('team_channels.channel_view_name', 'team_channels.team_channel_id', 'team_channels.id')
                        ->leftJoin('team_channel_users', 'team_channel_users.team_channel_name_id', '=', 'team_channels.id')
                        ->where('team_channel_users.user_id', '=', Auth::user()->id)->get();
        /**
         * Loothrough each team ids obtained and get team users where 'this user was a memeber'
         * 
         * 
         */
        foreach ($teamName as $values) {
            $teamMembers = DB::table('users')
                            ->select('users.first_name', 'users.id')
                            ->leftJoin('team_channel_users', 'team_channel_users.user_id', '=', 'users.id')
                            ->where('team_channel_users.team_channel_name_id', '=', $values["id"])->get();

            foreach ($teamMembers as $memeber) {
                //Publish data to redis
                $channelId = $memeber["id"] . "_" . $values["team_channel_id"];

                $teamChannelId = $values["team_channel_id"];
                $data = array(
                    'room' => $channelId,
                    'message' => array('user_id' => Auth::user()->id, "status" => $status)
                );
                Event::fire(LoginStatusEventHandler::EVENT, array(json_encode($data)));
            }
        }
    }

    public function updateTimeZone(){
        $tzName=Input::get('tz');
        
        
        storeUserTimeZone($tzName);
        
    }
}
