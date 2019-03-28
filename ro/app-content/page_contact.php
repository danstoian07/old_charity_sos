  <!-- Start main-content -->
  <div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="<?=__APPFILESURL__?>images/slider/top.jpg">
      <div class="container pt-70 pb-50">
        <!-- Section Content -->
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-12">
              <h4 class="title text-white">Contact</h4>
              <ul class="breadcrumb white">
                <li><a class="text-white" href="<?=__URL__?>">Home</a></li>
                <li class="active">Contact</li>
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
          <div class="col-md-4">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-map-2 text-theme-colored"></i></a>
                  <div class="media-body"> <strong>ADRESA</strong>
                    <p><?=$this->settings['company_address']?></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-call text-theme-colored"></i></a>
                  <div class="media-body"> <strong>TELEFON CONTACT</strong>
                    <p><?=$this->settings['company_phone']?></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-mail text-theme-colored"></i></a>
                  <div class="media-body"> <strong>ADRESE E-MAIL</strong>
                    <p><?=el_ret_safety_email($this->settings['company_email'],'','');?></p>
                  </div>
                </div>
              </div>
			  <!--
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="fa fa-skype text-theme-colored"></i></a>
                  <div class="media-body"> <strong>Make a Video Call</strong>
                    <p>ThemeMascotSkype</p>
                  </div>
                </div>
              </div>
			  -->
            </div>
          </div>
          <div class="col-md-8">
            <h3 class="mt-0 mb-20">Formular de contact</h3>
            <!-- Contact Form -->
            <form id="contact_form" name="contact_form" class="" action="<?=__APPFILESURL__?>includes/quickcontact.php" method="post">

              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="form_name">Nume <small>*</small></label>
                    <input id="form_city" name="form_city" class="form-control noafis" type="text" placeholder="City" required="">
					<input id="form_name" name="form_name" class="form-control" type="text" placeholder="Nume" required="">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="form_email">Email <small>*</small></label>
					<input id="form_region" name="form_region" class="form-control noafis" type="text" placeholder="Region" required="">
                    <input id="form_email" name="form_email" class="form-control required email" type="email" placeholder="Adresa Email">
                  </div>
                </div>
              </div>
                
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="form_name">Subiect <small>*</small></label>
                    <input id="form_subject" name="form_subject" class="form-control required" type="text" placeholder="Subiect mesaj">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="form_phone">Telefon <small>*</small></label>
                    <input id="form_phone" name="form_phone" class="form-control required" type="text" placeholder="Telefon" required="">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="form_message">Mesaj</label>
				<input id="form_address" name="form_address" class="form-control noafis" type="text" placeholder="Address" required="">
                <textarea id="form_message" name="form_message" class="form-control required" rows="5" placeholder="Mesajul tau"></textarea>
              </div>
              <div class="form-group">
                <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="" />
                <button type="submit" class="btn btn-dark btn-theme-colored btn-flat mr-5" data-loading-text="Please wait...">Trimite mesajul</button>
                <button type="reset" class="btn btn-default btn-flat btn-theme-colored">Resetare</button>
              </div>
            </form>

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
        </div>
      </div>
    </section>
    
    <!-- Divider: Google Map -->
    <section>
      <div class="container-fluid pt-0 pb-0">
        <div class="row">

          <!-- Google Map HTML Codes -->
		  <div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2799.8661986987663!2d28.04794581584984!3d45.432198479100606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b6deff07110f3f%3A0x52620f49baa3a77f!2sStrada+Melodiei+8%2C+Gala%C8%9Bi+827100!5e0!3m2!1sro!2sro!4v1548056445700" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		  </div>

        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->
