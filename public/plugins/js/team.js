




function loadTeams(isTeamCreatedTrue) {

        $.ajax({
                url: "/get_teams",
                type: "POST",
                dataType: "HTML",
                data: {channelId: channelId},
        }).done(function (data) {
                // $("#teams").empty();
                $("#teamList").remove();
                $("#container").append(data);
                if (isTeamCreatedTrue) {
                        chatOrTeamListWindowFlag = 0;
                        showWindow();
                }
                $("#teamListBody").mCustomScrollbar({
                        autoHideScrollbar: true
                });
        });
}
function getTeamMembers(teamId) {
        $.ajax({
                url: "/get_team_members",
                type: "POST",
                dataType: "html",
                data: {teamId: teamId},
        }).done(function (data) {
                $("#members").empty();
                $("#members").append(data);
                basicDataTable();
        });
}
function showAllTeamsMembers() {
        if (showChatBar == 0) {
                $.ajax({
                        url: "/list_teams_memebers",
                        type: "GET",
                        dataType: "HTML",
                        data: {teamId: teamId}
                }).done(function (data) {
                        showChatBar = 1;
                        $("#chat").empty();
                        $("#chat").append(data);
                });
        }
        showChatBar = 0;
}
function deleteTeam(teamId) {
        $.ajax({
                url: "/delete_team",
                type: "POST",
                dataType: "html",
                data: {teamId: settingsTeamId},
        }).done(function (data) {
                $("#" + teamId + "_team").remove();
                 $('#teamSettings').modal("hide");
                 loadTeams(1);
        });
}

function switchTab(id) {
        if (id == "teamLink") {
                $("#restrictedLink").removeClass("active");
                $("#" + id).addClass("active");
                $("#restrictedAccounts").hide();
                $("#teams").show();
                loadTeams();
//        $('#loading').html('<img clas="text-center" style="display:block;margin-left: auto;margin-right: auto;" src="http://preloaders.net/preloaders/287/Filling%20broken%20ring.gif">');

        }
        if (id == "restrictedLink") {
                $("#teamLink").removeClass("active");
                $("#" + id).addClass("active");
                $("#teams").hide();
                $("#restrictedAccounts").show();
        }

}

function createTeam()
{


        $.ajax({
                url: "/create_team",
                type: "POST",
                dataType: "html",
                data: {name: $("#teamName").val()},
        }).done(function (data) {
                $("#customCreateTeamMessage").empty();
                $("#customCreateTeamMessage").append(data);
                loadTeams(1);
        });
}
function createTeamMember()
{
        $('#createNewMember').block({
               message: '<img src="fusionmate/public/plugins/images/newloader.gif"/><br/><center>Processing....</center>',
        css: { width: '0%', border:'0px solid #FFFFFF',cursor:'wait',backgroundColor:'#FFFFFF'},
        overlayCSS:  { backgroundColor: '#000',opacity:0.0,cursor:'wait'} 
        });
        var emails = [];
        $("#newMember :input").each(function () {
                var input = $(this).val();
                emails.push(input);
        });
        $.ajax({
                url: "/create_team_member",
                type: "POST",
                dataType: "TEXT",
                data: {email: emails, teamId: teamId},
        }).done(function (data) {
                $("#emailStatus").empty();
                $("#emailStatus").append(data);
                $('#createNewMember').unblock();
        });
}

function showWindow() {

        if (dashboardWindowFlag == 1) {
                $("#dashboardTab").remove();
                $("body").css("background-color", "#edecec");
        }
        if (chatOrTeamListWindowFlag == 0) {
                $("#teamList").removeClass("hidden");
                $("#messageMain").hide();
                chatOrTeamListWindowFlag = 1;
        } else {

                $("#teamList").addClass("hidden");
                $("#messageMain").show();
                chatOrTeamListWindowFlag = 0;
        }


}

function loadTeamId(thisEle) {
        teamId = $(thisEle).attr("id");
        $("#teamName").val('');
        $("#customCreateTeamMessage").empty();
        $("#createTeam").modal('hide');
}
function scrollToBottom() {

        $("#messageWindow").mCustomScrollbar();
        $("#messageWindow").mCustomScrollbar("scrollTo", "bottom");
}
function removeMemberInput(id) {
        $("#" + id + "newMember").remove();
}
function addMoreMember() {
        var html;
        addCount += addCount + 1;
        html = "<tr id='" + addCount + "newMember'>";
        html += ' <td>  <div class="input-group fg-float ">';
        html += '<span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>';
        html += '<div class="fg-line">';
        html += '<input id="teamMemberEmail" name="emails[]" class="form-control modalInputCustomHeight" type="text" name="team">';
        html += '                                <label class="fg-label">Member Email</label>';
        html += '                      </div>';
        html += '                 </div></td>';
        html += '                    <td>';
        html += '                <a href="#" onclick="removeMemberInput(' + addCount + ')">';
        html += '    <i class="zmdi zmdi-close-circle glyphiconCustom"></i>';
        html += ' </a></td>';
        html += '                 </tr>';
        $("#newMember").append(html);
}

function updateTimeZone(tzName) {
        $.ajax({
                url: "/update_timezone",
                type: "POST",
                dataType: "TEXT",
                async: false,
                data: {tz: tzName},
        }).done(function (data) {

                loadTeams(); //call next ajax for loading




        });
}

