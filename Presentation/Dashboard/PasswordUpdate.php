<?php

declare(strict_types=1);

namespace Presentation\Dashboard;

// IMPORT URL CONSTANTS.
// COMPOSER FIX? 
require_once("Data/URLConfig.php");

class PasswordUpdate
{
    public function showPasswordUpdateForm($errors = null)
    {
       
        require_once("Presentation/header.php");

?>

        <h1>Change your password.</h1>

        <p>Please make sure your password fits the following requirements.</p>
        <ul>
            <li>Minimum length of 8 characters.</li>
            <li>At least one uppercase letter.</li>
            <li>At least one lowercase letter.</li>
            <li>At least one digit.</li>
            <li>At least one special character.</li>
        </ul>

        <?php if ($errors) { ?>
            <h2>Oops, please try again.</h2>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <form action="<?php echo PHP_SELF_URL; ?>" method="POST">
            <label id="newpassword-label" for="newpassword">New Password:</label>
            <input type="password" name="newpassword" id="newpassword" aria-labelledby="newpassword-label" autocomplete="new-password">
            <label id="password-label" for="password">Password:</label>
            <input type="password" name="password" id="password" aria-labelledby="password-label" autocomplete="current-password">
            <input type="submit" value="Change my password" name="btnUpdatePassword">
        </form>

<?php

        require_once("Presentation/footer.php");
    }
}

?>
