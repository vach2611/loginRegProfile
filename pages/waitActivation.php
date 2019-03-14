<?php 
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/header.php");
	unset($_SESSION['wrong_sign']);
	if(isset($_SESSION['logged_user'])) {  
		header("Location:profile.php");
		die;
	}
?>
	<h1 style="text-align: center;margin-top: 50px;" >Please Activate your Email Address</h1>
<?php 
	header("Location:../index.php");
	die;
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/footer.php");
?>