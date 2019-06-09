<!DOCTYPE html>

<?php
	session_start();

	$errorMsg = "";
	$username = "";

	if(isset($_POST) && !empty($_POST)){
		$username = htmlspecialchars($_POST['username']);
		$password = $_POST['password'];

		if($username != "" && $password != ""){
			// Setup sqlite PDO handler for prepared statements
			$db = 'users.db';
			$dsn = 'sqlite:'.$db;
			$opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
			$pdo = new PDO($dsn, null, null, $opt);

			// Check for username in db
			$query = "SELECT * FROM USERS WHERE USERNAME = :username";
			$prep = $pdo->prepare($query);
			$prep->execute(['username' => $username]);
			$result = $prep->fetch();

			// See if found
			if($result != false){
				// See if match
				if(password_verify($password, $result[2])){
					$_SESSION['USER'] = $username;
					$_SESSION['ADMIN'] = $result[3];

					date_default_timezone_set('Australia/Adelaide');
					$activity = date('d/m/y h:i:s a', time());
					$query = "UPDATE USERS SET ACTIVITY = :activity WHERE USERNAME = :username";
					$prep = $pdo->prepare($query);
					$prep->execute(['activity' => $activity, 'username' => $username]);

					if(isset($_SESSION['PREV_LOC']) && $_SESSION['PREV_LOC'] != ""){
						header("Location: " . $_SESSION['PREV_LOC']);
					}
					else{
						header("Location: ./index.php");
					}
				}
				else{
					$errorMsg = "Username or password do not match any user.";
				}
			}
			else{
				$errorMsg = "Username or password do not match any user.";
			}
		}
		else{
			$errorMsg = "Username and password cannot be empty.";
		}
	}
?>

<html>
	<head>
		<!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta name="robots" content="noindex">

		<title>Login</title>

		<!-- Style -->
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    	<link rel="stylesheet" href="style.css">

    	<!-- jQuery & JavaScrip -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    	<script async src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</head>
	<body>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

		<?php include 'nav.php'; ?>

		<div class="nav-offset container-fluid">
			<div class="nav-offset text-center width-40">
				<div>
					<h2>Log in</h2>
					<?php
						if($errorMsg != ""){
							echo '<div class="alert alert-danger alert-dismissible fade in">';
								echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
								echo $errorMsg;
							echo '</div>';
						}
					?>
				</div>

				<form action="login.php" method="post">
					<div class="form-group">
						<?php
							echo '<input type="text" class="form-control" name="username" value="'.$username.'" placeholder="Username" / autofocus>';
						?>
					</div>

					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password" />
					</div>
					
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Login">
						<!-- <br /> <br />
						<a href="register.php">Sign up now >></a> -->
					</div>
				</form>
			</div>
		</div>
	</body>
</html>