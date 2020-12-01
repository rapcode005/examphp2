<?php
	include_once '../data/dbh.php';
	include_once '../layout/header.php';
	
	if (!isset($_SESSION['u_id'])) {
		header("Location: ../index.php");
	}
?>
<br><br>
<div class="container mt-5">
	<table class="table table-striped">
		<thead>
			<tr>
				<th scope="col">Sales Rep</th>
				<th scope="col">Commission Percentage</th>
				<th scope="col">Tax Rate</th>
				<th scope="col">Bonuses</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$sql = "Select name,com,tax,bonus from Profile";
						
				$result = mysqli_query($conn, $sql); 

				while ($row = mysqli_fetch_assoc($result)) { ?>
				
					<tr>
						<td><?= $row['name'] ?></td>
						<td><?= $row['com'] ?></td>
						<td><?= $row['tax'] ?></td>
						<td><?= $row['bonus'] ?></td>
					<tr>
				<?php }
				
				$conn->close();
			?>
		</tbody>
	</table>
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
								placeholder="Salesrep Name" required>
							</div>
							<div class="input-group input-group-sm mb-3">
								<input class="form-control" aria-label="Small" id="commission"
								placeholder="Set Commission Percentage"4
								name="commission"
								type="number"
								aria-describedby="percent" required></input>
								<div class="input-group-append">
									<span class="input-group-text" id="percent">%</span>
								</div>
							</div>
							<div class="input-group input-group-sm mb-3">
								<input type="number" class="form-control" 
								placeholder="Tax Rate"
								name="taxrate"
								id="taxrate" required>
							</div>
							<div class="input-group input-group-sm mb-3">
								<input type="number" class="form-control" 
								placeholder="Bonuses"
								name="bonus"
								id="bonus" required>
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

