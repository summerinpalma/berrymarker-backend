<?php

declare(strict_types=1);

namespace Data;

use Data\DbConfig;
use Entities\User;
use Exceptions\InCorrectPasswordException;
use Exceptions\UserEmailAlreadyTakenException;
use Exceptions\UserNameAlreadyTakenException;
use Exceptions\UserNotFoundException;

class UserDAO
{

    // CHECK FOR DUPLICATE EMAIL IN TABLE. 
    public function checkForDuplicateEmail($email)
    {
        $dbh = new \PDO(DbConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
        $stmt->execute();

        $rowCount = $stmt->rowCount();
        $dbh = null;

        if ($rowCount > 0) {
            throw new UserEmailAlreadyTakenException();
        }
    }

    // CHECK FOR DUPLICATE USERNAME IN TABEL.
    public function checkForDuplicateUserName($username)
    {
        $dbh = new \PDO(DbConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);

        $stmt = $dbh->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, \PDO::PARAM_STR);
        $stmt->execute();

        $rowCount = $stmt->rowCount();
        $dbh = null;

        if ($rowCount > 0) {
            throw new UserNameAlreadyTakenException();
        }
    }

    public function checkPassword($resultSet, $password)
    {
        // CHECK FOR CORRECT PASSWORD, ELSE THROW.

        $isCorrectPassword = password_verify($password, $resultSet->getPassword());

        if (!$isCorrectPassword) {
            throw new InCorrectPasswordException();
        }

        return true;
    }

    public function getUserById(int $userid): User
    {
        // GET USER BASED ON ID.
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("SELECT id, username, email, password, role FROM users WHERE id = :id");

        $stmt->bindParam(":id", $userid, \PDO::PARAM_INT);
        $stmt->execute();
        $resultSet = $stmt->fetch(\PDO::FETCH_ASSOC);

        $dbh = null;

        // IF RESULT HAS BEEN RETURNED ELSE THROW.
        if (!$stmt->rowCount() > 0) {
            throw new UserNotFoundException();
        }

        $userid = $resultSet['id'];
        $username = $resultSet['username'];
        $email = $resultSet['email'];
        $password = $resultSet['password'];
        $role = $resultSet['role'];

        $user = new User($userid, $email, $username,$password,$role,null);
        return $user;
    }

    public function updateUserProperty(User $tempUser, string $property, $value)
    {
        // GET TEMPORARY OBJECT DATA.
        $userId = $tempUser->getId();
        $tempPassword = $tempUser->getPassword();

        // CHECK FOR DUPLICATE PROPERTY.
        if ($property === 'email') {
            $this->checkForDuplicateEmail($value);
        } elseif ($property === 'username') {
            $this->checkForDuplicateUserName($value);
        }

        // GET CURRENT USER BY ID.
        $resultSet = $this->getUserById($userId);

        // IF PASSWORD IS CORRECT, UPDATE DATABASE.
        if ($this->checkPassword($resultSet, $tempPassword)) {
            $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare("UPDATE users SET $property = :value WHERE id = :id");
            $stmt->bindParam(":value", $value, \PDO::PARAM_STR);
            $stmt->bindParam(":id", $userId, \PDO::PARAM_INT);
            $stmt->execute();
        }

        // CREATE USER OBJECT & RETURN.
        $user = new User();
        $user->setUserId($resultSet->getId());
        $user->setEmail($property === 'email' ? $value : $resultSet->getEmail());
        $user->setUserName($property === 'username' ? $value : $resultSet->getUsername());
        $user->setRole($resultSet->getRole());

        // CLEAR PASSWORD.
        $resultSet = [];
        unset($tempPassword);
        unset($value);

        return $user;
    }

    public function userLogin(User $user)
    {

        // GET USER BASED ON EMAIL.
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("SELECT id, email, username, password, role FROM users WHERE email = :email");

        $email = $user->getEmail();
        $password = $user->getPassword();
        $user->resetSensitiveData();

        $stmt->bindParam(":email", $email, \PDO::PARAM_STR);
        $stmt->execute();
        $resultSet = $stmt->fetch(\PDO::FETCH_ASSOC);

        $dbh = null;

        // IF RESULT HAS BEEN RETURNED ELSE THROW.
        if ($stmt->rowCount() > 0) {
            // CHECK FOR CORRECT PASSWORD, ELSE THROW.
            // CREATE USER OBJECT. 
        $userData = new User($resultSet['id'],$resultSet['email'],$resultSet['username'],$resultSet['password'], $resultSet['role'],null);
            $this->checkPassword($userData, $password);
        } else {
            throw new UserNotFoundException();
        }

        // SET USER INFORMATION.
        $user->setUserId($resultSet["id"]);
        $user->setUserName($resultSet["username"]);
        $user->setRole($resultSet["role"]);

        return $user;
    }

    public function registerUser(User $user)
    {

        // ADD A NEW USER TO THE TABLE.
        $dbh = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();

        $stmt->bindParam(":username", $username, \PDO::PARAM_STR);
        $stmt->bindParam("email", $email, \PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, \PDO::PARAM_STR);
        $stmt->execute();

        // GET LAST INSERTED ID FROM TABLE.
        $lastInsertedId = $dbh->lastInsertId();

        // GET ROLE OF LAST SELECTED ID FROM TABLE.
        $stmt = $dbh->prepare("SELECT role FROM users WHERE id = :id");
        $stmt->bindParam(":id", $lastInsertedId, \PDO::PARAM_INT);
        $stmt->execute();

        $roleResult = $stmt->fetch(\PDO::FETCH_ASSOC);
        $role = $roleResult["role"];

        // SET USERID & ROLE TO USER OBJECT, RESET PASSWORD.
        $user->setUserId($lastInsertedId);
        $user->setRole($role);
        $user->resetSensitiveData();

        // RETURN THE USER OBJECT. 
        return $user;
    }
}
