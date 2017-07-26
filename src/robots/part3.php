<html>
<head>
</head>
<body>
<table border = "1" style="background-image: url(../logo.png);background-repeat:no-repeat;background-position:40% 40%;">

    <?php
    /**
     * Created by PhpStorm.
     * User: Notebook
     * Date: 25.07.2017
     * Time: 21:25
     */

    //Let's start by defining some variables for amount of rows and columns to keep things scalable
    $amountRows = 15;
    $amountColumns = 15;
    //since we do not now the size of future icons used in the grid, we keep the Cell-Width Variable from the beginning
    $emptyCellWidth = 30;
    /***************************************************/
    //this was moved up here from down below to make sure
    // that player and bot do not get equal startposition
    // and cause an instant loss
    $lockedSpots=array();

    //initialize our player position
    $player = array();
    $player["x"] = rand(0,$amountColumns-1);
    $player["y"] = rand(0,$amountRows-1);

    //add the player positions to the lockedSpots array
    $lockedSpots[] = $player["x"] . "|" . $player["y"];
    /***************************************************/

    //Let's randomize some bot positions and
    // keep things variable again...
    $amountOfBots = 5;
    $botPositions = array();


    for($botId=0;$botId<$amountOfBots;$botId++) {
        //make sure we don't get doublets which effectively reduces amount of bots
        do {
            $x = rand(0,$amountColumns-1);
            $y = rand(0,$amountRows-1);
        } while(in_array($x."|".$y, $lockedSpots));

        $lockedSpots[] = $x."|".$y;

        $botPositions[$botId]["x"] = $x;
        $botPositions[$botId]["y"] = $y;
    }

    //Outer loop for the rows...
    for($i=0;$i<$amountRows;$i++) {
        echo "<tr>";
        //now the inner loop for the cells...
        for($j=0;$j<$amountColumns;$j++) {
            // Here we have to check whether the current cell
            // matches one of the bots positions
            $placeBot=false;
            foreach($botPositions as $botId=>$positions) {
                if($i==$positions["y"] && $j==$positions["x"]) {
                    $placeBot=$botId;
                    break;
                }
            }

            /***************************************************/
            //Set player to it's position
            if($i==$player["y"] && $j==$player["x"]) {
                echo '<td><img style="width:' . $emptyCellWidth . 'px;" src="../ressources/jenna.png"/></td>';
                continue;
            }
            /***************************************************/

            if($placeBot!==false) {
                echo '<td><img style="width:' . $emptyCellWidth . 'px;" src="../ressources/herold.png"/ alt="BotId: '.$placeBot.'"></td>';
                continue;
            }

            echo '<td><a href="./part3.php?cmd=moveToCoord&x='.$j.'&y='.$i.'"><img style="width:'.$emptyCellWidth.'px;" src="../ressources/empty.png"/></a></td>';

        }

        echo "</tr>";
    }


    ?>
</table>

</body>
</html>
