<?php
declare(strict_types=1);

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

?>
<nav>
    <ul>
        <?php if (isset($_SESSION["user"])) { ?>
            <li><a href="<?php echo MAPVIEW_URL; ?>">Map Overview</a></li>
            <li><a href="<?php echo DASHBOARD_URL; ?>">User Dashboard</a></li>
            <li><a href="<?php echo USER_MARKERS_URL; ?>">Manage My Markers</a></li>
            <li><a href="<?php echo ALL_MARKERS_URL; ?>">All Markers</a></li>
            <li><a href="<?php echo LOGOUT_URL; ?>">Logout</a></li>
        <?php } ?>

        <?php if (!isset($_SESSION["user"])) { ?>
            <li><a href="<?php echo LOGIN_URL; ?>">Login or Register</a></li>
        <?php } ?>
    </ul>
</nav>