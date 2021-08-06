<?php
	/*
		This website is free, enjoy! 
		
		Template author: https://startbootstrap.com/theme/freelancer
		Modified by https://adapools.org
		
		Just modify "my_pool_id" and all data should be fetched via adapools API. Of course you can modify whatever you want.
		
		Compatible with most webhostings, requires only PHP5+
	*/
	//-----------------

	$my_pool_id = "6ab1fd13a4e182f731ecf356ce3e145311f43cd512be2579ba3572e9"; // here your pool id, thats all; not bech32 id, on adapools pool detail page is mentioned as second
	
	//------------------
	
	function adanice($n) {
		if($n > 1000000 * 1000 * 1000)
			return round($n/(1000000 * 1000 * 1000),2)."M";
		elseif($n > 1000000 * 1000)
			return round($n/(1000000 * 1000),2)."k";
		else
			return round($n/1000000);
	}

	$a = json_decode(file_get_contents("https://js.adapools.org/pools/{$my_pool_id}/summary.json", false, stream_context_create(array('http'=>array('timeout' => 5)))),true); $a = $a['data'];

?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="<?php echo $a['db_description']; ?>" />
        <title><?php echo "{$a['db_name']} - [{$a['db_ticker']}]"; ?></title>
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top"><?php echo $a['db_name']; ?></a>
                <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#pool">Pool</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#stats">Stats</a></li>
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">About Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead bg-primary text-white text-center" id="pool">
            <div class="container d-flex align-items-center flex-column">
                <!-- Masthead Avatar Image-->
                <img class="masthead-avatar mb-5" src="assets/img/avataaars.svg" alt="" />
                <!-- Masthead Heading-->
                <h1 class="masthead-heading text-uppercase mb-0"><?php echo $a['db_name']; ?></h1>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Masthead Subheading-->
                <p class="masthead-subheading font-weight-light mb-0"><?php echo $a['db_description']; ?></p>
                
                <p class="mt-3 small">
					Pool ID: <a href="https://adapools.org/pool/<?php echo $a['pool_id']; ?>?utm_source=poolweb" class="text-white" target="_blank"><?php echo $a['pool_id_bech32']; ?></a><br />
					(old format: <?php echo $a['pool_id']; ?>)
				</p>
                
            </div>
        </header>

        <section class="page-section bg-primary text-white mb-0" id="stats">
            <div class="container">
                <!-- About Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-white">Live Stats [<?php echo $a['db_ticker']; ?>]</h2>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- About Section Content-->
                <?php
					$l = array(
						array("Live Stake", adanice($a['total_stake'])." ADA"),
						array("Epoch Blocks", $a['blocks_epoch']),				
						array("Lifetime Blocks", $a['blocks_epoch']+$a['blocks_lifetime']),				
						array("Delegators", $a['delegators']),
						array("Saturation", round($a['saturated']*100)."%")					
					);
					
					$r = array(
						array("Active Stake", adanice($a['active_stake'])." ADA"),
						array("Return of ADA", round($a['roa_lifetime'],2)."%"),
						array("Pledge", adanice($a['pledge'])." ADA"),
						array("Costs - Fixed",adanice($a['tax_fix'])." ADA"),
						array("Costs - Margin",round($a['tax_ratio']*100,2)."%")
					);
				?>

				<div class="row">
					<div class="col-12 col-md-6 mb-4">
					<?php
						for($i=0;$i<count($l);$i++) {
							echo "<div class=\"d-flex justify-content-between align-items-center mb-3\"><span>{$l[$i][0]}:</span><b>{$l[$i][1]}</b></div>";
						}
					?>
					</div>
					<div class="col-12 col-md-6 mb-4">
					<?php

						for($i=0;$i<count($r);$i++) {
							echo "<div class=\"d-flex justify-content-between align-items-center mb-3\"><span>{$r[$i][0]}:</span><b>{$r[$i][1]}</b></div>";
						}
					?>
					</div>
				</div>
                
                <div class="text-center mt-4">
                    <a class="btn btn-xl btn-outline-light" href="https://adapools.org/pool/<?php echo $a['pool_id']; ?>?utm_source=poolweb" target="_blank">
                        <i class="fas fa-question-circle mr-2"></i>
                        <?php echo $a['db_ticker']; ?> on ADApools.org
                    </a>
                </div>
            </div>
        </section>
        <!-- Contact Section-->
        <section class="page-section" id="about">
            <div class="container">
                <!-- Contact Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">About Us</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- Contact Section Form-->
                <div class="row">
					<p class="lead"><?php echo $a['db_description']; ?></p>
                    <div class="col-lg-8 mx-auto text-center">
                    <?php
						if($a['handles']['tw'])
							echo "<a class=\"btn btn-outline-dark btn-social mx-1\" href=\"https://twitter.com/{$a['handles']['tw']}\" target=\"_blank\"><i class=\"fab fa-fw fa-twitter\"></i></a>";
						if($a['handles']['tg'])
							echo "<a class=\"btn btn-outline-dark btn-social mx-1\" href=\"https://t.me/{$a['handles']['tg']}\" target=\"_blank\"><i class=\"fab fa-fw fa-telegram\"></i></a>";
						if($a['handles']['yt'])
							echo "<a class=\"btn btn-outline-dark btn-social mx-1\" href=\"https://www.youtube.com/{$a['handles']['yt']}\" target=\"_blank\"><i class=\"fab fa-fw fa-youtube\"></i></a>";	
						if($a['handles']['fb'])
							echo "<a class=\"btn btn-outline-dark btn-social mx-1\" href=\"https://fb.me/{$a['handles']['fb']}\" target=\"_blank\"><i class=\"fab fa-fw fa-facebook\"></i></a>";	
						if($a['handles']['yt'])
							echo "<a class=\"btn btn-outline-dark btn-social mx-1\" href=\"https://discord.gg/{$a['handles']['di']}\" target=\"_blank\"><i class=\"fas fa-fw fa-server\"></i></a>";															
					?>
                    </div>
                </div>
            </div>
        </section>

        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright © <?php echo $a['db_name']; ?></small></div>
        </div>
        <div class="scroll-to-top d-lg-none position-fixed">
            <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>