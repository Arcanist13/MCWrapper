<!DOCTYPE html>

<?php
	session_start();
	$_SESSION['PREV_LOC'] = 'index.php';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
			var timer = setInterval(refresh, 3000);

			function refresh()
			{
				console.log("Refresh")
				
				$.get("./refresh.php", function(data){
					$("#mc-logs").html(data);
				});
			}

			function sendCommand()
			{
				var command = $("#commandInput").val();
				$.post("./sendCommand.php", {"cmd": command});
				$("#commandInput").val("");
			}

			$(document).ready(function(){
				refresh();
			});
		</script>

<html>
	<head>
		<!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta name="robots" content="noindex">
	    
		<title>Server Logs</title>

		<!-- Style -->
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    	<link rel="stylesheet" href="style.css">

    	<!-- JavaScrip -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php include 'nav.php'; ?>

		<!-- cmd -->
		<div class="nav-offset text-center">
		<?php
			if(isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']){
				echo "
					<form onsubmit=\"event.preventDefault();\">
						<div class=\"form-group form-inline\">
							<input type=\"text\" class=\"form-control\" name=\"command\" id=\"commandInput\" placeholder=\"\" autocomplete=\"off\">
							<input type=\"submit\" class=\"btn btn-info\" value=\"Send\" onclick=\"sendCommand()\">
						</div>
					</form>
					<br/>
				";
			}
		?>
		</div>

		<div>
			<div id="mc-logs" class="tab-pane"></div>
		</div>
	</body>
</html>