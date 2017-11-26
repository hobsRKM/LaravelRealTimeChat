


function dashboard() {
      
    $('#body').block({
        message: '<h1><center>Loading....</center></h1>',
        css: { width: '0%', border:'0px solid #FFFFFF',cursor:'wait',backgroundColor:'#FFFFFF'},
        overlayCSS:  { backgroundColor: '#000',opacity:0.0,cursor:'wait'} 
    });
    $.ajax({
        url: "/task/dashboard",
        type: "POST",
        dataType: "html",
        async:true

    }).done(function (data) {
        showDashboard();
      
        $("#container").append(data);
        $('#body').unblock();
          
    });
}

function showDashboard() {

    dashboardWindowFlag = 1;
    selectedTaskTeamId = '';
    selectedProjectId = '';
    $("#dashboardTab").remove();
    $("#animatedModal").remove();
    $("#dashboardTab").show();
    $("#teamList").addClass("hidden");
    $("#messageMain").hide();
    $("body").css("background-color", "#fff");
    chatOrTeamListWindowFlag = 0;
   
   
    

}

function projectModal() {
    $('#createProject').modal("show");
}
function initializeGrid() {
    $('#dashboardTab').block({
        message: '<img src="fusionmate/public/plugins/images/newloader.gif"/><br/><center>Processing....</center>',
        css: { width: '0%', border:'0px solid #FFFFFF',cursor:'wait',backgroundColor:'#FFFFFF'},
        overlayCSS:  { backgroundColor: '#000',opacity:0.0,cursor:'wait'} 
    });
    $("#data-table-basic").bootgrid("destroy");// distroy any open instance before re-instantiation
    //initalize gird
    $("#data-table-basic").bootgrid({
        ajax: true,
        post: function ()
        {
            /* To accumulate custom parameter with the request object */
            return {
                teamId: selectedTaskTeamId,
                projectId: selectedProjectId,
            };
        },
        url: "/task/filter_grid",
        labels: {
            noResults: "No tasks found."
        },
        formatters: {
            "status_name": function (column, row)
            {
                switch (row.status_name) {
                    case "New":
                        return "<button class='btn btn-default btn-block task-new'>New</button>";
                        break;
                    case "In Progress":
                        return "<button ' class='btn btn-default btn-block task-inprogress'>In Progress</button>";
                        break;
                    case "Resolved":
                        return "<button  class='btn btn-default btn-block task-resolved '>Resolved</button>";
                        break;
                    case "Due":
                        return "<button  class='btn btn-default btn-block task-due '>Due</button>";
                        break;
                    case "Closed":
                        return "<button class='btn btn-default btn-block task-closed'>Closed</button>";
                        break;
                    case "Critical":
                        return "<button class='btn btn-default btn-block task-critical'>Critical</button>";
                        break;
                }
            },
            "priority_name": function (column, row)
            {
                return "<b>" + row.priority_name + "</b>";
            },
            "tracker": function (column, row)
            {
                return "<b>" + row.tracker + "</b>";
            },
            "action": function (column, row)
            {
                return " <button  onclick=\"viewAssignment('" + row.un_id + "')\"  class=\"taskView taskAction btn btn-default btn-icon-custom\" href='#animatedModal'><i class=\"zmdi zmdi-assignment assignment-custom-icon\"></i></button>";
            },
        }
    }).on("loaded.rs.jquery.bootgrid", function ()
    {
        /* Executes after data is loaded and rendered */

        initializeAnimatedModal();
        $('#dashboardTab').unblock();

    });



}

function initializeAnimatedModal() {
    $(".taskView").animatedModal({
        animatedIn: 'bounceInLeft',
        animatedOut: 'bounceOutRight',
        color: '#fff'

    });
}

