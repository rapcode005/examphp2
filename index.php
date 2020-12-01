<?php
	
	session_start();
	
	if(isset($_SESSION['u_id'])) {
		header("Location: home/");
	}
	else {
		
		include 'headerhomeadmin.php';
		
			echo "
			<div class='login-page'>
			<center>
			<img src='assets/img/logo.png' />
			</center>
			<div class='form'>
			<form class='login-form' action='data/login.php' method='POST'>
			<input type='text' name='uid' 
			placeholder='Username' />
			<input type='password' name='pwd' 
			placeholder='Password' />
			<button type='submit' name='submit'
			>Login</button></form>
			</div></div>";
	}

	include_once 'footer.php';
?>

