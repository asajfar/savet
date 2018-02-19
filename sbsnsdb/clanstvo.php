<?php 
	session_start();
	require_once 'class.user.php';

	$page = "primedbe";

	$reg_member = new USER();

	$user_login = new USER();

	$user_forgot = new USER();

	
	if($user_forgot->is_logged_in()!="")
	{
		$user_forgot->redirect('member-home.php');
	}

	if(isset($_POST['submit-obnova']))
	{
		$email = $_POST['mail-obnova'];
		$stmt = $user_forgot->runQuery("SELECT memberID FROM tbl_members WHERE memberEmail=:email LIMIT 1");
		$stmt->execute(array(":email"=>$email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($stmt->rowCount() == 1)
		{
			$id = base64_encode($row['memberID']);
			$code = md5(uniqid(rand()));

			$stmt = $user_forgot->runQuery("UPDATE tbl_members SET tokenCode=:token WHERE memberEmail=:email");
			$stmt->execute(array(":token"=>$code,"email"=>$email));

			$message= "
		       Poštovani $email korisniče,
		       <br /><br />
		       Primili smo zahtev da želite da obnovite Vašu lozinku. Da biste to uradili kliknite na sledeći link radi obnove lozinke, a ako ne želite ignorišite ovu poruku,
		       <br /><br />
		       Kliknite na ovaj link da obnovite Vašu lozinku: 
		       <br /><br />
		       <a href='http://www.sbsns.rs/sr/sbsnsdb/resetpass.php?id=$id&code=$code'>KLIKNITE OVDE.</a>
		       <br /><br />
		       Hvala :)
		       ";

		    $subject = "Obnova lozinke";

		    $user_forgot->send_mail($email,$message,$subject);

		    $msg_obnova_clanstvo = "<div class='alert alert-success'>
				     	Na Vašu email adresu <span class='CyrLatIgnore'>$email</span> poslali smo Vam link za obnovu lozinke.
			    		Kliknite na njega kako bi obnovili Vašu lozinku. 
				    </div>";

		}
		else
		{
			$msg_obnova_clanstvo = "<div class='alert alert-danger'>
				    <strong>Izvinjavamo se,</strong>  ova email adresa nije pronađena.. 
				    </div>";
		}
	}





	if($user_login->is_logged_in()!="")
	{
		$user_login->redirect('member-home.php');
	}


	if(isset($_POST['login-submit']))
	{
		$email = trim($_POST['login-email']);
 		$upass = trim($_POST['login-password']);
 		if($_POST["remember_me"]=='1' || $_POST["remember_me"]=='on')
        {
        $hour = time() + 3600 * 24 * 30;
        setcookie('email', $email, $hour);
        setcookie('password', $upass, $hour);
        }

 		if($user_login->login($email,$upass))
 		{
 			if($_POST["remember_me"]=='1' || $_POST["remember_me"]=='on')
	        {
	        $hour = time() + 3600 * 24 * 30;
	        setcookie('email', $email, $hour);
	        setcookie('password', $upass, $hour);
	        }
 			$_SESSION['email'] = $email;
    		$_SESSION['password'] = $upass;
 			$user_login->redirect('member-home.php');
 		}
	}



	if($reg_member->is_logged_in()!="")
	{
	 $reg_member->redirect('member-home.php');
	}

	if(isset($_POST['register-submit']))
	{
		$fname = trim($_POST['ime']);
		$lname = trim($_POST['prezime']);
		$location = trim($_POST['deograda']);
		$street = trim($_POST['ulica']);
		$mobile = trim($_POST['mobilni']);
		$uname = trim($_POST['korisnicko-ime']);
		$email = trim($_POST['mail-registracija']);
		$upass = trim($_POST['korisnicka-lozinka']);
		$code = md5(uniqid(rand()));

		$stmt = $reg_member->runQuery("SELECT * FROM tbl_members WHERE memberEmail=:email_id");
		$stmt->execute(array(":email_id"=>$email));
		$memberRow=$stmt->fetch(PDO::FETCH_ASSOC);

		if($stmt->rowCount() > 0)
		{
			$msg = "
        	<div class='alert alert-error'>
        	<!-- <button class='close' data-dismiss='alert'>&times;</button> -->    		
     		<strong>Žao nam je,</strong>  ali ova email adresa već postoji u našoj bazi! Molimo vas da pokušate sa nekom drugom adresom.
     		</div>
     		";
		}
		else
		{
			if($reg_member->register($fname,$lname,$location,$street,$mobile,$email,$uname,$upass,$code))
			{
				$id = $reg_member->lastID();
				$key = base64_encode($id);
				$id = $key;

				$message = "     
			    Poštovani/a $uname,
			    <br /><br />
			    Na našem sajtu www.sbsns.rs započeli ste proces registracije i prijavljivanja na našu bazu podataka.<br/>
			    Kako bi kompletirali ovaj proces molimo Vas da kliknete na sledeći link:<br/>
			    <br /><br />
			    <a href='http://www.sbsns.rs/sr/sbsnsdb/verify.php?id=$id&code=$code'>Kliknite OVDE za aktivaciju :)</a>
			    <br /><br />
			    Hvala,<br />
			    Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada";

			    $subject = "Potvrda registracije";

			    $reg_member->send_mail($email,$message,$subject);

			    $msg = "
			    <div class='alert alert-success'>
			    <!-- <button class='close' data-dismiss='alert'>&times;</button> -->			    
			    <strong>Uspešno ste poslali svoje podatke!</strong>  Na Vašu email adresu <span class='CyrLatIgnore'>$email</span> smo vam poslali konfirmacioni link za potvrdu registracije.
			    Kliknite na njega kako bi kreirali vaš nalog. 
			    </div>
			    ";
			}
			else
			{
				echo "Izvinjavamo se, upit nije moguće izvršiti...";
			}
		}
	}
