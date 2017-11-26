<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * stores user local timezone in session
 * 
 */

function storeUserTimeZone($tzName) {
    Session::put('tzName', $tzName);
}

/**
 * 
 * @return fomratedDateTime 
 * @param string $timeStamp Timestamp from db
 * 
 */
function toDateTime($timesTamp) {
    
    $tzName = Session::get('tzName');
  
    $tz = new DateTimeZone(trim($tzName));
   
    $date = new DateTime($timesTamp);
     $date->setTimezone($tz);
    $dateTime=$date->format('F jS, Y h:i:s A');
    return $dateTime;
   
   
    
}


/**

 * @function generates a unique ID
 * @return string unique id
 */

function generateId(){
    $date = date_create();
    $id=md5(date_timestamp_get($date));
    return $id;
    
}