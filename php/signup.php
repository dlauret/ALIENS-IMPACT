<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Sign up page"/>
        <meta name="author" content="Dario Lauretta">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Sign up</title>
        <link rel="stylesheet" href="../css/style_signup.css" />

        <script>
            // funzione per controllare i caratteri della password
            // e per controllare se le due passwd combaciano
            function validateForm() {
                // check password input
                var pwd = document.getElementById("password").value;
                var pwdRegex = /^(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{5,}$/;
                if(pwd.match(pwdRegex) !== null) {
                    // check se le due pwd sono uguali
                    var pwdRpt = document.getElementById("passwordRepeat").value;

                    if(pwd.localeCompare(pwdRpt) === 0) {
                        return true; // tutti i controlli passati
                    }
                    else {
                        document.getElementById("possibleError").innerHTML = "Passwords are not the same!";
                        return false;
                    }
                }
                else{
                    document.getElementById("possibleError").innerHTML = "Password not ok!";
                    return false;
                }
            }

        </script>
    </head>
    <body >
        <div class="page-content">    
            <div class="form-content">
                <form class="form-detail" id="signUpForm" action="./signup_submit.php" onsubmit="return validateForm()" method="post">

                    <h2>Register</h2>
                    <p id="possibleError" style="color: red">
                        <?php
                            // codice per gestire gli errori: userexists
                            if(isset($_GET["error"])) {

                                if ($_GET["error"] === "userexists") {
                                    echo "*Username already exists";
                                }
                            }

                            // codice per gestire gli errori: invalidemail e emailexists
                            if(isset($_GET["error"])) {
                                        
                                if($_GET["error"] === "invalidemail") {
                                    echo "*E-mail not valid";
                                } 
                                
                                else if ($_GET["error"] === "emailexists") {
                                    echo "*E-mail already exists";
                                }
                            }

                        ?>
                    </p>
                    <div class="form-row-total">
                        <div class="form-row">
                            <!-- username -->
                            <input type="text" name="username" class="input-text" id="username" placeholder="Username*" required/>
                        </div>

                        <div class="form-row">
                            <!-- country -->
                            <input type="text" name="country" class="input-text" id="country" placeholder="Country" />
                        </div>

                        <div class="form-row">
                            <!-- email -->
                            <input type="email" name="email" class="input-text" id="email" placeholder="Email*" required/>
                        </div>        
                    </div>
                    <div class="form-row-total">
                        <div class="form-row">
                            <!-- password -->
                            <div class="tooltip">
                                <input type="password" name="pwd" class="input-text" id="password" placeholder="Password*" required/>
                                <span class="tooltiptext"> Use 5 or more characters with a mix of uppercase and lowercase letters and numbers </span>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- password 2 -->
                            <input type="password" name="pwdRepeat" class="input-text" id="passwordRepeat" placeholder="Repeat Password*" required/>
                        </div>

                    </div>
                    
                    <p id="necessary"> fields with * are necessary </p>

                    <div class="form-row-last">
                        <input type="submit" name="submit" class="submit" value="Register" />
                    </div>

                </form>

                <p class="registration_link"> Already registered? <a href='./login.php'>Log in</a> </p>

            </div>
        </div>
    </body>

</html>