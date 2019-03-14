<?php 
	require_once 'config.php';
	require_once 'database.php';
	$regData=getData($conn,'users');
	require_once 'mailer.php';



	function checkData($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	if (isset($_POST['register'])) {
		$error = false;
		if (!empty($_POST['name']) && preg_match("/(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/",$_POST['name'])){
			$_SESSION['name'] = $name = mysqli_real_escape_string($conn,checkData($_POST['name']));
			unset($_SESSION['nameErr']);
		}else{
			unset($_SESSION['name']);
			$_SESSION['nameErr'] = "Name is Invalid";
			$error=true;
		}

		if (!empty($_POST['surname']) && preg_match("/(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/",$_POST['surname'])){
			$_SESSION['surname'] = $surname = mysqli_real_escape_string($conn,checkData($_POST['surname']));
			unset($_SESSION['surnameErr']);
		}else{
			unset($_SESSION['surname']);
			$_SESSION['surnameErr'] = "Surname is Invalid";
			$error=true;
		}

		if(!empty($_POST['age']) && is_numeric($_POST['age']) && strlen($_POST['age'])<=3) {
			$_SESSION['age'] = $age = mysqli_real_escape_string($conn,checkData($_POST['age']));
			unset($_SESSION['ageErr']);
		}else{
			unset($_SESSION['age']);
			$_SESSION['ageErr'] = "Age is Invalid";
			$error=true;
		}

		if (!empty($_POST['country']) && preg_match("/(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/",$_POST['country'])) {
			$_SESSION['country'] = $country = mysqli_real_escape_string($conn,checkData($_POST['country']));
			unset($_SESSION['countryErr']);
		}else{
			unset($_SESSION['country']);
			$_SESSION['countryErr'] = "Country is Invalid";
			$error=true;
		}

		if (isset($_POST['gender'])) {
			$_SESSION['gender'] = $gender = mysqli_real_escape_string($conn,checkData($_POST['gender']));
			unset($_SESSION['genderErr']);
		}else{
			unset($_SESSION['gender']);
			$_SESSION['genderErr'] = "Gender is Invalid";
			$error=true;
		}

		if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			if (!empty($regData)) {
				foreach ($regData as $data) {
					if (is_array($regData) && !in_array($_POST['email'], $data)) {
			 			$_SESSION['email'] = $email = $_POST['email'];
						// unset($_SESSION['emailErr']);
					}else{
						$_SESSION['emailErr'] = "Email already exists";
						$error=true;
					}
				}
			}else{
			 	$_SESSION['email'] = $email = $_POST['email'];
				unset($_SESSION['emailErr']);
			}
		}else{
			unset($_SESSION['email']);
			$_SESSION['emailErr'] = "Email is Invalid";
			$error=true;
		}

		if (!empty($_POST['password']) && $_POST['password']===$_POST['rePassword']) {
			$password = md5(mysqli_real_escape_string($conn,checkData($_POST['password'])));
			unset($_SESSION['passwordErr']);
		}elseif ($_POST['password']!==$_POST['rePassword']) {
			$_SESSION['passwordErr'] = "Passwords are not matches";
			$error=true;
		}
		else{
			$_SESSION['passwordErr'] = "Password is Invalid";
			$error=true;
		}
		$img = ($gender=="female")?"../assets/img/avatars/female.jpg":"../assets/img/avatars/male.jpg";
		$active = 0;
		if (!$error) {	
			$result=addData($conn,'users',["NULL","'$name'","'$surname'","$age","'$email'","'$gender'","'$country'","'$img'","'$password'","$active"]);
			if ($result) {
				$actContent = "<div style='padding:50px 0;background-color:cadetblue;'>
				<h1 style='font-size: 25px; margin-bottom: 30px;text-align:center;color:#fff;'>If you want to activate Your Profile <br> Click Activate button</h1>
				<div style='background-color: cornflowerblue;padding: 7px 45px;border-radius: 7px;font-size: 20px;letter-spacing: 4px;text-transform: uppercase;cursor: pointer;text-align:center;margin: 0 auto;' >
				<a style='text-decoration:none;color:#fff;' href='http://loginreg.beget.tech/pages/activationcomplite.php?id=".$result."'>Activate</a>
				</div></div>";
				$from = 'Authorization';
				$subject = 'Activation Request';
				sendMail($from,$email,$subject,$actContent);
				header("Location:pages/waitActivation.php");
				die;
			}
		}else{
			header("Location:pages/register.php");
			die;
		}
	}
