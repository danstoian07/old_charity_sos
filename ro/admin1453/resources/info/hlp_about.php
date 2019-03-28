<?php
	session_start();    
	$ERROR     = false;
    $ERROR_MSG = '';
	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app-top.php');
	if ((isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
    	require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
    	//require_once('..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'functions.php');
    	//spl_autoload_register("autoload_backend_classes");
	} else {
		$ERROR = true; $ERROR_MSG = 'Eroare: Utilizator Nelogat';
	}	
	if (!$ERROR) {
?>
	<div class="row">
		<div class="col-md-6">
			<div class="ta_center">
				<img src="<?=__ADMINURL__?>resources/logo-big2.png" />
				<p><a target="_blank" href="<?=APP_WEBSITE?>"><?=APP_WEBSITE?></a></p>
			</div>
		</div>
		<div class="col-md-6">
			<h2><strong>CMS</strong> OWD</h2>
			<p class="mt5 mb5"><strong>Versiune 2.0</strong><br />CMS administrare website</p>
			<p class="mt5 mb5 fs12">Sistem de administrare continut website.</p>
			<!--<p class="mt5 mb5 fs12">Vrei mai multe detalii? <a target="_blank" href="<?=LINK_TO_HELP_BACKEND?>">Click aici</a></p>-->
		</div>	
	</div>
<?php
	}
?>