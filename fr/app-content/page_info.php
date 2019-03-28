<?php
	/* -------------------------- */
	$query = "
	SELECT el_articles.* 
	FROM el_articles 
	WHERE el_articles.id_archive=50 OR el_articles.id_archive=30 ORDER BY display_index ASC, date_add DESC";
	$result = $oDB->db_query($query);
	$str_right_services  = '';
	$str_bottom_services = '';
	$str_bottom_news     = '';
	$news_no = 0;
	while ($result_line = $oDB->db_fetch_array($result)) {		
		if ($result_line['id_archive']==50) {
			$class=($result_line['slug']==$this->idn ? 'class="text-theme-colored"' : '');
			$lnk = $this->return_link_to_servicii($result_line['slug'], $result_line['redirect_to']);
			$str_right_services .= ' <li><a '.$class.' href="'.$lnk.'">'.$result_line['name'].'</a></li>';
			$str_bottom_services .= '
					<div class="item">
					  <div class="team-members maxwidth400">
						<div class="team-thumb">
						  <a href="'.$lnk.'"><img class="img-fullwidth" alt="'.$result_line['image_description'].'" src="'.FE_CropImage($result_line['featured_image'], 260, 230).'"></a>
						</div>
						<div class="team-bottom-part border-1px text-center bg-white p-10 pt-20 pb-10">
						  <h4 class="text-uppercase font-raleway text-theme-color-2 font-weight-600 line-bottom-center m-0">'.$result_line['name'].'</h4>
						  <p class="font-13 mt-10 mb-10">'.el_TruncateString(strip_tags($result_line['description']), 120).'</p>
						  <!--
						  <ul class="styled-icons icon-sm icon-gray icon-hover-theme-colored">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
							<li><a href="#"><i class="fa fa-skype"></i></a></li>
						  </ul>
						  -->
						</div>
					  </div>
					</div>'.PHP_EOL;
		} else {
			$news_no++;
			if ($news_no<5) {
				$lnk = $this->return_link_to_article($result_line['slug'], $result_line['redirect_to']);
				$str_bottom_news .= '
              <article class="post media-post clearfix pb-0 mb-20">
                <div class="event-date-time pull-left bg-theme-colored text-center mt-5 p-15 pt-10">
                  <h4 class="text-white font-weight-600 font-28 mt-0 mb-0">'.$news_no.'</h4>
                  <span class="text-white">&#936;</span>
                </div>
                <div class="post-right upcoming-event-right">
                  <h4 class="mt-0 mb-5"><a href="'.$lnk.'">'.$result_line['name'].'</a></h4>
                  <ul class="list-inline font-12 mb-5">
                    <li class="pr-0"><i class="fa fa-file-text-o mr-5"></i> Articole psihologie |</li>
                    <li class="pl-5"><i class="fa fa-user mr-5"></i>Psiholog Calin Magda</li>
                  </ul>
                  <p class="mb-0 font-13">'.el_TruncateString(strip_tags($result_line['description']), 93).' <a class="text-theme-colored font-weight-600 font-13 ml-5" href="">→</a></p>
                </div>
              </article>'.PHP_EOL;
			}
		}
	}
	/* -------------------------- */
	$query = "SELECT * FROM el_gallery WHERE id_archive=1 ORDER BY date_add DESC";
	$result = $oDB->db_query($query);
	$str_right_ads = '';
	$news_no = 0;
	while ($result_line = $oDB->db_fetch_array($result)) {		
		$str_right_ads .= '
		  <div class="item">
			<img src="'.$result_line['file'].'" alt="">
			<h4 class="title">'.$result_line['description'].'</h4>
			<!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae illum amet illo.</p>-->
		  </div>'.PHP_EOL;
	}
	/* -------------------------- */
	$tags_string = '';        
	$str_tag_cloud =rtrim(trim($this->current_page['tags']), ",");
	
	$arr_keywords = explode(',',$str_tag_cloud);
	foreach ($arr_keywords as $value) {
		$tags_string .= "<a href='javascript:void(0);'>$value</a>".PHP_EOL;
	}
	/* -------------------------- */

