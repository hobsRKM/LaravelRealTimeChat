@if(isset($data['create_team']))

<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h5 style="color:#fff">Team Created Successfully.<a class='btn btn-default waves-effect' data-dismiss="modal" onclick="loadTeamId(this)"  id="{{$data['teamId']}}" data-toggle="modal" data-target="#teamMember" >Add Member</a></h5>

</div>
@endif
@if(isset($message))


   <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h5 style="color:#fff" class='text-center'>{{$message}}.</h5>

</div>


@endif

@if(isset($danger))


   <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h5 style="color:#fff" class='text-center'>{{$danger}}.</h5>

</div>


@endif


@if(isset($info))


   <div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h5 class='text-center'>{{$info}}.</h5>

</div>


@endif