function initializePlugins() {
    //load default element plugins on this page
    //Add active class for opened items
    $('.collapse').on('show.bs.collapse', function (e) {
        $(this).closest('.panel').find('.panel-heading').addClass('active');
    });

    $('.collapse').on('hide.bs.collapse', function (e) {
        $(this).closest('.panel').find('.panel-heading').removeClass('active');
    });

    //Add active class for pre opened items
    $('.collapse.in').each(function () {
        $(this).closest('.panel').find('.panel-heading').addClass('active');
    });
    $('.date-picker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    $('.html-editor').summernote({
        height: 150
    });

    $('body').on('click', '.hec-button', function () {
        $('.html-editor-click').summernote({
            focus: true
        });
        $('.hec-save').show();
    })

    //Save
    $('body').on('click', '.hec-save', function () {
        $('.html-editor-click').code();
        $('.html-editor-click').destroy();
        $('.hec-save').hide();
        notify('Content Saved Successfully!', 'success');
    });

    $('.html-editor-airmod').summernote({
        airMode: true
    });
    $('.chosen-single').css("height", "35");
    $('.chosen').chosen({
        width: '100%',
        allow_single_deselect: true
    });
    $('.fa-question ').remove();
    $('.note-help ').remove();
    $('[data-toggle="tooltip"]').tooltip();
    
}
function viewAssignment(id) {
    $("#animatedModal").remove();
    $('#dashboardTab').block({
        message: '<img src="fusionmate/public/plugins/images/newloader.gif"/><br/><center>Processing....</center>',
        css: { width: '0%', border:'0px solid #FFFFFF',cursor:'wait',backgroundColor:'#FFFFFF'},
        overlayCSS:  { backgroundColor: '#000',opacity:0.0,cursor:'wait'} 
    });
    $.ajax({
        url: "/task/view_assignment",
        type: "POST",
        data: {id: id},
        dataType: "html",
        success: function (data) {
            $('#dashboardTab').unblock();

            $("#container").append(data);
            $("#animatedModal").removeClass('animated animatedModal-off');
            $("#animatedModal").addClass('animated animatedModal-on bounceInLeft');
            $("#animatedModal").addClass('animatemodal-custom-class');

            initializeAnimatedModal();
            initializePlugins();
            $('#dashboardTab').unblock();
        }



    });


}
function createProject() {

    var data = $("#newProject").serialize();
   
   
    $.ajax({
        url: "/task/create_project",
        type: "POST",
        data: data,
        dataType: "html"


    }).done(function (data) {
        
        $("#customCreateProjectMessage").empty();
        $("#customCreateProjectMessage").append(data);

    });
}


function loadTaskData() {
    $("#data-table-basic").bootgrid("destroy");
    initializeGrid();
    scrollToGrid();



}

function scrollToGrid() {
    $('html, body').animate({
        scrollTop: $("#data-table-basic").offset().top
    }, 2000);
}

function initializeTaskForm() {
    $('#animatedModal').block({
        message: '<img src="fusionmate/public/plugins/images/newloader.gif"/><br/><center>Processing....</center>',
        css: { width: '0%', border:'0px solid #FFFFFF',cursor:'wait',backgroundColor:'#FFFFFF'},
        overlayCSS:  { backgroundColor: '#000',opacity:0.0,cursor:'wait'} 
    });


    var isTrue = validateFilter();

    if (isTrue) {
        $("#animatedModal").show();
        $.ajax({
            url: "/task/get_members",
            type: "POST",
            data: {teamId: selectedTaskTeamId, projectId: selectedProjectId},
            dataType: "html",
        }).done(function (data) {

            $("#taskMembers").empty();
            $("#taskMembers").append(data);
            $('#taskMembers').trigger("chosen:updated");
            $('#animatedModal').unblock();
            resetTaskForm();
        });
    } else {
        $("#animatedModal").hide();

    }
}


function storeSelectedIdInGlobalVar(thisEle, option) {
    switch (option) {
        case "team":
            /**
             * Validate if the user is allowed to create task on this team
             */

            selectedTaskTeamId = $(thisEle).val();

            if (selectedTaskTeamId != '' && selectedProjectId != '') {
                var success = validateTaskAuthority(selectedTaskTeamId, selectedProjectId);

                if (!success) {

                    disableCreateTask(true);
                } else
                    disableCreateTask(false);
            }

            break
        case "project":
            selectedProjectId = $(thisEle).val();
             getTeamsAlignedToProject(selectedProjectId);
            if (selectedProjectId != '' && selectedTaskTeamId != '') {
                var success = validateTaskAuthority(selectedTaskTeamId, selectedProjectId);
                if (!success) {

                    disableCreateTask(true);
                } else{
                    disableCreateTask(false);
                   
                }
            }
            break
    }




}

