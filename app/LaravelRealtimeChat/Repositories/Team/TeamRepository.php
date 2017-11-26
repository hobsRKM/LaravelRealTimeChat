<?php namespace LaravelRealtimeChat\Repositories\Team;

interface TeamRepository  {

    /**
     * Fetch a record by id
     * 
     * @param $id
     */
    public function getTeams($id);

    /**
     * Fetch a record by its id
     *
     * @param $id
     */
    public function getMembers($id);
    
    
      /**
     * Decode a team ecnoded Id
     *
     * @param $id
     */
    public function getTeamDecodedId($id);
     /**
     * fetch a team name by Id
     *
     * @param $id
     */
    public function getTeamName($id);
    
      /**
     * update a team name by Id
     *
     * @param $id
     */
    public function updateTeamName($id);
    
       /**
     * update a team head by Id
     *
     * @param $id
     */
    public function updateTeamHead($id);
    
     /**
     * update a notification
     *
     * @param $id,$teamid
     */
    public function updateNewMemberJoinNotification($team_id,$user_id);
    
    /**
     * get user details
     *
     * @param $user_id
     */
    public function getUserDetails($user_id);
    
    
}
