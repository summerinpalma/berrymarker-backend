<?php 
declare(strict_types=1);

namespace Presentation\Login;

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class LoggedInView
{
    public function showLoggedInView()
    {
        require_once("Presentation/header.php");

?>
    <h1>You're already logged in!</h1>
    <p>Try to <a href="<?php echo LOGOUT_URL; ?>" title="Log Out">log out</a> for logging in or registering a new account.</p>

<?php
        require_once("Presentation/footer.php");
    }

}

?>