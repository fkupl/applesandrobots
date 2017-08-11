<?php
session_start();
$_SESSION['name'] = "AppleEatingRobots";

 $rbt = 3;
 $steps = 20;
 $steps2win = 20;

 $colums = 10;
 $rows = 20;

 $stepsdone = 0;

    $player["x"] = rand(0,$colums-1);
    $player["y"] = rand(0,$rows-1);

    foreach($rbt as $i)
    {
        $robot[$i]["x"] = rand(0,$colums-1);
        $robot[$i]["y"] = rand(0,$colums-1);
    }
?>
<html>
    <head>
        <title>Apple eating Robots</title>
        <style>
            TABLE {
                border: 2px solid black
            }
        </style>
    </head>

    <body>
    <table class ="robots">
        <?

        foreach($rbt as $key => $value)
        {
            if ($player["x"] > $rbt[$key]["x"])
            {
                $rbt[$key]["x"]++;
            }
            else
            {
                $rbt[$key]["x"]--;
            }

            if ($player["y"] > $rbt[$key]["y"])
            {
                $rbt[$key]["y"]++;
            }
            else
            {
                $rbt[$key]["y"]--;
            }

            if($rbt[$key]["x"] == $player["x"] && $rbt[$key]["y"] = $player["y"])
            {
                echo 'You lose!';
            }
            elseif($stepsdone >= $steps2win)
            {
                echo 'You Win!';
            }
        }



        ?>
    </table>
    </body>
</html>