// ================================================================== REGISTER END =============================================






	if (isset($_POST['sign'])) {
		$error = false;

		if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['signEmail'] = $email = $_POST['email'];	
			unset($_SESSION['signEmailErr']);
		}else{
			unset($_SESSION['signEmail']);
			$_SESSION['signEmailErr'] = "Email is Invalid";
			$error=true;
		}

		if (!empty($_POST['password'])){
			$password = md5(mysqli_real_escape_string($conn,checkData($_POST['password'])));
			unset($_SESSION['signPasswordErr']);
		} 
		else{
			$_SESSION['signPasswordErr'] = "Password is Empty";
			$error=true;
		}

		if(!$error){
			$sign = getData($conn,'users','*',"WHERE email='$email' AND password='$password'");
			if(!empty($sign) && $sign[0]['active']==1){
				$_SESSION["logged_user"]=$email;
				header("Location:pages/profile.php");
				die;
			}
			elseif(!empty($sign) && $sign[0]['active']==0) {
				$_SESSION['wrong_sign'] = "The Account is NOT Activated";
				header("Location:index.php");
				die;
			}
			else{
				$_SESSION['wrong_sign'] = "Email or Password not Found!!!";
				header("Location:index.php");
				die;
			}			
		}else{
			$_SESSION['wrong_sign'] = "Invalid Email and Password !!!";
			header("Location:index.php");
			die;
		}
	}

// ======================================================================SIGN END =======================================================










	// if (isset($_POST['uploadImage'])) {
	// 	$file=$_FILES["image"];
	// 	$fileName = $file["name"];
	// 	$fileError = $file["error"];
	// 	$fileSize = $file["size"];
	// 	$fileTMP = $file["tmp_name"];


	// 	if ($fileError==0 && $fileSize<9999999999) {

	// 		$fileExtension = pathinfo($fileName,PATHINFO_EXTENSION);
	// 		$arr=array("png","jpg","jpeg");
	// 		if (in_array($fileExtension, $arr)) {
			
	// 			$newName = uniqid(true).".".$fileExtension;
	// 			$dirName = "assets/img/".$_SESSION['logged_user'].'/';
	// 			if (!file_exists($dirName)){
	// 				shell_exec("mkdir $dirName");
				
	// 			}

	// 			move_uploaded_file($fileTMP, $dirName.$newName);

	// 			$newPath = $dirName.$newName;

	// 			foreach ($regData as &$data) {
	// 				if($data["email"]==$_SESSION["logged_user"]){
	// 					$oldImg=$data["img"];
	// 					updateData($conn,'users',["img='../$newPath'"],"id=".$data['id']);
	// 					// if ($oldImg!="assets/img/avatars/male.jpg" && $oldImg!="assets/img/avatars/female.jpg") unlink($oldImg);	
	// 				}
	// 			}
	// 			header("Location:pages/profile.php");
	// 			exit;
	// 		}
	// 	}
	// }



 
// ==========================================================IMAGE UPLOAD END ========================================================







