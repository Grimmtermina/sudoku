<?php
// AUTHOR: Andrew Miller; DATE: 11/8/2017

include 'model.php';

session_start();

unset($_SESSION['loginError']);
unset($_SESSION['regError']);

// Full array of all users and hashed passwords
$userArr = $theDBA->getUsers();

// Login button session handler
if(isset($_POST['usn']) && isset($_POST['pass'])) {
    $found = -1;
    $usn = htmlspecialchars($_POST['usn']);
    $pass = htmlspecialchars($_POST['pass']);
    // Search for existing usn
    for($i = 0; $i < count($userArr); $i++) {
        if($userArr[$i]['username'] == $usn) {
            $found = $i;
        }
    }
    // Set session based on usn (if exists)
    if ($found != -1 && (password_verify($pass,$userArr[$found]['hash']) == 1)) {
        $_SESSION['user'] = $usn;
        header('Location: puzzle.php');
    }
    // Return to login page with error (if doesn't exist)
    else {
        $_SESSION['loginError'] = 'Invalid USN or pass.';
        header('Location: login.php');
    }
    unset($_SESSION['usn']);
    unset($_SESSION['pass']);
}

// Registration session handler
if(isset($_POST['regusn']) && isset($_POST['regpass'])) {
    $found = -1;
    $regusn = htmlspecialchars($regusn);
    $regpass = htmlspecialchars($regpass);
    // Check for existing usn
    for($i = 0; $i < count($userArr); $i++) {
        if($userArr[$i]['username'] == $regusn) {
            $found++;
        }
    }
    // Return to registration page with error (if usn already exists)
    if($found != -1) {
        $_SESSION['regError'] = 'USN already exists in database. Choose different USN';
        header('Location: register.php');
    }
    // Add new usn with associated password to the database (if doesn't exist)
    else {
        $hash = password_hash($regpass, PASSWORD_DEFAULT);
        $theDBA->addUserToDB($regusn,$hash);
        header('Location: puzzle.php');
    }
    unset($_SESSION['regusn']);
    unset($_SESSION['regpass']);
}

// Difficulty settings handler
if(isset($_POST['mode'])) {
    $difficulty = htmlspecialchars($_POST['mode']);
    if ($difficulty == 'easy') {
        $_SESSION['difficulty'] = 'easy';
        header('Location: puzzle.php');
    }
    else if ($difficulty == 'medium') {
        $_SESSION['difficulty'] = 'medium';
        header('Location: puzzle.php');
    }
    else if ($difficulty == 'hard') {
        $_SESSION['difficulty'] = 'hard';
        header('Location: puzzle.php');
    }
}

// Scoring handler
if(isset($_POST['value']) && isset($_POST['scoreUSN'])) {
//    echo 'alert("Success, score = ' . $_POST['value'] . '");';
   $id = "";
   $found = -1;
   for($i = 0; $i < count($userArr); $i++) {
       if($userArr[$i]['username'] == $_POST['scoreUSN']) {
           $found = $i;
       }
   }
   $id = $userArr[$found]['id']; // No if statement because this is opened assuming there's a username 
   
   $found = -1;
   $scoresArr = $theDBA->getScoresTable();
   for ($i = 0; $i < $scoresArr; $i++) {
       if ($scoresArr[$i]['id'] == $id) {
           $found = $i;
       }
   }
   
   if ($found == -1) {
       $theDBA->addScoreToDB($id, $_POST['value']);
       header('Location: puzzle.php');
   }
   
   else if ($scoresArr[$found]['score'] <= $_POST['value']) {
       $theDBA->replaceScore($id, $_POST['value']);
       header('Location: puzzle.php');
   }
}

// Logout session handler
if(isset( $_POST['logout']) && $_POST['logout'] == 'Logout') {
    session_destroy();
    header('Location: puzzle.php');
}
?>