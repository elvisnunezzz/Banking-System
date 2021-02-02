<?php 

	include "dbconfig.php";
	
	if( isset($_POST) && !empty($_POST) && !empty($_COOKIE['customer_id']) ){
		$ids = $_POST['tid'];
		$arrayDelete = $_POST['cdelete'];
		$arrayUpdate = $_POST['note'];

		mysqli_select_db($link, "CPS3740_2020S");
		$delete = 0;
		$update = 0;
		echo "<a href='logout.php'>User logout</a><br>";
		foreach ($ids as $key => $value) {

			// Delete
			if( $arrayDelete[$value] == "Y" ){
				$sqlDelete = "DELETE FROM Money_nuneelvi WHERE id = " . $value;
				$resultDelete = mysqli_query($link, $sqlDelete);

				echo "Successfully delete transaction code: ".$sqlDelete ."<br>";
				$delete++;
				continue;
			}

			//Updated
			$sql = "SELECT * FROM Money_nuneelvi WHERE note = '".$arrayUpdate[$key]."' AND id = " . $value;
			$result = mysqli_query($link, $sql);
			
			if (mysqli_num_rows($result) > 0) {
			    
			}else{
				$sqlUpdated = "UPDATE Money_nuneelvi SET note = '".$arrayUpdate[$key]."' WHERE id = " . $value;
				$resultUpdated = mysqli_query($link, $sqlUpdated);

				if( $resultUpdated ){
					echo "Successfully update transaction code: ".$sqlUpdated."<br>";
					$update++;
				}				
			}
		}

		echo "<br><br>"."Finish deleting ".$delete." records and updating ".$update." transactions";
	}else{
		header("Location: display_update_transaction.php");
	}

	mysqli_close($link);