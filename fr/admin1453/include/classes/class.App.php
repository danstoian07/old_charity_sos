<?php

Class App
{
	/* ------------------------------------------------------------------------------------- */	
	public  $name                   = APP_ADM_NAME;							/* app name */	
	private $default_language       = 'ro';  								/* language code as per "List of ISO 639-1 codes" */	
	private $languages              = array( 'ro', 'gb', 'es',
											 'de', 'ru', 'fr');				/* array of languages for application: array of ISO 639-1 codes*/
	public  $theme_color            = 0;									/* theme color id */	
	public  $theme_style            = 0;	 								/* theme style id: 0-> colturi drepte, 1-> rotunjite */		
	public  $theme_header           = 0;	 								/* HEADER tema: 0-> default, 1-> fixed */
	public  $theme_top_menu_bg      = 0;									/* TOP MENU BACKGROUND tema: 0-> light, 1-> dark */
	public  $theme_sidebar_mode     = 0;	 	    						/* SIDEBAR tema: 0-> default, 1-> fixed */
	public  $theme_sidebar_menu     = 0;	 	    						/* SIDEBAR MENU tema: 0-> accordion, 1-> hover */
	public  $theme_sidebar_style    = 0;	 	    						/* SIDEBAR STYLE tema: 0-> default, 1-> light */
	public  $theme_sidebar_position = 0;	    							/* SIDEBAR POSITION tema: 0-> left, 1-> right */
	public  $theme_footer           = 0;	 	    						/* FOOTER tema: 0-> default, 1-> fixed */

	public  $display_user_top_menu  = 1;									/* display or not users menu */
	public  $display_theme_settings = 1;									/* display or not theme panel settings */
	public  $display_quick_sidebar  = 1;									/* display or not quick sidebar (right); 1- allways display quick sidebar, 2- only if logged user is admin */
	public  $display_quick_nav_menu = 1;									/* display quick nav menu */
	public  $quick_sidebar_content  = '';									/* */

	public  $user_name              = '';									/* Unesr name */
	public  $user_photo             =  0;									/* path of users photo */	
	public  $user_id_cript          = '';									/* user id (encripted) */	
	private $user_logged            =  0;									/* user status */
	private $user_id                =  0;									/* real user id */	
	public  $user_have_support    	=  false;								/* user have acces to support */	
	
	public $hlpid                   =  1;									/* helpid */	
	
	public  $current_date_en        =  '';
	public  $json_calendar_colors   = '';
	public  $calendar              	= array();
	public  $applink           	    = array();	

	public  $session_expire         =  0;									/* 0 -> never expire; >0 session will expire after "$session_expire" seconds of inactivity */
	public  $message                = array();								/* App message to display */
	public  $user_top_menu          = array();								/* Array with items of top user menu */
	public  $quick_nav 				= array();								/* Quick Nav Menu */
	public  $user_rights_by_admin   = array();								/* Array with user rights set by admin */
	public  $color_schemes 			= array(
											array ( 'json' => '{"universal_f1":"#ECEFF1","universal_f2":"#000000","universal_f3":"#ffffff","universal_f4":"#000000"}', 'title' => 'Light gray'),
											array ( 'json' => '{"universal_f1":"#4b636e","universal_f2":"#ffffff","universal_f3":"#a7c0cd","universal_f4":"#000000"}', 'title' => 'Gray'),
											array ( 'json' => '{"universal_f1":"#C8E6C9","universal_f2":"#000000","universal_f3":"#fbfffc","universal_f4":"#000000"}', 'title' => 'Green'),
											array ( 'json' => '{"universal_f1":"#E1F5FE","universal_f2":"#000000","universal_f3":"#ffffff","universal_f4":"#000000"}', 'title' => 'Blue'),
											array ( 'json' => '{"universal_f1":"#E1BEE7","universal_f2":"#000000","universal_f3":"#fff1ff","universal_f4":"#000000"}', 'title' => 'Lilac'),
											array ( 'json' => '{"universal_f1":"#DCE775","universal_f2":"#000000","universal_f3":"#ffffa6","universal_f4":"#000000"}', 'title' => 'Lime'),
											array ( 'json' => '{"universal_f1":"#FFE082","universal_f2":"#000000","universal_f3":"#ffffb3","universal_f4":"#000000"}', 'title' => 'Peach'),
											array ( 'json' => '{"universal_f1":"#FFF8E1","universal_f2":"#000000","universal_f3":"#ffffff","universal_f4":"#000000"}', 'title' => 'Light Peach'),
											array ( 'json' => '{"universal_f1":"#FBE9E7","universal_f2":"#000000","universal_f3":"#ffffff","universal_f4":"#000000"}', 'title' => 'Caramel'),
									  );
	
		
	public  $panel;															/* will store panel object */	
	public  $pn;															/* will store $pn - page number */	
	public  $parent;
	
	/* ------------------------------------------------------------------------------------- */	

	public function __construct() {
		global $oDB;
		if ( (isset($_SESSION[APP_ID]["user"]["id"])) && (isset($_SESSION[APP_ID]["user"]["logged"])) && ($_SESSION[APP_ID]["user"]["logged"]==1) ) {
			/* ... verifica daca id -ul din sesiune corespunde cu id-ul user-ului curent */
			$this->user_id_cript   = $_SESSION[APP_ID]["user"]["id"];
			
			$this->AddItemToUserTopMenu('Profil utilizator', $this->LinkToUserProfile(), 'icon-user');
			//$this->AddItemToUserTopMenu('Calendar', $this->LinkToCalendar(), 'icon-calendar');
			$this->AddSeparatorToUserTopMenu();
			$this->AddItemToUserTopMenu('Log Out', $this->LinkToLogout(), 'icon-key');
						
			$query  = "
						SELECT *, CURDATE() AS date_now 
						FROM $oDB->users
						WHERE $oDB->users.id='".el_decript_info($_SESSION[APP_ID]["user"]["id"])."' AND $oDB->users.id_archive=10 LIMIT 1";
			$result = $oDB->db_query($query);

			if ($result_line = $oDB->db_fetch_array($result)) {
				$this->user_logged              = 1;
				$this->user_id                  = $result_line['id'];
				$this->user_photo               = $result_line['photo'];
				$this->user_name                = $result_line['name'];
				$this->current_date_en 	  	    = $result_line['date_now'];
				$this->user_have_support		= $_SESSION[APP_ID]["user"]["have_support"];
				$this->user_rights_by_admin     = json_decode( el_decript_info($_SESSION[APP_ID]["user"]["rights"]), true);
				$this->json_calendar_colors     = $result_line['json_calendar_colors'];
				$this->display_quick_nav_menu   = $result_line['show_quick_menu'];
				
				$this->calendar['show_weekend'] = $result_line['calendar_show_weekend'];
				$this->calendar['type']         = $result_line['calendar_type']; /* 0 - afiseaza dosarele/activitatile/evenimentele utilizatorului, 1 - afiseaza dosarele/activitatile/evenimentele societatii */
				$this->calendar['first_day']    = $result_line['calendar_first_day'];
				
				
				$this->applink['sectii']        	= __ADMINURL__.'?pn=2&archtype=sectii';
				$this->applink['menu']				= __ADMINURL__.'?pn=2&archtype=menu';
				$this->applink['evenimente']    	= __ADMINURL__.'?pn=2&archtype=evenimente';
				$this->applink['anunturi']    		= __ADMINURL__.'?pn=2&archtype=anunturi';
				$this->applink['infoutile']    		= __ADMINURL__.'?pn=2&archtype=infoutile';
				$this->applink['infobraila']    	= __ADMINURL__.'?pn=2&archtype=infobraila';
				$this->applink['afise']    			= __ADMINURL__.'?pn=2&archtype=afise';				
				$this->applink['setari_afise']   	= __ADMINURL__.'?pn=3&archtype=setari_afise&id=U1F5T1Rwa0c0TFdFbjFqOXprUVVSdz09&redirect='.urlencode(__ADMINURL__.'?pn=2&archtype=setari_afise');
				$this->applink['setari_coperte']   	= __ADMINURL__.'?pn=3&archtype=setari_coperte&id=KzNTSzhRdUpXUzIyZTY0SkdudE5uZz09&redirect='.urlencode(__ADMINURL__.'?pn=2&archtype=setari_coperte');
				$this->applink['galeriemuzeu'] 		= __ADMINURL__.'?pn=2&archtype=galeriemuzeu';
				$this->applink['editura'] 			= __ADMINURL__.'?pn=2&archtype=editura';
				$this->applink['publicatiibraila'] 	= __ADMINURL__.'?pn=2&archtype=publicatiibraila';
				$this->applink['video']    			= __ADMINURL__.'?pn=2&archtype=video';
				
				$this->applink['calendar']      = __ADMINURL__.'?pn=4&archtype=calendar';
				$this->applink['users']         = __ADMINURL__.'?pn=2&archtype=utilizatori';
				//$this->applink['sedii']         = __ADMINURL__.'?pn=2&archtype=sedii';
				//$this->applink['clients']       = __ADMINURL__.'?pn=2&archtype=clienti';
				//$this->applink['contracts']     = __ADMINURL__.'?pn=2&archtype=contracte';
				//$this->applink['cases']     	= __ADMINURL__.'?pn=2&archtype=dosare';
				$this->applink['settings']     	= __ADMINURL__.'?pn=3&archtype=setari&id=MFdlWE8wQktlZUtwNHZMU282Y0VLUT09&redirect='.urlencode(__ADMINURL__).'%3Fpn%3D2%26archtype%3Dsetari&tab=1';
				$this->applink['support']       = __ADMINURL__.'?pn=4&archtype=support';
				$this->applink['help']       	= __ADMINURL__.'?pn=4&archtype=help';								
				
				$this->SetQuickNav();
				$this->quick_sidebar_content  = $result_line['users_status_list'];
				$this->SetUserSettings($result_line['json_parameters']);
				$this->parent = $this;
			} else {
				$this->user_id_cript   = '';
				$this->user_logged     = 0;
				unset($_SESSION[APP_ID]["user"]);
			}
			/* ... */
		}		
	}
	/* ------------------------------------------------------------------------------------- */	
    public function createProperty($name, $value){
        $this->{$name} = $value;
    }		
	/* ------------------------------------------------------------------------------------- */	
	public function Run() {
		if ($this->user_logged!=0) {			
			$this->DisplayPanel();
    	} else {
			if( isset($_REQUEST['recover']) ) {
				global $oDB;
				$recover_uuid = $_REQUEST['recover'];
				$query = "SELECT count(*) AS no_recover FROM $oDB->users WHERE recover_uuid = '$recover_uuid' AND recover_valid_until>=NOW()";
				$result = $oDB->db_query($query);
				if ($result_line = $oDB->db_fetch_array($result)) {
					if ($result_line['no_recover']==1) {
						include(__THEMEPATH__.'page_reset_password_1.php');
					} else {
						el_redirect(__ADMINURL__);
					}
				} else {					
					el_redirect(__ADMINURL__);
				}
			} else {
				include(__THEMEPATH__.'page_login.php');
			}
    	}
	}
	/* ------------------------------------------------------------------------------------- */	
	public function DisplayPanel(){
		
		if( isset($_REQUEST['pn']) )       { $pn       = $_REQUEST['pn'];  }                   else { $pn  = 1; }               /* index of page to be show */
		if( isset($_REQUEST['archtype']) ) { $archtype = $_REQUEST['archtype']; }              else { $archtype = ''; if (($pn==2) || ($pn==3)) $pn=1; }  /* identify archive */
		if( isset($_REQUEST['id']) )       { $id       = $_REQUEST['id'];  }                   else { $id  = 0; }               /* item id */			
		if( isset($_REQUEST['tab']) )      { $tab      = $_REQUEST['tab'];  }                  else { $tab = 1; }               /* active tab no */		
		if( isset($_REQUEST['cdate']) )    { $cdate    = $_REQUEST['cdate'];  }                else { $cdate = date('d-m-Y'); } /* curent date for calendar */		
		if( isset($_REQUEST['hlpid']) )    { $hlpid    = $_REQUEST['hlpid'];  }                else { $hlpid = 1; }             /* id help */		
		
		if( isset($_REQUEST['redirect']) ) { $redirect = $_REQUEST['redirect'];  }             else { $redirect = ''; }         /* redirect link */
				
		//if ($pn==1) { el_redirect(__ADMINURL__.'?pn=2&archtype=dosare');}
		if ($pn==1) { el_redirect(__ADMINURL__.'?pn=2&archtype=sectii');}
		
		$this->hlpid = $hlpid;
		$this->pn    = $pn;
		switch ($pn) {
			case 1: 
		    		include(__THEMEPATH__.'app_header.php');
		    		include(__THEMEPATH__.'page_dashboard.php');
		    		include(__THEMEPATH__.'app_footer.php');			        
		    		break;
			        /* ----------------------------------------- */
			case 2:  					
					$class_name  = "archive_".$archtype;
					if (class_exists("$class_name")) {
						$eval_str = "\$this->panel = new $class_name(\$this);"; 
						eval($eval_str);			
						$this->panel->archtype = $archtype;
						$this->panel->ShowList();
					} else {
						el_redirect(__ADMINURL__);
					}					
		    		break;			
			        /* ----------------------------------------- */
			case 3: 
					$class_name  = "archive_".$archtype;
					if (class_exists("$class_name")) {
						$eval_str = "\$this->panel = new $class_name(\$this);"; 
						eval($eval_str);			
						$this->panel->archtype   = $archtype;
						$this->panel->active_tab = $tab;
						if (!empty($redirect)) {$this->panel->url_referer = $redirect;} else { $this->panel->url_referer = $this->panel->LinkToList($archtype);}
						$this->panel->ShowEdit($id);
					} else {
						el_redirect(__ADMINURL__);
					}					
		    		break;
			        /* ----------------------------------------- */
			case 4: 
					$class_name  = "archive_".$archtype;
					if (class_exists("$class_name")) {
						$eval_str = "\$this->panel = new $class_name(\$this);"; 
						eval($eval_str);			
						$this->panel->archtype = $archtype;
						$this->panel->ShowPanel();
					} else {
						el_redirect(__ADMINURL__);
					}										
					break;
					/* ----------------------------------------- */
					/* ----------------------------------------- */
		}
	}
	/* ------------------------------------------------------------------------------------- */	
	public function Login() {	
		global $oDB;	
		if ($this->user_logged==0) {
			if($_SERVER["REQUEST_METHOD"] == "POST") {
					
					$username = mysqli_real_escape_string($oDB->dbh,$_POST['username']);
					$password = md5(mysqli_real_escape_string($oDB->dbh,$_POST['password'])); 
					$query="SELECT count(*) AS items_no, id, name, email, phone, type, json_rights FROM $oDB->users WHERE email = '$username' AND password='$password' AND active=1";
					$result = $oDB->db_query($query);
					if ($result_line = $oDB->db_fetch_array($result)) {
					    if ($result_line['items_no']==1) {
							$ID_LOGGED_USER = $result_line['id'];
					    	$_SESSION[APP_ID]["user"]["logged"] 	  = 1;
					        $_SESSION[APP_ID]["user"]["id"]     	  = el_encript_info($result_line['id']);
							$_SESSION[APP_ID]["user"]["name"]   	  = el_encript_info($result_line['name']);
							$_SESSION[APP_ID]["user"]["email"]  	  = el_encript_info($result_line['email']);
							$_SESSION[APP_ID]["user"]["phone"]        = el_encript_info($result_line['phone']);
							$_SESSION[APP_ID]["user"]["have_support"] = false;
							$_SESSION['unique_app_id']          	  = APP_ID;
							$_SESSION['enc_string']             	  = AUTH_KEY;
							
							/* ------------------------------------------- */
							$_SESSION[APP_ID]["user"]["company"] = '';
							$query2  = "SELECT company_name FROM $oDB->app_settings WHERE id=1";
							$result2 = $oDB->db_query($query2);
							if ($result_line2 = $oDB->db_fetch_array($result2)) {
								$_SESSION[APP_ID]["user"]["company"]  = el_encript_info($result_line2['company_name']);
							}							
							/* ------------------------------------------- */
							/*
							$oDB_support  = new db( DB_SUPPORT_SERVER_USERNAME, DB_SUPPORT_SERVER_PASSWORD, DB_SUPPORT_DATABASE, DB_SUPPORT_SERVER );
							$query3  = "SELECT supportdate_start, supportdate_end, CURDATE() AS azi FROM $oDB_support->companies WHERE id=1";
							
							$result3 = $oDB_support->db_query($query3);
							if ($result_line3 = $oDB_support->db_fetch_array($result3)) {
								$_SESSION[APP_ID]["user"]["have_support"]  = ((($result_line3['azi']>=$result_line3['supportdate_start']) && ($result_line3['azi']<=$result_line3['supportdate_end'])) ? true: false);
							}
							*/
							/* ------------------------------------------- */
							
							$arr_rights     = json_decode($result_line["json_rights"], true);
							$len_arr_rights = count($arr_rights);
							$arr_rights[$len_arr_rights]['name']  ='administrator';
							$arr_rights[$len_arr_rights]['value'] =$result_line['type'];							
							$_SESSION[APP_ID]["user"]["rights"]   = el_encript_info(json_encode($arr_rights));
							/* ----------------------------- */
							$query     = "UPDATE $oDB->users SET last_login=NOW(), last_seen=NOW() WHERE id=".$ID_LOGGED_USER;
							$result    = $oDB->db_query($query);
							adm_AddTrackingInfo('Login utilizator');
							$AJAX_SEC_GET_USERS_STATUS_LIST = AJAX_TIME_GET_USERS_STATUS_LIST/1000;
							$query     = "
								SELECT id, name, phone, email, type, photo, type_association, last_login, IF(TIME_TO_SEC(TIMEDIFF(NOW(), last_seen))<=$AJAX_SEC_GET_USERS_STATUS_LIST,1,0) AS is_online 
								FROM $oDB->users 
								WHERE active=1 
								ORDER BY is_online DESC, last_login ASC";							
							$result    = $oDB->db_query($query);
							$users_list = '';							
							while ($result_line = $oDB->db_fetch_array($result)) {
								$users_list .= '
									<li class="media">
										'.($result_line['is_online'] ? '<div class="media-status"><span class="badge badge-success">online</span></div>' : '').'
										<img class="media-object" src="'.(!empty($result_line['photo']) ? adm_thumb_image($result_line['photo'],45,45) : __THEMEURL__.'assets/layouts/layout/img/user-icon.jpg').'" alt="">
										<div class="media-body">
											<h4 class="media-heading">'.$result_line['name'].'</h4>
											<div class="media-heading-sub"> '.adm_tip_colaborare($result_line['type_association']).' </div>
											<div class="media-heading-sub2"> Ultimul Login: '.el_MysqlDateTime_To_RomanianShortDate_Literal($result_line['last_login']).' </div>
										</div>
									</li>'.PHP_EOL;								
							}
							$query = "UPDATE $oDB->users SET users_status_list ='".addslashes(stripslashes($users_list))."' WHERE id=".el_decript_info($_SESSION[APP_ID]["user"]["id"]);
							$result    = $oDB->db_query($query);
							/* ----------------------------- */
							if (TRACK_USERS_ACTIVITY) {
								/* create records for curent and next month in order to store tracking activities */
								$year = date("Y"); $month = date("n"); 
								$yearmonth       = $year. str_pad($month, 2, "0", STR_PAD_LEFT);
								$year_next_month = date("Y", mktime(0, 0, 0, $month+1, 1, $year));
								$next_month      = date("n", mktime(0, 0, 0, $month+1, 1, $year));
								$yearmonth2      = $year_next_month. str_pad($next_month, 2, "0", STR_PAD_LEFT);
								$multiple_query = "
									INSERT INTO $oDB->users_track SET idma=$ID_LOGGED_USER, year=".$year.", month=".$month.", date_mod=NOW(), yearmonth='$yearmonth', add_by=$ID_LOGGED_USER, mod_by=$ID_LOGGED_USER ON DUPLICATE KEY UPDATE id=id;
									INSERT INTO $oDB->users_track SET idma=$ID_LOGGED_USER, year=".$year_next_month.", month=".$next_month.", yearmonth='$yearmonth2', date_mod=NOW(), add_by=$ID_LOGGED_USER, mod_by=$ID_LOGGED_USER ON DUPLICATE KEY UPDATE id=id;
								";
								$result = $oDB->db_multiquery($multiple_query);
								$oDB->db_next_result();
								
							}
							/* ----------------------------- */
					    }
					}
					if (isset($_SERVER["HTTP_REFERER"])) {
						el_redirect($_SERVER["HTTP_REFERER"]);
					} else {
						el_redirect(__ADMINURL__);
					}
			}			
		}
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function Logout() {
		unset($_SESSION[APP_ID]["user"]);
		header('Location: '.__ADMINURL__);
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function LoggedUserIsAdmin(){
		$arr_rights      = json_decode(el_decript_info($_SESSION[APP_ID]["user"]["rights"]), true);
		$arr_rights_info = end($arr_rights);
		return (isset($arr_rights_info['value']) ? $arr_rights_info['value'] : 0);
	}
	/* ------------------------------------------------------------------------------------- */	
	/* 
		Will return an array of user rights of archive 
		$arr_all_user_rights = json_decode( el_decript_info($_SESSION[APP_ID]["user"]["rights"]), true);
	*/
	
	public function GetUserRightsOfArchive($archtype, $arr_all_user_rights = '') {
		$arr_return_rights = array();
		if (empty($arr_all_user_rights)) {
			$arr_all_user_rights = json_decode( el_decript_info($_SESSION[APP_ID]["user"]["rights"]), true);
		}		
		foreach ($arr_all_user_rights as $rights) {
			if ( $rights['name']=='administrator' ) {
				$arr_return_rights["administrator"] = $rights['value'];
			}			
			if ( $rights['name']==$archtype ) {
				$arr_return_rights["$archtype"] = $rights['value'];
			}
			if (strpos($rights['name'], $archtype)!==false) {
				if ($rights['name']!=$archtype) {
					$rights_name = str_replace( $archtype."_", "", $rights['name'] );				
					$arr_return_rights["$rights_name"] = ($rights['value']=='on' ? 1 : 0);
				}
			}
		}
		return $arr_return_rights;		
	}
	/* ------------------------------------------------------------------------------------- */	
	public function CopyrightInfo() {
		/* vezi posibilitate criptare text, pentru a nu fi gasit la cautare prin cod */
		return '2017 &copy; '.strtoupper(APP_COMPANY_NAME);
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function SoftwareAuthorInfo() {
		return APP_COMPANY_NAME;
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function FooterInfo() {
		return '<a href="'.LINK_TO_HELP_BACKEND.'" title="Help aplicatie" target="_blank">Help online</a> | <a href="javascript:cst_message_load_html(\'Despre...\',\''.__ADMINURL__.'resources/info/hlp_about.php\');">Despre</a>';
	}			
	/* ------------------------------------------------------------------------------------- */
	public function StylizedName($lite_background = false){
		return '<img src="'.__ADMINURL__.'resources/logo-big.png" />';
		/*
		if ($lite_background==true) {
			return '<h1>EASY LAW</h1>';
		} else {
			return '<h1 class="fs18 font-bold"><i class="fa fa-gavel color_white"></i> <span class="color_white">EASY</span> <span class="color_red">LAW</span></h1>';
		}
		*/
	}
	/* ------------------------------------------------------------------------------------- */
	/* set app settings: theme, language, etc */
	private function SetUserSettings($json) {		
		if (!empty($json)) {			
	        
	        $data = json_decode($json, true);

	        /* ------ */
		    $this->theme_color            = ( (el_between($data['tip1'],0,5)) ? $data['tip1'] : 0 ); 
		    $this->theme_style            = ( (el_between($data['tip2'],0,1)) ? $data['tip2'] : 0 ); 
		    $this->theme_header           = ( (el_between($data['tip3'],0,1)) ? $data['tip3'] : 0 ); 
		    $this->theme_top_menu_bg      = ( (el_between($data['tip4'],0,1)) ? $data['tip4'] : 0 ); 
		    $this->theme_sidebar_mode     = ( (el_between($data['tip5'],0,1)) ? $data['tip5'] : 0 ); 
		    $this->theme_sidebar_menu     = ( (el_between($data['tip6'],0,1)) ? $data['tip6'] : 0 ); 
		    $this->theme_sidebar_style    = ( (el_between($data['tip7'],0,1)) ? $data['tip7'] : 0 ); 
		    $this->theme_sidebar_position = ( (el_between($data['tip8'],0,1)) ? $data['tip8'] : 0 ); 
		    $this->theme_footer   		  = ( (el_between($data['tip9'],0,1)) ? $data['tip9'] : 0 ); 
	        if (($this->theme_sidebar_mode==1) && ($this->theme_sidebar_menu==1)) {
	        	$this->theme_sidebar_menu = 0;
	        }
	        /* ------ */
	        $this->SetDefaultLanguage($data['lang']);
	        /* ------ */
	        $this->session_expire         = $data['s_expire'];
	        /* ------ */
	    }
	}
	/* ------------------------------------------------------------------------------------- */	
	private function SetDefaultLanguage($lang_code){
			$lang_str = strtolower(trim($lang_code));
			if (!empty($lang_str)) {
				if (in_array($lang_str, $this->languages)) {
					$this->default_language = $lang_str;
					/* ------ */

					/* ------ */
				}				
			}
	}
	/* ------------------------------------------------------------------------------------- */	
	/* return name of css file for specific theme color */
	public function ThemeColorCssFile(){		
	    $file_name = 'default.min.css';
	    switch ($this->theme_color) {
	        case 0: $file_name = 'default.min.css'; break;
	        case 1: $file_name = 'darkblue.min.css'; break;
	        case 2: $file_name = 'blue.min.css'; break;
	        case 3: $file_name = 'grey.min.css'; break;
	        case 4: $file_name = 'light.min.css'; break;
	        case 5: $file_name = 'light2.min.css'; break;
	    }
	    return $file_name;
	}
	/* ------------------------------------------------------------------------------------- */	
	/* return name of css file for theme style : "right corners" or "rounded corners"*/
	public function ThemeStyleCssFile(){		
	    $file_name = 'components.min.css';
	    switch ($this->theme_style) {
	        case 0: $file_name = 'components.min.css'; break;
	        case 1: $file_name = 'components-rounded.min.css'; break;
	    }
	    return $file_name;
	}	
	/* ------------------------------------------------------------------------------------- */	
	/* return language name. Parameters $language_code is ISO 639-1 code */
	private function ReturnLanguageInfo( $language_code, $info_type = 0 ){
		switch ( $info_type ){
			case 0:
				/* return language name */
				switch ($language_code) {
				    case 'ro': return 'Romana'; 
				    case 'gb': return 'English'; 
				    case 'fr': return 'Francais'; 
				    case 'es': return 'Espaniol'; 
				    case 'de': return 'Deusch'; 
				    case 'ru': return 'Russian'; 
				}
				break;
			case 1:
				/* return name of translate file */
				switch ($language_code) {
				    case 'ro': return 'ro_RO'; 
				    case 'gb': return 'en_GB'; 
				    case 'fr': return 'fr_FR'; 
				    case 'es': return 'es_ES'; 
				    case 'de': return 'de_DE'; 
				    case 'ru': return 'ru_RU'; 
				}
				break;				
		}	
	}
	/* ------------------------------------------------------------------------------------- */	
	/* display app languages in menu bar */
	public function ShowLanguages() {
		/*
		if (count($this->languages)>1) {
			?>
			<li class="dropdown dropdown-language">
			<?php
				if (!empty($this->default_language)) {
					$lang_str = strtolower($this->default_language);
					?>
		                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		                    <img alt="" src="<?=__THEMEURL__?>assets/global/img/flags/<?=$lang_str?>.png">
		                    <span class="langname"> <?=$this->ReturnLanguageInfo($lang_str)?> </span>
		                    <i class="fa fa-angle-down"></i>
		                </a>			
		                <ul class="dropdown-menu dropdown-menu-default">
					<?php
				}
				
				foreach ($this->languages as $value) {
					$lang_str = strtolower($value);
					?>					
                        <li><a href="<?=(($lang_str!=$this->default_language) ? $this->LinkToChangeLanguage($lang_str) : 'javascript:void(0);')?>"><img alt="" src="<?=__THEMEURL__?>assets/global/img/flags/<?=$lang_str?>.png"> <?=$this->ReturnLanguageInfo($lang_str)?> </a></li>
					<?php
				}			
				
			?>
						</ul>
			</li>
			<?php
		}
		*/
	}		
	/* ------------------------------------------------------------------------------------- */	
	/* get curent url of application */
	public function GetCurentUrl(){
		return "http".((array_key_exists('HTTPS', $_SERVER) && $_SERVER["HTTPS"] == "on") ? "s" : "")."://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	/* ------------------------------------------------------------------------------------- */	
	/* return link for change language */
	/**
		* @param string   $language_code     		 language code as per "List of ISO 639-1 codes"
	*/

	public function LinkToChangeLanguage($language_code) {
		//return __ADMINURL__.action.DIRECTORY_SEPARATOR.'s-changelanguage.php?lang='.$language_code.'&redirect='.urlencode($this->GetCurentUrl());
		return __ADMINURL__.'action'.DIRECTORY_SEPARATOR.'s-changelanguage.php?lang='.$language_code.'&redirect='.urlencode( el_remove_url_param($this->GetCurentUrl(),'redirect') );
	}
	/* ------------------------------------------------------------------------------------- */	
	public function LinkToLogout() {
		return __ADMINURL__.'action'.DIRECTORY_SEPARATOR.'s-logout.php';
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function LinkToUserProfile() {
		return __ADMINURL__.'?pn=3&archtype=utilizator&id='.$this->user_id_cript;
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function LinkToCalendar() {
		return __ADMINURL__.'?pn=4&archtype=calendar';
	}			
	/* ------------------------------------------------------------------------------------- */	
	public function LinkToHelp($hlpid=1) {
		return __ADMINURL__."?pn=4&archtype=help&hlpid=$hlpid";
	}				
	/* ------------------------------------------------------------------------------------- */	
	/**
		* @param string   $msg        		 Message to display
		* @param int      $msg_type          Message type: can be MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING
	*/	
	public function Alert($msg, $msg_type = MSG_INFO){
		return '
			<div class="custom-alerts alert '.$this->ReturnAlertsClassFromType($msg_type).' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				'.$msg.'
			</div>';
	}
	/* ------------------------------------------------------------------------------------- */	
	/**
		* @param string   $msg        		 Message to display
		* @param string   $button_redirect   Link to redirect when click button
		* @param string   $button_text       Button text
		* @param int      $msg_type          Message type: can be MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING
	*/
	public function ShowMessage($msg, $button_redirect = '', $button_text = 'OK',$msg_type = MSG_INFO){
		$this->message[0] = $msg;
		$this->message[1] = ((!empty($button_redirect)) ? $button_redirect : __ADMINURL__);
		$this->message[2] = $button_text;
		$this->message[3] = $this->ReturnMessageClassFromType($msg_type);
		if (headers_sent() === false) {				
				if (class_exists("archive_info")) {
					$this->panel = new archive_info($this, $msg_type);
					$this->panel->ShowInfo();
				} else {
					el_redirect(__ADMINURL__);
				}								
		} else {
			echo $msg;
		}
	}
	/* ------------------------------------------------------------------------------------- */	
	/* return NOTES class from $msg_type */
	public function ReturnMessageClassFromType($msg_type){
		switch ($msg_type) {
		    case MSG_SUCCESS: return 'note-success'; 
		    case MSG_INFO   : return 'note-info';    
		    case MSG_DANGER : return 'note-danger';  
		    case MSG_WARNING: return 'note-warning'; 
		}
	}
	/* ------------------------------------------------------------------------------------- */	
	/* return NOTES class from $msg_type */
	public function ReturnAlertsClassFromType($msg_type){
		switch ($msg_type) {
		    case MSG_SUCCESS: return 'alert-success'; 
		    case MSG_INFO   : return 'alert-info';    
		    case MSG_DANGER : return 'alert-danger';  
		    case MSG_WARNING: return 'alert-warning'; 
		}
	}
	/* -------------------------------------------------------------------------------------- */
	/* delete items of quick nav menu */
	public function ClearItemsQuickNav() {
		$this->user_top_menu = array_slice($this->quick_nav, 0, 0); 
	}	
	/* ------------------------------------------------------------------------------------- */	
	public function AddItemToQuickNav($title, $link, $icon_class) {
		array_push($this->quick_nav,array($title, $link, $icon_class));
	}		
	/* ------------------------------------------------------------------------------------- */
	public function ShowQuickNav() {
		$quicknav_content = '';
		if ($this->display_quick_nav_menu) {
			if (!empty($this->quick_nav)) {
				$quicknav_content = '
				<nav class="quick-nav">
					<a class="quick-nav-trigger" href="#0">
						<span aria-hidden="true"></span>
					</a>
					<ul>'.PHP_EOL;
				foreach ($this->quick_nav as $key => $item) {					
					$quicknav_content .= '
						<li>
							<a href="'.$this->quick_nav[$key][1].'" class="active">
								<span>'.$this->quick_nav[$key][0].'</span>
								<i class="'.$this->quick_nav[$key][2].'"></i>
							</a>
						</li>'.PHP_EOL;
				}
						$quicknav_content .= '
					</ul>
					<span aria-hidden="true" class="quick-nav-bg"></span>
				</nav>
				<div class="quick-nav-overlay"></div>'.PHP_EOL;
			}
		}
		echo $quicknav_content;
	}
	/* ------------------------------------------------------------------------------------- */
	public function AddItemToUserTopMenu($title, $link, $icon_class) {
		array_push($this->user_top_menu,array($title, $link, $icon_class));
	}	
	/* ------------------------------------------------------------------------------------- */
	/* delete items of user top menu, except Log Out item */
	public function ClearItemsUserTopMenu() {
		$this->user_top_menu = array_slice($this->user_top_menu, 0, 0); 
	}
	/* ------------------------------------------------------------------------------------- */
	public function AddSeparatorToUserTopMenu() {
		array_push($this->user_top_menu,array('twNHZMU282Y0', '', ''));
	}		
	/* ------------------------------------------------------------------------------------- */
	public function ShowItemsOfTopMenu() {
		if ($this->display_user_top_menu) {
			$menu_length = count($this->user_top_menu);
			if ($menu_length>0) {
				$str_actions = '';
				for ($i = 0; $i < $menu_length; $i++) {
					if (!empty($this->user_top_menu[$i][0])) {
						if ($this->user_top_menu[$i][0]!='twNHZMU282Y0') {
							$str_actions .= '<li><a href="'.(!empty($this->user_top_menu[$i][1]) ? $this->user_top_menu[$i][1] : 'javascript:void(0);').'">'.((!empty($this->user_top_menu[$i][2])) ? '<i class="'.$this->user_top_menu[$i][2].'"></i>' : '').' '.$this->user_top_menu[$i][0].'</a></li>'.PHP_EOL;
						} else {
							$str_actions .= '<li class="divider"> </li>'.PHP_EOL;
						}
				    }
				}
				echo $str_actions;
			}
		}
	}				
	/* ------------------------------------------------------------------------------------- */
	/* display app top menu */
	public function ShowTopMenu() {
			?>

			<?php
	}
	/* ------------------------------------------------------------------------------------- */
	/* display users top menu */
	public function ShowUserTopMenu(){		
		if ($this->display_user_top_menu) {
		    ?>
		    
		                        <li class="dropdown dropdown-user <?=($this->theme_top_menu_bg ? 'dropdown-dark' : '')?>">
		                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		                                <img alt="" class="img-circle" src="<?=adm_thumb_image($this->user_photo,29,29)?>" />
		                                <span class="username username-hide-on-mobile"> <?=$this->user_name?> </span>
		                                <i class="fa fa-angle-down"></i>
		                            </a>
		                            <ul class="dropdown-menu dropdown-menu-default">
										<!--
		                                <li>
		                                    <a href="page_user_profile_1.html">
		                                        <i class="icon-user"></i> <?=_('Profil utilizator')?> </a>
		                                </li>
		                                <li>
		                                    <a href="app_calendar.html">
		                                        <i class="icon-calendar"></i> <?=_('Calendar')?> </a>
		                                </li>
		                                <li>
		                                    <a href="app_inbox.html">
		                                        <i class="icon-envelope-open"></i> <?=_('Inbox')?>
		                                        <span class="badge badge-danger"> 3 </span>
		                                    </a>
		                                </li>
		                                <li>
		                                    <a href="app_todo.html">
		                                        <i class="icon-rocket"></i> <?=_('Task-uri')?>
		                                        <span class="badge badge-success"> 7 </span>
		                                    </a>
		                                </li>
		                                <li class="divider"> </li>
										-->
										<?=$this->ShowItemsOfTopMenu()?>
		                            </ul>
		                        </li>

		    <?php
		}
	} 	
	/* ------------------------------------------------------------------------------------- */		
	/* display theme panel settings */
	function ShowThemePanelSettings() {
		if ($this->display_theme_settings) {
			?>
			                <div class="theme-panel hidden-xs hidden-sm">
			                    <div class="toggler"> </div>
			                    <div class="toggler-close"> </div>
			                    <div class="theme-options">
			                        <div class="theme-option theme-colors clearfix">
			                            <span> <?=_('CULORI TEMA')?> </span>
			                            <ul id="th_colors">
			                                <li class="color-default <?=($this->theme_color==0 ? 'current' : '')?> tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
			                                <li class="color-darkblue <?=($this->theme_color==1 ? 'current' : '')?> tooltips" data-style="darkblue" data-container="body" data-original-title="Dark Blue"> </li>
			                                <li class="color-blue <?=($this->theme_color==2 ? 'current' : '')?> tooltips" data-style="blue" data-container="body" data-original-title="Blue"> </li>
			                                <li class="color-grey <?=($this->theme_color==3 ? 'current' : '')?> tooltips" data-style="grey" data-container="body" data-original-title="Grey"> </li>
			                                <li class="color-light <?=($this->theme_color==4 ? 'current' : '')?> tooltips" data-style="light" data-container="body" data-original-title="Light"> </li>
			                                <li class="color-light2 <?=($this->theme_color==5 ? 'current' : '')?> tooltips" data-style="light2" data-container="body" data-html="true" data-original-title="Light 2"> </li>
			                            </ul>
			                        </div>
			                        <div class="theme-option">
			                            <span> <?=_('Stil tema')?> </span>
			                            <select class="layout-style-option form-control input-sm">
			                                <option value="square"  <?=($this->theme_style==0 ? 'selected="selected"' : '')?>><?=_('Colturi drepte')?></option>
			                                <option value="rounded" <?=($this->theme_style==1 ? 'selected="selected"' : '')?>><?=_('Colturi rotunjite')?></option>
			                            </select>
			                        </div>
			                        <div class="theme-option">
			                            <span> <?=_('Header')?> </span>
			                            <select class="page-header-option form-control input-sm">
			                                <option value="fixed" <?=($this->theme_header==1 ? 'selected="selected"' : '')?>><?=_('Fix')?></option>
			                                <option value="default" <?=($this->theme_header==0 ? 'selected="selected"' : '')?>><?=_('Implicit')?></option>
			                            </select>
			                        </div>
			                        <div class="theme-option">
			                            <span> <?=_('Meniu top')?></span>
			                            <select class="page-header-top-dropdown-style-option form-control input-sm">
			                                <option value="light" <?=($this->theme_top_menu_bg==0 ? 'selected="selected"' : '')?>><?=_('Deschis la culoare')?></option>
			                                <option value="dark" <?=($this->theme_top_menu_bg==1 ? 'selected="selected"' : '')?>><?=_('Inchis la culoare')?></option>
			                            </select>
			                        </div>
			                        <div class="theme-option">
			                            <span> <?=_('Mod zona laterala')?></span>
			                            <select class="sidebar-option form-control input-sm">
			                                <option value="fixed" <?=($this->theme_sidebar_mode==1 ? 'selected="selected"' : '')?>><?=_('Fix')?></option>
			                                <option value="default" <?=($this->theme_sidebar_mode==0 ? 'selected="selected"' : '')?>><?=_('Implicit')?></option>
			                            </select>
			                        </div>
			                        <div class="theme-option">
			                            <span> <?=_('Meniu zona laterala')?> </span>
			                            <select class="sidebar-menu-option form-control input-sm">
			                                <option value="accordion" <?=($this->theme_sidebar_menu==0 ? 'selected="selected"' : '')?>>Accordion</option>
			                                <option value="hover" <?=($this->theme_sidebar_menu==1 ? 'selected="selected"' : '')?>>Hover</option>
			                            </select>
			                        </div>
			                        <div class="theme-option">
			                            <span> <?=_('Stil zona laterala')?> </span>
			                            <select class="sidebar-style-option form-control input-sm">
			                                <option value="default" <?=($this->theme_sidebar_style==0 ? 'selected="selected"' : '')?>><?=_('Implicit')?></option>
			                                <option value="light" <?=($this->theme_sidebar_style==1 ? 'selected="selected"' : '')?>><?=_('Deschis la culoare')?></option>
			                            </select>
			                        </div>
			                        <div class="theme-option">
			                            <span> <?=_('Pozitie zona laterala')?> </span>
			                            <select class="sidebar-pos-option form-control input-sm">
			                                <option value="left" <?=($this->theme_sidebar_position==0 ? 'selected="selected"' : '')?>><?=_('Stanga')?></option>
			                                <option value="right" <?=($this->theme_sidebar_position==1 ? 'selected="selected"' : '')?>><?=_('Dreapta')?></option>
			                            </select>
			                        </div>
			                        <div class="theme-option">
			                            <span> Footer </span>
			                            <select class="page-footer-option form-control input-sm">
			                                <option value="fixed" <?=($this->theme_footer==1 ? 'selected="selected"' : '')?>><?=_('Fix')?></option>
			                                <option value="default" <?=($this->theme_footer==0 ? 'selected="selected"' : '')?>><?=_('Implicit')?></option>
			                            </select>
			                        </div>
			                    </div>
			                </div>

			<?php
		}
	}
	/* ------------------------------------------------------------------------------------- */
	/* display app sidebar */
	public function ShowSidebar($active_id) {
		
		?>
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed <?=($this->theme_sidebar_menu ? 'page-sidebar-menu-hover-submenu' : '')?> <?=($this->theme_sidebar_style ? 'page-sidebar-menu-light' : '')?>" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                        <li class="sidebar-toggler-wrapper hide">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler">
                                <span></span>
                            </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>
                        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                        <li class="sidebar-search-wrapper">
                            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
							
                            <form class="sidebar-search  " action="page_general_search_3.html" method="POST">
                                <a href="javascript:;" class="remove">
                                    <i class="icon-close"></i>
                                </a>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <a href="javascript:;" class="btn submit">
                                            <i class="icon-magnifier"></i>
                                        </a>
                                    </span>
                                </div>
                            </form>
							
                            <!-- END RESPONSIVE QUICK SEARCH FORM -->
                        </li>
						<!--
                        <li class="nav-item start ">
                            <a href="<?=__ADMINURL__?>" class="nav-link ">
                                <i class="icon-home"></i>
                                <span class="title">Home</span>
                                <span class="badge badge-success">1</span>
                            </a>
                        </li>
						-->
						<?php
							$archive_rights = $this->GetUserRightsOfArchive('sectii', $this->user_rights_by_admin);
							if ( $archive_rights && (($archive_rights['administrator']==1) || (isset($archive_rights['menu']) && ($archive_rights['menu']==1)))) {
								
						?>						
							<li class="nav-item start <?=($active_id==12 ? 'active open' : '')?>">
								<a href="<?=$this->applink['menu']?>" class="nav-link ">
									<i class="fa fa-bars"></i>
									<span class="title">Meniu principal</span>
									<!--<span class="badge badge-danger">1</span>-->
								</a>
							</li>
						<?php } ?>
						
						<?php
							$archive_rights = $this->GetUserRightsOfArchive('sectii', $this->user_rights_by_admin);
							if ( $archive_rights && (($archive_rights['administrator']==1) || (isset($archive_rights['sectii']) && ($archive_rights['sectii']==1)))) {
								
						?>						
							<li class="nav-item start <?=($active_id==11 ? 'active open' : '')?>">
								<a href="<?=$this->applink['sectii']?>" class="nav-link ">
									<i class="fa fa-file-text-o"></i>
									<span class="title">Continut website/pagini</span>
									<!--<span class="badge badge-danger">1</span>-->
								</a>
							</li>
						<?php } ?>
						<?php
							$archive_rights = $this->GetUserRightsOfArchive('infoutile', $this->user_rights_by_admin);
							if ( $archive_rights && (($archive_rights['administrator']==1) || (isset($archive_rights['infoutile']) && ($archive_rights['infoutile']==1)))) {
								
						?>						
							<li class="nav-item start <?=($active_id==33 ? 'active open' : '')?>">
								<a href="<?=$this->applink['infoutile']?>" class="nav-link ">
									<i class="fa fa-info-circle"></i>
									<span class="title">Lista servicii</span>
									<!--<span class="badge badge-danger">1</span>-->
								</a>
							</li>
						<?php } ?>
						
						<?php
							$archive_rights = $this->GetUserRightsOfArchive('evenimente', $this->user_rights_by_admin);
							if ( $archive_rights && (($archive_rights['administrator']==1) || (isset($archive_rights['evenimente']) && ($archive_rights['evenimente']==1)))) {
								
						?>						
							<li class="nav-item start <?=($active_id==13 ? 'active open' : '')?>">
								<a href="<?=$this->applink['evenimente']?>" class="nav-link ">
									<i class="fa fa-calendar"></i>
									<span class="title">Articole de specialitate</span>
									<!--<span class="badge badge-danger">1</span>-->
								</a>
							</li>
						<?php } ?>
						
						
						<?php
							$archive_rights = $this->GetUserRightsOfArchive('utilizatori', $this->user_rights_by_admin);
							if ( $archive_rights && (($archive_rights['administrator']==1) || (isset($archive_rights['utilizatori']) && ($archive_rights['utilizatori']==1)))) {
						?>
							<li class="nav-item start <?=($active_id==120 ? 'active open' : '')?>">
								<a href="<?=__ADMINURL__?>?pn=2&archtype=utilizatori" class="nav-link ">
									<i class="fa fa-user-secret"></i>
									<span class="title">Utilizatori</span>
									<!--<span class="badge badge-danger">1</span>-->
								</a>
							</li>
						<?php } ?>
						
						<?php
							$archive_rights = $this->GetUserRightsOfArchive('setari', $this->user_rights_by_admin);
							if ( $archive_rights && ($archive_rights['administrator']==1)) {
						?>						
                        <li class="nav-item start <?=($active_id==100 ? 'active open' : '')?>">
							<a href="<?=__ADMINURL__?>?pn=3&archtype=setari&id=MFdlWE8wQktlZUtwNHZMU282Y0VLUT09&redirect=<?=urlencode(__ADMINURL__)?>%3Fpn%3D2%26archtype%3Dsetari&tab=1" class="nav-link ">                            
                                <i class="fa fa-cog"></i>
                                <span class="title">Setari website</span>
                                <!--<span class="badge badge-danger">1</span>-->
                            </a>
                        </li>
						<?php } ?>						
						<!-- **************************************** -->

                    </ul>
                    <!-- END SIDEBAR MENU -->
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->

		<?php
	}	
	/* ------------------------------------------------------------------------------------- */
	public function ShowQuickSideBar() {
		
		$display_quick_sidebar = 0;
		if ($this->display_quick_sidebar==1) { $display_quick_sidebar = 1;}
		if ($this->display_quick_sidebar==2) { $display_quick_sidebar = $this->LoggedUserIsAdmin();}		
		if ($display_quick_sidebar) {
		?>
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
            <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                <div class="page-quick-sidebar">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Utilizatori
                                <!--<span class="badge badge-danger">2</span>-->
                            </a>
                        </li>
						<!--
                        <li>
                            <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alerts
                                <span class="badge badge-success">7</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> More
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                        <i class="icon-bell"></i> Alerts </a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                        <i class="icon-info"></i> Notifications </a>
                                </li>
                                <li>
                                    <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                        <i class="icon-speech"></i> Activities </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                        <i class="icon-settings"></i> Settings </a>
                                </li>
                            </ul>
                        </li>
						-->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                            <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                <h3 class="list-heading">Utilizatori</h3>
                                <ul class="media-list list-items" id="user_list">
									<?=$this->quick_sidebar_content?>
                                </ul>
                            </div>
                        </div>
						<!--
                        <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                            <div class="page-quick-sidebar-alerts-list">
                                <h3 class="list-heading">General</h3>
                                <ul class="feeds list-items">
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> You have 4 pending tasks.
                                                        <span class="label label-sm label-warning "> Take action
                                                            <i class="fa fa-share"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> Just now </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bar-chart-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> Finance Report for year 2013 has been released. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 20 mins </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 24 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received with
                                                        <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 30 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 24 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-bell-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> Web server hardware needs to be upgraded.
                                                        <span class="label label-sm label-warning"> Overdue </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 2 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-default">
                                                            <i class="fa fa-briefcase"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> IPO Report for year 2013 has been released. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 20 mins </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <h3 class="list-heading">System</h3>
                                <ul class="feeds list-items">
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> You have 4 pending tasks.
                                                        <span class="label label-sm label-warning "> Take action
                                                            <i class="fa fa-share"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> Just now </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-danger">
                                                            <i class="fa fa-bar-chart-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> Finance Report for year 2013 has been released. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 20 mins </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 24 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received with
                                                        <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 30 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 24 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> Web server hardware needs to be upgraded.
                                                        <span class="label label-sm label-default "> Overdue </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 2 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-info">
                                                            <i class="fa fa-briefcase"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> IPO Report for year 2013 has been released. </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 20 mins </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
						-->
						<!--
                        <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                            <div class="page-quick-sidebar-settings-list">
                                <h3 class="list-heading">General Settings</h3>
                                <ul class="list-items borderless">
                                    <li> Enable Notifications
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Allow Tracking
                                        <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Log Errors
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Auto Sumbit Issues
                                        <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Enable SMS Alerts
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                </ul>
                                <h3 class="list-heading">System Settings</h3>
                                <ul class="list-items borderless">
                                    <li> Security Level
                                        <select class="form-control input-inline input-sm input-small">
                                            <option value="1">Normal</option>
                                            <option value="2" selected>Medium</option>
                                            <option value="e">High</option>
                                        </select>
                                    </li>
                                    <li> Failed Email Attempts
                                        <input class="form-control input-inline input-sm input-small" value="5" /> </li>
                                    <li> Secondary SMTP Port
                                        <input class="form-control input-inline input-sm input-small" value="3560" /> </li>
                                    <li> Notify On System Error
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                    <li> Notify On SMTP Error
                                        <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF"> </li>
                                </ul>
                                <div class="inner-content">
                                    <button class="btn btn-success">
                                        <i class="icon-settings"></i> Save Changes</button>
                                </div>
                            </div>
                        </div>
						-->
                    </div>
                </div>
            </div>
            <!-- END QUICK SIDEBAR -->

		<?php
		}
	}
	/* ------------------------------------------------------------------------- */
	public function SetQuickNav(){
		$encoded_zero   = el_encript_info('0');
		$link_events    = __ADMINURL__."?pn=2&archtype=evenimente";    $link_event_add    = __ADMINURL__."?pn=3&archtype=evenimente&id=$encoded_zero&redirect=".urlencode($link_events);
		$link_ads       = __ADMINURL__."?pn=2&archtype=anunturi";      $link_ads_add      = __ADMINURL__."?pn=3&archtype=anunturi&id=$encoded_zero&redirect=".urlencode($link_ads);
		$link_clienti   = __ADMINURL__."?pn=2&archtype=clienti";   $link_client_add   = __ADMINURL__."?pn=3&archtype=clienti&id=$encoded_zero&redirect=".urlencode($link_clienti);
		$link_contracte = __ADMINURL__."?pn=2&archtype=contracte"; $link_contract_add = __ADMINURL__."?pn=3&archtype=contracte&id=$encoded_zero&redirect=".urlencode($link_clienti);
		$this->AddItemToQuickNav('Adauga Eveniment', $link_event_add, 'fa fa-calendar');
		$this->AddItemToQuickNav('Adauga Anunt', $link_ads_add, 'fa fa-bullhorn');
		/*$this->AddItemToQuickNav('Adauga Activitate', '#', 'fa fa-hourglass-3');*/
	}	
	/* ------------------------------------------------------------------------- */
}

?>