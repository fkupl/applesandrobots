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
//Let's randomize some bot positions and
// keep things variable again...
$amountOfBots = 5;
$botPositions = array();
$lockedSpots=array();

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

/***************************************************/

//Outer loop for the rows...
for($i=0;$i<$amountRows;$i++) {
    echo "<tr>";
    //now the inner loop for the cells...
    for($j=0;$j<$amountColumns;$j++) {
        /***************************************************/
        // Here we have to check whether the current cell
        // matches one of the bots positions
        $placeBot=false;
        foreach($botPositions as $botId=>$positions) {
            if($i==$positions["y"] && $j==$positions["x"]) {
                $placeBot=$botId;
                break;
            }
        }

        if($placeBot!==false) {
            echo '<td><img style="width:' . $emptyCellWidth . 'px;" src="../ressources/herold.png"/>'.$placeBot.'</td>';
            continue;
        }
        /***************************************************/

        echo '<td><img style="width:'.$emptyCellWidth.'px;" src="../ressources/empty.png"/></td>';
    }

    echo "</tr>";
}


?>
</table>

</body>
</html>
