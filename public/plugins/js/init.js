$(function () {

    /***
     Initialization
     ***/
    PNotify.desktop.permission();
    scrollToBottom();
    /** 
     * Get each of team names,ids and their team members.
     * Split team array index to get team name and id
     * @type type
     */

    var socket = io.connect(socket_url, {
        secure: true
    });

    socket.on('connect', function () {
var sessionid = socket.io.engine.id;

        updateLoginStatus("online");
        if (socketDisconnectFlag == 1) {
            notifylabel('Connectivity restored...', 'success');
            socketDisconnectFlag = 0;
        }

    });

    socket.on('disconnect', function () {
        updateLoginStatus("offline");
        notifylabel('You have lost connectivity! trying to reconnect', 'danger');
        socketDisconnectFlag = 1;

    });

    jqxhr = $.ajax({
        url: 'list_teams',
        type: 'GET',
        cache: false,
        dataType: 'json'
    });

    jqxhr.done(function (data) {
        for (var result in data) {
            var membArr = [];
            var channelIds = [];
            var userIds = [];
            var mainChannelId;
            for (var members in data[result]) {
                var teamNameAndId = result.toString().split("_");
                mainChannelId = teamNameAndId[1];
                var teamName = teamNameAndId[0];
                var teamGeneralId = teamNameAndId[2];
                var userDetails = data[result][members].toString().split("_");
                var userName = userDetails[0];
                var userId = userDetails[1];
                var status = userDetails[2];
                var userChannelId = userId + "_" + mainChannelId;

                socket.emit('join', {
                    room: userChannelId
                });
                membArr.push(userName + "_" + status);
                userIds.push(userId);
                channelIds.push(userChannelId);

            }

            socket.emit('join', {
                room: mainChannelId
            });
            preapreSideBar(membArr, channelIds, teamName, userIds, mainChannelId, teamGeneralId);
        }
        /*
         * 
         * On page load make first group as active and get conversations
         */
        getConversations(activeSidbarTeamMenuId);
    });

    /***
     Socket.io Events
     ***/

    //    socket.on('welcome', function (data) {
    //          console.log(data.message);
    //
    //          socket.emit('join', { room:  user_id });
    //           socket.emit("typing", true);
    //      });

    socket.on('joined', function (data) {
        console.log(data.message);
    });
    socket.on('typing', function (data) {
      
     
        $('.typing-loader').hide();
        if (activeChannelId==data.message)
             $('.typing-loader').show();
    });
    socket.on('chat.messages', function (data) {

        updateLoginStatus("online");
        appendNotifications(data, "personal");
        /**
         * append message to message window too
         */
        appendNewIncomingMessage(data, false);//set true for personal conversation else false 

    });

    socket.on('chat.conversations', function (data) {
       
        updateLoginStatus("online");
        appendNotifications(data, "general");
        appendNewIncomingMessage(data, true);

    });
    
    socket.on('invite.status', function (data) {

        appendNotifications(data, "join");
        

    });
    
    socket.on('chat.status', function (data) {
       
        var fromUserId = data.message.user_id;
        var status = data.message.status;
        if (status == "online") {
            $("." + fromUserId).removeClass("offline");
            $("." + fromUserId).addClass("online");
//             $("i." + fromUserId).removeClass("chat-status-offline");
//             $("i." + fromUserId).addClass("chat-status-online");

        } else {
            //   $("i." + fromUserId).removeClass("chat-status-online");
            $("." + fromUserId).removeClass("online");
            $("." + fromUserId).addClass("offline");
            // $("i." + fromUserId).addClass("chat-status-offline");

        }

        if (fromUserId != userId)
            showAllTeamsMembers();//reload right side bar on any activity of online or online activities
    });
    /***
     Functions
     ***/

    /*
     * 
     * @param {type} data
     * @returns {undefined}
     * 
     * for append notifications and append messages ,do not append the norification and message on sender side 
     * check a condition of userid with the data userid which shoould not be equal
     */
    function appendNotifications(data, type) {


        if (type=="personal") {
            if ( data.message.to_channel_id!=activeChannelId && data.message.to_user_id==userId) {

                /*
                 * append to message notifications counter if window is not active 
                 */

                var unreadCount = $("#unreadCount").text();
                if (unreadCount == '') {
                    unreadCount = 0;
                    $("#unreadCount").addClass("tmn-counts");
                }
                $("#unreadCount").text(parseInt(unreadCount) + 1);




            }
        }
        if (type=="general") {

            if (data.message.team_encoded_id != activeMessageWindowId && data.message.user_id != userId) {
                var unreadGeneralCount = $("#unreadGeneralCount").text();

                if (unreadGeneralCount == '') {
                    unreadGeneralCount = 0;
                    $("#unreadGeneralCount").addClass("tmn-counts");
                }
                $("#unreadGeneralCount").text(parseInt(unreadGeneralCount) + 1);

            }

        }
        
         if (type=="join") {

                if(data.message.user_id==userId){
                
                
                var unreadJoinCount = $("#unreadJoinCount").text();

                if (unreadJoinCount == '') {
                    unreadJoinCount = 0;
                    $("#unreadJoinCount").addClass("tmn-counts");
                }
                $("#unreadJoinCount").text(parseInt(unreadJoinCount) + 1);
                appendUserToChatList(data);

            }

        }
        /*
         * if window is active do not update notifcation counter,update read status to 0 , only applicable for conversations
         * 
         */
     if (type=="personal") {
            if ( data.message.to_channel_id==activeChannelId && data.message.to_user_id==userId)
                updateReadStatus("messages", data.message.user_id);
        }
       if (type=="general") {
		   
			
            if (data.room == activeChannelId && data.message.user_id != userId)
                updateReadStatus("general", "team_" + data.message.team_decoded_id);
        }


    }
    
    function appendUserToChatList(data){
        var html;
        html='<li id='+data.message.new_user_id+'_team_'+data.message.team_id+' onclick="getPersonalConversations("'+data.message.new_user_channel_id+'",this)"><a><span class="'+data.message.new_user_id+' online">&nbsp;</span>'+data.message.name+'</a></li>';
        $("#team_members_"+data.message.team_id).append(html);
    }
    
    function appendNewIncomingMessage(data, isGeneralSet) {
        var userIdOrRoomId;
        if (data.message.user_id != userId) {

				if (browserTabActiveFlag == 1 ) {
				if( isGeneralSet == true){
					
							activateDesktopNotification(data);
							
				}
		else{
				if ( data.message.to_user_id==userId) {
					
					activateDesktopNotification(data);
				}
			}
		
            } else {
				
					if(activeChannelId != data.room && isGeneralSet == true){
				
						activateDesktopNotification(data);
						
					}
				else{
				
				
					if ( data.message.to_channel_id!=activeChannelId && data.message.to_user_id==userId) {
						
						activateDesktopNotification(data);
					}
				}
			}
           

          if((data.message.to_channel_id==activeChannelId && data.message.to_user_id==userId )|| (data.room==activeChannelId && isGeneralSet==true)){
				

                var html;
                html = '<div class="lv-item media">';
                html += '<div class="lv-avatar pull-left">';
                if (data.message.profile_pic != null)
                    html += '<img src=' + base_url + "fusionmate/public/plugins/profile_pics/" + data.message.profile_pic + ' alt="">';
                else
                    html += '<img src=' + base_url + "fusionmate/public/plugins/profile_pics/" + 'default_user_icon.png' + ' alt="">';
                html += "<h6 class='elipsee'><a target='_blank' href='/view_profile/" + data.message.user_id + "' >" + data.message.first_name + "</a></h6>";

                html += '</div>';
                html += '<div class="media-body">';
                html += '<div class="ms-item">';
                html += data.message.body;
                html += '</div>';
                html += '<small class="ms-date"><i class="zmdi zmdi-time"></i>' + new Date().toString('MMMM dS, yyyy h:mm:ss tt') + ' </small>';
                html += '</div>';
                html += '</div>';
                $("#innerMessage").append(html);
                $("#messageWindow").mCustomScrollbar("scrollTo", "bottom");
          }
        }
    }
    function  preapreSideBar(members, userChannelId, teamName, userIds, mainChannelId, generalId) {
        var html;

        /**
         * Make the first team menu as active on load of page
         * 
         */

       
        if (initialActiveSidbarTeamMenuIdCount == 0) {

            activeSidbarTeamMenuId = mainChannelId;
            initialActiveSidbarTeamMenuIdCount = 1;
            html = "<li class=\"sub-menu toggled active \" ><a style='background-color:#fff !important' href=\"\" id='team_name_" + generalId + "' class='toggle-active' ><i class=\"zmdi zmdi-view-compact \"></i> " + teamName + "</a>";
            html += "<ul id='team_members_" + generalId + "' >";

            html += '<li><a >Add a memeber</a></li>';
            html += "<li  onclick=\"getConversations('" + mainChannelId + "',this)\"  id='team_" + generalId + "'><a class=\"active\" style=\"\">General</a></li>";
        } else {
            html = "<li class=\"sub-menu \" ><a href=\"\" id='" + "team" + "_" + mainChannelId + "' ><i class=\"zmdi zmdi-view-compact\"></i> " + teamName + "</a>";
            html += "<ul  >";

            html += '<li><a >Add a memeber</a></li>';
            html += "<li  onclick=\"getConversations('" + mainChannelId + "',this)\"  id='team_" + generalId + "'><a  style=\"\">General</a></li>";
        }
        if (sideBarAddNewTeamCount != limit) {
            sideBarAddNewTeamCount = sideBarAddNewTeamCount + 1;
            for (var member in members) {
                var userDetail = members[member].toString().split("_");
                ;
                var userName = userDetail[0];
                var status = userDetail[1];
                if (userIds[member] != userId && typeof userIds[member]!=='undefined') {
                    if (status == "online")
                        html += "<li id='" + userIds[member] +"_"+ "team_" + generalId +"' onclick=\"getPersonalConversations('" + userChannelId[member] + "',this)\"><a ><span class='" + userIds[member] + " online' >&nbsp;</span>" + userName + "</a></li>";
                    else
                        html += "<li id='" + userIds[member] +"_"+ "team_" + generalId +"' onclick=\"getPersonalConversations('" + userChannelId[member] + "',this)\"><a ><span class='" + userIds[member] + " offline' >&nbsp;</span>" + userName + "</a></li>";


                }
            }
        }
        html += '</ul>';
        html += '</li>';
        $("#team").append(html);
        

    }




    function getMessages(conversation) {
        var jqxhr = $.ajax({
            url: '/getmessages',
            type: 'POST',
            data: {
                conversation: conversation
            },
            dataType: 'html',
            cache: false
        });

        return jqxhr;
    }



    function updateConversationCounter($conversation) {
        var
                $badge = $conversation.find('.badge'),
                counter = Number($badge.text());

        if ($badge.length) {
            $badge.text(counter + 1);
        } else {
            $conversation.prepend('<span class="badge">1</span>');
        }
    }



    /***
     Events
     ***/

    $('#btnSendMessage').on('click', function (evt) {
        var $messageBox = $("#messageBox");

        evt.preventDefault();

        sendMessage($messageBox.val(), current_conversation, user_id).done(function (data) {
            console.log(data);
            $messageBox.val('');
            $messageBox.focus();
        });
    });

    $('#btnNewMessage').on('click', function () {
        $('#newMessageModal').modal('show');
    });

    /**
     * Shift+Enter to send message
     */
    $('#messageBox').keypress(function (event) {
        if (event.keyCode == 13 && event.shiftKey) {
            event.preventDefault();

            $('#btnSendMessage').trigger('click');
        }
    });
});

