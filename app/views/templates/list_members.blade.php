
<div class="table-responsive">
    <table id="data-table-basic" class="table table-striped">
        <thead>
            <tr>
                <th data-column-id="id" data-type="numeric">ID</th>
                <th data-column-id="status" data-formatter="status">Status</th>
                <th data-column-id="username" data-formatter="username" >Username</th>
            </tr>
        </thead>
        <tbody >
            @foreach($members as $member)
            <?php $memberDetails = explode("_", $member); ?>
            <tr>
                <td>{{$memberDetails[2]}}</td>
                @if($memberDetails[3]=="online")
                    <td >{{$memberDetails[3]}}</td>
                @else
                   <td>{{$memberDetails[3]}}</td>
                @endif
                <td>{{$memberDetails[0]." ".$memberDetails[1]}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

