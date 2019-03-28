<?php
class archive_help extends archive_custom {
	/* ------------------------------------------------------------------------------------- */	
	public  $list_archive_title			    = 'Help';						/* Title of archive */
	public  $activate_menuitem_id           = 117;					    /* id of menuitem wich will be active when panel show */
	public  $actions_title                  = 'Actiuni';

	public  $archive_title_top_big          	= '<strong>Help aplicatie</strong>';
	public  $archive_title_top_small        	= 'Easy Law <a href="javascript:cst_message_load_html(\'Despre...\',\''.__ADMINURL__.'resources/info/hlp_about.php\');" class="btn green btn-xs">Info</a>';
	
		
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL) {
		parent::__construct($oParent);
		$this->AddItemToBreadcrumbs('Help Easy Law', '');
		$this->AddItemToActions('Help General', __ADMINURL__, 'fa fa-calendar-plus-o');
		$this->AddItemToActions('Help Calendar', __ADMINURL__, 'fa fa-print');
		$this->AddItemToActions('Help Utilizatori', __ADMINURL__, 'fa fa-cog');
		
	}
	/* ------------------------------------------------------------------------------------- */	
	public function IncludeResources() {
		include(__THEMEPATH__.'app_header_help.php');
		include(__THEMEPATH__.'page_help.php');
		include(__THEMEPATH__.'app_footer_help.php');
	}
	/* ------------------------------------------------------------------------------------- */	
	public function InfoToUseSupport() {
		$arr_msg[] = '<strong>Salut <em>'.$this->parent->user_name.'</em></strong>, Daca intampini dificultati in folosirea aplicatiei ne poti trimite un mesaj prin intermediul sectiunii <strong class="font-underline"><a href="'.$this->parent->applink['support'].'">suport online</a></strong>.';
		$arr_msg[] = '<strong>Salut <em>'.$this->parent->user_name.'</em></strong>, Daca ai nevoie de ajutor in folosirea aplicatiei sau ai intampinat o problema tehnica, ne poti solicita ajutorul accesand sectiunea <strong class="font-underline"><a href="'.$this->parent->applink['support'].'">suport online</a></strong>.';
		$arr_msg[] = '<strong>Salut <em>'.$this->parent->user_name.'</em></strong>, Accesand sectiunea <strong class="font-underline"><a href="'.$this->parent->applink['support'].'">suport online</a></strong> ne poti solicita ajutorul daca intampini dificultati in folosirea aplicatiei.';
		$number =  rand (0, count($arr_msg)-1);
		return $this->parent->Alert($arr_msg[$number], MSG_INFO);
	}
	/* ------------------------------------------------------------------------------------- */
	public function InfoToBuySupport() {
		$arr_msg[] = '<strong>Salut <em>'.$this->parent->user_name.'</em></strong>, Nu ai achizitionat inca pachetul de <span class="bold"><a class="font-yellow-gold font-underline" href="'.$this->parent->applink['support'].'">suport online</a></span>. Poti beneficia de asistenta tehnica specializata din partea echipei Easy law.';
		$arr_msg[] = '<strong>Salut <em>'.$this->parent->user_name.'</em></strong>, Achizitionand un pachet de <span class="bold"><a class="font-yellow-gold font-underline" href="'.$this->parent->applink['support'].'">suport online</a></span> vei beneficia de asistenta tehnica specializata, rapid, direct din contul tau.';
		$arr_msg[] = '<strong>Salut <em>'.$this->parent->user_name.'</em></strong>, Daca achizitionezi pachetul de <span class="bold"><a class="font-yellow-gold font-underline" href="'.$this->parent->applink['support'].'">suport online</a></span> vei beneficia rapid, atunci cand ai nevoie, de asistenta tehnica specializata.';
		$arr_msg[] = '<strong>Salut <em>'.$this->parent->user_name.'</em></strong>, Vei beneficia oricand de suport tehnic specializat daca achizitionezi un pachet de <span class="bold"><a class="font-yellow-gold font-underline" href="'.$this->parent->applink['support'].'">suport online</a></span>.';
		$number =  rand (0, count($arr_msg)-1);
		return $this->parent->Alert($arr_msg[$number], MSG_WARNING);
	}
	/* ------------------------------------------------------------------------------------- */
	public function InfoSupport() {
		if ($this->parent->user_have_support) {
			return $this->InfoToUseSupport();
		} else {
			return $this->InfoToBuySupport();
		}
	}
	/* ------------------------------------------------------------------------------------- */
	public function InfoHelp() {
		
	}
	/* ------------------------------------------------------------------------------------- */
	
}