/*
 * Messages functions
 * 
 * 
 */

function addOrRemoveActive(thisEle) {
    $("li>a").removeClass('active memberTabActive');
    $("li>a").removeClass('toggle-active');

    $("ul").removeClass('toggle-active');
    if (!($(thisEle).parent().parent().children().hasClass('toggle-active'))) {
        $(thisEle).parent().parent().children().addClass('toggle-active')
        if (!($(thisEle).parent().parent().hasClass('toggled')))
            $(thisEle).parent().parent().addClass('toggled active');// expand collapsed team on click of memeber from outside of container
    }
    if ($(thisEle).find('a').hasClass('active')) {
        $(thisEle).find('a').removeClass('active memberTabActive');
    } else {
        $(thisEle).find('a').addClass('active memberTabActive');
    }
}


function getConversations(channelId, thisEle) {
    chatOrTeamListWindowFlag = 1;
    personalOrGeneral = 0;
    showWindow();
    updateLoginStatus("online");
    activeMessageWindowId = channelId;
    activeChannelId = channelId;
    if (typeof thisEle !== "undefined")
        addOrRemoveActive(thisEle);
    var jqxhr = $.ajax({
        url: '/conversations',
        type: 'GET',
        data: {
            channelId: channelId
        },
        dataType: 'html',
        cache: false
    });

    jqxhr.done(function (data) {
        $("#messageMain").empty();
        $("#messageMain").append(data);

        $("#messageWindow").css("height", screen.height - 320);

        //         $("#messageWindow").mCustomScrollbar();
        $("#messageWindow").mCustomScrollbar({
            autoHideScrollbar: true
        });
        $("#messageWindow").mCustomScrollbar("scrollTo", "bottom");
    });

}

