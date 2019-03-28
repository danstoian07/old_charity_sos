            <!-- BEGIN CONTAINER -->
            <div class="page-container">
				<?=$this->parent->ShowSidebar(117)?>
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
                            </div>
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
						<?php
							if ((!empty($this->archive_title_top_big)) || (!empty($this->archive_title_top_small))) {
								echo '<h3 class="page-title"> '.$this->archive_title_top_big.'
										<small>'.$this->archive_title_top_small.'</small>
									  </h3>'.PHP_EOL;
							}
						?>                                            <!-- END PAGE TITLE-->
                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PROFILE SIDEBAR -->
                                <div class="profile-sidebar">
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light profile-sidebar-portlet ">
                                        <!-- SIDEBAR USERPIC -->
										<!--
                                        <div class="profile-userpic">
                                            <img src="<?=__ADMINURL__?>resources/logo-super-big.jpg" class="img-responsive" alt="Easy Law">
										</div>
										
                                        <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> EASY LAW </div>
                                            <div class="profile-usertitle-job"> Software pentru avocati </div>
                                        </div>
                                        <div class="profile-userbuttons">
                                            <button type="button" class="btn btn-circle green btn-sm" onclick="cst_message_load_html('Despre...','<?=__ADMINURL__?>resources/info/hlp_about.php');">Info aplicatie</button>
                                            <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                        </div>
										-->
                                        <!-- SIDEBAR MENU -->
                                        <div class="profile-usermenu">
                                            <ul class="nav">
												<?php
													require(addslashes(PATH_HELP_FOLDER.'hlp_menu.php'));
												?>
                                            </ul>
                                        </div>
                                        <!-- END MENU -->
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                    <!-- PORTLET MAIN -->
                                    <div class="portlet light ">
                                        <!-- STAT -->
                                        <!-- END STAT -->
                                        <div>
											<!--
                                            <h4 class="profile-desc-title">Salut <em><?=$this->parent->user_name?></em>,</h4>
                                            <span class="profile-desc-text"> Daca intampini dificultati in folosirea aplicatiei ne poti trimite un mesaj prin intermediul sectiunii <a href="">suport online</a> sau apasand butonul de mai jos. </span>
                                            <div class="margin-top-20">
												<div class="btn-group">
													<button id="sample_editable_1_new" class="btn btn-default sbold"> Solicita ajutor
														<i class="fa fa-question-circle"></i>
													</button>
												</div>												                                                
                                            </div>
											-->
                                        </div>
                                    </div>
                                    <!-- END PORTLET MAIN -->
                                </div>
                                <!-- END BEGIN PROFILE SIDEBAR -->
                                <!-- BEGIN TICKET LIST CONTENT -->
                                <div class="app-ticket app-ticket-list">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light ">
												<?php 
													if ($this->parent->hlpid==1) {
														echo $this->InfoSupport();
													}
												?>
												<!-- **************************************************** -->
												<?php
													require(addslashes(PATH_HELP_FOLDER.$this->parent->hlpid.'.php'));
												?>												
												<!-- **************************************************** -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PROFILE CONTENT -->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
				<?=$this->parent->ShowQuickSideBar()?>
            </div>
            <!-- END CONTAINER -->
