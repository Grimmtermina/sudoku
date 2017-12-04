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
<body onload="generatePuzzle('load', 'easy');">
	<?php
	require_once './model.php';
	session_start ();
	?>
	<h1>SUDOKU CHALLENGE</h1>
	<div class="btnbar">
		<?php
		// Session-specific button functionality
		if (! isset ( $_SESSION ['user'] )) {
			echo '<a class="btn" href="login.php">Login</a>';
		}
		?>
        <a class="btn" onclick="generatePuzzle('new', 'easy');">New Puzzle</a> <a
			class="btn" href="highScore.php">View High Scores</a>
    	<?php
					// Session-specific button functionality
					if (isset ( $_SESSION ['user'] )) {
						echo '<br><br><form class="form" action="controller.php" method="POST">';
						echo '<input class="btn" type="submit" name="difficulty" value="Change Difficulty">';
						echo '  <select class="btn" name="difficulty">
                        <option>Easy</option>
					    <option>Medium</option>
					    <option>Hard</option></select>';
						echo '</form><br>';
					}
					?>
	</div>
	<br>
    
	<?php
	// Automates the writing of 81 boxes organized into 9 subsections
	echo '<div class="puzzle">';
	for($i = 1; $i < 82; $i ++) {
		if ($i == 1) {
			echo '<div class="topLeftBox" id="' . $i . '"></div>';
		} else if ($i == 9) {
			echo '<div class="topRightBox" id="' . $i . '"></div>';
		} else if ($i == 73 || $i == 19 || $i == 46) {
			echo '<div class="bottomLeftBox" id="' . $i . '"></div>';
		} else if ($i == 81 || $i == 54 || $i == 27 || $i == 24 || $i == 21 || $i == 51 || $i == 48) {
			echo '<div class="bottomRightBox" id="' . $i . '"></div>';
		} else if ($i == 19) {
		} else if ($i < 10) {
			if ($i % 9 == 3 || $i % 9 == 6) {
				echo '<div class="topRightBox" id="' . $i . '"></div>';
			} else {
				echo '<div class="topBox" id="' . $i . '"></div>';
			}
		} else if ($i > 72 || $i == 22 || $i == 25 || $i == 20 || $i == 23 || $i == 26 || $i == 47 || $i == 50 || $i == 49 || $i == 53 || $i == 52) {
			if ($i % 9 == 3 || $i % 9 == 6) {
				echo '<div class="bottomRightBox" id="' . $i . '"></div>';
			} else {
				echo '<div class="bottomBox" id="' . $i . '"></div>';
			}
		} else if ($i % 9 == 1) {
			echo '<div class="leftBox" id="' . $i . '"></div>';
		} else if ($i % 9 == 0) {
			echo '<div class="rightBox" id="' . $i . '"></div>';
		} else if ($i % 9 == 3 || $i % 9 == 6) {
			echo '<div class="rightBox" id="' . $i . '"></div>';
		} else {
			echo '<div class="box" id="' . $i . '"></div>';
		}
	}
	echo '</div>';
	?>
	
	<script>
	var array = [];
	var puzzleArray = [];
	var intArray;
	var flagArray = [];
	
	// Should generate full puzzle and randomize which are hidden based on difficulty
	function generatePuzzle(setting, difficulty) {
		var boxNum = "";
		getNewPuzzle();
		console.log(sessionStorage.getItem('generated'));
		if ((setting == 'load' && sessionStorage.getItem('generated') != 'true') || setting == 'new') {
			
    		for (var i = 0; i < 81; i++) {
    			boxNum = (i + 1).toString();
    			puzzleArray[i] = document.getElementById(boxNum);
    		}
    		for (var i = 0; i < puzzleArray.length; i++) {
    			puzzleArray[i].innerHTML = "<b>" + intArray[i] + "</b>";
    		}
    		sessionStorage.setItem('generated', 'true');

			sessionStorage.setItem('intArray', JSON.stringify(intArray));
		}
		else {
			intArray = sessionStorage.getItem('intArray');
			intArray = (intArray) ? JSON.parse(intArray) : [];
			for (var i = 0; i < 81; i++) {
    			boxNum = (i + 1).toString();
    			puzzleArray[i] = document.getElementById(boxNum);
    		}
    		
    		for (var i = 0; i < puzzleArray.length; i++) {;
    			puzzleArray[i].innerHTML = "<b>" + intArray[i] + "</b>";
    		}
		}

		if(difficulty === 'easy'){
			for(var i = 0; i < 81; i++){
				flagArray[i] = 0;
			}
			for(var i = 0; i < 9; i++){
				var one = Math.floor(Math.random()*9);
				var two = Math.floor(Math.random()*9);
				while(one == two){
					two = Math.floor(Math.random()*9);
				}
				console.log(one + " " + two);

				one = i*9 + one + 1;
				two = i*9 + two + 1;
				//flag the boxes we'll be changing so we can find them easily.
				flagArray[one-1] = 1;
				flagArray[two-1] = 1;
				//replace with text boxes
				puzzleArray[one-1].innerHTML = "<input type='text' id='inputBox" + one + "'>";
				puzzleArray[two-1].innerHTML = "<input type='text' id='inputBox" + two + "'>";
			}
			sessionStorage.setItem('flagArray', JSON.stringify(flagArray));
		}
	}

	function getNewPuzzle(){
		var anObj = new XMLHttpRequest();
		anObj.open("GET", "puzzle_gen.php", true);
		anObj.send();
		anObj.onreadystatechange = function() {
			if (anObj.readyState == 4 && anObj.status == 200) {
				array = JSON.parse(anObj.responseText);
				intArray = array;
			}
		};
	}
	</script>
</body>
</html>