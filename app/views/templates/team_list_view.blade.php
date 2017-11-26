
<div id='teamList' class="card hidden lv-body mCustomScrollbar   " style='height:580px;' data-mcs-theme="dark-2" >
    <div class="listview lv-bordered lv-lg">
        <div class="lv-header-alt clearfix">
            <h2 class="lvh-label hidden-xs">Teams</h2>

            <div class="lvh-search">
                <input type="text" id="teamSearch" placeholder="Search for team name or date of creation...." class="lvhs-input search">

                <i class="lvh-search-close">&times;</i>
            </div>

            <ul class="lv-actions actions">
                <li data-toggle="tooltip" data-placement="bottom" title="Search Team">
                    <a href="" class="lvh-search-trigger">
                        <i class="zmdi zmdi-search"></i>
                    </a>
                </li>
                @if(Session::get('role')==1)
                <li data-toggle="tooltip" data-placement="left" title="Create Team">
                    <a  data-toggle="modal" data-target="#createTeam">
                        <i  class="zmdi zmdi-plus-circle"></i>
                    </a>
                </li>
                @endif
                <li data-toggle="tooltip" data-placement="left" title="Close Window">
                    <a  onclick="showWindow()">
                        <i  class="zmdi zmdi-close-circle-o"></i>
                    </a>
                </li>
                <li class="dropdown" style="display: none;">
                    <a href="" data-toggle="dropdown" aria-expanded="true">
                        <i class="zmdi zmdi-sort"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a href="">Last Modified</a>
                        </li>
                        <li>
                            <a href="">Last Edited</a>
                        </li>
                        <li>
                            <a href="">Name</a>
                        </li>
                        <li>
                            <a href="">Date</a>
                        </li>
                    </ul>
                </li>
                <li style="display: none;">
                    <a href="">
                        <i class="zmdi zmdi-info"></i>
                    </a>
                </li>
                <li class="dropdown" style="display: none;">
                    <a href="" data-toggle="dropdown" aria-expanded="true">
                        <i class="zmdi zmdi-more-vert"></i>
                    </a>

                </li>
            </ul>
        </div>

        <div id="teamListBody" class="lv-body mCustomScrollbar " style='height:450px;' data-mcs-theme="dark-2">
            @if(count($teams)==0 )

<div class="lv-item media">
                <div class="checkbox pull-left">
                    <label>
                        <input type="checkbox" value="">
                        <i class="input-helper"></i>
                    </label>
                </div>
                <div class="media-body">
                    <div class="lv-title">You have no teams created.<a data-toggle="modal" data-target="#createTeam">Create one now!</a></div>
                    
                </div>
            </div>
@endif
            @foreach($teams as $team)
            <div class="lv-item media" id="{{$team['id']}}_team">
                <div class="checkbox pull-left">
                    <label>
                        <input type="checkbox" value="">
                        <i class="input-helper"></i>
                    </label>
                </div>
                <div class="media-body">
                    <div class="lv-title name">{{$team['channel_view_name']}}</div>
                     <ul class="lv-attrs">
                                            <li>{{toDateTime($team['created_at'])}}</li>
                                            
                                            <li data-toggle="modal" href="#modalWider" onclick="getTeamMembers('{{$team['id']}}')" >View Members</li>
                                           @if((Session::get('role')==1 && $team['author_id']== Auth::user()->id) || $team['team_head_id']==Auth::user()->id )
                                            <li data-toggle="modal" onclick="loadTeamId(this)"  id="{{$team['id']}}" data-toggle="modal" data-target="#teamMember"  >Add Members</li>
                                            @endif
                     </ul>
                     @if($team['author_id']== Auth::user()->id)
                        <div class="lv-actions actions dropdown" data-toggle="tooltip" data-placement="left" title="Preferences">
                            <a href="" data-toggle="dropdown" aria-expanded="true">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right">
                                 <li>

                                        <a data-toggle="modal" data-target="#teamSettings" onclick="teamPreferences('{{$team['team_channel_id']."_".$team['id']}}')"  >Preferences</a>

                                </li>
                            </ul>
                        </div>
                      @endif
                </div>
            </div>
            @endforeach

            
            </div>
        </div>
    </div>


</div>
<!--
team members modal

