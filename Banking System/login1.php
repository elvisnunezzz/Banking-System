<?php


	if( isset($_POST['username']) && isset($_POST['password']) ){		

		setcookie("name",$username, time() + 36 + 10);
		if( empty($_POST['username'] ) ){
			echo "Username or password its empty";
			die();
		}

		if( empty($_POST['password']) ){
			echo "Password its empty";
			die();
		}

		include "dbconfig.php";

		$username = $_POST['username'];
		$password = $_POST['password'];


		$query = "SELECT * FROM Customers WHERE login = '".$username."'";
		$result = mysqli_query($link, $query);
	
		if( $result ){
			if( mysqli_num_rows($result) > 0 ){
				$row = mysqli_fetch_array($result);
				
				echo "Your IP: " . $_SERVER["REMOTE_ADDR"] . "<br>";
				$ipExp = explode(".", $_SERVER["REMOTE_ADDR"]);

				$ipMessages = "You are NOT from Kean Unversity.<br>";
				if( $ipExp[0] == "131" && $ipExp[1] == "125" ){
					$ipMessages = "Welcome, you are from Kean University wired network. <br>";
				}else if( $ipExp[0] == "10" ){
					$ipMessages = "You are from Kean University. <br>";
				}

				echo $ipMessages;

				if( $row['password'] == $password ){
					list($a,$m,$d) = explode("-", $row['DOB']);
					$age = date('Y') - $a;					
				  	$month = date("m") - $m;
				  	$day   = date("d") - $d;
				  	if ($day < 0 || $month < 0)
				    	$age--;
					echo "Welcome Customer: " . $row['name'] . "<br>";
					echo "Age: " . $age . "<br>";
					echo "Address: " . $row['street'] .", ". $row['city'] .", ". $row['zipcode'];

					echo "<hr>The transcations for customer ".$username." are: Saving account ";

					mysqli_select_db($link, "CPS3740_2020S");
					$sql = "SELECT * FROM Money_nuneelvi";
					$result2 = mysqli_query($link, $sql);

					$balance=0;
						echo '<table border="1">';
					if (mysqli_num_rows($result2) > 0) {
						
					    while($row2 = mysqli_fetch_assoc($result2)) {
					      $balance+=$row2['amount'];
					     echo '<tr>';
					     echo '<td>Firstname</td>'
					     echo '<td> ' . $row2['mid']. ' </td> ';
					     echo '<td> ' . $row2['code']. ' </td> ';
					     echo '<td> ' . $row2['type']. ' </td> ';

					     if($row2['type']=="W"){
					       echo '<td><font color="red"> $' . $row2['amount']. '</font> </td> ';

					     }
					     if($row2['type']=="D"){
					       echo '<td><font color="blue"> $' . $row2['amount']. '</font> </td> ';

					     }
					     echo '<td> ' . $row2['mydatetime']. ' </td> ';
					     echo '<td> ' . $row2['note']. ' </td> ';
					     echo '</tr>'; 

					    }


					} 

					echo '</table>';
					echo 'balance: $'.$balance.'<br>';
					setcookie("login",$username,time()+ 36* 10);
					
				}else{
					echo "User ".$username." is in the database, but wrong password was entered.";
				}			
				
				die();
			}
			else
			{ 
				echo "Your IP: " . $_SERVER["REMOTE_ADDR"] . "<br>";
				echo 'Your browser and OS: '. $_SERVER['HTTP_USER_AGENT'] . "<br>";
				echo $ipMessages;
				echo "User ". $username . " is not in the database" . "<br>";
				echo '<a href="index.html">project home page</a>';
				die();
			}

			mysqli_free_result($result);
		}
		

		

		mysqli_close($con);
	}

?>

<HTML>

<HEAD>
	<TITLE>Welcome to Elvis project 1</TITLE>
</HEAD>
<BODY>
	<br> 
	Welcome to Elvis CPS3740 project 1.
	<br> <br>
	<a href="display_customers.php">Display all customers</a>
	<br>
	<div id="form">
	<form action="login1.php" method="POST">

		<p>
			<labe>Login ID</label>
		<input type="text" id="username" name="username"  required="required" >
		</p>
		<p>
			<label>Password</label>
		<input type="password" id="password" name="password"  required="required" >
		</p>
		<p>
		<input type="submit" value="Submit">

		</p>
	</form>

	</div>

</BODY>

</HTML>