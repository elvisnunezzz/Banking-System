<?php 

	include "dbconfig.php";
	
	if( isset($_POST) && !empty($_POST) && !empty($_COOKIE['customer_id']) ){
		echo '<a href="logout.php">User logout</a><br>';

		$code = $_POST['code'];
		$type = $_POST['type'];
		$amount = $_POST['amount'];
		$source_id = $_POST['source_id'];
		$note = $_POST['note'];

		if( $code == "" ){
			echo "Please insert a code.";
			die();
		}

		mysqli_select_db($link, "CPS3740_2020S");
		$sql = "SELECT * FROM Money_nuneelvi WHERE code = '".$code."'";
		$resultCode = mysqli_query($link, $sql);		
		if (mysqli_num_rows($resultCode) > 0) {
			echo "Error! There is same transaction code in database.";
			die();
		}

		if( $type == "" ){
			echo "Please select deposit or withdraw.";
			die();
		}

		if( $amount == "" ){
			echo "Please insert an amount.";
			die();
		}

		if( $amount <= 0 ){
			echo "Please insert an amount, it cannot be negative.";
			die();
		}

		$sql = "SELECT * FROM Money_nuneelvi WHERE cid = " . $_COOKIE['customer_id'];
		$result2 = mysqli_query($link, $sql);
		$balance = 0;		
		if (mysqli_num_rows($result2) > 0) {
		    while($row2 = mysqli_fetch_assoc($result2)) {
	      		$balance += $row2['amount'];
		    }
		}

		if( $type == 'W' ){
			if( $amount > $balance ){
				echo "Error! Customer Mary Lee has $".$balance." in the bank, and tries to withdraw ".$amount.". Not enough money!";
				die();
			}

			$resultAmount = ($balance-$amount);
			$am = '-'.$amount;
		}else{
			$resultAmount = ($balance+$amount);
			$am = $amount;
		}

		$sqlInsert = "INSERT INTO Money_nuneelvi (code, type, amount, mydatetime, note, sid, cid) VALUES ('".$code."','".$type."', '".$am."','".DATE('Y-m-d h:m:s')."','".$note."', '".$source_id."','".$_COOKIE['customer_id']."')";
		$resultInsert = mysqli_query($link, $sqlInsert);

		if( $resultInsert ){
			echo "Successfully add the transcation<br><br>";
			echo "New balance: $". $resultAmount;
			die();
		}else{
			echo "Error! Insert Transaction";
			die();
		}
		
		mysqli_close($link);
	}else{
		header("Location: add_transaction.php");
	}