-->
<div class="modal fade" id="modalWider" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Members</h4>
            </div>
            <div class="modal-body" id="members" >
            
                     
                        
                        
                        
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--
add team members modal
-->
<div id="teamMember" class="modal fade" role="dialog">
  <div class=" modal-dialog ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header-info modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title custom-modal-header-font">Invite  members.</h4>
      </div>
      <div class="modal-body " id='createNewMember'>
          <blockquote  class="m-b-25">
                                <p>An email will be  sent for each of the user added.Enter a valid email address.The user has to visit the link and create an password before joining .</p>
                            </blockquote>
          <span id='emailStatus'></span>
          <table class="table">
              <form>
                                <tbody id='newMember'>
                                    <tr>
                                        <td>  <div class="input-group fg-float ">
                                        <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                                        <div class="fg-line">
                                            
      <input id="teamMemberEmail" name="emails[]" required class='form-control modalInputCustomHeight' type='text'  name='team' />
                                            <label class="fg-label" >Member Email</label>
                                        </div>
                                    </div></td>
                                        <td>
                                    <a href='#' onclick='addMoreMember()'  data-toggle="tooltip" data-placement="bottom" title="Add Member" >
                        <i class="zmdi zmdi-account-add glyphiconCustom"></i>
                    </a></td>
                                        
                                    </tr>
                                  
                                </tbody>
              </form>
                            </table>
    
      </div>
      <div class="modal-footer">
        <button onclick="createTeamMember()" type="button" class="btn btn-success waves-effect" >Create</button>
      </div>
    </div>

  </div>
</div>
<!--Create team modal-->
<div id="createTeam" class="modal fade" role="dialog">
  <div class=" modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header-info modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title custom-modal-header-font">Create Team</h4>
      </div>
      <div class="modal-body createTeamBodyCustomHeight">
          <blockquote  class="m-b-25">
                                <p>You can create team and add members to it.If you choose to add members later you can do so,but teams without member will not be shown on chat menu unless and until you add atleast one member.
                                To add members to a team you can go to quick settings and select "All Teams".</p>
                            </blockquote>
      
       <div class="input-group fg-float">
                                        <span class="input-group-addon"><i class="zmdi zmdi- collection-bookmark"></i></span>
                                        <div class="fg-line">
                                            
                                            <input class='form-control modalInputCustomHeight'  id="teamName" type='text' placeholder="Enter team name" name='team' />
                                            <label class="fg-label" >Your Team Name</label>
                                        </div>
                                    </div>
          <p id='customCreateTeamMessage' class='text-center'></p>
      </div>
      <div class="modal-footer">
          
        <button onclick="createTeam()" type="button" class="btn btn-success waves-effect" >Create</button>
      </div>
    </div>

  </div>
</div>
<!--
 Include team settings modal

-->
@include('templates/team/team_settings')
 <script src="fusionmate/public/plugins/vendors/bootgrid/jquery.bootgrid.updated.min.js"></script>
<script src="fusionmate/public/plugins/js/jquery.quicksearch.js"></script> 

<script>
$(document).ready(function(){
    $('.chosen-single').css("height","46");
    $('input#teamSearch').quicksearch('.media');
    $('[data-toggle="tooltip"]').tooltip();  
});

</script>
<script>


   if ($('.lvh-search-trigger')[0]) {


        $('body').on('click', '.lvh-search-trigger', function(e){
            e.preventDefault();
            x = $(this).closest('.lv-header-alt').find('.lvh-search');

            x.fadeIn(300);
            x.find('.lvhs-input').focus();
        });

        //Close Search
        $('body').on('click', '.lvh-search-close', function(){
            x.fadeOut(300);
            setTimeout(function(){
                x.find('.lvhs-input').val('');
            }, 350);
        })
    }

function basicDataTable(){
     $("#data-table-basic").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
   formatters: {
        "status": function(column, row)
        {
            
            return "<span class='"+row.status+"'></span>&nbsp;"+row.status ;
        },
       "username": function(column, row)
        {
            
            return "<a onclick=\"openChatWindow("+row.id+")\">"+row.username+"</a>";
        }
    }
    
                });
}
            $(document).ready(function(){
                $(".actionBar").children().addClass("col-sm-6 customGridActionBar");
                //Basic Example
               
                
                //Selection
                $("#data-table-selection").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<button type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> " + 
                                "<button type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";
                        }
                    }
                });
            });
            
</script>