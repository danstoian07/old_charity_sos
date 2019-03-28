<?php
class calendar extends info_messages {
	/* ------------------------------------------------------------------------------------- */	
	public  $parent;
	public  $active_tab=1;
	public  $activate_menuitem_id = 50;
	public  $archive_title_top_big = '<i class="fa fa-calendar"></i> <strong>Calendar</strong>';
	public  $archive_title_top_small = 'taskuri & evenimente';
	public  $url_referer;
	public  $current_date;
	/* ------------------------------------------------------------------------------------- */	
	public function __construct($oParent=NULL) {
		$this->parent = $oParent;		
		$this->AddItemToBreadcrumbs('Home', __ADMINURL__);
		$this->AddItemToActions('Mergi in Homepage', __ADMINURL__, 'icon-home');		
	}
	/* ------------------------------------------------------------------------------------- */	
	public function Show() {
		include(__THEMEPATH__.'app_header.php');
		include(__THEMEPATH__.'page_calendar.php');
		include(__THEMEPATH__.'app_footer_calendar.php');
	}	
	/* ------------------------------------------------------------------------------------- */
	public function ShowTabs() {
		$curent_date = date('d-m-Y');
		?>
		
			<div class="tabbable-custom">
						<ul class="nav nav-tabs tabs-reversed">
							<li>								
								<div class="pull-left btn-group btn-group-devided">							
									<button type="button" class="btn btn-default" onclick="cst_LoadCalendar_AddDay(-1);"><i class="fa fa-arrow-left"></i></button>
									<button type="button" class="btn btn-default" onclick="cst_LoadCalendar_AddDay(1);"><i class="fa fa-arrow-right"></i></button>
									<button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Eveniment</button>
									<button type="button" class="btn default" onclick="cst_LoadCalendar_ToDay();">Astazi</button>
									<div class="input-group input-small date date-picker pull-left" data-date="<?=$this->current_date?>" data-date-format="dd-mm-yyyy">
										<input class="form-control" readonly="" type="text" value="<?=$this->current_date?>" id="day_selector">
										<span class="input-group-btn">
											<button class="btn default" type="button">
												<i class="fa fa-calendar"></i>
											</button>
										</span>
									</div>								
								</div>										
							</li>
							<li <?=($this->active_tab==3 ? 'class="active"' : '')?>>
								<a href="#tab_3" data-toggle="tab" aria-expanded="true"> Luna </a>
							</li>
							<li <?=($this->active_tab==2 ? 'class="active"' : '')?>>
								<a href="#tab_2" data-toggle="tab" aria-expanded="false"> Saptamana </a>
							</li>					
							<li <?=($this->active_tab==1 ? 'class="active"' : '')?>>
								<a href="#tab_1" data-toggle="tab" aria-expanded="false"> O Zi </a>
							</li>					
						</ul>
					
				
				<div class="tab-content">
					<div <?=($this->active_tab==3 ? 'class="tab-pane active"' : 'class="tab-pane"')?> id="tab_3">
						<p> I'm in Section luna. </p>
						<p> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
							consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat. </p>
					</div>
					<div <?=($this->active_tab==2 ? 'class="tab-pane active"' : 'class="tab-pane"')?> id="tab_2">
						<p> Howdy, I'm in Section saptamana. </p>
						<p> Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie
							consequat. Ut wisi enim ad minim veniam, quis nostrud exerci tation. </p>
						<p>
							<a class="btn green" href="ui_tabs_accordions_navs.html#tab_5_2" target="_blank"> Activate this tab via URL </a>
						</p>
					</div>
					<div <?=($this->active_tab==1 ? 'class="tab-pane active"' : 'class="tab-pane"')?> id="tab_1">						
                            <!--<div class="portlet box green">-->
								<div class="portlet box">
									<div class="portlet-title bg-grey-cararra">
										<div class="caption">
											<i id="day_icon" class="fa fa-calendar-check-o"></i>
											<span class="caption-subject font-dark bold uppercase"><span id="day_title">Zi lucratoare</span></span>
										</div>
										<div class="actions">
											<a class="btn btn-icon-only btn-default" onclick="cst_LoadCalendar_Day();">
												<i class="fa fa-refresh"></i>
											</a>
										</div>
									</div>
								</div>
                                <div class="portlet-body" id="day_content">
									<!-- aici tabel -->
                                </div>
                            <!--</div>-->
							<!-- ******************************* -->
					</div>
				</div>
			</div>		
		<?php
	}
}	
	/* ------------------------------------------------------------------------------------- */
?>