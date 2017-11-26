<?php

namespace LaravelRealtimeChat\Repositories\Team;
use App\Events\JoinNotificationEvenHandler;
class DbTeamRepository implements TeamRepository {

        /**
         * @param int $id channel_name_id
         * @return Arr returns array of teams aligned to user or admin
         */
        public function getTeams($id) {//
                if (\Session::get("role") == 1) {
                        $teams = \DB::table('channels')
                                            ->select('team_channels.id', 'channels.channel_name', 'team_channels.channel_view_name', 'channels.author_id', "team_channels.created_at", 'team_channels.team_channel_id','team_heads.user_id')
                                            ->leftJoin('team_channels', 'channels.id', '=', 'team_channels.channel_name_id')
                                              ->leftJoin('team_heads', 'team_heads.team_id', '=', 'team_channels.id')
                                            ->where('team_channels.id', '!=', '')
                                            ->where('channels.id', '=', $id)->distinct()->get();
                }
                else {
                        $teams = \DB::table('team_channels')
                                            ->select('team_channels.channel_view_name', 'team_channels.team_channel_id', 'team_channels.id', 'team_channels.created_at','team_heads.user_id')
                                            ->leftJoin('team_channel_users', 'team_channel_users.team_channel_name_id', '=', 'team_channels.id')
                                                ->leftJoin('team_heads', 'team_heads.team_id', '=', 'team_channels.id')         
                                               ->where('team_channel_users.user_id', '=', \Auth::user()->id)->distinct()->get();
                }

                return $teams;
        }
        
        /**
         * @param int $id team_id
         * @return Arr returns array of members aligned to a team
         */
        public function getMembers($id) {
                $teamId      = $id;
                $teamArr     = array();
                $teamMembers = \DB::table('users')
                                    ->select('users.first_name', 'users.id', 'users.last_name')
                                    ->leftJoin('team_channel_users', 'team_channel_users.user_id', '=', 'users.id')
                                    ->where('team_channel_users.team_channel_name_id', '=', $teamId)->get();
                foreach ($teamMembers as $memeber) {
                        $teamArr[] = $memeber["first_name"] . "_" . $memeber["last_name"] . "_" . $memeber["id"];
                }
                return $teamArr;
        }

        public function getTeamDecodedId($id) {
                $team = \DB::table('team_channels')
                                    ->select('id')
                                    ->where('team_channel_id', '=', $id)->first();
                return $team['id'];
        }
        
         public function getTeamName($id) {
                $team = \DB::table('team_channels')
                                    ->select('team_channels.channel_view_name',\DB::raw('CONCAT(users.first_name, " ", users.last_name) AS full_name'))
                                    ->leftJoin('team_heads', 'team_heads.team_id', '=', 'team_channels.id')
                                    ->leftJoin('users', 'users.id', '=', 'team_heads.user_id')
                                    ->where('team_channels.id', '=', $id)->first();
                return $team['channel_view_name']."_".$team['full_name'];
        }
        
        public function updateTeamName($id) {
        $name = \Input::get('name');
        if(empty($name))
            return "empty";
        try {
            //validate for duplicates
            $data = \DB::table('team_channels')
                            ->select('team_channels.channel_view_name')
                            ->where('channel_view_name', '=', $name)->first();
            if (count($data) == 0) {
                //perform update
                \DB::table('team_channels')
                        ->where('id', $id)
                        ->update(['channel_view_name' => $name]);
            } else
                return "exists";
        } catch (\Exception $e) {
            //coudnt update
            return "false";
        }
        return "true";
    }

    public function updateTeamHead($id) {
        $userId = \Input::get('userId');
        if (empty($userId))
            return "empty";
        try {

            //perform update
            \DB::table('team_heads')
                    ->where('team_id', $id)
                    ->update(['user_id' => $userId]);
        } catch (\Exception $e) {
            //coudnt update
            return "false";
        }
        return "true";
    }
    
    public function updateNewMemberJoinNotification($team_id,$user_id){
       
        /**
         * 
         * Get all team details where the user is a memeber
         * 
         * 
         * 
         */
        $teamArr = array();
        
       $details= $this->getUserDetails($user_id);
      
            $teamMembers =\DB::table('users')
                            ->select('users.first_name','users.last_name', 'users.id','team_channels.channel_view_name','team_channels.team_channel_id','team_channels.id as team_id_decoded')
                            ->leftJoin('team_channel_users', 'team_channel_users.user_id', '=', 'users.id')
                    ->leftJoin('team_channels', 'team_channel_users.team_channel_name_id', '=', 'team_channels.id')
                            ->where('team_channel_users.team_channel_name_id', '=', $team_id)->get();

            foreach ($teamMembers as $memeber) {
                //insert notification
                 $lastId = \DB::table('invitation_notification')->insertGetId(
                        ['team_id' => $team_id, "team_user" => $memeber["id"],'new_user'=>$user_id]
                );
                //Publish data to redis
                $channelId = $memeber["id"] . "_" . $memeber["team_channel_id"];

                $teamChannelId = $memeber["team_channel_id"];
               
                $data = array(
                    'room' =>$memeber["id"] . "_" . $memeber["team_channel_id"],
                    'message' => array('new_user_id'=>$user_id,'new_user_channel_id' => $user_id."_".$teamChannelId,'user_id' =>$memeber["id"] ,'name'=>$details['first_name']." ".$details['last_name'],'team_name'=>$memeber['channel_view_name'],'team_id'=>$memeber['team_id_decoded'])
                );
//                 print_r($data);
               \Event::fire(\JoinNotificationEventHandler::EVENT, array(json_encode($data)));
            }
        
   
    }
    
    
      public function getUserDetails($user_id){
             $details =\DB::table('users')
              ->select('users.first_name','users.last_name')
                     ->where('id', '=', $user_id)   
                     ->first();
             return $details;
      }

}