function getTeamsAlignedToProject(id){
     $("#customTopLoader").show();
    $.ajax({
        url: "/task/get_project_teams",
        type: "POST",
        data: { projectId: selectedProjectId},
        dataType: "html"
      
    }).done(function (data) {
           $('#allignedTeams').empty();
              $('#allignedTeams').append(data);
            $('#allignedTeams').trigger("chosen:updated");
             $("#customTopLoader").hide();
    });
}
function disableCreateTask(toggle) {

    if (toggle) {

        $("#createTask").attr("disabled", "disabled");
        $('#createTask').attr('title', '<b>You are not allowed to create tasks for this team.To create task you should be admin of this team.<br/><span style="color:#fff;"><b>OR</b></span><br/>If you are the admin but still cant create then try assigning the project to this team and try again.</b><br/><a style="color:#ff9800"  onclick="dismiss();">Dismiss</a>').tooltip('fixTitle').tooltip('show');
        $('[data-toggle="tooltip"]').tooltip();
    } else {
        $("#createTask").removeAttr("disabled");
        showCreateTaskToolTip();

    }

}
function showCreateTaskToolTip() {
    $('[data-toggle="tooltip"]').tooltip();
    $('#createTask').attr('title', 'Create Task').tooltip('fixTitle').tooltip('show');
    setTimeout(function () {
        $('#createTask').tooltip('hide');
    }, 2000);
}
function dismiss() {
    $('[data-toggle="tooltip"]').tooltip('destroy');
    $('[data-toggle="tooltip"]').tooltip();

}
function validateTaskAuthority(selectedTaskTeamId, selectedProjectId) {
    var returnData;
    $.ajax({
        url: "/task/validate_create_task",
        type: "POST",
        data: {teamId: selectedTaskTeamId, projectId: selectedProjectId},
        dataType: "json",
        async: false,
        global: false,
    }).done(function (data) {
        returnData = data;
//                        $("#taskMembers").empty();
//                        $("#taskMembers").append(data);
//                        $('#taskMembers').trigger("chosen:updated");
//                        $('#animatedModal').unblock();
    });

    return returnData.success;


}
function  validateFilter() {
    $('#animatedModal').block({
        message: '<img src="fusionmate/public/plugins/images/newloader.gif"/><br/><center>Processing....</center>',
        css: { width: '0%', border:'0px solid #FFFFFF',cursor:'wait',backgroundColor:'#FFFFFF'},
        overlayCSS:  { backgroundColor: '#000',opacity:0.0,cursor:'wait'} 
    });
    if (selectedTaskTeamId == '' & selectedProjectId == '') {
        swal("Please Select Project and Team", "", "error");
        return false;
    }
    if (selectedTaskTeamId == '') {
        swal("Please Select Team ", "", "error");
        return false;
    }

    if (selectedProjectId == '') {
        swal("Please Select  Project", "", "error");
        return false;
    }



    return true;
}

