<?php

class UserProfileController extends AuthController {
   
    public function userProfile() {
        if (Auth::user()) {

            //   $email = Auth::user()->email;
            $userDetails = DB::table('users')->select('*')->where('id', Auth::user()->id)->get();
            foreach ($userDetails as $key => $value) {
                $userDetailsArray = array();
                $userDetailsArray = $value;
            }
           // print_r($userDetailsArray);
             $data['userDetailsArray']=$userDetailsArray;
            return View::make('layouts/profile')->with("userDetailsArray", $userDetailsArray);
        }

        return Redirect::route('main');
    }

    public function viewProfile($userId) {
        if (Auth::user()) {

            //   $email = Auth::user()->email;
            $userDetails = DB::table('users')->select('*')->where('id', $userId)->get();
            foreach ($userDetails as $key => $value) {
                $userDetailsArray = array();
                $userDetailsArray = $value;
            }
            // print_r($userDetailsArray);
            // $data['userDetailsArray']=$userDetailsArray;
            return View::make('layouts/profile')->with("userDetailsArray", $userDetailsArray);
        }

        return Redirect::route('main');
    }

    public function updateProfile() {

        DB::table('users')->where('id', Auth::user()->id)->update(array(
            'summary' => Input::get('summary'), 'first_name' => Input::get('first_name'), 'birthday' => Input::get('birthday'), 'gender' => Input::get('gender')
            , 'last_name' => Input::get('last_name'), 'email' => Input::get('email'), 'contact' => Input::get('contact')
                )
        );
          return Redirect::to('/view_profile/'.Auth::user()->id);
    }

    public function updateProfilePicture() {
        $userProfile = DB::table('users')->select('profile_pic')->where('id', Auth::user()->id)->get();
        foreach ($userProfile as $key => $value) {
                $userDetailsArray = $value;
            }
            @unlink('fusionmate/public/plugins/profile_pics/'.$userDetailsArray['profile_pic']);
        
        // Build the input for our validation
        $input = array('image' => Input::file('avatar'));

        // Within the ruleset, make sure we let the validator know that this
        // file should be an image
        $rules = array(
            'image' => 'image|required'
        );
        // Now pass the input and rules into the validator
        $validator = Validator::make($input, $rules);

        // Check to see if validation fails or passes
        if ($validator->fails()) {
            // Redirect with a helpful message to inform the user that 
            // the provided file was not an adequate type
//            return Redirect::back()->withErrors(['Error: The provided file was not an image', 'Error: The provided file was not an image']);
             return Redirect::back()->withErrors($validator);
            //print_r('Error: The provided file was not an image');
            // return Redirect::to('/')->with('message', 'Error: The provided file was not an image');
        } else {
            $file = Input::file('avatar');
            
            $file->move('fusionmate/public/plugins/profile_pics', $file->getClientOriginalName());

            $imgPath = $file->getClientOriginalName();
            $imagePath = $imgPath;
            DB::table('users')->where('id', Auth::user()->id)->update(array(
                'profile_pic' => $imagePath
                    )
            );
            return Redirect::to('/view_profile/'.Auth::user()->id);
            // Actually go and store the file now, then inform 
            // the user we successfully uploaded the file they chose
            //return Redirect::to('/')->with('message', 'Success: File upload was successful');
        }
    }
    public function settings() {
        if (Auth::user()) {
            return View::make('templates/settings/password_settings');
        }

        return Redirect::route('main');
    }
    
     public function updatePassword() {
          $input = Input::all();
           $rules = array(
                       'current_password' => 'required',

             'password' => 'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{1,}$/',
        'password_confirm' => 'required|same:password'
        );
           
        // Now pass the input and rules into the validator
        $validator = Validator::make($input, $rules);
        // Check to see if validation fails or passes
        if ($validator->fails()) {
         
             return Redirect::back()->withErrors($validator);
        } else {
         $password=  Hash::make(Input::get('new_password'));
        DB::table('users')->where('id', Auth::user()->id)->update(array(
                'password' => $password
                    )
            );
        }
          return Redirect::to('/settings/');
    }
    
    function deactivateAccount(){
         if (Auth::user()) {            
        $loggedInUser=Auth::user()->id;
        $userProfile = DB::table('users')->select('profile_pic')->where('id', Auth::user()->id)->get();
        foreach ($userProfile as $key => $value) {
                $userDetailsArray = $value;
            }
        @unlink('fusionmate/public/plugins/profile_pics/'.$userDetailsArray['profile_pic']);
        DB::table('team_channel_users')->where('user_id', '=', $loggedInUser)->delete();
        DB::table('team_conversations')->where('user_id', '=', $loggedInUser)->delete();
        DB::table('team_conversations_read_status')->where('user_id', '=', $loggedInUser)->delete();
        DB::table('team_heads')->where('user_id', '=', $loggedInUser)->delete();
        DB::table('login_status')->where('user_id', '=', $loggedInUser)->delete();
        DB::table('user_roles')->where('user_id', '=', $loggedInUser)->delete();
        $affected = DB::table('users')->where('id', '=', $loggedInUser)->delete();
//        @unlink('fusionmate/public/plugins/userUploads/' . $userDetailsArray['profile_pic']);
            return Redirect::route('main');
         }
                 

             
    }
}
