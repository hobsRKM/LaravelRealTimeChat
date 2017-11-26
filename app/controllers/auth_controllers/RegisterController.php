<?php

class RegisterController extends \BaseController {

    public function registerUser() {
        
         $input = Input::only(array(
             'firstName',
             'lastName',
            'email',
            'password',
             'role'
        ));

         
        $rules = array(
            'firstName'    => 'required|min:4',
            'lastName' => 'required|min:4',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{1,}$/',
            'role' => 'required'
        );
 $messages = array(
            'password.regex' => 'The password must containt atleast 1 Upper Case letters[A-Z],1 Lower Case Letter[a-z],1 numeric letter [0-9] and 1 special character.',
           
        );
        $validator = Validator::make($input, $rules,$messages);
 $messages = $validator->messages();
        if($validator->fails()) {
          
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(), 
                400
                )); // 400 being the HTTP code for an invalid request. 
        }
       
        $id = DB::table('users')->insertGetId(
                ['first_name' => Input::get('firstName'),'last_name' => Input::get('lastName'),'email' => Input::get('email'), 'password' => Hash::make(Input::get('password'))]
        );
        DB::table('user_roles')->insert(
                ['user_id' => $id, 'role_id' => Input::get('role')]
        );
      $channelId=  Hash::make(Input::get('password'));
       DB::table('channels')->insert(
                ['channel_name' => $channelId, 'author_id' => $id]
        );
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')),true)) {

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
                        'success' => "ok"
                            ), 200);
           
        }
              return Response::json(array(
                        'success' => "notok"
                            ), 400);
      
    }

   

}

