<?php
class Home extends Controller
{

    function Show()
    {
        $taskModel = $this->model("Task");
        $tasks = $taskModel->getAllTasks();
        $this->view("app", [
            "tasks" => json_encode($tasks)
        ]);
    }
    public function createTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventDate = explode("-", filter_var(trim($_POST["event_date"])));
            $title = $_POST['title'];
            $status = $_POST['status'];
            $start_date = date('Y-m-d H:i:s', strtotime($eventDate[0]));
            $end_date = date('Y-m-d H:i:s', strtotime($eventDate[1]));
            $now = date('Y-m-d H:i:s', time());
            $data = array(
                'title' => $title,
                'start' => $start_date,
                'end' => $end_date,
                'status' => $status,
                'created_at' => $now,
                'updated_at' => $now
            );
            $taskModel = $this->model("Task");
            $taskModel->insert('tasks', $data);
            echo "<meta http-equiv='refresh' content='0'>";

        }
    }
    public function updateTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventDate = explode("-", filter_var(trim($_POST["event_date"])));
            $id = intval($_POST['id']);
            $title = $_POST['title'];
            $status = $_POST['status'];
            $start_date = date('Y-m-d H:i:s', strtotime($eventDate[0]));
            $end_date = date('Y-m-d H:i:s', strtotime($eventDate[1]));
            $now = date('Y-m-d H:i:s', time());
            $data = array(
                'title' => $title,
                'start' => $start_date,
                'end' => $end_date,
                'status' => $status,
                'created_at' => $now,
                'updated_at' => $now
            );
            $taskModel = $this->model("Task");
            $taskModel->update('tasks', $data, $id);
            echo "<meta http-equiv='refresh' content='0'>";

        }
    }
    public function deleteTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $taskModel = $this->model("Task");
            $taskModel->delete('tasks', $id);

        }
    }
}
?>