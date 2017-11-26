<?php

class NotificationController extends BaseController {

    public function unread_notifications() {
        $type = Input::get('data'); //type to indicate whether global,task or message notification
        /*
         * get notofications,task notifications,global notifications contents ...
         */
        if ($type == "messages") {
            $unReadMessages = DB::table('messages')
                            ->select(DB::raw('count(from_user_id) as fromCount'), 'personal_conversations.*','team_channels.id as team_id', 'messages.*', 'users_from.first_name as from_first_name', 'users_from.first_name as from_last_name')
                            ->leftJoin('personal_conversations', 'messages.id', '=', 'personal_conversations.message_id')
                               ->leftJoin('team_channels', 'team_channels.id', '=', 'personal_conversations.team_channel_id')
                            ->leftJoin('users as users_from', 'users_from.id', '=', 'personal_conversations.from_user_id')
                            ->where('personal_conversations.read_status', '=', 1)
                            ->where('personal_conversations.to_user_id', '=', Auth::user()->id)->groupBy('from_user_id')->orderBy('messages.id', 'desc')->get();
            $unReadMessages = array_reverse($unReadMessages);

            $data = array($unReadMessages, "type" => $type);
        }

        if ($type == "general") {
            $unReadGeneralMessages = DB::table('team_conversations_read_status')
                            ->select(DB::raw('count(team_conversations_read_status.message_id) as messageCount'), 'team_channels.channel_view_name', 'team_channels.id')
                            ->leftJoin('team_channels', 'team_channels.id', '=', 'team_conversations_read_status.team_channel_id')
                            ->where('team_conversations_read_status.user_id', '=', Auth::user()->id)
                    ->where('team_conversations_read_status.read_status', '=', 1)
                    ->groupBy('team_channels.channel_view_name')->orderBy('team_conversations_read_status.message_id', 'desc')->get();
            $unReadGeneralMessages = array_reverse($unReadGeneralMessages);

            $data = array($unReadGeneralMessages, "type" => $type);
        }
        
        if ($type == "join") {
            $unReadJoinMessages = DB::table('invitation_notification')
                            ->select(DB::raw('count(invitation_notification.new_user) as userCount'), 'team_channels.channel_view_name', 'team_channels.team_channel_id', 'users.first_name', 'users.last_name', 'users.id as user_id', 'team_channels.id as team_id')
                            ->leftJoin('team_channels', 'team_channels.id', '=', 'invitation_notification.team_id')
                            ->leftJoin('users', 'users.id', '=', 'invitation_notification.new_user')
                            ->where('invitation_notification.team_user', '=', Auth::user()->id)
                             ->where('invitation_notification.new_user', '!=', Auth::user()->id)
                            ->where('invitation_notification.read_status', '=', 1)
                            ->groupBy('invitation_notification.new_user')
                            ->orderBy('invitation_notification.created_at', 'desc')->get();
            $unReadJoinMessages = array_reverse($unReadJoinMessages);

            $data = array($unReadJoinMessages, "type" => $type);
        }

        return View::make('templates/notification_content')->with("data", $data);
    }

    public function update_status() {
        $type = Input::get('data'); //type to indicate whether global,task or message notification

        switch ($type) {
            case "messages" : $fromUserId = Input::get('fromUserId');
                $toUserId = Input::get('toUserId');
                if ($type == "messages") {
                    DB::table('personal_conversations')
                            ->where('from_user_id', $fromUserId)
                            ->where('to_user_id', $toUserId)
                            ->update(array('read_status' => 0));
                }
                break;
            case "general":
                $teamId = explode("_",Input::get('teamId'));
                
                DB::table('team_conversations_read_status')
                        ->where('user_id', Auth::user()->id)
                        ->where('team_channel_id', $teamId[1])
                        ->update(array('read_status' => 0));
                break;
            
                case "join":
                $teamId = explode("_",Input::get('teamId'));
                
                DB::table('invitation_notification')
                        ->where('team_user', Auth::user()->id)
                        ->where('team_id', $teamId[1])
                        ->where('new_user', $teamId[0])
                        ->update(array('read_status' => 0));
        }
    }

}
