<?php 
		require_once 'layouts/header.php';
		if(isset($_SESSION['logged_user'])) { 
			header("Location:pages/profile.php");
			die;
		}
?>


<div class="form_container">
	<h3 class="errInfo" ><?=isset($_SESSION['wrong_sign'])?$_SESSION['wrong_sign']:"";?></h3>
	<form method="post" action="requests.php">
	      <div>
	      	<input type="email" name="email" placeholder="Email" value="<?= isset($_SESSION['signEmail'])?$_SESSION['signEmail']:"";?>">
	      	<span class="errInfo"><?=isset($_SESSION['signEmailErr'])?$_SESSION['signEmailErr']:"";?></span>
	      </div>
	      <div>
	      	<input type="password" name="password" placeholder="Password">
	      	<span class="errInfo"><?=isset($_SESSION['signPasswordErr'])?$_SESSION['signPasswordErr']:"";?></span>
	      </div>
	      <input type="submit" name="sign" value="Sign in">
		  <div style="display: flex; justify-content: space-between;" >
		  	<p>Don't Have an Account ? <a href="<?=ROOT_URL?>pages/register.php">Register</a></p>
		  	<p>Forgot password ? <a href="<?=ROOT_URL?>pages/recover.php">Recover</a></p>
		  </div>
	</form>
</div>
<?php 
		session_unset();
		require_once 'layouts/footer.php';
?>
	
