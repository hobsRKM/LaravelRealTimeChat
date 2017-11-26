<?php

namespace LaravelRealtimeChat\Repositories\Task;

use LaravelRealtimeChat\Repositories\Team\TeamRepository;

class DbTaskRepository implements TaskRepository {

    /**
     * @function creates project
     * @param null
     * @return null
     */
    public function __construct(TeamRepository $teamRepository) {
        $this->teamRepository = $teamRepository;
    }

    public function createProject() {
        $project = \Input::get("project");
        $teamEnId = \Input::get("team");

        /*
         * Check if prjoject is already created by admin
         * 
         */
        $projects = \DB::table('projects')
                        ->select('projects.*')
                        ->leftJoin('team_heads', 'projects.un_id', '=', 'team_heads.project_id')
                        ->where('projects.project_name', '=', $project)
                        ->where('team_heads.author_id', '=', \Auth::user()->id)->first();
        if (count($projects) == 0) {



            $team = $this->teamRepository->getTeamDecodedId($teamEnId);

            $id = generateId();
            try {
                //insert project
                $lastId = \DB::table('projects')->insertGetId(
                        ['un_id' => $id, "project_name" => $project]
                );
                $lastId = \DB::table('projects')
                                ->select('un_id')
                                ->where('id', '=', $lastId)->first();
                $lastId = $lastId['un_id'];
            } catch (\Exception $e) {
                //coudnt insert
                return "Server Error Occurred while processiong your request!";
            }

            try {
                //get the id of the team head before assigning project
                $user_id = \DB::table('team_heads')
                        ->select('team_heads.user_id')
                        ->where('team_heads.team_id', '=', $team)
                        ->whereNull('team_heads.project_id')
                        ->first();
                if (count($user_id) > 0) {
                    \DB::table('team_heads')
                            ->where('team_id', '=', $team)
                            ->where('user_id', '=', $user_id['user_id'])
                            ->whereNull('team_heads.project_id')
                            ->update(array('project_id' => $lastId));
//                    \DB::table('team_heads')->insertGetId(
//                            ['project_id' => $lastId, "team_id" => $team, 'author_id' => \Session::get("userId"), "user_id" => $user_id['user_id']]
//                    );
                } else {
                    \DB::table('team_heads')->insertGetId(
                            ['project_id' => $lastId, "team_id" => $team, 'author_id' => \Session::get("userId"), "user_id" => \Session::get("userId")]
                    );
                }
                return "Project Created Successfully";
            } catch (\Exception $e) {
                //coudnt insert
                return "Server Error Occurred while processiong your request!";
            }
        } else {
            return "You have already created this project!";
        }
    }

    /**
     * @function gets array of projects created
     * @param null
     * @return array of projects
     */
    public function getProjects() {
        /*
         * Get all created projects for  teams where logged in user is a member
         */
        $projects = \DB::table('projects')
                        ->select('projects.*')
                        ->leftJoin('team_heads', 'projects.un_id', '=', 'team_heads.project_id')
                        ->leftJoin('team_channel_users', 'team_channel_users.team_channel_name_id', '=', 'team_heads.team_id')
                        ->where('team_channel_users.user_id', '=', \Auth::user()->id)->get();

        return $projects;
    }

    public function getTracker() {
        $trackers = \DB::table('tracker')
                ->select('un_id', 'name')
                ->get();
        return $trackers;
    }

    public function getStatus() {
        $status = \DB::table('tracker_status_names')
                ->select('un_id', 'name')
                ->get();
        return $status;
    }

    public function getPriorities() {
        $priorities = \DB::table('tracker_priority')
                ->select('un_id', 'name')
                ->get();
        return $priorities;
    }

