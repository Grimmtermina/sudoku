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
<body onload="generatePuzzle('load');">
	<?php 
	   require_once './model.php';
	   session_start();
	?>
	<h1>SUDOKU CHALLENGE</h1>
	<div class="btnbar">
		<?php
    	// Session-specific button functionality
        if(!isset($_SESSION['user'])) {
            echo '<a class="btn" href="login.php">Login</a>';
        }
        ?>
        <a class="btn" onclick="generatePuzzle('new');">New Puzzle</a>
    	<a class="btn" href="highScore.php">View High Scores</a>
    	<?php
    	// Session-specific button functionality
        if(isset($_SESSION['user'])) {
            echo '<br><br><form class="form" action="controller.php" method="POST">';
            echo '<input class="btn" type="submit" name="difficulty" value="Change Difficulty">';
            echo '  <input class="btn" type="submit" name="logout" value="Logout">';
            echo '</form><br>';
        }
        ?>
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
	echo '</div>';
	?>
	
	<script>
	var puzzleArray = [];
	var intArray = [];
	
	// TODO: Change function to allow random number generation w/in sudoku guidelines
	// Should generate full puzzle and randomize which are hidden based on difficulty
	function generatePuzzle(setting) {
		var boxNum = "";
		
		if ((setting == 'load' && localStorage.getItem('generated') != 'true') || setting == 'new') {
    		for (var i = 0; i < 81; i++) {
    			boxNum = (i + 1).toString();
    			puzzleArray[i] = document.getElementById(boxNum);
    		}
    		for (var i = 0; i < puzzleArray.length; i++) {
        		intArray[i] = parseInt(Math.floor(Math.random()*(9)+1));
    			puzzleArray[i].innerHTML = "<b>" + intArray[i] + "</b>";
    		}
    		localStorage.setItem('generated', 'true');
			localStorage.setItem('intArray', JSON.stringify(intArray));
		}
		
		else {
			intArray = localStorage.getItem('intArray');
			intArray = (intArray) ? JSON.parse(intArray) : [];
			
			for (var i = 0; i < 81; i++) {
    			boxNum = (i + 1).toString();
    			puzzleArray[i] = document.getElementById(boxNum);
    		}
    		
    		for (var i = 0; i < puzzleArray.length; i++) {;
    			puzzleArray[i].innerHTML = "<b>" + intArray[i] + "</b>";
    		}
		}
	}

	</script>
</body>
</html>