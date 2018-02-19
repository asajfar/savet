<!-- Preuzimanje naslova vesti u promenljivu $title -->
<?php
	$page = "savet"; 
	include_once '../cnews/cn_api.php';
	$entry = cn_api_get_entry();

	if ($entry['t']) 
	{
	     // ........
	     $header_title = $entry['t'];
	     $str = $entry['s'];
	     $rawdesc = $entry['f'];
	     
	function get_string_between($string, $start, $end){
	    $string = " ".$string;
	    $ini = strpos($string,$start);
	    if ($ini == 0) return "";
	    $ini += strlen($start);
	    $len = strpos($string,$end,$ini) - $ini;
	    return substr($string,$ini,$len);
	}

	function stripBBCode($text_to_search) {
	 $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
	 $replace = '';
	 return preg_replace($pattern, $replace, $text_to_search);
	}

	$rawdesc2 = stripBBCode($rawdesc);

	$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
	$replacement = "";
	$sdesc = preg_replace($pattern, $replacement, $rawdesc2);
	$fdesc = strip_tags($sdesc);

	$image = get_string_between($str, "[img]", "[/img]");


	      $title = "<title>".$header_title."</title>\n";
	      
	} else {
	      
	       $title = "<title>Vesti</title>\n";
	    }
 ?>

<!doctype html>


<html lang="sr" class="no-js">

<head>
	<!-- <title>Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada</title> -->
	<!-- Postavljanje title taga -->
	<?php echo $title ?>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/magnific-popup.css" media="screen">	
	<link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/icomoon.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/animate.css" media="screen">
    <!-- REVOLUTION BANNER CSS SETTINGS -->
	<link rel="stylesheet" type="text/css" href="css/settings.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">

	
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.migrate.js"></script>
	<script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="js/owl.carousel.min.js"></script>
	<script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
	<script type="text/javascript" src="js/jquery.appear.js"></script>
	<script type="text/javascript" src="js/jquery.countTo.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/jquery.imagesloaded.min.js"></script>
	
	<script type="text/javascript" src="js/plugins-scroll.js"></script>
	<script type="text/javascript" src="js/waypoint.min.js"></script>
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="js/jquery.themepunch.revolution.min.js"></script>
	<script type="text/javascript" src="js/jquery.mb.YTPlayer.js"></script>
	<link rel="stylesheet" type="text/css" href="css/YTPlayer.css" media="screen">
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/cyrlatconverter_ignore_list_rs.js"></script>
	<script type="text/javascript" src="js/cyrlatconverter.js"></script>

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
										<li><a href="#lat"><img src="images/flag/srb.png" alt=""><span>Latinica</span><i class="fa fa-angle-down"></i></a>
											<ul class="drop-languages">
												<li><a href="#cyr"><img src="images/flag/srb.png" alt=""><span>Ćirilica</span></a></li>
												<li><a href="#"><img src="images/flag/uk.png" alt=""><span>Engleski</span></a></li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<?php include 'include/logo-baner.php' ?>
				<?php include 'include/meni.php' ?>
			</nav>
		</header>
		<!-- End Header -->

		
		<!-- content 
			================================================== -->
		<div id="content">

			
			<!-- page-banner-section
				================================================== -->
			<div class="section-content page-banner-section">
				<div class="container">
					<!-- <h1>Vesti</h1> -->
					<ul>
						<li><a href="index.php">Naslovna</a></li>
						<li><a href="arhiva.php">Aktuelne vesti</a></li>
						<li><a style="color: #a21f1e;" href="#"><?php echo $header_title ?></a></li>
					</ul>
					<!-- <ul>
						<li><a href="#">Blog</a></li>
						<li><a href="single-post.html">Single Post</a></li>
					</ul> -->
				</div>
			</div>

			<!-- blog-section
				================================================== -->
			<div class="section-content blog-section blog-standard">
				<div class="container">
					<div class="blog-box">

						<div class="blog-post single-post">
							<div class="blog-content">
								<?php
								    $template = "savet1";
								    $QUERY_STRING = "$_GET('id')";
								    include("/home/uprava/public_html/sbsns.rs/cnews/show_news.php");
								?>				
							</div>

							<div class="social-tag-post">
								<div class="row">
									<div class="col-md-12">
										<div class="single-post-icons">
											<!-- Koriscen servis AddToAny BEGIN  -->
											<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
												<ul>
													<!-- <li><span>Podeli:</span></li> -->

													<li><a class="a2a_button_facebook" href="#"><i class="fa fa-facebook"></i></a></li>
													<li><a class="a2a_button_twitter" href="#"><i class="fa fa-twitter"></i></a></li>
													<!-- <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
													<li><a class="google" href="#"><i class="fa fa-google-plus"></i></a></li> -->
													<li><a class="a2a_button_linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
													<li><a class="a2a_button_google_gmail" href="#"><i class="fa fa-envelope"></i></a></li>
													<!-- <li><a class="pinterest" href="#"><i class="fa fa-pinterest"></i></a></li> -->
												</ul>
											</div>
											<script async src="https://static.addtoany.com/menu/page.js"></script>
											<!-- AddToAny END -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- End content -->


		<!-- footer 
			================================================== -->
		<?php include 'include/footer.php' ?>
		<!-- End footer -->
	</div>
	<!-- End Container -->
	
	

	<!-- SLIDER REVOLUTION SCRIPT INITIALISATION -->
	<!-- LOOK THE DOCUMENTATION FOR MORE INFORMATIONS -->
	<script type="text/javascript">

		var revapi;

		jQuery(document).ready(function() {

			   revapi = jQuery('.tp-banner').revolution(
				{
					delay:12000,
					startwidth:1140,
					startheight:480,
					hideThumbs:10,
					fullWidth:"on",
					forceFullWidth:"on",
					onHoverStop:"on",
					navigationType:"none",
					soloArrowLeftHOffset:30,
					soloArrowRightHOffset:30
				});

		});

	</script>
	<!-- END REVOLUTION SLIDER -->

	<!-- Skripta za aktivaciju linkova #lat i #cyr -->
	<script>
		$.CyrLatConverter({
		  permalink_hash : "on"
		});
	</script>
	
</body>

</html>