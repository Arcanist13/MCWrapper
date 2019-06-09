<!DOCTYPE html>

<?php
	session_start();

	function validPassword($psk){
		if(strlen($psk) < 5){
			return False;
		}
		$detectPatt = '/^(.*)[0-9]+(.*)/';
		if(!preg_match($detectPatt, $psk)){
			return False;
		}
		return True;
	}

	$regErr = "";

	if(isset($_POST) && !empty($_POST)){
		// Get input
		$username = htmlspecialchars($_POST['username']);
		$password = $_POST['password'];
		$confpass = $_POST['confpass'];

		// Check all fields entered
		if($username != "" && $password != "" && $confpass != ""){
			// Setup sqlite PDO handler for prepared statements
			$db = 'users.db';
			$dsn = 'sqlite:'.$db;
			$opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
			$pdo = new PDO($dsn, null, null, $opt);

			// Check for valid password
			if(validPassword($password)){
				// Check if passwords match
				if($password == $confpass){
					// Check for username in db
					$query = "SELECT * FROM USERS WHERE USERNAME = :username";
					$prep = $pdo->prepare($query);
					$prep->execute(['username' => $username]);
					$result = $prep->fetch();

					// Check that user doesn't already exist
					if($result == false){
						// Get date/time
						date_default_timezone_set('Australia/Adelaide');
						$created = date('d/m/y h:i:s a', time());

						// Encrypt password
						$encpassword = password_hash($password, PASSWORD_DEFAULT);

						if($encpassword){
							// Insert into db
							$query = "INSERT INTO USERS (USERNAME, PASSWORD, ADMIN, CREATED) VALUES (:username, :password, :admin, :created)";
							$prep = $pdo->prepare($query);

							// check if insert successfull
							if($prep->execute(['username' => $username, 'password' => $encpassword, 'admin' => 0, 'created' => $created])){
								// Update session
								$_SESSION['USER'] = $username;
								$_SESSION['ADMIN'] = 0;

								header("Location: index.php?msg=r1");
							}
							else{
								$regErr = "Failed to create account.";
							}	
						}
						else{
							$regErr = "Failed to create account.";
						}
					}
					else{
						$regErr = "Must select a unique username.";
					}
				}
				else{
					$regErr = "Passwords don't match.";
				}
			}
			else{
				$regErr = "Invalid password. Passwords must be at least length 5 and have one numeric character.";
			}
		}
		else{
			$regErr = "You must have a username and password entered.";
		}
	}
?>

<html>
	<head>
		<!-- Required meta tags -->
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta name="robots" content="noindex">

		<title>Register</title>

		<!-- Style -->
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    	<link rel="stylesheet" href="style.css">

    	<!-- JavaScrip -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</head>
	<body>
		<?php include 'nav.php'; ?>

		<div class="nav-offset container-fluid">
			<div class="nav-offset text-center width-40">
				<div>
					<h2>Register an Account</h2>
					<br />
					<?php
						if($regErr != ""){
							echo '<div class="alert alert-danger alert-dismissible fade in">';
								echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
								echo $regErr;
							echo '</div>';
						}
					?>
				</div>

				<form action="register.php" method="post">
					<div class="form-group">
						<?php
							echo '<input type="text" class="form-control" name="username" value="';
							if(isset($username)){
								echo $username;
							}
							echo '" placeholder="Username" />';
						?>
					</div>

					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password" />
						<input type="password" class="form-control" name="confpass" placeholder="Confirm password" />
					</div>
					
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Sign up">
					</div>
				</form>
			</div>
		</div>
	</body>
</html>