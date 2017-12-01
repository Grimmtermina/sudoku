<?php
// EDITED BY: Andrew Miller; DATE: 11/17/2017
class DatabaseAdaptor {
    private $DB; // The instance variable used in every function
    // Connect to an existing data based named 'imdb_small'
    public function __construct() {
        $db = 'mysql:dbname=sudoku; host=127.0.0.1; charset=utf8';
        $user = 'root';
        $password = ''; // an empty string
        try {
            $this->DB = new PDO ( $db, $user, $password );
            $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            echo ('Error establishing Connection');
            exit ();
        }
    }
    
    public function getScoresTable() {
        $stmt = $this->DB->prepare ("SELECT users.username, highscore.score FROM users JOIN highscore ON users.id = highscore.userID");
        $stmt->execute ();
        return $stmt->fetchAll ( PDO::FETCH_ASSOC );
    }
    
    public function addScoreToDB($userID,$score) {
        // FIXME: FINISH!
    }
    
    public function getUsers() {
        $stmt = $this->DB->prepare ("SELECT * FROM users");
        $stmt->execute ();
        return $stmt->fetchAll ( PDO::FETCH_ASSOC );
    }
    
    public function addUserToDB($usn,$pass) {
        $sql = $this->DB->prepare("INSERT INTO users (username, hash) VALUES ('" . $usn . "','" . $pass . "')");
        $sql->execute ();
    }
} // End class DatabaseAdaptor

$theDBA = new DatabaseAdaptor ();

?>

