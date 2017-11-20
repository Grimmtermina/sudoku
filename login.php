<!DOCTYPE html>
<html>
<head>
<link href="sudoku.css" rel="stylesheet" type="text/css" />
<meta charset="UTF-8">
<title>Login Page</title>
</head>
<body>
	<?php session_start(); ?>
	<div class="form">
	<a class="btn" href="puzzle.php">&larr; Back</a><br>
	<h2>Login</h2>
    <form action="controller.php" method="POST">
    Username:<br>
    <input type="text" name="usn" required>
    <br>
    Password:<br>
    <input type="password" name="pass" required>
    <br><br>
    <input class="btn" type="submit" name="login" value="Login">
    </form>
    <br>
    ---------------------New to SUDOKU CHALLENGE?---------------------
    <br><br><a class="btn" href="register.php">Create your SUDOKU CHALLENGE account</a><br>
    </div>
    <?php
        if(isset($_SESSION['loginError'])) {
            echo $_SESSION['loginError'];
        }
    ?>
</body>
</html>