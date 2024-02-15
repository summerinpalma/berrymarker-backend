<?php

namespace URLConfig;

// SELF. 
define('PHP_SELF_URL', htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8'));

// LOGIN, REGISTER, LOGOUT.
define('LOGIN_URL', 'login.php');
define('REGISTER_URL', 'register.php');
define('LOGOUT_URL', 'logout.php');

// DASHBOARD.
define('DASHBOARD_URL', 'index.php?view=dashboard');
define('UPDATE_EMAIL_URL', 'index.php?update=email');
define('UPDATE_USERNAME_URL', 'index.php?update=username');
define('UPDATE_PASSWORD_URL', 'index.php?update=password');

// MAPVIEW. 
define('MAPVIEW_URL', 'mapview.php');

// MARKERS. 
define('USER_MARKERS_URL', 'usermarkers.php');
define('ALL_MARKERS_URL', 'allmarkers.php');
