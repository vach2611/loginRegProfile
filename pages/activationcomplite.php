<?php 
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/header.php");

	require_once '../database.php';
	unset($_SESSION['wrong_sign']);

	if(isset($_SESSION['logged_user'])) {  // sra optimal dzev@ ???
		header("Location:profile.php");
		die;
	}
	if ($_GET['id']) {
		$user = getData($conn,'users','*',"WHERE id=".$_GET['id']);
		if (!empty($user) && $user[0]['active']==0) {
			$mail = $user[0]['email'];
			updateData($conn,'users',["active=1"],"email='$mail'");
?>
			<h1 style="text-align: center;margin-top: 50px;" >Your Email is already confirmed <br> Now you can <a href="../index.php">Sign In</a> your profile</h1>

<?php 
		}
		elseif (!empty($user) && $user[0]['active']==1) {
?>
			<h1 style="text-align: center;margin-top: 50px;" >Your profile is already activated <br>This link is Invalid.</h1>
<?php			
			header("Refresh:2;url=../index");
			die;
		}else{
?>
			<h1 style="text-align: center;margin-top: 50px;" >Sorry Your data is not found <br> please<a href="register">Register</a>again</h1>
<?php				
		}
	}
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/footer.php");
?>
