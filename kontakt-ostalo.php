<?php 
session_start();

if(isset($_POST['user']) && trim($_POST['user']) != '') {
    die ();
}

function getRealIp() {
   if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
     $ip=$_SERVER['HTTP_CLIENT_IP'];
   } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
     $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
   } else {
     $ip=$_SERVER['REMOTE_ADDR'];
   }
   return $ip;
}

function writeLog($where) {
    
	$ip = getRealIp(); // Get the IP from superglobal
	$host = gethostbyaddr($ip);    // Try to locate the host of the attack
	$date = date("d M Y");
	
	// create a logging message with php heredoc syntax
	$logging = <<<LOG
		\n
		<< Start of Message >>
		There was a hacking attempt on your form. \n 
		Date of Attack: {$date}
		IP-Adress: {$ip} \n
		Host of Attacker: {$host}
		Point of Attack: {$where}
		<< End of Message >>
LOG;
// Awkward but LOG must be flush left
    
        // open log file
		if($handle = fopen('hacklog.log', 'a')) {
		
			fputs($handle, $logging);  // write the Data to file
			fclose($handle);           // close the file
			
		} else {  // if first method is not working, for example because of wrong file permissions, email the data
		
			$to = 'asajfar@gmail.com';  
        	$subject = 'HACK ATTEMPT';
        	$header = 'From: ADMIN-OSTALO@sbsns.rs';
        	if (mail($to, $subject, $logging, $header)) {
        		echo "Sent notice to admin.";
        	}

		}
    }

    function verifyFormToken($form) {
        
        // check if a session is started and a token is transmitted, if not return an error
    	if(!isset($_SESSION[$form.'_token'])) { 
    		return false;
        }
    	
    	// check if the form is sent with token in it
    	if(!isset($_POST['token'])) {
    		return false;
        }
    	
    	// compare the tokens against each other if they are still the same
    	if ($_SESSION[$form.'_token'] !== $_POST['token']) {
    		return false;
        }
    	
    	return true;
    }

    function generateFormToken($form) {
    
        // generate a token from an unique value, took from microtime, you can also use salt-values, other crypting methods...
    	$token = md5(uniqid(microtime(), true));  
    	
    	// Write the generated token to the session variable to check it against the hidden field when the form is sent
    	$_SESSION[$form.'_token'] = $token; 
    	
    	return $token;
    }

    // VERIFY LEGITIMACY OF TOKEN
    if (verifyFormToken('form1')) {
    
        // CHECK TO SEE IF THIS IS A MAIL POST
        if (isset($_POST['mail'])) {
        
            // Building a whitelist array with keys which will send through the form, no others would be accepted later on
            $whitelist = array('token','kategorija','name','mail','comment','date','submit');
            
            // Building an array with the $_POST-superglobal 
            foreach ($_POST as $key=>$item) {
                    
                    // Check if the value $key (fieldname from $_POST) can be found in the whitelisting array, if not, die with a short message to the hacker
            		if (!in_array($key, $whitelist)) {
            			
            			writeLog('Unknown form fields');
            			die("Hack-Attempt detected. Please use only the fields in the form");
            			
            		}
            }			
			
			
			//  MAKE SURE THE "FROM" EMAIL ADDRESS DOESN'T HAVE ANY NASTY STUFF IN IT
			
			$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i"; 
            if (preg_match($pattern, trim(strip_tags($_POST['mail'])))) { 
                $cleanedFrom = trim(strip_tags($_POST['mail'])); 
            } else { 
                return "The email address you entered was invalid. Please try again!"; 
            } 
		      
        }
    } else {
    
   		if (!isset($_SESSION[$form.'_token'])) {
   		
   		} else {
   			echo "Hack-Attempt detected. Got ya!.";
   			writeLog('Formtoken');
   	    }
   
   	}


	// provera podataka iz forme i njihovo slanje na odredjenu adresu

	// define variables and set to empty values
	$nameErr = $mailErr = $commentErr = "";
	$name = $mail = $comment = "";
	$kategorija = $_POST["kategorija"];

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  if (empty($_POST["name"])) {
	    $nameErr = "<span class='error-red'>:: Unos imena je obavezan ::</span>";
	  } else {
	    $name = test_input($_POST["name"]);
	    // check if name only contains letters and whitespace
	    if (!preg_match('/^\p{L}[\p{L} .-]+$/u',$name)) {
	      $nameErr = "<span class='error-red'>:: Dozvoljen je unos samo slova i razmaka ::</span>"; 
	    }
	  }
	  
	  if (empty($_POST["mail"])) {
	    $mailErr = "<span class='error-red'>:: Unos je obavezan ::</span>";
	  } else {
	    $mail = test_input($_POST["mail"]);
	    // check if e-mail address is well-formed
	    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
	      $mailErr = "<span class='error-red'>:: Pogrešan format ::</span>"; 
	    } else {
	    	if (strpos($mail, 'mail.ru') !== false || strpos($mail, 'yandex') !== false || strpos($mail, 'mail.ua') !== false) {
	    		$mailErr = "<span class='error-red'>:: Nedozvoljena adresa  ::</span>"; 	
	    	}
	    }
	  }
	    
	  if (empty($_POST["comment"])) {
	    $comment = "";
	  } else {
	    $comment = test_input($_POST["comment"]);
	  }

	  // zabrana da u polju komentari postoji http linkovi
	  if (preg_match("/http/i", "$comment")) {
	  	$commentErr = "------ Uneli ste nedozvoljene podatke!"; 
	  }
		
	  $trn_date = date("Y-m-d H:i:s");

	  if ($nameErr !== "" || $mailErr !== "" || $commentErr !== "") {

		$message = "Vaša poruka nije poslata. Pokušajte ponovo sa ispravnim podacima.";

		} else {

		$message = "Vaša poruka je uspešno poslata. Hvala Vam na Vašem interesovanju za naš rad.";
		
		//Slanje podataka na mail

		 //Email information
		  $admin_email = "asajfar@gmail.com";
		  $subject = $kategorija;


		  # MAIL BODY
		 
		  $body .= "Datum poruke " . date("d.m.Y.") . " \n";
		  $body .= "Ime i prezime: ". $name ." \n";
		  $body .= "Email: ". $mail ." \n";
		  $body .= "Poruka: ". $comment ." \n";
		  

		  $headers = "From: administrator@sbsns.rs";
								  
		  //send email
		  mail($admin_email, $subject, $body, $headers);
		  mail($admin_email, $subject, $poruka, $headers);

		}

	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

