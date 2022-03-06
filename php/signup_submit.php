<?php
    require('db_init.php');
    require('functions.php');

    // se viene premuto il tasto Register
    if(isset($_POST["submit"])) {
        
        $username = stripslashes($_POST['username']);
        $username = mysqli_real_escape_string($con,$username);
        

        $country = stripslashes($_POST["country"]);
        $country = mysqli_real_escape_string($con,$country);
        

        $email = $_POST['email'];
        $email = mysqli_real_escape_string($con,$email);
        

        $pwd = stripslashes($_POST['pwd']);
        $pwd = mysqli_real_escape_string($con,$pwd);
        

        $pwdRepeat = stripslashes($_POST['pwdRepeat']);
        $pwdRepeat = mysqli_real_escape_string($con,$pwdRepeat);
        


        // gestione degli errori
        // funzioni presenti nel file ./php/functions.php

        // se username già esistente
        if(userExists($con, $username) !== false) {
            header("location: ./signup.php?error=userexists");
            exit();
        }

        // se email non valida
        if(invalidEmail($email) !== false) { 
            header("location: ./signup.php?error=invalidemail");
            exit();
        }

        // se email già usata da altri user
        if(emailExists($con, $email) !== false) { 
            header("location: ./signup.php?error=emailexists");
            exit();
        }

        // creazione del nuovo utente
        createUser($con, $username, $email, $pwd, $country);
    }
    else {
        header("Location: ./signup.php");
        exit();
    }
?>