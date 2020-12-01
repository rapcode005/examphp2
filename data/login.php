<?php
	
	session_start();
	
	if (isset($_POST['submit'])) {
	
		if ($_POST['uid'] == "admin" && $_POST['pwd'] == "12345") {
			$_SESSION['u_id'] = $_POST['uid'];
			$_SESSION['uid'] = $_POST['pwd'];
			
			header("Location: ../profile/");
			
			exit();
		}
		else {
			header("Location: ../index.php?login=empty");
			exit();
		}
	}
		
