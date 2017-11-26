


<style>
.error {
	color: #ff0000;
}
</style>
@if(isset($data['task_data']))

<input id="parent_task_id" type="hidden" value="<?php echo $data['task_data']['parent_tracker_activity_un_id'];   ?>" />
@endif
<div id="animatedModal">
	<div id='taskModalContent' class="modal-content">
                <div  id="taskServerError"style="display:none" class="alert alert-danger " role="alert"> <span id="taskServerErrorContent"></span></div>
		<blockquote class="m-b-25">
			<p>
				This section allows you to add, update and delete a task.If you are
				not sure on how this section works.<a href="#">Click here</a><a
					class="close-animatedModal" href=""><i
					class="pull-right zmdi zmdi-close"></i></a>
			</p>
		</blockquote>

		<div class="panel panel-primary">
			<div class="panel-heading customPannelheading">
				<span>Create Task</span>
			</div>
			<div class="panel-body customPannelBody">
				<div class="row">
					<div class="col-sm-12">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Tracker<span class="imp">&nbsp*</span></b></label>
						</div>
						<div class="col-md-4">
							<select id="tracker" class="chosen"
								data-placeholder="Choose a Country...">
								<option value="" >Select Tracker</option>
								@foreach($data['trackers'] as $values)
                                                                @if(isset($data['task_data']))
                                                                    @if($values['name']==$data['task_data']['tracker'])
                                                                        <option selected='true'  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                    @else
                                                                         <option  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                    @endif
                                                                @else
                                                                    <option  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                @endif
								@endforeach
							</select>
						</div>
						<span id="trackerErr" class="error"></span>
					</div>
					<br />
					<br />
					<br />

					<div class="col-sm-12">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Status<span class="imp">&nbsp*</span></b></label>
						</div>
						<div class="col-md-4">
							<select id="status" class="chosen"
								data-placeholder="Choose a Country...">
								<option value="">Select Status</option> 
                                                                @foreach($data['status'] as $values)
                                                                @if(isset($data['task_data']))
                                                                    @if($values['name']==$data['task_data']['status_name'])
                                                                        <option selected='true'  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                    @else
                                                                         <option  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                    @endif
                                                                @else
                                                                    <option  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                @endif
								@endforeach
							</select>
						</div>
						<span id="statusErr" class="error"></span>
					</div>
					<br />
					<br />
					<br />

					<div class="col-sm-12">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Priority<span class="imp">&nbsp*</span></b></label>
						</div>
						<div class="col-md-4">
							<select id="priority" class="chosen"
								data-placeholder="Choose a Country...">
								<option value="">Select Priority</option>
								@foreach($data['priorities'] as $values)
                                                                @if(isset($data['task_data']))
                                                                    @if($values['name']==$data['task_data']['priority_name'])
                                                                        <option selected='true'  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                    @else
                                                                         <option  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                    @endif
                                                                @else
                                                                    <option  value="<?php echo $values['un_id'] ?>">{{$values['name']}}</option>
                                                                @endif
								@endforeach
							</select>
						</div>
						<span id="priorityErr" class="error"></span>
					</div>
					<br />
					<br />
					<br />

					<div class="col-sm-12">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Subject</b></label>
						</div>
						<div class="col-md-7">
							<div class="fg-line ">
								<input id="subjectErr"  type="text" class=" form-control"  value="<?php if(isset($data['task_data']))echo $data['task_data']['tracker_subject']?>"
									placeholder="Enter Subject">
							</div>
						</div>
						<span id="subjectMinErr" class="error"></span>
					</div>
					<br />
					<br />
					<br />

					<div class="col-sm-12">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Start Date<span class="imp">&nbsp*</span></b></label>
						</div>
						<div class="col-md-3">
							<div class="dtp-container fg-line">
								<input id="start_date" type='text' value="<?php if(isset($data['task_data']))echo $data['task_data']['start_date']?>"
									class="form-control date-picker" placeholder="Click here...">
							</div>
						</div>
						<span id="startDateErr" class="error"></span>
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Due Date</b></label>
						</div>
						<div class="col-md-3">
							<div class="dtp-container fg-line">
								<input id="due_date" type='text'  value="<?php if(isset($data['task_data']))echo $data['task_data']['end_date']?>"
									class="form-control date-picker" placeholder="Click here...">
							</div>
						</div>
					</div>
					<br />
					<br />
					<br />


					<div class="col-sm-12">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Assign To<span class="imp">&nbsp*</span></b></label>
						</div>
						<div class="col-md-3">
							<select id="taskMembers" class="chosen"
								data-placeholder="Choose a User...">
								<option value="">Select User</option>
                                                                @if(isset($data['task_data']))
                                                                    @foreach($data['members'] as $values)
                                                                        <?php $member=explode("_",$values); ?>
                                                                         @if($member[2]==$data['task_data']['main_user_id'])
                                                                            <option selected='true'  value="<?php echo $member[2] ?>">{{$member[0]." ".$member[1]}}</option>
                                                                        @else
                                                                             <option  value="<?php echo $member[2] ?>">{{$member[0]." ".$member[1]}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
							</select>
						</div>
						<span id="assigneeErr" class="error"></span>
					</div>
					<br />
					<br />
					<br />
                                        <div class="col-sm-12" id="files">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Files</b></label>
						</div>
						<div class="col-md-10">
 <?php

 if(isset($data['task_data']['file_name'])){
                                            if(count($data['task_data']['file_name'])==0)
                                               echo "No files attached";
                                            else
                                                foreach($data['task_data']['file_name'] as $files){
                                                    echo "<a href='".Config::get('constants.constants_list.FILE_PATH')."userUploads/".$files."' download>".$files."</a><br/>";
                                                }
                                                   
 }
                                           
                                            ?>
						</div>
					</div>
                                        <br />
					<br />
<div class="col-sm-12" id="updates">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b></b></label>
						</div>
						<div class="col-md-10">
				@if(isset($data['task_data']))
<blockquote class="m-b-25 c-deeporange task-block-quote">
    <a target="_blank" href="/task/updates/<?php echo $data['task_data']['parent_tracker_activity_un_id'];   ?>"><i class="zmdi zmdi-open-in-new zmdi-hc-fw"></i> &nbsp; View Previous Updates </a>
		</blockquote>   
                                @endif
						</div>
					</div>
					<br />
					<br />
					<br />
					<div class="col-sm-12">
						<div class="col-md-2 taskLabel">
							<label class=" pull-right"><b>Attach</b></label>
						</div>
						<div class="col-md-10">
							<form id="taskForm"  class="dropzone">
								<div class="fallback">
									<input name="file" type="file" multiple />
                                                                       
								</div>
							</form>
						</div>
					</div>
					<br />
					<br />
					<br />



					<div class="col-sm-12">
						<div class="col-md-2 taskLabel">
							<br /> <label class=" pull-right"><b>Description</b></label>
						</div>
						<div class="col-md-10">
							<br />
                                                        <div class="html-editor">
                                                              @if(isset($data['task_data']))
                                                              {{$data['task_data']['description']}}
                                                              @endif
                                                        </div>
						</div>
					</div>
					<br />
					<br />
					<br />
				</div>
                                <a  href="#taskServerError"><span id="scrollToError"></span></a>
                                <span class="col-sm-offset-5 text-center">
                                 @if(isset($data['task_data']))
				<button id="saveTask"
						onclick="createTask(true)" class=" btn btn-primary btn-icon-text">
						<i class="zmdi zmdi-check"></i> Update
					</button>
                                    @else
                                    <button id="saveTask"
						onclick="createTask(false)" class=" btn btn-primary btn-icon-text">
						<i class="zmdi zmdi-check"></i> Save
					</button>
                                        @endif
                                    &nbsp;
					<button id="cancelTask" class=" close-animatedModal btn btn-primary btn-icon-text">
						<i class="zmdi zmdi-close"></i> Cancel
					</button></span>

			</div>
		</div>
	</div>
</div>
<script src="{{asset('fusionmate/public/plugins/js/fileupload.js')}}"></script>

<script>
        //Date

  var taskDropzone = new Dropzone("form#taskForm", {url: '/upload_user_files/task'});
 

      

     
</script>