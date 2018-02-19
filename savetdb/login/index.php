<?php

session_start();
require_once 'class.user.php';

$admin_login = new USER();

if($admin_login->is_logged_in_admin()!="")
{
 	$admin_login->redirect('../panel/index.php');
}

if(isset($_POST['ulazak']))
{
	$korisnik = trim($_POST['korisnickoIme']);
	$lozinka = trim($_POST['korisnickaLozinka']);
	$pin = trim($_POST['korisnickiPin']);

	if($admin_login->loginadmin($korisnik,$lozinka,$pin))
	{
		$admin_login->redirect('../panel/index.php');
	}
}



?>

<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>SBSNS - Baza podataka</title>
	<meta name="robots" content="noindex">
	<meta name="googlebot" content="index" />
	<meta name="robots" content="nofollow" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
 
	<link rel="stylesheet" href="css/style.css">

</head>

<body>
	<div class="wrapper">
		<div class="naslov">
			<p>Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada</p>
		</div>
		<div class="container">
			<h1>Dobrodošli</h1>
			
			<form class="form" method="POST">
				<input type="text" name="korisnickoIme" placeholder="Korisničko ime">
				<input type="password" name="korisnickaLozinka" placeholder="Lozinka">
				<input type="password" name="korisnickiPin" placeholder="Pin">
				<button type="submit" name="ulazak" id="login-button">Ulazak</button>
			</form>
		</div>
		<?php
        if(isset($_GET['error']))
		{
		?>
		    <div class='naslov'>
		    <p><strong>Pogrešni podaci! Pokušajte ponovo.</strong></p> 
		   	</div>
		<?php
		}
		?>
		
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<!-- <script src="js/index.js"></script> -->

</body>
</html>
