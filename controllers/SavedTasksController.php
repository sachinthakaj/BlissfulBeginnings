<?php

class SavedTasksController
{
    private $savedTasks;

    public function __construct()
    {
        $this->savedTasks = new savedTasks();
    }

    public function savedTasks() {
        require_once './public/savedTasks.php';
    }

    public function getSavedTasks() {
        try {
            $savedTasks = $this->savedTasks->getSavedTasks();
        } catch (Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(['error' => 'Error fetching saved tasks']);
        }
    }


}
?>