function createTask(isUpdateSet) {

    var uploadTaskFileSet = 0;
    lastSavedTaskId = '';
    lastSavedTaskDescId = '';


    var data = {};
    data += "&tracker=" + $("#tracker").val();
    data += "&status=" + $("#status").val();
    data += "&priority=" + $("#priority").val();
    data += "&subject=" + $("#subjectErr").val();
    data += "&startDate=" + $("#start_date").val();
    data += "&endDate=" + $("#due_date").val();
    data += "&assignee=" + $("#taskMembers").val();
    data += "&description=" + $(".html-editor").code();
    data += "&projectId=" + selectedProjectId;
    data += "&teamId=" + selectedTaskTeamId;
    if (isUpdateSet)
        data += "&taskId=" + $("#parent_task_id").val();
    ;
    $.ajax({
        url: "/task/create_task",
        type: "POST",
        data: data,
        dataType: "json",
    }).done(function (data) {
        $("#taskServerErrorContent").empty();
        $('.error').empty();
        if (data.success == false) {
            for (var values in data.result) {
//                                alert(data.result[values]);
                if (data.result[values] == "trackerErr") {
                    $("#" + data.result[values]).append("You Missed Out Tracker!.")
                }
                if (data.result[values] == "statusErr") {
                    $("#" + data.result[values]).append("You Missed Out Status!.")
                }
                if (data.result[values] == "priorityErr") {
                    $("#" + data.result[values]).append("You Missed Out Priority!.")
                }
                if (data.result[values] == "subjectErr") {
                    $("#" + data.result[values]).append("You Missed Out Subject!.")
                }
                if (data.result[values] == "startDateErr") {
                    $("#" + data.result[values]).append("You Missed Out Start Date!.")
                }
                if (data.result[values] == "subjectMinErr") {
                    $("#" + data.result[values]).append("Subject requires atleast 3 characters!.")
                }

            }
            $('#taskModalContent').unblock();
        }
        if (data.success == true) {
            /**
             * Check if there is atleast one file to upload
             */


            if (taskDropzone.getQueuedFiles().length > 0) {
                uploadTaskFileSet = 1;
                uploadTaskFiles();
                lastSavedTaskId = data.last_id;
                lastSavedTaskDescId = data.last_desc_id;
//                            if(isDone){
//                                     taskDropzone.removeAllFiles();
//                               $('#animatedModal').unblock();
//                                 $('#cancelTask').trigger('click');
//                       }
//                       else{
//                               /**
//                                * rollback back previous saved data
//                                */
////                               rollBackSavedTask(data.last_id,data.last_desc_id);
//                       }
            }
            if (!uploadTaskFileSet) {
                $('#saveTask').html('Save');
                $('#saveTask').prop('disabled', false);
                $('#cancelTask').prop('disabled', false);
                $('#cancelTask').trigger('click');
                filterDashBoard();
            }



        }
        if (data.error == true) {

            $("#taskServerErrorContent").append("Oh snap! Server Error occured while saving your data.Try again!");
            $("#taskServerError").show();
            $("#scrollToError").trigger('click');
            $('#taskModalContent').unblock();
            setTimeout(function () {
                $("#taskServerError").fadeOut();
            }, 4000);

        }

    });
    $('html, body').animate({
        scrollTop: $("#animatedModal").offset().top
    }, 2000);
}

function getRecentTaskUpdates() {
    $.ajax({
        url: "/task/get_recent_task_updates",
        type: "POST",
        data: {taskId: $("#parent_task_id").val()},
        dataType: "json"


    }).done(function (data) {

    });
}
function rollBackSavedTask(id, descId) {
    $.ajax({
        url: "/task/rollback_saved_task",
        type: "POST",
        data: {last_id: id, last_desc_id: descId},
        dataType: "json"


    }).done(function (data) {

    });

    lastSavedTaskId = '';
    lastSavedTaskDescId = '';



}

function filterDashBoard() {
    initializeGrid();
    $.ajax({
        url: "/task/filter_all_dashboard_data",
        type: "POST",
        data: {teamId: selectedTaskTeamId, projectId: selectedProjectId},
        dataType: "json"


    }).done(function (data) {
        $("#new").text('0');
        $("#inprogress").text('0');
        $("#resolved").text('0');
        $("#critical").text('0');
        $("#due").text('0');
        $("#all").text(data.allCount);
        $("#closed").text('0');



        for (var result in data) {

            if (data[result]['name'] == "New") {
                $("#new").text('');
                $("#new").text(data[result]['count']);
            }
            if (data[result]['name'] == "In Progress") {
                $("#inprogress").text('');
                $("#inprogress").text(data[result]['count']);
            }
            if (data[result]['name'] == "Resolved") {
                $("#resolved").text('');
                $("#resolved").text(data[result]['count']);
            }
            if (data[result]['name'] == "Critical") {
                $("#critical").text('');
                $("#critical").text(data[result]['count']);
            }
            if (data[result]['name'] == "Due") {
                $("#due").text('');
                $("#due").text(data[result]['count']);
            }



            if (data[result]['name'] == "Closed") {
                $("#closed").text('');
                $("#closed").text(data[result]['count']);
            }


        }

    });


}
function toggleTaskDashboardView() {
    if ($('#ts1').prop('checked')) {
        $("#task").slideDown()
    } else {
        $("#task").slideUp()
    }
}

function resetTaskForm() {

    $("#tracker").val('').trigger('chosen:updated');
    $("#status").val('').trigger('chosen:updated');
    $("#priority").val('').trigger('chosen:updated');
    $("#subjectErr").val('');
    $("#start_date").val('');
    $("#due_date").val('');
    $("#taskMembers").val('');
    $(".html-editor").summernote('reset')
    $("#updates").remove();
    $("#parent_task_id").remove();
    $("#files").remove();

}


       