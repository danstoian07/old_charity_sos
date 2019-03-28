        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <?=$this->parent->ShowSidebar(110)?>
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <?=$this->parent->ShowThemePanelSettings()?>
					<!-- BEGIN PAGE BAR -->
					<div class="page-bar">
						<?=$this->ShowBreadcrumbs()?>
						<div class="page-toolbar">
							<?=$this->ShowActions()?>
							<div class="btn-group pull-right mr10">
								<button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Schema culori
									<i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right" role="menu">
									<?php
										foreach ($this->parent->color_schemes as $key => $item) {											
											$arr_colors  = json_decode($item['json'], true);
											$item_title = $item['title'];
											if ($item['json']==$this->parent->json_calendar_colors) {
												$item_title = '<em class="font-bold">'.$item['title'].'</em>';
											}
											$link = __ACTIONURL__.'s-set-calendar-colors.php?jcolors='.urlencode($item['json']);
											echo '<li><a href="'.$link.'"><i style="color:'.$arr_colors['universal_f1'].';" class="fa fa-square"></i><i style="color:'.$arr_colors['universal_f3'].';" class="fa fa-square"></i> '.$item_title.'</a></li>'.PHP_EOL;
										}
									?>
									<!--
									<li class="divider"> </li>
									<li><a href="<?=__ADMINURL__?>?pn=3&archtype=utilizator&id=<?=$this->parent->user_id_cript?>&tab=2">Personalizeaza culori</a></li>
									-->
								</ul>
							</div>
							<a class="btn btn-sm green  mr10" data-toggle="modal" href="#myevent"> Adauga eveniment <i class="fa fa-plus"></i></a>
							<!--
							-->
						</div>
					</div>
					<!-- END PAGE BAR -->					
                    <!-- BEGIN PAGE TITLE-->
						<h3 class="page-title" id="bbb"><strong><a href="">EASY CALENDAR | <?=($calendar_type==0 ?'EVENIMENTE UTILIZATOR' : 'EVENIMENTE SOCIETATE')?></a></strong></h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
							<div class="portlet">                                    
								<div class="portlet-body">
									<!-- ************************************* -->
									<div id="script-warning">
										<code>Eroare incarcare date</code> EASY Calendar.
									</div>

									<div id="loading">incarcare calendar...</div>
									
									<div id="calendar"></div>
									<!-- ************************************* -->
								</div>
							</div>
                        </div>
                    </div>
					<!-- ***************************************** -->
					<!-- ****** modal window add event ******      -->
                                        <div class="modal fade bs-modal-lg" id="myevent" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title"><i class="fa fa-calendar" aria-hidden="true"></i> Adauga eveniment</h4>
                                                    </div>
                                                    <div class="modal-body"> 
													<!-- ************************************************** -->
													<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
														<form class="form-horizontal" role="form">
															<div class="tabbable-custom "> 
																<ul class="nav nav-tabs ">
																	<li class="active">
																		<a href="#tab_5_1" data-toggle="tab"> Eveniment </a>
																	</li>
																	<li>
																		<a href="#tab_5_2" data-toggle="tab"> Notificari </a>
																	</li>
																</ul>
																<div class="tab-content">
																	<div class="tab-pane active" id="tab_5_1">
																		<div class="row">
																			<div class="col-md-6">
																				<div class="form-body">
																					<!-- --------------------------------------------- -->
																							<div class="form-group">
																								<label class="col-md-3 control-label">Titlu eveniment</label>
																								<div class="col-md-9">
																									<input type="text" class="form-control" placeholder="" name="e_title">
																								</div>
																							</div>
																							<div class="form-group">
																								<label class="col-md-3 control-label">Descriere</label>
																								<div class="col-md-9">
																									<textarea class="form-control" rows="3"></textarea>
																								</div>
																							</div>
																							<div class="form-group">
																								<label class="col-md-3 control-label">Culoare eveniment</label>
																								<div class="col-md-9">
																									<input type="color" class="form-control" placeholder="" name="e_title">
																								</div>
																							</div>																					
																					<!-- --------------------------------------------- -->
																				</div>
																			</div>
																			<div class="col-md-6">
																			</div>
																		</div>	
																	</div>
																	<div class="tab-pane" id="tab_5_2">
																		<p> Howdy, I'm in Section 2. </p>
																			<a class="btn green" href="ui_tabs_accordions_navs.html#tab_5_2" target="_blank"> Activate this tab via URL </a>
																		</p>
																	</div>
																</div>
															</div>
														</form>
													</div>
													<!-- ************************************************** -->
													</div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Inchide</button>
                                                        <button type="button" class="btn green">Adauga eveniment</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
					
                                        <div id="responsive1" class="modal fade draggable-modal" role="basic" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Responsive & Scrollable</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h4>Some Input</h4>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h4>Some More Input</h4>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                    <p>
                                                                        <input type="text" class="col-md-12 form-control"> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                                                        <button type="button" class="btn green">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
					
					<!-- ***************************************** -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <?=$this->parent->ShowQuickSideBar()?>
        </div>
        <!-- END CONTAINER -->
