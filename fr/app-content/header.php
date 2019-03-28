<?php
	$query = "
	SELECT el_articles.* 
	FROM el_articles 
	WHERE el_articles.id_archive=50 ORDER BY display_index ASC, date_add DESC";
	$result = $oDB->db_query($query);
	$str_footer_news = '';
	$str_fp_news     = '';
	$str_articles    = '';
	$delay = 3; 
	$contor=0;
	while ($result_line = $oDB->db_fetch_array($result)) {
		$contor++;
		$lnk = $this->return_link_to_article($result_line['slug'], $result_line['redirect_to']);
		if ($contor<=2) {			
			$str_footer_news .= '
				  <article class="post media-post clearfix pb-0 mb-10">
					<a href="'.$lnk.'" class="post-thumb"><img alt="" src="'.FE_CropImage($result_line['featured_image'], 80, 55).'"></a>
					<div class="post-right">
					  <h5 class="post-title mt-0 mb-5"><a href="'.$lnk.'">'.$result_line['name'].'</a></h5>
					  <p class="post-date mb-0 font-12">Association SOS Umanitar</p>
					</div>
				  </article>'.PHP_EOL;
				  
			$str_fp_news .= '
				<div class="col-xs-12 col-sm-6 col-md-4 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.'.$delay.'s">
				  <article class="post clearfix bg-lighter mb-sm-30">
					<div class="entry-header">
					  <div class="post-thumb thumb"> 
						<img src="'.FE_CropImage($result_line['featured_image'], 540, 370).'" alt="" class="img-responsive img-fullwidth">
					  </div>
					</div>
					<div class="entry-content p-20">
					  <h4 class="entry-title text-white text-uppercase"><a class="font-weight-600" href="blog-single-left-sidebar.html">'.$result_line['name'].'</a></h4>
					  <div class="entry-meta">
						<ul class="list-inline font-12 mb-10">
						  <li><i class="fa fa-user text-theme-colored mr-5"></i>Autor: - / </li>
						  <li><i class="fa fa-calendar text-theme-colored mr-5"></i> Article  </li>                      
						</ul>
					  </div>
					  <p class="mt-5">'.el_TruncateString(strip_tags($result_line['description']), 80).'</p>
					  <a class="btn btn-theme-colored btn-sm mt-10" href="'.$lnk.'"> Afla detalii</a>
					</div>
				  </article>
				</div>'.PHP_EOL;
			$delay++;
		}
		$str_articles .= '
            <div class="col-sm-6 col-md-4 col-lg-4">
              <div class="schedule-box maxwidth500 bg-lighter mb-30">
                <div class="thumb">
                  <img class="img-fullwidth" alt="" src="'.FE_CropImage($result_line['featured_image'], 470, 320).'">
                </div>
                <div class="schedule-details clearfix p-15 pt-10">
                  <div class="text-center pull-left flip bg-theme-colored p-10 pt-5 pb-5 mr-10">
                    <ul>
                      <li class="font-19 text-white font-weight-600 border-bottom ">&#936;</li>
                      <li class="font-12 text-white text-uppercase"><i class="fa fa-file-text-o"></i></li>
                    </ul>
                  </div>
                  <h4 class="title mt-0"><a href="'.$lnk.'">'.$result_line['name'].'</a></h4>
                  <ul class="list-inline font-11 text-gray">
                    <li><i class="fa fa-user mr-5"></i> Autor: CALIN MAGDA</li>
                    <li><i class="fa fa-map-marker mr-5"></i> Articole` psihologie</li>
                  </ul>
                  <div class="clearfix"></div>
                  <p class="mt-10">'.el_TruncateString(strip_tags($result_line['description']), 147).'</p>
                  <div class="mt-10">
                   <!--<a class="btn btn-dark btn-theme-colored btn-sm mt-10" href="#">Register</a>-->
                   <a href="'.$lnk.'" class="btn btn-dark btn-sm mt-10">Afla detalii</a>
                  </div>
                </div>
              </div>
            </div>'.PHP_EOL;
	}

?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<!-- Page Title -->
<title><?=$this->meta_title?></title>
<?=(!empty($this->meta_description) ? '<meta name="description" content="'.$this->meta_description.'" />' : '').PHP_EOL?>
<?=(!empty($this->meta_keywords) ? '<meta name="keywords" content="'.$this->meta_keywords.'">' : '').PHP_EOL?>

<?=(!empty($this->og_title) ? '<meta property="og:title" content="'.$this->og_title.'" />' : '').PHP_EOL?>
<?=(!empty($this->og_description) ? '<meta property="og:description" content="'.$this->og_description.'"/> ' : '').PHP_EOL?>	  
<?php if (!empty($this->og_image)) { ?>
  <meta property="og:image" content="<?=$this->og_image?>" />
  <meta property="og:image:width" content="<?=$this->og_width?>" />
  <meta property="og:image:height" content="<?=$this->og_height?>" />	  	  
<?php } ?>
<?=(!empty($this->og_locale) ? '<meta property="og:locale" content="'.$this->og_locale.'" />' : '').PHP_EOL?>
<meta property="og:type" content="article" />
<meta property="og:url" content="<?=el_curent_url()?>" />
<meta name="google-site-verification" content="k40_Zj33hklUnIJk0s6KEsIPwyt6sIgHx_XcO0bFxJY" />

<!-- Favicon and Touch Icons -->
<link href="<?=__APPFILESURL__?>images/favicon.png" rel="shortcut icon" type="image/png">
<link href="<?=__APPFILESURL__?>images/apple-touch-icon.png" rel="apple-touch-icon">
<link href="<?=__APPFILESURL__?>images/apple-touch-icon-72x72.png" rel="apple-touch-icon" sizes="72x72">
<link href="<?=__APPFILESURL__?>images/apple-touch-icon-114x114.png" rel="apple-touch-icon" sizes="114x114">
<link href="<?=__APPFILESURL__?>images/apple-touch-icon-144x144.png" rel="apple-touch-icon" sizes="144x144">

<!-- Stylesheet -->
<link href="<?=__APPFILESURL__?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?=__APPFILESURL__?>css/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="<?=__APPFILESURL__?>css/animate.css" rel="stylesheet" type="text/css">
<link href="<?=__APPFILESURL__?>css/css-plugin-collections.css" rel="stylesheet"/>
<!-- CSS | menuzord megamenu skins -->
<link id="menuzord-menu-skins" href="<?=__APPFILESURL__?>css/menuzord-skins/menuzord-rounded-boxed.css" rel="stylesheet"/>
<!-- CSS | Main style file -->
<link href="<?=__APPFILESURL__?>css/style-main.css" rel="stylesheet" type="text/css">
<!-- CSS | Preloader Styles -->
<link href="<?=__APPFILESURL__?>css/preloader.css" rel="stylesheet" type="text/css">
<!-- CSS | Custom Margin Padding Collection -->
<link href="<?=__APPFILESURL__?>css/custom-bootstrap-margin-padding.css" rel="stylesheet" type="text/css">
<!-- CSS | Responsive media queries -->
<link href="<?=__APPFILESURL__?>css/responsive.css" rel="stylesheet" type="text/css">
<!-- CSS | Style css. This is the file where you can place your own custom css code. Just uncomment it and use it. -->
<link href="<?=__APPFILESURL__?>css/style.css" rel="stylesheet" type="text/css">

<!-- Revolution Slider 5.x CSS settings -->
<link  href="<?=__APPFILESURL__?>js/revolution-slider/css/settings.css" rel="stylesheet" type="text/css"/>
<link  href="<?=__APPFILESURL__?>js/revolution-slider/css/layers.css" rel="stylesheet" type="text/css"/>
<link  href="<?=__APPFILESURL__?>js/revolution-slider/css/navigation.css" rel="stylesheet" type="text/css"/>

<!-- CSS | Theme Color -->
<link href="<?=__APPFILESURL__?>css/colors/theme-skin-red.css" rel="stylesheet" type="text/css">

<!-- external javascripts -->
<script src="<?=__APPFILESURL__?>js/jquery-2.2.4.min.js"></script>
<script src="<?=__APPFILESURL__?>js/jquery-ui.min.js"></script>
<script src="<?=__APPFILESURL__?>js/bootstrap.min.js"></script>
<!-- JS | jquery plugin collection for this theme -->
<script src="<?=__APPFILESURL__?>js/jquery-plugin-collection.js"></script>

<!-- Revolution Slider 5.x SCRIPTS -->
<script src="<?=__APPFILESURL__?>js/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
<script src="<?=__APPFILESURL__?>js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="">
<div id="wrapper" class="clearfix">
  <!-- preloader -->
  <!--
  <div id="preloader">
    <div id="spinner">
      <img class="floating ml-5" src="<?=__APPFILESURL__?>images/preloaders/13.png" alt="">
      <h5 class="line-height-50 font-18">Chargement...</h5>
    </div>
    <div id="disable-preloader" class="btn btn-default btn-sm">Dezactiveaza Preloader</div>
  </div>
  -->
  <!-- Header -->
  <header id="header" class="header">
    <div class="header-top bg-black-333 sm-text-center border-top-theme-color-3px p-0">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="widget no-border m-0">
              <ul class="styled-icons icon-dark icon-flat icon-sm sm-text-center mt-sm-15">
				<li><a style="width:auto !important;" href="<?=__URL__EN__?>"><img src="<?=__APPFILESURL__?>images/flag_en.svg" style="width:20px;"> English</a></li>				
				<li><a style="width:auto !important;" href="<?=__URL__FR__?>"><img src="<?=__APPFILESURL__?>images/flag_fr.svg" style="width:20px;"> Francais</a></li>
				<li><a style="width:auto !important;" href="<?=__URL__RO__?>"><img src="<?=__APPFILESURL__?>images/flag_ro.svg" style="width:20px;"> Româna</a></li>
				<!--
                <li><a href="#"><i class="fa fa-facebook text-white"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter text-white"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus text-white"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram text-white"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin text-white"></i></a></li>
				-->
              </ul>
            </div>
          </div>
          <div class="col-md-6 pr-0">
            <div class="widget no-border">
              <ul class="list-inline pull-right flip sm-pull-none xs-text-center text-white mt-5">
                <li class="m-0 pl-10 pr-10"> <a href="#" class="text-white"><i class="fa fa-phone text-theme-colored"></i> <?=$this->settings['company_phone']?></a> </li>
                <!--<li class="m-0 pl-10 pr-10"> <i class="fa fa-clock-o text-theme-colored"></i> Luni-Vineri 9:00 to 19:00 </li>-->
                <li class="m-0 pl-10 pr-10"> 
                  <a href="#" class="text-white"><i class="fa fa-envelope-o text-theme-colored"></i> <?=el_ret_safety_email($this->settings['company_email'],'','header_email');?></a> 
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-2">
            <a class="btn btn-colored btn-flat btn-theme-colored pb-10" href="<?=$this->return_link_to_doneaza()?>"><strong class="white">FAITES UN DON</strong></a>
          </div>
        </div>
      </div>
    </div>
    <div class="header-nav">
      <div class="header-nav-wrapper navbar-scrolltofixed bg-white">
        <div class="container">
          <nav id="menuzord-right" class="menuzord default">
            <a class="menuzord-brand pull-left flip xs-pull-center mt-20" href="<?=__URL__?>">
              <img src="<?=__APPFILESURL__?>images/logo-wide2.png" alt="Servicii traduceri in Milano">
            </a>
            <ul class="menuzord-menu">
				<?php require('generate/menu_main.php'); ?>
			</ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