function getPersonalConversations(channelId, thisEle) {


    $('body').css('overflow', 'hidden');
    chatOrTeamListWindowFlag = 1;
    personalOrGeneral = 1;
    showWindow();
    updateLoginStatus("online");
    addOrRemoveActive(thisEle);
    var userId = channelId.split("_");
    currentUserActiveFlag = userId[0];
    activeMessageWindowId = userId[0];
    activeChannelId = channelId;
    var jqxhr = $.ajax({
        url: '/personal_conversations',
        type: 'GET',
        data: {
            channelId: channelId
        },
        dataType: 'html',
        cache: false
    });

    jqxhr.done(function (data) {
        $("#messageMain").empty();
        $("#messageMain").append(data);
        $("#messageWindow").css("height", screen.height - 335);
        //         $("#messageWindow").mCustomScrollbar();
        $("#messageWindow").mCustomScrollbar({
            autoHideScrollbar: true
        });
        $("#messageWindow").mCustomScrollbar("scrollTo", "bottom");
window.emojiPicker.discover();
    });

}

function sendMessage(channelId, isPersonalSet) {
    
    updateLoginStatus("online");
     $('.typing-loader').hide();
 
    //    var
    //            socket = io('http://localhost:3000');
    //    socket.emit('test', "");
    //    ;
    if (msgBody === '' || msgBody == undefined) {
        if (snippetCode === '' || snippetCode == undefined) {
            snippetUpload = 0;
            var message = $("#messageBox").next().html();
             var html;
    html = '<div class="lv-item media">';
    html += '<div class="lv-avatar pull-left">';
    if (profilePic != '')
        html += '<img src=' + base_url + "fusionmate/public/plugins/profile_pics/" + profilePic + ' alt="">';
    else
        html += '<img src=' + base_url + "fusionmate/public/plugins/profile_pics/" + 'default_user_icon.png' + ' alt="">';
    html += "<h6 class='elipsee'><a target='_blank' href='/view_profile/" + userId + "' >" + firstName + "</a></h6>";

    html += '</div>';
    html += '<div class="media-body">';
     html += '<div class="ms-item">';
//        html += 
//        html += '<textarea data-emojiable="true">';
        html += message;
//        html += '</textarea>';
        html += '</div>';
    



    html += '<small class="ms-date"><i class="zmdi zmdi-time"></i>' + new Date().toString('MMMM dS, yyyy h:mm:ss tt') + ' </small>';
    html += '</div>';
    html += '<br/><div class="progress"><div class="progress-bar" style="height:24% !important" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">';
    html += '<span class="sr-only">100% Complete</span> </div> </div>';

    html += '</div>';
        } else {
            var message = snippetCode;
            snippetUpload = 1;
        }
        fileUpload = 0;
    } else {
        fileUpload = 1;
        var message = msgBody;
        ;
    }
    
       if (message.trim() == ''){
           $("#messageBox").next().html('');
        return false;
    }
    var jqxhr;

    lastSuccessfulMessageId = ''// clear any last stored message id
    if (!isPersonalSet) {
        jqxhr = $.ajax({
            url: '/messages',
            type: 'POST',
            data: {
                body: message,
                channelId: channelId,
                userId: userId
            },
            dataType: 'json',
            global: false,
           
            cache: false,
        });
        jqxhr.done(function (data) {

            lastSuccessfulMessageId = data.result.message.message_id;

        });
    } else {

        var toUserId = channelId.split("_")
        jqxhr = $.ajax({
            url: '/messages',
            type: 'POST',
            data: {
                body: message,
                channelId: channelId,
                toUserId: toUserId[0],
                isPersonalFlag: true
            },
            dataType: 'json',
            global: false,
            
            cache: false
        });
        jqxhr.done(function (data) {

            lastSuccessfulMessageId = data.result.message.message_id;

        });
    }

    /*
     * Append the message to window on send
     * 
     * 
     */
    if(snippetUpload!=0 || fileUpload!=0){
      
    var html;
    html = '<div class="lv-item media">';
    html += '<div class="lv-avatar pull-left">';
    if (profilePic != '')
        html += '<img src=' + base_url + "fusionmate/public/plugins/profile_pics/" + profilePic + ' alt="">';
    else
        html += '<img src=' + base_url + "fusionmate/public/plugins/profile_pics/" + 'default_user_icon.png' + ' alt="">';
    html += "<h6 class='elipsee'><a target='_blank' href='/view_profile/" + userId + "' >" + firstName + "</a></h6>";

    html += '</div>';
    html += '<div class="media-body">';

    if (fileUpload) {
        html += '<div class="card uploadCard">';
        html += '<div class="custom-file-display card-header bgm-cyan fileUploadText">Uploaded a File';
        html += '<span class="pull-right lv-actions actions"><a data-toggle="tooltip" data-html="true" data-placement="bottom" data-original-title="Download file"  download href="' + FilePath + '"><i style="font-size:24px;color:#000" class="zmdi zmdi-case-download"></i></a><a href="' + FilePath + '" target="_blank" data-toggle="tooltip" data-html="true" data-placement="bottom" data-original-title="Open in new window"><i style="padding-left:4px;font-size:22px;color:#000" class="zmdi zmdi-open-in-new"></i></a></span></div>';
        html += ' <div class="card-body card-padding"><div class="row"> <div class="col-md-4">';
        var fileTypeArr = ['avi', 'csv', 'sql', 'doc', 'flv', 'm4v', 'mp3', 'mp4', 'mpg', 'odt', 'ogv', 'pps', 'ppsx', 'ppt', 'pptx', 'psd', 'rtf', 'txt', 'wma', 'xls', 'xlsx', 'zip', 'pdf', 'docx'];
        var imageArry = ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'tiff'];
        var found = $.inArray(fileExtension, fileTypeArr);
        var imageFound = $.inArray(fileExtension, imageArry);
        if (found > -1) {
            html += '<a href="' + FilePath + '" target="_blank"><img src=' + base_url + "fusionmate/public/plugins/uploadIcons/" + fileExtension + '.png' + ' alt=""></a>';

        } else if (imageFound > -1) {
            html += '<a href="' + FilePath + '" target="_blank"><img class="img-thumbnail" width="504" height="465" src=' + FilePath + '' + ' alt=""></a>';

        } else {
            html += '<a href="' + FilePath + '" target="_blank"><img src=' + base_url + "fusionmate/public/plugins/uploadIcons/" + 'default.png' + ' alt=""></a>';

        }

        html += '</div>';
        html += ' <div class="col-md-8">';
        html += '<h2 class="uploadedFileName">';
            html += fileName;
            html += '</h2>';
        if (thought === '' || thought == undefined) {

        } else { 
            
            html += '<h2 class="comment">';
            html += thought;
            html += '</h2>';
        }
        html += '</div></div> </div></div>';
    } else if (snippetUpload) {
        html += '<div class="card uploadCard" onclick="viewSnippet(' + lastSuccessfulMessageId + ')">';
        html += '<div class="custom-file-display card-header bgm-cyan" style="">';
        html += '<span class="pull-right lv-actions actions">';
        html += '<a href="#"  data-toggle="tooltip" data-html="true" data-placement="bottom" data-original-title="View Snippet"><i style="padding-left:4px;font-size:22px;color:#000" class="zmdi zmdi-view-dashboard"></i></a>';
        html += '</span></div>';
        html += '<div class="card-body custom-file-dsiplay-body card-padding" style="">';
        html += ' <div class="row">';
        html += '<div class="col-md-4" > <a href="#" target="_blank"><img src=' + base_url + "fusionmate/public/plugins/uploadIcons/" + 'code.png' + ' alt=""></a></div>';
        html += ' <div class="col-md-8 snippetTextFormal">Added a Snippet Code</div>';
        html += '</div></div></div>';
    } else {
        html += '<div class="ms-item">';
//        html += 
//        html += '<textarea data-emojiable="true">';
        html += message;
//        html += '</textarea>';
        html += '</div>';
    }



    html += '<small class="ms-date"><i class="zmdi zmdi-time"></i>' + new Date().toString('MMMM dS, yyyy h:mm:ss tt') + ' </small>';
    html += '</div>';
    html += '<br/><div class="progress"><div class="progress-bar" style="height:24% !important" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">';
    html += '<span class="sr-only">100% Complete</span> </div> </div>';

    html += '</div>';
}
    $("#innerMessage").append(html);
    $("#messageWindow").mCustomScrollbar("scrollTo", "bottom");
    $("#messageBox").val(' ');
    $("#messageBox").next().html('');
    $("textarea#comment").val(' ');
	 $("textarea#comment").focus();
	  $("#messageBox").focus();
    $("#noConversations").remove();

    msgBody = "";
    thought = "";
    snippetCode='';
    snippetUpload='';
    fileUpload='';
    return jqxhr;
}

