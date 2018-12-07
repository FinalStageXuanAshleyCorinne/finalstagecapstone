<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xml:lang="en-US" lang="en-US">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,
                                   initial-scale=1">
    <meta name="Author" content="Ashley Tribbett" />
    <meta name="generator" content="emacs" />
    <link rel="stylesheet" href="style.css">
    <title>Home Page</title>
  </head>
  <body>

<?PHP
  // form handler
  
  //Connect to database
  include_once "Connect.php";
  $dbh = ConnectDB();
  $query = 'INSERT IGNORE INTO music_table (artist, track, album, mood)' .
			'VALUES (:artist, :track, :album, :mood)';
  
  $mood = $_POST['mood'];
  //set search term for music
   function genreSort($mood){
	   if($mood == 'happy'){
		 $mood = 'Ed Sheeran';
	 }elseif($mood == 'sad'){
		 $mood = 'Adele';
	 }elseif($mood == 'angry'){
		 $mood = 'Linkin Park';
	 }
	 return $mood;
   }
	
 if(isset($_POST['mood']))
{
	$term = genreSort($mood);
    $term = urlencode($term); // user input 'term' in a form
    $json =  file_get_contents('http://itunes.apple.com/search?term='.$term.'&limit=3&media=music&entity=musicArtist,musicTrack,album,mix,song');    
    $array = json_decode($json, true);

    foreach($array['results'] as $value)
    {
		$stmt = $dbh->prepare($query);
		$artist = $value['artistName'];
		$track = $value['trackName'];
		$album = $value['collectionName'];
			
		// Put music into database
		$stmt->bindParam(':artist', $artist);
        $stmt->bindParam(':track', $track);
		$stmt->bindParam(':album', $album);
		$stmt->bindParam(':mood', $mood);

        $stmt->execute();
        $inserted = $stmt->rowCount();
        $stmt = null;	
		
		
		// Display Music
        echo '<p>';
        echo "Artist: ". $value['artistName'].'<br />';
        echo "Track: ". $value['trackName'].'<br />';
        echo "Album: ". $value['collectionName'];
        echo '</p>';

    }
}
?>
   <footer style="border-top: 1px solid blue">
      <span style="float: right;">
        <a href="http://validator.w3.org/check/referer">HTML5</a> /
        <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
          CSS3 </a>
      </span>
    </footer>
  </body>
</html>