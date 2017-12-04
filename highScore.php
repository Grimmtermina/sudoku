<!DOCTYPE HTML>

<!-- AUTHORS: Andrew Miller & Saile Daimwood -->
<html>
<head>
<meta charset="UTF-8">
<link href="sudoku.css" rel="stylesheet" type="text/css" />
<title>High Score Page</title>
</head>
<body onload="fillTable();">
<a class="btn" href="puzzle.php">&larr; Back</a><br><br>

<input class="search" type="text" id="playerInput"><input type="submit" value="Search player" class="searchBtn" onclick="searchPlayer();"><br><br>
<div id="toChange"></div>
<div id="searchResult"></div>

<?php
include 'model.php';
$arr = $theDBA->getScoresTable();
?>

<script>
	function fillTable() {
		var array = <?php echo json_encode($arr);?>;
		if (array.length > 10) {
			shortenedArr = array.slice(0,10);
            str = "<table>";
            str += "<th>Username</th>";
            str += "<th>High Score</th>";
            
            for (var i = 0; i < 10; i++) {
                str += "<tr>";
                str += "<td>" + shortenedArr[i]['username']   + "</td>";
                str += "<td>" + shortenedArr[i]['score'] + "</td>";
                str += "</tr>";
            }
            str += "</table>";
            
            var toChange = document.getElementById("toChange");
            toChange.innerHTML = str;
		}
		else {
            str = "<table>";
            str += "<th>Username</th>";
            str += "<th>High Score</th>";
            
            for (var i = 0; i < array.length; i++) {
                str += "<tr>";
                str += "<td>" + array[i]['username']   + "</td>";
                str += "<td>" + array[i]['score'] + "</td>";
                str += "</tr>";
            }
            str += "</table>";
            
            var toChange = document.getElementById("toChange");
            toChange.innerHTML = str;
		}
	}

	function searchPlayer() {
		// Make highlighted bottom row with the found name
		var array = <?php echo json_encode($arr);?>;
		var index = -1;
		var str = "";
		var name = document.getElementById('playerInput');
		var toChange = document.getElementById("searchResult");
        
		for (var i = 0; i < array.length; i++) {
			if (name.value == array[i]['username']) {
				index = i;
			}
		}
		if (index == -1) {
			toChange.innerHTML = "User not found";
		}
		else {
			str += "<table class='searchResult'>";
			str += "<tr>";
            str += "<td>" + array[index]['username'] + "</td>";
            str += "<td>" + array[index]['score'] + "</td>";
            str += "</tr></table>";
            toChange.innerHTML = str;
		}
	}
</script>
</body>