<?php 

	session_start();
	require_once 'class.user.php';

	$user_home = new USER();

	if(!$user_home->is_logged_in())
	{
		$user_home->redirect('clanstvo.php');
	}

	// Uskladjivanje vremenske zone sa bazom
	date_default_timezone_set('Europe/Belgrade');
	// $settimezone = $user_home->runQuery("SET SESSION time_zone = '+2:00'");
	// $settimezone->execute();


	$stmt = $user_home->runQuery("SELECT * FROM tbl_members WHERE memberID=:uid");
	$stmt->execute(array(":uid"=>$_SESSION['memberSession']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if(isset($_POST['komentar-submit']))
	{
		$memberID = $row['memberID'];
		$oblast = trim($_POST['oblast']);
		$komentar = trim($_POST['komentar']);		
		$date = date("Y-m-d H:i:s");
		$email = $row['memberEmail'];
		$ime = $row['memberName'];
		$prezime = $row['memberLastname'];

		if($user_home->komentar($memberID,$oblast,$komentar,$date))
		{
			$message = "     
		    Poštovani/a $ime $prezime,
		    <br /><br />
		    Na našem sajtu www.sbsns.rs poslali ste komentar sledeće sadržine:<br /><br />
		    ------------------------------------------------------------------------<br />
		    $komentar<br />
		    ------------------------------------------------------------------------<br /><br />
		    Hvala Vam na Vašem predlogu, želimo Vam prijatan ostatak dana.<br /><br />
		    
		    Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada<br />
		    Žarka Zrenjanina 2<br />
		    21000 Novi Sad<br />
		    021/529-721<br />
		    021/4882-835<br />
		    <a href='http://www.sbsns.rs'>www.sbsns.rs</a>";

		    $subject = "Potvrda o slanju komentara";

		    $user_home->send_mail($email,$message,$subject);

		    $poruka = "Uspešno ste poslali komentar! Na Vašu email adresu smo poslali potvrdu o uspešnom slanju komentara.";
		    header("Location: member-home.php?poslato=$poruka");

		    $poruka_komentar = "
		    <div class='alert alert-success'>
		    <!-- <button class='close' data-dismiss='alert'>&times;</button> -->			    
		    <strong>Uspešno ste poslali komentar!</strong>  Na Vašu email adresu <span class='CyrLatIgnore'>$email</span> smo poslali potvrdu o uspešnom slanju komentara.
		    </div>
		    ";

		   

		}
		else
		{
			echo "Izvinjavamo se , upit nije moguće izvršiti...";
		}
	}

	if(isset($_POST['podaci-promena-submit']))
	{
		$memberID = $row['memberID'];
		$fname = trim($_POST['ime']);
		$lname = trim($_POST['prezime']);		
		$location = trim($_POST['deograda']);
		$street = trim($_POST['ulica']);
		$mobile = trim($_POST['mobilni']);
		$email = $row['memberEmail'];
		$ime = $row['memberName'];
		$prezime = $row['memberLastname'];

		if($user_home->podaci($memberID,$fname,$lname,$location,$street,$mobile))
		{
			$message = "     
		    Poštovani/a $fname $lname,
		    <br /><br />
		    Uspešno ste promenili vaše podatke u bazi:<br /><br />
		    ------------------------------------------------------------------------<br />
		    Ime i prezime: $fname $lname<br />
		    Deo grada u kojem živite: $location<br />
		    Ulica: $street <br />
		    Mobilni: $mobile <br />
		    Prijavljeni email: $email <br />
		    ------------------------------------------------------------------------<br /><br />
		    Želimo Vam prijatan ostatak dana,<br /><br />
		    
		    Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada<br />
		    Žarka Zrenjanina 2<br />
		    21000 Novi Sad<br />
		    021/529-721<br />
		    021/4882-835<br />
		    <a href='http://www.sbsns.rs'>www.sbsns.rs</a>";

		    $subject = "Potvrda o promeni podataka u bazi podataka";

		    $user_home->send_mail($email,$message,$subject);

		    $poruka = "Uspešno ste promenili Vaše podatke! Na Vašu email adresu smo poslali potvrdu o promeni.";
		    header("Location: member-home.php?podaci=$poruka");

		    $poruka_komentar = "
		    <div class='alert alert-success'>
		    <!-- <button class='close' data-dismiss='alert'>&times;</button> -->			    
		    <strong>Uspešno ste poslali komentar!</strong>  Na Vašu email adresu <span class='CyrLatIgnore'>$email</span> smo poslali potvrdu o uspešnom slanju komentara.
		    </div>
		    ";

		   

		}
		else
		{
			echo "Izvinjavamo se , upit nije moguće izvršiti...";
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
				<div class="container-full member-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="welcome">
									<h4><?php echo $row['memberName']; ?> <?php echo $row['memberLastname']; ?></h4>
									<h6>Dobrodošli na Vašu stranicu!</h6>																	
								</div>
								<div class="logout">
									<a href="logout.php" class="button-logout" target="_blank">Odjavi se</a>								
								</div>							
							</div>
						</div>		
					</div>								
				</div>
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
					<div class="member-box">
						<div class="row">
							<div class="col-md-6">
								<div class="komentar triggerAnimation animated fadeInLeft" data-animate="fadeInLeft">
									<h3>Pošaljite<span class="naglasi"> komentar</span></h3>
									<p>Poštovani/a,</p>
									<p>Na ovoj stranici možete nam uputiti određene primedbe, pohvale, sugestije ili predloge koji se tiču bezbednosti saobraćaja na teritoriji Grada Novog Sada.</p>
									<p>Na ovaj način ćete doprineti boljem dononošenju budućih odluka koje se tiču bezbednosti saobraćaja u Vašem gradu.</p>
								</div>
								<div class="member-forma triggerAnimation animated fadeInUp" data-animate="fadeInUp">
						            <form id="contact-form" method="POST">
										<div class="row">
											<input type="hidden" name="kategorija" value="SLANJE KOMENTARA">
											<div class="col-md-12">
												<select name="oblast" id="oblast" class="register-input">
													<option value="Nije odabrana oblast">Odaberite oblast...</option>
													<option value="Javni prevoz">Javni prevoz</option>
													<option value="Parking">Parking</option>
													<option value="Biciklistički saobraćaj">Biciklistički saobraćaj</option>
													<option value="Ostalo">Ostalo</option>
						                        </select> 
											</div>
											<div class="col-md-12">
												<label for="komentar" class="required"></label>
												<textarea name="komentar" id="komentar" placeholder="Коментар / Komentar" class="register-input" rows="30" required=""></textarea>
											</div>												
										</div>
										<div class="submit-area">
											<input type="submit" name="komentar-submit" value="Пошаљи коментар / Pošalji komentar" style="float: none; width: 100%;" class="register-input">
											<?php if(isset($_GET['poslato'])) echo "<div class='alert alert-success'>" . $_GET['poslato'] . "</div>"; ?>
											<p class="mali-tekst">Da biste se uspešno registrovali i kreirali novi korisnički nalog potrebno je uneti obavezna polja označena zvezdicom (<span style="color: #e41819;">*</span>)</p>													
										</div>
									</form>
								</div>
							</div>
							<div class="col-md-6">
								<div class="podaci1 triggerAnimation animated fadeInLeft" data-animate="fadeInLeft">
									<div class="podaci1-1">
									<img src="../images/member/profile.png" alt="member icon">
										<p>
											<span class="CyrLatIgnore podaci1-2 profil-mail"><?php echo $row['memberEmail']; ?></span><br>
											Ime i prezime: <span class="podaci1-2"><?php echo $row['memberName']; ?> <?php echo $row['memberLastname']; ?></span><br>
											Deo grada: <span class="podaci1-2"><?php echo $row['memberLocation']; ?></span><br>
											Adresa: <span class="podaci1-2"><?php echo $row['memberStreet']; ?></span><br>
											Mobilni: <span class="podaci1-2"><?php echo $row['memberMobile']; ?></span>
										</p>
									</div>
									
								</div>
								<div class="podaci2 triggerAnimation animated fadeInLeft" data-animate="fadeInLeft">
									<h3>Promenite<span class="naglasi blue"> Vaše podatke</span></h3>
									<p>Ovde možete promeniti vaše podatke koje ste nam ostavili prilikom registracije.</p>
									<p>Ažurnim podacima obezbeđujete da naša obaveštenja, promocije i određene usluge stižu na pravu adresu.</p>
								</div>
								<div class="member-forma triggerAnimation animated fadeInUp" data-animate="fadeInUp">
						            <form id="contact-form" method="POST">
										<div class="row">
											<input type="hidden" name="kategorija" value="IZMENA PODATAKA ČLANA">
											<div class="col-md-12">
												<label class="member-label-form" for="ime">Ime:</label>
												<input name="ime" id="ime" type="text" placeholder="<?php echo $row['memberName']; ?>" value="<?php echo $row['memberName']; ?>" class="register-input">
											</div>
											<div class="col-md-12">
												<label class="member-label-form" for="prezime">Prezime:</label>
												<input name="prezime" id="prezime" type="text" placeholder="<?php echo $row['memberLastname']; ?>" value="<?php echo $row['memberLastname']; ?>" class="register-input">
											</div>
											<div class="col-md-12">
												<label class="member-label-form" for="deograda">Deo grada u kojem živite:</label>											
												<select name="deograda" id="deograda" value="<?php echo $row['memberLocation']; ?>" class="register-input">
													<option value="<?php echo $row['memberLocation']; ?>"><?php echo $row['memberLocation']; ?></option>
													<option value="Ne živim na teritoji Grada Novog Sada">Ne živim na teritoriji Grada Novog Sada</option>
						                            <option value="Avijatičarsko naselje">Avijatičarsko naselje</option>
						                            <option value="Adamovićevo naselje">Adamovićevo naselje</option>
						                            <option value="Adice">Adice</option>
						                            <option value="Banatić">Banatić</option>
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
												<label class="member-label-form" for="ulica">Adresa:</label>
												<input name="ulica" id="ulica" type="text" placeholder="<?php echo $row['memberStreet']; ?>" value="<?php echo $row['memberStreet']; ?>" class="register-input">
											</div>
											<div class="col-md-12">
												<label class="member-label-form" for="mobilni">Broj mobilnog telefona:</label>
												<input name="mobilni" id="mobilni" type="text" placeholder="<?php echo $row['memberMobile']; ?>" value="<?php echo $row['memberMobile']; ?>" class="register-input">
											</div>				
										</div>
										<div class="submit-area">
											<input type="submit" id="blue-button" name="podaci-promena-submit" value="Промени податке / Promeni podatke" style="float: none; width: 100%;" class="register-input">
											<?php if(isset($_GET['podaci'])) echo "<div class='alert alert-success'>" . $_GET['podaci'] . "</div>"; ?>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="komentar">
								
							</div>
							
						</div>
						<div class="col-md-6">
							<div class="podaci_update">
								
							</div>	
						</div>
					</div>
				</div>
			</div>
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




