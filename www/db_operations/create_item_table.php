<?php

	if (empty($selectingDatabase)) {
    	require "db_connection.php";
    }

	$result = mysqli_query($connect,"SHOW TABLES LIKE 'item'");
	$tableExists = mysqli_num_rows($result);

	if($tableExists > 0) {
		echo "'item' table already exists!<br/>";
	
	} else {
		mysqli_query($connect,
			'CREATE TABLE item ( id int(11) NOT NULL auto_increment, 
				name varchar(20) NOT NULL,
				price DECIMAL(10,2) NOT NULL,
				PRIMARY KEY (id)
			)'
		);

		echo "Item table created!<br/> Inserting two sample items";

		mysqli_query($connect,
			"INSERT INTO item (name, price) VALUES ( 'Item A', '5.99')"
		);

		mysqli_query($connect,
			"INSERT INTO item (name, price) VALUES ( 'Item B', '12.99')"
		);

		echo "<br/>Items added successfully!";	
	}

	

?>