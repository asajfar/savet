<?php  ?>
<div class="bottom-menu">
	<div class="container">
		<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav navbar-left">
            <li class="drop"><a <?php if($page == 'naslovna'): ?> class="active"<?php endif ?> href="../index.php">Naslovna</a></li>                            
			<li class="drop"><a <?php if($page == 'savet'): ?> class="active"<?php endif ?> href="#">Savet</a>
				<ul class="drop-down">
                    <li><a href="../onama.php">O nama</a></li>
                    <li><a href="../arhiva.php">Vesti</a></li>
					<li><a href="../bezbednost.php">Bezbednost saobraćaja</a></li>
                    <li><a href="../sednice.php">Sednice saveta</a></li>
					<li><a href="../javne-nabavke.php">Javne nabavke</a></li>
					<li><a href="../kampanje.php">Kampanje</a></li>
					<li><a href="#">Najave događaja<i class="fa fa-angle-right"></i></a>
						<ul class="drop-down level3">
							<li><a href="../najave2017.php">2017. godina</a></li>
							<li><a href="../najave2016.php">2016. godina</a></li>
						</ul>
					</li>
					<li><a href="#">Međunarodna saradnja</a></li>
					<li><a href="../android.php">Android aplikacije</a></li>
				</ul>
			</li>
            <li class="drop"><a <?php if($page == 'zahtevi'): ?> class="active"<?php endif ?> href="../zahtevi.php">Zahtevi</a></li>
            <li class="drop"><a <?php if($page == 'odluke'): ?> class="active"<?php endif ?> href="../odluke.php">Gradske odluke i pravilnici</a></li>
            <li class="drop"><a <?php if($page == 'servis'): ?> class="active"<?php endif ?> href="../servis.php">Servisne informacije</a></li>
			<li class="drop"><a <?php if($page == 'primedbe'): ?> class="active"<?php endif ?> href="#">Pohvale/Primedbe</a>
			</li>
			<li class="drop"><a <?php if($page == 'kontakt'): ?> class="active"<?php endif ?> href="../kontakt.php">Kontakt</a></li>
			<!-- <li>
				<a href="#" class="open-search"><i class="icon-search2"></i></a>
				<form class="form-search">
					<div class="container">
						<input type="search" placeholder="Pretražite"/>
						<a href="#" class="close-search">x</a>
					</div>
				</form>
			</li> -->
		</ul>
	</div>
	</div>
</div>
<?php  ?>