    public function createTask() {
        $rules = array(
            'tracker' => 'required',
            'status' => 'required',
            'priority' => 'required',
            'assignee' => 'required',
            'startDate' => 'required',
            'subject' => 'required|min:3'
        );
        $messages = array(
            'tracker.required' => 'trackerErr',
            'status.required' => 'statusErr',
            'priority.required' => 'priorityErr',
            'subject.required' => 'subjectErr',
            'assignee.required' => 'assigneeErr',
            'startDate.required' => 'startDateErr',
            'subject.min' => 'subjectMinErr',
        );
        $validator = \Validator::make(\Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return \Response::json([
                        'success' => false,
                        'result' => $validator->messages()
            ]);
        }
        $id = generateId();
        $trackerId = \Input::get("tracker");
        $statusId = \Input::get("status");
        $priorityId = \Input::get("priority");
        $subject = \Input::get("subject");
        $assigneeId = \Input::get("assignee");
        $startDate = \Input::get("startDate");
        $endDate = \Input::get("endDate");
        $description = \Input::get("description");
        $projectId = \Input::get("projectId");
        $taskId = \Input::get("taskId");
        $teamId = $this->teamRepository->getTeamDecodedId(\Input::get("teamId"));
        try {
            //insert task
            $lastId = \DB::table('task_activities')->insertGetId(
                    ['un_id' => $id,
                        "tracker_id" => $trackerId,
                        "tracker_status_id" => $statusId,
                        "tracker_priority_id" => $priorityId,
                        "tracker_subject" => $subject,
                        "project_id" => $projectId,
                        "team_id" => $teamId,
                        "start_date" => $startDate,
                        "end_date" => $endDate,
                        "user_id" => $assigneeId]
            );
            $lastUnId = \DB::table('task_activities')
                    ->select('un_id')
                    ->where('id', '=', $lastId)
                    ->first();
            $lastDescId = \DB::table('tracker_description')->insertGetId(
                    ['un_id' => generateId(),
                        "tracker_activity_un_id" => $lastUnId['un_id'],
                        "description" => $description,
                    ]
            );
            if ($taskId == '')
                $taskId = $lastUnId['un_id'];
            \DB::table('task_updated_activities')->insertGetId(
                    ['un_id' => generateId(),
                        "tracker_activity_un_id" => $lastUnId['un_id'],
                        "parent_tracker_activity_un_id" => $taskId,
                    ]
            );
        } catch (\Exception $e) {
//                                coudnt insert
            return \Response::json([
                        'error' => true,
            ]);
        }
        return \Response::json([
                    'success' => true,
                    'last_id' => $lastId,
                    'last_desc_id' => $lastDescId,
        ]);
    }

    public function rollBackTask() {
        $id = \Input::get('last_id');
        $descId = \Input::get('last_desc_id');
        \DB::table('task_activities')->where('id', '=', $id)->delete();
        \DB::table('tracker_description')->where('id', '=', $descId)->delete();
    }

    public function filterDashboard() {
        $teamId = $this->teamRepository->getTeamDecodedId(\Input::get("teamId"));
        $projectId = \Input::get('projectId');
        $dashboardCount = \DB::table('task_updated_activities')
                        ->select(\DB::raw('count(tracker_status_names.name) as count,tracker_status_names.name'))
                        ->leftJoin('task_activities', 'task_activities.un_id', '=', 'task_updated_activities.tracker_activity_un_id')
                        ->leftJoin('tracker', 'tracker.un_id', '=', 'task_activities.tracker_id')
                        ->leftJoin('tracker_priority', 'tracker_priority.un_id', '=', 'task_activities.tracker_priority_id')
                        ->leftJoin('tracker_status_names', 'tracker_status_names.un_id', '=', 'task_activities.tracker_status_id')
                        ->leftJoin('users', 'users.id', '=', 'task_activities.user_id')
                        ->where('task_activities.user_id', '=', \Auth::user()->id)
                        ->whereIn('task_updated_activities.id', function($query) {
                            $query->select(\DB::raw('MAX(id)'))
                            ->from('task_updated_activities')
                            ->groupBy('task_updated_activities.parent_tracker_activity_un_id');
                        })
                        ->where('task_activities.project_id', '=', $projectId)
                        ->where('task_activities.team_id', '=', $teamId)->groupBy('tracker_status_names.name')->get();


        $allCount = \DB::table('task_updated_activities')
                        ->select(\DB::raw('count(*) as allCount'))
                        ->leftJoin('task_activities', 'task_activities.un_id', '=', 'task_updated_activities.tracker_activity_un_id')
                        ->leftJoin('tracker', 'tracker.un_id', '=', 'task_activities.tracker_id')
                        ->leftJoin('tracker_priority', 'tracker_priority.un_id', '=', 'task_activities.tracker_priority_id')
                        ->leftJoin('tracker_status_names', 'tracker_status_names.un_id', '=', 'task_activities.tracker_status_id')
                        ->leftJoin('users', 'users.id', '=', 'task_activities.user_id')
                        ->where('task_activities.user_id', '=', \Auth::user()->id)
                        ->whereIn('task_updated_activities.id', function($query) {
                            $query->select(\DB::raw('MAX(id)'))
                            ->from('task_updated_activities')
                            ->groupBy('task_updated_activities.parent_tracker_activity_un_id');
                        })
                        ->where('task_activities.project_id', '=', $projectId)
                        ->where('task_activities.team_id', '=', $teamId)->first();
        $dashboardCount['allCount'] = $allCount['allCount'];
        return $dashboardCount;
    }

