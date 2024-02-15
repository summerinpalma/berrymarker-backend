<?php

declare(strict_types=1);

// COMPOSER AUTOLOAD. 
require_once('vendor/autoload.php');

use Presentation\Login\LoginView;
use Presentation\Login\LogOutView;
use Business\UserService;
use Presentation\Login\LoggedInView;

session_start();

$userService = new UserService();

if (!isset($_SESSION["user"])) {

    $showLogin = new LoginView();
    $errors = [];

    // IF LOGIN BUTTON IS SET.
    if (isset($_POST["btnLogin"])) {
        $userService = new UserService();

        // CHECK FOR EMPTY EMAIL FIELD. 
        $email = trim($_POST["email"]) ?? '' ?:array_push($errors, "Email input was empty.");

        // CHECK FOR EMPTY PASSWORD FIELD.
        $password = trim($_POST["password"]) ?? '' ?: array_push($errors, "Password input was empty.");

        // IF FIELDS ARE NOT EMPTY.
        if (empty($errors)) {
            $result = $userService->loginUser($email, $password);
            $user = $result["user"];
            $errors = $result["errors"];

            // IF NO OTHER ERRORS, START SESSION & SET COOKIE, FORWARD TO DASHBOARD.
            if (empty($errors)) {

                $userService->updateUserCookie($user);

                header("Location: index.php?view=dashboard");
            }
        }
    }

    // SHOW LOGIN FORM.
    $showLogin->showLoginForm($errors);
} else {

    // SHOW LOGGED IN VIEW.
    $showLogOut = new LoggedInView();
    $showLogOut->showLoggedInView();

}
