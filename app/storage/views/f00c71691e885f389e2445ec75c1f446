
<script src="fusionmate/public/plugins/js/fileupload.js"></script>

<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1"  aria-hidden="true">
        <div class=" modal-dialog ">

                <!-- Modal content-->
                <div class="modal-content">
                        <div class="modal-header-info modal-header">
                                <!--<button type="button" class="close" id="clear-dropzone"  onclick="closeUploadModal()">&times;</button>-->
                                <h4 class="modal-title custom-modal-header-font">Upload Files.</h4>
                        </div>
                        <div class="modal-body" >
                                <!--                <blockquote  class="m-b-25" id='inner'>
                                                                      <p>Choose.</p>
                                                </blockquote>-->
                                <form class="dropzone"  id="my-awesome-dropzone">
                                        <div class="fallback">
                                                <input name="file" type="file"  />
                                        </div>
                                        <!--<input type="reset" style="display:none;">-->
                                </form><br/>
                                
                                <textarea  rows="4" id='comment' class="form-control" placeholder="Comments..."></textarea>
                                <br/>
                                <button id="uploadChatFile" class="btn btn-success waves-effect" onclick="uploadFilesComment()">UPLOAD&nbsp;</button>
                                <button id="closeUploadChatFile" type="button" class="btn btn-default" onclick="closeUploadModal()" >Close</button>
                                <!--<button id="clear-dropzone">Clear Dropzone</button>-->

                        </div>
                        <div class="modal-footer  text-center">

                        </div>
                </div>


        </div>
</div>

<script>
   
var fileChatDropZone = new Dropzone("form#my-awesome-dropzone", {url: '/upload_user_files/chat'});//intialize dropzone for form

</script>