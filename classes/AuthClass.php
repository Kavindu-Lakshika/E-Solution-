<?php
require 'Database.php';

class Auth
{
    public function loginAction()
    {
        // Create a new database object
        $db = new Database();

        // Retrieve the username and password from the POST request
        $un = $_POST['un'];
        $pw = md5($_POST['pw']);

        // Construct a query to select a user with the matching username and password
        $query = "SELECT * FROM users INNER JOIN user_types ON users.user_type_id = user_types.user_type_id WHERE un='$un' AND pw='$pw'";

        // Execute the query and retrieve the results
        $result = $db->query($query);
        $users = $db->fetchAll($result);

        // If there are any matching users, set session variables and redirect to the home page
        if (count($users) > 0) {
            session_start();
            $_SESSION['logged_in'] = '1';
            $_SESSION['user_id'] = $users[0]['user_id'];
            $_SESSION['name'] = $users[0]['fname'] . ' ' . $users[0]['lname'];
            $_SESSION['type'] = $users[0]['type'];
            header('Location: /home');
        } else { // If there are no matching users, set an error message in the session and redirect back to the login page
            $_SESSION['error'] = "Incorrect username or password";
            header('Location: /');
        }
        exit;
    }

    public function logoutAction()
    {
        // Destroy the current session
        session_start();
        session_destroy();
        // Redirect the user to the login
        header('Location: /');
        exit;
    }
}
