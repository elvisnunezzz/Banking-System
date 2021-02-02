<?php 

	if( !isset($_COOKIE['customer_id']) ){
		echo 'Please click on <a href="index.html">here (project home)</a> to login first!';
		die();
	}

	$keywords = "";

	if( isset($_GET['keywords']) ){
		$keywords = trim($_GET['keywords']);

		include "dbconfig.php";
		mysqli_select_db($link, "CPS3740_2020S");

		if( $keywords == "*" ){
			$sql = "SELECT m.*, s.name 
				FROM Money_nuneelvi AS m
					INNER JOIN CPS3740.Sources s ON s.id = m.sid
				WHERE m.cid = ".$_COOKIE['customer_id'];
		}else{
			$sql = "SELECT m.*, s.name 
				FROM Money_nuneelvi AS m
					INNER JOIN CPS3740.Sources s ON s.id = m.sid
				WHERE m.cid = ".$_COOKIE['customer_id']." AND  m.note LIKE '%".$keywords."%'";
		}

		$result = mysqli_query($link, $sql);

		$balance=0;
		if (mysqli_num_rows($result) > 0) {
			echo "The transactions in customer <b>". $_COOKIE['customer_name'] ."</b> records matched keyword <b>". $keywords."</b> are:";

			echo '<table border="1">
					<tbody>
						<tr>
							<th>ID</th>
							<th>Code</th>
							<th>Type</th>
							<th>Amount</th>
							<th>Date Time</th>
							<th>Note</th>
							<th>Source</th>
						</tr>';
		    while($row2 = mysqli_fetch_assoc($result)) {
				$balance += $row2['amount'];

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
				echo '<td> ' . $row2['name']. ' </td> ';
				echo '</tr>';
				echo "</tr>";
		    }

		    echo "</tbody>
				</table>";

			echo 'Total balance: $'.$balance;
		}else{
			echo "There is no transcations in customer <b>".$_COOKIE['customer_name']."</b> records matched the keyword.";
		}
	}
?>