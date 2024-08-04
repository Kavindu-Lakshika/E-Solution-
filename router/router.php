<?php
require 'classes/AuthClass.php';
require 'classes/RouterClass.php';
require 'classes/EmployeesClass.php';
require 'classes/ProjectsClass.php';
require 'classes/TeamsClass.php';
require 'classes/TasksClass.php';

$url = $_SERVER['REQUEST_URI'];
$authClass = new Auth();
$routerClass = new Router();
$empClass = new Employees();
$projClass = new Projects();
$teamClass = new Teams();
$taskClass = new Tasks();

switch ($url) {
    case '/':
        $routerClass->displayLogin();
        break;
    case '/home':
        $routerClass->displayHome();
        break;
    case '/login_action':
        $authClass->loginAction();
        break;
    case '/logout':
        $authClass->logoutAction();
        break;
    case '/get_user_types':
        $empClass->getUserTypes();
        break;
    case '/save_user':
        $empClass->saveEmployee();
        break;
    case '/update_user':
        $empClass->updateEmployee();
        break;
    case '/delete_user':
        $empClass->deleteEmployee();
        break;
    case '/get_all_users':
        $empClass->getAllUsers();
        break;
    case '/get_pms':
        $projClass->getProjectManagers();
        break;
    case '/save_proj':
        $projClass->saveProject();
        break;
    case '/get_all_proj':
        $projClass->getAllProjects();
        break;
    case '/get_project':
        $projClass->getProjDetails();
        break;
    case '/get_employees':
        $teamClass->getEmployees();
        break;
    case '/get_tls':
        $teamClass->getTeamLeaders();
        break;
    case '/save_team':
        $teamClass->saveTeam();
        break;
    case '/get_all_teams':
        $teamClass->getAllTeams();
        break;
    case '/get_pm_data':
        $teamClass->getPmData();
        break;
    case '/set_task_team':
        $teamClass->setTaskTeam();
        break;
    case '/get_pm_tasks':
        $teamClass->getPmTasks();
        break;
    case '/get_tl_data':
        $taskClass->getTlData();
        break;
    case '/set_task_mem':
        $taskClass->setTaskMember();
        break;
    case '/get_tl_tasks':
        $taskClass->getTlTasks();
        break;
    case '/get_emp_tasks':
        $taskClass->getempTasks();
        break;
    case '/update_task':
        $taskClass->updateStatus();
        break;
}