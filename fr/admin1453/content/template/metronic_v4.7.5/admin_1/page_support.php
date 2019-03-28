            <!-- BEGIN CONTAINER -->
            <div class="page-container">
				<?=$this->parent->ShowSidebar($this->activate_menuitem_id)?>
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
                                <!-- continut suport tehnic -->
								<?php
									if ($this->parent->user_have_support) {
								?>
									<iframe src="<?=APP_SUPPORT_LINK?>" width="100%" height="2300px" frameborder="0"></iframe>
								<?php 
									} else {
								?>
								<div class="alert alert-warning alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
									<h2 class="font-blue-chambray"><i class="fa fa-exclamation-triangle"></i> Sistemul de suport tehnic nu este activ pentru <?=el_decript_info($_SESSION[APP_ID]["user"]["company"])?>.</h2>
									<p class="font-blue-chambray">Pentru a putea folosi sistemul de suport tehnic online trebuie sa achizitionezi un pachet de suport. Mai multe detalii gasesti pe site-ul <a target="_blank" href="<?=APP_WEBSITE?>"><?=APP_WEBSITE?></a>.</p>
									<p>&nbsp;</p>
									<a href="<?=APP_WEBSITE?>" target="_blank" type="button" class="btn grey-mint">Afla detalii</a>
								</div>
								<h3 class="page-title">In ce consta pachetul de suport tehnic ?</h3>
								<p>Pentru a te putea ajuta, folosim un sistem de suport online profesional, prin tickete. Daca ai o problema in momentul folosirii aplicatiei ne poti trimite o solicitare. Fiecarei solicitari de asistenta i se atribuie un numar unic de ticket pe care il poti utiliza pentru a urmari starea solicitarii. Pentru orice solicitare, iti oferim un istoric complet al tuturor mesajelor de asistenta. Pentru a accesa sistemul de suport este necesar sa achizitionezi un pachet de suport tehnic si sa ai o adresa de e-mail valabila. </p>
								<?php 
									}
								?>
								
								<!-- end continut suport tehnic -->
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
				<?=$this->parent->ShowQuickSideBar()?>
            </div>
            <!-- END CONTAINER -->