if (isset($_POST['updateData'])) {

	$error = false;
	if (!empty($_POST['name']) && preg_match("/(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/",$_POST['name'])){
		$name = mysqli_real_escape_string($conn,checkData($_POST['name']));
		unset($_SESSION['updNameErr']);
	}else{
		$_SESSION['updNameErr'] = "Name is Invalid";
		$error=true;
	}


	if (!empty($_POST['surname']) && preg_match("/(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/",$_POST['surname'])){
		$surname = mysqli_real_escape_string($conn,checkData($_POST['surname']));
		unset($_SESSION['updSurnameErr']);
	}else{
		$_SESSION['updSurnameErr'] = "Surname is Invalid";
		$error=true;
	}

	if(!empty($_POST['age']) && is_numeric($_POST['age']) && strlen($_POST['age'])) {
		$age = mysqli_real_escape_string($conn,checkData($_POST['age']));
		unset($_SESSION['updAgeErr']);
	}else{
		$_SESSION['updAgeErr'] = "Age is Invalid";
		$error=true;
	}


	if (!empty($_POST['country']) && preg_match("/(?=.*[a-zA-Z]{1,})(?=.*[\d]{0,})[a-zA-Z0-9]{1,15}$/",$_POST['country'])) {
		$country = mysqli_real_escape_string($conn,checkData($_POST['country']));
		unset($_SESSION['updCountryErr']);
	}else{
		$_SESSION['updCountryErr'] = "Country is Invalid";
		$error=true;
	}

	if (isset($_POST['gender'])) {
		$gender = mysqli_real_escape_string($conn,checkData($_POST['gender']));
		unset($_SESSION['updGenderErr']);
	}else{
		$_SESSION['updGenderErr'] = "Gender is Invalid";
		$error=true;
	}


	if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		if ($_POST['email']===$_SESSION['logged_user']) {
			$email = $_POST['email'];
		}else{	
			foreach ($regData as $data) {
					if (!in_array($_POST['email'], $data)) {
			 			$email = $_POST['email'];
					}else{
						$_SESSION['updEmailErr'] = "Email already exists";
						$error=true;
					}
			}
		}
	}else{
		$_SESSION['updEmailErr'] = "Email is Invalid";
		$error=true;
	}




 
	$file=$_FILES["image"];
	$fileName = $file["name"];
	$fileError = $file["error"];
	$fileSize = $file["size"];
	$fileTMP = $file["tmp_name"];




		if ($fileError==0 && $fileSize<9999999999) {

			$fileExtension = pathinfo($fileName,PATHINFO_EXTENSION);
			$arr=array("png","jpg","jpeg");
			if (in_array($fileExtension, $arr)) {
			
				$newName = uniqid(true).".".$fileExtension;
				$dirName = "assets/img/".$_SESSION['logged_user'].'/';
				if (!file_exists($dirName)){
					shell_exec("mkdir $dirName");
				
				}

				move_uploaded_file($fileTMP, $dirName.$newName);

				$newPath = $dirName.$newName;

			}
		}
	

















	if (!$error) {
		$idEmail = $_SESSION['logged_user'];
		if ($fileName && $fileTMP) {
			updateData($conn,'users',["name='$name'","surname='$surname'","age=$age","email='$email'","gender='$gender'","country='$country'","img='../$newPath'"],"email='$idEmail'");	
		}else{
			updateData($conn,'users',["name='$name'","surname='$surname'","age=$age","email='$email'","gender='$gender'","country='$country'"],"email='$idEmail'");	
		}
		$_SESSION['logged_user'] = $email;
		header("Location:pages/profile.php");
		die;
	}else{
		header("Location:pages/profile.php");
		die;
	}
}


// =====================================================================UPDATE END ===========================================











	if (isset($_POST['recover'])) {
		if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$email = $_POST['email'];

			$recAccount = getData($conn,'users','*',"WHERE email='$email'");
	
				if(!empty($recAccount) && $recAccount[0]['active']==1) {
		 			$email = $_POST['email'];
		 			$messageName = "Recovery Request";
		 			$subject = "Password Recovery Request";
		 			$content ="<div style='padding: 50px 0;background-color: cadetblue;'>
								<h1 style='font-size: 25px; margin-bottom: 30px;text-align:center;color:#fff;'>If you want to Recovery Your Profile password <br> Click Recovery button</h1>
								<div style='background-color: cornflowerblue;padding: 7px 45px;border-radius: 7px;font-size: 20px;letter-spacing: 4px;text-transform: uppercase;cursor: pointer;text-align:center;' >
								<a style='text-decoration:none;color:#fff;' href='http://loginreg.beget.tech/pages/resetpassword.php?id=".$recAccount[0]['id']."'>Recovery</a>
								</div></div>";
					sendMail($messageName,$email,$subject,$content);
		 			$_SESSION['check_email']="Message is send Check your email";
		 			// sleep(1);
		 			// unset($_SESSION['check_email']);
		 			header("Location:pages/recover.php");
		 			die;
				}else{
					$_SESSION['recEmailErr'] = "Email not Found";
					header("Location:pages/recover.php");
					die;
				}
				
		}else{
				$_SESSION['recEmailErr'] = "Email is Invalid";
				header("Location:pages/recover.php");
				die;
		}
	}



// ============================================================RECOVERY MESSAGE ==============================================









	if (isset($_POST['chengePass'])) {
		// $_SESSION['recPassID'] = $_GET['id'];
		if (!empty($_POST['updPass']) || !empty($_POST['ReUpdPass'])) {
			$pass = md5(mysqli_real_escape_string($conn,checkData($_POST['updPass'])));
			$rePass = md5(mysqli_real_escape_string($conn,checkData($_POST['ReUpdPass'])));
			unset($_SESSION['RecPassErr']);
			if ($pass===$rePass) {
				updateData($conn,'users',["password='$pass'"],"id=".$_SESSION['recPassID']);
				header("Location:index.php");
				die;
			}else{
				$_SESSION['RecPassErr'] = "Passwords do not match";
				header("Location:pages/resetPassword?id=".$_SESSION['recPassID']);
				die;
			}
		}else{
			$_SESSION['RecPassErr'] = "Complete the two fields";
			header("Location:pages/resetPassword?id=".$_SESSION['recPassID']);
			die;
			
		}
	}


?>