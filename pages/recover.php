<?php 
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/header.php");
	if(isset($_SESSION['logged_user'])) {  // sra optimal dzev@ ???
		header("Location:pages/profile.php");
		die;
	}
?>
	<h4 style="text-align: center;" ><?= isset($_SESSION['check_email'])?$_SESSION['check_email']:"";?></h4>
	<div class="form_container">
	
		<form action="../requests.php" method="post">
			<div>
				<input type="text" name="email" placeholder="Email address of your Profile">
				<span class="errInfo"><?= isset($_SESSION['recEmailErr'])?$_SESSION['recEmailErr']:"";?></span>
			</div>
			<input type="submit" name="recover" value="Submit">
		  	<p>Have an Account ? <a href="<?=ROOT_URL?>">Sign In</a></p>
			
		</form>
	</div>
<?php 
	session_unset();
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/footer.php");
 ?>