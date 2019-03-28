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
        <meta content="Pagina login aplicatie" name="description" />
        <meta content="<?=$this->SoftwareAuthorInfo()?>" name="author"/>
        <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />-->
        <link href="<?=__THEMEURL__?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="<?=__THEMEURL__?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=__THEMEURL__?>assets/pages/css/login-3.min.css" rel="stylesheet" type="text/css" />
		<link href="<?=__THEMEURL__?>assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css" />
        <!--<link rel="shortcut icon" type="image/x-icon" href="<?=__THEMEURL__?>admin_1/favicon.ico" /> </head>-->
		<link rel="shortcut icon" type="image/png" href="<?=__THEMEURL__?>admin_1/favicon.png" />
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
            <form class="login-form" action="<?=__ACTIONURL__?>s-login.php" method="post">
                <h3 class="form-title"><?=_('Login to your account')?></h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> <?=_('Please fill your e-mail and password')?> </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9"><?=_('E-mail')?></label>
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="<?=_('E-mail')?>" name="username" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9"><?=_('Password')?></label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="<?=_('Password')?>" name="password" /> </div>
                </div>
                <div class="form-actions">
					
                    <label class="rememberme mt-checkbox mt-checkbox-outline">						
						<!--
                        <input type="checkbox" name="remember" value="1" /> <?=_('Memoreaza')?>						
                        <span></span>
						-->
                    </label>
					
                    <button type="submit" class="btn green pull-right"> <?=_('Login')?> </button>
                </div>
				
                <div class="forget-password">
                    <h4><?=_('Forgot your password ?')?></h4>
                    <p> <?=_('Don\'t worries, click')?>
                        <a href="javascript:;" id="forget-password"> <?=_('here')?> </a> <?=_('to reset your password.')?> </p>
                </div>
				
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form1" id="form_reset" action="<?=__ACTIONURL__?>ajax-reset-pass.php" method="post" style="display:none;">
                <h3><?=_('Forgot your password ?')?></h3>
                <p> <?=_('Enter your email address and we\'ll send you a link to reset your password. ')?> </p>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
						<div class="noafis"><input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Lasa necompletat" id ="user" name="user" /></div>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" id ="emailrec" name="emailrec"/> 
						<div class="noafis"><input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Lasa necompletat" id ="person" name="person" /></div>
						<div class="noafis"><input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Lasa necompletat" id ="phone" name="phone" /></div>
					</div>						
                </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn grey-salsa btn-outline"> <?=_('Back')?> </button>					
                    <button type="submit" class="btn green pull-right"> <?=_('Submit')?> </button>
					<div id="loader" class="pull-right" style="display:none;"><i class="fa fa-cog fa-spin"></i></div>
                </div>
				<div class="form-actions mt5" id="form_message"></div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
            <!-- END REGISTRATION FORM -->
        </div>
		<div class="copyright color_white"> <?=$this->CopyrightInfo()?> </div>
        <!-- END LOGIN -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <script src="<?=__THEMEURL__?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?=__THEMEURL__?>assets/global/scripts/custom.js" type="text/javascript"></script>
    </body>

</html>