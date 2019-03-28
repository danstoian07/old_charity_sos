  <!-- Start main-content -->
  <div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="<?=__APPFILESURL__?>images/slider/top.jpg">
      <div class="container pt-70 pb-50">
        <!-- Section Content -->
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-12">
              <h4 class="title text-white">FAITES UN DON</h4>
              <ul class="breadcrumb white">
                <li><a class="text-white" href="<?=__URL__?>">Home</a></li>
                <li class="active">Faites un don, SOS Umanitar</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Divider: Contact -->
    <section class="divider">
      <div class="container pt-sm-10 pb-sm-30">
        <div class="row pt-30">
          <div class="col-md-8">
            <h1 class="mt-0 mb-20">Faites un don</h1>
				<div class="event-details">
					<div class="hidden-md hidden-lg">
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick" />
						<input type="hidden" name="hosted_button_id" value="8J87U49YV6VWE" />
						<input type="image" src="https://www.charity-sos.com/app-content/images/paypal-donate-button.png" border="0" style="width:70%;" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
						<img alt="" border="0" src="https://www.paypal.com/en_RO/i/scr/pixel.gif" width="1" height="1" />
						</form>				
					</div>
					<p><strong>L’Association S.O.S. Umanitar, ayant le siège à Galati-Romania, vous prie de donner</strong> par PayPal pour:</p>
					<ul>
					<li>Soutenir les enfants malformés, les enfants sans abri, les enfants des centres d’accueil, les enfants surdoués, les vieux souffrants.</li>
					<li>La réintégration sociale des personnes atteintes d’un handicap </li>
					<li>L’aide des personnes en difficulté à la suite des désastres telles que des tremblements de terre, des inondations, des incendies ou d’autres situations similaires</li>
					<li>Le logement temporaire des personnes qui se trouvent à notre attention et qui ne possèdent pas de ressources</li>
					<li>Autres activités sociales similaires dont le but est l’éducation des citoyens et le développement des relations interhumaines</li>
					</ul>
					<p>En Roumanie, beaucoup de fois, l’attention accordée à ces cas est incomplète, et, par suite beaucoup de ces catégories perdent la lutte contre les difficultés sociales actuelles. Les solutions pour résoudre les problèmes sociaux mentionnés sont chères et il y a peu de personnes qui puissent les résoudre tout seules.</p>
					<h3><strong>Donnez et l’argent collecté sera utilisé afin d’aider les catégories sociales mentionnées. On vous remercie!</strong></h3>
				</div>
            <!-- Contact Form -->
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick" />
			<input type="hidden" name="hosted_button_id" value="8J87U49YV6VWE" />
			<input type="image" src="https://www.charity-sos.com/app-content/images/paypal-donate-button.png" border="0" style="width:70%;" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
			<img alt="" border="0" src="https://www.paypal.com/en_RO/i/scr/pixel.gif" width="1" height="1" />
			</form>
			<?php
				$my_paypal_email = "sosumanitar-facilitator@yahoo.com"; /* se modifica cu adresa de e-mail a asociatiei */
				$charity_name    = "Asociatia SOS Umanitar"; /* numele asociatiei */
				$url_tank_you 	 = __URL__."thank-you/"; /* Adresa de return dupa efectuarea platii */
				$url_cancel 	 = __URL__."cancel/"; /* Adresa de return daca operatiunea a esuat */
			?>
			<blockquote>
			<p>Aidez en donnant une somme d&rsquo;argent dans le compte de notre Association S.O.S. Umanitar ayant le n&deg; <strong>RO16 BACX 0000 0013 7379 9001</strong> ouvert &agrave; la <strong>Banque Unicredit Galati, Romania</strong></p>
			</blockquote>

			<blockquote>
			<p>Envoyez &agrave; notre adresse :&nbsp; Asociatia&nbsp; S.O.S.&nbsp; UMANITAR str. Aleea Melodiei nr. 8, Bl. B8, Sc. 5&nbsp; ap. 49, Cam. 3, Galati, Romania, Code fiscal 36840122, des paquets avec des aides humanitaires qui seront ult&eacute;rieurement redistribu&eacute;s.</p>
			</blockquote>
			
			<!--
            <form id="contact_form1" name="contact_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
			  <input type="hidden" name="charset" value="utf-8">
			  <input type="hidden" name="cmd" value="_donations" />
			  <input type="hidden" name="business" value="<?=$my_paypal_email?>" />
			  <input type="hidden" name="receiver_email" value="<?=$my_paypal_email?>" />
			  <input type="hidden" name="item_name" value="<?=$charity_name?>" />
			  <input type="hidden" name="return" value="<?=$url_tank_you?>">
			  <input type="hidden" name="cancel_return" value="<?=$url_cancel?>">
			  <input type="hidden" name="currency_code" value="EUR">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="first_name">First Name <small>*</small></label>
					<input id="first_name" name="first_name" class="form-control" type="text" placeholder="First name" required="">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="last_name">Last Name <small>*</small></label>
					<input id="last_name" name="last_name" class="form-control" type="text" placeholder="Last name" required="">
                  </div>
                </div>
				
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="email">Email <small>*</small></label>
                    <input id="email" name="email" class="form-control required email" type="email" placeholder="Email Address">
                  </div>
                </div>
              </div>
                
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="address1">Address <small></small></label>
                    <input id="address1" name="address1" class="form-control" type="text" placeholder="Address">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
					  <div class="form-group">
						<label for="exampleFormControlSelect1">Select Amount</label>
						<select class="form-control required" id="select_amount" required="">
						  <option value="5">&euro; 5 EUR</option>
						  <option value="10">&euro; 10 EUR</option>
						  <option value="25" selected>&euro; 25 EUR</option>
						  <option value="50">&euro; 50 EUR</option>
						  <option value="100">&euro; 100 EUR</option>
						  <option value="250">&euro; 250 EUR</option>
						  <option value="500">&euro; 500 EUR</option>
						  <option value="111">Custom amount</option>
						</select>
					  </div>				
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="amount">Amount value (&euro; EUR) <small>*</small></label>                    
					<input id="amount" name="amount" class="form-control" type="number" placeholder="Custom amount" value="25" readonly required="">
                  </div>
                </div>				
              </div>
              <div class="form-group">
                <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="" />
                <button type="submit" class="btn btn-dark btn-theme-colored btn-flat mr-5" data-loading-text="Please wait...">DONATE WITH PAYPAL</button>
              </div>
            </form>
			-->
            <!-- Contact Form Validation-->
            <script type="text/javascript">
              $("#contact_form").validate({
                submitHandler: function(form) {
                  var form_btn = $(form).find('button[type="submit"]');
                  var form_result_div = '#form-result';
                  $(form_result_div).remove();
                  form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
                  var form_btn_old_msg = form_btn.html();
                  form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
                  $(form).ajaxSubmit({
                    dataType:  'json',
                    success: function(data) {
                      if( data.status == 'true' ) {
                        $(form).find('.form-control').val('');
                      }
                      form_btn.prop('disabled', false).html(form_btn_old_msg);
                      $(form_result_div).html(data.message).fadeIn('slow');
                      setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
                    }
                  });
                }
              });
            </script>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-map-2 text-theme-colored"></i></a>
                  <div class="media-body"> <strong>FAITES UN DON</strong>
                    <p>Aidez en donnant une somme d’argent dans le compte de notre <strong>Association S.O.S. Umanitar</strong> avant le n° <strong>RO16 BACX 0000 0013 7379 9001</strong> ouvert à la <strong>Banque Unicredit Galati, Romania</strong>.</p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-call text-theme-colored"></i></a>
                  <div class="media-body"> <strong>TÉLÉPHONE</strong>
                    <p><?=$this->settings['company_phone']?></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-mail text-theme-colored"></i></a>
                  <div class="media-body"> <strong>E-MAIL</strong>
                    <p><?=el_ret_safety_email($this->settings['company_email'],'','');?></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20">
                  <div class="media-body" style="text-align:center;">
                    <img src="https://www.charity-sos.com/app-content/images/QRCode.png">
                  </div>
                </div>
              </div>
			  
			  
            </div>
          </div>
		  
        </div>
      </div>
    </section>
    
    <!-- Divider: Google Map -->
    <section>
      <div class="container-fluid pt-0 pb-0">
        <div class="row">

          <!-- Google Map HTML Codes -->
		  <div>
			<!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2796.390673546773!2d9.092323515851811!3d45.50221367910137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4786ea7d9c862665%3A0xb6ba7602979c2243!2sVia+Francesco+Cilea%2C+126%2C+20151+Milano+MI%2C+Italia!5e0!3m2!1sro!2sro!4v1544188778900" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
		  </div>

        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->
