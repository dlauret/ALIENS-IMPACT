<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Log in page"/>
        <meta name="author" content="Dario Lauretta">
        <title>Log in</title>
        <link rel="stylesheet" href="../css/style_login.css" />
    </head>
    <body >
        <div class="page-content">
            <div class="form-content">

                <form class="form-detail"  action="./login_submit.php" method="post">
                    <?php
                        // codice per quando registrazione con successo
                        if(isset($_GET["register"])) {

                            if ($_GET["register"] === "successful") {
                                echo "<small style=\"color: yellowgreen\"> You've registered! Please, log in </small>";
                            }
                        }
                    ?>
                    <h2>Log In</h2>

                    <div class="form-row-total">

					    <div class="form-row">
                            <!-- username -->
                            <?php
                                // codice per gestire gli errori: wronglogin
                                if(isset($_GET["error"])) {

                                    if ($_GET["error"] === "wronglogin") {
                                        echo "<small style=\"color: red\"> *Username does not exist! </small>";
                                    }
                                }
                            ?>
                            <input type="text" name="username" class="input-text" id="username" placeholder="Username" required/>
                        </div>
                    </div>
                    
                    <div class="form-row-total">
					    <div class="form-row">
                            <!-- password -->
                            <?php
                                // codice per gestire l'errore: incorrectpassword
                                if (isset($_GET["error"])) {

                                    if($_GET["error"] === "incorrectpassword") {
                                        echo "<small style=\"color: red\"> *Password not correct! Try again... </small>";
                                    }
                                }
                                
                            ?>
                            <input type="password" name="pwd" class="input-text" id="password" placeholder="Password" required/>
                        </div>
                    </div>

                    <div class="form-row-last">
                        <input type="submit" name="submit" class="submit" value="Log in" />
                    </div>                    

                </form>

                <p class="registration_link"> Not registered yet? <a href='./signup.php'>Register Here</a> </p>

            </div>
        </div>
    </body>
</html>