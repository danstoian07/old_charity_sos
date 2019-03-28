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
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal form-row-seperated" action="#" name="<?=$this->getClassName()?>" id="submit-form" method="POST" enctype="multipart/form-data">
                                <div class="portlet">
                                    <?=$this->ShowTopButtons()?>
                                    <div class="portlet-body">
										<!--<div class="tabbable-bordered">-->
                                        <div class="tabbable-custom">
                                            <?=$this->ShowTabs()?>
                                        </div>
                                    </div>
									<?=$this->ShowTopButtons(false)?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <?=$this->parent->ShowQuickSideBar()?>
        </div>
        <!-- END CONTAINER -->
