<?php
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "pweb_myproject";

    $con = mysqli_connect($host, $dbUsername, $dbPassword, $dbName) or die
        ("Impossibile connettersi al server: " . mysqli_connect_error());

?>