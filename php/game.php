<?php
  session_start();
  require('db_init.php');
  require('functions.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="description" content="game page of ALIENS IMPACT"/>
        <meta name="author" content="Dario Lauretta">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <title>ALIENS IMPACT</title>
        <link rel="stylesheet" href="../css/style_game.css" />
    </head>
    <body>

        <?php
          
          $IDUser = $_SESSION["IDUser"]; 
          $username = $_SESSION["Username"];
          $email = $_SESSION["Email"];
          $country = $_SESSION["Country"];

          // funzione con query per prendere il maxScore dell'user
          // funzione su functions.php
          $_SESSION["maxScore"] = getMaxScore($con, $IDUser);
          $_SESSION["minTime"] = getMinTime($con, $IDUser); // min:sec

          if(isset($_GET["error"])) {
            if ($_GET["error"] === "stmtfailed") {
                echo "Error with database: mysqli_stmt_prepare()";
            }
          }
        ?>

        <div id="clock" class="gameData">0</div>

        <script src="../js/Entity.js"></script>
        <script src="../js/Ship.js"></script>
        <script src="../js/Bullet.js"></script>
        <script src="../js/Alien.js"></script>
        <script src="../js/Score.js"></script>
        <script src="../js/Lives.js"></script>
        <script src="../js/game_Functions.js"></script>
        <script src="../js/game.js"></script>

      
    </body>
</html>
