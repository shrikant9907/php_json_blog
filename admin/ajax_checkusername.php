<?php 
include 'functions.php';  

$cusername = $_POST['cusername']; 

$output = $user->get_user_by_username($cusername);
$usercount = count($output);
if($usercount>0) {
	echo '0'; 
} else { 
	echo '1';
}
