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
                    ?>                    
                    <!-- END PAGE TITLE-->
                    <!-- BEGIN ALERTS-->
                    <?php
                        if ($this->alerts) {
                            ?>
                            <div class="row">
                                <div class="col-md-12">                            
                                <?php
                                    $this->ShowAlerts();
                                ?>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    <!-- END ALERTS-->

                    <!-- BEGIN NOTIFICATIONS-->
                    <?php
                        if ($this->notifications) {
                            ?>
                            <div class="row">
                                <div class="col-md-12">                            
                                <?php
                                    $this->ShowNotifications();
                                ?>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    <!-- END NOTIFICATIONS-->
                    <!-- END PAGE HEADER-->
					<!-- ******************************************* -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats -->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="<?=$this->list_archive_icon_class?> font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase"><?=$this->list_archive_title?></span>
                                    </div>
                                    <div class="actions">
                                        <div class="btn-group btn-group-devided">
											<a class="btn btn-success" href="<?=$this->LinkToAddItem();?>">  <i class="fa fa-file-o"></i> <?=$this->list_add_button_name;?> </a>
											<!--<a class="btn btn-default" role="button" href="javascript:grid.getDataTable().ajax.reload();">  <i class="fa fa-refresh"></i> Refresh </a>-->
											<button class="btn btn-default" type="button" onclick="grid.getDataTable().ajax.reload('',false);"><i class="fa fa-refresh"></i> Refresh</button>
                                        </div>
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-outline" href="javascript:;" data-toggle="dropdown">
                                                <i class="fa fa-share"></i>
                                                <span class="hidden-xs"> Instrumente </span>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="<?=$this->LinkExportToMSExcel()?>" > Exporta in MSExcel </a>
                                                </li>
                                                <li>
                                                    <a href="<?=$this->LinkExportToCSV()?>"> Exporta in CSV </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-container">
                                        <div class="table-actions-wrapper">
                                            <span> </span>
                                            <select class="table-group-action-input form-control input-inline input-small input-sm">
                                                <option value="">Actiuni globale...</option>
                                                <?=$this->ReturnGlobalActionsString()?>
                                            </select>
                                            <button class="btn btn-sm green table-group-action-submit">
                                                <i class="fa fa-check"></i><span class="hidden-sm hidden-md hidden-xs"> Executa</span></button>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                                            <thead>
												<?php $this->ShowListHeader(); ?>
                                            </thead>
                                            <tbody> </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- End: life time stats -->
                        </div>
                    </div>					
					<!-- ******************************************* -->
                    <div class="row">
                        <div class="col-md-12">
							<?=$this->ShowLegend()?>
						</div>
					</div>					
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <?=$this->parent->ShowQuickSideBar()?>
        </div>
        <!-- END CONTAINER -->
