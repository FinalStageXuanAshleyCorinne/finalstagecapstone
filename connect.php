<?php

ConnectDB();
// NOTE: this file has a password, and so should not be world-readable.
// Usually it would be mode 600, with a ACL permitting the webserver in.
// But it's like this because you have to use it as sample code.

// ConnectDB() - takes no arguments, returns database handle
// USAGE: $dbh = ConnectDB();
function ConnectDB() {

    /*** mysql server info ***/
    $hostname = 'localhost';    // Local host, i.e. running on elvis
    $username = 'root';         // Your MySQL Username goes here
    $password = '';             // Your MySQL Password goes here
    $dbname   = 'dox0';         // For elvis, your MySQL Username is repeated here

    try {
        $dbh = new PDO("mysql:host=$hostname;dbname=$dbname",$username, $password);
    }
    catch(PDOException $e) {
        die ('PDO error in "ConnectDB()": ' . $e->getMessage());
    }

    return $dbh;
}

?>
