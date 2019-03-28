  <!-- Start main-content -->
  <div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="<?=__APPFILESURL__?>images/slider/top.jpg">
      <div class="container pt-70 pb-50">
        <!-- Section Content -->
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-12">
              <h4 class="title text-white">Articole Psihologie</h4>
              <ul class="breadcrumb white">
                <li><a class="text-white" href="<?=__URL__?>">Home</a></li>
                <li class="active"><?=$this->settings['company_name']?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section: Our Mission & Upcoming Events -->
    <section>
      <div class="container">
        <div class="section-content">
          <div class="row multi-row-clearfix">
			<?=$str_articles?>
          </div>
        </div>
      </div>
    </section>

    <!-- Divider: Call To Action  -->
    <section class="bg-theme-colored">
      <div class="container pt-0 pb-0">
        <div class="row">
          <div class="call-to-action sm-text-center p-0 pt-30 pb-20">
            <div class="col-md-9">
              <h3 class="mt-5 text-white">Cabinet Individual de Psihologie CALIN MAGDA</h3>
            </div>
            <div class="col-md-3 text-right flip sm-text-center"> 
              <a href="<?=$this->return_link_to_contact()?>" class="btn btn-default btn-circled btn-lg mt-5">Contact<i class="fa fa-angle-double-right font-16 ml-10"></i></a> 
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end main-content -->
