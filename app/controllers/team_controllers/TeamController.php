<?php
use LaravelRealtimeChat\Repositories\Team\TeamRepository;
use LaravelRealtimeChat\Repositories\Task\TaskRepository;
class TeamController extends \BaseController {
 /**
         * @var LaravelRealtimeChat\Repositories\TeamRepository
         */
        private $teamRepository;
        /**
         * @var LaravelRealtimeChat\Repositories\TaskRepository
         */
        private $taskRepository;

        public function __construct(TeamRepository $teamRepository, TaskRepository $taskRepository) {
                $this->teamRepository = $teamRepository;
                $this->taskRepository = $taskRepository;
        }
    /**
     * @function creates team
     * @return message string
     */
    public function create_team_channels() {
        $teamName = Input::get('name');
        if ($teamName == '')
            return View::make('templates/greeting')->with('danger', "Please provide a team name!");
//Check for duplicates
        $exists = DB::table('team_channels')
                        ->select('channel_view_name')
                        ->where('channel_view_name', '=', $teamName)
                        ->where('author_id', '=', Auth::user()->id)
                        ->where('channel_view_name', '=', $teamName)->first();
        if (count($exists) == 0) {
            $id = DB::table('team_channels')->insertGetId(
                    ['channel_name_id' => Session::get('channelId'), 'team_channel_id' => Hash::make(Auth::user()->email), 'author_id' => Auth::user()->id, 'channel_view_name' => $teamName]
            );
            //Add the admin as user to the team created
            DB::table('team_channel_users')->insert(
                    ['team_channel_name_id' => $id, 'user_id' => Auth::user()->id]
            );
            
            //Make  admin as default team head
             \DB::table('team_heads')->insertGetId(
                            [ "team_id" => $id, 'author_id' => \Session::get("userId"), "user_id" =>\Session::get("userId")]
                    );
            $data = array("create_team" => true, "message" => "Team Created Succesfully.", "teamId" => $id);
            return View::make('templates/greeting')->with('data', $data);
        } else {
            return View::make('templates/greeting')->with('danger', "Team name already in use.Pleas try other!");
        }
    }

    public function get_teams() {
        $channelId = Input::get('channelId');
        if (Session::get("role") == 1) {
            $teams = DB::table('channels')
                            ->select('team_channels.id','team_channels.team_channel_id', 'channels.channel_name', 'team_channels.channel_view_name', 'channels.author_id', "team_channels.created_at",'team_heads.author_id','team_heads.user_id as team_head_id')
                            ->leftJoin('team_channels', 'channels.id', '=', 'team_channels.channel_name_id')
                            ->leftJoin('team_heads', 'team_heads.team_id', '=', 'team_channels.id')
                            ->where('team_channels.id', '!=', '')
                            ->where('channels.id', '=', $channelId)->distinct()->get();
        } else {
            $teams = DB::table('team_channels')
                            ->select('team_channels.channel_view_name', 'team_channels.team_channel_id', 'team_channels.id', 'team_channels.created_at','team_heads.author_id','team_heads.user_id as team_head_id')
                            ->leftJoin('team_channel_users', 'team_channel_users.team_channel_name_id', '=', 'team_channels.id')
                            ->leftJoin('team_heads', 'team_heads.team_id', '=', 'team_channels.id')
                            ->where('team_channel_users.user_id', '=', Auth::user()->id)->distinct()->get();
        }


        return View::make('templates/team_list_view')->with('teams', $teams);
    }