function activateDesktopNotification(data) {

    PNotify.desktop.permission();
    (new PNotify({
        title: data.message.first_name,
        text: $("<div/>").html(data.message.body).text(),
        desktop: {
            desktop: true,
            fallback: false,
            icon: "fusionmate/public/plugins/images/fmdesktop.png"
        }
    })).get().click(function (e) {
        if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target))
            return;
        alert('Hey! You clicked the desktop notification!');
    });
}



;

window.onbeforeunload = function (e) {
    /**
     * Send ajax and mark user as offline
     * 
     * 
     */
    updateLoginStatus("offline");
    e = e || window.event;

    // For IE and Firefox prior to version 4
    if (e) {
        // e.returnValue = 'Sure?';
    }

// For Safari

};

function updateLoginStatus(status) {

    var jqxhr = $.ajax({
        url: '/update_login_status',
        type: 'POST',
        data: {
            data: status
        },
        dataType: 'TEXT',
        cache: false
    });

    return jqxhr;
}
//function process(e, thisEle, toUserId) {
//alert();
//    var code = (e.keyCode ? e.keyCode : e.which);
//
//    //    
//    if (code == 13) { //Enter keycode
//        $("#send").trigger("click");
//    } else {
//        if (e.which == 8 || e.which == 17) {//backspace
//
//            if (thisEle.value.length == 0) {
//
//                detectTyping(false, toUserId);
//
//            }
//        } else {
//
//            detectTyping(true, toUserId);
//        }
//    }
//
//}

