<!DOCTYPE html>
<html>
<head>
<link href="sudoku.css" rel="stylesheet" type="text/css" />
<meta charset="UTF-8">
<title>Login Page</title>
</head>
<body>
	<?php session_start();?>
	<div class="form">
	<a class="btn" href="puzzle.php">&larr; Back to Home</a><br>
	<h2>Register</h2>
    <form action="controller.php" method="POST">
    Username:<br>
    <input type="text" name="regusn" required>
    <br>
    Password:<br>
    <input type="text" name="regpass" required>
    <br><br>
    <input class="btn" type="submit" name="register" value="Register">
    </form>
    <br>
    </div>
    <?php
        if(isset($_SESSION['regError'])) {
            echo $_SESSION['regError'];
        }
    ?>
</body>
</html>