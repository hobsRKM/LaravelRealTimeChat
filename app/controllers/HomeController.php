<?php

class HomeController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |    Route::get('/', 'HomeController@showWelcome');
    |
     */

    public function showWelcome()
    {
        
         if (Auth::user()) {

            //   $email = Auth::user()->email;
            $userDetails = DB::table('users')->select('*')->where('id', Auth::user()->id)->get();
            foreach ($userDetails as $key => $value) {
                $userDetailsArray = array();
                $userDetailsArray = $value;
            }
           // print_r($userDetailsArray);
           
//             $data['userDetailsArray']=$userDetailsArray;
           
        }
        /*
         * get notofications,task notifications,global notifications ...
         */
         $countUnreadMessages = DB::table('personal_conversations')
                ->select(DB::raw('count(read_status) as unread_count'))
                
                ->where('read_status','=',1)
                 ->where('to_user_id','=',Auth::user()->id)->first();
         
          $countUnreadGeneralMessages = DB::table('team_conversations_read_status')
                ->select(DB::raw('count(read_status) as unread_count'))
                
                ->where('read_status','=',1)
                 ->where('user_id','=',Auth::user()->id)->first();
          
          $countUnreadJoinMessages = DB::table('invitation_notification')
                ->select(DB::raw('count(read_status) as unread_count'))
                
                ->where('read_status','=',1)
                   
                     ->where('invitation_notification.new_user', '!=', Auth::user()->id)
                 ->where('team_user','=',Auth::user()->id)->first();
         /*
          * pass each notifcation count in array
          */
        
         $data=array(
             
                            "unreadMessageCount"=>$countUnreadMessages["unread_count"],
                            "userDetailsArray"=>$userDetailsArray,
                            "unreadGeneralMessageCount"=>$countUnreadGeneralMessages["unread_count"],
                            "unreadJoinMessageCount"=>$countUnreadJoinMessages["unread_count"],
                           
                    );
        return View::make('templates/home')->with("data",$data);
    }

}
