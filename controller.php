<?php
// AUTHOR: Andrew Miller; DATE: 11/8/2017

include 'model.php';

session_start();

unset($_SESSION['loginError']);
unset($_SESSION['regError']);

$userArr = $theDBA->getUsers();

// // DEBUGGING CODE:
// // Login button session handler
// if(isset($_POST['usn']) && isset($_POST['pass'])) {
//     // Check if correct usn & pass, then set the user for the session
//     if ($_POST['usn'] == 'player' && $_POST['pass'] == '1234') {
//         $_SESSION['user'] = $_POST['usn'];
//         header('Location: puzzle.php');
//     }
//     // Return to login page with error (if doesn't exist)
//     else {
//         $_SESSION['loginError'] = 'Invalid USN or pass.';
//         header('Location: login.php');
//     }
//     unset($_SESSION['usn']);
//     unset($_SESSION['pass']);
// }

// Login button session handler
if(isset($_POST['usn']) && isset($_POST['pass'])) {
    $found = -1;
    $usn = htmlspecialchars($usn);
    $pass = htmlspecialchars($pass);
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
    $regusn = htmlspecialchars_decode($regusn);
    $regpass = htmlspecialchars_decode($regpass);
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
if(isset($_POST['difficulty'])) {
    // TODO: Take difficulty and change
}
// Logout session handler
if(isset( $_POST['logout']) && $_POST['logout'] == 'Logout') {
    session_destroy();
    header('Location: puzzle.php');
}
?>