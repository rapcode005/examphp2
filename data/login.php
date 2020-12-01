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
	
		/*include_once 'dbh.php';
		
		$uid = mysqli_real_escape_string($conn,$_POST['uid']);
		$pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
		
		
		//Error handlers
		//Check if inputs are empty
		if (empty($uid) || empty($pwd)) {
			//header("Location: ../index.php?login=empty");
			exit();
		}
		else {
			$sql = "SELECT * FROM user_profile WHERE user='".$uid."'";
			$result = mysqli_query($conn,$sql);
			$resultCheck = mysqli_num_rows($result);
			if ($resultCheck < 1) {
				header("Location: ../index.php?login=error");
				exit();
			}
			else {
				if ($row = mysqli_fetch_assoc($result)) {
					//De-hashing the password
					//$hashedPwdCheck = password_verify($pwd,$row['password']);
					if ($row['password'] != $pwd) {
						header("Location: ../index.php?login=error");
						exit();
					}
					else {
						//Log in the user here
						$_SESSION['u_id'] = $row['id'];
						$_SESSION['uid'] = $row['user'];
						
						header("Location: ../profile/");
						
						exit();
					}
				}
			}
		}*/
	}
		
