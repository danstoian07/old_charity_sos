<?php
/* generic class */
class archive_custom extends info_messages {
	/* ------------------------------------------------------------------------------------- */	
	public  $parent;
	public  $archtype;													/* archive name */
	public  $table_name                     = '';
	public  $list_archive_title			    = '';						/* Title of archive */
	public  $list_archive_icon_class        = 'fa fa-folder-open-o';	/* icon for title of archive */		
	public  $activate_menuitem_id           = 110;					    /* id of menuitem wich will be active when panel show */
	public  $user_rights_by_admin           = array();					/* array cu drepturi utilizator pentru aceasta arhiva, setate de administratorul sistemului */	
		
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL) {
		$this->parent 				= $oParent;
		$this->user_id              = el_decript_info($_SESSION[APP_ID]["user"]["id"]);
		$this->archtype             = preg_replace('/archive_/', '', get_class($this), 1);	
		$this->user_rights_by_admin = $this->SetArchiveUserRightsByAdmin();
		$this->AddItemToBreadcrumbs('Home', __ADMINURL__);
	}
	/* ------------------------------------------------------------------------------------- */	
    public function createProperty($name, $value){
        $this->{$name} = $value;
    }			
	/* ------------------------------------------------------------------------------------- */
	public function IncludeResources() {
		
	}
	/* ------------------------------------------------------------------------------------- */
	public function ShowPanel() {
		 global $oDB;
		 $ERROR     = false;
		 $ERROR_MSG = '';		
		 if (!$ERROR) {
			 if (!$this->CanAccessPanelLoggedUser()) {
				 $ERROR = true; $ERROR_MSG = 'Nu aveti drept de acces in sectiunea: '.$this->list_archive_title.'!';
			 }
		 }
		 if ($ERROR) {
			 if (!empty($this->parent)) {
				$this->parent->ShowMessage($ERROR_MSG,'','&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;',MSG_WARNING);
			 }
		 } else {
			$this->IncludeResources();
			adm_AddTrackingInfo('Acceseaza sectiunea: '.$this->list_archive_title);
		 }
	}				
	/* ------------------------------------------------------------------------------------- */	
	public function CanAccessPanelLoggedUser() {
		$GRANTED_ACCES = true;
		if ( $this->user_rights_by_admin && (($this->user_rights_by_admin['administrator']==1) || (isset($this->user_rights_by_admin["$this->archtype"]) && ($this->user_rights_by_admin["$this->archtype"]==1)))) {
			// acces permis			
		} else {
			$GRANTED_ACCES = false;
		}		
		return $GRANTED_ACCES;		
	}
	/* ------------------------------------------------------------------------------------- */	
	public function SetArchiveUserRightsByAdmin(){
		$arr_return_rights = $this->GetArchiveUserRightsByAdmin($this->archtype);		
		if ($arr_return_rights) {			
			if ($arr_return_rights["administrator"]==0) {
				if ((isset($arr_return_rights["$this->archtype"])) && ($arr_return_rights["$this->archtype"]!=0)) {
					foreach ($arr_return_rights as $key => $value) {
						if (($key!="administrator") && ($key!=$this->archtype)) {
							if (property_exists(get_class($this), $key)) {
								$eval_str = "\$this->$key = $value;";
								eval($eval_str);
							} else {
								$this->createProperty($key, $value);
							}
						}
					}
				} else {
					/* daca arhiva nu este setata in class.tab_utilizator_rights.php, se vor lua in considerare drepturile de aici. A se seta daca este cazul. Daca nu e setat nimic, se vor lua in consideratie drepturile implicite ale arhivei */
				}
					
			} else {
				// este administrator; are drepturi implicite pentru arhiva, setate de programator
			}
		}		
		return $arr_return_rights;
	}		
	/* ------------------------------------------------------------------------------------- */
	public function GetArchiveUserRightsByAdmin($archtype){
		$arr_return_rights = array();
		$arr_all_user_rights = json_decode( el_decript_info($_SESSION[APP_ID]["user"]["rights"]), true);
		if ($arr_all_user_rights) {
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
		}
		return $arr_return_rights;
	}	
	/* ------------------------------------------------------------------------------------- */
}