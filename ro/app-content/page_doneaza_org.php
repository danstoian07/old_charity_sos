  <!-- Start main-content -->
  <div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="<?=__APPFILESURL__?>images/slider/top.jpg">
      <div class="container pt-70 pb-50">
        <!-- Section Content -->
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-12">
              <h4 class="title text-white">DONEAZA ACUM</h4>
              <ul class="breadcrumb white">
                <li><a class="text-white" href="<?=__URL__?>">Home</a></li>
                <li class="active">Doneaza, SOS Umanitar</li>
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
                    <p><?=$this->settings['company_name']?><br /><?=$this->settings['company_address']?></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-call text-theme-colored"></i></a>
                  <div class="media-body"> <strong>TELEFOANE CONTACT</strong>
                    <p><?=$this->settings['company_phone']?></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-mail text-theme-colored"></i></a>
                  <div class="media-body"> <strong>ADRESA E-MAIL</strong>
                    <p><?=el_ret_safety_email($this->settings['company_email'],'','');?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <h1 class="mt-0 mb-20">Formular de donatie</h1>
				<div class="event-details">
					<p><strong>Asociatia S.O.S. Umanitar cu sediul in Galati- Romania va roaga sa donati</strong> prin PAYPAL pentru :</p>
					<ul>
					<li>Sprijinirea copiilor cu malformatii, copiilor strazii, copiilor din centre de plasament, copiilor supradotati,batranilor suferinzi</li>
					<li>Reintegrarea sociala a persoanelor cu handicap</li>
					<li>Ajutorarea persoanelor care se afla in dificultate ca urmare a unor dezastre precum cutremure,inundatii ,incendii sau alte situatii asemanatoare</li>
					<li>Cazarea temporara a persoanelor aflate in atentia noastra care nu detin resurse </li>
					<li>Alte activitati sociale asemanatoare care au ca scop educarea cetatenilor si dezvoltarea relatiilor inter-umane </li>
					</ul>
					<p>In Romania de multe ori atentia acordata acestor cazuri este incompleta, si ca urmare multe dintre aceste categorii pierd lupta cu dificultatile sociale existente. Solutiile de rezolvare ale problemelor sociale mentionate sunt costisitoare si putine sunt persoanele care le pot rezolva singure.</p>
					<h3><strong>Doneaza, si banii adunati se vor folosi in ajutorarea categoriilor sociale precizate. Va multumim !</strong></h3>
				</div>
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
                <button type="submit" class="btn btn-dark btn-theme-colored btn-flat mr-5" data-loading-text="Please wait...">DONEAZA PRIN PAYPAL</button>
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
			<!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2796.390673546773!2d9.092323515851811!3d45.50221367910137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4786ea7d9c862665%3A0xb6ba7602979c2243!2sVia+Francesco+Cilea%2C+126%2C+20151+Milano+MI%2C+Italia!5e0!3m2!1sro!2sro!4v1544188778900" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
		  </div>

        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->
