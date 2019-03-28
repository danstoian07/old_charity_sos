<?php
	$archive_rights = $this->parent->GetUserRightsOfArchive('calendar', $this->parent->user_rights_by_admin);
	$calendar_type = $this->parent->calendar['type'];
	if ($archive_rights['administrator']!=1) {
		if (isset($archive_rights['permission_view_all_company_calendar'])) {
			if ($archive_rights['permission_view_all_company_calendar']==0) {
				// nu vede decat propriile dosare
				$calendar_type =0;
			}
		} else {
			// nu vede decat propriile dosare
			$calendar_type =0;
		}
	}
	//print_r($this->parent->calendar['rights']);die('');
	/*
	$calendar_type = $this->parent->calendar['type'];
	if ($this->parent->calendar['rights']['administrator']!=1) {
		if ((isset($this->parent->calendar['rights']['calendar']) && ($this->parent->calendar['rights']['calendar']==1)) {
			
		}
	}
		*/
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title><?=APP_ADM_NAME?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <!--<meta content="" name="description" />
        <meta content="" name="author" />-->
        <!-- BEGIN GLOBAL MANDATORY STYLES -->		
        <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />-->
		
        <link href="<?=__THEMEURL__?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
		
        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
		
		<link rel="stylesheet" href="<?=__UTILSAPP__?>jquery-minicolors-master/jquery.minicolors.css">

		<link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />

        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css" />
        
        
		<link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
		<link href="<?=__THEMEURL__?>assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
		
		
        <link href="<?=__THEMEURL__?>assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />

        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />        
		<link href="<?=__THEMEURL__?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        
		
        <link href="<?=__THEMEURL__?>assets/global/css/<?=$this->parent->ThemeStyleCssFile()?>" rel="stylesheet" id="style_components" type="text/css" />
		<link href="<?=__THEMEURL__?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
		
		
        <link href="<?=__THEMEURL__?>assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/layouts/layout/css/themes/<?=$this->parent->ThemeColorCssFile()?>" rel="stylesheet" type="text/css" id="style_color" />
		
		 <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
		
		<link href="<?=__ADMINURL__?>app/ajaxloader/ajaxloader/ajaxloader.css" type="text/css" rel="stylesheet" />
        <!--<link href="<?=__THEMEURL__?>assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css" />-->
		<link rel="stylesheet" type="text/css" href="<?=__UTILSAPP__?>nested-list/jquery.domenu-0.99.77.css"/>
		
        <!-- END THEME LAYOUT STYLES -->
        <!--<link rel="shortcut icon" type="image/x-icon" href="<?=__THEMEURL__?>admin_1/favicon.ico" /> -->
		<link rel="shortcut icon" type="image/png" href="<?=__THEMEURL__?>admin_1/favicon.png" />

		<!-- calendar resources -->
		<link href='<?=__CALENDARURL__?>fullcalendar.min.css' rel='stylesheet' />
		<link href='<?=__CALENDARURL__?>fullcalendar.print.min.css' rel='stylesheet' media='print' />		
		<!-- end calendar resources -->		
		
		<!-- qtip resources -->
		<link type="text/css" rel="stylesheet" href="<?=__ADMINURL__?>app/qtip2/jquery.qtip.css" />
		
		<link href="<?=__THEMEURL__?>assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css" />
	</head>
<script type="text/javascript">
document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'interactive') {
       document.getElementById('contents').style.visibility="hidden";
  } else if (state == 'complete') {
      setTimeout(function(){
         document.getElementById('interactive');
         document.getElementById('load').style.visibility="hidden";
         document.getElementById('contents').style.visibility="visible";
      },200);
  }
}		
</script>		
		</head>
    <!-- END HEAD -->
<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->

<!-- /////////////////////////////////////////////////////////////////////////////////////////// -->
    <body class="<?=($this->parent->theme_header ? 'page-header-fixed' : '')?> <?=($this->parent->theme_sidebar_mode ? 'page-sidebar-fixed' : '')?> <?=($this->parent->theme_sidebar_position ? 'page-sidebar-reversed' : '')?> <?=($this->parent->theme_footer ? 'page-footer-fixed' : '')?> page-sidebar-closed-hide-logo page-content-white" template-path="<?=__THEMEURL__?>">
		<div id="load"></div>
        <!-- BEGIN HEADER -->
        <div class="page-header navbar <?=($this->parent->theme_header ? 'navbar-fixed-top' : 'navbar-static-top')?>">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                        <img id="xxx" src="<?=__THEMEURL__?>assets/layouts/layout/img/logo.png" class="logo-default mousepointer" onclick="cst_message_load_html('Despre...','<?=__ADMINURL__?>resources/info/hlp_about.php');" />
						<!--<?=$this->parent->StylizedName(false)?>-->
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <?=$this->parent->ShowTopMenu()?>
                        <?=$this->parent->ShowUserTopMenu()?>
                        <!-- END USER LOGIN DROPDOWN -->
                        <?=$this->parent->ShowLanguages()?>
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <?php if ($this->parent->display_quick_sidebar) { ?>
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="javascript:;" class="dropdown-toggle">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                        <?php } ?>
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
