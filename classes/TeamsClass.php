<?php


class Teams
{
    public function getEmployees()
    {
        $db = new Database();

        $query = "SELECT *  FROM sad.users u LEFT JOIN sad.team_members tm ON u.user_id = tm.team_member_user_id JOIN sad.user_types ut ON u.user_type_id = ut.user_type_id WHERE ut.type = 'Employee' AND tm.team_member_id IS NULL;";
        $results = $db->query($query);

        $response = array();

        if ($results) {
            $employees = $db->fetchAll($results);

            $response = [
                "status" => "success",
                "message" => "Users list",
                "result" => $employees
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

    public function getTeamLeaders()
    {
        $db = new Database();

        $query = "SELECT * FROM users u INNER JOIN user_types ut on u.user_type_id = ut.user_type_id WHERE type='Team Leader'";
        $results = $db->query($query);

        $response = array();

        if ($results) {
            $tls = $db->fetchAll($results);

            $response = [
                "status" => "success",
                "message" => "Users list",
                "result" => $tls
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

    public function saveTeam()
    {
        $p = $_POST["p"];
        $tl = $_POST["tl"];
        $members = json_decode($_POST["members"]);

        $response = array();

        $db = new Database();

        $query = "INSERT INTO team(team_leader_user_id, project_id) VALUES ('$tl', '$p')";
        $results = $db->query($query);

        if ($results) {
            $team_id = $db->conn->insert_id;

            foreach ($members as $member) {
                $id = $member;

                $query = "INSERT INTO team_members(team_member_user_id, team_id) VALUES ('$id', '$team_id')";
                $db->query($query);
            }

            $response = [
                "status" => "success",
                "message" => "Team saved successfully",
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

    public function getAllTeams()
    {
        $response = array();

        $db = new Database();

        $query = "SELECT t.team_id, p.name, u1.fname as team_leader_fname, u2.fname as project_manager_fname, 
GROUP_CONCAT(u3.fname SEPARATOR ', ') as team_members_fname
FROM team t
INNER JOIN users u1 ON t.team_leader_user_id = u1.user_id
INNER JOIN project p ON t.project_id = p.project_id
INNER JOIN users u2 ON p.project_manager_user_id = u2.user_id
INNER JOIN team_members tm ON tm.team_id = t.team_id
INNER JOIN users u3 ON tm.team_member_user_id = u3.user_id
GROUP BY t.team_id";
        $results = $db->query($query);

        if ($results) {
            $teams = $db->fetchAll($results);

            $response = [
                "status" => "success",
                "message" => "Team saved successfully",
                "result" => $teams
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

    public function getPmData()
    {
        $db = new Database();
        $response = array();

        session_start();

        $user_id = $_SESSION["user_id"];

        $proj_query = "SELECT * FROM project WHERE project_manager_user_id='$user_id'";
        $proj_result = $db->query($proj_query);

        $team_query = "SELECT * FROM team";
        $team_result = $db->query($team_query);

        $task_query = "SELECT * FROM tasks WHERE team_id IS NULL";
        $task_result = $db->query($task_query);

        if ($proj_result && $team_result && $task_result) {
            $projects = $db->fetchAll($proj_result);
            $teams = $db->fetchAll($team_result);
            $tasks = $db->fetchAll($task_result);

            $result = [
                "projects" => $projects,
                "teams" => $teams,
                "tasks" => $tasks
            ];

            $response = [
                "status" => "success",
                "message" => "Team saved successfully",
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

    public function setTaskTeam()
    {
        $t = $_POST["t"];
        $ts = json_decode($_POST["ts"]);

        $response = array();

        $db = new Database();
        $result = null;

        foreach ($ts as $task) {
            $query = "UPDATE tasks SET team_id='$t' WHERE task_id='$task'";
            $result = $db->query($query);
        }

        if ($result) {
            $response = [
                "status" => "success",
                "message" => "Team updated successfully",
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

    public function getPmTasks()
    {
        $db = new Database();
        $response = array();

        session_start();

        $user_id = $_SESSION["user_id"];

        $query = "SELECT p.`name` as project_name, tm.*
FROM team t
INNER JOIN users u1 ON t.team_leader_user_id = u1.user_id
INNER JOIN project p ON t.project_id = p.project_id
INNER JOIN users u2 ON p.project_manager_user_id = u2.user_id
INNER JOIN tasks tm ON tm.team_id = t.team_id
WHERE u2.user_id='$user_id'
GROUP BY tm.task_id";
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
}