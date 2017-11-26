<?php

class MainController extends \BaseController {

    public function welcome() {
        if (Auth::check()) {
            // The user is logged in...
            
            return Redirect::route('home');
        }
        
        $roles = DB::table('roles')->where('id', '<=', 2)->get();

        return View::make('templates/welcome')->with('roles', $roles);
    }

   

}