    public function create_team_members() {

// Get the value from the form
        $teamId = Input::get('teamId');
        $emails = Input::get('email');
        $failCheck = false;
        $failedEmail = '';
  
        foreach ($emails as $email) {

            /**
             * If user doesnt exists in fm database,trigger a mail for account creation
             * if user already exists check if he exists in team else add him to team
             * 
             */
            //get user id

            $userId = DB::table('users')
                            ->select('id')
                            ->where('email', '=', $email)->first();

            if (count($userId) > 0) {//if user already exists
                //check if user is already a member of this team
                $exists = DB::table('team_channel_users')
                                ->select('team_channel_users.user_id')
                                ->where('team_channel_users.user_id', '=', $userId['id'])
                                ->where('team_channel_users.team_channel_name_id', '=', $teamId)->first();

                if (count($exists) == 0) {//if exists insert into team_channel_users
                    DB::table('team_channel_users')->insert(
                            ['team_channel_name_id' => $teamId, 'user_id' => $userId['id']]
                    );
                   
                    $this->teamRepository->updateNewMemberJoinNotification($teamId,$userId['id']);
                } else {
                    $failCheck = true;
                    $failedEmail.=$email;
                }
            } else {
                /* new user,trigger email
                 * generate a token for each invitation
                 * 
                 */

                $token = Crypt::encrypt(time());
                ;
                $url = Config::get('constants.constants_list.BASE_URL') . "invitation/" . $token;
                $data = array("teamId" => $teamId, "email" => $email, "url" => $url, "token" => $token);


                Mail::send('templates/email_template', $data, function($message)use ($data) {

                            $message->to($data['email'], '')
                                    ->subject('Welcome to Fusion Mate!');
                            //->setBody("Hi, <br/> You have an inviation from a team.Click below url and join to collaborate with your team members <br/>".$data['url']);
                            if (Mail::failures()) {
                                return "There was an error in sending email to one of the recipients";
                            } else {
                                DB::table('invitation_token')->insert(
                                        ['token' => $data['token'],'team_id'=>$data['teamId'],'email'=>$data['email']]
                                );
                            }
                        });
            }
        }

        if ($failCheck != true)
            return View::make('templates/greeting')->with('message', "Invited Successfully!");
        else
            return View::make('templates/greeting')->with('danger', "Email already exists." . ":" . $failedEmail);
// Create a random  'pass' and send invitation via mail
//            $id = DB::table('users')->insertGetId(
//                ['first_name' => Input::get('email'),'last_name' => Input::get('email'),'email' => Input::get('email'), 'password' => Hash::make(Input::get('email'))]
//        );
//        DB::table('user_roles')->insert(
//                ['user_id' => $id, 'role_id' => "3"]
//        );
//            DB::table('team_channel_users')->insert(
//                    ['team_channel_name_id' => $teamId, 'user_id' => $id]
//            );
    }

    public function list_teams_and_team_memebers() {
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
         * Loothrough each team ids obtained and get team users
         * 
         * 
         */
        foreach ($teamName as $values) {
            $teamMembers = DB::table('users')
                            ->select('users.first_name', 'users.id')
                            ->leftJoin('team_channel_users', 'team_channel_users.user_id', '=', 'users.id')
                            ->where('team_channel_users.team_channel_name_id', '=', $values["id"])->get();
            $queries = DB::getQueryLog();
//            if (count($teamMembers) > 1) {// atelast there should be one user except the admin who craeted the team
                foreach ($teamMembers as $memeber) {
                    /**
                     * Get memeber login status too
                     * 
                     */
                    $status = DB::table('login_status')->select('status')->where('user_id', $memeber["id"])->first();
                    $teamArr[$values["channel_view_name"] . "_" . $values["team_channel_id"]."_".$values["id"]][] = $memeber["first_name"] . "_" . $memeber["id"] . "_" . $status['status'];
//                }
            }
        }
       // echo $this->db->last_query(); exit;
//        print_r($teamArr);
        return json_encode($teamArr);
    }

    /**
      @function gets team members
      @param team id  - id of team to list its members

     */
    function getTeamMembers() {
        $teamId = Input::get('teamId');
        $teamArr = array();
        $teamMembers = DB::table('users')
                        ->select('users.first_name', 'users.id', 'users.last_name')
                        ->leftJoin('team_channel_users', 'team_channel_users.user_id', '=', 'users.id')
                        ->where('team_channel_users.team_channel_name_id', '=', $teamId)->get();


        foreach ($teamMembers as $memeber) {
            /**
             * Get memeber login status too
             * 
             */
            $status = DB::table('login_status')->select('status')->where('user_id', $memeber["id"])->first();
            if ($memeber['id'] != Session::get('userId'))
                $teamArr[] = $memeber["first_name"] . "_" . $memeber["last_name"] . "_" . $memeber["id"] . "_" . $status['status'];
        }
        return View::make('templates/list_members')->with('members', $teamArr);
    }