function teamPreferences(teamId){
    var data=teamId.split("_");
    $('#teamSettings').modal("show");
    settingsTeamId='';
    settingsTeamId=data[0];
    settingsTeamIdDecoded=data[1];
      $("#settingsTeamName").focus();
      $.ajax({
                url: "/task/get_members",
                type: "POST",
                dataType: "html",
                data: {teamId: settingsTeamId},
        }).done(function (data) {

            $("#teamSettingsUsers").empty();
            $("#settingsTeamName").empty();
            $("#settingsTeamName").append();
            $("#teamSettingsUsers").append(data);
            $('#teamSettingsUsers').trigger("chosen:updated");




        });
        
        
        $.ajax({
                url: "/get_team_name",
                type: "POST",
                dataType: "text",
                data: {teamId: settingsTeamId},
        }).done(function (data) {
            var teamData=data.split("_");
            $("#settingsTeamName").empty();
            $("#settingsTeamName").val(teamData[0]);
              $("#settingsTeamName").focus();
            $("#teamHeadName").empty();
             $("#teamHeadName").append(teamData[1]);
            $("#teamHeadInfo").empty();
              $("#teamHeadInfo").append(teamData[0]);
            
          
        });
}

function updateTeamName(){
     $.ajax({
                url: "/update_team_name",
                type: "POST",
                dataType: "text",
                data: {teamId: settingsTeamId,name:$("#settingsTeamName").val()},
        }).done(function (data) {
           if(data=="true" && data!="exists"){
               $("#settingsNameSuccess").empty();
               $("#settingsNameError").empty();
               $("#settingsNameSuccess").append("Team name updated successfully");
               $("#"+"team_name_"+settingsTeamIdDecoded).empty();
                $("#team_name_"+settingsTeamIdDecoded).append('<i class="zmdi zmdi-view-compact "></i>'+$("#settingsTeamName").val());
               loadTeams(1);
        }
        if( data=="exists"){
                $("#settingsNameSuccess").empty();
               $("#settingsNameError").empty();
               $("#settingsNameError").append("Team name already in use");
        }
         if( data=="empty"){
            $("#settingsNameSuccess").empty();
               $("#settingsNameError").empty();
               $("#settingsNameError").append("Team name is required");
        }
        setTimeout(function () {
            $("#settingsNameSuccess").empty();
            $("#settingsNameError").empty();
    }, 4000);
        });
}

function assignTeamHead(){
    $.ajax({
                url: "/update_team_head",
                type: "POST",
                dataType: "text",
                data: {teamId: settingsTeamId,userId:$("#teamSettingsUsers").val()},
        }).done(function (data) {
           if(data=="true"){
               $("#settingsHeadSuccess").empty();
               $("#settingsHeadError").empty();
               $("#settingsHeadSuccess").append("Team head updated successfully");
               loadTeams(1);
        }
         if( data=="empty"){
            $("#settingsNameSuccess").empty();
               $("#settingsHeadError").empty();
               $("#settingsHeadError").append("Team name is required");
        }
        setTimeout(function () {
            $("#settingsHeadSuccess").empty();
            $("#settingsHeadError").empty();
    }, 4000);
        });
}

function closeSettings(){
    $('#teamSettings').modal("hide");
}
$(document).ready(function () {

//This will execute whenever the window maxmimize button is clicked

        $(window).bind('resize', function () {

                $("#messageWindow").css("height", $(window).height() - 335);
        });
        $(window).resize(function () {
                // This will execute whenever the window is resized

                $("#messageWindow").css("height", $(window).height() - 265);
        });
//This will execute whenever page is loaded

        var tz = jstz.determine();
        var tzName = tz.name();
        updateTimeZone(tzName);
//initialize walkthorugh
        // Set up tour
        name: 'introduction',
                $('body').pagewalkthrough({
                name: 'introduction',
                steps: [{
                                wrapper: 'body',
                                popup: {
                                        content: 'Welcome to fusionmate.To Get started click next.',
                                        type: 'modal',
                                        position: 'top'
                                }
                        }, {
                                wrapper: '#messageNotificationContainer',
                                popup: {
                                        content: 'Access Unread Messages here',
                                        position: 'left'
                                }
                        }, {
                                wrapper: '#main  .profile-info  ',
                                popup: {
                                        content: 'Expand to acceses profile settings.',
                                        type: 'tooltip',
                                        position: 'right'

                                }
                        }, {
                                wrapper: '#dashboard',
                                popup: {
                                        content: 'Here you can view your dashboard for features such as task and event management',
                                        type: 'tooltip',
                                        position: 'right'
                                }
                        }, {
                                wrapper: '#team',
                                popup: {
                                        content: 'Teams and its members will be listed here.You can select any member to collaborate privately.',
                                        type: 'tooltip',
                                        position: 'right'
                                }
                        }, {
                                wrapper: '#quickSettings',
                                popup: {
                                        content: 'You can access quick menu to list down all teams .',
                                        type: 'tooltip',
                                        position: 'left'
                                }
                        }],
        });
// $('body').pagewalkthrough('show');
        // Show the tour
        // loadTeams();

//          $("div").removeClass(".mCS-autoHide");
        $(window).focus(function () {
                // tab is being activated
                if (browserTabActiveFlag == 1) {
                        browserTabActiveFlag = 0;
                }
        });
        $(window).blur(function () {
                // tab looses control
                browserTabActiveFlag = 1;
        });
        ;
window.onload = function () {
        scrollToBottom();
}

});


