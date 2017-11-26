@extends('layouts/base')



<!--load user profile elements-->
@section('profile-elements')
 <?php $loggedID=Auth::user()->id; ?>
  <div class="profile-menu">
                    <a href="">
                        <div class="profile-pic">
                              <?php if($data['userDetailsArray']['profile_pic']!=""){ ?>
                            <img src="fusionmate/public/plugins/profile_pics/{{$data['userDetailsArray']['profile_pic']}}" alt="">
                              <?php } else{ ?>
                                         <img  src="fusionmate/public/plugins/images/default_user_icon.png" alt=""> 
                                         <?php }  ?>
                        </div>

                        <div class="profile-info">
                            {{$data['userDetailsArray']['first_name']." ".$data['userDetailsArray']['last_name']}}
                          

                            <i class="zmdi zmdi-caret-down"></i>
                        </div>
                    </a>

                    <ul class="main-menu">
                        <li>
                            <a href="/view_profile/<?php echo $loggedID;?>" target="_blank"><i class="zmdi zmdi-account"></i> View Profile</a>
                        </li>
                        <li>
                            <a href=""><i class="zmdi zmdi-input-antenna"></i> Privacy Settings</a>
                        </li>
                        <li>
                            <a href="/settings" target="_blank"><i class="zmdi zmdi-settings"></i> Settings</a>
                        </li>
                        <li>
                            <a href="/logout"><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </div>
@stop



@include('templates/notification_count', array('count'=>$data))



