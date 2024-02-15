<?php

declare(strict_types=1);

namespace Presentation\Dashboard;

use Business\DashboardService;
use Data\URLConfig;

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class DashboardView
{

    private $userId;
    private $email;
    private $username;
    private $role;

    // CONSTRUCTOR FOR RETRIEVING DATA FOR THIS VIEW.
    public function __construct(DashboardService $dashboardService)
    {
        $this->userId = $dashboardService->getUserId();
        $this->email = $dashboardService->getEmail();
        $this->username = $dashboardService->getUsername();
        $this->role = $dashboardService->getRole();
    }

    public function showDashboard($errors = null)
    {

        require_once("Presentation/header.php");
    
?>
        
        <h1>Welcome, <?php echo htmlspecialchars($this->username); ?>.</h1>
        <h2>Change your information.</h2>
        <ul>
            <li><a href="<?php echo UPDATE_EMAIL_URL; ?>" title="Update your e-mail adress">Update your e-mail adress.</a></li>
            <li><a href="<?php echo UPDATE_USERNAME_URL; ?>" title="Update your username">Update your username.</a></li>
            <li><a href="<?php echo UPDATE_PASSWORD_URL; ?>" title="Update your password">Update your password.</a></li>
        </ul>

        <h2>Your information.</h2>
        <ul>
            <li>Username: <?php echo htmlspecialchars($this->username); ?></li>
            <li>E-mail: <?php echo htmlspecialchars($this->email); ?></li>
            <li>Role: <?php echo htmlspecialchars($this->role); ?></li>
        </ul>

<?php

        require_once("Presentation/footer.php");
    }
}

?>