<?php
	include "dbconfig.php";
	
	if( !isset($_COOKIE['customer_id']) && empty($_COOKIE['customer_id']) ){
		if( isset($_POST['username']) && isset($_POST['password']) ){		

			if( empty($_POST['username'] ) ){
				echo "Username or password its empty";
				die();
			}

			if( empty($_POST['password']) ){
				echo "Password its empty";
				die();
			}

			$username = $_POST['username'];
			$password = $_POST['password'];


			$query = "SELECT * FROM Customers WHERE login = '".$username."'";
			$result = mysqli_query($link, $query);
		
			if( $result ){
				if( mysqli_num_rows($result) > 0 ){
					$row = mysqli_fetch_array($result);
					
					echo '<a href="logout.php">User logout</a>' . "<br>";
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
						$id_customer = $row['id'];
						$nombre = $row['name'];
						list($a,$m,$d) = explode("-", $row['DOB']);
						$age = date('Y') - $a;					
					  	$month = date("m") - $m;
					  	$day   = date("d") - $d;
					  	if ($day < 0 || $month < 0)
					    	$age--;
						print "Welcome Customer: " . $row['name']. "<br>";
						echo "Age: " . $age . "<br>";
						echo "Address: " . $row['street'] .", ". $row['city'] .", ". $row['zipcode'];

						echo "<hr>The transcations for customer: " . $row['name']. " are";

						mysqli_select_db($link, "CPS3740_2020S");
						$sql = "SELECT * FROM Money_nuneelvi WHERE cid = " . $id_customer;
						$result2 = mysqli_query($link, $sql);

						$balance=0;
							echo '<table border="1">';
						if (mysqli_num_rows($result2) > 0) {
							echo '<tr>';
								echo '<th>ID</th>';
								echo '<th>Code</th>';
								echo '<th>Type</th>';
								echo '<th>Amount</th>';
								echo '<th>Date Time</th>';
								echo '<th>Note</th>';
							echo '</tr>';
						    while($row2 = mysqli_fetch_assoc($result2)) {
						      $balance+=$row2['amount'];

						     echo '<tr>';
						     echo '<td> ' . $row2['ID']. ' </td> ';
						     echo '<td> ' . $row2['code']. ' </td> ';
						     if($row2['type']=="W"){
						       echo '<td>Withdraw</td> ';

						     }
						     if($row2['type']=="D"){
						       echo '<td>Deposit</td> ';

						     }
						     
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
						echo 'Total balance: $'.$balance.'<br><br>';

						echo '<table border="0">';
	     					echo '<tbody>
	     							<tr>
	     								<td>
	     									<form action="add_transaction.php" method="POST">
	     										<input type="hidden" name="customer_name">
	     										<input type="submit" value="Add transaction">
	     									</form>
	     								</td>
	     								<td>
	     									<a href="display_update_transaction.php">Display and update transaction</a>
	     								</td>
	 								</tr>
	 								<tr>
	 									<td colspan="2">
	 										<form action="search_transaction.php" method="get">
	    										Keyword: <input type="text" name="keywords" required="required">
	 											<input type="submit" value="Search transaction"></form>
	     								</td>
	 								</tr>
								</tbody>
							</table>';		

						
						setcookie("customer_id",$id_customer,time() + (36* 10));
						setcookie("customer_name",$nombre, time() + (36 * 10));
					
						
					}
					
					else{
						echo "User ".$username." is in the database, but wrong password was entered.";
					}			
					
					die();
				}
				else
				{ 
					echo '<a href="logout.php">User logout</a>' . "<br>";
					echo "Your IP: " . $_SERVER["REMOTE_ADDR"] . "<br>";
					echo 'You are NOT from Kean Unversity.'. "<br>";
					echo $ipMessages;
					echo "User ". $username . " is not in the database." . "<br>";
					echo '<a href="index.html">project home page</a>';
					die();
				}

				mysqli_free_result($result);
			}		

			mysqli_close($link);
		}
	}else if( isset($_COOKIE['customer_id']) && !empty($_COOKIE['customer_id']) ){

		$query = "SELECT * FROM Customers WHERE id = '".$_COOKIE['customer_id']."'";
		$result = mysqli_query($link, $query);
		
		if( $result ){
			if( mysqli_num_rows($result) > 0 ){
				$row = mysqli_fetch_array($result);
				
				echo '<a href="logout.php">User logout</a>' . "<br>";
				echo "Your IP: " . $_SERVER["REMOTE_ADDR"] . "<br>";
				$ipExp = explode(".", $_SERVER["REMOTE_ADDR"]);

				$ipMessages = "You are NOT from Kean Unversity.<br>";
				if( $ipExp[0] == "131" && $ipExp[1] == "125" ){
					$ipMessages = "Welcome, you are from Kean University wired network. <br>";
				}else if( $ipExp[0] == "10" ){
					$ipMessages = "You are from Kean University. <br>";
				}

			
				echo $ipMessages;

				$id_customer = $row['id'];
				$nombre = $row['name'];
				list($a,$m,$d) = explode("-", $row['DOB']);
				$age = date('Y') - $a;					
			  	$month = date("m") - $m;
			  	$day   = date("d") - $d;
			  	if ($day < 0 || $month < 0)
			    	$age--;
				print "Welcome Customer: " . $row['name']. "<br>";
				echo "Age: " . $age . "<br>";
				echo "Address: " . $row['street'] .", ". $row['city'] .", ". $row['zipcode'];

				echo "<hr>The transcations for customer: " . $row['name']. " are";

				mysqli_select_db($link, "CPS3740_2020S");
				$sql = "SELECT * FROM Money_nuneelvi WHERE cid = " . $id_customer;
				$result2 = mysqli_query($link, $sql);

				$balance=0;
					echo '<table border="1">';
				if (mysqli_num_rows($result2) > 0) {
					echo '<tr>';
						echo '<th>ID</th>';
						echo '<th>Code</th>';
						echo '<th>Type</th>';
						echo '<th>Amount</th>';
						echo '<th>Date Time</th>';
						echo '<th>Note</th>';
					echo '</tr>';
				    while($row2 = mysqli_fetch_assoc($result2)) {
				      $balance+=$row2['amount'];

				     echo '<tr>';
				     echo '<td> ' . $row2['ID']. ' </td> ';
				     echo '<td> ' . $row2['code']. ' </td> ';
				     if($row2['type']=="W"){
				       echo '<td>Withdraw</td> ';

				     }
				     if($row2['type']=="D"){
				       echo '<td>Deposit</td> ';

				     }
				     
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
				echo 'Total balance: $'.$balance.'<br><br>';

				echo '<table border="0">';
 					echo '<tbody>
 							<tr>
 								<td>
 									<form action="add_transaction.php" method="POST">
 										<input type="hidden" name="customer_name" value="Mary Lee">
 										<input type="submit" value="Add transaction">
 									</form>
 								</td>
 								<td>
 									<a href="display_update_transaction.php">Display and update transaction</a>
 								</td>
								</tr>
								<tr>
									<td colspan="2">
										<form action="search_transaction.php" method="get">
										Keyword: <input type="text" name="keywords" required="required">
											<input type="submit" value="Search transaction"></form>
 								</td>
								</tr>
						</tbody>
					</table>';		
				
				die();
			}
			else
			{ 
				echo '<a href="logout.php">User logout</a>' . "<br>";
				echo "Your IP: " . $_SERVER["REMOTE_ADDR"] . "<br>";
				echo 'You are NOT from Kean Unversity.'. "<br>";
				echo $ipMessages;
				echo "User ". $username . " is not in the database." . "<br>";
				echo '<a href="index.html">project home page</a>';
				die();
			}

			mysqli_free_result($result);
			mysqli_close($link);
		}
	}	

?>

<HTML>
<HEAD>
	<TITLE>Welcome to Elvis project 2</TITLE>
</HEAD>
<BODY>
	<br> 
	Welcome to Elvis CPS3740 project 2.
	<br> <br>
	<a href="display_customers.php">Display all customers</a>
	<br>
	<div id="form">
	<form action="login2.php" method="POST">
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