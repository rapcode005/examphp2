<?php
	if (isset($_POST['saveProfile'])) {
		
		include '../../data/dbh.php';
	
		$name = mysqli_real_escape_string($conn, $_POST['salesrep']);
		$com = mysqli_real_escape_string($conn, $_POST['commission']);
		$tax = mysqli_real_escape_string($conn, $_POST['taxrate']);
		$bonus = mysqli_real_escape_string($conn, $_POST['bonus']);
		
		if (empty($name) || empty($com) ||
			empty($tax) || empty($bonus)) {
			header("Location: ../?n=empty");
			exit();
		}
		else {
			
			$sqlInsert = "Insert into profile(name,com,bonus,tax,reg_date)
			values('$name',$com,$bonus,$tax,NOW())";
			
			if (mysqli_query($conn,$sqlInsert)) {
				header("Location: ../");
			} 
			else {
				echo mysqli_error($conn);
			}
			exit();
			
		}
		
		$conn->close();
	}
?>