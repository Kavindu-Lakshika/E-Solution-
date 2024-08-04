<?php


class Projects
{
    public function getProjectManagers() {
        $db = new Database();

        $query = "SELECT * FROM users u INNER JOIN user_types ut on u.user_type_id = ut.user_type_id WHERE type='Project Manager'";
        $results = $db->query($query);

        $response = array();

        if ($results) {
            $pms = $db->fetchAll($results);

            $response = [
                "status" => "success",
                "message" => "Users list",
                "result" => $pms
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

    public function saveProject() {
        $pn = $_POST["pn"];
        $pm = $_POST["pm"];
        $tasks = json_decode($_POST["tasks"]);

        $response = array();

        $db = new Database();

        $query = "INSERT INTO project(name, project_manager_user_id) VALUES ('$pn', '$pm')";
        $results = $db->query($query);

        if ($results) {
            $project_id = $db->conn->insert_id;

            foreach ($tasks as $task) {
                $name = $task->task;
                $fp = $task->fp;
                $status = "On Going";

                $query = "INSERT INTO tasks(name, functional_point, project_id, status) VALUES ('$name', '$fp', '$project_id', '$status')";
                $db->query($query);
            }

            $response = [
                "status" => "success",
                "message" => "Project saved successfully",
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

    public function getAllProjects() {
        $response = array();

        $db = new Database();

        $query = "SELECT * FROM project p INNER JOIN users u on p.project_manager_user_id = u.user_id";
        $results = $db->query($query);

        if ($results) {
            $projects = $db->fetchAll($results);

            $response = [
                "status" => "success",
                "message" => "Projects list",
                "result" => $projects
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

    public function getProjDetails() {
        $response = array();

        $db = new Database();

        $pid = $_POST["pid"];

        $query = "SELECT 
ts.task_id,
ts.`name` as task_name,
ts.functional_point * emp.hourly_rate as task_cost,
ts.functional_point,
ts.status,
emp.hourly_rate,
emp.fname as emp_name,
tl.fname as team_leader
FROM tasks ts
INNER JOIN team_members tm on ts.team_member_id=tm.team_member_user_id
INNER JOIN team t on tm.team_id=t.team_id
INNER JOIN users tl on t.team_leader_user_id=tl.user_id
INNER JOIN users emp on tm.team_member_user_id=emp.user_id
INNER JOIN project p on t.project_id=p.project_id
WHERE p.project_id='$pid'";
        $results = $db->query($query);

        if ($results) {
            $tasks = $db->fetchAll($results);

            if (count($tasks) > 0) {
                $response = [
                    "status" => "success",
                    "message" => "Projects list",
                    "result" => $tasks
                ];
            } else {
                $response = [
                    "status" => "error",
                    "message" => "No data available on this project",
                    "result" => []
                ];
            }
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