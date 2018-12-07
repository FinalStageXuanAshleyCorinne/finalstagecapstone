	<?php // Database connect

		// Add host, username, password and database name
		define('HOSTNAME','');
		define('DB_USERNAME','');
		define('DB_PASSWORD','');
		define('DB_NAME', '');			
		
		$con = mysqli_connect(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME) or die ("error");
		
		// Check connection
		if(mysqli_connect_errno($con))  echo "Failed to connect MySQL: " .mysqli_connect_error();
		
	?>
	