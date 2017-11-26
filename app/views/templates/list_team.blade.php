<style>
    table > tbody > tr > td {
        font-size:12px !important;
    }
    td > span{
        cursor:pointer;
    }
    button {
        font-size:12px !important;
    }
    span.glyphicon.glyphicon-user {
    color: #ccc !important;
    font-size: 14px !important;
    line-height: 1em !important;
}
    
</style>





@if(count($teams)==0)
<h6 class="text-center">You have no teams created.<a data-toggle="modal" data-target="#createTeam">Create one now!</a></h6>
{{exit}}
@endif
<div class="col-md-12">
    <h6 class="text-center col-md-10" ><b>Teams list</b></h6>
<a href="#" data-toggle="modal" data-target="#createTeam" class="btn btn-default btn-sm pull-right col-md-2">
          <span  class="glyphicon glyphicon-plus"></span> Team 
</a>
</div>


<table class="table table-hover">
    <tbody>
       @foreach($teams as $team)
       <tr>
           <td class="col-md-4">{{$team['channel_view_name']}}</td>
           <td class="col-md-1"><a href="#"><span onclick="loadTeamId(this)"  id="{{$team['id']}}" data-toggle="modal" data-target="#teamMember" class="glyphicon glyphicon-user"></span></a></td>
           <td class="col-md-1"><a><span  id="{{$team['id']}}"  class="glyphicon glyphicon-remove"></span></td>
       </tr>
       @endforeach
    </tbody>
</table>

