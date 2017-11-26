<?php namespace LaravelRealtimeChat\Repositories\Task;

interface TaskRepository  {

   
    public function createProject();
    
    
    public function getProjects();
    
    
    public function getTracker();
    
    
    public function getStatus();
    
    
    public function getPriorities();
    
    
    public function createTask();
    
    public function rollBackTask();
    
    public function filterDashboard();
    
    public function filterGrid();

    public function getTaskData();
    
    public function saveTaskFiles($fileName);
      
    public function getUpdates($parent_task_id);
    
    public function getProjectTeams($id);
}
