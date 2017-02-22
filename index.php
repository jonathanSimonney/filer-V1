<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8"/>
      <title>filer</title>
      <meta name="author" content="Jonathan">
      <script src="https://use.fontawesome.com/e79eca285b.js"></script>
      <link rel="stylesheet" type="text/css" href="assets/style.css">
    </head>
    <body>
        <?php
            include "include/elementsHtml/header.php";
            includeRightHeader('<a href="pages/notConnected/signUp.php"><i class="fa fa-sign-in" aria-hidden="true"></i>sign&nbsp;in</a>');
        ?>

        <br>
        <span>already registered ? Click the button below.</span>
        <br>
        <button id="buttonDisplay">log in</button>
        <br><br>

        <form name="connect" method="POST" action="assets/scripts/PHP/validateLogIn.php" class="toHide">
            <fieldset>
                <label for="username">username</label>
                <input type="text" name="username" id="username" placeholder="username">
                <label for="password">password : </label>
                <input type="password" name="password" id="password" placeholder="*******">
                <br>
                <button>Send</button>
            </fieldset>
        </form>

        <p id="message" class="message red">
            <?php
                //start session + display error if present
                session_start();
                if (array_key_exists("errorMessage", $_SESSION)) {
                    echo $_SESSION["errorMessage"];
                    $_SESSION["errorMessage"] = "";
                }
            ?>
        </p>

        <script src="assets/scripts/JS/index.js"></script>
    </body>
</html>