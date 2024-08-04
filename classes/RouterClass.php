<?php

class Router
{
    function isLoggedIn() {
        $loggedIn = false;

        session_start();

        if (isset($_SESSION['logged_in'])) {
            $loggedIn = true;
        }

        return $loggedIn;
    }

    function displayLogin() {
        if ($this->isLoggedIn()) {
            header('Location: /home');
            exit();
        } else {
            include 'login.php';
        }
    }

    function displayHome() {
        if ($this->isLoggedIn()) {
            if ($_SESSION['type'] == "Project Director") {
                include 'home_director.php';
            } else if ($_SESSION['type'] == "Project Manager") {
                include 'home_manager.php';
            } else if ($_SESSION['type'] == "Team Leader") {
                include 'home_leader.php';
            } else if ($_SESSION['type'] == "Employee") {
                include 'home_emp.php';
            }
        } else {
            header('Location: /');
            exit();
        }
    }
}