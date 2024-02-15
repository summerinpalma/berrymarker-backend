<?php
    declare(strict_types=1);
    
    // COMPOSER AUTOLOAD. 
    require_once('vendor/autoload.php');

    use Presentation\Login\RegisterView;
    use Presentation\Login\LoggedInView;
    use Business\UserService;

    session_start();

    if (!isset($_SESSION["user"])) {
    $showRegister = new RegisterView;
    $errors = [];

    // SHOW REGISTER FORM IF ACTION IS REGISTER OR LOGIN FORM IS ACTION IS LOGIN OR NULL.
    if (isset($_POST["btnRegister"])) {
            $userService = new UserService();

            // NO NEED TO CHECK FOR EMPTY FIELDS SINCE USER SERVICE WILL CATCH THAT.
            $email = $_POST["email"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            $result = $userService->registerUser($email, $username, $password);
            $user = $result['user'];
            $errors = $result['errors'];

            if (empty($errors)) {
                header("Location: login.php?registration=success");
                exit();
            }
        }

        // SHOW REGISTRATIONFORM. 
        $showRegister->showRegisterForm($errors);


} else {

    // SHOW LOGGED IN VIEW.
    $showLogOut = new LoggedInView();
    $showLogOut->showLoggedInView();

}

?>