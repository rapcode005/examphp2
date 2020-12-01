<?php
	session_start();
	if (isset($_POST['addPayroll'])) {
		
		include '../../data/dbh.php';
		
		$salesrep = mysqli_real_escape_string($conn, $_POST['salesrep']);
		$month = mysqli_real_escape_string($conn, $_POST['month']);
		$period = mysqli_real_escape_string($conn, $_POST['period']);
		$year = mysqli_real_escape_string($conn, $_POST['year']);
		$bonus = mysqli_real_escape_string($conn, $_POST['bonus']);
		$idProfile = mysqli_real_escape_string($conn, $_POST['idProfile']);
		$client = mysqli_real_escape_string($conn, $_POST['client']);
		$clientname = json_decode(str_replace("client-","",$_POST['clientname']));
		$coms = json_decode(str_replace("com-","",$_POST['coms']));
		
		$aName = [];
		$aComs = [];

		foreach ($clientname as $key => $value) {
			array_push($aName, $value);
		}
		
		foreach ($coms as $key => $value) {
			array_push($aComs, $value);
		}
		
		
		$sqlInsert = "Insert into Payroll(profile_id,month_name,period,c_year,no_client)
		values($idProfile,'$month','$period',$year,$client)";
		
		$_SESSION['comsT'] = 0;
		
		if(mysqli_query($conn,$sqlInsert)){
			
			for($i = 0; $i <= $client; $i++) {

				$name = $aName[$i];
				$com = $aComs[$i];
				
				$_SESSION['comsT'] += $com;
				
				$sqlPs = "SELECT id FROM Payroll ORDER BY id DESC LIMIT 0, 1";
			
				$resultPs = mysqli_query($conn, $sqlPs); 
				while ($rowPs = mysqli_fetch_assoc($resultPs)) { 
					$pyI = $rowPs['id'];
				}
				
				$sqlInsertC = "Insert into client(payroll_id, name, com) 
				values($pyI,'$name',$com)";
				
				if(mysqli_query($conn,$sqlInsertC)){
					
				}
			}
		}
	
		
		$conn->close();
		
		createpdf();
	}
	
	function createpdf() {
		include '../../assets/code/fpdf.php';
		include '../../data/dbh.php';
		
		
		class PDF extends FPDF {
			// Page header
			function Headertitle($title)
			{
				// Arial bold 15
				$this->SetFont('Arial','B',12);
				// Title
				$this->Cell(30,6,$title,0);
				// Line break
				$this->Ln();
			}
			
			// Page footer
			function Footer()
			{
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}
			
			// Simple Alignment
			function Alignment($title,$value) {
				$this->SetFont('Arial','',10);
				$this->Cell(80,6,$title,0);
				$this->Cell(80,6,$value,0); 
				$this->Ln();
			}
		}
		
		$y = $_POST['year'];
		$m = $_POST['month'];
		$idP = $_POST['idProfile'];
		$pd = $_POST['period'];
		
		$sqlPs = "SELECT max(id) as 'id' FROM Payroll";
			
		$resultPs = mysqli_query($conn, $sqlPs); 
		while ($rowPs = mysqli_fetch_assoc($resultPs)) { 
			$pyIs = $rowPs['id'];
		}
		
		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		$pdf->Headertitle('Buyer Created Tax Invoices');
		
		$Months = array("Jan" => "01",
		"Feb" => "02",
		"Mar" => "03",
		"Apr" => "04",
		"May" => "05",
		"Jun" => "06",
		"Jul" => "07",
		"Aug" => "08",
		"Sept" => "09",
		"Oct" => "10",
		"Nov" => "11",
		"Dec" => "12");
		
		if ($pd == "Biweekly") {
			$startDate = $Months[$m]."/01/".$y;
			$endDate = $Months[$m]."/15/".$y;
			$dates = $Months[$m]."/01/".$y."-".$Months[$m]."/15/".$y;  
		}
		else if($pd == "Weekly") {
			$startDate = $Months[$m]."/01/".$y;
			$endDate = $Months[$m]."/07/".$y;
			$dates = $Months[$m]."/01/".$y."-".$Months[$m]."/07/".$y;
		}
		else if($pd == "Monthly") {
			$startDate = $Months[$m]."/01/".$y;
			$endDate =  $Months[$m]."/".date("t", strtotime($startDate))."/".$y;
			$dates = $startDate."-".$endDate;
		}
		else if($pd == "Quarterly") {
			$startDate = $Months[$m]."/01/".$y;
			$endDate = date("m/d/Y", strtotime('+2 months', strtotime($startDate)));
			$dates = $startDate."-".$endDate;
		}
		else {
			$startDate = $Months[$m]."/01/".$y;
			$endDate = date("m/d/Y", strtotime('+11 months', strtotime($startDate)));
			$dates = $startDate."-".$endDate;
		}
		
		$sql = "Select id,name,com,tax,bonus from profile where id=$idP"; 
		$result = mysqli_query($conn, $sql); 
		
		while ($row = mysqli_fetch_assoc($result)) { 
			$salesRepsName = $row['name'];
			$comsssPer = $row['com'];
			$taxes = $row['tax'];
			$bonuses =  $row['bonus'];
			$pdf->Alignment('Sales Rep No:',$row['id'].' '.$salesRepsName.'  '.$dates);
			$pdf->SetFillColor('RED');
			$pdf->Ln(5);
		}
		
		$sqlP = "Select reg_date from payroll where id=".$pyI; 
								
		$resultP = mysqli_query($conn, $sqlP); 
		while ($rowP = mysqli_fetch_assoc($resultP)) { 
			$pdf->Alignment('Produced on ('.date('m/d/Y', $rowP['reg_date']).')', $salesRepsName);
			$pdf->Alignment('Produced by:', 'Onlineinsure');
		}
		$pdf->Ln(5);
		
		$pdf->Alignment('Statement Week: ', $y.$Months[$m]);
		$pdf->Alignment('Statement Date: ', $endDate);
		$pdf->Alignment("Payment type:", "Direct Cable");
		$pdf->Ln(5);
		
		$pdf->Alignment('Date: ', $startDate);
		$pdf->Alignment('Decription:', 'Commission');	
		$pdf->Alignment('Credit: ', $_SESSION['comsT']);
		$pdf->Alignment('Decription:', 'Bonus');	
		if ($comsssPer == 60 && $tax == 5)
			$bonuses = floatval($bonuses) * 2;
			
		$pdf->Alignment('Credit: ', $bonuses);
		$pdf->Ln(5);
		
		$comsT = floatval($_SESSION['comsT']) * (floatval($comsssPer)/100);
		$taxT = $comsT * ((floatval($tax)/100));
		$compute = ($comsT - $taxT) + $bonuses;
		
		$pdf->Alignment('Net: ', $compute);
		$pdf->Ln(5);
		
		$sqlC = "Select name,com from client where payroll_id=".$pyIs; 
		
		echo $sqlC;
		
		$resultC = mysqli_query($conn, $sqlC); 
		while ($rowC = mysqli_fetch_assoc($resultC)) { 
			$pdf->Alignment('Client Name: ', $rowC['name']);
			$pdf->Alignment('Onlineinsure Commissions: ', $rowC['com']);
			$pdf->Ln(5);
		}
		
		$pdf->Output('F',"test.pdf");
		
		$conn->close();
		
		header("Location: viewPayroll.php");
	}
	
?>