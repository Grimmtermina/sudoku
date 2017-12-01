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
<?php
// FIXME: Insert a search bar for searching by username
?>
<div id="toChange"></div>

<?php
include 'model.php';
$arr = $theDBA->getScoresTable();
?>

<script>
	function fillTable() {
		var array = <?php echo json_encode($arr);?>;
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

	function searchPlayer() {
		// Make highlighted bottom row with the found name
	}
</script>
</body>