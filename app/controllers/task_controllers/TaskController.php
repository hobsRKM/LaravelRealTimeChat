<?php

use LaravelRealtimeChat\Repositories\Team\TeamRepository;
use LaravelRealtimeChat\Repositories\Task\TaskRepository;
class TaskController extends BaseController {
        /**
         * @var LaravelRealtimeChat\Repositories\TeamRepository
         */
        private $teamRepository;
        /**
         * @var LaravelRealtimeChat\Repositories\TaskRepository
         */
        private $taskRepository;

        public function __construct(TeamRepository $teamRepository, TaskRepository $taskRepository) {
                $this->teamRepository = $teamRepository;
                $this->taskRepository = $taskRepository;
        }

        public function dashboard() {
                $channeld = Session::get('channelId');
                $teams    = $this->teamRepository->getTeams($channeld);
                $projects = $this->taskRepository->getProjects();
                $trackers = $this->taskRepository->getTracker();
                $status = $this->taskRepository->getStatus();
                $priotities = $this->taskRepository->getPriorities();
                $data     = array("teams" => $teams, "projects" => $projects,"trackers"=>$trackers,"status"=>$status,"priorities"=>$priotities);
              
                return View::make('templates/task/dashboard')->with('data', $data);
        }

        /**
         *  @function creates project
          @param null
          @return null
         */
        public function create_project() {
                $result = $this->taskRepository->createProject();
                return View::make('templates/greeting')->with('info', $result);
        }
        
         /**
         *  @function creates task
          @param null
          @return null
         */
        public function create_task() {
                $result = $this->taskRepository->createTask();
                return $result;
        }
        
        
        /**
         *  @function returns members
          @param null
          @return null
         */
        public function get_members() {
                $enTeamId=Input::get("teamId");
                $teamId=$this->teamRepository->getTeamDecodedId($enTeamId);
                $members = $this->teamRepository->getMembers($teamId);
                /*
                 * Prepare html select options
                 */
                
                $data='';
                $data.="<option value=''>Select User</option>";
                foreach($members as $values){
                        $memDetail=explode("_",$values);
                        $data.="<option value=".$memDetail[2].">".$memDetail[0]." ".$memDetail[1]."</option>";
                }
                return trim($data,'"');
        }
        
        /**
         *  @function rollback task
          @param null
          @return null
         */
        public function rollback_task() {
                $result = $this->taskRepository->rollBackTask();
                return $result;
        }
        
          /**
         *  @function filter dashboard data
          @param null
          @return array dashboard data
         */
        public function filter_dashboard() {
                $result = $this->taskRepository->filterDashboard();
                return $result;
        }
        
          /**
         *  @function filter grid data
          @param null
          @return array grid data
         */
        public function filter_grid() {
                $page = \Input::get('current');
                $rowCount = \Input::get('rowCount');
                
                $total='';
                $result = $this->taskRepository->filterGrid();
                foreach($result as $values){
                       $rows[]=array('un_id'=>$values['un_id'],
                            'priority_name'=>$values['priority_name'],
                            'status_name'=>$values['status_name'],
                            'tracker'=>$values['tracker'],
                            'assignee'=>$values['first_name']." ".$values['last_name'],
                            'created_at'=>$values['created_at'],
                            'start_date'=>$values['start_date'],
                             'end_date'=>$values['end_date']) ;
                }
                $data=array('current'=>$page,'rowCount'=>$rowCount,'rows'=>$rows,'total'=>count($rows));
                return json_encode($data);
        }
        
        /**  @function opens exisiting task
          @param null
          @return html view
         */
        public function view_assignment() {
                $trackers = $this->taskRepository->getTracker();
                $status = $this->taskRepository->getStatus();
                $priotities = $this->taskRepository->getPriorities();
                $taskData = $this->taskRepository->getTaskData();
                $members = $this->teamRepository->getMembers($taskData['team_id']);
                $data     = array("trackers"=>$trackers,"status"=>$status,"priorities"=>$priotities,'members'=>$members,'task_data'=>$taskData);
                return View::make('templates/task/create_task_modal')->with('data', $data);
        }
        
        /**  @function list of previous updates on a task
          @param task parent id
          @return html view
         */
        public function recent_updates($parent_task_id) {
                $result=$this->taskRepository->getUpdates($parent_task_id);
                return View::make('templates/task/recent_task_updates')->with("result",$result);
        }
        
        
          /**  @function list of previous updates on a task
          @param task parent id
          @return html view
         */
        public function get_project_teams() {
                $result=$this->taskRepository->getProjectTeams(Input::get('projectId'));
                $data='';
                $data.="<option value=''>Select Team</option>";
                foreach($result as $teamDetail){
                       
                        $data.="<option value=".$teamDetail['team_channel_id'].">".$teamDetail['channel_view_name']."</option>";
                }
                return trim($data,'"');
        }
}