    public function filterGrid() {
        $teamId = $this->teamRepository->getTeamDecodedId(\Input::get("teamId"));
        $page = \Input::get('current');
        $rowCount = \Input::get('rowCount');
        $searchPhrase = \Input::get('searchPhrase');
        $limit = $rowCount * $page;
        $offset = $rowCount * ($page - 1);
        $projectId = \Input::get('projectId');
        $data = \DB::table('task_updated_activities')
                ->select('task_activities.un_id', 'tracker_priority.name as priority_name', 'tracker_status_names.name as status_name', 'tracker.name as tracker', 'users.first_name', 'users.last_name', 'task_activities.created_at', 'task_activities.start_date', 'task_activities.end_date')
                ->leftJoin('task_activities', 'task_activities.un_id', '=', 'task_updated_activities.tracker_activity_un_id')
                ->leftJoin('tracker', 'tracker.un_id', '=', 'task_activities.tracker_id')
                ->leftJoin('tracker_priority', 'tracker_priority.un_id', '=', 'task_activities.tracker_priority_id')
                ->leftJoin('tracker_status_names', 'tracker_status_names.un_id', '=', 'task_activities.tracker_status_id')
                ->leftJoin('users', 'users.id', '=', 'task_activities.user_id')
                ->where('task_activities.user_id', '=', \Auth::user()->id)
                ->whereIn('task_updated_activities.id', function($query) {
                    $query->select(\DB::raw('MAX(id)'))
                    ->from('task_updated_activities')
                    ->groupBy('task_updated_activities.parent_tracker_activity_un_id');
                })
                ->where('task_activities.project_id', '=', $projectId)
                ->where('task_activities.team_id', '=', $teamId);
        if ($searchPhrase != '') {
            $data->whereRaw(\DB::raw("(tracker_priority.name like  '%$searchPhrase%' OR tracker_status_names.name like  '%$searchPhrase%' OR tracker.name like  '%$searchPhrase%' OR users.first_name like  '%$searchPhrase%' OR users.last_name like  '%$searchPhrase%') "));
        }

        $result = $data->skip($offset)->take($limit)->get();
        return $result;
    }

