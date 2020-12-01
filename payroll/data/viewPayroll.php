<?php
$filePath = "test.pdf";
		if (!file_exists($filePath)) {
			echo "The file $filePath does not exist";
			die();
		}
		$filename="test.pdf";

		header('Content-type:application/pdf');
		header('Content-disposition: inline; filename="'.$filename.'"');
		header('content-Transfer-Encoding:binary');
		header('Accept-Ranges:bytes');
		readfile($filePath);
?>