function detectTyping(flag, toUserId) {
    
    var socket = io.connect(socket_url, {
        secure: true
    });
    if (flag) {

        socket.emit('typed', {
            room: toUserId
        });
    } else {

        socket.emit('typed', {
            room: ''
        });
    }
}

function getUnreadMessages(type) {
    switch (type) {
        case "messages":
            if (!messageNotificationExpanded) {
                $("#customTopLoader").show();
                var jqxhrs = $.ajax({
                    url: '/unread_notifications',
                    type: 'POST',
                    data: {
                        data: type
                    },
                    dataType: 'html',
                    cache: false
                });

                jqxhrs.done(function (data) {
                     $("#customTopLoader").hide();
                    $("#messageNotificationContainer").append(data);
                    messageNotificationExpanded = true;
                    
                });
            } else {
                messageNotificationExpanded = false;
                  
            }
            break;

        case "general":
            if (!generalNotificationExpanded) {
                 $("#customTopLoader").show();
                var jqxhrs = $.ajax({
                    url: '/unread_notifications',
                    type: 'POST',
                    data: {
                        data: type
                    },
                    dataType: 'html',
                    cache: false
                });

                jqxhrs.done(function (data) {
                     $("#customTopLoader").hide();
                    $("#generalNotificationContainer").append(data);
                    generalNotificationExpanded = true;
                });
            } else {
                generalNotificationExpanded = false;
               
            }
            break;
            
             case "join":
            if (!joinNotificationExpanded) {
                 $("#customTopLoader").show();
                var jqxhrs = $.ajax({
                    url: '/unread_notifications',
                    type: 'POST',
                    data: {
                        data: type
                    },
                    dataType: 'html',
                    cache: false
                });

                jqxhrs.done(function (data) {
                     $("#customTopLoader").hide();
                    $("#joinNotificationContainer").append(data);
                    joinNotificationExpanded = true;
                });
            } else {
                joinNotificationExpanded = false;
               
            }
            break;
    }

}

