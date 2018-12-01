<!-- Author: Xuan Do -->
<?php
if (!isset($_POST['action'])) {
    header("Location: index.html"); /* Redirect browser to index page */
    die();
}
?>
<?php
// Connect to the database
if (!include('connect.php')) {
    die('error finding connect file');
}
$dbh = ConnectDB();
?>
<?php
$action = $_POST['action'];

if ($action == 'add_movie') {
    $mTitle = $_POST['title'];
    $mOverview = $_POST['overview'];
    $mPoster_path = $_POST['poster_path'];
    $mMood = $_POST['mood'];
    $mGenre = $_POST['genre'];


    // Avoid inserting duplicate records in MySQL using PHP.
    $sql = "SELECT * FROM movies ";
    $sql .= "WHERE title = :title";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $mTitle);  // prevents SQL injection
    $stmt->execute();
    $cols = $stmt->rowCount();

    echo $cols;

    if ($cols == 0) {

        // INSERT into DB table with PDO prepare and bindParam.
        $sql_add = "INSERT INTO movies (title, overview, poster_path, mood, genre) ";
        $sql_add .= "VALUES (:title, :overview, :poster_path, :mood, :genre)";


        // PDO prepare and bindParam.
        $stmt = $dbh->prepare($sql_add);

        $stmt->bindParam(':title', $mTitle);  // prevents SQL injection
        $stmt->bindParam(':overview', $mOverview);
        $stmt->bindParam(':poster_path', $mPoster_path);
        $stmt->bindParam(':mood', $mMood);
        $stmt->bindParam(':genre', $mGenre);


        // Submit data.
        $stmt->execute();
    }
}
?>
