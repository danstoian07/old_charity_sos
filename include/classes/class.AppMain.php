<?php

Class AppMain
{
	/* ------------------------------------------------------------------------------------- */	
	public  $name                   = APP_NAME;	
		
	public  $meta_title             = '';
	public  $meta_keywords          = '';
	public  $meta_description       = '';

	public  $section_title          = '';
	public  $category_title         = '';
	public  $category_link          = '';
	
	public  $og_title             	= '';
	public  $og_description         = '';
	public  $og_image             	= '';
	public  $og_width             	= 800;
	public  $og_height             	= 415;
	public  $og_locale             	= 'ro_RO';
	public  $body_class				= '';
	
	
	
			
	/* ------------------------------------------------------------------------------------- */	

	public function __construct() {
		global $oDB;
		
		if( isset($_REQUEST['pn']) )       { $this->createProperty('pn',   $_REQUEST['pn']);  }  		  else { $this->createProperty('pn', 1);   }
		if( isset($_REQUEST['idn']) )      { $this->createProperty('idn',  $_REQUEST['idn']); }           else { $this->createProperty('idn', '');  }
		if( isset($_REQUEST['categ']) )    { $this->createProperty('categ',$_REQUEST['categ']); }         else { $this->createProperty('categ', '');  }
		if( isset($_REQUEST['lpn']) )      { $this->createProperty('lpn',  $_REQUEST['lpn']);  }  		  else { $this->createProperty('lpn', 1);   }
		if ( isset($_REQUEST['src']))      { $this->createProperty('src',  urldecode($_REQUEST['src']));} else  { $this->createProperty('src', '');  } 
		/* aici determina parametri din setari, seteaza meta, etc */
		
		$query = "SELECT * FROM el_app_settings WHERE id=1";
		$result = $oDB->db_query($query);
		if ($result_line = $oDB->db_fetch_array($result)) {            
			
			
			$this->meta_title       = $result_line['fp_meta_title'];
			$this->meta_description = $result_line['fp_meta_description'];
			$this->meta_keywords 	= $result_line['fp_meta_keywords'];			
			
			$this->createProperty('settings', array());			
			$this->settings['photo_facebook']       = __APPFILESURL__.'images/share/facebook-share.jpg';
			$this->og_image 					    = $this->settings['photo_facebook'];			
			
			$this->og_title         = $this->meta_title;
			$this->og_description   = $this->meta_description;
			
			$this->settings['company_name']                = $result_line['company_name'];
			$this->settings['company_address']             = $result_line['company_address'];
			$this->settings['company_phone']               = $result_line['company_phone'];
			$this->settings['company_fax']                 = $result_line['company_fax'];
			$this->settings['company_email']               = $result_line['company_email'];
			$this->settings['company_program']             = $result_line['company_program'];			
			$this->settings['company_contact_tel1']        = $result_line['company_contact_tel1'];
			$this->settings['company_contact_tel2']        = $result_line['company_contact_tel2'];			
			$this->settings['company_contact_fax1']        = $result_line['company_contact_fax1'];
			$this->settings['company_contact_fax2']        = $result_line['company_contact_fax2'];
			$this->settings['company_contact_description'] = $result_line['company_contact_description'];
			
			$this->settings['slider_1']                = $result_line['slider_1'];
			$this->settings['slider_2']                = $result_line['slider_2'];
			$this->settings['slider_3']                = $result_line['slider_3'];
			
			/* top banners and opacity */
			
			$this->settings['admin_contact_email']       = $result_line['admin_contact_email'];
			$this->settings['oferta_istros']             = $result_line['oferta_istros'];
			$this->settings['aparitii_istros']           = $result_line['aparitii_istros'];
						
			$this->createProperty('links', '');
			$this->createProperty('last_photos', $this->return_last_photos());
			
			/* determina ultimele evenimente */
			$this->createProperty('last_events', '');			
			$this->last_events = $this->return_last_events(4);
			
			$this->createProperty('last_ads_achizitii', '');
			$this->createProperty('last_ads_angajari', '');
			$this->createProperty('last_ads_diverse', '');
			
			/* query ads - achizitii publice */
		} else {
			die ('Error get website settings !');
		}
		
	}
	/* ------------------------------------------------------------------------------------- */
	public function getClassName(){
		return get_class($this);
	}	
	/* ------------------------------------------------------------------------------------- */	
    public function createProperty($name, $value){
        $this->{$name} = $value;
    }			
	/* ------------------------------------------------------------------------------------- */
	public function Run() {
		$this->DisplayPanel();
	}
	/* ------------------------------------------------------------------------------------- */	
	public function DisplayPanel(){
		global $oDB;
		$ERROR_NOTFOUND = false;
		$ERROR_CODE     = 0;
		switch ($this->pn) {
			case 1: 
					/* afiseaza prima pagina */					
		    		include(__APPFILESPATH__.'header.php');
		    		include(__APPFILESPATH__.'page_first.php');
		    		include(__APPFILESPATH__.'footer.php');			        					
		    		break;
			        /* ----------------------------------------- */
			case 2:
					/* afiseaza articol principal */
					/*
					$query = "
					SELECT el_articles.* 
					FROM el_articles 
					WHERE el_articles.slug='$this->idn' AND el_articles.id_archive=0";
					*/
					$this->idn = mysqli_real_escape_string($oDB->dbh,$this->idn);
					$query = "
					SELECT el_articles.* 
					FROM el_articles 
					WHERE el_articles.slug='$this->idn'";
					
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
						
						$this->category_title = ($result_line['type']==1 ? 'Secțiile Muzeului Brăilei „CAROL I“' : 'Muzeul Brăilei „CAROL I“');
						$this->category_link  = __URL__;
						$show_categ_date      = false;
						
						$this->meta_title       = (!empty($result_line['meta_title']) ? $result_line['meta_title'] : strip_tags($result_line['name']));
						$this->meta_description = (!empty($result_line['meta_description']) ? $result_line['meta_description'] : '');
						$this->meta_keywords    = $result_line['meta_keywords'];
						
						$this->createProperty('current_page', array());
						$this->current_page['sectie']              	 = ($result_line['type']==1 ? true : false);
						$this->current_page['id']                 	 = $result_line['id'];
						$this->current_page['id_archive']          	 = $result_line['id_archive'];
						$this->current_page['idma']          	 	 = $result_line['idma'];
						$this->current_page['title']                 = $result_line['name'];
						$this->current_page['title_top']             = $result_line['top_title'];
						$this->current_page['description']           = $result_line['description'];
						$this->current_page['date_add']              = $result_line['date_add'];
						$this->current_page['show_image_in_body']    = $result_line['show_image_in_body'];
						$this->current_page['tags']                  = $result_line['tags'];
						
						//$this->current_page['show_custom_menu']      = $result_line['show_custom_menu'];
						//$this->current_page['custom_menu_title']     = $result_line['custom_menu_title'];
						//$this->current_page['custom_menu']     	     = $result_line['custom_menu'];
						
						
						//$this->current_page['top_image']    		 = (!empty($result_line['top_image']) ? FE_CropImage($result_line['top_image'], 1920, 325) : __URL__.'app-content/img/banner-top-1920x325.jpg');
						//$this->current_page['top_image_opacity']     = $result_line['top_image_opacity'];
						
						$this->current_page['featured_image_org']    = $result_line['featured_image'];
						$this->current_page['featured_image']        = (!empty($result_line['featured_image']) ? FE_CropImage($result_line['featured_image'], 750) : '');
						$this->current_page['image_description']     = $result_line['image_description'];
						
						
						
						$this->current_page['show_bottom_galeries']  = $result_line['show_bottom_galeries']; /* afiseaza galeria foto in dreapta */
						$this->current_page['gallery_name']  		 = $result_line['gallery_name'];
												
						$this->current_page['redirect_to']           = $result_line['redirect_to'];
						
						//$this->current_page['right_photos']      	 =  ($this->current_page['show_right_poze'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						//$this->current_page['tabs']           	     =  $this->return_article_tabs( $result_line['id']);    /* array */
						//$this->current_page['subarticles']           =  $this->return_article_subarticles($result_line['id'], $result_line['idma'], $result_line['slug']); /* array */
												
						/* -------------------------------------------------- */						
						$this->current_page['right_photos']      	 =  ($this->current_page['show_bottom_galeries'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						/* -------------------------------------------------- */
						/*
						if ($this->current_page['show_bottom_related']!=0) {
							$this->createProperty('related', '');
							$this->related = $this->return_related_articles($this->current_page['id'], $this->current_page['id_archive']);
						}
						*/
						/* -------------------------------------------------- */
						/*
						if ($this->current_page['show_right_events']!=0) {
							$this->createProperty('events', '');
							$this->events = $this->return_last_events(3);
						}
						*/
						/* -------------------------------------------------- */
						
						$this->og_title         = $this->meta_title;
						$this->og_description   = $this->meta_description;
						$this->og_image         = (!empty($result_line['featured_image']) ? $result_line['featured_image'] : $this->settings['photo_facebook']);						
						
					} else {
						$ERROR_CODE = 404;
					}
						
					if (!$ERROR_CODE) {
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_info.php');
						include(__APPFILESPATH__.'footer.php');
					}
		    		break;					
			
					/* ----------------------------------------- */
			case 22: 
					/* afisare SUBARTICOL */
					//echo $this->categ; die(' yyyy');
					if (!empty($this->categ)) {
						$CATEG_NAME = 'MENIU';
						$CATEG_TYPE = 0;
						$CATEG_ID_ARCHIVE = 0;
						/*
						$query = "
						SELECT el_articles.slug, el_articles.name, el_articles.type, el_articles.id_archive 
						FROM el_articles 
						WHERE el_articles.slug='$this->categ' AND el_articles.id_archive=0";
						*/
						$query = "
						SELECT el_articles.slug, el_articles.name, el_articles.type, el_articles.id_archive 
						FROM el_articles 
						WHERE el_articles.slug='$this->categ'";
						
						$result = $oDB->db_query($query);
						if ($result_line = $oDB->db_fetch_array($result)) {
							$CATEG_NAME = $result_line['name'];
							$CATEG_TYPE = $result_line['type'];
							$CATEG_ID_ARCHIVE = $result_line['id_archive'];
						} else {
							$ERROR_CODE = 404;
						}
					} else {
						$ERROR_CODE = 404;
					}					
					if (!$ERROR_CODE) {
						$query = "
						SELECT el_articles.* 
						FROM el_articles 
						WHERE el_articles.slug='$this->idn' AND el_articles.id_archive=20";
						$result = $oDB->db_query($query);
						if ($result_line = $oDB->db_fetch_array($result)) {
							
							$this->category_title = ($result_line['type']==1 ? 'Secțiile Muzeului Brăilei „CAROL I“' : 'Muzeul Brăilei „CAROL I“');
							$this->category_link  = __URL__;
							$show_categ_date      = false;
							
							$this->meta_title       = (!empty($result_line['meta_title']) ? $result_line['meta_title'] : strip_tags($result_line['name']).' | Muzeul Brailei „CAROL I”');
							$this->meta_description = (!empty($result_line['meta_description']) ? $result_line['meta_description'] : '');
							$this->meta_keywords    = $result_line['meta_keywords'];
							
							$this->createProperty('current_page', '');
							$this->current_page['sectie']              	 = ($result_line['type']==1 ? true : false);
							$this->current_page['id']                 	 = $result_line['id'];
							$this->current_page['id_archive']          	 = $result_line['id_archive'];
							$this->current_page['idma']          	 	 = $result_line['idma'];
							$this->current_page['title']                 = $result_line['name'];
							$this->current_page['title_top']             = $result_line['top_title'];
							$this->current_page['description']           = $result_line['description'];
							$this->current_page['date_add']              = $result_line['date_add'];
							$this->current_page['show_image_in_body']    = $result_line['show_image_in_body'];
							
							$this->current_page['show_custom_menu']      = $result_line['show_custom_menu'];
							$this->current_page['custom_menu_title']     = $result_line['custom_menu_title'];
							$this->current_page['custom_menu']     	     = $result_line['custom_menu'];
							
							$this->current_page['categ_slug']          	 = $result_line['id'];
							
							//$this->current_page['top_image']    		 = (!empty($result_line['top_image']) ? FE_CropImage($result_line['top_image'], 1920, 325) : __URL__.'app-content/img/banner-top-1920x325.jpg');
							//$this->current_page['top_image_opacity']     = $result_line['top_image_opacity'];
							
							$this->current_page['featured_image_org']    = $result_line['featured_image'];
							$this->current_page['featured_image']        = (!empty($result_line['featured_image']) ? FE_CropImage($result_line['featured_image'], 720) : '');
							$this->current_page['image_description']     = $result_line['image_description'];
							
							$this->current_page['show_left_contact']    = $result_line['show_right_contact'];
							$this->current_page['contact_title']    	 = $result_line['contact_title'];
							$this->current_page['contact_address']    	 = $result_line['contact_address'];
							$this->current_page['contact_phone']    	 = $result_line['contact_phone'];
							$this->current_page['contact_email']    	 = $result_line['contact_email'];
							$this->current_page['contact_info']    	 	 = $result_line['contact_info'];
							
							$this->current_page['show_right_program']    = $result_line['show_right_program'];
							$this->current_page['program_title']    	 = $result_line['program_title'];
							$this->current_page['program']    	 		 = $result_line['program_sectie']; /* json */
							
							$this->current_page['show_bottom_galeries']  = $result_line['show_bottom_galeries']; /* afiseaza galeria foto in dreapta */
							$this->current_page['gallery_name']  		 = $result_line['gallery_name'];
							
							$this->current_page['show_bottom_related']   = $result_line['show_bottom_related'];
							$this->current_page['related_name']  		 = $result_line['related_name'];
							
							
							$this->current_page['show_right_poze']       = $result_line['show_right_poze'];
							$this->current_page['show_right_events']     = $result_line['show_right_events'];
							$this->current_page['show_right_anunturi']   = $result_line['show_right_impresii']; /* afiseaza anunturi in stanga */
							
							$this->current_page['redirect_to']           = $result_line['redirect_to'];
							
							//$this->current_page['right_photos']      	 =  ($this->current_page['show_right_poze'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
							//$this->current_page['tabs']           	     =  $this->return_article_tabs( $result_line['id']);    /* array */
							
							//$this->current_page['subarticles']           =  $this->return_article_subarticles($result_line['id'], $result_line['idma'], $result_line['slug']); /* array */
							$this->current_page['subarticles']           =  $this->return_article_subarticles($result_line['id'], $result_line['idma'], $this->categ); /* array */
													
							/* -------------------------------------------------- */						
							$this->current_page['right_photos']      	 =  ($this->current_page['show_bottom_galeries'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
							/* -------------------------------------------------- */
							if ($this->current_page['show_bottom_related']!=0) {
								$this->createProperty('related', '');
								$this->related = $this->return_related_articles($this->current_page['id'], $this->current_page['id_archive']);
							}
							/* -------------------------------------------------- */
							if ($this->current_page['show_right_events']!=0) {
								$this->createProperty('events', '');
								$this->events = $this->return_last_events(3);
							}
							/* -------------------------------------------------- */
							
							$this->og_title         = $this->meta_title;
							$this->og_description   = $this->meta_description;
							$this->og_image         = (!empty($result_line['featured_image']) ? $result_line['featured_image'] : $this->settings['photo_facebook']);						
							
						} else {
							$ERROR_CODE = 404;
						}						
					}	
					if (!$ERROR_CODE) {
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_info_subarticle.php');
						include(__APPFILESPATH__.'footer.php');
					}
		    		break;					
					/* ----------------------------------------- */
			case 3: 
					/* afiseaza lista evenimente */				
					$this->createProperty('items_no', 0);
					$query="SELECT count(*) as items_no FROM el_articles 
					WHERE el_articles.visible!=0 AND  el_articles.id_archive=30"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_EVENTS_NO_PER_PAGE;
					$items_no = EC_EVENTS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->items_no/EC_EVENTS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->section_title    = 'Evenimente';
						$this->meta_title       = 'Evenimente '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Evenimente, Muzeul Brailei Carol |';
						$this->og_description   = '';
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_list_articles.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;
					/* ----------------------------------------- */
			case 31: 
					/* afiseaza detalii eveniment */
					$query = "
					SELECT el_articles.* 
					FROM el_articles 
					WHERE el_articles.slug='$this->idn' AND el_articles.id_archive=30";
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
						
						$this->category_title = 'Evenimente';
						$this->category_link  = $this->return_link_to_events();
						$show_categ_date      = true;
						
						$this->meta_title       = (!empty($result_line['meta_title']) ? $result_line['meta_title'] : strip_tags($result_line['name']));
						$this->meta_description = (!empty($result_line['meta_description']) ? $result_line['meta_description'] : '');
						$this->meta_keywords    = $result_line['meta_keywords'];
						
						$this->createProperty('current_page', '');
						$this->current_page['id']                 	 = $result_line['id'];
						$this->current_page['id_archive']          	 = $result_line['id_archive'];
						$this->current_page['idma']          	 	 = $result_line['idma'];
						$this->current_page['title']                 = $result_line['name'];
						$this->current_page['title_top']             = $result_line['top_title'];
						$this->current_page['description']           = $result_line['description'];
						$this->current_page['date_add']              = $result_line['date_add'];
						$this->current_page['show_image_in_body']    = $result_line['show_image_in_body'];
						
						$this->current_page['show_custom_menu']      = $result_line['show_custom_menu'];
						$this->current_page['custom_menu_title']     = $result_line['custom_menu_title'];
						$this->current_page['custom_menu']     	     = $result_line['custom_menu'];						
						
						//$this->current_page['top_image']    		 = (!empty($result_line['top_image']) ? FE_CropImage($result_line['top_image'], 1920, 325) : __URL__.'app-content/img/banner-top-1920x325.jpg');
						//$this->current_page['top_image_opacity']     = $result_line['top_image_opacity'];
						
						$this->current_page['featured_image_org']    = $result_line['featured_image'];
						$this->current_page['featured_image']        = (!empty($result_line['featured_image']) ? FE_CropImage($result_line['featured_image'], 720) : '');
						$this->current_page['image_description']     = $result_line['image_description'];
						
						$this->current_page['show_left_contact']    = $result_line['show_right_contact'];
						$this->current_page['contact_title']    	 = $result_line['contact_title'];
						$this->current_page['contact_address']    	 = $result_line['contact_address'];
						$this->current_page['contact_phone']    	 = $result_line['contact_phone'];
						$this->current_page['contact_email']    	 = $result_line['contact_email'];
						$this->current_page['contact_info']    	 	 = $result_line['contact_info'];
						
						$this->current_page['show_right_program']    = $result_line['show_right_program'];
						$this->current_page['program_title']    	 = $result_line['program_title'];
						$this->current_page['program']    	 		 = $result_line['program_sectie']; /* json */
						
						$this->current_page['show_bottom_galeries']  = $result_line['show_bottom_galeries']; /* afiseaza galeria foto in dreapta */
						$this->current_page['gallery_name']  		 = $result_line['gallery_name'];
						
						$this->current_page['show_bottom_related']   = $result_line['show_bottom_related'];
						$this->current_page['related_name']  		 = $result_line['related_name'];
						
						
						$this->current_page['show_right_poze']       = $result_line['show_right_poze'];
						$this->current_page['show_right_events']     = $result_line['show_right_events'];
						$this->current_page['show_right_anunturi']   = $result_line['show_right_impresii']; /* afiseaza anunturi in stanga */
						
						$this->current_page['redirect_to']           = $result_line['redirect_to'];
						
						//$this->current_page['right_photos']      	 =  ($this->current_page['show_right_poze'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						$this->current_page['tabs']           	     =  $this->return_article_tabs( $result_line['id']);    /* array */
						$this->current_page['subarticles']           =  $this->return_article_subarticles($result_line['id'], $result_line['idma'], $result_line['slug']); /* array */
												
						/* -------------------------------------------------- */						
						$this->current_page['right_photos']      	 =  ($this->current_page['show_bottom_galeries'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						if ($this->current_page['show_bottom_galeries']!=0) {
								
								/*
								$this->current_page['categ_gallery']         = array();
								$query = "SELECT id, idma, name FROM el_galerii WHERE idma=".$result_line['id']." ORDER BY display_index ASC, date_add DESC";
								$result = $oDB->db_query($query);
								$list_categ_gallery_ids = '';
								$i = 0;
								while ($result_line = $oDB->db_fetch_array($result)) {
									$id_categ_gallery = $result_line['id'];
									$this->current_page['categ_gallery']["$id_categ_gallery"]["id"]   = $result_line['id'];
									$this->current_page['categ_gallery']["$id_categ_gallery"]["name"] = $result_line['name'];
									$list_categ_gallery_ids .= ($i>0 ? ',' : '').$result_line['id'];
									$i++;
								}
								
								if (!empty($list_categ_gallery_ids)) {
									$this->createProperty('gallery', '');
									$query = "SELECT id, id_archive, file, description FROM el_gallery WHERE id_archive IN ($list_categ_gallery_ids) ORDER BY date_add DESC";
									$result = $oDB->db_query($query);
									while ($result_line = $oDB->db_fetch_array($result)) {
										$id         = $result_line['id'];									
										$this->gallery["$id"]['file']        = $result_line['file'];
										$this->gallery["$id"]['id_archive']  = $result_line['id_archive'];
										$this->gallery["$id"]['description'] = $result_line['description'];
									}
								}
								*/
						}
						/* -------------------------------------------------- */
						if ($this->current_page['show_bottom_related']!=0) {
							$this->createProperty('related', '');
							$this->related = $this->return_related_articles($this->current_page['id'], $this->current_page['id_archive']);
						}
						/* -------------------------------------------------- */
						if ($this->current_page['show_right_events']!=0) {
							$this->createProperty('events', '');
							$this->events = $this->return_last_events(3);
						}
						/* -------------------------------------------------- */
						
						$this->og_title         = $this->meta_title;
						$this->og_description   = $this->meta_description;
						$this->og_image         = (!empty($result_line['featured_image']) ? $result_line['featured_image'] : $this->settings['photo_facebook']);						
						
					} else {
						$ERROR_CODE = 404;
					}
						
					if (!$ERROR_CODE) {
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_info_event.php');
						include(__APPFILESPATH__.'footer.php');
					}
		    		break;
					/* ----------------------------------------- */					
			case 32: 
					/* afiseaza lista anunturi */
					$this->createProperty('items_no', 0);
					$query="SELECT count(*) as items_no FROM el_articles 
					WHERE el_articles.visible!=0 AND  el_articles.id_archive=40"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_ADS_NO_PER_PAGE;
					$items_no = EC_ADS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->section_title    = 'Anunturi';
						$this->meta_title       = 'Anunturi '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Anunturi, Muzeul Brailei Carol';
						$this->og_description   = '';
						
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_ads.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;
					/* ----------------------------------------- */
					
					/* ----------------------------------------- */
			case 33: 
					/* afiseaza detalii eveniment */
					$query = "
					SELECT el_articles.* 
					FROM el_articles 
					WHERE el_articles.slug='$this->idn' AND el_articles.id_archive=40";
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
						
						$this->category_title = 'Anunturi';
						$this->category_link  = $this->return_link_to_anunturi();
						$show_categ_date      = true;
						
						$this->meta_title       = (!empty($result_line['meta_title']) ? $result_line['meta_title'] : strip_tags($result_line['name']));
						$this->meta_description = (!empty($result_line['meta_description']) ? $result_line['meta_description'] : '');
						$this->meta_keywords    = $result_line['meta_keywords'];
						
						$this->createProperty('current_page', '');
						$this->current_page['id']                 	 = $result_line['id'];
						$this->current_page['id_archive']          	 = $result_line['id_archive'];
						$this->current_page['idma']          	 	 = $result_line['idma'];
						$this->current_page['title']                 = $result_line['name'];
						$this->current_page['title_top']             = $result_line['top_title'];
						$this->current_page['description']           = $result_line['description'];
						$this->current_page['date_add']              = $result_line['date_add'];
						$this->current_page['show_image_in_body']    = $result_line['show_image_in_body'];
						
						//$this->current_page['top_image']    		 = (!empty($result_line['top_image']) ? FE_CropImage($result_line['top_image'], 1920, 325) : __URL__.'app-content/img/banner-top-1920x325.jpg');
						//$this->current_page['top_image_opacity']     = $result_line['top_image_opacity'];
						
						$this->current_page['featured_image_org']    = $result_line['featured_image'];
						$this->current_page['featured_image']        = (!empty($result_line['featured_image']) ? FE_CropImage($result_line['featured_image'], 720) : '');
						$this->current_page['image_description']     = $result_line['image_description'];
						
						$this->current_page['show_left_contact']    = $result_line['show_right_contact'];
						$this->current_page['contact_title']    	 = $result_line['contact_title'];
						$this->current_page['contact_address']    	 = $result_line['contact_address'];
						$this->current_page['contact_phone']    	 = $result_line['contact_phone'];
						$this->current_page['contact_email']    	 = $result_line['contact_email'];
						$this->current_page['contact_info']    	 	 = $result_line['contact_info'];
						
						$this->current_page['show_right_program']    = $result_line['show_right_program'];
						$this->current_page['program_title']    	 = $result_line['program_title'];
						$this->current_page['program']    	 		 = $result_line['program_sectie']; /* json */
						
						$this->current_page['show_bottom_galeries']  = $result_line['show_bottom_galeries']; /* afiseaza galeria foto in dreapta */
						$this->current_page['gallery_name']  		 = $result_line['gallery_name'];
						
						$this->current_page['show_bottom_related']   = $result_line['show_bottom_related'];
						$this->current_page['related_name']  		 = $result_line['related_name'];
						
						
						$this->current_page['show_right_poze']       = $result_line['show_right_poze'];
						$this->current_page['show_right_events']     = $result_line['show_right_events'];
						$this->current_page['show_right_anunturi']   = $result_line['show_right_impresii']; /* afiseaza anunturi in stanga */
						
						$this->current_page['redirect_to']           = $result_line['redirect_to'];
						
						//$this->current_page['right_photos']      	 =  ($this->current_page['show_right_poze'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						$this->current_page['tabs']           	     =  $this->return_article_tabs( $result_line['id']);    /* array */
						$this->current_page['subarticles']           =  $this->return_article_subarticles($result_line['id'], $result_line['idma'], $result_line['slug']); /* array */
												
						/* -------------------------------------------------- */						
						$this->current_page['right_photos']      	 =  ($this->current_page['show_bottom_galeries'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						if ($this->current_page['show_bottom_galeries']!=0) {
								
								/*
								$this->current_page['categ_gallery']         = array();
								$query = "SELECT id, idma, name FROM el_galerii WHERE idma=".$result_line['id']." ORDER BY display_index ASC, date_add DESC";
								$result = $oDB->db_query($query);
								$list_categ_gallery_ids = '';
								$i = 0;
								while ($result_line = $oDB->db_fetch_array($result)) {
									$id_categ_gallery = $result_line['id'];
									$this->current_page['categ_gallery']["$id_categ_gallery"]["id"]   = $result_line['id'];
									$this->current_page['categ_gallery']["$id_categ_gallery"]["name"] = $result_line['name'];
									$list_categ_gallery_ids .= ($i>0 ? ',' : '').$result_line['id'];
									$i++;
								}
								
								if (!empty($list_categ_gallery_ids)) {
									$this->createProperty('gallery', '');
									$query = "SELECT id, id_archive, file, description FROM el_gallery WHERE id_archive IN ($list_categ_gallery_ids) ORDER BY date_add DESC";
									$result = $oDB->db_query($query);
									while ($result_line = $oDB->db_fetch_array($result)) {
										$id         = $result_line['id'];									
										$this->gallery["$id"]['file']        = $result_line['file'];
										$this->gallery["$id"]['id_archive']  = $result_line['id_archive'];
										$this->gallery["$id"]['description'] = $result_line['description'];
									}
								}
								*/
						}
						/* -------------------------------------------------- */
						if ($this->current_page['show_bottom_related']!=0) {
							$this->createProperty('related', '');
							$this->related = $this->return_related_articles($this->current_page['id'], $this->current_page['id_archive']);
						}
						/* -------------------------------------------------- */
						if ($this->current_page['show_right_events']!=0) {
							$this->createProperty('events', '');
							$this->events = $this->return_last_events(3);
						}
						/* -------------------------------------------------- */
						
						$this->og_title         = $this->meta_title;
						$this->og_description   = $this->meta_description;
						$this->og_image         = (!empty($result_line['featured_image']) ? $result_line['featured_image'] : $this->settings['photo_facebook']);						
						
					} else {
						$ERROR_CODE = 404;
					}
						
					if (!$ERROR_CODE) {
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_info.php');
						include(__APPFILESPATH__.'footer.php');
					}
		    		break;
					/* ----------------------------------------- */					
					
			case 4:
					/* afiseaza galerie video */				
					$this->createProperty('videogallery_items_no', 0);
					$query="SELECT count(*) as items_no FROM el_afise 
					WHERE el_afise.id_archive =40 AND el_afise.visible!=0"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->videogallery_items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_VIDEO_NO_PER_PAGE;
					$items_no = EC_VIDEO_NO_PER_PAGE;
					$ultimapagina   = ceil($this->videogallery_items_no/EC_VIDEO_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->meta_title       = 'Galerie Video '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_gallery_video.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;					
					/* ----------------------------------------- */	
			case 5:
					/* afiseaza colectia de afise */									
					$this->createProperty('afise_items_no', 0);
					/* query comentat - pentru versiunea 1 de afise; se va folosi impreuna cu page_afise.php*/
					/*
					$query="SELECT count(*) as items_no FROM el_afise 
					WHERE el_afise.id_archive =0 AND el_afise.visible!=0"; 
					*/
					$query="SELECT count(*) as items_no FROM el_gallery 
					WHERE el_gallery.id_archive =-100";
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->afise_items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_AFISE_NO_PER_PAGE;
					$items_no = EC_AFISE_NO_PER_PAGE;
					$ultimapagina   = ceil($this->afise_items_no/EC_AFISE_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->createProperty('events', '');
						$this->events = $this->return_last_events(3);						
						$this->meta_title       = 'Colectia de afise '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						
						include(__APPFILESPATH__.'header.php');
						//include(__APPFILESPATH__.'page_afise.php'); /* pentru varianta 1 de afise */
						include(__APPFILESPATH__.'page_afise2.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;								
					/* ----------------------------------------- */					
			case 6:
					/* afiseaza publicatii Braila */
					$this->createProperty('publicatii_items_no', 0);
					$query="SELECT count(*) as items_no FROM el_afise 
					WHERE el_afise.id_archive =30 AND el_afise.visible!=0"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->publicatii_items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_PUBLICATII_NO_PER_PAGE;
					$items_no = EC_PUBLICATII_NO_PER_PAGE;
					$ultimapagina   = ceil($this->publicatii_items_no/EC_PUBLICATII_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->createProperty('events', '');
						$this->events = $this->return_last_events(3);						
						$this->meta_title       = 'Publicatii BRĂILA '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_publicatii.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;								
					/* ----------------------------------------- */
			case 7:
					/* afiseaza galerie foto */
					$this->createProperty('years', array());
					if ($this->valid_photosgallery_categ($this->idn)) {
						$this->createProperty('photos_items_no', 0);						
						$sup_cond = (is_numeric($this->idn) ? ' AND year='.$this->idn : '');
						$query="SELECT count(*) as items_no FROM el_afise 
						WHERE el_afise.id_archive =10 AND el_afise.visible!=0 $sup_cond AND featured_image!=''"; 
						$result = $oDB->db_query($query);
						if ($result_line = $oDB->db_fetch_array($result)) {
						   $this->photos_items_no = $result_line['items_no'];
						} 						   
						
						$offset   = ($this->lpn-1)*EC_PHOTO_NO_PER_PAGE;
						$items_no = EC_PHOTO_NO_PER_PAGE;
						$ultimapagina   = ceil($this->photos_items_no/EC_PHOTO_NO_PER_PAGE);
						if ($this->lpn<=$ultimapagina) {
							$this->createProperty('events', '');
							$this->events = $this->return_last_events(3);						
							if (($this->idn=='toate') && ($this->lpn==1)) {
								$this->meta_title       = 'Galerie foto | Muzeul Brailei Carol I';
							} else {
								$this->meta_title       = 'Galerie Foto '.' - '.$this->idn.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
							}														
							$this->meta_description = '';
							$this->meta_keywords    = '';
							
							include(__APPFILESPATH__.'header.php');
							include(__APPFILESPATH__.'page_gallery_photo.php');
							include(__APPFILESPATH__.'footer.php');			        					
						} else {
							$ERROR_CODE = 404;
						}
					} else {
						$ERROR_CODE = 404;
					}
		    		break;											
					/* ----------------------------------------- */
			case 8:
					/* afiseaza carti editura Istros */
					$this->createProperty('years', array());
					$this->createProperty('istros_items_no', 0);
					$sup_cond = '';
					switch ($this->idn) {
						case 'periodice':
							$sup_cond = ' AND idma=31';
							break;
						case 'arheologie':
							$sup_cond = ' AND idma=32';
							break;
						case 'istorie-si-memorialistica':
							$sup_cond = ' AND idma=33';
							break;
						case 'albume-si-multimedia':
							$sup_cond = ' AND idma=34';
							break;							
					}					
					
					$query="SELECT count(*) as items_no FROM el_afise 
					WHERE el_afise.id_archive =20 AND el_afise.visible!=0 $sup_cond AND featured_image!=''"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->istros_items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_ISTROS_NO_PER_PAGE;
					$items_no = EC_ISTROS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->istros_items_no/EC_ISTROS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->createProperty('events', '');
						$this->events = $this->return_last_events(3);						
						if (($this->idn=='toate') && ($this->lpn==1)) {
							$this->meta_title       = 'Publicatii Editura Istros | Muzeul Brailei Carol I';
						} else {
							$this->meta_title       = 'Publicatii Editura Istros '.' - '.$this->idn.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						}
						$this->meta_description = '';
						$this->meta_keywords    = '';
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_istros.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;																
					/* ----------------------------------------- */	
					//88
			case 88:
					/* afiseaza carti editura Istros */
					$this->createProperty('years', array());
					$this->createProperty('istros_items_no', 0);
					
					$query="SELECT count(*) as items_no FROM el_gallery 
					WHERE el_gallery.id_archive =-200 AND el_gallery.visible!=0"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->istros_items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_ISTROS_NO_PER_PAGE;
					$items_no = EC_ISTROS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->istros_items_no/EC_ISTROS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->createProperty('events', '');
						$this->events = $this->return_last_events(3);						
						if ($this->lpn==1) {
							$this->meta_title       = 'Publicatii Editura Istros | Muzeul Brailei Carol I';
						} else {
							$this->meta_title       = 'Publicatii Editura Istros '.' - '.($this->lpn!=1 ? 'Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						}
						$this->meta_description = '';
						$this->meta_keywords    = '';
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_istros2.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;																					
					/* ----------------------------------------- */	
			case 9: 
					/* afiseaza stiri si evenimente */
					$this->createProperty('news_items_no', 0);
					$query="SELECT count(*) as items_no FROM el_cronici 
					WHERE el_cronici.id_archive=10 AND el_cronici.visible!=0"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->news_items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_NEWS_NO_PER_PAGE;
					$items_no = EC_NEWS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->news_items_no/EC_NEWS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->meta_title       = 'Stiri si evenimente'.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Teatrul Dramatic Fani Tardini Galati';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Stiri si evenimente ! Teatrul Dramatic Fani Tardini';
						$this->og_description   = '';
						
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_news.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;					
					/* ----------------------------------------- */
			case 10: 
					/* afiseaza lista informatii de interes public */
					$this->createProperty('items_no', 0);
					$query="SELECT count(*) as items_no FROM el_articles 
					WHERE el_articles.visible!=0 AND  el_articles.id_archive=50"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_INTERES_NO_PER_PAGE;
					$items_no = EC_INTERES_NO_PER_PAGE;
					$ultimapagina   = ceil($this->items_no/EC_INTERES_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->section_title    = 'Informații de interes public';
						$this->meta_title       = 'Informatii de interes public'.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Informatii de interes public, Muzeul Brailei Carol |';
						$this->og_description   = '';
						
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_interes.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;					
					/* ----------------------------------------- */
			case 11: 
					/* afiseaza detalii articol interes public */
					$query = "
					SELECT el_articles.* 
					FROM el_articles 
					WHERE el_articles.slug='$this->idn' AND el_articles.id_archive=50";
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
						
						$this->category_title = 'Informații de interes public';
						$this->category_link  = $this->return_link_to_interes_list();
						$show_categ_date      = true;
						
						$this->meta_title       = (!empty($result_line['meta_title']) ? $result_line['meta_title'] : strip_tags($result_line['name']));
						$this->meta_description = (!empty($result_line['meta_description']) ? $result_line['meta_description'] : '');
						$this->meta_keywords    = $result_line['meta_keywords'];
						
						$this->createProperty('current_page', '');
						$this->current_page['id']                 	 = $result_line['id'];
						$this->current_page['id_archive']          	 = $result_line['id_archive'];
						$this->current_page['idma']          	 	 = $result_line['idma'];
						$this->current_page['title']                 = $result_line['name'];
						$this->current_page['title_top']             = $result_line['top_title'];
						$this->current_page['description']           = $result_line['description'];
						$this->current_page['date_add']              = $result_line['date_add'];
						$this->current_page['show_image_in_body']    = $result_line['show_image_in_body'];
						
						$this->current_page['show_custom_menu']      = $result_line['show_custom_menu'];
						$this->current_page['custom_menu_title']     = $result_line['custom_menu_title'];
						$this->current_page['custom_menu']     	     = $result_line['custom_menu'];						
						
						//$this->current_page['top_image']    		 = (!empty($result_line['top_image']) ? FE_CropImage($result_line['top_image'], 1920, 325) : __URL__.'app-content/img/banner-top-1920x325.jpg');
						//$this->current_page['top_image_opacity']     = $result_line['top_image_opacity'];
						
						$this->current_page['featured_image_org']    = $result_line['featured_image'];
						$this->current_page['featured_image']        = (!empty($result_line['featured_image']) ? FE_CropImage($result_line['featured_image'], 720) : '');
						$this->current_page['image_description']     = $result_line['image_description'];
						
						$this->current_page['show_left_contact']    = $result_line['show_right_contact'];
						$this->current_page['contact_title']    	 = $result_line['contact_title'];
						$this->current_page['contact_address']    	 = $result_line['contact_address'];
						$this->current_page['contact_phone']    	 = $result_line['contact_phone'];
						$this->current_page['contact_email']    	 = $result_line['contact_email'];
						$this->current_page['contact_info']    	 	 = $result_line['contact_info'];
						
						$this->current_page['show_right_program']    = $result_line['show_right_program'];
						$this->current_page['program_title']    	 = $result_line['program_title'];
						$this->current_page['program']    	 		 = $result_line['program_sectie']; /* json */
						
						$this->current_page['show_bottom_galeries']  = $result_line['show_bottom_galeries']; /* afiseaza galeria foto in dreapta */
						$this->current_page['gallery_name']  		 = $result_line['gallery_name'];
						
						$this->current_page['show_bottom_related']   = $result_line['show_bottom_related'];
						$this->current_page['related_name']  		 = $result_line['related_name'];
						
						
						$this->current_page['show_right_poze']       = $result_line['show_right_poze'];
						$this->current_page['show_right_events']     = $result_line['show_right_events'];
						$this->current_page['show_right_anunturi']   = $result_line['show_right_impresii']; /* afiseaza anunturi in stanga */
						
						$this->current_page['redirect_to']           = $result_line['redirect_to'];
						
						//$this->current_page['right_photos']      	 =  ($this->current_page['show_right_poze'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						$this->current_page['tabs']           	     =  $this->return_article_tabs( $result_line['id']);    /* array */
						$this->current_page['subarticles']           =  $this->return_article_subarticles($result_line['id'], $result_line['idma'], $result_line['slug']); /* array */
												
						/* -------------------------------------------------- */						
						$this->current_page['right_photos']      	 =  ($this->current_page['show_bottom_galeries'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						/* -------------------------------------------------- */
						if ($this->current_page['show_bottom_related']!=0) {
							$this->createProperty('related', '');
							$this->related = $this->return_related_articles($this->current_page['id'], $this->current_page['id_archive']);
						}
						/* -------------------------------------------------- */
						if ($this->current_page['show_right_events']!=0) {
							$this->createProperty('events', '');
							$this->events = $this->return_last_events(3);
						}
						/* -------------------------------------------------- */
						
						$this->og_title         = $this->meta_title;
						$this->og_description   = $this->meta_description;
						$this->og_image         = (!empty($result_line['featured_image']) ? $result_line['featured_image'] : $this->settings['photo_facebook']);						
						
					} else {
						$ERROR_CODE = 404;
					}
						
					if (!$ERROR_CODE) {
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_info.php');
						include(__APPFILESPATH__.'footer.php');
					}
		    		break;					
					/* ----------------------------------------- */
			case 12: 
					/* afisare pagina NOT FOUND */					
					$this->meta_title       = 'Pagina nu exista | Asociatia SOS Umanitar';
					$this->meta_description = 'Pagina pe care doresti sa o accesezi nu exista, este posibil sa fi fost stearsa din website.';
					$this->meta_keywords    = '';
					$this->og_title         = $this->meta_title;
					$this->og_description   = $this->meta_description;
					$this->og_image         = $this->settings['photo_facebook'];
		    		include(__APPFILESPATH__.'header.php');
		    		include(__APPFILESPATH__.'page_404.php');
		    		include(__APPFILESPATH__.'footer.php');			        								
		    		break;			
					/* ----------------------------------------- */
					
			case 13: 
					/* afisare pagina CONTACT */					
					$this->meta_title       = 'Contact | S.O.S. Umanitar Association';
					$this->meta_description = 'S.O.S. Umanitar Association. Aleea melodiei, nr. 8, bloc b8, sc. 5, ap. 49, camera 3, Galati Romania';
					$this->meta_keywords    = '';
					$this->og_title         = $this->meta_title;
					$this->og_description   = $this->meta_description;
					//$this->og_image         = $this->fp['photo_facebook'];					
		    		include(__APPFILESPATH__.'header.php');
		    		include(__APPFILESPATH__.'page_contact.php');
		    		include(__APPFILESPATH__.'footer.php');			        								
		    		break;			
					/* ----------------------------------------- */
			case 133: 
					/* afisare pagina DONEAZA */
					$this->meta_title       = 'Donate now | S.O.S. Umanitar Association';
					$this->meta_description = 'S.O.S. Umanitar Association, with the headquarters in Galati-Romania, is asking you to donate via PayPal for supporting malformed children, homeless children, etc';
					$this->meta_keywords    = '';
					$this->og_title         = $this->meta_title;
					$this->og_description   = $this->meta_description;
					//$this->og_image         = $this->fp['photo_facebook'];					
		    		include(__APPFILESPATH__.'header.php');
		    		include(__APPFILESPATH__.'page_doneaza.php');
		    		include(__APPFILESPATH__.'footer.php');			        								
		    		break;			
					/* ----------------------------------------- */
			case 1333: 
					/* afisare pagina THANK YOU */
					$this->meta_title       = 'Thank You | S.O.S. Umanitar Association';
					$this->meta_description = 'Thank you for your generosity.';
					$this->meta_keywords    = '';
					$this->og_title         = $this->meta_title;
					$this->og_description   = $this->meta_description;
					//$this->og_image         = $this->fp['photo_facebook'];					
		    		include(__APPFILESPATH__.'header.php');
		    		include(__APPFILESPATH__.'page_thank_you.php');
		    		include(__APPFILESPATH__.'footer.php');			        								
		    		break;			
					/* ----------------------------------------- */
			case 13333: 
					/* afisare pagina CANCEL */
					$this->meta_title       = 'Donation operation failed | S.O.S. Umanitar Association';
					$this->meta_description = 'Operation failed. Please, try later';
					$this->meta_keywords    = '';
					$this->og_title         = $this->meta_title;
					$this->og_description   = $this->meta_description;
					//$this->og_image         = $this->fp['photo_facebook'];					
		    		include(__APPFILESPATH__.'header.php');
		    		include(__APPFILESPATH__.'page_cancel.php');
		    		include(__APPFILESPATH__.'footer.php');			        								
		    		break;			
					/* ----------------------------------------- */
					
			case 14: 
					/* afisare articole */					
					$this->meta_title       = 'Articole psihologie | Asociatia SOS Umanitar';
					$this->meta_description = '';
					$this->meta_keywords    = '';
					$this->og_title         = $this->meta_title;
					$this->og_description   = $this->meta_description;
					$this->og_image         = $this->settings['photo_facebook'];
		    		include(__APPFILESPATH__.'header.php');
		    		include(__APPFILESPATH__.'page_list_articles.php');
		    		include(__APPFILESPATH__.'footer.php');			        								
		    		break;			
					/* ----------------------------------------- */
					
			case 100: 
					/* afiseaza lista anunturi achizitii publice */
					$this->createProperty('items_no', 0);
					$query="SELECT count(*) as items_no FROM el_articles 
					WHERE el_articles.visible!=0 AND  el_articles.id_archive=40 AND type_ads=1"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_ADS_NO_PER_PAGE;
					$items_no = EC_ADS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->section_title    = 'Anunturi achizitii publice';
						$this->meta_title       = 'Anunturi '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Anunturi, Muzeul Brailei Carol';
						$this->og_description   = '';
						
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_ads_achizitii.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;
					/* ----------------------------------------- */
			case 102: 
					/* afiseaza lista anunturi achizitii publice */
					$this->createProperty('items_no', 0);
					$query="SELECT count(*) as items_no FROM el_articles 
					WHERE el_articles.visible!=0 AND  el_articles.id_archive=40 AND type_ads=1"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_ADS_NO_PER_PAGE;
					$items_no = EC_ADS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->section_title    = 'Anunturi achizitii publice';
						$this->meta_title       = 'Anunturi achizitii publice '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Anunturi achizitii publice, Muzeul Brailei Carol';
						$this->og_description   = '';
						
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_ads_achizitii.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;
					/* ----------------------------------------- */
			case 104: 
					/* afiseaza lista anunturi angajari */
					$this->createProperty('items_no', 0);
					$query="SELECT count(*) as items_no FROM el_articles 
					WHERE el_articles.visible!=0 AND  el_articles.id_archive=40 AND type_ads=2"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_ADS_NO_PER_PAGE;
					$items_no = EC_ADS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->section_title    = 'Anunturi angajari';
						$this->meta_title       = 'Anunturi angajari '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Anunturi angajari, Muzeul Brailei Carol';
						$this->og_description   = '';
						
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_ads_angajari.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;
					/* ----------------------------------------- */
			case 106: 
					/* afiseaza lista anunturi diverse */
					$this->createProperty('items_no', 0);
					$query="SELECT count(*) as items_no FROM el_articles 
					WHERE el_articles.visible!=0 AND  el_articles.id_archive=40 AND type_ads=0"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_ADS_NO_PER_PAGE;
					$items_no = EC_ADS_NO_PER_PAGE;
					$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->section_title    = 'Anunturi diverse';
						$this->meta_title       = 'Anunturi diverse '.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Anunturi diverse, Muzeul Brailei Carol';
						$this->og_description   = '';
						
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_ads_diverse.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;
					/* ----------------------------------------- */
			case 108: 
					/* afiseaza lista informatii despre Braila */
					$this->createProperty('items_no', 0);
					$query="SELECT count(*) as items_no FROM el_articles 
					WHERE el_articles.visible!=0 AND  el_articles.id_archive=60"; 
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					   $this->items_no = $result_line['items_no'];
					} 						   
					
					$offset   = ($this->lpn-1)*EC_BRAILA_NO_PER_PAGE;
					$items_no = EC_BRAILA_NO_PER_PAGE;
					$ultimapagina   = ceil($this->items_no/EC_BRAILA_NO_PER_PAGE);
					if ($this->lpn<=$ultimapagina) {
						$this->section_title    = 'Informații despre Braila';
						$this->meta_title       = 'Informații despre Braila'.($this->lpn!=1 ? ' - Pag.'.$this->lpn : '').' | Muzeul Brailei Carol I';
						$this->meta_description = '';
						$this->meta_keywords    = '';
						$this->og_title         = 'Informații despre Braila, Muzeul Brailei Carol |';
						$this->og_description   = '';
						
						
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_braila.php');
						include(__APPFILESPATH__.'footer.php');			        					
					} else {
						$ERROR_CODE = 404;
					}
		    		break;					
					/* ----------------------------------------------- */
			case 109: 
					/* afiseaza detalii articol braila */
					$query = "
					SELECT el_articles.* 
					FROM el_articles 
					WHERE el_articles.slug='$this->idn' AND el_articles.id_archive=60";
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
						
						$this->category_title = 'Brăila';
						$this->category_link  = $this->return_link_to_braila();
						$show_categ_date      = true;
						
						$this->meta_title       = (!empty($result_line['meta_title']) ? $result_line['meta_title'] : strip_tags($result_line['name']));
						$this->meta_description = (!empty($result_line['meta_description']) ? $result_line['meta_description'] : '');
						$this->meta_keywords    = $result_line['meta_keywords'];
						
						$this->createProperty('current_page', '');
						$this->current_page['id']                 	 = $result_line['id'];
						$this->current_page['id_archive']          	 = $result_line['id_archive'];
						$this->current_page['idma']          	 	 = $result_line['idma'];
						$this->current_page['title']                 = $result_line['name'];
						$this->current_page['title_top']             = $result_line['top_title'];
						$this->current_page['description']           = $result_line['description'];
						$this->current_page['date_add']              = $result_line['date_add'];
						$this->current_page['show_image_in_body']    = $result_line['show_image_in_body'];

						$this->current_page['show_custom_menu']      = $result_line['show_custom_menu'];
						$this->current_page['custom_menu_title']     = $result_line['custom_menu_title'];
						$this->current_page['custom_menu']     	     = $result_line['custom_menu'];
						
						
						//$this->current_page['top_image']    		 = (!empty($result_line['top_image']) ? FE_CropImage($result_line['top_image'], 1920, 325) : __URL__.'app-content/img/banner-top-1920x325.jpg');
						//$this->current_page['top_image_opacity']     = $result_line['top_image_opacity'];
						
						$this->current_page['featured_image_org']    = $result_line['featured_image'];
						$this->current_page['featured_image']        = (!empty($result_line['featured_image']) ? FE_CropImage($result_line['featured_image'], 720) : '');
						$this->current_page['image_description']     = $result_line['image_description'];
						
						$this->current_page['show_left_contact']    = $result_line['show_right_contact'];
						$this->current_page['contact_title']    	 = $result_line['contact_title'];
						$this->current_page['contact_address']    	 = $result_line['contact_address'];
						$this->current_page['contact_phone']    	 = $result_line['contact_phone'];
						$this->current_page['contact_email']    	 = $result_line['contact_email'];
						$this->current_page['contact_info']    	 	 = $result_line['contact_info'];
						
						$this->current_page['show_right_program']    = $result_line['show_right_program'];
						$this->current_page['program_title']    	 = $result_line['program_title'];
						$this->current_page['program']    	 		 = $result_line['program_sectie']; /* json */
						
						$this->current_page['show_bottom_galeries']  = $result_line['show_bottom_galeries']; /* afiseaza galeria foto in dreapta */
						$this->current_page['gallery_name']  		 = $result_line['gallery_name'];
						
						$this->current_page['show_bottom_related']   = $result_line['show_bottom_related'];
						$this->current_page['related_name']  		 = $result_line['related_name'];
						
						
						$this->current_page['show_right_poze']       = $result_line['show_right_poze'];
						$this->current_page['show_right_events']     = $result_line['show_right_events'];
						$this->current_page['show_right_anunturi']   = $result_line['show_right_impresii']; /* afiseaza anunturi in stanga */
						
						$this->current_page['redirect_to']           = $result_line['redirect_to'];
						
						//$this->current_page['right_photos']      	 =  ($this->current_page['show_right_poze'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						$this->current_page['tabs']           	     =  $this->return_article_tabs( $result_line['id']);    /* array */
						$this->current_page['subarticles']           =  $this->return_article_subarticles($result_line['id'], $result_line['idma'], $result_line['slug']); /* array */
												
						/* -------------------------------------------------- */						
						$this->current_page['right_photos']      	 =  ($this->current_page['show_bottom_galeries'] ? $this->return_article_gallery( $result_line['id']) : array()); /* array */
						/* -------------------------------------------------- */
						if ($this->current_page['show_bottom_related']!=0) {
							$this->createProperty('related', '');
							$this->related = $this->return_related_articles($this->current_page['id'], $this->current_page['id_archive']);
						}
						/* -------------------------------------------------- */
						if ($this->current_page['show_right_events']!=0) {
							$this->createProperty('events', '');
							$this->events = $this->return_last_events(3);
						}
						/* -------------------------------------------------- */
						
						$this->og_title         = $this->meta_title;
						$this->og_description   = $this->meta_description;
						$this->og_image         = (!empty($result_line['featured_image']) ? $result_line['featured_image'] : $this->settings['photo_facebook']);						
						
					} else {
						$ERROR_CODE = 404;
					}
						
					if (!$ERROR_CODE) {
						include(__APPFILESPATH__.'header.php');
						include(__APPFILESPATH__.'page_info.php');
						include(__APPFILESPATH__.'footer.php');
					}
		    		break;
					
					
		}
		//echo $this->pn; die(' xxx');
		if ($ERROR_CODE >0) {
			switch ($ERROR_CODE) {
				case 404:
					el_redirect($this->return_link_to_notfound());
					//echo $this->pn; die(' xxx');
					break;
			}			
		}
	}	
	/* ------------------------------------------------------------------------------------- */
	public function valid_photosgallery_categ($categ_slug) {
		$valid = false;
		
		global $oDB;
		$query = "SELECT DISTINCT year FROM el_afise WHERE id_archive=10 ORDER BY year ASC";
		$result = $oDB->db_query($query);		
		while ($result_line = $oDB->db_fetch_array($result)) {
			$this->years[] = $result_line['year'];
			if ($categ_slug==$result_line['year']) {
				$valid = true;				
			}
		}
		if (!$valid) {
			if ($categ_slug=='toate') { $valid = true;}
		}
		return $valid;
	}
	/* ------------------------------------------------------------------------------------- */
	public function valid_edituraistros_categ($categ_slug) {
		$valid = false;
		
		global $oDB;
		$query = "SELECT DISTINCT year FROM el_afise WHERE id_archive=20 ORDER BY year ASC";
		$result = $oDB->db_query($query);		
		while ($result_line = $oDB->db_fetch_array($result)) {
			$this->years[] = $result_line['year'];
			if ($categ_slug==$result_line['year']) {
				$valid = true;				
			}
		}
		if (!$valid) {
			if ($categ_slug=='toate') { $valid = true;}
		}
		return $valid;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function return_article_gallery($id_article) {
		global $oDB;
		$query = "
			SELECT id, file, description 
			FROM el_gallery 
			WHERE visible!=0 AND id_archive=$id_article 
			ORDER BY date_add DESC 
			LIMIT 1000
			";
		$result = $oDB->db_query($query);
		$gallery = array();
		$i = 0;
		while ($result_line = $oDB->db_fetch_array($result)) {
			$gallery[$i]['id']         		= $result_line['id'];
			$gallery[$i]['file']           	= $result_line['file'];
			$gallery[$i]['description'] 	= $result_line['description'];
			$i++;
		}		
		return $gallery;
	}						
	/* ------------------------------------------------------------------------------------- */	
	public function return_last_photos($no=6){
		global $oDB;
		$query = "
			SELECT name, description, featured_image, download AS label 
			FROM el_afise 
			WHERE id_archive=10 AND visible!=0 
			ORDER BY date_add DESC LIMIT $no";
			$result = $oDB->db_query($query);
			$i=0;
			$afise_list  = '';
			$img_list = '';
			$photos = array();
			$i = 0;
			while ($result_line = $oDB->db_fetch_array($result)) {
				$photos[$i]['name']           = $result_line['name'];
				$photos[$i]['description'] 	  = $result_line['description'];
				$photos[$i]['featured_image'] = $result_line['featured_image'];
				$photos[$i]['label'] 	  	  = $result_line['label'];				
				$i++;
			}
		return $photos;
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_article_tabs($id_article) {
		global $oDB;
		$query = "SELECT * FROM el_tabs WHERE el_tabs.idma = $id_article ORDER BY display_index ASC, date_add DESC";
		$result = $oDB->db_query($query);
		$tabs = array();
		$i = 0;		
		while ($result_line = $oDB->db_fetch_array($result)) {
			$tabs[$i]['name']        = $result_line['name'];
			$tabs[$i]['description'] = $result_line['description'];
			$i++;
		}
		return $tabs;
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_article_subarticles($id_article, $idma_article, $slug_article) {
		global $oDB;
		$idma = ($idma_article==0 ? $id_article : $idma_article);
		$query = "SELECT name, slug, redirect_to FROM el_articles WHERE el_articles.idma = $idma ORDER BY display_index ASC, date_add DESC";
		$result = $oDB->db_query($query);
		$subarticles = array();
		$i = 0;		
		while ($result_line = $oDB->db_fetch_array($result)) {
			$subarticles[$i]['name'] = $result_line['name'];
			$subarticles[$i]['slug'] = $result_line['slug'];
			$subarticles[$i]['link'] = $this->return_link_to_subarticle($result_line['slug'], $slug_article, $result_line['redirect_to']);
			$i++;
		}
		return $subarticles;
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_article_subarticles2($id_article, $idma_article, $slug_article, $slug_categ) {
		global $oDB;
		$idma = ($idma_article==0 ? $id_article : $idma_article);
		$query = "SELECT name, slug, redirect_to FROM el_articles WHERE el_articles.idma = $idma ORDER BY display_index ASC, date_add DESC";
		$result = $oDB->db_query($query);
		$subarticles = array();
		$i = 0;		
		while ($result_line = $oDB->db_fetch_array($result)) {
			$subarticles[$i]['name'] = $result_line['name'];
			$subarticles[$i]['slug'] = $result_line['slug'];
			$subarticles[$i]['link'] = $this->return_link_to_subarticle($result_line['slug'], $slug_categ, $result_line['redirect_to']);
			$i++;
		}
		return $subarticles;
	}	
	/* ------------------------------------------------------------------------------------- */
	public function return_related_articles($id_article, $id_archive, $type=0) {
		global $oDB;
		$id_archive = ((($id_archive==0) && ($id_archive==20)) ? 0 : $id_archive);
		$query = "
		SELECT name, featured_image, image_description, description, slug, redirect_to 
		FROM el_articles 
		WHERE el_articles.id_archive = $id_archive AND id!=$id_article AND type=$type 
		ORDER BY display_index ASC, date_add DESC 
		LIMIT 10";
		$result = $oDB->db_query($query);
		$related = array();
		$i = 0;		
		while ($result_line = $oDB->db_fetch_array($result)) {
			$related[$i]['title']             = $result_line['name'];
			$related[$i]['featured_image']    = $result_line['featured_image'];
			$related[$i]['image_description'] = $result_line['image_description'];
			$related[$i]['short_description'] = el_TruncateString($result_line['description'], 100);
			$related[$i]['link']              = '';//$this->return_link_to_subarticle($result_line['slug'], $slug_article, $result_line['redirect_to']);
			switch ($id_archive) {
				case  0: $related[$i]['link'] = $this->return_link_to_article( $result_line['slug'],  $result_line['redirect_to']); break;
				case 30: $related[$i]['link'] = $this->return_link_to_event( $result_line['slug'],  $result_line['redirect_to']); break;
				case 40: $related[$i]['link'] = $this->return_link_to_ads( $result_line['slug'],  $result_line['redirect_to']); break;
			}
			$i++;
		}
		return $related;
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function return_right_contact($display_type){
		$return_info ='';
		switch ($display_type) {
			case 1: 
			/* afiseaza contact general muzeu */
			$return_info = '
                            <div class="widget">
                                <div class="widget--title" data-ajax="tab">
                                    <h2 class="h4">CONTACT</h2>
									<i class="icon fa fa-map-marker"></i>
                                </div>                                
                                <div class="poll--widget" data-ajax-content="outer">
                                    <ul class="nav" data-ajax-content="inner">									
                                        <li class="title">
                                            <h3 class="h4"><i class="fa fa-map-marker"></i> <span class="fw_normal">'.$this->settings['company_address'].'</span></h3>
											<h3 class="h4"><i class="fa fa-phone"></i> <span class="fw_normal">'.$this->settings['company_phone'].'</span></h3>
											<h3 class="h4"><i class="fa fa-fax"></i> <span class="fw_normal">'.$this->settings['company_fax'].'</span></h3>
											<h3 class="h4"><i class="fa fa-envelope-open"></i> <span class="fw_normal">'.el_ret_safety_email($this->settings['company_email']).'</span></h3>
                                        </li>

                                        <li class="title">
                                                <button onclick="window.location.href=\''.$this->return_link_to_contact().'\'" type="button" class="btn btn-primary">Contact</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>'.PHP_EOL;
			break;
			case 2: 
			/* afiseaza contact personalizart articol */
			$return_info = '
                            <div class="widget">
                                <div class="widget--title" data-ajax="tab">
                                    <h2 class="h4">'.$this->current_page['contact_title'].'</h2>
									<i class="icon fa fa-map-marker"></i>
                                </div>                                
                                <div class="poll--widget" data-ajax-content="outer">
                                    <ul class="nav" data-ajax-content="inner">									
                                        <li class="title">
											'.((!empty($this->current_page['contact_address'])) ? '<h3 class="h4"><i class="fa fa-map-marker"></i> <span class="fw_normal">'.$this->current_page['contact_address'].'</span></h3>' : '').'
											'.((!empty($this->current_page['contact_phone'])) ? '<h3 class="h4"><i class="fa fa-phone"></i> <span class="fw_normal">'.$this->current_page['contact_phone'].'</span></h3>' : '').'
											'.((!empty($this->current_page['contact_email'])) ? '<h3 class="h4"><i class="fa fa-envelope-open"></i> <span class="fw_normal">'.el_ret_safety_email($this->current_page['contact_email']).'</span></h3>' : '').'
											'.((!empty($this->current_page['contact_info'])) ? '<h3 class="h4"><i class="fa fa-info"></i> <span class="fw_normal">'.$this->current_page['contact_info'].'</span></h3>' : '').'
                                        </li>

                                        <li class="title">
                                                <button onclick="window.location.href=\''.$this->return_link_to_contact().'\'" type="button" class="btn btn-primary">Contact</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>'.PHP_EOL;			
			break;
			
		}		
		return $return_info;
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_article_custom_menu() {
		$arr_menu  = json_decode($this->current_page['custom_menu'], true);	
		$i=0;
		$arr_info = array();
		foreach ($arr_menu as $key => $item) {
			if ( el_string_contain_substring($item['name'], 'meniu') ) {
				$arr_info[$i]['title'] = $item['value'];				
			}
			if ( el_string_contain_substring($item['name'], 'link') ) {
				$arr_info[$i]['link'] = $item['value'];
				$i++;
			}
		}
		$meniu = '
			<div class="widget">
				<div class="widget--title">
					<h2 class="h4">'.$this->current_page['custom_menu_title'].'</h2>
					<i class="icon fa fa-info-circle"></i>
				</div>
				<div class="links--widget">
					<ul class="nav">'.PHP_EOL;
		foreach ($arr_info as $key => $item) {
			$meniu .= '<li><a href="'.$item['link'].'" class="fa-angle-right">'.$item['title'].'</a></li>'.PHP_EOL;
		}
		$meniu .= '
					</ul>
				</div>
			</div>'.PHP_EOL;
		return $meniu;
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_right_program($display_type) {
		$ret_str = '';
		$arr_program = array();
		$title_program = 'Program de vizitare';
		switch ($display_type) {
			case 1: 
			/* afiseaza program general muzeu */
			$arr_program  = json_decode($this->settings['company_program'], true);		
			break;
			case 2: 
			/* afiseaza program general muzeu */
			$arr_program  = json_decode($this->current_page['program'], true);
			$title_program = $this->current_page['program_title'];
			break;
		}
		//print_r($arr_program);
		$arr_info = array();
		$i=0;
		foreach ($arr_program as $key => $item) {
			if ( el_string_contain_substring($item['name'], 'perioada') ) {
				$arr_info[$i]['perioada'] = $item['value'];				
			}
			if ( el_string_contain_substring($item['name'], 'ore') ) {
				$arr_info[$i]['ore'] = $item['value'];
			}
			if ( el_string_contain_substring($item['name'], 'observatii') ) {
				$arr_info[$i]['observatii'] = $item['value'];
				$i++;
			}
		}
		foreach ($arr_info as $key => $item) {
			$ret_str .= '
				<li>
					<!-- Post Item Start -->
					<div class="post--item post--layout-3">
						<div class="post--img">
							<a href="javascript:void(0);" class="thumb block_program">
								'.$item['perioada'].'
							</a>

							<div class="post--info">
								<div class="title">
									<h3 class="h4"><a href="javascript:void(0);" class="btn-link">'.$item['ore'].'</a></h3>
								</div>														
								<ul class="nav meta">
									<li><a href="javascript:void(0);">'.$item['observatii'].' </a></li>                                                                
								</ul>
							</div>
						</div>
					</div>
					<!-- Post Item End -->
				</li>'.PHP_EOL;
		}
		if (!empty($ret_str)) {
			$ret_str = '
                            <div class="widget">
                                <div class="widget--title" data-ajax="tab">
                                    <h2 class="h4">'.$title_program.'</h2>
									<i class="icon fa fa-clock-o"></i>									
                                </div>
                                <!-- List Widgets Start -->
                                <div class="list--widget list--widget-1" data-ajax-content="outer">
                                    <!-- Post Items Start -->
                                    <div class="post--items post--items-3">
                                        <ul class="nav" data-ajax-content="inner">
											'.$ret_str.'
                                        </ul>

                                        <!-- Preloader Start -->
                                        <div class="preloader bg--color-0--b" data-preloader="1">
                                            <div class="preloader--inner"></div>
                                        </div>
                                        <!-- Preloader End -->
                                    </div>
                                    <!-- Post Items End -->
                                </div>
                                <!-- List Widgets End -->
                            </div>'.PHP_EOL;
								
		}
		
		return ($display_type=!0 ? $ret_str : '');
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_last_events($events_no) {
		global $oDB;
		$query = "SELECT name, featured_image, slug, redirect_to, date_add FROM el_articles WHERE el_articles.id_archive=30 ORDER BY display_index ASC, date_add DESC LIMIT $events_no";
		$result = $oDB->db_query($query);
		$events = array();
		$i = 0;		
		while ($result_line = $oDB->db_fetch_array($result)) {
			$events[$i]['name'] = $result_line['name'];
			$events[$i]['link'] = $this->return_link_to_event($result_line['slug'], $result_line['redirect_to']);
			$events[$i]['date'] = el_MysqlDateTime_To_ShortRomanianDate_Literal($result_line['date_add']);
			$i++;
		}
		return $events;
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_news_ticker() {
		$events_list = '';
		foreach ($this->last_events as $key => $event) {
			$events_list .= '<li><h3 class="h3"><a href="'.$event['link'].'">'.el_TruncateString($event['name'],67).'</a></h3></li>'.PHP_EOL;
		}
		
		return '
        <div class="news--ticker">
            <div class="container">
                <div class="title">
                    <h2>Ultimele evenimente</h2>
                    <span>(Muzeul Brăilei „Carol I”)</span>
                </div>

                <div class="news-updates--list" data-marquee="true">
                    <ul class="nav">
						'.$events_list.'
                    </ul>
                </div>
            </div>
        </div>'.PHP_EOL;
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_widget_gallery($column_no, $arr_gallery) {
		$widget = '
			<div class="widget">
				<div class="widget--title">
					<h2 class="h4">Galerie foto</h2>
					<i class="icon fa fa-camera"></i>
				</div>											
				<!-- Ad Widget Start -->
				<div class="ad--widget">'.PHP_EOL;
		if (($column_no!=1) && ($column_no!=2)) $column_no=1;
		if ($column_no==2) { $widget .= '<div class="row">'.PHP_EOL;}
		if ($column_no==1) {
			foreach ($arr_gallery as $key => $item) {
				$widget .= '<a title="'.$item['description'].'" class="group_gallery_right" href="'.$item['file'].'"><img src="'.FE_CropImage($item['file'], 300, 250).'" alt=""></a>'.(!empty($item['description']) ? '<p>'.$item['description'].'</p>' : '').''.PHP_EOL;
			}	
		} else {
			foreach ($arr_gallery as $key => $item) {
				$widget .= '
							<div class="col-sm-6">
								<a title="'.$item['description'].'" class="group_gallery_right" href="'.$item['file'].'">
									<img src="'.FE_CropImage($item['file'], 150, 150).'" alt="">
								</a>
							</div>'.PHP_EOL;
			}				
		}
		if ($column_no==2) { $widget .= '</div>'.PHP_EOL;}
		$widget .= '
				</div>
			</div>'.PHP_EOL;
		return $widget;
	}
	/* ------------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------------- */
	public function return_paginator_video(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->videogallery_items_no/EC_VIDEO_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_video($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_video($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_video($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_video($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_video($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_video(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_video(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_video($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_video($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_video($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_video(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_video(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_video($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_video($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}		
	
	/* ------------------------------------------------------------------------------------- */
	// paginator afise
	public function return_paginator_afise(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->afise_items_no/EC_AFISE_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_afise($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_afise($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_afise($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_afise($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_afise($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_afise(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_afise(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_afise($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_afise($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_afise($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_afise(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_afise(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_afise($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_afise($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}		
	
	/* ------------------------------------------------------------------------------------- */
	// paginator publicatii BRAILA
	public function return_paginator_publicatii(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->publicatii_items_no/EC_PUBLICATII_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_publicatii($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_publicatii($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_publicatii($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_publicatii($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_publicatii($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_publicatii(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_publicatii(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_publicatii($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_publicatii($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_publicatii($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_publicatii(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_publicatii(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_publicatii($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_afise($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}		
	
	/* ------------------------------------------------------------------------------------- */
	// paginator galerie foto
	public function return_paginator_photos(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->photos_items_no/EC_PHOTO_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, 1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, 2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, 1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, 2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_photos($this->idn, $next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}		
	
	/* ------------------------------------------------------------------------------------- */
	// paginator istros
	public function return_paginator_istros(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->istros_items_no/EC_ISTROS_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, 1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, 2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, 1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, 2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_istros($this->idn, $next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}		
	
	/* ------------------------------------------------------------------------------------- */	
	// paginator istros 2
	public function return_paginator_istros2(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->istros_items_no/EC_ISTROS_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_istros2($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_istros2($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_istros2($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros2($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros2($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_istros2(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros2(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_istros2($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros2($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros2($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_istros2(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_istros2(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_istros2($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_istros2($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}		
	
	/* ------------------------------------------------------------------------------------- */	
	// interes public
	public function return_paginator_interes(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->items_no/EC_INTERES_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_interes_list($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_interes_list($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_interes_list($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_interes_list($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_interes_list($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_interes_list(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_interes_list(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_interes_list($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_interes_list($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_interes_list($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_interes_list(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_interes_list(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_interes_list($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_interes_list($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}		
	
	/* ------------------------------------------------------------------------------------- */	
	// braila
	public function return_paginator_braila(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->items_no/EC_BRAILA_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_braila($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_braila($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_braila($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_braila($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_braila($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_braila(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_braila(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_braila($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_braila($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_braila($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_braila(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_braila(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_braila($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_braila($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function return_paginator_evenimente(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->items_no/EC_EVENTS_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_events($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_events($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_events($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_events($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_events($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_events(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_events(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_events($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_events($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_events($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_events(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_events(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_events($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_events($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}		
	/* ------------------------------------------------------------------------------------- */
	// anunturi
	public function return_paginator_anunturi(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_anunturi($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_anunturi($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_anunturi($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}			
	/* ------------------------------------------------------------------------------------- */
	// anunturi achizitii
	public function return_paginator_anunturi_achizitii(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_anunturi_achizitii($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}				
	/* ------------------------------------------------------------------------------------- */
	// angajari
	public function return_paginator_anunturi_angajari(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_anunturi_angajari($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}				
	
	/* ------------------------------------------------------------------------------------- */
	public function return_paginator_anunturi_diverse(){
		$nrpag          = $this->lpn;
		$ultimapagina   = ceil($this->items_no/EC_ADS_NO_PER_PAGE);
        $lpm1           = $ultimapagina-1;
        $adiacente      = 2;
        $prev           = $nrpag - 1;
        $next           = $nrpag + 1; 
				
        if($ultimapagina > 1) {
            $output = '<ul class="pagination float--right">'.PHP_EOL; 
            //button inapoi
            
            if ($nrpag > 1) 
                $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($prev)."\">&larr;</a></li>\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-left\"></i></a></li>\n";    
            
            //pagini    
            if ($ultimapagina < 7 + ($adiacente * 2)) {    
                for ($counter = 1; $counter <= $ultimapagina; $counter++) {
                    if ($counter == $nrpag)
                        $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                    else
                        $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($counter)."\">$counter</a></li>\n"; 
                }
            }
            else if($ultimapagina > 5 + ($adiacente * 2)) {
                if($nrpag < 1 + ($adiacente * 2)) {
                    for ($counter = 1; $counter < 4 + ($adiacente * 2); $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($counter)."\">$counter</a></li>\n";
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($ultimapagina)."\">$ultimapagina</a></li>\n";        
                }
                elseif ($ultimapagina - ($adiacente * 2) > $nrpag && $nrpag > ($adiacente * 2)) {
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $nrpag - $adiacente; $counter <= $nrpag + $adiacente; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($counter)."\">$counter</a></li>\n";                    
                    }
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($lpm1)."\">$lpm1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($ultimapagina)."\">$ultimapagina</a></li>\n"; 
                }
                else {
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse(1)."\">1</a></li>\n";
                    $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse(2)."\">2</a></li>\n";
                    $output.= "<li><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-double-right\"></i></li>\n";
                    for ($counter = $ultimapagina - (2 + ($adiacente * 2)); $counter <= $ultimapagina; $counter++) {
                        if ($counter == $nrpag)
                            $output.= "<li class=\"active\"><span>$counter</span></li>\n";
                        else
                            $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($counter)."\">$counter</a></li>\n";
                    }
                }
            }
            
            //next button
            
            if ($nrpag < $counter - 1) 
                $output.= "<li><a href=\"".$this->return_link_to_anunturi_diverse($next)."\">&rarr;</a></li>\n\n";
            else
                $output.= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-long-arrow-right\"></i></a></li>\n";
            
            $output .= "</ul>".PHP_EOL;
            return $output;       
        } 				
		
	}				
	
	/* ------------------------------------------------------------------------------------- */
	public function return_publication_type($idn) {
		$mo = '-';
		switch ($idn) {
			case  'periodice':  			   $mo="Periodice"; break;
			case  'arheologie':                $mo="Arheologie"; break;
			case  'istorie-si-memorialistica': $mo="Istorie și memorialistică"; break;
			case  'albume-si-multimedia':      $mo="Albume și multimedia"; break;
		}
		return $mo;
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_categ_slug_from_pn($pn) {
		$categ_slug = '';
		switch ($pn) {
			
			case  11 : $categ_slug = 'interes-public'; break;
			case  31 : $categ_slug = 'evenimente'; break;			
			case  33 : $categ_slug = 'anunturi'; break;
			case  101: $categ_slug = 'anunturi-achizitii-publice'; break;
			case  105: $categ_slug = 'anunturi-angajari'; break;
			case  107: $categ_slug = 'anunturi-diverse'; break;
			case  109: $categ_slug = 'braila'; break;
		}		
		return $categ_slug;
	}
	/* ------------------------------------------------------------------------------------- */
	
	public function return_youtube_link_from_id($id_YouTube) {
		return "http://www.youtube.com/embed/$id_YouTube?rel=0&autoplay=1&amp;wmode=transparent";
	}
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_search($src, $lpn=1){
		return ($lpn==1 ? __URL__.'cauta'.DIRECTORY_SEPARATOR.$src.DIRECTORY_SEPARATOR : __URL__.'cauta'.DIRECTORY_SEPARATOR.$src.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR);
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_contact(){
		return __URL__.'contact'.DIRECTORY_SEPARATOR;
	}				
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_doneaza(){
		return __URL__.'donate-now'.DIRECTORY_SEPARATOR;
	}				
	/* ------------------------------------------------------------------------------------- */	
	
	public function return_link_to_servicii($article_slug, $redirect_to){
		//return (!empty($redirect_to) ? $redirect_to : __URL__.'servicii'.DIRECTORY_SEPARATOR.$article_slug.DIRECTORY_SEPARATOR);
		return (!empty($redirect_to) ? $redirect_to : __URL__.$article_slug.DIRECTORY_SEPARATOR);
	}
	/* ------------------------------------------------------------------------------------- */	
	
	public function return_link_to_article($article_slug, $redirect_to){
		return (!empty($redirect_to) ? $redirect_to : __URL__.$article_slug.DIRECTORY_SEPARATOR);
	}
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_subarticle($subarticle_slug, $article_slug, $subarticle_redirect_to){
		return (!empty($subarticle_redirect_to) ? $subarticle_redirect_to : __URL__.$article_slug.DIRECTORY_SEPARATOR.$subarticle_slug.DIRECTORY_SEPARATOR);
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_event($article_slug, $redirect_to){
		return (!empty($redirect_to) ? $redirect_to : __URL__.'evenimente'.DIRECTORY_SEPARATOR.$article_slug.DIRECTORY_SEPARATOR);
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_ads($article_slug, $redirect_to){
		return (!empty($redirect_to) ? $redirect_to : __URL__.'anunturi'.DIRECTORY_SEPARATOR.$article_slug.DIRECTORY_SEPARATOR);
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_brailainfo($article_slug, $redirect_to){
		return (!empty($redirect_to) ? $redirect_to : __URL__.'braila'.DIRECTORY_SEPARATOR.$article_slug.DIRECTORY_SEPARATOR);
	}		
	/* ------------------------------------------------------------------------------------- */		
	public function return_link_to_interesinfo($article_slug, $redirect_to){
		return (!empty($redirect_to) ? $redirect_to : __URL__.'interes-public'.DIRECTORY_SEPARATOR.$article_slug.DIRECTORY_SEPARATOR);
	}			
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_interes($article_slug, $redirect_to){
		return (!empty($redirect_to) ? $redirect_to : __URL__.'interes-public'.DIRECTORY_SEPARATOR.$article_slug.DIRECTORY_SEPARATOR);
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_general_article($categ_slug, $article_slug, $redirect_to){
		if (!empty($categ_slug)) {
			return (!empty($redirect_to) ? $redirect_to : __URL__.$categ_slug.DIRECTORY_SEPARATOR.$article_slug.DIRECTORY_SEPARATOR);
		} else {
			return (!empty($redirect_to) ? $redirect_to : __URL__.$article_slug.DIRECTORY_SEPARATOR);
		}
	}		
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_interes_list($lpn=1){
		if ($lpn<=1) {
			return __URL__.'interes-public'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'interes-public'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_braila($lpn=1){
		if ($lpn<=1) {
			return __URL__.'braila'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'braila'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}		
	/* ------------------------------------------------------------------------------------- */	
	
	public function return_link_to_news($lpn=1){
		if ($lpn<=1) {
			return __URL__.'stiri-evenimente'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'stiri-evenimente'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_events($lpn=1){
		if ($lpn<=1) {
			return __URL__.'evenimente'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'evenimente'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}				
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_anunturi($lpn=1){
		if ($lpn<=1) {
			return __URL__.'anunturi'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'anunturi'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}					
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_anunturi_achizitii($lpn=1){
		if ($lpn<=1) {
			return __URL__.'anunturi-achizitii-publice'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'anunturi-achizitii-publice'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}						
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_anunturi_angajari($lpn=1){
		if ($lpn<=1) {
			return __URL__.'anunturi-angajari'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'anunturi-angajari'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}						
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_anunturi_diverse($lpn=1){
		if ($lpn<=1) {
			return __URL__.'anunturi-diverse'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'anunturi-diverse'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}						
	/* ------------------------------------------------------------------------------------- */	
	
	public function return_link_to_video($lpn=1){
		if ($lpn<=1) {
			return __URL__.'galerie-video'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'galerie-video'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}		
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_afise($lpn=1){
		if ($lpn<=1) {
			return __URL__.'colectia-de-afise'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'colectia-de-afise'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}			
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_publicatii($lpn=1){
		if ($lpn<=1) {
			return __URL__.'publicatii-braila'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'publicatii-braila'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}				
	/* ------------------------------------------------------------------------------------- */
	/* pt versiune veche pentru pn=8 */
	public function return_link_to_istros($categ_slug='toate', $lpn=1){
		if ($lpn<=1) {
			return __URL__.'editura-istros'.DIRECTORY_SEPARATOR.$categ_slug.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'editura-istros'.DIRECTORY_SEPARATOR.$categ_slug.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}					
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_istros2($lpn=1){
		if ($lpn<=1) {
			return __URL__.'editura-istros'.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'editura-istros'.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}						
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_photos($categ_slug='toate', $lpn=1){
		if ($lpn<=1) {
			return __URL__.'galerie-foto'.DIRECTORY_SEPARATOR.$categ_slug.DIRECTORY_SEPARATOR;
		} else {
			return __URL__.'galerie-foto'.DIRECTORY_SEPARATOR.$categ_slug.DIRECTORY_SEPARATOR.$lpn.DIRECTORY_SEPARATOR;
		}
	}					
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_notfound(){
		return __URL__.'page-not-found'.DIRECTORY_SEPARATOR;
	}								
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_impresii(){
		return __URL__.'relatii-publice/carte-de-impresii'.DIRECTORY_SEPARATOR;
	}									
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_relatii(){
		return __URL__.'relatii-publice/activitati-6'.DIRECTORY_SEPARATOR;
	}										
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_tur_virtual(){
		return __URL__.'muzeulbrailei/';
	}											
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_copii(){
		return __URL__.'relatii-publice/muzeul-vazut-de-copii'.DIRECTORY_SEPARATOR;
	}										
	/* ------------------------------------------------------------------------------------- */
	public function return_link_to_tarife(){
		return __URL__.'tarife-muzeu'.DIRECTORY_SEPARATOR;
	}								
	/* ------------------------------------------------------------------------------------- */	
	
	public function return_link_to_memoriam(){
		return __URL__.'in-memoriam'.DIRECTORY_SEPARATOR;
	}								
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_corespondenta(){
		return __URL__.'corespondnta-cu-strainatatea'.DIRECTORY_SEPARATOR;
	}								
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_decret_regal(){
		return __URL__.'decret-regal'.DIRECTORY_SEPARATOR;
	}								
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_facebook(){
		return '';
	}									
	/* ------------------------------------------------------------------------------------- */	
	public function return_link_to_youtube(){
		return '';
	}									
	/* ------------------------------------------------------------------------------------- */	
	
}

?>