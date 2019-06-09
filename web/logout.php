<?php
	session_start();
	$previous_location = $_SESSION['PREV_LOC'];
	session_unset();
	session_destroy();

	header("Location: " . $previous_location);
?>