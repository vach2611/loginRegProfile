<?php 
	$host = "localhost";
	$username = "loginreg_vach";
	$password = "loginreg";
	$db = "loginreg_vach";

	$conn = mysqli_connect($host,$username,$password,$db);

	function getData($conn,$table,$what="*",$where=""){
		$data = mysqli_query($conn,"SELECT $what FROM $table ".$where);
		$data = mysqli_fetch_all($data,MYSQLI_ASSOC);
		return $data;
	}

	function addData($conn,$table,$data){
		$string_data = implode(",", $data);
		mysqli_query($conn,"INSERT INTO $table VALUES($string_data)");
		return mysqli_insert_id($conn);
		
	}


	function updateData($conn,$table,$data,$where){
		$string_data = implode(",", $data);
		mysqli_query($conn,"UPDATE $table SET $string_data WHERE $where");		
	}

	function deleteData($conn,$table,$id){
		mysqli_query($conn,"DELETE FROM $table WHERE id=$id");
	}


?>