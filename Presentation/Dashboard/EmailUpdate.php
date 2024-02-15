<?php

declare(strict_types=1);

namespace Presentation\Dashboard;

class EmailUpdate
{
    public function showEmailUpdateForm($errors = null)
    {
        
        require_once("Presentation/header.php");

?>

        <h1>Change your e-mail adress.</h1>
        <p>Choose a new e-mail adress followed by your password.</p>

        <?php if ($errors) { ?>
            <h2>Oops, please try again.</h2>
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
            <label id="email-label" for="email">Email Address:</label>
            <input type="text" name="email" id="email" aria-labelledby="email-label">
            <label id="password-label" for="password">Password:</label>
            <input type="password" name="password" id="password" aria-labelledby="password-label" autocomplete="current-password">
            <input type="submit" value="Change my email adress" name="btnUpdateEmail">
        </form>

<?php

        require_once("Presentation/footer.php");
    }
}

?>