?>



<!doctype html>


<html lang="sr" class="no-js">

<head>
	<title>Primedbe i pohvale - Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada</title>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../css/magnific-popup.css" media="screen">	
	<link rel="stylesheet" type="text/css" href="../css/jquery.bxslider.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../css/owl.carousel.css" media="screen">
    <link rel="stylesheet" type="text/css" href="../css/owl.theme.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../css/icomoon.css" media="screen">
	<link rel="stylesheet" type="text/css" href="../css/animate.css" media="screen">
    <!-- REVOLUTION BANNER CSS SETTINGS -->
	<link rel="stylesheet" type="text/css" href="../css/settings.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen">

	
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/jquery.migrate.js"></script>
	<script type="text/javascript" src="../js/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="../js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="../js/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="../js/jquery.appear.js"></script>
	<script type="text/javascript" src="../js/jquery.countTo.js"></script>
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	<script type="text/javascript" src="../js/jquery.imagesloaded.min.js"></script>
	
	<script type="text/javascript" src="../js/plugins-scroll.js"></script>
	<script type="text/javascript" src="../js/waypoint.min.js"></script>
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="../js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="../js/jquery.themepunch.revolution.min.js"></script>
	<script type="text/javascript" src="../js/jquery.mb.YTPlayer.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/YTPlayer.css" media="screen">
	<script type="text/javascript" src="../js/script.js"></script>
	<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCz80zpFoj9YDreX6S52NdTo9SHdoDfYt8&sensor=false&extension=.js'></script>
	<script type="text/javascript" src="../js/cyrlatconverter_ignore_list_rs.js"></script>
	<script type="text/javascript" src="../js/cyrlatconverter.js"></script>
	<style>
		.gm-style-iw * {
		    display: block;
		    width: 350px;
		    overflow: hidden;
		}
		.gm-style-iw h4, .gm-style-iw p {
		    margin: 0;
		    padding: 0;
		}
		.gm-style-iw a {
		    color: #4272db;
		}
	</style>

