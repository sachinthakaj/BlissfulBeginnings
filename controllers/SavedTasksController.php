<?php

class SavedTasksController
{
    private $calendarModel;

    public function __construct()
    {
        $this->calendarModel = new Calendar();
    }

    public function savedTasks() {
        require_once './public/savedTasks.php';
    }



}
?>