    public function getTaskData() {
        $taskId = \Input::get('id');
        $result = \DB::table('task_activities')
                ->select('task_updated_activities.parent_tracker_activity_un_id', 'task_activities.un_id', 'tracker_priority.name as priority_name', 'tracker_status_names.name as status_name', 'tracker.name as tracker', 'users.first_name', 'users.id as main_user_id', 'users.last_name', 'task_activities.created_at', 'task_activities.start_date', 'task_activities.end_date', 'tracker_description.description', 'task_activities.team_id', 'task_activities.tracker_subject')
                ->leftJoin('task_updated_activities', 'task_updated_activities.tracker_activity_un_id', '=', 'task_activities.un_id')
                ->leftJoin('tracker', 'tracker.un_id', '=', 'task_activities.tracker_id')
                ->leftJoin('tracker_priority', 'tracker_priority.un_id', '=', 'task_activities.tracker_priority_id')
                ->leftJoin('tracker_status_names', 'tracker_status_names.un_id', '=', 'task_activities.tracker_status_id')
                ->leftJoin('tracker_description', 'tracker_description.tracker_activity_un_id', '=', 'task_activities.un_id')
               
                ->leftJoin('users', 'users.id', '=', 'task_activities.user_id')
                ->where('task_activities.un_id', '=', $taskId)
                ->first();


            $files = \DB::table('task_activities')
                    ->select('tracker_files.file_name')
                     ->leftJoin('tracker_files', 'tracker_files.tracker_activity_un_id', '=', 'task_activities.un_id')
                    ->where('tracker_files.tracker_activity_un_id', '=', $result['un_id'])
                    ->get();
           
            foreach ($files as $file_name) {
                $result['file_name'][] = $file_name['file_name'];
            }
            $row=$result;

        return $row;
    }

    public function saveTaskFiles($fileName) {
        $lastUnId = \DB::table('task_activities')
                ->select('un_id')
                ->orderBy('id', 'desc')
                ->first();
        \DB::table('tracker_files')->insertGetId(
                ['un_id' => generateId(),
                    "tracker_activity_un_id" => $lastUnId['un_id'],
                    "file_name" => $fileName,
                ]
        );
    }

    public function getUpdates($parent_task_id) {
        $data = \DB::table('task_activities')
                        ->select('task_activities.id', 'task_updated_activities.parent_tracker_activity_un_id', 'task_updated_activities.tracker_activity_un_id', 'task_activities.un_id', 'tracker_priority.name as priority_name', 'tracker_status_names.name as status_name', 'tracker.name as tracker', 'users.first_name', 'users.id as main_user_id', 'users.last_name', 'task_activities.created_at', 'task_activities.start_date', 'task_activities.end_date', 'tracker_description.description', 'task_activities.team_id', 'task_activities.tracker_subject', 'task_activities.un_id as main_un_id')
                        ->leftJoin('task_updated_activities', 'task_updated_activities.tracker_activity_un_id', '=', 'task_activities.un_id')
                        ->leftJoin('tracker', 'tracker.un_id', '=', 'task_activities.tracker_id')
                        ->leftJoin('tracker_priority', 'tracker_priority.un_id', '=', 'task_activities.tracker_priority_id')
                        ->leftJoin('tracker_status_names', 'tracker_status_names.un_id', '=', 'task_activities.tracker_status_id')
                        ->leftJoin('tracker_description', 'tracker_description.tracker_activity_un_id', '=', 'task_activities.un_id')
                        ->leftJoin('users', 'users.id', '=', 'task_activities.user_id')
                        ->where('task_updated_activities.parent_tracker_activity_un_id', '=', $parent_task_id)
                        ->distinct()->get();

        foreach ($data as $key => $values) {

            $files = \DB::table('task_activities')
                    ->select('tracker_files.file_name', 'tracker_files.tracker_activity_un_id')
                    ->leftJoin('tracker_files', 'tracker_files.tracker_activity_un_id', '=', 'task_activities.un_id')
                    ->where('tracker_files.tracker_activity_un_id', '=', $values['tracker_activity_un_id'])
                    ->get();
            foreach ($files as $file_name) {
                $values['file_name'][] = $file_name['file_name'];
            }
            $row[]=$values;
        }


        return $row;
    }
    
    function getProjectTeams($id){
        $teams = \DB::table('team_channels')
                        ->select('team_channels.channel_view_name', 'team_channels.team_channel_id', 'team_channels.id', 'team_channels.created_at','team_heads.user_id')
                        ->leftJoin('team_channel_users', 'team_channel_users.team_channel_name_id', '=', 'team_channels.id')
                        ->leftJoin('team_heads', 'team_heads.team_id', '=', 'team_channels.id')
                        ->where('team_heads.project_id', '=', $id)
                        ->where('team_channel_users.user_id', '=', \Auth::user()->id)->distinct()->get();
        return $teams;
    }

}
