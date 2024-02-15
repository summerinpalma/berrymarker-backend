<?php

declare(strict_types=1);

use Presentation\Dashboard\DashboardView;
use Presentation\Dashboard\EmailUpdate;
use Presentation\Dashboard\UsernameUpdate;
use Presentation\Dashboard\PasswordUpdate;
use Business\DashboardService;
use Business\UserService;

// COMPOSER AUTOLOAD. 
require_once('vendor/autoload.php');

session_start();

// IF THE USER SESSION COOKIE IS NOT SET REDIRECT & EXIT.
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// NORMAL DASHBOARDVIEW.
if (isset($_GET["view"]) && $_GET["view"] === "dashboard") {
    $dashboardService = new DashboardService;
    $dashboardService->getDashboardData();
    $dashboardView = new DashboardView($dashboardService);
    $dashboardView->showDashboard();

// FIRST UPDATE VIEWS.
} elseif (isset($_GET["update"])) {
    $updateType = $_GET["update"];

    // CHECK WHICH UPDATE IS REQUESTED.
    switch ($updateType) {
        case "email":
            $updateEmail = new EmailUpdate;
            $updateEmail->showEmailUpdateForm();
            break;
        case "username":
            $updateEmail = new UsernameUpdate;
            $updateEmail->showUsernameUpdateForm();
            break;
        case "password":
            $updateEmail = new PasswordUpdate;
            $updateEmail->showPasswordUpdateForm();
            break;
        default:
            // ADD ERROR PAGE IF THERE IS TIME. 
            break;
    }
    
}

    /* 
    IF THERE IS AN UPDATE IS SUBMITTED:
    CHECK FOR EMPTY FIELD ERRORS
    HANDLE THE UPDATE
    REDIRECT OR SHOW FORM WITH ERRORS. 
    */ 

    /* MAKE THIS SHORTER IF THERE IS TIME. */ 

if (!empty($_POST)) {
    $dashboardService = new DashboardService;
    $userService = new UserService;

    $errors = [];
    $dashboardService->getDashboardData();

    // HANDLE PART OF ANY UPDATE ACTION.
    function handleUpdate($userId, $property, $value, $password, $userService, $redirectUrl) {
        $result = $userService->updateUserProperty($userId, $property, $value, $password);
        $errors = $result["errors"];

        if (empty($errors)) {
            header("Location: $redirectUrl");
            exit();
        }

        return $errors;
    }

    // HANDLE EMAIL UPDATE.
    if (isset($_POST["btnUpdateEmail"])) {
        if (empty($_POST["email"]) || empty($_POST["password"])) {
            $errors[] = "New Email and password are required.";
        } else {
            $userId = (int) $dashboardService->getUserId();
            $email = $_POST["email"];
            $password = $_POST["password"];
            $errors = handleUpdate($userId, "email", $email, $password, $userService, "index.php?view=dashboard");
        }
        $updateEmail = new EmailUpdate();
        $updateEmail->showEmailUpdateForm($errors);
    }

    // HANDLE USERNAME UPDATE.
    if (isset($_POST["btnUpdateUsername"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $errors[] = "New username and password are required.";
        } else {
            $userId = (int) $dashboardService->getUserId();
            $username = $_POST["username"];
            $password = $_POST["password"];
            $errors = handleUpdate($userId, "username", $username, $password, $userService, "index.php?view=dashboard");
        }
        $updateUsername = new UsernameUpdate();
        $updateUsername->showUsernameUpdateForm($errors);
    }

    // HANDLE PASSWORD UPDATE.
    if (isset($_POST["btnUpdatePassword"])) {
        if (empty($_POST["newpassword"]) || empty($_POST["password"])) {
            $errors[] = "New password and current password are required.";
        } else {
            $userId = (int) $dashboardService->getUserId();
            $newpassword = $_POST["newpassword"];
            $password = $_POST["password"];
            $errors = handleUpdate($userId, "password", $newpassword, $password, $userService, "index.php?view=dashboard");
        }
        $updatePassword = new PasswordUpdate();
        $updatePassword->showPasswordUpdateForm($errors);
    }
}
