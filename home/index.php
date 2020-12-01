<?php
	include_once '../data/dbh.php';
	include_once '../layout/header.php';
	
	if (!isset($_SESSION['u_id'])) {
		header("Location: ../index.php");
	}
?>
<br><br>
<div class="container mt-5">
	<! -- Popup --!>
	<div class="modal fade" id="salesrepProfile" tabindex="-1" role="dialog" 
		aria-labelledby="salesrepProfileLabel" 
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-info modalWh">
					<h5 class="modal-title" id="salesrepProfileLabel">Sales Rep Profile</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="modalWh" aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="data/addProfile.php" method="post" id="profileForm">
					<div class="modal-body">
						
							<div class="input-group input-group-sm mb-3">
								<input type="text" 
								class="form-control" 
								id="name"
								name="name"
								placeholder="Salesrep Name">
							</div>
							<div class="input-group input-group-sm mb-3">
								<input class="form-control" aria-label="Small" id="commission"
								placeholder="Set Commission Percentage"4
								name="commission"
								aria-describedby="percent"></input>
								<div class="input-group-append">
									<span class="input-group-text" id="percent">%</span>
								</div>
							</div>
							<div class="input-group input-group-sm mb-3">
								<input type="text" class="form-control" 
								placeholder="Tax Rate"
								name="taxrate"
								id="taxrate">
							</div>
							<div class="input-group input-group-sm mb-3">
								<input type="text" class="form-control" 
								placeholder="Bonuses"
								name="bonus"
								id="bonus">
							</div>
					</div>
					<div class="modal-footer">
						<a class="btn btn-secondary" href="#" data-dismiss="modal">Close</a>
						<button type="submit"class="btn btn-primary" value="saveProfile"
						name="saveProfile">Save</Submit>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php		
	include_once '../layout/footer.php';
?>