?>

<?php
	$page = "primedbe";
	// generate a new token for the $_SESSION superglobal and put them in a hidden field
	$newToken = generateFormToken('form1');   
?>

<!doctype html>


<html lang="sr" class="no-js">

<head>
	<title>Pohvale i primedbe - Ostalo - Savet za koordinaciju poslova bezbednosti saobraćaja na putevima na teritoriji Grada Novog Sada</title>
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
	<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCz80zpFoj9YDreX6S52NdTo9SHdoDfYt8&sensor=false&extension=.js'></script>
	<script type="text/javascript" src="js/cyrlatconverter_ignore_list_rs.js"></script>
	<script type="text/javascript" src="js/cyrlatconverter.js"></script>
	<script type="text/javascript" src="js/jquery.jqtransform.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/jquery.form.js"></script>
	
	<script type="text/javascript" src="js/websitechange.js"></script>

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
			

			<!-- contact-section
				================================================== -->
			<div class="section-content contact-section">
				<div class="container">
					<div class="row">
						<div class="col-md-9">
							<form id="contact-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>#contact-form" method="POST">
								<h1>Ostalo</h1>
								<h2 id="ostalo">Pošaljite pohvalu/primedbu</h2>
								<p>Ovde možete poslati poruku ukoliko vaše pitanje, pohvala ili primedba ne spada u sledeće oblasti: <br> <a href="kontakt-put.php">PUTNA INFRASTRUKTURA</a>, <a href="kontakt-prevoz.php">JAVNI PREVOZ</a>, <a href="kontakt-parking.php">
								PARKING</a> ili <a href="kontakt-biciklisti.php">BICIKLISTIČKI SAOBRAĆAJ</a>.</p>
								<div class="row">
									<input type="hidden" name="token" value="<?php echo $newToken; ?>">
									<input type="hidden" name="kategorija" value="OSTALO-NOVO-TEST">
									<div id="fooDiv">
										<label for="user"></label>
										<input type="text" name="user" id="user">
									</div>
									<script>
									(function () {
									    var e = document.getElementById("fooDiv");
									    e.parentNode.removeChild(e);
									})();
									</script>
									<div class="col-md-6">
										<input name="name" id="name" type="text" placeholder="Име/Ime" required>
										<span class="error">*Obavezno polje <?php echo $nameErr;?></span>
									</div>
									<div class="col-md-6">
										<input name="mail" id="mail" type="text" placeholder="Имејл/Email" required>
										<span class="error">*Obavezno polje <?php echo $mailErr;?></span>
									</div>
								</div>
								<textarea name="comment" id="comment" placeholder="Порука/Poruka" required></textarea>
								<span class="error">*Obavezno polje <?php echo $commentErr;?></span>
								<div class="submit-area">
									<input type="submit" name="submit" value="Пошаљите поруку / Pošaljite poruku">
									<?php 
										if ($message != "") { ?>
											<div id="msg" class="message"><?php echo $message ?></div>
										<?php }?>
									
																	
								</div>
							</form>	
						</div>
						<div class="col-md-3">
							<div class="contact-information primpoh">
								<h2>Kontakt informacije</h2>
								<ul class="information-list">
									<li><i class="fa fa-map-marker"></i><span>Žarka Zrenjanina 2 <br> 21000 Novi Sad, Srbija</span></li>
									<li><i class="fa fa-phone"></i><span> +381-(0)21-529-721</span><span>+381-(0)21-4882-835</span></li>
									<li><i class="fa fa-envelope-o"></i><a class="CyrLatIgnore" href="#">office@sbsns.rs</a></li>
								</ul>
								<ul class="social-list">
									<li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
								</ul>
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
	
</body>


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