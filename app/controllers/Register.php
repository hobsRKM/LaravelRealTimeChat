<?php

class Register extends \BaseController {

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
            'password' => 'required|min:4',
            'role' => 'required'
        );

        $validator = Validator::make($input, $rules);
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
            return View::make('templates/greeting')->with('message', "Account created successfully.You can now log in.Have a great day!");
      
    }

   

}

