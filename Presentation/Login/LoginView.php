<?php

declare(strict_types=1);

namespace Presentation\Login;

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class LoginView
{
    public function showLoginForm($errors = null)
    {
        require_once("Presentation/header.php");
?>
        <?php if (isset($_GET["logout"]) && ($_GET["logout"] === "success")) { ?>
            <h1>You have been logged out. Found more?</h1>
        <?php } else { ?>

            <h1>Use your credentials to log in...</h1>

        <?php }
        if (isset($_GET["registration"]) && ($_GET["registration"] === "success")) { ?>
            <p>Registration succesful, continue by logging in...</p>
        <?php } else { ?>
            <p>No account? <a href="<?php echo REGISTER_URL; ?>">Register here.</a></p>
        <?php } ?>

        <?php if ($errors) { ?>
            <h2>Oops, please try again.</h2>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <form action="<?php echo PHP_SELF_URL; ?>" method="POST">
            <label id="email-label" for="email">Email Address:</label>
            <input type="text" name="email" id="email" aria-labelledby="email-label">
            <label id="password-label" for="password">Password:</label>
            <input type="password" name="password" id="password" aria-labelledby="password-label">
            <input type="submit" value="Let's get picking!" name="btnLogin">
        </form>
<?php
        require_once("Presentation/footer.php");
    }
}

?>