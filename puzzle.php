<!DOCTYPE html>

<!-- AUTHORS: Andrew Miller & Saile Daimwood -->
<!-- DESCRIPTION: A randomly-generated Sudoku webpage that can be
increased in difficulty by logging in with a verified username and 
password. Registration is done through the login page right now. -->

<html>
<head>
<meta charset="UTF-8">
<link href="sudoku.css" rel="stylesheet" type="text/css" />
<title>Sudoku</title>
</head>
<body onload="generatePuzzle();">
	<h1>SUDOKU CHALLENGE</h1>
	<div class="btnbar">
    	<a class="btn" href="login.php">Login</a>
    	<a class="btn" href="highScore.php">View High Scores</a>
	</div><br>
	<?php 
	// Automates the writing of 81 boxes organized into 9 subsections
	echo '<div class="puzzle"><div class="puzzleSection">';
	for ($i = 1; $i < 82; $i++) {
	    echo '<div class="box" id="' . $i . '"></div>';
	    if ($i % 9 == 0 && $i != 81) {
	        echo '</div><div class="puzzleSection">';
	    }
	    if ($i == 81) {
	        echo '</div>';
	    }
	}
	echo '</div>'
	?>
	
	<script>
	var array = [];
	var puzzleArray = [];
	function generatePuzzle() {
		var boxNum = "";
		for (var i = 0; i < 81; i++) {
			boxNum = (i + 1).toString();
			puzzleArray[i] = document.getElementById(boxNum);
		}
		for (var i = 0; i < puzzleArray.length; i++) {
			puzzleArray[i].innerHTML = "<b>" + i + "<b>";
		}
	}
	</script>
</body>
</html>