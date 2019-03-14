<?php 
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/header.php");
	require_once '../database.php';
	unset($_SESSION['wrong_sign']);

	if(isset($_SESSION['logged_user'])) {  // sra optimal dzev@ ???
		header("Location:profile.php");
		die;
	}

	if ($_GET['id']) {
		$_SESSION['recPassID']=$_GET['id'];
		$user = getData($conn,'users','*',"WHERE id=".$_GET['id']);
		if (!empty($user) && $user[0]['active']==1) {
			// updateData($conn,'users',["activated=1"],$user[0]['email']);
?>
		<div class="form_container">
			<form action="../requests.php" method="post">
				<div>
					<input type="password" name="updPass" placeholder="Write your password">
					<input type="password" name="ReUpdPass" placeholder="Reapeat you password">
					<span class="errInfo"><?= isset($_SESSION['RecPassErr'])?$_SESSION['RecPassErr']:"";?></span>
				</div>
				<input type="submit" name="chengePass" value="Change Password">
			</form>
		</div>
<?php 
		}
	}

	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/footer.php");

?>