function openChatWindow(Id) {

    $("#" + Id).trigger("click");
    chatOrTeamListWindowFlag = 1;
    showWindow();
}
function activateChatWindow(type, ChannelId, fromId, thisEle, totalMessageCount) {

    switch (type) {
        case "messages":
            var onSuccess = updateReadStatus("messages", fromId);
            var teamChannelId = ChannelId.toString().split("_");
            var fromUserId = teamChannelId[0];
            teamChannelId = teamChannelId[1];

            openChatWindow(fromUserId+"_"+"team"+"_"+teamChannelId);

            if (onSuccess) {
                //$(thisEle).remove();
                var unreadCount = $("#unreadCount").text();
                unreadCount = unreadCount - totalMessageCount;


                if (unreadCount > 1)
                    $("#unreadCount").text(unreadCount - totalMessageCount);
                else {
                    $("#unreadCount").text('');
                    $("#unreadCount").removeClass("tmn-counts");
                }


                $(thisEle).remove();
            }
            break;

        case "general":
            var teamChannelId = ChannelId;

            var onSuccess = updateReadStatus("general", teamChannelId);


            openChatWindow(teamChannelId);

            if (onSuccess) {
                //$(thisEle).remove();

                var unreadGeneralCount = $("#unreadGeneralCount").text();
                unreadGeneralCount = unreadGeneralCount - totalMessageCount;


                if (unreadGeneralCount > 1)
                    $("#unreadGeneralCount").text(unreadGeneralCount - totalMessageCount);
                else {
                    $("#unreadGeneralCount").text('');
                    $("#unreadGeneralCount").removeClass("tmn-counts");
                }

                $(thisEle).remove();

            }
            break;
            
        case "join":
                var onSuccess = updateReadStatus("join", ChannelId);
                var teamChannelId = ChannelId.toString().split("_");
                var fromUserId = teamChannelId[0];
                teamChannelId = teamChannelId[1];

                openChatWindow(fromUserId+"_"+"team"+"_"+teamChannelId);
               
                if (onSuccess) {
                   
                    //$(thisEle).remove();
                    var unreadCount = $("#unreadJoinCount").text();
                    unreadCount = unreadCount - totalMessageCount;

                  
                    if (unreadCount > 1)
                        $("#unreadJoinCount").text(unreadCount - totalMessageCount);
                    else {
                        $("#unreadJoinCount").text('');
                        $("#unreadJoinCount").removeClass("tmn-counts");
                    }


                    $(thisEle).remove();
                }
            break;
    }


}

