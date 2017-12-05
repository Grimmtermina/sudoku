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
        <a class="btn" onclick="generatePuzzle('new');">New Puzzle</a> 
        <a class="btn" href="highScore.php">View High Scores</a>
    	<?php
		// Session-specific button functionality
		if (isset ( $_SESSION ['user'] )) {
			echo '<br><br><form class="form" action="controller.php" method="POST">';
			echo '<select class="btn" name="mode" onchange=this.form.submit()>
            <option value="none">Difficulty</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option></select>';
			echo '   <input class="btn" type="submit" name="logout" value="Logout">';
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
	function generatePuzzle(setting) {
		var boxNum = "";

		// Set difficulty to easy if it's not set
		if (<?php echo isset($_SESSION['difficulty'])?>) {
			var difficulty = '<?php echo $_SESSION['difficulty'];?>';
		}
		else {
			var difficulty = 'easy';
		}
		
		getNewPuzzle();
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
		
		if(sessionStorage.getItem('generated') === 'true' && setting != 'new'){
			flagArrayTemp = sessionStorage.getItem('flagArray');
			flagArrayTemp = (flagArrayTemp) ? JSON.parse(flagArrayTemp) : [];

			for(var i = 0; i < 81; i++){
				if(flagArrayTemp[i] == 1){
					var val = i + 1;
					puzzleArray[i].innerHTML = "<input type='text' id='inputBox" + val + "' class='sudokuInput'>";
				}
			}
		} else if(difficulty === 'easy'){
			for(var i = 0; i < 81; i++){
				flagArray[i] = 0;
			}
			for(var i = 0; i < 9; i++){
				var one = Math.floor(Math.random()*9);
				var two = Math.floor(Math.random()*9);
				while(one == two){
					two = Math.floor(Math.random()*9);
				}

				one = i*9 + one + 1;
				two = i*9 + two + 1;
				//flag the boxes we'll be changing so we can find them easily.
				flagArray[one-1] = 1;
				flagArray[two-1] = 1;
				//replace with text boxes
				puzzleArray[one-1].innerHTML = "<input type='text' id='inputBox" + one + "' class='sudokuInput'>";
				puzzleArray[two-1].innerHTML = "<input type='text' id='inputBox" + two + "' class='sudokuInput'>";
			}
			sessionStorage.setItem('flagArray', JSON.stringify(flagArray));
		} else if(difficulty === 'medium'){
			for(var i = 0; i < 81; i++){
				flagArray[i] = 0;
			}
			for(var i = 0; i < 9; i++){
				var one = Math.floor(Math.random()*9);
				var two = Math.floor(Math.random()*9);
				while(one == two){
					two = Math.floor(Math.random()*9);
				}
				var three = Math.floor(Math.random()*9);
				while(three == two || three == one){
					three = Math.floor(Math.random()*9);
				}

				one = i*9 + one + 1;
				two = i*9 + two + 1;
				three = i*9 + three + 1;
				//flag the boxes we'll be changing so we can find them easily.
				flagArray[one-1] = 1;
				flagArray[two-1] = 1;
				flagArray[three-1] = 1;
				//replace with text boxes
				puzzleArray[one-1].innerHTML = "<input type='text' id='inputBox" + one + "' class='sudokuInput'>";
				puzzleArray[two-1].innerHTML = "<input type='text' id='inputBox" + two + "' class='sudokuInput'>";
				puzzleArray[three-1].innerHTML = "<input type='text' id='inputBox" + three + "' class='sudokuInput'>";
			}
			sessionStorage.setItem('flagArray', JSON.stringify(flagArray));
		} else if(difficulty === 'hard'){
			for(var i = 0; i < 81; i++){
				flagArray[i] = 0;
			}
			for(var i = 0; i < 9; i++){
				var one = Math.floor(Math.random()*9);
				var two = Math.floor(Math.random()*9);
				while(one == two){
					two = Math.floor(Math.random()*9);
				}
				var three = Math.floor(Math.random()*9);
				while(three == two || three == one){
					three = Math.floor(Math.random()*9);
				}
				var four = Math.floor(Math.random()*9);
				while(four == three || four == two || four == one){
					four = Math.floor(Math.random()*9);
				}

				one = i*9 + one + 1;
				two = i*9 + two + 1;
				three = i*9 + three + 1;
				four = i*9 + four + 1;
				//flag the boxes we'll be changing so we can find them easily.
				flagArray[one-1] = 1;
				flagArray[two-1] = 1;
				flagArray[three-1] = 1;
				flagArray[four-1] = 1;
				//replace with text boxes
				puzzleArray[one-1].innerHTML = "<input type='text' id='inputBox" + one + "' class='sudokuInput'>";
				puzzleArray[two-1].innerHTML = "<input type='text' id='inputBox" + two + "' class='sudokuInput'>";
				puzzleArray[three-1].innerHTML = "<input type='text' id='inputBox" + three + "' class='sudokuInput'>";
				puzzleArray[four-1].innerHTML = "<input type='text' id='inputBox" + four + "' class='sudokuInput'>";
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

	//STRETCH TODO: Find all invalid inputs(mark in separate matrix)
	//				Highlight the boxes that they are contained in red(temporary).
	function checkSolutions(){
		flagArrayTemp = sessionStorage.getItem('flagArray');
		flagArrayTemp = (flagArrayTemp) ? JSON.parse(flagArrayTemp) : [];
		
		intArrayTemp = sessionStorage.getItem('intArray');
		intArrayTemp = (intArrayTemp) ? JSON.parse(intArrayTemp) : [];

		for(var i = 0; i < flagArrayTemp.length; i++){
			if(flagArrayTemp[i] == 1){
				var num = i + 1;
				console.log(document.getElementById('inputBox'+num).className);
				document.getElementById('inputBox'+num).className = document.getElementById('inputBox'+num).className.replace(/\bfade-it\b/, '');
				console.log(document.getElementById('inputBox'+num).className);
			}
		}
		for(var i = 0; i < flagArrayTemp.length; i++){
			if(flagArrayTemp[i] == 1){
				var num = i + 1;
				if(intArrayTemp[i] == document.getElementById('inputBox' + num).value){
					continue;
				} else{
					document.getElementById('inputBox'+num).className += ' fade-it';
					var row = Math.floor(i/9) + 1;
					var col = (i % 9) + 1;
					alert("Your submission is incorrect. The first error seen was at " + row + ", " + col + "(row,column)");
					document.getElementById('inputBox'+num).value = "";
					return;
				}
			}
		}
		alert("Congratulations! Your score has been placed in the high scores for correctly solving the puzzle.");
		//TODO: Database stuff here for putting in score based on difficulty.
		
		//TODO, generate below based on current not always easy
		generatePuzzle('new');
	}
	</script>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<div class="btnbar2">
		<button class="btn" onclick="checkSolutions();">Check Submission</button>
	</div>
</body>
</html>