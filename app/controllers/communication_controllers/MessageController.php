<?php

class MessageController extends \BaseController {

    /**
     * Display a listing of messages.
     *
     * @return Response
     */
    public function index() {

        $conversation = Conversation::where('name', Input::get('conversation'))->first();
        $messages       = Message::where('conversation_id', $conversation->id)->orderBy('created_at')->get();

        return View::make('templates/messages')->with('messages', $messages)->render();
    }

    /**
     * Store a newly created message in storage.
     *
     * @return Response
     */
    public function send_message() {
        $isPersonalSet=Input::get('isPersonalFlag');
        $rules     = array('body' => 'required');
        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()) {
            return Response::json([
                'success' => false,
                'result' => $validator->messages()
            ]);
        }

       

        $params = array(
            'channel_id' => Input::get('channelId'),
            'body'               => Input::get('body'),
            'user_id'           => Input::get('user_id')
           
        );
        //decode team id
        $team_decoded_id = DB::table('team_channels')->where('team_channel_id', Input::get('channelId'))->first();
        /**
         * 
         * Get the id of the last inserted message
         */
		if (strpos(Input::get('body'), '<img') !== false) {
		   $lastId= DB::table('messages')->insertGetId(
                ['message' => strip_tags( Input::get('body'),'<img></img><img /><p></p><br/><br><span></span></code><code><table><td></td><tr></tr><a></a>')]
        );
		}
		else{
	       $lastId= DB::table('messages')->insertGetId(
                ['message' => strip_tags(preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', Input::get('body')),'<img></img><img /><p></p><br/><br><span></span></code><code><table><td></td><tr></tr><a></a>')]
        );}
       
   
       /**
        * if personal flag is set to true insert into personal conversations
        * 
        */
       if($isPersonalSet){
           $teamChannelId=explode("_",Input::get('channelId'));
           
           DB::table('personal_conversations')->insert(
                     ['team_channel_id' => $teamChannelId[1], 'to_user_id' => Input::get('toUserId'),'from_user_id' => Auth::user()->id,'message_id' => $lastId,'read_status'=>1]
             );
       }
       else{
            DB::table('team_conversations')->insert(
                     ['team_channel_id' => Input::get('channelId'), 'user_id' => Input::get('userId'),'message_id' => $lastId]
             );
              $this->insertIntoTeamConversationReadStatus(Input::get('channelId'),$lastId);
       }
        // Publish Data To Redis
        
        if($isPersonalSet){
            $data = array(
                'room'        => Input::get('channelId'),
                'message'  => array( 'body' => Input::get('body'),'to_channel_id'=>Auth::user()->id."_".$teamChannelId[1], 'user_id' => Auth::user()->id,'first_name'=> Session::get('firstName'),'last_name'=> Session::get('lastName'),'profile_pic'=> Session::get('profilePic'),'message_id'=>$lastId ,'to_user_id'=>Input::get('toUserId'))
            );
            Event::fire(ChatMessagesEventHandler::EVENT, array(json_encode($data)));
        }
        else{
            $data = array(
                'room'        => Input::get('channelId'),
                'message'  => array( 'body' => Input::get('body'), 'user_id' => Input::get('userId'),'first_name'=> Session::get('firstName'),'last_name'=> Session::get('lastName'),'profile_pic'=> Session::get('profilePic'),'team_encoded_id'=> Input::get('channelId'),'team_decoded_id'=> $team_decoded_id['id'],'message_id'=>$lastId)
            );
            Event::fire(ChatConversationsEventHandler::EVENT, array(json_encode($data)));

        }
        return Response::json([
            'success' => true,
            'result' => $data
        ]);
    }
    
     function insertIntoTeamConversationReadStatus($channelId,$messageId){
       
          $teamId = DB::table('team_channels')
                        ->select('id')
                        
                        ->where('team_channel_id', '=', $channelId)->first();
        $teamMembers = DB::table('users')
                        ->select('users.first_name', 'users.id', 'users.last_name')
                        ->leftJoin('team_channel_users', 'team_channel_users.user_id', '=', 'users.id')
                        ->where('team_channel_users.team_channel_name_id', '=', $teamId['id'])->get();


        foreach ($teamMembers as $memeber) {
           
         
            if ($memeber['id'] != Session::get('userId'))
                DB::table('team_conversations_read_status')->insert(
                     ['team_channel_id' => $teamId['id'], 'message_id' => $messageId,'user_id' => $memeber['id']]
             );
        }
    }
}
