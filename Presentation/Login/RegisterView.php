<?php

declare(strict_types=1);

namespace Presentation\Login;


// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class RegisterView
{
    public function showRegisterForm($errors = null)
    {
        require_once("Presentation/header.php");
?>

        <h1>Complete your credentials to register...</h1>
        <p>Already have an account? <a href="<?php echo LOGIN_URL; ?>">Login here.</a></p>

        <?php if ($errors) { ?>
            <h2>Oops, check for errors.</h2>
            <ul>
                <?php foreach ($errors as $error) { ?>
                <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <form action="<?php echo PHP_SELF_URL; ?>" method="POST">            
            <label id="email-label" for="emailaddress">Email Address:</label>
            <input type="text" name="email" id="email" aria-labelledby="email-label">
            <label id="username-label" for="username">Username:</label>
            <input type="text" name="username" id="username" aria-labelledby="username-label">
            <label id="password-label" for="password">Password:</label>
            <input type="password" name="password" id="password" aria-labelledby="password-label">
            <input type="submit" value="Register me!" name="btnRegister">
        </form>

<?php
        require_once("Presentation/footer.php");
    }
}

?>