<html>
<head>
</head>
<body>
	<?php

		include "dbconfig.php";

		$query = "SELECT * FROM Customers";
		$result = mysqli_query($link, $query);

		if( $result ){
			if( mysqli_num_rows($result) > 0 ){
				echo "The following customers are in the bank system:";
				echo "<TABLE border=1><tbody>";
				echo "<tr><th>ID</th><th>login</th><th>password</th><th>Name</th><th>Gender</th><th>DOB</th><th>Street</th><th>City</th><th>State</th><th>Zipcode</th></tr>";

				while($row = mysqli_fetch_array($result)){

					$id = $row['id'];
					$login_id = $row['login'];
				    $name = $row['name'];
				    $password = $row['password'];
				    $DOB = $row['DOB'];
				    $gender = $row['gender'];
				    $street = $row['street'];
				    $city = $row['city'];
				    $state = $row['state'];
				    $zipcode = $row['zipcode'];

					echo "<tr><td>$id</td><td>$login_id</td><td>$password</td><td>$name</td><td>$gender</td><td>$DOB</td><td>$street</td><td>$city</td><td>$state</td><td>$zipcode<br></td></tr>";
				}

				echo "</tbody></TABLE>";
			}else{
				echo "<br>No records in the database.\n";
				mysqli_free_result($result);
			}
		}else{
			echo "<br>Something wrong with the SQL query.\n";
		}

		mysqli_close($con);
	?>
</body>
</html>