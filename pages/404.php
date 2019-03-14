<?php

	require_once ($_SERVER['DOCUMENT_ROOT']."/layouts/header.php");
	unset($_SESSION['wrong_sign']);
	if(isset($_SESSION['logged_user'])) {  // sra optimal dzev@ ???
		header("Location:profile.php");
		die;
	}


?>
	<section>
		<h4>Error 404 Page not Found  :( <a href="<?= ROOT_URL ?>">GO BACK</a></h4>
	<div class="errContainer">
		<img class="move first" src="../assets/img/error_page/6.png">
	</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="../assets/js/script.js"></script>
</body>
</html>
