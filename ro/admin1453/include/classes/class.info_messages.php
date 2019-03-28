<?php
/* generic class */
class info_messages {

	public  $display_actions = 1;       /* display navication button */
	public  $actions        = array();
	public  $alerts         = array();
	public  $breadcrumbs    = array();
	public  $notifications  = array();
	public  $actions_title  = 'Navigare';

	/* ------------------------------------------------------------------------------------- */
	public function getClassName(){
		return get_class($this);
	}	
	/* ------------------------------------------------------------------------------------- */
	/**
		* Add message to alerts stack
		* @param string   $msg        		 	 Alert message
		* @param int      $msg_type    		 	 Type of message, as per constants: MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING (defined in config.php)
		* @param string   $msg_icon_class	 	 Icon class for notification: Ex: "icon-bell","fa fa-map"
	*/	
	public function AddAlert($msg, $msg_type, $msg_icon_class) {
		if (!empty($msg)) {
			array_push($this->alerts,array($msg, $msg_type, $msg_icon_class));
		}
	}

	/* ------------------------------------------------------------------------------------- */
	/**
		* Remove all notification messages from stack
	*/	
	public function ClearAlerts() {		
		$this->alerts = array_slice($this->alerts, 0, 0); 
	}	
	/* ------------------------------------------------------------------------------------- */
	/* display action top menu */
	public function ShowAlerts() {
			$alerts_length = count($this->alerts);
			if ($alerts_length>0) {
				$str_info = '';
				for ($i = 0; $i < $alerts_length; $i++) {
					if (!empty($this->alerts[$i][0])) {
				    	$str_info .= '<div class="alert '.$this->parent->ReturnAlertsClassFromType($this->alerts[$i][1]).' margin-bottom-10">
									    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
									    '.((!empty($this->alerts[$i][2])) ? '<i class="'.$this->alerts[$i][2].'"></i>' : '').' '.$this->alerts[$i][0].' 
									</div>'.PHP_EOL;
				    }
				}				
				echo $str_info;
			}
	}				
	/* ------------------------------------------------------------------------------------- */
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Add message to notifications stack
		* @param string   $msg        		 	 Notification message
		* @param int      $msg_type    		 	 Type of message, as per constants: MSG_SUCCESS, MSG_INFO, MSG_DANGER, MSG_WARNING (defined in config.php)
	*/	
	public function AddNotification($msg, $msg_type) {
		if (!empty($msg)) {
			array_push($this->notifications,array($msg, $msg_type));
		}
	}

	/* ------------------------------------------------------------------------------------- */	
	/**
		* Remove all notification messages from stack
	*/	
	public function ClearNotifications() {		
		$this->notifications = array_slice($this->notifications, 0, 0); 
	}	
	/* ------------------------------------------------------------------------------------- */
	/* display action top menu */
	public function ShowNotifications() {
			$info_length = count($this->notifications);
			if ($info_length>0) {
				$str_info = '';
				for ($i = 0; $i < $info_length; $i++) {
					if (!empty($this->notifications[$i][0])) {
				    	$str_info .= '<div class="note '.$this->parent->ReturnMessageClassFromType($this->notifications[$i][1]).'">
				    					'.(($this->notifications[$i][0] !=strip_tags($this->notifications[$i][0])) ? $this->notifications[$i][0] : '<p>'.$this->notifications[$i][0].'</p>').'
                            		  </div>'.PHP_EOL;
				    }
				}				
				echo $str_info;
			}
	}				
	/* ------------------------------------------------------------------------------------- */
	/**
		* Add a item to breadcrumbs
		* @param string   $title        		 Items title
		* @param string   $link        		 	 Link of item (Set empty string for: no link)
	*/	
	public function AddItemToBreadcrumbs($title, $link) {
		array_push($this->breadcrumbs,array($title, $link));
	}
	/* ------------------------------------------------------------------------------------- */
	/**
		* Remove all items from breadcrumbs except first
	*/	
	public function ClearBreadcrumbs() {		
		$this->breadcrumbs = array_slice($this->breadcrumbs, 0, 1); 
	}	
	/* ------------------------------------------------------------------------------------- */
	/**
		* Display archive breadcrumbs
	*/	
	public function ShowBreadcrumbs() {
		$breadcrumbs_length = count($this->breadcrumbs);
		$str_items = '<ul class="page-breadcrumb">';
		for ($i = 0; $i < $breadcrumbs_length; $i++) {
			if (!empty($this->breadcrumbs[$i][1])) {
		    	$str_items .= '<li><a href="'.$this->breadcrumbs[$i][1].'">'.$this->breadcrumbs[$i][0].'</a>'.(($i+1)<$breadcrumbs_length ? '<i class="fa fa-circle"></i>' : '').'</li>'.PHP_EOL;
			} else {
				$str_items .= '<li>'.$this->breadcrumbs[$i][0].(($i+1)<$breadcrumbs_length ? '<i class="fa fa-circle"></i>' : '').'</li>'.PHP_EOL;
			}
		}
		$str_items .='</ul>'.PHP_EOL;
		echo $str_items;
	}		
	/* ------------------------------------------------------------------------------------- */	
	public function ShowTopButtons($title_left=true){
		
	}
	/* ------------------------------------------------------------------------------------- */	
	/**
		* Add a item to panel actions
		* @param string   $title        		 Action title
		* @param string   $link        		 	 Link of action (Set empty string for: no link)
		* @param string   $link        		 	 Icon class for action: Ex: "icon-bell"
	*/	
	public function AddItemToActions($title, $link, $icon_class) {
		array_push($this->actions,array($title, $link, $icon_class));
	}

	/* ------------------------------------------------------------------------------------- */	
	/**
		* Remove all items from actions array
	*/	
	public function ClearActions() {		
		$this->actions = array_slice($this->actions, 0, 0); 
	}		
	/* ------------------------------------------------------------------------------------- */	
	/* display action top menu */
	public function ShowActions() {
		if ($this->display_actions) {
			$actions_length = count($this->actions);
			if ($actions_length>0) {
				$str_actions = '<div class="btn-group pull-right">
	                                <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> '.$this->actions_title.'
	                                    <i class="fa fa-angle-down"></i>
	                                </button>
	                                <ul class="dropdown-menu pull-right" role="menu">'.PHP_EOL;
				for ($i = 0; $i < $actions_length; $i++) {
					if (!empty($this->actions[$i][0])) {
				    	$str_actions .= '<li><a href="'.(!empty($this->actions[$i][1]) ? $this->actions[$i][1] : 'javascript:void(0);').'">'.((!empty($this->actions[$i][2])) ? '<i class="'.$this->actions[$i][2].'"></i>' : '').' '.$this->actions[$i][0].'</a></li>'.PHP_EOL;
				    }
				}
				$str_actions .='</ul></div>'.PHP_EOL;
				echo $str_actions;
			}
		}
	}			
	/* ------------------------------------------------------------------------------------- */	
}
?>