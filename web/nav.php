<?php
  $uri = explode('/', $_SERVER['REQUEST_URI']);
  $end = end($uri);
?>

<nav class="navbar navbar-default navbar-fixed-top">
  	<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#index-navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="../index.php" class="navbar-brand">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="index-navbar-collapse">
      
      <?php
        if(isset($_SESSION['ADMIN']) && $_SESSION['ADMIN']){
          echo '<ul class="nav navbar-nav">';
          echo '<li class="';
          if(strpos($end, 'admin') !== false){
            echo 'active';
          }
          echo '"><a href="./admin.php">Admin</a></li>';
          echo '</ul>';
        }
      ?>
      
    	<div class="text-center">
	    	<?php
				if(isset($_SESSION['USER'])){
          echo '<button type="button" class="btn btn-transparent navbar-btn navbar-right" onclick="location.href=\'../account.php\'"><span class="glyphicon glyphicon-cog"></span></button>';
					echo '<button type="button" class="btn btn-default navbar-btn navbar-right" onclick="location.href=\'../logout.php\'">Logout</button>';
					echo '<p class="navbar-text navbar-right divider">Welcome '. $_SESSION['USER'] . '!</p>';
				}
				else{
					echo '<button type="button" class="btn btn-default navbar-btn navbar-right divider" onclick="location.href=\'login.php\'">Login</button>';
					echo '<button type="button" class="btn btn-default navbar-btn navbar-right divider" onclick="location.href=\'register.php\'">Register</button>';
				}
			?>
		</div>
    </div>
  </div>
</nav>