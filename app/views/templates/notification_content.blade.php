<?php
/*
 * Notification content for messages, global and tasks
 */

?>
@if($data['type']=="messages")
 
<div class="dropdown-menu dropdown-menu-lg pull-right">
    <div class="listview" id='messageNotification'>
        <div class="lv-header">
            Messages
        </div>
       
        <div class="lv-body">
            @foreach($data[0] as $messages)
            <a class="lv-item"  onclick="activateChatWindow('messages','<?php echo $messages['from_user_id']."_".$messages['team_id']?>',<?php echo $messages['from_user_id']?>,this,<?php echo $messages['fromCount']?>)">
                 
                <div class="media">
                    <div class="pull-left">
                        <img class="lv-img-sm" src="fusionmate/public/plugins/img/profile-pics/1.jpg" alt="">
                    </div>
                    <div class="media-body" >
                        <div class="lv-title">{{"<span style='color:#2196f3'>(".$messages['fromCount'].")</span>&nbsp;".$messages['from_first_name']." ".$messages['from_last_name']}}</div>
                        <small class="lv-small">{{$messages['message']}}</small>
                    </div>
                </div>
              
            </a>
             @endforeach
        </div>
         
        <a class="lv-footer" href="">View All</a>
    </div>
</div>

 @endif
 
 
 @if($data['type']=="general")
 
<div class="dropdown-menu dropdown-menu-lg pull-right">
    <div class="listview" id=''>
        <div class="lv-header">
            General Messages
        </div>
       
        <div class="lv-body">
            @foreach($data[0] as $generalMessages)
            <a class="lv-item" id="{{'general_'.$generalMessages['id']}}" onclick="activateChatWindow('general','<?php echo "team_".$generalMessages['id']?>','',this,<?php echo $generalMessages['messageCount']?>)">
                 
                <div class="media">
                    <div class="pull-left">
                        <!--<img class="lv-img-sm" src="fusionmate/public/plugins/img/profile-pics/1.jpg" alt="">-->
                    </div>
                    <div class="media-body" >
                       <div class="lv-title"><span style='color:#2196f3'>({{$generalMessages['messageCount']}})</span>&nbsp;New Message(s) from <span style='color:#2196f3;'>#{{$generalMessages['channel_view_name']}}</span></div>
                        <small class="lv-small"></small>
                    </div>
                </div>
              
            </a>
             @endforeach
        </div>
         
        <a class="lv-footer" href="">View All</a>
    </div>
</div>

 @endif
 
 
 
 @if($data['type']=="join")
 
<div class="dropdown-menu dropdown-menu-lg pull-right">
    <div class="listview" id=''>
        <div class="lv-header">
            New mates
        </div>
       
        <div class="lv-body">
            @foreach($data[0] as $joinees)
                @if($joinees['userCount']>0)
                    <a class="lv-item"  onclick="activateChatWindow('join','<?php echo $joinees['user_id'].'_'.$joinees['team_id']?>','<?php echo $joinees['user_id']  ?>',this,<?php echo $joinees['userCount']?>)">

                        <div class="media">
                            <div class="pull-left">
                                <!--<img class="lv-img-sm" src="fusionmate/public/plugins/img/profile-pics/1.jpg" alt="">-->
                            </div>
                            <div class="media-body" >
                               <div class="lv-title" style='    white-space: normal;
            overflow: hidden;'><span style='color:#2196f3;'>{{$joinees['first_name']." ".$joinees['last_name']}}</span> &nbsp;Joined team <span style='color:#2196f3;'>#{{$joinees['channel_view_name']}}</span></div>
                                <small class="lv-small"></small>
                            </div>
                        </div>

                    </a>
                @endif
            @endforeach
        </div>
         
        <a class="lv-footer" href="">View All</a>
    </div>
</div>

 @endif