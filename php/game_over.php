<?php
  session_start();
  require('db_init.php');
  require('functions.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Game Over page"/>
        <meta name="author" content="Dario Lauretta">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Game Over</title>
        <link rel="stylesheet" href="../css/style_game_over.css" />
    </head>
    <body>
        
        <?php
            // codice per prendere i parametri dell'url corrente

            // Program to display URL of current page
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $link = "https";
            else
            $link = "http";

            // Here append the common URL characters.
            $link .= "://";

            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER['HTTP_HOST'];

            // Append the requested resource location to the URL
            $link .= $_SERVER['REQUEST_URI'];
            
            // dividere url per le variabili
            // Use parse_url() function to parse the URL 
            // and return an associative array which
            // contains its various components
            $url_components = parse_url($link);
            
            // Use parse_str() function to parse the
            // string passed via URL
            parse_str($url_components['query'], $params);
            
            $didWin = false;
            if ($params["end"] === "bump") {
                echo "<h2 class=\"messagegameover\"> SHIP DESTROYED </h2>";
            }
            elseif($params["end"] === "lives") {
                echo "<h2 class=\"messagegameover\"> ALL LIVES OVER </h2>";
            }
            elseif ($params["end"] === "win") {
                    echo "<h2 class=\"messagegameover\"> YOU WIN </h2>";
                    $didWin = true;
            }

            $score = $params["score"];
            $time = $params["time"];

            echo "<div class='points'>";
                echo "<h2 class='messagegameover score'>SCORE: " .$score . "</h2>";
                $newMin = floor($time / 60);
                $newSec = $time % 60;
                if($newSec < 10) {
                    $newSec = "0".$newSec;
                }
                $newTime = $newMin.':'.$newSec;
                echo "<h2 class='messagegameover time'>TIME: " .$newTime . "</h2>";
                echo "<h2 class='messagegameover recordscore'>NEW SCORE RECORD</h2>";
                echo "<h2 class='messagegameover recordtime'>NEW TIME RECORD</h2>";
            echo "</div>";
            // controllare se il time e' minore 
            // e se lo score e' maggiore e sostituire in caso

            $IDUser = $_SESSION["IDUser"];
            $minTime = $_SESSION["minTime"]; // time saved in db, ottenuto in game.php
            $maxScore = $_SESSION["maxScore"];

            // controllare se fatto nuovo record
            if($score > $maxScore) {

                echo "  <script>
                            var t = document.getElementsByClassName('recordscore');
                            t[0].style.visibility = 'visible';
                        </script>";
                
                // query per update score
                $sql = "UPDATE max_score SET Max_Score = CASE WHEN Max_Score < ? THEN ? ELSE Max_Score END WHERE IDUser = ?;";

                $stmt = mysqli_stmt_init($con);

                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("location: ./game_over.php?error=stmtfailedupdatescore");
                    exit();
                }        

                mysqli_stmt_bind_param($stmt, "sss", $score, $score, $IDUser);

                mysqli_stmt_execute($stmt);

                mysqli_stmt_close($stmt);
                // fine query
            }
                       

            // Bisogna controllare il time, quindi se minore del time salvato, solo se si vince!
            // cioè se tutti gli alieni sono stati uccisi
            if($didWin === true){
                // trasformare il dato "min:sec" in secondi
                if($minTime !== '0') {
                    list($min, $sec) = explode(":", $minTime);
                } else {
                    $min = 10; // valore alto cosi' sostituisce sicuramente
                    $sec = 0;
                }

                // se il tempo nel db e' maggiore di quello appena fatto
                // --> va cambiato
                if($min * 60 + $sec > $time) {
                    echo "  <script>
                                var t = document.getElementsByClassName('recordtime');
                                t[0].style.visibility = 'visible';
                            </script>";

                    // query per update Time
                    $sql = "UPDATE max_score SET Time = ? WHERE IDUser = ?;";

                    $stmt = mysqli_stmt_init($con);
        
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        header("location: ./game_over.php?error=stmtfailedupdatetime");
                        exit();
                    }        
        
                    mysqli_stmt_bind_param($stmt, "ss", $newTime, $IDUser);
        
                    mysqli_stmt_execute($stmt);
        
                    mysqli_stmt_close($stmt);
                    // fine query

                }
            }
            
            
            if(isset($_GET["error"])) {

                if ($_GET["error"] === "stmtfailedupdatescore" || $_GET["error"] === "stmtfailedupdatetime") {
                    echo "<small style=\"color: red\"> *problem updating table </small>";
                }
            }

            // codice per creare tabella html con i dati
            $result = mysqli_query($con,"SELECT * FROM user INNER JOIN max_score ON user.IDUser = max_score.IDUser");
            $cont = 0;
            echo "<table class=\"table-sortable\">
                <thead>
                    <tr>
                    <th>USERNAME</th>
                    <th>COUNTRY</th>
                    <th>MAX SCORE</th>
                    <th>MIN TIME</th>
                    </tr>
                </thead><tbody>";

            while($row = mysqli_fetch_array($result))
            {   
                $cont = $cont+1;
                echo "<tr>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['Country'] . "</td>";
                echo "<td>" . $row['Max_Score'] . "</td>";
                // pezzo per concatenare essendoci un if
                $html = '';
                $html .= "<td>";
                if($row['Time']==='0') {
                    $html .='N';
                } 
                else {
                    $html .= $row['Time'];
                } 
                echo $html."</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            
        ?>
               
        <div class="form-row-last">
            <input type="submit" name="submit" onclick="playAgain()" class="submit" value="PLAY AGAIN">
            <input type="submit" name="submit" onclick="logout()" class="submit" value="LOGOUT">
        </div>
        

        
        <script src="../js/utility.js"></script>
        


    </body>
</html>