</head>
<body class="CyrLatConvert">

	<!-- Preloader--> <!-- Ako ukinemo preloader moramo dodati klasu active koji ima id container --> 
	<div class="preloader">
		<!-- <h2>Savet za bezbednost saobraćaja</h2>
		<h3>Novi Sad</h3> -->
	</div>

	<!-- Container -->
	<div id="container" class="header3">
		<header class="clearfix">
			<!-- Static navbar -->
			<nav class="navbar navbar-default navbar-fixed-top">
				<div class="header-top-line">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-sm-7">
								<span><i class="icon-phone"></i> +381-(0)21-529-721</span>
								<span><i class="icon-phone"></i> +381-(0)21-4882-835</span>
								<span class="CyrLatIgnore"><i class="icon-envelope"></i> office@sbsns.rs</span>
							</div>
							<div class="col-md-6 col-sm-5">
								<div class="flags-section">
									<ul class="language-choose">
										<li><a href="#lat"><img src="../images/flag/srb.png" alt=""><span>Latinica</span><i class="fa fa-angle-down"></i></a>
											<ul class="drop-languages">
												<li><a href="#cyr"><img src="../images/flag/srb.png" alt=""><span>Ćirilica</span></a></li>
												<li><a href="#"><img src="../images/flag/uk.png" alt=""><span>Engleski</span></a></li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<?php include '../include/logo-baner-db.php' ?>
				<?php include '../include/meni-db.php' ?>
			</nav>
		</header>
		<!-- End Header -->

		
		<!-- content 
			================================================== -->
		<div id="content" class="grey-page-background">

			
			<!-- page-banner-section
				================================================== -->
			

			<!-- contact-section
				================================================== -->
			<div class="section-content contact-section">
				<div class="container">
					<div class="row">
						<div class="col-md-9 col-md-offset-1">
							
							<div class="bs-example bs-example-tabs clearfix" data-example-id="togglable-tabs">
							    <ul class="register-nav register-nav-tabs" id="myTabs" role="tablist">
							        <li role="presentation" class="active" style="width: 33%;"><a href="#prijava" id="prijava-tab" role="tab" data-toggle="tab" aria-controls="prijava" aria-expanded="true" >Prijava</a>
							        </li>
							        <li role="presentation" class="" style="width: 33%;"><a href="#registracija" role="tab" id="registracija-tab" data-toggle="tab" aria-controls="registracija" aria-expanded="false">Registracija</a>
							        </li>
							        <li role="presentation" class="" style="width: 34%;"><a href="#lozinka" role="tab" id="lozinka-tab" data-toggle="tab" aria-controls="lozinka" aria-expanded="false" >Zaboravili ste lozinku?</a>
							        </li>							    
							    </ul>
							    <div class="tab-content" id="myTabContent">
							        <div class="tab-pane fade active in" role="tabpanel" id="prijava" aria-labelledby="prijava-tab">
							            <div class="forma">
								            <form id="contact-form" method="POST">
												<div class="row">
													<?php 
														if(isset($_GET['inactive']))
														{
													?>
														<div class='alert alert-error login-margin'>
															<button class='close' data-dismiss='alert'>&times;</button>
															<strong>Žao nam je!</strong><br>Ovaj nalog nije aktiviran, pogledajte svoj email i aktivirajte ga. 
														</div>
													<?php
														}
													?>
													<?php
													    if(isset($_GET['error']))
													  	{
													?>
													    <div class='alert alert-error login-margin'>
													    	<button class='close' data-dismiss='alert'>&times;</button>
													    	<strong>Pogrešno uneti podaci!</strong><br>Pokušajte ponovo.
													   </div>
													<?php
														}
													?>
													<input type="hidden" name="kategorija" value="PRIJAVA ČLANA">
													<div class="col-md-12">
														<!-- <input name="login-username" id="korisnicko-ime" type="text" placeholder="Корисничко име / Korisničko ime" class="register-input" required> -->
														<input name="login-email" id="login-email" type="text" placeholder="Имејл / Email" class="register-input" required>
													</div>
													<div class="col-md-12">
														<input name="login-password" id="korisnicka-lozinka" type="password" placeholder="Лозинка / Lozinka" class="register-input" required>
													</div>
													<div class="col-md-12 checkbox">
														<label class="zapamti-form"><input type="checkbox" name="remember"> &nbsp;Zapamti me</label>
													</div>
												</div>
												<div class="submit-area">
													<input type="submit" name="login-submit" value="Пријава / Prijava" style="float: none; width: 100%;" class="register-input">													
												</div>
											</form>
										</div>
										<div class="tekst-forma">
											<h1>Prijavite se</h1>
											<h2>Učestvujte sa nama u donošenju odluka</h2>
											<p>Prijavite se na vaš nalog koristeći podatke koje ste nam ostavili prilikom registracije. Nakon prijave bićete u mogućnosti da nam sa vaše lične stranice pošaljete komentar, predlog, primedbu ili sugestiju. Hvala.</p>
											<p class="mali-tekst">Zaboravili ste lozinku? <a href="#lozinka" data-toggle="tab">Pošaljite zahtev za novu</a></p>
											<p class="mali-tekst">Niste registrovani? <a href="#registracija" data-toggle="tab">Kreirajte nalog</a></p>
										</div>
							        </div>
							        <div class="tab-pane fade" role="tabpanel" id="registracija" aria-labelledby="registracija-tab">
							            <div class="forma">
								            <form id="contact-form" method="POST">
												<div class="row">
													<input type="hidden" name="kategorija" value="REGISTRACIJA ČLANA">
													<div class="col-md-12">
														<label for="ime" class="required"></label>
														<input name="ime" id="ime" type="text" placeholder="Име / Ime" class="register-input" required>
													</div>												
													<div class="col-md-12">
													<label for="prezime" class="required"></label>
														<input name="prezime" id="prezime" type="text" placeholder="Презиме / Prezime" class="register-input" required>
													</div>
													<div class="col-md-12">
														<select name="deograda" id="deograda" class="register-input">
															<option value="Nije odgovoreno">Deo grada u kojem živite...</option>
															<option value="Ne živim na teritoji Grada Novog Sada">Ne živim na teritoriji Grada Novog Sada</option>
								                            <option value="Avijatičarsko naselje">Avijatičarsko naselje</option>
								                            <option value="Adamovićevo naselje">Adamovićevo naselje</option>
								                            <option value="Adice">Adice</option>
								                            <option value="Banatić">Banatić</option>
								                            <option value="Betanija">Betanija</option>
								                            <option value="Veternička rampa">Veternička rampa</option>
								                            <option value="Grbavica">Grbavica</option>
								                            <option value="Detelinara">Detelinara</option>
								                            <option value="Industrijska zona sever-jug">Industrijska zona sever-jug</option>
								                            <option value="Jugovićevo">Jugovićevo</option>
								                            <option value="Kamenjar">Kamenjar</option>
								                            <option value="Klisa / Veliki rit">Klisa / Veliki rit</option>
								                            <option value="Klisa / Vidovdansko naselje">Klisa / Vidovdansko naselje</option>
								                            <option value="Klisa / Gornje livade">Klisa / Gornje livade</option>
								                            <option value="KLisa / Deponija">KLisa / Deponija</option>
								                            <option value="Klisa / Mali Beograd">Klisa / Mali Beograd</option>
								                            <option value="Klisa / Rimski šančevi">Klisa / Rimski šančevi</option>
								                            <option value="Klisa / Slana bara">Klisa / Slana bara</option>
								                            <option value="Liman 1">Liman 1</option>
								                            <option value="Liman 2">Liman 2</option>
								                            <option value="Liman 3">Liman 3</option>
								                            <option value="Liman 4">Liman 4</option>
								                            <option value="Novo Naselje (Bistrica)">Novo Naselje (Bistrica)</option>
								                            <option value="Podbara">Podbara</option>
								                            <option value="Radna zona sever 4">Radna zona sever 4</option>
								                            <option value="Ribarsko ostrvo">Ribarsko ostrvo</option>
								                            <option value="Rotkvarija (Žitni trg)">Rotkvarija (Žitni trg)</option>
								                            <option value="Sajlovo">Sajlovo</option>
								                            <option value="Sajmište">Sajmište</option>
								                            <option value="Salajka (Slavija)">Salajka (Slavija)</option>
								                            <option value="Satelit">Satelit</option>
								                            <option value="Stari grad (Centar)">Stari grad (Centar)</option>
								                            <option value="Telep">Telep</option>
								                            <option value="Šangaj">Šangaj</option>
								                            <option value="Futog">Futog</option>
								                            <option value="Begeč">Begeč</option>
								                            <option value="Veternik">Veternik</option>
								                            <option value="Petrovaradin / Bukovački plato">Petrovaradin / Bukovački plato</option>
								                            <option value="Petrovaradin / Vezirac">Petrovaradin / Vezirac</option>
								                            <option value="Petrovaradin / Karagača">Petrovaradin / Karagača</option>
								                            <option value="Petrovaradin / Petrovaradinska ada">Petrovaradin / Petrovaradinska ada</option>								                  
								                            <option value="Petrovaradin / Radna zona istok">Petrovaradin / Radna zona istok</option>
								                            <option value="Petrovaradin / Ribnjak">Petrovaradin / Ribnjak</option>
								                            <option value="Petrovaradin / Sadovi">Petrovaradin / Sadovi</option>
								                            <option value="Petrovaradin / Stari deo">Petrovaradin / Stari deo</option>
								                            <option value="Petrovaradin / Stari-Novi Majur">Petrovaradin / Stari-Novi Majur</option>
								                            <option value="Petrovaradin / Trandžament">Petrovaradin / Trandžament</option>								                            
								                            <option value="Petrovaradin / Širine">Petrovaradin / Širine</option>
								                            <option value="Petrovaradin / Široka Dolina">Petrovaradin / Široka Dolina</option>
								                            <option value="Sremska Kamenica / Alibegovac">Sremska Kamenica / Alibegovac</option>
								                            <option value="Sremska Kamenica / Bocke">Sremska Kamenica / Bocke</option>
								                            <option value="Sremska Kamenica / Mišeluk i Tatarsko brdo">Sremska Kamenica / Mišeluk i Tatarsko brdo</option>
								                            <option value="Sremska Kamenica / Paragovo">Sremska Kamenica / Paragovo</option>
								                            <option value="Sremska Kamenica / Popovica">Sremska Kamenica / Popovica</option>
								                            <option value="Sremska Kamenica / Staroiriški put">Sremska Kamenica / Staroiriški put</option>
								                            <option value="Sremska Kamenica / Čardak">Sremska Kamenica / Čardak</option>
								                        </select> 
													</div>
													<div class="col-md-12">
														<input name="ulica" id="ulica" type="text" placeholder="Улица и број / Ulica i broj" class="register-input">
													</div>
													<div class="col-md-12">
														<input name="mobilni" id="mobilni" type="text" placeholder="Број моб. телефона / Broj mob. telefona" class="register-input">
													</div>
													<div class="col-md-12">
														<label for="mail-registracija" class="required"></label>
														<input name="mail-registracija" id="mail-registracija" type="email" placeholder="Имејл / Email" class="register-input" required>
													</div>
													<div class="col-md-12">
														<label for="korisnicko-ime" class="required"></label>
														<input name="korisnicko-ime" id="korisnicko-ime" type="text" placeholder="Корисничко име / Korisničko ime" class="register-input" required>
													</div>
													<div class="col-md-12">
														<label for="korisnicka-lozinka" class="required"></label>
														<input name="korisnicka-lozinka" id="korisnicka-lozinka" type="password" placeholder="Лозинка / Lozinka" class="register-input" required>
													</div>
													<div class="col-md-12 checkbox">
														<label class="zapamti-form"><input type="checkbox" name="uslovi" required> &nbsp;Prihvatam <a href="uslovi.php" target="_blank" >uslove korišćenja*</a></label>
													</div>
												</div>
												<div class="submit-area">
													<input type="submit" name="register-submit" value="Регистрација / Registracija" style="float: none; width: 100%;" class="register-input">
													<?php if(isset($msg)) echo $msg;  ?>												
													<p class="mali-tekst">Da biste se uspešno registrovali i kreirali novi korisnički nalog potrebno je uneti obavezna polja označena zvezdicom (<span style="color: #e41819;">*</span>)</p>													
												</div>
											</form>
										</div>
										<div class="tekst-forma">
											<h1>Registrujte se</h1>
											<h2>Učestvujte sa nama u donošenju odluka</h2>
											<p>Da biste postali naš član, neophodno je da se registrujete kao korisnik. Nakon što registrujete svoje korisničko ime i lozinku, potrebno je da se prijavite na sistem i imaćete mogućnost da na Vašoj stranici "Moj portal" uputite određene primedbe, pohvale, sugestije ili predloge koji se tiču bezbednosti saobraćaja na teritoriji Grada Novog Sada.</p>
											<p>Pored toga što ćete na ovaj način doprineti boljem dononošenju budućih odluka koje se tiču bezbednosti saobraćaja u Vašem gradu, na Vašem portalu smo za Vas odvojili dokumente koji će biti dostupni samo registrovanim korisnicima.</p>
											<p>Isto tako na vašu mejl adresu će stizati obaveštenja o našim novim aktivnostima, planiranim događajima, obukama, itd.</p>
											<p>Registracija je besplatna i pruža vam mogućnost da po potrebi menjate ili dopunite svoje podatke, i budete stalno u kontaktu sa Savetom za koordinaciju bezbednosti saoraćaja na teritoriji Grada Novog Sada.</p>
											<p>Ukoliko imate tehničkih problema prilikom registracije ili prijave na sistem, molimo vas da kontaktirate našu tehničku podršku putem adrese <a class="CyrLatIgnore" href="#">podrska@sbsns.rs</a></p>
										</div>
							        </div>
							        <div class="tab-pane fade" role="tabpanel" id="lozinka" aria-labelledby="lozinka-tab">
							            <div class="forma">
								            <form id="contact-form" novalidate action="" method="POST">
												<div class="row">
													<input type="hidden" name="kategorija" value="OBNOVA LOZINKE">
													<div class="col-md-12">
														<input name="mail-obnova" id="mail-obnova" type="email" placeholder="Имејл / Email" class="register-input" required>
													</div>
												</div>
												<div class="submit-area">
													<input type="submit" name="submit-obnova" value="Обнови лозинку / Obnovi lozinku" style="float: none; width: 100%;" class="register-input">
													<?php if(isset($msg_obnova_clanstvo)) echo $msg_obnova_clanstvo;  ?>													
												</div>
											</form>
										</div>
										<div class="tekst-forma">
											<h1>Obnovite Vašu lozinku</h1>
											<p>Ukoliko ste zaboravili Vašu lozinku i želite da Vam je pošaljemo na Vašu imejl adresu, upišite je u navedeno polje i poslaćemo Vam je za nekoliko trenutaka.</p>
										</div>
							        </div>							       
							    </div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Prikazivanje modal popup prozora prilikom registracije sa obavestenjem i otranje taba registracija -->
			<?php if(isset($msg))
			{ ?>
				<div class="modal fade" id="myModal">
			    <div class="modal-body-moj">
			        <p><?php echo $msg ?></p>
			    </div>
			    <div class="modal-footer-moj">
			        <a href="#registracija" data-toggle="tab" class="close btn" data-dismiss="modal">X</a>
			    </div>
			</div>

			<script type="text/javascript">
			    $(window).load(function () {
			        $('#myModal').modal('show');
			    });
			</script>
			<?php } ?>
		<!-- End content -->

		<!-- Prikazivanje modal popup prozora prilikom registracije sa obavestenjem i otvaranje taba prijava -->
			<?php if(isset($msg_obnova_clanstvo))
			{ ?>
				<div class="modal fade" id="myModal">
			    <div class="modal-body-moj">
			        <p><?php echo $msg_obnova_clanstvo ?></p>
			    </div>
			    <div class="modal-footer-moj">
			        <a href="#lozinka" data-toggle="tab" class="close btn" data-dismiss="modal">X</a>
			    </div>
			</div>

			<script type="text/javascript">
			    $(window).load(function () {
			        $('#myModal').modal('show');
			    });
			</script>
			<?php } ?>
		<!-- End content -->


		<!-- footer 
			================================================== -->
		<?php include '../include/footer-db.php' ?>
		<!-- End footer -->
	</div>
	<!-- End Container -->
	
