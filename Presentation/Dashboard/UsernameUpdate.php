<?php

declare(strict_types=1);

namespace Presentation\Dashboard;

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class UsernameUpdate
{
    public function showUsernameUpdateForm($errors = null)
    {
       
        require_once("Presentation/header.php");

?>

        <h1>Change your username.</h1>
        <p>Choose a new username followed by your password.</p>

        <?php if ($errors) { ?>
            <h2>Oops, please try again.</h2>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <form action="<?php echo PHP_SELF_URL; ?>" method="POST">
            <label id="username-label" for="username">Username:</label>
            <input type="text" name="username" id="username" aria-labelledby="username-label">
            <label id="password-label" for="password">Password:</label>
            <input type="password" name="password" id="password" aria-labelledby="password-label" autocomplete="current-password">
            <input type="submit" value="Change my username" name="btnUpdateUsername">
        </form>

<?php

        require_once("Presentation/footer.php");
    }
}

?>
