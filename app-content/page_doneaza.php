  <!-- Start main-content -->
  <div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="<?=__APPFILESURL__?>images/slider/top.jpg">
      <div class="container pt-70 pb-50">
        <!-- Section Content -->
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-12">
              <h4 class="title text-white">DONATE NOW</h4>
              <ul class="breadcrumb white">
                <li><a class="text-white" href="<?=__URL__?>">Home</a></li>
                <li class="active">Donate now, SOS Umanitar</li>
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
            <h1 class="mt-0 mb-20">Donate now</h1>
				<div class="event-details">
					<div class="hidden-md hidden-lg">
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick" />
						<input type="hidden" name="hosted_button_id" value="8J87U49YV6VWE" />
						<input type="image" src="https://www.charity-sos.com/app-content/images/paypal-donate-button.png" border="0" style="width:70%;" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
						<img alt="" border="0" src="https://www.paypal.com/en_RO/i/scr/pixel.gif" width="1" height="1" />
						</form>				
					</div>
					<p><strong>S.O.S. Umanitar Association, with the headquarters in Galati-Romania, is asking you to donate</strong> via PayPal for:</p>
					<ul>
					<li>Supporting malformed children, homeless children, foster care children, gifted children, suffering elderly</li>
					<li>Social reintegration of disabled people </li>
					<li>Assisting people in distress further to disasters such as earthquakes, floods, fires and other similar events</li>
					<li>Temporary accommodation of poor people under our attention  </li>
					<li>Other similar social activities intended to educate citizens and develop interhuman relations</li>
					</ul>
					<p>In Romania, the attention given to many of these cases is incomplete and, as such, many of these categories lose the fight with the existing social difficulties. The solutions for settling the aforementioned social issues are costly and there are few people who can settle them by themselves.</p>
					<h3><strong>Donate and the gathered money will be used for helping the aforementioned social categories. Thank you!</strong></h3>
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
			<p>Help by donating an amount of money into the account of our S.O.S. Umanitar Association with no.<br />
			<strong>RO16 BACX 0000 0013 7379 9001</strong> opened at Unicredit Bank Galati, Romania.</p>
			</blockquote>

			<blockquote>
			<p>Ship to our address:&nbsp; Asociatia&nbsp; S.O.S.&nbsp; UMANITAR str. Aleea Melodiei nr. 8, Bl. B8, Sc. 5, ap. 49, Cam. 3, Galati, Romania, VAT No. 36840122, parcels with humanitarian aids that will subsequently be redistributed.</p>
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
                  <div class="media-body"> <strong>DONATE</strong>
                    <p>Help by donating an amount of money into the account of our <strong>S.O.S. Umanitar Association</strong> with no. <strong>RO16 BACX 0000 0013 7379 9001</strong> opened at <strong>Unicredit Bank Galati, Romania</strong>.</p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-call text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR PHONE</strong>
                    <p><?=$this->settings['company_phone']?></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-mail text-theme-colored"></i></a>
                  <div class="media-body"> <strong>E-MAIL ADDRESS</strong>
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
