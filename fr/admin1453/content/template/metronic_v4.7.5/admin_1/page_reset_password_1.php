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
        <meta content="Pagina resetare parola" name="description" />
        <meta content="<?=$this->SoftwareAuthorInfo()?>" name="author"/>
        <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />-->
        <link href="<?=__THEMEURL__?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />


        <link href="<?=__THEMEURL__?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />		
        <link href="<?=__THEMEURL__?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
		
        <link href="<?=__THEMEURL__?>assets/pages/css/login.min.css" rel="stylesheet" type="text/css" />
		<link href="<?=__THEMEURL__?>assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css" />

        <link rel="shortcut icon" href="<?=__THEMEURL__?>admin_1/favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">           
			<?=$this->StylizedName(false)?>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form1" id="form_update_pass" action="<?=__ACTIONURL__?>ajax-update-pass.php" method="post">
                <h3 class="form-title font-green">Resetare Parola</h3>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
					<div class="noafis"><input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Lasa necompletat" id ="user" name="user" /></div>
                    <label class="control-label visible-ie8 visible-ie9">Parola</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Parola" name="pass1" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Repeta parola</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Repeta parola" name="pass2" /> </div>
					<div class="noafis"><input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Lasa necompletat" id ="person" name="person" /></div>
					<div class="noafis"><input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Lasa necompletat" id ="phone" name="phone" /></div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase pull-left">Reseteaza parola</button>
					<div id="loader" class="pull-left" style="display:none;"><i class="fa fa-cog fa-spin"></i></div>
					<div class="clearfix"></div>
                </div>
                <div class="login-options">
                    <div id="form_message"></div>
                </div>
                <div class="create-account">
                    <p>
                        <a href="<?=__ADMINURL__?>" id="goto-login" class="uppercase">Mergi la Login</a>
                    </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->
        </div>
        <div class="copyright"> <?=$this->CopyrightInfo()?> </div>
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?=__THEMEURL__?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?=__THEMEURL__?>assets/global/scripts/custom.js" type="text/javascript"></script>
    </body>

</html>