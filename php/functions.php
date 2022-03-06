<?php
    // SIGN UP
    /**
     * Funzione utilizzata per controllare la validità dell'e-mail inserita
     */

    function invalidEmail($email) {

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Funzione utilizzata per controllare che l'username utilizzato in fase di
     * registrazione non sia già stata usata da un altro utente
     */

    function userExists($con, $username) {
        $sql = "SELECT *
                FROM user 
                WHERE Username = ?;";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ./signup.php?error=stmtfaileduser");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row; // qualcuno ha già usato l'username inserito
        }
        else {
            return false; // nessuno ha usato tale username
        }

        mysqli_stmt_close($stmt);

    }

    /**
     * Funzione utilizzata per controllare che l'email utilizzata in fase di 
     * registrazione non sia già stata usata da un altro utente
     */

    function emailExists($con, $email) {

        $sql = "SELECT * 
                FROM user 
                WHERE Email = ?;";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ./signup.php?error=stmtfailedemail");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row; // qualcuno ha già usato l'e-mail inserita
        }
        else {
            return false; // nessuno ha usato tale e-mail
        }

        mysqli_stmt_close($stmt);
    }


    /**
     * Funzione utilizzata per inserire all'interno del database
     * i dati inseriti dall'utente in fase di registrazione
     */

    function createUser($con, $username, $email, $pwd, $country) {

        $sql = "INSERT INTO user(Username, Email, Password, Country) 
                VALUES(?, ?, ?, ?);";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: ./signup.php?error=stmtfailedcreateuser");
            exit();
        }

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPwd, $country);

        if(mysqli_stmt_execute($stmt) === true) {
            header("location: login.php?register=successful");
        }

        mysqli_stmt_close($stmt);

        // prendiamo IDUser dalla tabella user
        // ci serve per creare record nell'altra tabella

        $sql = "SELECT IDUser FROM user WHERE Username=?;";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: signup.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);

        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);
        $iduser = $row['IDUser'];

        // creazione record nella tabella max_score con valori nulli ma con ID user appena creato 

        $sql = "INSERT INTO max_score(IDUser, Max_Score, Time) values(?,?,?);";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $sql)) { 
            header("location: ./signup.php?error=stmtfailedcreateuser");
            exit();
        }        

        $zero = 0;
        $nullo = "0";
        mysqli_stmt_bind_param($stmt, "sss", $iduser, $zero, $nullo);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        
        exit();
    }

    
    // -----------------------------------------------------
    // LOG IN

    /**
     * Funzione di servizio utilizzata per permettere l'accesso al sistema all'utente.
     */

    function loginUser($con, $username, $pwd) {

        $sql = "SELECT *
                FROM user 
                WHERE Username = ?;";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: login.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $username);

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) { // si ottiene una sola riga come risultato

            $pwdHashed = $row["Password"];

            $checkPwd = password_verify($pwd, $pwdHashed);

            if($checkPwd === false) {
                header("location: login.php?error=incorrectpassword");
                exit();
            }
            else if($checkPwd === true) { // se l'utente si è registrato e la password è corretta allora 
                
                session_start(); // si avvia una sessione

                // impostazione delle variabili di sessione (variabili globali)

                $_SESSION["IDUser"] = $row["IDUser"]; 
                $_SESSION["Username"] = $row["Username"];
                $_SESSION["Email"] = $row["Email"];
                $_SESSION["Country"] = $row["Country"];

                
                header("location: game.php"); // reindirizzamento ad un'altra pagina
                exit();
            }
        }
        else { // non è stato trovato alcun utente con l'username indicato

            header("location: login.php?error=wronglogin");
            exit();
        }

        mysqli_stmt_close($stmt);
    }


    /**
     * Funzione utilizzata per prendere il maxScore da tabella max_score avendo un ID utente
     */
 
    function getMaxScore($con, $IDUser) {
        $sql = "SELECT *
                FROM max_score 
                WHERE IDUser = ?;";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: game.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $IDUser);

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) { // si ottiene una sola riga come risultato

            $maxSc = $row["Max_Score"];

        }
        else { // non è stato trovato alcun user con tale ID
            $maxSc = 0;
        }

        mysqli_stmt_close($stmt);

        return $maxSc;
    }

    /**
     * Funzione utilizzata per prendere il Time da tabella max_score avendo un ID utente
     */
 
    function getMinTime($con, $IDUser) {
        $sql = "SELECT *
                FROM max_score 
                WHERE IDUser = ?;";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: game.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $IDUser);

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($resultData)) { // si ottiene una sola riga come risultato

            $minTime = $row["Time"];

        }
        else { // non è stato trovato alcun user con tale ID
            $minTime = '-';
        }

        mysqli_stmt_close($stmt);

        return $minTime;
    }
    
?>
