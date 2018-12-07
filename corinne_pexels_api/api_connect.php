	<?php 
	  // requires
	  require("db.php");
	?>
	
	<?php
	
	  // TODO Set emotion for our usage
	  $emotionDB = "sad";
	  // TODO Set search term i.e. sad, blue, smile, etc
	  $search = "sad";
	
	  // add API key variable
	  $api_key = "Authorization: ";
	  
      // create curl resource
      $ch = curl_init();
	  
      // create url for API search
      curl_setopt($ch, CURLOPT_URL, 'https://api.pexels.com/v1/search?query=' . $search . '&per_page=50&page=1'); //set url 
	  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $api_key )); //add api_key
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //return JSON instead of echoing
	  
      // store JSON data
      $output = curl_exec($ch);
	  
      // close curl resource to free up system resources 
      curl_close($ch);
	  
	  // change JSON to php array
      $data = json_decode($output, true);
	  
	  // Trust, but verify
	  //var_dump($data);
	  //var_dump($data["photos"][0]["id"]);
	  
	  // Traverse array and insert into database
	  foreach ($data["photos"] as $photo) {
		$id = $photo["id"];
		$width = $photo["width"];
		$height = $photo["height"];
		$url = $photo["url"];
		$photog = $photo["photographer"];
		$original = $photo["src"]["original"];
		$large2x = $photo["src"]["large2x"];
		$large = $photo["src"]["large"];
		$medium = $photo["src"]["medium"];
		$small = $photo["src"]["small"];
		$portrait = $photo["src"]["portrait"];
		$square = $photo["src"]["square"];
		$landscape = $photo["src"]["landscape"];
		$tiny = $photo["src"]["tiny"];
		
		// SQL insert
		$sql = "INSERT INTO photo (id, emotion, width, height, url, photog, original, large2x, large, medium, small, portrait, 
			square, landscape, tiny)
			VALUES ('$id', '$emotionDB', '$width', '$height', '$url', '$photog', '$original', '$large2x', '$large', '$medium',
			'$small', '$portrait', '$square', '$landscape', '$tiny')";

		if ($con->query($sql) === TRUE) {
			echo "New record - <a href='".$url."'>".$url."</a>";
			echo "<br>";
		} else {
			echo "Duplicate - <a href='".$url."'>".$url."</a>";
			echo "<br>";
		}

	  }	
	
	  $con->close();

	 
	
	  
    ?>
	
	