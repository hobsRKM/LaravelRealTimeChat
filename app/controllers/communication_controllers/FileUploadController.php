<?php
use LaravelRealtimeChat\Repositories\Team\TeamRepository;
use LaravelRealtimeChat\Repositories\Task\TaskRepository;
class FileUploadController extends AuthController {
  private $taskRepository;

        public function __construct(TeamRepository $teamRepository, TaskRepository $taskRepository) {
                $this->teamRepository = $teamRepository;
                $this->taskRepository = $taskRepository;
        }
        public function uploadFiles($name) {

                switch ($name) {
                        case "chat":$folderName = "userUploads";
                                $this->validateAndUpload($folderName,false);//set true for db operations,else false
                                break;

                        case "task":$folderName = "userTaskFiles";
                                $this->validateAndUpload($folderName,true);
                                break;
                }
        }


 function validateAndUpload($folderName,$dbSave) {
        $successStatus;
        $fileErr;
        // Build the input for our validation
        $input      = Input::all();
        // Within the ruleset, make sure we let the validator know that this
        // file should be an image
        $rules      = array(
             'file' => 'max:100000000',
        );
        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
                return Response::make($validation->errors->first(), 400);
        }

        $file = Input::file('file');
        foreach ($file as $files) {

                $upload_success = $files->move('fusionmate/public/plugins/' . $folderName . '', $files->getClientOriginalName());

                $imgPath = $files->getClientOriginalName();

                if ($upload_success) {
                        if($dbSave){
                             $this->taskRepository->saveTaskFiles($imgPath);   
                        }
                        $fileErr = false;
                }
                else {
                        $fileErr = true;
                }
        }
        if (!$fileErr) {

                $successStatus = Response::json('success', 200);
        }
        else {
                $successStatus = Response::json('error', 400);
        }
        return $successStatus;
}
}