    function activate_invited_member( $token) {
        //Validate token for security reasons 
        $isValidToken = DB::table('invitation_token')
                        ->select('token')
                        ->where('token', '=', $token)->first();
        //Team Name

        if (count($isValidToken) > 0) {
            $invitationDetails= DB::table('invitation_token')
                            ->select('team_id','email')
                            ->where('token', '=', $token)->first();
                    
            $teamName = DB::table('team_channels')
                            ->select('channel_view_name')
                            ->where('id', '=', $invitationDetails['team_id'])->first();
            $data = array("teamName" => $teamName['channel_view_name'], "email" => $invitationDetails['email'], "token" => $token, "teamId" => $invitationDetails['team_id']);
            return View::make('layouts/invitation_view')->with('data', $data);
        }
        else
            return "your not authorized to access this page";
    }
function deleteTeam(){
       $enTeamId=Input::get("teamId");
        $teamId=$this->teamRepository->getTeamDecodedId($enTeamId);
        DB::table('team_conversations_read_status')->where('team_channel_id', $teamId)->delete();
         DB::table('team_conversations')->where('team_channel_id', $teamId)->delete();
        DB::table('team_channel_users')->where('team_channel_name_id', $teamId)->delete();
        $status=  DB::table('team_channels')->where('id', $teamId)->delete();
        return json_encode($status);
    }
    
         public function list_teams_memebers() {
       
              $offlineSort=array();
            $onlineSort=array();
             /**
         * 
         * Get all team details where the user is a memeber
         * 
         * 
         * 
         */
        $teamArr = array();
         $data = array();
        $teamName = DB::table('team_channels')
                        ->select('team_channels.channel_view_name', 'team_channels.team_channel_id', 'team_channels.id')
                        ->leftJoin('team_channel_users', 'team_channel_users.team_channel_name_id', '=', 'team_channels.id')
                        ->where('team_channel_users.user_id', '=', Auth::user()->id)->get();
        /**
         * Loothrough each team ids obtained and get team users
         * 
         * 
         */
        foreach ($teamName as $values) {
           
            $teamMembers = DB::table('users')
                            ->select('users.first_name','users.last_name', 'users.id','users.profile_pic','team_channels.channel_view_name','team_channels.id as team_id')
                            ->leftJoin('team_channel_users', 'team_channel_users.user_id', '=', 'users.id')
                            ->leftJoin('team_channels', 'team_channels.id', '=', 'team_channel_users.team_channel_name_id')
                            ->where('team_channel_users.team_channel_name_id', '=', $values["id"])->get();
            if (count($teamMembers) > 1) {// atelast there should be one user except the admin who craeted the team
                foreach ($teamMembers as $memeber) {
                    /**
                     * Get memeber login status too
                     * left join `team_channels` on `team_channels`.`id` = `team_channel_users`.`team_channel_name_id`
                     */
                    $status = DB::table('login_status')->select('status')->where('user_id', $memeber["id"])->first();
                    $memeber['status']=$status;
                    if($status['status']=="offline")
                        $offlineSort[]=$memeber;
                    else
                        $onlineSort[]=$memeber;
                    
                    if(count($onlineSort)==0)//if there are no online users do not merge
                        $data[]=$memeber;
                
                }
   
              
            }
        } 
  
       
        if(count($onlineSort)>0){// if online users are there pass merged data else pass non merged data
          
            return View::make('templates/team_members')->with('data',  array_merge($onlineSort,$offlineSort));
        }
        else
            return View::make('templates/team_members')->with('data',$data  );
    }

    public function get_team_name(){
        $enTeamId=Input::get("teamId");
        $teamId=$this->teamRepository->getTeamDecodedId($enTeamId);
        $data = $this->teamRepository->getTeamName($teamId);
        return $data;
    }
    
    public function update_team_name(){
        $enTeamId=Input::get("teamId");
        $teamId=$this->teamRepository->getTeamDecodedId($enTeamId);
        $data = $this->teamRepository->updateTeamName($teamId);
        return $data;
    }
    
    public function update_team_head(){
        $enTeamId=Input::get("teamId");
        $teamId=$this->teamRepository->getTeamDecodedId($enTeamId);
        $data = $this->teamRepository->updateTeamHead($teamId);
        return $data;
    }
     

}