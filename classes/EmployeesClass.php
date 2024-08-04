<?php
//require 'Database.php';

class Employees
{
    public function getUserTypes()
    {
        // Create a new database object
        $db = new Database();
        $query = "SELECT * FROM user_types";

        // Execute the query and retrieve the results
        $result = $db->query($query);
        $types = $db->fetchAll($result);
        echo json_encode($types);
    }

    public function saveEmployee()
    {
        $formData = $_POST;

        $fn = $formData["fn"];
        $ln = $formData["ln"];
        $un = $formData["un"];
        $pw = md5($formData["pw"]);
        $hr = $formData["hr"];
        $ut = $formData["ut"];

        $db = new Database();
        $query = "SELECT * FROM users WHERE un='$un'";
        $results = $db->query($query);
        $users = $db->fetchAll($results);

        $response = array();

        if (count($users) > 0) {
            $response = [
                "status" => "error",
                "message" => "Username already exists",
                "result" => []
            ];
        } else {
            $query = "INSERT INTO users(fname, lname, un, pw, hourly_rate, user_type_id) VALUES ('$fn', '$ln', '$un', '$pw', '$hr', '$ut')";
            $results = $db->query($query);

            if ($results) {
                $response = [
                    "status" => "success",
                    "message" => "Employee successfully saved",
                    "result" => []
                ];
            } else {
                $response = [
                    "status" => "error",
                    "message" => "Something went wrong, try again later",
                    "result" => []
                ];
            }
        }

        echo json_encode($response);
    }

    public function updateEmployee() {
        $formData = $_POST;

        $id = $formData["user_id"];
        $fn = $formData["fn"];
        $ln = $formData["ln"];
        $un = $formData["un"];
        $pw = $formData["pw"];
        $hr = $formData["hr"];
        $ut = $formData["ut"];

        $db = new Database();
        $query = '';

        if ($pw != "" || $pw != null) {
            $query = "UPDATE users SET fname='$fn', lname='$ln', un='$un', hourly_rate='$hr', user_type_id='$ut', pw='". md5($pw) ."' WHERE user_id='$id'";
        } else {
            $query = "UPDATE users SET fname='$fn', lname='$ln', un='$un', hourly_rate='$hr', user_type_id='$ut' WHERE user_id='$id'";
        }

        $results = $db->query($query);

        $response = array();

        if ($results) {
            $response = [
                "status" => "success",
                "message" => "Employee updated successfully",
                "result" => []
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Something went wrong, try again later",
                "result" => []
            ];
        }

        echo json_encode($response);
    }

    public function deleteEmployee() {
        $id = $_POST["id"];
        $db = new Database();
        $query = "DELETE FROM users WHERE user_id='$id'";
        $results = $db->query($query);

        if ($results) {
            $response = [
                "status" => "success",
                "message" => "Employee deleted successfully",
                "result" => []
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Something went wrong, try again later",
                "result" => []
            ];
        }

        echo json_encode($response);
    }

    public function getAllUsers()
    {
        try {
            $db = new Database();
            $query = "SELECT CONCAT_WS(' ', u.fname, u.lname) as name, u.fname, u.lname, u.un, u.hourly_rate, u.user_id, ut.* FROM users u INNER JOIN user_types ut on u.user_type_id = ut.user_type_id";
            $results = $db->query($query);

            $response = array();

            if ($results) {
                $users = $db->fetchAll($results);

                $response = [
                    "status" => "success",
                    "message" => "Users list",
                    "result" => $users
                ];
            } else {
                $response = [
                    "status" => "error",
                    "message" => "Something went wrong, try again later",
                    "result" => []
                ];
            }

            echo json_encode($response);
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => $e,
                "result" => []
            ];

            echo json_encode($response);
        }
    }
}