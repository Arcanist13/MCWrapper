<?php
	$filepath = '../logs/latest.log';
	$data = [];
	$result = "";

	if(file_exists($filepath) && is_file($filepath)){
		$file = fopen($filepath, 'r');

		while (($line = fgets($file)) !== false) {
			array_push($data, $line);
		}
		fclose($file);
	}
	else{
		$result = "Could not open";
	}

	$data = array_reverse($data);
	foreach ($data as $line) {
		$result = $result . "<p>" . $line . "</p>";
	}

	echo $result;
?>