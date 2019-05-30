<!DOCTYPE html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
			var timer = setInterval(refresh, 3000);

			function refresh()
			{
				console.log("Refresh")
				
				$.get("./func.php", function(data){
					$("#mc-logs").html(data);
				});
			}

			$(document).ready(function(){
				refresh();
			});
		</script>

<html>
	<head>
		<title>Server Logs</title>

    	<!-- Bootstrap -->
    	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    	<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="mc-logs">
			<?php
				$temp = array_reverse($data);
				foreach ($temp as $line) {
					echo "<p>". htmlspecialchars($line) ."</p>";
				}
			?>
		</div>
	</body>
</html>