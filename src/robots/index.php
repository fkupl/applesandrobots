<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

session_start();
echo "Try to escape as long as possible from beeing eaten by the robots.<br/>Do this by clicking on neighbour fields, allowed are horizontal, vertical and diagonal, only one field-steps are allowed (carefull there's no check for this rule implemented now, so cheating is possible)";
$max = 20;
$stepsToWin=3;
$robots = 3;
if (!isset($_SESSION["robots"]) || isset($_GET["restart"])) {
    if (isset($_SESSION["robots"])) {
        unset($_SESSION["robots"]);
    }

    $playerPos["x"] = rand(0, $max);
    $playerPos["y"] = rand(0, $max);

    for ($i = 0; $i < $robots; $i++) {
        $robot[$i]["x"] = rand(0, $max);
        $robot[$i]["y"] = rand(0, $max);

        if ($robot[$i]["x"] == $playerPos["x"] && $robot[$i]["y"] == $playerPos["y"]) {
            unset($robot[$i]);
            $i--;
        }
    }
    $_SESSION["robots"] = $robot;
    $_SESSION["doneSteps"]=0;
}
?>
<html>
<head>
</head>
<body>
<table border="1" style="background-image: url(../logo.png);background-repeat:no-repeat;background-position:40% 40%;">
    <?php
    if($_SESSION["doneSteps"]>=$stepsToWin) {
        echo '<div style="width:30%;margin:auto;top:45%;text-align:center;"><h1>You\'ve won! Congratulations.<br/> New Game? <a href ="./index.php?restart">Yes!</a></h1></div>';
        die;
    }

    $_SESSION["doneSteps"]++;
    if (isset($_GET["x"]) && isset($_GET["y"])) {
        $playerPos["x"] = $_GET["x"];
        $playerPos["y"] = $_GET["y"];
    }
    $robot = $_SESSION["robots"];

    foreach ($robot as $key => $value) {
        if ($playerPos["x"] > $value["x"]) {
            $robot[$key]["x"]++;
        } elseif ($playerPos["x"] < $value["x"]) {
            $robot[$key]["x"]--;
        }

        if ($playerPos["y"] > $value["y"]) {
            $robot[$key]["y"]++;
        } elseif ($playerPos["y"] < $value["y"]) {
            $robot[$key]["y"]--;
        }
    }

    $width = 40;

    for ($i = 0; $i <= $max; $i++) {
        echo "<tr>";
        for ($j = 0; $j <= $max; $j++) {
            $set = false;
            $image = "";
            $appleset = false;
            $locked = array();
            echo '<td style="height:' . $width . 'px;width:' . $width . 'px;">';
            if ($i == $playerPos["x"] && $j == $playerPos["y"]) {
                $appleset = true;
                echo '<img style="width:' . $width . 'px;" src="../ressources/jenna.png"/>';
            }

            foreach ($robot as $key => $value) {
                if ($robot[$key]["x"] == $i && $robot[$key]["y"] == $j) {
                    if (isset($locked[$i . "_" . $j])) {
                        unset($robot[$key]);
                        unset($robot[$locked[$i . "_" . $j]]);
                        echo '<a href="./index.php?x=' . $i . '&y=' . $j . '"><img style="width:' . $width . 'px;" src="../ressources/empty.png"/></a>';
                        continue;
                    } else {
                        $locked[$i . "_" . $j] = $key;
                    }
                    $set = true;
                    echo '<img style="width:' . $width . 'px;" src="../ressources/robot.png"/>';
                }
                if ($robot[$key]["x"] == $playerPos["x"] && $robot[$key]["y"] == $playerPos["y"]) {
                    echo "Gameover. New Game? <a href ='./index.php?restart'>Yes!</a>";
                    //header("location: ./gameover.php");
                    exit;
                }
            }

            if (!$set && !$appleset) {
                echo '<a href="./index.php?x=' . $i . '&y=' . $j . '"><img style="width:' . $width . 'px;" src="../ressources/empty.png"/></a>';
            }

            echo '</td>';
        }
        $_SESSION["robots"] = $robot;
        echo "</tr>";
    }

    ?>
</table>

</body>
</html>