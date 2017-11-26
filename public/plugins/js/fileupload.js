
/**
 * 
 * @type Dropzone
 * intialize dropzone for fileupload form 
 */

//



$('#myModal').on('hidden.bs.modal', function (e) {
        $(this)
                .find("input,textarea,select")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
})

$("#codeSnippet").click(function () {
        aceEditor();



        sendMessage(activeChannelId, personalOrGeneral);

});

$(".chzn-select").chosen().change(function () {
        var languageSelected = $(this).val();
        aceEditor(languageSelected);

});
function uploadFilesComment() {

        if (fileChatDropZone.getQueuedFiles().length == 0) {
                swal("Select a file to upload.", "", "error");
                return false;
        }
        $('#uploadChatFile').html('Uploading...<span id="uploadLoader" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
        $('#uploadChatFile').prop('disabled', true);
         $('#closeUploadChatFile').prop('disabled', true);

//                       fileChatDropZone.removeAllFiles();//remove any previous files
        fileChatDropZone.processQueue();
        fileChatDropZone.on("complete", function (file) {

                /*
                 * 
                 * Wait for 2 seconds to check if any server erroe occured before closing modal and sending message
                 * 
                 */
                $('#uploadChatFile').html('Saving...');
                $('#uploadChatFile').prop('disabled', true);
                $('#closeUploadChatFile').prop('disabled', true);
                setTimeout(function () {

                        if (fileErroFlag) {
                                swal("Error Occured!.Please choose a different file or try again.", "", "error");
                                fileErroFlag = 0;
                                $('#uploadChatFile').prop('disabled', false);
                                $('#closeUploadChatFile').prop('disabled', false);
                                $('#uploadChatFile').html('UPLOAD&nbsp;<i class="zmdi zmdi-mail-send">');
                                return false;
                        } else {
                                thought = $("textarea#comment").val();
                                fileName = filename.replace(/["']/g, "")
                                FilePath = 'fusionmate/public/plugins/userUploads/' + fileName;
                                var str = fileName;
                                fileExtension = str.substring(str.indexOf(".") + 1);
                                msgBody = fileExtension + "#_$" + FilePath + "#_$" + thought;
                                sendMessage(activeChannelId, personalOrGeneral);
                                $('#uploadChatFile').prop('disabled', false);
                                $('#closeUploadChatFile').prop('disabled', false);
                                $('#uploadChatFile').html('UPLOAD');
                                closeUploadModal();
                        }
                }, 2000);
        });
        fileChatDropZone.on("error", function (file) {
                fileErroFlag = 1;

        });



}
Dropzone.options.myAwesomeDropzone = {
        maxFiles: 1,
        accept: function (file, done) {
                console.log("uploaded");
                done();
        },
        init: function () {
                this.on("maxfilesexceeded", function (file) {
                        $('#inner').append("No more files please!");
                });

        }
};

$(document).ready(function () {
        // .... your jQuery goodness .... 
});

function closeUploadModal() {
        fileChatDropZone.removeAllFiles();
        $(this).closest('#my-awesome-dropzone').find("input[type=file], textarea").val("");

        thought = "";
        $('#myModal').modal('hide')
}


function uploadTaskFiles() {

         fileErroFlag=0;
        $('#saveTask').html('Processing..<span id="uploadLoader" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
        $('#saveTask').prop('disabled', true);
        $('#cancelTask').prop('disabled', true);

        taskDropzone.processQueue();
        taskDropzone.on("complete", function (file) {

                $('#saveTask').html('Save');
                $('#saveTask').prop('disabled', false);
                $('#cancelTask').prop('disabled', false);
                setTimeout(function () {
                        if (!fileErroFlag){
                                fileErroFlag=0;
                                 taskDropzone.removeAllFiles();
                                $('#cancelTask').trigger('click');
                                 filterDashBoard();
                               
                        }
                }, 2000);


        });
        taskDropzone.on("error", function (file) {
                fileErroFlag = 1;
                $("#taskServerErrorContent").empty();
                $("#taskServerErrorContent").append("Oh snap! One of the files coudnt be uploaded!.The reasone might be with one of the files you just tried to upload.Plrase try agian!.");
                $("#taskServerError").show();
                $("#scrollToError").trigger('click');
                $('#saveTask').html('Save');
                $('#saveTask').prop('disabled', false);
                $('#cancelTask').prop('disabled', false);

                /**
                 * rollback back previous saved data
                 */
                rollBackSavedTask(lastSavedTaskId, lastSavedTaskDescId);

        });



}


