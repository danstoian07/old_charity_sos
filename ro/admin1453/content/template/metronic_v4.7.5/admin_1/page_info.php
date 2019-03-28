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
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                                if ($this->parent->message) {
                                    /* array is not empty*/
                                    ?>
                                        <div class="note <?=$this->parent->message[3]?>">                                            
                                            <?php
                                                if($this->parent->message[0] != strip_tags($this->parent->message[0])) {
                                                    // contains HTML
                                                    echo $this->parent->message[0];
                                                } else {
                                                    // no HTML tags in message
                                                    echo '<p>'.$this->parent->message[0].'</p>';
                                                }
                                            ?>                                            
                                        </div>
                                        <div class="clearfix"></div>
                                        <a class="btn btn-success" type="button" href="<?=$this->parent->message[1]?>"><?=$this->parent->message[2]?></a>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <?=$this->parent->ShowQuickSideBar()?>
        </div>
        <!-- END CONTAINER -->
