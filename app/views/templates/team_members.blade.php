<div id="searchchat" >
<div class="chat-search">
                    <div class="fg-line">
                        <input type="text" class="form-control search" placeholder="Search People">
                        
                    </div>
                </div>
  
                <div class="listview list">
                     @foreach($data as $memeber=>$val)
                    @if($val['id']!=Auth::user()->id)
                    <a class="lv-item"  onclick="openChatWindow('{{$val['id']."_team_".$val['team_id']}}')">
                        <div class="media">
                            <div class="pull-left p-relative">
                                <img class="lv-img-sm" src="fusionmate/public/plugins/profile_pics/<?php echo ($val['profile_pic']=='') ?  'default_user_icon.png' : $val['profile_pic'];?>" alt="">
                              @if($val['status']['status']=="online")<i class="chat-status-online {{$val['id']}}"></i> 
                               @else<i class="chat-status-offline {{$val['id']}}"></i> 
                               @endif
                            </div>
                            <div class="media-body">
                                <div class="lv-title name username">{{$val['first_name']." ".$val['last_name']}}</div>
                                <small class="lv-small teamname">{{$val['channel_view_name']}}</small>
                            </div>
                        </div>
                    </a>
@endif
                    @endforeach
                </div>
  
  </div>
   
<!--   <script src="fusionmate/public/plugins/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="fusionmate/public/plugins/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
       

     <script>       
$(document).ready(function(){
//  alert();
var options = {
  valueNames: [ 'username']
};

var userList = new List('searchchat', options);
});

////Add blue animated border and remove with condition when focus and blur for right side bar search input
        $('body').on('focus', '.fg-line .form-control', function(){
            $(this).closest('.fg-line').addClass('fg-toggled');
        })

        $('body').on('blur', '.form-control', function(){
            var p = $(this).closest('.form-group, .input-group');
            var i = p.find('.form-control').val();

            if (p.hasClass('fg-float')) {
                if (i.length == 0) {
                    $(this).closest('.fg-line').removeClass('fg-toggled');
                }
            }
            else {
                $(this).closest('.fg-line').removeClass('fg-toggled');
            }
        });
        
</script>
