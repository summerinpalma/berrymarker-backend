<?php

declare(strict_types=1);

namespace Business;

class DashboardService
{

    // CREATE DASHBOARD SPECIFIC USER OBJECT TO POPULATE DASHBOARD FIELDS. 
    // THIS OBJECT IS BASED ON THE SESSION COOKIE.
    // NO CONSTRUCTOR.

    private $userID;
    private $email;
    private $username;
    private $role;

    public function getDashboardData()
    {
        $userData  = unserialize($_SESSION["user"]);

        $this->userID = $userData->getId();
        $this->email = $userData->getEmail();
        $this->username = $userData->getUsername();
        $this->role = $userData->getRole();

    }

    public function getUserId() {
        return $this->userID;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getRole() {
        return $this->role;
    }
}