</body>


<!-- Skripta da se sa linka u tekstu otvori drugi tab i pokaze kao aktivan -->
<script>
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	    var target = this.href.split('#');
	    $('.register-nav a').filter('a[href="#'+target[1]+'"]').tab('show');
	})
</script>

<!-- Skripta za aktivaciju i prikazivanje taba sa druge stranice na sajtu -->
<script>
	$(document).ready(function(){

	  if(window.location.hash != "") {
	      $('a[href="' + window.location.hash + '"]').click()
	  }

	});
</script>


<!-- Skripta koja pomera za odredjeni broj pixela pozicioniranje iznad anchora -->
<script>
// The function actually applying the offset
function offsetAnchor() {
    if(location.hash.length !== 0) {
        window.scrollTo(window.scrollX, window.scrollY - 300);
    }
}

// This will capture hash changes while on the page
window.addEventListener("hashchange", offsetAnchor);

// This is here so that when you enter the page with a hash,
// it can provide the offset in that case too. Having a timeout
// seems necessary to allow the browser to jump to the anchor first.
window.setTimeout(offsetAnchor, 1); // The delay of 1 is arbitrary and may not always work right (although it did in my testing).
</script>


<!-- Skripta za aktivaciju linkova #lat i #cyr -->
<script>
	$.CyrLatConverter({
	  permalink_hash : "on"
	});
</script>

</html>