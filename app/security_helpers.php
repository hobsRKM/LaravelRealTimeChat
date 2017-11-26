<?php

/*
 * All Security Checks  are implented using this helper file
 */

use LaravelRealtimeChat\Repositories\Team\DbTeamRepository;
class SecurityHelper  {
        
         
public static function authorizeWrite($type) {
        switch ($type) {
                case "create_project":
                        if (Session::get('role'))
                                return "allowed";
                        else
                                return "notAllowed";
                        break;
                case "create_task":
                        if (Session::get('role'))
                        {
                                /**
                                 * Cross check 
                                 */
                                $teamRepository = new DbTeamRepository();
                                $teamId=  \Input::get("teamId");
                                  $id = $teamRepository->getTeamDecodedId($teamId);
                                 $teamId=$id;
                                $projectId=\Input::get("projectId");
                                $user_id = \DB::table('team_heads')
                                                    ->select('user_id')
                                                    ->where('team_heads.team_id', '=', $teamId)
                                          ->where('team_heads.project_id', '=', $projectId)
                                          ->first();
                                if($user_id['user_id']==\Session::get('userId'))
                                        return "allowed";
                                else
                                      return "notAllowed";  
                        }
                        else
                                return "notAllowed";
                        break;
        }
}

public static function authorizeRead() {
        
}

}