?>
  <!-- Start main-content -->
  <div class="main-content">

    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="<?=__APPFILESURL__?>images/slider/top.jpg">
      <div class="container pt-70 pb-50">
        <!-- Section Content -->
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-12">
              <h4 class="title text-white"><?=$this->current_page['title']?></h4>
              <ul class="breadcrumb white">
                <li><a class="text-white" href="<?=__URL__?>">Home</a></li>
                <li class="active"><?=$this->settings['company_name']?></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section: Services -->
    <section>
      <div class="container">
        <div class="row mtli-row-clearfix">
          <div class="col-sm-6 col-md-8 col-lg-8">
            <div class="campaign bg-silver-light maxwidth500 mb-30">
			  <?php if (!empty($this->current_page['featured_image_org'])) { ?>
              <div class="thumb">
                <img src="<?=$this->current_page['featured_image_org']?>" alt="<?=$this->current_page['image_description']?>" class="img-fullwidth">
                <div class="campaign-overlay"></div>
              </div>
			  <?php } ?>
              <div class="campaign-details clearfix p-15 pt-10 pb-10">
                <h5 class="text-theme-colored font-weight-500 mb-0"><?=$this->settings['company_name']?></h5>
                <h4 class="font-weight-700 mt-0"><a href="javascript:void(0);"><?=$this->current_page['title']?></a></h4>
                <p><?=$this->settings['company_address']?>, Tel: <?=$this->settings['company_phone']?> <a class="text-theme-colored ml-5" href="<?=$this->return_link_to_contact()?>"> →</a></p>
                <div class="campaign-bottom border-top clearfix mt-20">
                  <ul class="list-inline font-weight-600 pull-left flip pr-0 mt-10">
                    <li class="text-gray pr-0 mr-5">Activités <span class="text-theme-colored">humanitaires</span> |</li>
                    <li>
                      <div class="star-rating" title=""><span style="width: 100%;">5</span></div>
                    </li>
                  </ul>
                  <a class="btn btn-xs btn-theme-colored font-weight-600 font-11 pull-right flip mt-10" href="<?=$this->return_link_to_doneaza()?>">Faites un don</a>
                </div>
              </div>
            </div>
            <div class="event-details">
				<?=$this->current_page['description']?>
            </div>
			<p>Partager:</p>
			<div class="addthis_inline_share_toolbox"></div>
          </div>
          <div class="col-sm-6 col-md-4 col-lg-4">
            <div class="sidebar sidebar-right mt-sm-30">
              <div class="widget">
                <h5 class="widget-title line-bottom">Activités humanitaires</h5>
                <ul class="list-divider list-border list check">
				  <?=$str_right_services?>
                </ul>
              </div>
              <div class="widget">
                <h5 class="widget-title line-bottom"><?=$this->settings['company_name']?></h5>
                <div class="owl-carousel-1col">
				  <?=$str_right_ads?>
                </div>
              </div>
              <?php if (!empty($tags_string)) { ?>
			  <div class="widget">
                <h5 class="widget-title line-bottom">Mots clés</h5>
                <div class="tags">
					<?=$tags_string?>
                </div>
              </div>
			  <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section: Counselor & Upcoming Events -->
    
    <!-- Divider: Clients -->
    <section class="bg-theme-colored">
      <div class="container pt-0 pb-0">
        <div class="row">
          <div class="call-to-action sm-text-center p-0 pt-30 pb-20">
            <div class="col-md-9">
              <h3 class="mt-5 text-white">Sauvez la vie d'un enfant, aidez les personnes âgées et les gens de la rue!</h3>
            </div>
            <div class="col-md-3 text-right flip sm-text-center"> 
              <a href="<?=$this->return_link_to_doneaza()?>" class="btn btn-default btn-circled btn-lg mt-5">Faites un don<i class="fa fa-angle-double-right font-16 ml-10"></i></a> 
            </div>
          </div>
        </div>
      </div>
    </section>
	
  </div>
  <!-- end main-content -->