<?php 
	if( !isset($_COOKIE['customer_id']) ){
		echo 'Please click on <a href="index.html">here (project home)</a> to login first!';
		die();
	}else{
		include "dbconfig.php";
		if(!empty($_COOKIE['customer_id'])){			
			mysqli_select_db($link, "CPS3740_2020S");
			$sql = "SELECT * FROM Money_nuneelvi WHERE cid = " . $_COOKIE['customer_id'];
			$result2 = mysqli_query($link, $sql);

			$balance=0;
			echo '<a href="logout.php">User logout</a><br>';
			echo 'You can only udpdate <b>Note</b> column.<br>';
			echo '<form action="update_transaction.php" method="post">';
			echo '<table border="1">';
			if (mysqli_num_rows($result2) > 0) {
				echo '<tr>';
					echo '<th>ID</th>';
					echo '<th>Code</th>';
					echo '<th>Amount</th>';
					echo '<th>Type</th>';
					echo '<th>Date Time</th>';
					echo '<th>Note</th>';
					echo '<th>Delete</th>';
				echo '</tr>';
			    while($row2 = mysqli_fetch_assoc($result2)) {
			      $balance+=$row2['amount'];

			     echo '<tr>';
			     echo '<td> ' . $row2['ID']. ' </td> ';
			     echo '<td> ' . $row2['code']. ' </td> ';

			     if($row2['type']=="W"){
			       echo '<td><font color="red"> $' . $row2['amount']. '</font> </td> ';

			     }
			     if($row2['type']=="D"){
			       echo '<td><font color="blue"> $' . $row2['amount']. '</font> </td> ';

			     }


			     if($row2['type']=="W"){
			       echo '<td>Withdraw</td> ';

			     }
			     if($row2['type']=="D"){
			       echo '<td>Deposit</td> ';

			     }
			     
			     
			     echo '<td> ' . $row2['mydatetime']. ' </td> ';
			     echo '<td bgcolor="yellow"><input type="text" value="' . $row2['note']. '" name="note[]" style="background-color:yellow;"></td> ';
			     echo '<td>';
			     	echo '<input type="checkbox" name="cdelete[' . $row2['ID']. ']" value="Y">';
			     	echo '<input type="hidden" name="tid[]" value="' . $row2['ID']. '">';
			     echo '</td>';
			     echo '</tr>';

			    }


			} 

			echo '</table>';
			echo 'Total balance: $'.$balance.'<br>';
			echo '<input type="submit" value="Update transaction">';
			echo '</form>';
		}

		mysqli_close($link);
	}

?>