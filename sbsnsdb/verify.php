<?php 

	require_once 'class.user.php';
	$user = new USER();

	if(empty($_GET['id']) && empty($_GET['code']))
	{
		$user->redirect('clanstvo.php');
	}

	if(isset($_GET['id']) && isset($_GET['code']))
	{
		$id = base64_decode($_GET['id']);
		$code = $_GET['code'];

		$statusY = "Y";
		$statusN = "N";

		$stmt = $user->runQuery("SELECT memberID,memberStatus FROM tbl_members WHERE memberID=:uID AND tokenCode=:code LIMIT 1");
		$stmt->execute(array(":uID"=>$id,":code"=>$code));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() > 0)
		{
			if($row['memberStatus']==$statusN)
			{
				$stmt = $user->runQuery("UPDATE tbl_members SET memberStatus=:status WHERE memberID=:uID");
				$stmt->bindparam(":status",$statusY);
				$stmt->bindparam(":uID",$id);
				$stmt->execute();

				$msg = "
	            <div class='alert alert-success'>
	       			<button class='close' data-dismiss='alert'>&times;</button>
	       			<strong>HVALA VAM ŠTO STE SE REGISTROVALI!</strong></br>
	       			<br></br>
	       			Vaš nalog je aktiviran: <a href='clanstvo.php'>PRIJAVITE SE OVDE</a>
	          	</div>
	          	";
			}
			else
			{
				$msg = "
			    <div class='alert alert-error'>
			       	<button class='close' data-dismiss='alert'>&times;</button>
			       	<strong>ŽAO NAM JE,
	       			<br></br>
	       			</strong>ali Vaš nalog je već aktiviran: <a href='clanstvo.php'>PRIJAVITE SE OVDE</a>
			    </div>
			    ";
			}
		}
		else
		{
			$msg = "
         	<div class='alert alert-error'>
			    <button class='close' data-dismiss='alert'>&times;</button>
			    <strong>ŽAO NAM JE!</strong>
	       		<br></br>
	       		Nije pronađen vaš nalog. Molimo Vas da se ponovo registrujete: <a href='clanstvo.php#registracija'>REGISTRACIJA</a>
		    </div>
		    ";
		}
	}
?>

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
								<div class="confirmation-msg"><?php if(isset($msg)) { echo $msg; } ?></div>							
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End content -->


			<!-- footer 
				================================================== -->
			<?php include '../include/footer-db.php' ?>
			<!-- End footer -->
		</div>
		<!-- End Container -->
		
	</body>


	<script>	  
		    var dialog = document.getElementById('window');  
		    document.getElementById('prikazi-uslove').onclick = function() {  
		        $("html, body").animate({ scrollTop: 0 }, 500);
		        dialog.show(); 
		    };  
		    document.getElementById('exit').onclick = function() {  
		        dialog.close();  
		    }; 
	</script>

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