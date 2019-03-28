  <!-- Footer -->
  <footer id="footer" class="footer" data-bg-img="images/footer-bg.png" data-bg-color="#25272e">
    <div class="container pt-70 pb-40">
      <div class="row border-bottom-black">
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <!--<img class="mt-10 mb-20" alt="" src="images/logo.png">-->
            <p><strong><?=$this->settings['company_name']?></strong><br />
			S-a  infiintat  in  data  de  22.11.2016 prin  admiterea  cererii  de  infiintare  de  catre  un  judecator  din  cadrul  Judecatoriei  Galati (Nae  Sebastian),ce  a  constatat  scopul  filantropic  al  organizatiei</p>
            <ul class="list-inline mt-5">
              <li class="m-0 pl-10 pr-10"> <i class="fa fa-phone text-theme-colored mr-5"></i> <a class="text-gray" href="tel:0740213057"><?=$this->settings['company_phone']?></a> </li>
              <li class="m-0 pl-10 pr-10"> <i class="fa fa-envelope-o text-theme-colored mr-5"></i> <?=el_ret_safety_email($this->settings['company_email'],'','text-gray');?> </li>
              <li class="m-0 pl-10 pr-10"> <i class="fa fa-globe text-theme-colored mr-5"></i> <a class="text-gray" href="http://www.charity-sos.com">www.charity-sos.com</a> </li>
            </ul>
			<div class="addthis_inline_share_toolbox"></div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Activitati</h5>
            <div class="latest-posts">
				<?=$str_footer_news?>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Meniu</h5>
            <ul class="list angle-double-right list-border">
              <li><a href="<?=__URL__?>">Home</a></li>              
              <li><a href="<?=__URL__?>despre-noi/">Despre noi</a></li>
              <li><a href="<?=__URL__?>cum-putem-ajuta/">Cum putem ajuta?</a></li>
			  <li><a href="<?=$this->return_link_to_doneaza()?>"><strong class="white">DONEAZA ACUM</strong></a></li>
              <li><a href="<?=$this->return_link_to_contact()?>">Contact</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="widget-title line-bottom">Informatii Utile</h5>
            <ul class="list angle-double-right list-border">
              <li><a href="<?=__URL__?>politica-de-cookie/">Politica de cookie</a></li>
              <li><a href="<?=__URL__?>politica-de-confidentialitate/">Politica de confidentialitate</a></li>
            </ul>
            <h5 class="widget-title line-bottom">Download</h5>
            <ul class="list angle-double-right list-border">
              <li><a download href="https://www.charity-sos.com/uploads/img/download/calendar_RO.pdf">Calendar pentru copii si parinti</a></li>
            </ul>
			
          </div>		
        </div>
      </div>
    </div>
    <div class="footer-bottom bg-black-333">
      <div class="container pt-15 pb-10">
        <div class="row">
          <div class="col-md-6">
            <p class="font-11 text-black-777 m-0 sm-text-center"><?=$this->settings['company_name']?></p>
          </div>
          <div class="col-md-6 text-right">
            <div class="widget no-border m-0">
              <ul class="list-inline sm-text-center mt-5 font-12">
                <li>
				  <!-- **** -->
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
</div>
<!-- end wrapper -->

<!-- Footer Scripts -->
<!-- JS | Custom script for all pages -->
<script src="<?=__APPFILESURL__?>js/custom.js"></script>

<!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
      (Load Extensions only on Local File Systems ! 
       The following part can be removed on Server for On Demand Loading) -->
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.migration.min.js"></script>
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="<?=__APPFILESURL__?>js/revolution-slider/js/extensions/revolution.extension.video.min.js"></script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c0a2d755f48d6af"></script> 

</body>
</html>