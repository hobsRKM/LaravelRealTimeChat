<?php
/*
 * Notifications count for messages, global, and tasks
 * 
 */
?>
@section('message-notifications-count')
<a data-toggle="dropdown" href="">
    <i class="tm-icon zmdi zmdi-email"></i>
    @if($count['unreadMessageCount']>0)
    <i class="tmn-counts" id='unreadCount'>{{$count['unreadMessageCount']}}</i>
    @else
   <i  id='unreadCount'></i>
   @endif
</a>
@stop


@section('general-notifications-count')
<a data-toggle="dropdown" href="">
    <i class="tm-icon zmdi zmdi-comments"></i>
    @if($count['unreadGeneralMessageCount']>0)
    <i class="tmn-counts" id='unreadGeneralCount'>{{$count['unreadGeneralMessageCount']}}</i>
    @else
   <i  id='unreadGeneralCount'></i>
   @endif
</a>
@stop


@section('join-notifications-count')
<a data-toggle="dropdown" href="">
    <i class="tm-icon zmdi zmdi-accounts"></i>
    @if($count['unreadJoinMessageCount']>0)
    <i class="tmn-counts" id='unreadJoinCount'>{{$count['unreadJoinMessageCount']}}</i>
    @else
   <i  id='unreadJoinCount'></i>
   @endif
</a>
@stop