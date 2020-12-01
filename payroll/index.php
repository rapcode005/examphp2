<?php
	include_once '../data/dbh.php';
	include_once '../layout/header.php';
	
	if (!isset($_SESSION['u_id'])) {
		header("Location: ../index.php");
	}
	
?>
<div class="container mt-4">
	<div class="row mt-5 justify-content-center align-items-center">
      <h2>Create Payroll</h2>
	</div>
	
	<form action="data/addPayroll.php" method="post">
		<div class="row mt-5 align-self-center">
			<div class="col-3">
				<div class="form-group">
					<center>
						<label for="salesrep">Sales Rep</label>
						<select id="salesrep" name="salesrep" class="form-control form-control-sm"  
						aria-label="salesrep" onchange="onselectSalesRep()" >
							<option selected value="">Select Sales Reps</option>
							<?php
								$sql = "Select id,name,com,tax,bonus from Profile";
								
								$result = mysqli_query($conn, $sql); 

								while ($row = mysqli_fetch_assoc($result)) { ?>
								
									<option value="<?= $row['id'] ?>-<?= $row['bonus'] ?>-<?= $row['com'] ?>"><?= $row['name'] ?></option>
									
								<?php }
								
								$conn->close(); ?>
							
						</select>
					</center>
				</div>
				
			</div>
			
			<div class="col-6">
				<center>
					<label for="dates">Dates Period</label>
					<div id="dates" class="input-group pl-3">
						<div class="col-4">		
							<select id="month" name="month" class="form-control 
							form-control-sm input-sm"  
							aria-label="month">
								  <option value="Jan">Jan</option>
								  <option value="Feb">Feb</option>
								  <option value="Mar">Mar</option>
								  <option value="Apr">Apr</option>
								  <option value="May">May</option>
								  <option value="Jun">Jun</option>
								  <option value="Jul">Jul</option>
								  <option value="Aug">Aug</option>
								  <option value="Sept">Sept</option>
								  <option value="Oct">Oct</option>
								  <option value="Nov">Nov</option>
								  <option value="Dec">Dec</option>
							</select> 
						</div>
				
						<div class="col-4">	
							<select id="period" name="period" class="form-control 
							form-control-sm"  
							aria-label="period">
								  <option value="Weekly">Weekly</option>
								  <option value="Biweekly">Biweekly</option>
								  <option value="Monthly">Monthly</option>
								  <option value="Quarterly">Quarterly</option>
								  <option value="Annualy">Annualy</option>
							</select> 
						</div>
					
						<div class="col-4"> 
							<input type="number" id="year" name="year" class="form-control form-control-sm"  
							aria-label="year" min="0"/>
						</div>
					</div>
					<div class="form-group mt-5 w-50">
								<label for="bonus">Bonus</label>
								<input type="number" id="bonus" name="bonus" 
								class="form-control form-control-sm w-50"  
								aria-label="bonus"></input>
					</div>
				</center>
			</div>
			
			<div class="col-3">
				<div class="form-group">
					<center>
						<label for="client">No. of Client</label>
						<input type="number" id="client" name="client" 
						class="form-control form-control-sm w-50"  
						aria-label="client"  min="0" />
					</center>
				</div>
			</div>
			
		</div>
		
		<div id="lst">
		
		
		</div>
		
		<div class="row mt-5 justify-content-center align-items-center">
			<button id="addPayroll" style="display:none" type="submit"class="btn btn-primary" value="addPayroll"
			name="addPayroll">Create Payroll</Submit>
		</div>
		
		<input type="hidden" name="clientname" id="clientname" />
		<input type="hidden" name="coms" id="coms" />
		<input type="hidden" name="idProfile" id="idProfile" />
	</form>
	<! -- Popup -- >
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
				<form action="../profile/data/addProfile.php" method="post" id="profileForm">
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
<script type="text/javascript">
	
	var jComs;
	var len = 0;
	var jsonN = {};
	var jsonC = {};
	
	function onselectSalesRep() {
		
		$('#lst').empty();
		document.getElementById("addPayroll").style.display = "none";
		document.getElementById("client").value = "";
		
		jsonN = {};
		jsonC = {};
		
		if (document.getElementById("salesrep").value != "") {
			var x = document.getElementById("salesrep").value.split("-");
			var id = x[0];
			var bonus = x[1];
			document.getElementById("bonus").value = bonus;
			document.getElementById("idProfile").value = id;
			jComs = x[2];
			var d = new Date();
			document.getElementById("year").value = d.getFullYear();
		}
		else {
			document.getElementById("bonus").value = "";
			document.getElementById("idProfile").value = "";
			jComs = "";
		}
	}
		
	function onValueChanged(n, v) {
		 $('#' + n).val(v);
	}
		
	$(document).ready(function(){
		$("#client").on('keyup', function(){
			var salesrep = $('#salesrep').find(":selected").text();
			if (salesrep != "Select Sales Reps")
				add(this.value);
		});
	});
	
	function add(x) {
		var c = x == "" ? 0 : x;
		$('#lst').empty();
		if (c > 0) {
			document.getElementById("addPayroll").style.display = "inline";
		}
		else
			document.getElementById("addPayroll").style.display = "none";
			
		for (var i = 1; i <= c; i++) {
			var n = 'client-' + i;
			var start = '<div class="row mt-5 justify-content-center align-items-center"><div class="form-group">';
			var label = '<center><label for="' + n + '">Client Name</label>';
			var input = '<input oninput=\'onNameChanged("' + n + '")\' type="text" id="' + n + '" class="form-control form-control-sm" aria-label="' + n + '"/>';
			var end = '</center></div></div>';
			var el = start + label + input + end;
			var n1 = 'com-' + i;
			var start1 = '<div class="row justify-content-center align-items-center"><div class="form-group">';
			var label1 = '<center><label for="' + n1 + '">Elitensure Commissions</label>';
			var input1 = '<input type="number" oninput=\'onComChanged("' + n1 + '")\'  id="' + n1 + '" class="form-control form-control-sm" aria-label="' + n1 + '"/>';
			var end1 = '</center></div></div>';
			var el1 = start1 + label1 + input1 + end1;
			$("#lst").append(el + el1);
		}
	}
	
	function onNameChanged(n) {
		var v = document.getElementById(n).value;
		var i = n.split("-");
		var n1 = 'com-' + i[1]
		var v1 = document.getElementById(n1).value;
		jsonN[n] = v;
		jsonC[n1] = v1;
		$('#clientname').val(JSON.stringify(jsonN));
		$('#coms').val(JSON.stringify(jsonC));
	}
	
	function onComChanged(n) {
		var v = document.getElementById(n).value;
		jsonC[n] = v;
		$('#coms').val(JSON.stringify(jsonC));
	}
	
</script>
<?php		
	include_once '../footer.php';
?>

