<?php 

	session_start();
	require_once 'class.user.php';

	$page = "uslovi";

	$uslov = new USER();

	if($uslov->is_logged_in()!="")
	{
		$$uslov->redirect('member-home.php');
	}


	
?>

<html lang="sr" class="no-js">

	<head>
		<title>Primedbe i pohvale - Uslovi korišćenja baze podataka</title>
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
		<div>
						
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
							<div class="col-md-12">
								<div style="text-align: justify;">
									<!-- Obican html popup prozor za prikaz uslova koriscenja -->
									
									    <h3>Uslovi korišćenja baze podataka!</h3>  
									    <p>Poštovani korisnici/ce, molimo vas da pre korišćenja naših usluga, pažljivo pročitate sledeće uslove. Svaka poseta ovom delu sajta, kao i ostavljanje vaših podataka, znači da ste ove uslove pročitali i da se slažete sa njima u celosti. Ukoliko su oni za vas neprihvatljivi, molimo vas da ne koristite ovu prezentaciju.</p>
									    <p>Dobrodošli na sajt sbsns.rs. Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada vam omogućava korišćenje usluga i sadržaja svog portala koje je podložno niže navedenim Uslovima korišćenja. Uslovi korišćenja se primenjuju na sve sadržaje i usluge sbsns.rs. Korišćenjem bilo kog dela portala, smatra se da su korisnici upoznati sa ovim uslovima, kao i da prihvataju korišćenje sadržaja ovog portala isključivo za ličnu upotrebu i na sopstvenu odgovornost.</p>
									    <h4>Opšte odredbe</h4>
									    <p>Sbsns.rs ima autorska prava na sve sadržaje (tekstualne, vizuelne i audio materijale, baze podataka, programerski kod). Neovlašćeno korišćenje bilo kog dela portala, bez dozvole vlasnika autorskih prava, smatra se kršenjem autorskih prava i podložno je tužbi. Savet administrira ovu lokaciju iz svojih kancelarija u Novom Sadu, Srbija. Ni na koji način ne izjavljuje da su materijali ili usluge na ovoj lokaciji prikladni ili dostupni za korišćenje izvan Srbije, a pristupanje iz područja gde je njihov sadržaj nezakonit je zabranjeno. Nije dopušteno korišćenje ili izvoz, odnosno uvoz, radi izvoza materijala ili usluga na ovoj lokaciji niti bilo koje kopiranje ili prilagođavanje u suprotnosti sa važećim zakonima ili propisima uključujući, bez ograničenja, izvozne zakone i propise Srbije. Ako odlučite da pristupite ovoj lokaciji izvan Srbije, to radite na sopstvenu inicijativu i smatrate se odgovornim za poštovanje važećih lokalnih zakona. Ovi Uslovi se tumače u skladu sa zakonima Republike Srbije i neće se primenjivati načela o rešavanju neusaglašenosti</p>
									    <p>Savet može revidirati ove Uslove bilo kada, ažuriranjem ovog dokumenta. Povremeno posećujte ovu stranicu da biste pregledali Uslove koji trenutno važe, zato što su oni za vas obavezujući. Određene odredbe ovih Uslova mogu se zameniti izričito navedenim pravnim obaveštenjima i uslovima dostupnim na određenim stranicama ove lokacije.</p>
									    <h4>Materijal koji prosleđuje korisnik (komentari i drugi sadržaji)</h4>
									    <p>Lični podaci koje prosledite sajtu sbsns.rs u svrhu dobijanja proizvoda ili usluga biće tretirane u skladu sa našim dokumentom o privatnosti na mreži. Zabranjeno je slanje ili prenošenje na ovu lokaciju ili sa nje bilo kojih nezakonitih, pretećih, uvredljivih, klevetničkih, opscenih, pornografskih ili drugih materijala koji su u suprotnosti s bilo kojim zakonom.</p>
									    <p>Savet na ovoj lokaciji ne želi od vas da prima poverljive ili druge informacije kojima ne može slobodno da raspolaže. Svi materijali, informacije ili druga saopštenja koja prenosite ili šaljete na ovu lokaciju neće se smatrati poverljivim i onima kojima se ne može slobodno raspolagati. Sbsns.rs nema nikakve obaveze prema ovim saopštenjima. Naši zaposleni mogu da kopiraju, otkrivaju, distribuiraju, primenjuju ili na drugi način koriste saopštenja i sve podatke, slike, zvukove, tekst i sve ostale materijale u njima sadržane za bilo koje odnosno za sve komercijalne i nekomercijalne svrhe.</p>
									    <p>Naravno, u ovu grupu podataka ne spadaju vaši lični podaci. Njih, u skladu sa našom Politikom privatnosti, koristimo samo za internu upotrebu, ne obelodanjujemo niti prosleđujemo trećim licima, već koristimo isključivo za potrebe obrade vaših predloga, sugestija i komentara.</p>
									    <h4>Veze ka drugim Web lokacijama</h4>
									    <p>Veze na ovoj lokaciji ka lokacijama samostalnih pružaoca usluga su obezbeđene isključivo da bi vam olakšale rad. Ako budete koristili ove veze, napustićete ovu lokaciju. Sbsns.rs nije pregledao sve ove lokacije samostalnih proizvođača i ne kontroliše ih i nije odgovoran za bilo koju od ovih lokacija ili njihov sadržaj. Samim tim, ne podržavamo i ne dajemo nikakve izjave o njima, kao ni o bilo kojim informacijama, softveru ili drugim proizvodima ili materijalima koji se tamo nalaze, ili bilo kojim rezultatima koji se mogu dobiti njihovim korišćenjem. Ako odlučite da pristupite nekoj od Web lokacija samostalnih pružaoca usluga koje su povezane sa ovom lokacijom, to radite isključivo na sopstveni rizik.</p>
									   <h4>Postavljanje informacija i komentara od strane posetilaca</h4>
									   <p>Savet se ne smatra odgovornim za sadržaj bilo kog od navedenih komentara, bez obzira proizilazi li ili ne iz zakona o autorskim pravima, kleveti, privatnosti, opscenosti ili drugog. Savet zadržava pravo da ukloni poruke koje sadrže materijal koji smatramo nepristojnim, klevetničkim, opscenim ili na bilo koji drugi način neprihvatljivim.</p>
								   
								</div>							
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End content -->
		</div>
		<!-- End Container -->
		
	</body>

	<!-- Skripta za aktivaciju linkova #lat i #cyr -->
	<script>
		$.CyrLatConverter({
		  permalink_hash : "on"
		});
	</script>

</html>