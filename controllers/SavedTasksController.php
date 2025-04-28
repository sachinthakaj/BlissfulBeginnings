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
            $result = $this->savedTasks->getSavedTasks();
            if($result) {
                header("Content-Type: application/json; charset=utf-8");
                header("HTTP/1.1 200 Okay");
                echo json_encode($result);
            } else {
                header('HTTP/1.1 404 Unauthorized');
                echo json_encode(['error' => 'No features inserted']);
            }
            
        } catch (Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(['error' => 'Error fetching saved tasks']);
        }
    }

    public function addNewGroup() {
        try {
            $data = file_get_contents('php://input');
            $data = json_decode($data);
            
            $result = $this->savedTasks->addNewGroup($data->savedTaskGroupName, $data->typeID);
            if($result) {
                header("Content-Type: application/json; charset=utf-8");
                header("HTTP/1.1 200 Okay");
                echo json_encode(['message' => 'Group Created Successfully']);
            } else {
                header('HTTP/1.1 404 Unauthorized');
                echo json_encode(['error' => 'No features inserted']);
            }

        } catch (Exception $e) {
            header('HTTP/1.1 Internal Server Error');
            echo json_encode(['error' => 'Error creating new group']);
        }
    }


}
?>