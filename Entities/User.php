<?php

declare(strict_types=1);

namespace Entities;

require_once("exceptions/exceptions.php");

// APPEARS ONLY TO BE WORKING WHEN LINE ABOVE IS USED.
use Exceptions\EmailInvalidException;
use Exceptions\PasswordInvalidFormatException;
use Exceptions\RoleInvalidFormatException;
use Exceptions\UserIdInvalidException;
use Exceptions\UserNameSpecialCharactersException;
use Exceptions\UserNameTooShortException;

// USER OBJECT.

class User
{
    private $id;
    private $email;
    private $username;
    private $password;
    private $newpassword;
    private $role;

    // CONSTRUCTOR, MAKE SURE VALUES CAN BE NULL. 
    public function __construct($cid = null, $cemail = null, $cusername = null, $cpassword = null, $crole = null, $cnewpassword = null)
    {
        $this->id = $cid;
        $this->email = $cemail;
        $this->username = $cusername;
        $this->password = $cpassword;
        $this->newpassword = $cnewpassword;
        $this->role = $crole;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getNewPassword()
    {
        return $this->newpassword;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setUserId($id)
    {
        if (is_numeric($id)) {
            $this->id = (int)$id;
        }
    }

    public function setUserName($username)
    {

        // CHECK IF USERNAME IS LONGER THAN 5 CHAR & HAS NO SPECIAL CHARS, SET.
        if (strlen($username) > 5) {
            if (preg_match('/^[a-zA-Z0-9]+$/', $username)) {
                $this->username = $username;
            } else {
                throw new UserNameSpecialCharactersException();
            }
        } else {
            throw new UserNameTooShortException();
        }
    }

    public function setEmail($email)
    {

        // CHECK IF USERNAME IS VALID & SET.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailInvalidException();
        }

        $this->email = $email;
    }

    public function setPassword($password)
    {
        /* 
            CHECK PASSWORD & SET. 
            Minimum length of 8 characters.
            At least one uppercase letter.
            At least one lowercase letter.
            At least one digit.
            At least one special character (you can customize this character set).
        */

        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/\d/', $password)
        ) {
            throw new PasswordInvalidFormatException();
        }

        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setNewPassword($newpassword)
    {
        /* 
            CHECK PASSWORD & SET. 
            Minimum length of 8 characters.
            At least one uppercase letter.
            At least one lowercase letter.
            At least one digit.
            At least one special character (you can customize this character set).
        */

        if (
            strlen($newpassword) < 8 ||
            !preg_match('/[A-Z]/', $newpassword) ||
            !preg_match('/[a-z]/', $newpassword) ||
            !preg_match('/\d/', $newpassword)
        ) {
            throw new PasswordInvalidFormatException();
        }

        $this->newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
    }

    public function setLoginPasswordInput($password)
    {
        // SET PASSWORD FOR TEMPORARY USER THAT TRIES TO LOGIN.
        $this->password = $password;
    }

    public function setRole($role)
    {

        // ROLE WILL BE ASSIGNED MANUALLY IN DATABASE - DO NOT USE THIS. 
        if ($role !== "user" && $role !== "administrator") {
            throw new RoleInvalidFormatException();
        }

        $this->role = $role;
    }

    public function resetSensitiveData()
    {
        // RESETS PASSWORD TO NULL.
        $this->password = null;
    }
}
