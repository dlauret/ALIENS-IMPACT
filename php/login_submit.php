<?php
    require('db_init.php');
    require('functions.php');

    // se viene premuto il tasto Register
    if(isset($_POST["submit"])) {
        
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con,$username);

        $pwd = stripslashes($_POST['pwd']);
        $pwd = mysqli_real_escape_string($con,$pwd);

        // login utente
        loginUser($con, $username, $pwd); 
        
    }
    else {
        header("Location: ./login.php");
        exit();
    }
?>