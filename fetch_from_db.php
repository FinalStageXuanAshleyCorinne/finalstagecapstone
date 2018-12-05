<?php
// Connect to the database
if (!include('connect.php')) {
    die('error finding connect file');
}
$dbh = ConnectDB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Connect to MySQL DB and display results.">
    <title>Using TheMovieDB, TheMusicDB, ThePhotoDB</title>
    <meta name="author" content="Xuan Do">
    <meta name="viewport" content="width=device-width">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="corinne_css/table.css" type="text/css" />
    <!-- <link rel="stylesheet" href="ashley_css/table.css" type="text/css" /> -->
    <!-- <link rel="stylesheet" href="xuando_css/table.css" type="text/css" /> -->

</head>
<body>

    <!-- Dynamics front-end fetch from database -->
    <div class="container">

        <div class="row">

            <a href="index.php">Back to search page</a>

        </div>


        <!-- Ashley -->
        <div class="row">

            <!-- Fetch from THE MUSIC DB -->

            <h2>Fetch from THE MUSIC DB</h2>

            <?php

            // Get movie id  from querystring
            if (!isset($_POST["mood"])) {
                echo "How about including a mood id on that querystring, eh?";
            }
            else {
                $mood = $_POST["mood"];

                $sql = "SELECT artist, track, album FROM music_table ";
                $sql .= "WHERE mood = :mood ";
                $sql .= "LIMIT 5";

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':mood', $mood);  // prevents SQL injection
                $stmt->execute();
                $cols = $stmt->rowCount();

                if ($cols > 0) {
                    echo "<table id='myMusic' class='table table-bordered'><thead><tr><th>Artist</th><th>Track</th><th>Album</th></tr></thead>";
                    // output data of each row
                    foreach ($stmt->fetchAll() as $row ) {
                        echo "<tr><td>" . $row["artist"] . "</td><td>" . $row["track"] . "</td><td>" . $row["album"] ."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
            }

            ?>

        </div>
        <!-- // Ashley -->


        <!-- Corinne -->
        <div class="row">

            <!-- Fetch from THE PHOTO DB -->

            <!-- <h2>Fetch from THE PHOTO DB</h2> -->
			
		
            <?php

            // Get movie id  from querystring
            if (!isset($_POST["mood"])) {
                echo "How about including a mood id on that querystring, eh?";
            }
            else {
                $mood = $_POST["mood"];

                $sql = "SELECT square, url, photog FROM photo ";	// Changed to square image for consistency CK
                $sql .= "WHERE emotion = :mood ";
				$sql .= "ORDER BY RAND()";			// added RANDOM to sql statement to get new pictures each time CK
                $sql .= "LIMIT 6";

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':mood', $mood);  // prevents SQL injection
                $stmt->execute();
                $cols = $stmt->rowCount();
				
				// Original table format but removed headers, displays photo and author only
                /*if ($cols > 0) {
                    echo "<table id='myPhoto' class='table table-bordered'>";
                    // output data of each row
					echo "<tr>";
                    foreach ($stmt->fetchAll() as $row ) {
                        echo "
						<td><a href='" . $row["url"] . "'><img src='" . $row["square"] . "' style='width:200px;height:200px;' /></a></td>
						
						<td>" . $row["photog"] ."</td>";
						echo "</tr>";
                    }
			
                    echo "</table>";
                } else {
                    echo "0 results";
                } */
				
				// Gallery type format
                if ($cols > 0) {
					foreach ($stmt->fetchAll() as $row ) {
                        echo "<div class='gallery'>
								<a target='_blank' href='" . $row["url"] . "'>
								<img src='" . $row["square"] . "'>
								<div class='desc'>By: " . $row["photog"] ."</div>
								</a>
							</div>";
						}
                    }
                else {
                    echo "0 results";
                } 
            }

            ?>
        </div>
        <!-- // Corinne -->





        <!-- Xuan Do -->
        <div class="row">

            <!-- Fetch from THE MOVIE DB -->

            <h2>Fetch from THE MOVIE DB</h2>

            <?php

            // Get movie id  from querystring
            if (!isset($_POST["mood"])) {
                echo "How about including a mood id on that querystring, eh?";
            }
            else {
                $mood = $_POST["mood"];

                $sql = "SELECT title, overview, poster_path, genre FROM movies ";
                $sql .= "WHERE mood = :mood ";
                $sql .= "LIMIT 5";

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':mood', $mood);  // prevents SQL injection
                $stmt->execute();
                $cols = $stmt->rowCount();

                if ($cols > 0) {
                    echo "<table id='myMovie' class='table table-striped table-dark table-bordered'><thead class='thead-dark'><tr><th>Title</th><th>Overview</th><th>Avatars</th><th>Genre</th></tr></thead>";
                    // output data of each row
                    foreach ($stmt->fetchAll() as $row ) {
                        echo "<tr><td>" . $row["title"] . "</td><td>" . $row["overview"] . "</td><td><img src='" . $row["poster_path"] . "' /></td><td>" . $row["genre"] ."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
            }

            ?>

        </div>
        <!-- // Xuan Do -->

    </div>

</body>
</html>
