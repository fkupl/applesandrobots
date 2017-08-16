<?php session_start();

/** Changeable game settings */
const WIDTH = 8;
const HEIGHT = 8;
const COUNT_OF_ALIENS = 3;
const COUNT_OF_LIVES = 3;
const COUNT_OF_STEPS = 10;

/** Design resources */
$alien_img = 'resources/alien.png';
$ripley_img = 'resources/ripley.png';


/** Set Ripley's and Alien's first position, if there is not session entry) */
if (!isset($_SESSION["ripleypos"])) {
    $_SESSION["ripleyLives"] = COUNT_OF_LIVES;
    $_SESSION["ripleypos"] = $ripleyPos = array("x" => rand(0, WIDTH), "y" => rand(0, HEIGHT));
    $_SESSION["runningCounter"] = 0;
    $_SESSION["ID"] = session_id();

    // Create Aliens
    for ($alienCounter = 0; $alienCounter < COUNT_OF_ALIENS; $alienCounter++) {
        $aliens[$alienCounter]["alien"] = 'Alien ' . $alienCounter;
        $aliens[$alienCounter]["x"] = rand(0, WIDTH);
        $aliens[$alienCounter]["y"] = rand(0, HEIGHT);
    }

    $_SESSION["alienpositions"] = $aliens;
}

/** Positions */
$ripleyPos = $_SESSION["ripleypos"];
$aliens = $_SESSION["alienpositions"];


/**  Movement  */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $_SESSION["runningCounter"] = $_SESSION["runningCounter"] + 1;

    $position = explode(".", $_POST['position']);

    /** Ripley's Movement */
    if ($ripleyPos["x"] < $position[0]) {
        $ripleyPos["x"] = $position[0];
        $_SESSION["ripleypos"] = $ripleyPos;
    }
    if ($ripleyPos["x"] > $position[0]) {
        $ripleyPos["x"] = $position[0];
        $_SESSION["ripleypos"] = $ripleyPos;
    }

    if ($ripleyPos["y"] > $position[1]) {
        $ripleyPos["y"] = $position[1];
        $_SESSION["ripleypos"] = $ripleyPos;
    }
    if ($ripleyPos["y"] < $position[1]) {
        $ripleyPos["y"] = $position[1];
        $_SESSION["ripleypos"] = $ripleyPos;
    }

    /** Aliens movements */
    foreach ($aliens as $key => $value) {
        if ($ripleyPos["x"] < $aliens[$key]["x"]) {
            $aliens[$key]["x"]--;
        }
        if ($ripleyPos["x"] > $aliens[$key]["x"]) {
            $aliens[$key]["x"]++;
        }
        if ($ripleyPos["y"] < $aliens[$key]["y"]) {
            $aliens[$key]["y"]--;
        }
        if ($ripleyPos["y"] > $aliens[$key]["y"]) {
            $aliens[$key]["y"]++;
        }

        /** Check if Ripley and Aliens positions are the same, remove Alien and one hearth - perhaps Ripley is dead now */
        if ($aliens[$key]["x"] == $ripleyPos["x"] && $aliens[$key]["y"] == $ripleyPos["y"]) {
            $_SESSION["ripleyLives"] = $_SESSION["ripleyLives"] - 1;
            unset($aliens[$key]);

            if ($_SESSION["ripleyLives"] == 0) {
                playerDied();
            }
        }

        $_SESSION["alienpositions"] = $aliens;

    }

    /** Check if Ripley reached the COUNT_OF_STEPS */
    if ($_SESSION["runningCounter"] === COUNT_OF_STEPS && $_SESSION["ripleyLives"] > 0) {
        playerWon();
    }

}

/** Player won, reset the game */
function playerWon()
{
    echo "<div class=\"winner\">YOU ESCAPED! New Game start by click!<div>";
    resetGame();
}

/** Player died, reset the game */
function playerDied()
{
    echo "<div class=\"loser\">YOU DIED! New Game start by click!<div>";
    $_SESSION["ripleyLives"] = 0;
    resetGame();
}

/** Reset the game, start a new round */
function resetGame()
{
    $_SESSION["runningCounter"] = 0;
    session_regenerate_id();
    $_SESSION["NEWID"] = session_id();
    $_SESSION["ripleypos"] = null;
    $_SESSION["alienpositions"] = null;

}


?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div><img src="resources/aliens.png"</div>

<div class="center">
    <div><?php echo "<img src=\"$ripley_img\"/>:" . $_SESSION["ripleyLives"] . " X" ?></div>
    <form method="post">
        <table>
            <?php
            for ($height = 0; $height < HEIGHT; $height++) {
                echo "<tr>";
                for ($width = 0; $width < WIDTH; $width++) {

                    $setByAlien = false;
                    echo "<td class=\"tdstyle\">";

                    if ($ripleyPos["x"] == $width && $ripleyPos["y"] == $height) {
                        echo "<img src=\"$ripley_img\"/>" . PHP_EOL;
                    } else {
                        foreach ($aliens as $alien) {
                            if ($alien["x"] == $width && $alien["y"] == $height) {
                                $setByAlien = true;
                                echo "<img src=\"$alien_img\"/>" . PHP_EOL;
                            }
                        }
                    }

                    if (!$setByAlien && ($ripleyPos["x"] != $width || $ripleyPos["y"] != $height)) {
                        echo "<input class=\"inputstyle\" value='$width.$height' type=\"submit\" name=\"position\" />";
                    }

                }
                echo "</tr>";
            }

            ?>
        </table>
    </form>
</div>
</body>

</html>