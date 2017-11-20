<?php
// AUTHOR: Andrew Miller; DATE: 11/8/2017

include 'model.php';

session_start();

unset($_SESSION['loginError']);
unset($_SESSION['regError']);


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
    // Search for existing usn
    for($i = 0; $i < count($userArr); $i++) {
        if($userArr[$i]['username'] == $_POST['usn']) {
            $found = $i;
        }
    }
    // Set session based on usn (if exists)
    if ($found != -1 && (password_verify($_POST['pass'],$userArr[$found]['hash']) == 1)) {
        $_SESSION['user'] = $_POST['usn'];
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
    // Check for existing usn
    for($i = 0; $i < count($userArr); $i++) {
        if($userArr[$i]['username'] == $_POST['regusn']) {
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
        $hash = password_hash($_POST['regpass'], PASSWORD_DEFAULT);
        $theDBA->addUserToDB($_POST['regusn'],$hash);
        header('Location: puzzle.php');
    }
    unset($_SESSION['regusn']);
    unset($_SESSION['regpass']);
}

// Difficulty settings handler
// TODO: Decide on whether to perform through a separate page or a dropdown menu or something

// Logout session handler
if(isset( $_POST['logout']) && $_POST['logout'] == 'Logout') {
    session_destroy();
    header('Location: puzzle.php');
}
?>