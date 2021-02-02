<?php 
	include "dbconfig.php";
	$balance = 0;
	if( !isset($_COOKIE['customer_id']) ){
		echo 'Please click on <a href="index.html">here (project home)</a> to login first!';
		die();
	}else{
		if(!empty($_COOKIE['customer_id'])){			
			mysqli_select_db($link, "CPS3740_2020S");
			$sql = "SELECT * FROM Money_nuneelvi WHERE cid = " . $_COOKIE['customer_id'];
			$result2 = mysqli_query($link, $sql);
						
			if (mysqli_num_rows($result2) > 0) {
			    while($row2 = mysqli_fetch_assoc($result2)) {
		      		$balance += $row2['amount'];
			    }
			}
		}
	}
?>
<html>
<body>
	<a href='logout.php'>User logout</a><br>
	<br>
	<font size=4><b>Add Transaction</b></font>
	<br>
	<b><?php echo ( !empty($_COOKIE['customer_name']) )? $_COOKIE['customer_name']  : "";?></b> current balance is <b><?php echo $balance?></b>.
	<br>
	<form name="input" action="insert_transaction.php" method="post">
		Transaction code: 
		<input type="text" name="code" required="required">
		<br>

		<input type='radio' name='type' value='D'>Deposit
		<input type='radio' name='type' value='W'>Withdraw

		<br> 

		Amount: 
		<input type="text" name="amount" required="required">

		<br>
		Select a Source: 
		<SELECT name='source_id'>
			<?php
				mysqli_select_db($link, "CPS3740_2020S");
				$sql = "SELECT id, name FROM CPS3740.Sources";
				$result3 = mysqli_query($link, $sql);
							
				if (mysqli_num_rows($result3) > 0) {
					echo "<option value=''></option>";
					while($row2 = mysqli_fetch_assoc($result3)){
						echo "<option value='".$row2['id']."'>".$row2['name']."</option>";
					}
				}
			?>
		</SELECT>

		<br>

		Note: 
		<input type='text' name='note'>

		<br>
		<input type='submit' value='Submit'>
	</form>
</body>
</html>
<?php mysqli_close($link); ?>