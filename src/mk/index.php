<?php session_start(); ?>
<html>
<head>
<style>
.center {
    width:100%;
    height:100%;
  }
  table {
    margin: 0 auto; /* or margin: 0 auto 0 auto */
  }
  .tdstyle {
	  border: 1px solid #0063dc;height: 55px; width: 55px; text-align: center; border-radius: 5px;
  }
  .inputstyle {
	  height: 49px; width: 49px; background:black; border:0 none; cursor:pointer;
  }
</style></head>
<body style="background-color: black; text-align: center; color: white;">
<span><img src="aliens.png"</span>

<?php
// Size for the playing area
const WIDTH = 15;
const HEIGHT = 15;

// design resources
$alien = 'alien.png';
$alien2 = 'alien2.png';
$alien3 = 'alien3.png';
$ripley = 'ripley.png';

// Set Ripley's and Alien's first position, if there is not session entry)
if (!isset($_SESSION["ripleypos"])) {
    $_SESSION["ripleypos"] = $ripleypos = array("x" => rand(0, WIDTH), "y" => rand(0, HEIGHT));
    $_SESSION["alienpos"] = $alienpos = array("x" => rand(0, WIDTH), "y" => rand(0, HEIGHT));
    $_SESSION["alienpos2"] = $alienpos2 = array("x" => rand(0, WIDTH), "y" => rand(0, HEIGHT));
    $_SESSION["alienpos3"] = $alienpos3 = array("x" => rand(0, WIDTH), "y" => rand(0, HEIGHT));
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

    (int) $position = explode(".", $_POST['position']);

    // Ripley Movement
    if ($ripleypos["x"] < $position[0]) {
        $ripleypos["x"] = $position[0];
        $_SESSION["ripleypos"] = $ripleypos;
    }
    if ($ripleypos["x"] > $position[0]) {
        $ripleypos["x"] = $position[0];
        $_SESSION["ripleypos"] = $ripleypos;
    }

    if ($ripleypos["y"] > $position[1]) {
        $ripleypos["y"] = $position[1];
        $_SESSION["ripleypos"] = $ripleypos;
    }
    if ($ripleypos["y"] < $position[1]) {
        $ripleypos["y"] = $position[1];
        $_SESSION["ripleypos"] = $ripleypos;
    }

    // Alien  Movement
    if ($ripleypos["x"] <= $alienpos["x"]) {
        $alienpos["x"] = $alienpos["x"] - 1;
        $_SESSION["alienpos"] = $alienpos;
    }

    if ($ripleypos["x"] >= $alienpos["x"]) {
        $alienpos["x"] = $alienpos["x"] + 1;
        $_SESSION["alienpos"] = $alienpos;
    }

    if ($ripleypos["y"] <= $alienpos["y"]) {
        $alienpos["y"] = $alienpos["y"] - 1;
        $_SESSION["alienpos"] = $alienpos;
    }

    if ($ripleypos["y"] >= $alienpos["y"]) {
        $alienpos["y"] = $alienpos["y"] + 1;
        $_SESSION["alienpos"] = $alienpos;
    }

    // Alien2  Movement
    if ($ripleypos["x"] <= $alienpos2["x"]) {
        $alienpos2["x"] = $alienpos2["x"] - 1;
        $_SESSION["alienpos2"] = $alienpos2;
    }

    if ($ripleypos["x"] >= $alienpos2["x"]) {
        $alienpos2["x"] = $alienpos2["x"] + 1;
        $_SESSION["alienpos2"] = $alienpos2;
    }

    if ($ripleypos["y"] <= $alienpos2["y"]) {
        $alienpos2["y"] = $alienpos2["y"] - 1;
        $_SESSION["alienpos2"] = $alienpos2;
    }

    if ($ripleypos["y"] >= $alienpos2["y"]) {
        $alienpos2["y"] = $alienpos2["y"] + 1;
        $_SESSION["alienpos2"] = $alienpos2;
    }

    // Alien3  Movement
    if ($ripleypos["x"] <= $alienpos3["x"]) {
        $alienpos3["x"] = $alienpos3["x"] - 1;
        $_SESSION["alienpos3"] = $alienpos3;
    }

    if ($ripleypos["x"] >= $alienpos3["x"]) {
        $alienpos3["x"] = $alienpos3["x"] + 1;
        $_SESSION["alienpos3"] = $alienpos3;
    }

    if ($ripleypos["y"] <= $alienpos3["y"]) {
        $alienpos3["y"] = $alienpos3["y"] - 1;
        $_SESSION["alienpos3"] = $alienpos3;
    }

    if ($ripleypos["y"] >= $alienpos3["y"]) {
        $alienpos3["y"] = $alienpos3["y"] + 1;
        $_SESSION["alienpos3"] = $alienpos3;
    }


    if ($_SESSION["runningCounter"] === 5 && ($ripleypos != $alienpos || $ripleypos != $alienpos2 || $ripleypos != $alienpos3)) {

        echo "<div style=\"color: #0063dc; font-size: 20px; text-align:center;\">YOU ESCAPED! New Game start by click!<div>";

        $_SESSION["runningCounter"] = 0;
        session_regenerate_id();
        $_SESSION["NEWID"] = session_id();
        $_SESSION["ripleypos"] = null;

    }

    if($ripleypos == $alienpos || $ripleypos == $alienpos2 || $ripleypos == $alienpos3)
    {
		if($ripleypos == $alienpos)
			$alienkiller = "Alien";
		if($ripleypos == $alienpos2)
			$alienkiller = "Alien 2";
		if($ripleypos == $alienpos3)
			$alienkiller = "Alien 3";	
		
        echo "<div style=\"color: #0063dc; font-size: 20px; text-align:center;\">YOU DIED! Killed by $alienkiller - New Game start by click!<div>";
        $_SESSION["runningCounter"] = 0;
        session_regenerate_id();
        $_SESSION["NEWID"] = session_id();
        $_SESSION["ripleypos"] = null;
    }

}

?>
<div class="center">
<form method="post">
    <table>
        <?php

        for ($height = 0; $height < HEIGHT; $height++) {
            echo "<tr>";
            for ($width = 0; $width < WIDTH; $width++) {

			if ($ripleypos == $alienpos || $ripleypos == $alienpos2 || $ripleypos == $alienpos3) {
					echo "<td class=\"tdstyle\"><input class=\"inputstyle\" value='$width.$height' type=\"submit\" name=\"position\" /></td>" . PHP_EOL;
				}
                elseif ($ripleypos["x"] == $width && $ripleypos["y"] == $height) {
                    echo "<td class=\"tdstyle\"><img src=\"$ripley\"/></td>" . PHP_EOL;
                } elseif ($alienpos["x"] == $width && $alienpos["y"] == $height) {
                    echo "<td class=\"tdstyle\"><img src=\"$alien\"/></td>" . PHP_EOL;
                } elseif ($alienpos2["x"] == $width && $alienpos2["y"] == $height) {
                    echo "<td class=\"tdstyle\"><img src=\"$alien2\"/></td>" . PHP_EOL;
                } elseif ($alienpos3["x"] == $width && $alienpos3["y"] == $height) {
                    echo "<td class=\"tdstyle\"><img src=\"$alien3\"/></td>" . PHP_EOL;
                } 
				else {
                    $position = array('newx' => $width, 'newy' => $height);
                    echo "<td class=\"tdstyle\"><input class=\"inputstyle\" value='$width.$height' type=\"submit\" name=\"position\" /></td>". PHP_EOL;
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