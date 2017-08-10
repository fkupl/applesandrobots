<html>
<head></head>
<body style="background-color: black; text-align: center">
<span><img src="aliens.png"</span>

<?php
session_start();

// Some data ;)
const COLS = 100;
$alien = 'alien.png';
$ripley = 'ripley.png';
$i = 0;

// Set Ripley's and Alien's first position, if there is not session entry
if (!isset($_SESSION["ripleypos"]) || ($_SESSION["ID"] != $_SESSION["NEWID"])) {
    $_SESSION["ripleypos"] = $ripleypos = rand(0, COLS - 1);
    $_SESSION["alienpos"] = $alienpos = rand(0, COLS - 1);
    $_SESSION["alienpos2"] = $alienpos2 = rand(0, COLS - 1);
    $_SESSION["alienpos3"] = $alienpos3 = rand(0, COLS - 1);
    $_SESSION["runningCounter"] = 0;
    $_SESSION["ID"] = session_id();
}
// Positions
$ripleypos = $_SESSION["ripleypos"];
$alienpos = $_SESSION["alienpos"];
$alienpos2 = $_SESSION["alienpos2"];
$alienpos3 = $_SESSION["alienpos3"];

// If user run with Ripley, set her new position
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION["runningCounter"] = $_SESSION["runningCounter"] + 1;

    if ($_SESSION["runningCounter"] === 5 && ($ripleypos != $alienpos || $ripleypos != $alienpos2 || $ripleypos != $alienpos3)) {

        echo "<div style=\"color: #0063dc; font-size: 20px; text-align:center;\">YOU ESCAPED! New Game start by click!<div>";

        $_SESSION["runningCounter"] = 0;
        session_regenerate_id();
        $_SESSION["NEWID"] = session_id();


    }

    if ($ripleypos != $_POST['alter']) {
        $_SESSION["ripleypos"] = $ripleypos = $_POST['alter'];

    }
}

?>

<form method="post">
    <table>
        <?php

        while ($i < COLS) {
            if ($i % 10 == 0) {
                echo "<tr>";
            }
            //<td style="border: 1px solid #0063dc;height: 55px; width: 55px; text-align: center; border-radius: 5px;"
            if ($i == $ripleypos) {
                echo "<td style=\"border: 1px solid #0063dc;height: 55px; width: 55px; text-align: center; border-radius: 5px;\"><img src=\"$ripley\"/></td>"; // ripley pos
            } elseif ($i == $alienpos && $alienpos != $ripleypos && $alienpos != $alienpos2 && $alienpos != $alienpos3) {
                echo "<td style=\"border: 1px solid #0063dc;height: 55px; width: 55px; text-align: center; border-radius: 5px;\"><img src=\"$alien\"/></td>"; // alien 1 pos
            } elseif ($i == $alienpos2 && $alienpos2 != $ripleypos && $alienpos2 != $alienpos && $alienpos2 != $alienpos3) {
                echo "<td style=\"border: 1px solid #0063dc;height: 55px; width: 55px; text-align: center; border-radius: 5px;\"><img src=\"$alien\"/></td>"; // alien 2 pos
            } elseif ($i == $alienpos3 && $alienpos3 != $ripleypos && $alienpos3 != $alienpos && $alienpos3 != $alienpos2) {
                echo "<td style=\"border: 1px solid #0063dc;height: 55px; width: 55px; text-align: center; border-radius: 5px;\"><img src=\"$alien\"/></td>"; // alien 3 pos
            } else {
                echo "<td style=\"border: 1px solid #0063dc;height: 55px; width: 55px; text-align: center; border-radius: 5px;\"><input style='height: 49px; width: 49px; background:black; border:0 none; cursor:pointer;' value='$i' type=\"submit\" name=\"alter\" /></td>" . PHP_EOL; // empty
            }

            $i++;
            if ($i % 10 == 0) {
                echo "</tr>";
            }
        }

        ?>
    </table>
</form>
</body>

</html>