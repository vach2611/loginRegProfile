<?php 
	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/header.php");
	require_once '../database.php';
	unset($_SESSION['wrong_sign']);
	
	$who = $_SESSION['logged_user'];
	$users=getData($conn,'users','*',"WHERE email='$who'");
	$user=$users[0];

?>
	
	<div id="user_profile">
		<div class="user_card">
			<div class="user_image"><img id="prof_img" src="<?=$user['img']?>"></div>
			<!-- <form action="../requests.php" method="post" enctype="multipart/form-data" id="form1"> -->
				<!-- <input type="file" name="image" id="img" class="imgfile"> -->
				<label for="img">Փոխել նկարը</label>
				<!-- <input type="submit" name="uploadImage" class="imgfile"> -->
			<!-- </form> -->

			<p class="fullName" ><?=$user['name'].' '.$user['surname']?></p>
			<p class="email"><?=$user['email']?></p>
			<p><?=$user['country']?></p>
		</div>


		<div class="user_update">
			<h1>Personal Information</h1>

			<form action="../requests.php" method="post" enctype="multipart/form-data" >
				<input type="file" name="image" id="img" class="imgfile">
				
				<div>
					<input type="text" placeholder="Name" name="name" value="<?=$user['name']?>">
					<span class="errInfo"><?= isset($_SESSION['updNameErr'])?$_SESSION['updNameErr']:"";?></span>
				</div>
				<div>
					<input type="text" placeholder="Surname" name="surname" value="<?=$user['surname']?>">
					<span class="errInfo"><?= isset($_SESSION['updSurnameErr'])?$_SESSION['updSurnameErr']:"";?></span>
				</div>
				<div>
					<input type="text" placeholder="Age" name="age" value="<?=$user['age']?>">
					<span class="errInfo"><?= isset($_SESSION['updAgeErr'])?$_SESSION['updAgeErr']:"";?></span>
				</div>
				<div>
					<input type="text" placeholder="Country" name="country" value="<?=$user['country']?>">
					<span class="errInfo"><?= isset($_SESSION['updCountryErr'])?$_SESSION['updCountryErr']:"";?></span>
				</div>
				<div class="gen_block">
					<div class="gender"><label for="male">Male</label><input id="male" type="radio" name="gender" value="male" <?=($user['gender']=='male')?"checked=''":""?>></div>
					<div class="gender"><label for="female">Female</label><input id="female" type="radio" name="gender" value="female" <?=($user['gender']=='female')?"checked=''":""?>></div>
					<span class="errInfo"><?=isset($_SESSION['updGenderErr'])?$_SESSION['updGenderErr']:"";?></span>
				</div>
				<div>
					<input type="email" placeholder="Email" name="email" value="<?=$user['email']?>">
					<span class="errInfo"><?=isset($_SESSION['updEmailErr'])?$_SESSION['updEmailErr']:"";?></span>
				</div>
				<input id="form2" type="submit" name="updateData" value="Save Changes">
			</form>
			
		</div>
	</div>
	
			<a href="out.php" class="logout" >Log Out</a>




<?php
	if (!(isset($_SESSION['logged_user']))) {
		header("Location:../index.php");
		die;
	}

	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/footer.php");

?>