function updateReadStatus(type, data) {
    switch (type) {
        case "messages":
            var jqxhrs = $.ajax({
                url: '/update_read_status',
                type: 'POST',
                data: {
                    data: type,
                    fromUserId: data,
                    toUserId: userId
                },
                dataType: 'html',
                cache: false
            });

            jqxhrs.done(function (data) {

               // $("#messageNotificationContainer").append(data);
            });
            return jqxhrs;
            break;

        case "general":
            var jqxhrs = $.ajax({
                url: '/update_read_status',
                type: 'POST',
                data: {
                    data: type,
                    teamId: data

                },
                dataType: 'html',
                cache: false
            });

            jqxhrs.done(function (data) {

                // $("#messageNotificationContainer").append(data);
            });
            return jqxhrs;
            break;
            
            
            case "join":
              
                var jqxhrs = $.ajax({
                    url: '/update_read_status',
                    type: 'POST',
                    data: {
                        data: type,
                        teamId: data
                    },
                    dataType: 'html',
                    cache: false
                });

                jqxhrs.done(function (data) {

                   // $("#messageNotificationContainer").append(data);
                });
                return jqxhrs;
            break;
    }

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

function showJoinNotification(data){
    
        $.growl({
            message: data.message.name+" "+"Joined"+" "+data.message.team_name
        },{
            type: "inverse",
            allow_dismiss: true,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'top',
                align: 'right'
            },
            delay: 250000,
            animate: {
                    enter: 'animated fadeIn',
                    exit: 'animated fadeOut'
            },
            offset: {
                x: 20,
                y: 85
            }
        });
   
    
}
$(document).ready(function () {

//This will execute whenever the window maxmimize button is clicked

    $(window).bind('resize', function () {

        $("#messageWindow").css("height", $(window).height() - 320);
    });
    $(window).resize(function () {
        // This will execute whenever the window is resized

        $("#messageWindow").css("height", $(window).height() - 320);
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
    $("#body").on("click", function () {
        messageNotificationExpanded = false;
        generalNotificationExpanded = false;
        joinNotificationExpanded = false;
        $("#messageNotification").remove();
        $("#generalNotification").remove();
        $("#joinNotification").remove();
    });
});
