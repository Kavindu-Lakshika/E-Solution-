<?php


class Tasks
{
    public function getTlData()
    {
        $db = new Database();
        $response = array();

        session_start();

        $user_id = $_SESSION["user_id"];

        $q_tasks = "SELECT ts.* FROM users u INNER JOIN team t on u.user_id=t.team_leader_user_id INNER JOIN tasks ts on t.team_id=ts.team_id WHERE ts.team_member_id IS NULL AND u.user_id='$user_id'";
        $q_tresults = $db->query($q_tasks);

        $q_mems = "SELECT u2.* FROM users u INNER JOIN team t on u.user_id=t.team_leader_user_id INNER JOIN team_members tm on t.team_id=tm.team_id INNER JOIN users u2 on tm.team_member_user_id=u2.user_id INNER JOIN tasks ts on t.team_id=ts.team_id WHERE ts.team_member_id IS NULL and u.user_id='$user_id' GROUP BY tm.team_member_user_id";
        $q_mresults = $db->query($q_mems);

        if ($q_tresults && $q_mresults) {
            $tasks = $db->fetchAll($q_tresults);
            $members = $db->fetchAll($q_mresults);

            $result = [
                "tasks" => $tasks,
                "members" => $members
            ];

            $response = [
                "status" => "success",
                "message" => "Users list",
                "result" => $result
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Something went wrong, please try again",
                "result" => []
            ];
        }

        echo json_encode($response);
    }

    public function setTaskMember()
    {
        $tm = $_POST["tm"];
        $ts = json_decode($_POST["ts"]);

        $response = array();

        $db = new Database();
        $result = null;

        $query = "SET FOREIGN_KEY_CHECKS=0";
        $db->query($query);

        foreach ($ts as $task) {
            $query = "UPDATE tasks SET tasks.team_member_id='$tm' WHERE tasks.task_id='$task'";
            $result = $db->query($query);
        }

        $query = "SET FOREIGN_KEY_CHECKS=1";
        $db->query($query);
//
        if ($result) {
            $response = [
                "status" => "success",
                "message" => "Task updated successfully",
                "result" => []
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Something went wrong, please try again",
                "result" => []
            ];
        }

        echo json_encode($response);
    }

    public function getTlTasks()
    {
        $db = new Database();
        $response = array();

        session_start();

        $user_id = $_SESSION["user_id"];

        $query = "SELECT ts.`name` as task_name, ts.`status`, u2.* FROM users u
INNER JOIN team t on u.user_id=t.team_leader_user_id
INNER JOIN team_members tm on t.team_id=tm.team_id
INNER JOIN users u2 on tm.team_member_user_id=u2.user_id
INNER JOIN tasks ts on tm.team_member_user_id=ts.team_member_id
WHERE u.user_id='$user_id' GROUP BY ts.task_id";
        $results = $db->query($query);

        if ($results) {
            $tasks = $db->fetchAll($results);

            $response = [
                "status" => "success",
                "message" => "Team saved successfully",
                "result" => $tasks
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Something went wrong, please try again",
                "result" => []
            ];
        }

        echo json_encode($response);
    }

    public function getEmpTasks() {
        $db = new Database();
        $response = array();

        session_start();

        $user_id = $_SESSION["user_id"];

        $query = "SELECT * FROM tasks WHERE team_member_id='$user_id'";
        $results = $db->query($query);

        if ($results) {
            $tasks = $db->fetchAll($results);

            $response = [
                "status" => "success",
                "message" => "Team saved successfully",
                "result" => $tasks
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Something went wrong, please try again",
                "result" => []
            ];
        }

        echo json_encode($response);
    }

    public function updateStatus() {
        $db = new Database();
        $response = array();

        $tid = $_POST["tid"];
        $status = $_POST["status"];

        $query = "UPDATE tasks SET status='$status' WHERE task_id='$tid'";
        $results = $db->query($query);

        if ($results) {
            $response = [
                "status" => "success",
                "message" => "Task updated successfully",
                "result" => []
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Something went wrong, please try again",
                "result" => []
            ];
        }

        echo json_encode($response);
    }
}