<?php

declare(strict_types=1);

namespace Business;

use Data\UserDAO;
use Entities\User;
use Exceptions\EmailInvalidException;
use Exceptions\InCorrectPasswordException;
use Exceptions\PasswordInvalidFormatException;
use Exceptions\UserEmailAlreadyTakenException;
use Exceptions\UserNameAlreadyTakenException;
use Exceptions\UserNameSpecialCharactersException;
use Exceptions\UserNameTooShortException;
use Exceptions\UserNotFoundException;

class UserService
{
    // UPDATE USER COOKIE.
    public function updateUserCookie(User $user)
    {
        if ($user) {
            // UPDATE COOKIE WITH NEW USER OBJECT DATA.
            session_start();
            $_SESSION["user"] = serialize($user);

            // SESSION SECURITY.
            session_set_cookie_params(["secure" => true, "httponly" => true]);
            session_regenerate_id(true);
        }
    }

    public function updateUserProperty($id, $property, $value, $password) {
        $temporaryUser = new User($id);
        $userDAO = new UserDAO;
        $user = null;
        $errors = [];

        // Set user ID
        $temporaryUser->setUserId($id);

        // Set property value and validate
        try {
            switch ($property) {
                case 'password':
                    $temporaryUser->setNewPassword($value);
                    $value = $temporaryUser->getNewPassword();
                    break;
                case 'username':
                    $temporaryUser->setUserName($value);
                    break;
                case 'email':
                    $temporaryUser->setEmail($value);
                    break;
            }
        } catch (\Exception $e) {
            array_push($errors, $e->getMessage());
            return ["user" => $user, "errors" => $errors];
        }

        // Set password
        $temporaryUser->setLoginPasswordInput($password);

        // Try to update property
        try {
            $user = $userDAO->updateUserProperty($temporaryUser, $property, $value);
        } catch (\Exception $e) {
            array_push($errors, $e->getMessage());
        }

        // Update cookie if there are no errors
        if (empty($errors)) {
            $this->updateUserCookie($user);
        }

        // Clear sensitive information
        unset($temporaryUser);
        unset($password);

        // Return user object and errors
        return ["user" => $user, "errors" => $errors];
    }

    public function loginUser($email, $password)
    {

        // CREATE A TEMPORARY USER OBJECT TO CHECK.
        $temporaryUser = new User(null, $email, null, null);
        $userDAO = new UserDAO();

        // SET ERRORS & USER TO NULL.
        $errors = [];
        $user = null;

        // SET TEMPORARY USER EMAIL & VALIDATE.
        try {
            $temporaryUser->setEmail($email);
        } catch (EmailInvalidException $e) {
            array_push($errors, $e->getMessage());
        }

        // SET TEMPORARY USER PASSWORD.
        $temporaryUser->setLoginPasswordInput($password);

        // TRY LOG IN.
        try {
            $user = $userDAO->userLogin($temporaryUser);
        } catch (UserNotFoundException | InCorrectPasswordException $e) {
            array_push($errors, $e->getMessage());
        }

        return ["user" => $user, "errors" => $errors];
    }

    public function registerUser($email, $username, $password)
    {

        // CREATE A USER OBJECT.
        $user = new User(null, $email, $username, $password, null);
        $userDAO = new UserDAO;

        // SET ERRORS TO NULL.
        $errors = [];

        // CATCHING ALL SEPERATE EXCEPTIONS FOR VALIDATION. 
        try {
            $user->setEmail($email);
        } catch (EmailInvalidException $e) {
            array_push($errors, $e->getMessage());
        }

        try {
            $user->setUserName($username);
        } catch (UserNameTooShortException | UserNameSpecialCharactersException $e) {
            array_push($errors, $e->getMessage());
        }

        try {
            $user->setPassword($password);
        } catch (PasswordInvalidFormatException $e) {
            array_push($errors, $e->getMessage());
        }

        // IF NO EXCEPTIONS CHECK FOR DUPLICATES IN TABLE.
        if (empty($errors)) {
            try {
                $userDAO->checkForDuplicateEmail($email);
            } catch (UserEmailAlreadyTakenException $e) {
                array_push($errors, $e->getMessage());
            }

            try {
                $userDAO->checkForDuplicateUserName($username);
            } catch (UserEmailAlreadyTakenException $e) {
                array_push($errors, $e->getMessage());
            }

            // IF NO DUPLICATES REGISTER USER TO TABLE.
            if (empty($errors)) {
                $user = $userDAO->registerUser($user);
            }
        }

        // RETURN USER & ERRORS. 
        return ["user" => $user, "errors" => $errors];
    }
}
