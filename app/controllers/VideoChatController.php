<?php

class VideoChatController extends AuthController {
   
   
     public function video() {
        if (Auth::user()) {

          
            return View::make('layouts/video_view');
        }

        return Redirect::route('main');
    }
}
