<?php 
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/header.php");
	unset($_SESSION['wrong_sign']);
	if(isset($_SESSION['logged_user'])) { 
		header("Location:profile.php");
		die;
	}

?>

	<div class="form_container">
		<form action="../requests.php" method="post">
			<div>
				<input type="text" placeholder="Name" name="name" value="<?=isset($_SESSION['name'])?$_SESSION['name']:"";?>">
				<span class="errInfo" ><?= isset($_SESSION['nameErr'])?$_SESSION['nameErr']:"";?></span>
			</div>
			<div>
				<input type="text" placeholder="Surname" name="surname" value="<?=isset($_SESSION['surname'])?$_SESSION['surname']:"";?>">
				<span class="errInfo" ><?=isset($_SESSION['surnameErr'])?$_SESSION['surnameErr']:"";?></span>
			</div>
			<div>
				<input type="text" placeholder="Age" name="age" value="<?=isset($_SESSION['age'])?$_SESSION['age']:"";?>">
				<span class="errInfo" ><?=isset($_SESSION['ageErr'])?$_SESSION['ageErr']:"";?></span>
			</div>
			<div>
				<input type="text" placeholder="Country" name="country" value="<?=isset($_SESSION['country'])?$_SESSION['country']:"";?>">
				<span class="errInfo" ><?=isset($_SESSION['countryErr'])?$_SESSION['countryErr']:"";?></span>
			</div>
			<div class="gen_block">
				<div class="gender"><label for="male">Male</label><input type="radio" name="gender" value="male" checked=""></div>
				<div class="gender"><label for="female">Female</label><input type="radio" name="gender" value="female"></div>
				<span class="errInfo"><?=isset($_SESSION['genderErr'])?$_SESSION['genderErr']:"";?></span>
			</div>
			<div>
				<input type="email" placeholder="Email" name="email" value="<?=isset($_SESSION['email'])?$_SESSION['email']:"";?>">
				<span class="errInfo"><?=isset($_SESSION['emailErr'])?$_SESSION['emailErr']:"";?></span>
			</div>
			<div>
				<input type="password" placeholder="Password" name="password">
				<span class="errInfo"><?=isset($_SESSION['passwordErr'])?$_SESSION['passwordErr']:"";?></span>
			</div>
			<div>
				<input type="password" placeholder="Repeat Password" name="rePassword">
				<span class="errInfo"><?=isset($_SESSION['passwordErr'])?$_SESSION['passwordErr']:"";?></span>
			</div>
				<input type="submit" name="register" value="Register">
		  	<p>Have an Account ? <a href="<?=ROOT_URL?>">Sign In</a></p>

		</form>
	</div>

<?php 
	// require_once 'layouts/footer.php';
	session_unset(); 	
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/footer.php");

?>