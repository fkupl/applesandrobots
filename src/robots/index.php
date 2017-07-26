<?php 
session_start();
$max = 20;
$robots=3;
if(!isset($_SESSION["robots"]) || isset($_GET["restart"]))
{
	if(isset($_SESSION["robots"]))
		unset($_SESSION["robots"] );
	
	
	
	$apple["x"] = rand(0,$max);
	$apple["y"] = rand(0,$max);
	
	for($i=0;$i<$robots;$i++)
	{
		
		$robot[$i]["x"] = rand(0,$max);
		$robot[$i]["y"] = rand(0,$max);
		
		if($robot[$i]["x"] == $apple["x"] && $robot[$i]["y"] == $apple["y"])
		{
			$i--;
		}
	}
	$_SESSION["robots"] = $robot;
}
?>
<html>
<head>
</head>
<body>
<table border = "1" style="background-image: url(../logo.png);background-repeat:no-repeat;background-position:40% 40%;">
<?php

if(isset($_GET["x"]) && isset($_GET["y"]))
{
	$apple["x"] = $_GET["x"];
	$apple["y"] = $_GET["y"];
}
$robot = $_SESSION["robots"];

foreach($robot as $key=>$value)
{
	if($apple["x"] > $value["x"])
		$robot[$key]["x"]++;
	elseif($apple["x"] < $value["x"])
		$robot[$key]["x"]--;
	
	if($apple["y"] > $value["y"])
		$robot[$key]["y"]++;
	elseif($apple["y"] < $value["y"])
		$robot[$key]["y"]--;
}

$width=40;

for($i=0;$i<=$max;$i++)
{
	echo "<tr>";
		for($j=0;$j<=$max;$j++)
		{
			$set = false;
			$image = "";
			$appleset=false;
			$locked=array();
			echo '<td style="height:'.$width.'px;width:'.$width.'px;">';
			if($i == $apple["x"] && $j == $apple["y"])
			{
				$appleset = true;
				echo '<img style="width:'.$width.'px;" src="./jenna.png"/>';
			}
			
			foreach($robot as $key=>$value)
			{
				if($robot[$key]["x"] == $i && $robot[$key]["y"] == $j)
				{
					if(isset($locked[$i."_".$j]))
					{
						unset($robot[$key]);
						unset($robot[$locked[$i."_".$j]]);
						echo '<a href="./index.php?x='.$i.'&y='.$j.'"><img style="width:'.$width.'px;" src="./empty.png"/></a>';
						continue;
					}
					else
					{
						$locked[$i."_".$j] = $key;
					}
					$set = true;
					echo '<img style="width:'.$width.'px;" src="./herold.png"/>';
				}
				if($robot[$key]["x"] == $apple["x"] && $robot[$key]["y"] == $apple["y"])
				{
					echo "Gameover. New Game? <a href ='./index.php?restart'>Yes!</a>";
				    //header("location: ./gameover.php");
					exit;
				}
			}
			
			if(!$set && !$appleset)
			{
				echo '<a href="./index.php?x='.$i.'&y='.$j.'"><img style="width:'.$width.'px;" src="./empty.png"/></a>';
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