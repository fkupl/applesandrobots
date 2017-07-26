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
 * Time: 21:10
 */

//Let's start by defining some variables for amount of rows and columns to keep things scalable
$amountRows = 20;
$amountColumns = 20;
//since we do not now the size of future icons used in the grid, we keep the Cell-Width Variable from the beginning
$emptyCellWidth = 30;

//Outer loop for the rows...
for($i=0;$i<$amountRows;$i++) {
    echo "<tr>";
    //now the inner loop for the cells...
    for($j=0;$j<$amountColumns;$j++) {
        echo '<td><img style="width:'.$emptyCellWidth.'px;" src="../ressources/empty.png"/></td>';
    }

    echo "</tr>";
}


?>
</table>

</body>
</html>
