         <?php if ($this->parent->session_expire) { ?>
        <div class="modal fade" id="idle-timeout-dialog" data-backdrop="static">
            <div class="modal-dialog modal-small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?=_('Sesiunea de lucru urmeaza sa expire !')?></h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <i class="fa fa-warning font-red"></i> <?=_('Sesiunea se va inchide in')?>
                            <span id="idle-timeout-counter"></span> <?=_('secunde')?>.</p>
                        <p> <?=_('Doriti sa continuati sesiunea de lucru ?')?> </p>
                    </div>
                    <div class="modal-footer">
                        <button id="idle-timeout-dialog-logout" type="button" class="btn dark btn-outline sbold uppercase"><?=_('Logout')?></button>
                        <button id="idle-timeout-dialog-keepalive" type="button" class="btn green btn-outline sbold uppercase" data-dismiss="modal"><?=_('Pastraza-ma logat')?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> 
                <?=$this->parent->CopyrightInfo()?>&nbsp;&nbsp;<?=$this->parent->FooterInfo()?>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>	
        <!-- BEGIN QUICK NAV -->
		<?php /*$this->parent->ShowQuickNav();*/ ?>
	
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="<?=__THEMEURL__?>assets/global/plugins/respond.min.js"></script>
<script src="<?=__THEMEURL__?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?=__THEMEURL__?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>		
		<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css"><!-- elfinder -->
		
		
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script><!-- elfinder: atentie!! dupa botstrap.min.js -->
        <script src="<?=__THEMEURL__?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->		
        <!-- BEGIN PAGE LEVEL PLUGINS -->        
        <script src="<?=__THEMEURL__?>assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>		
        <script src="<?=__THEMEURL__?>assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>


        <script src="<?=__THEMEURL__?>assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        
        <!-- END PAGE LEVEL PLUGINS -->        

        <script src="<?=__THEMEURL__?>assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
		<script src="<?=__THEMEURL__?>assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
		
			
			<script src="<?=__THEMEURL__?>assets/global/scripts/datatable.js" type="text/javascript"></script>
			<script src="<?=__THEMEURL__?>assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
			<script src="<?=__THEMEURL__?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
			<script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>		
		
		<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css"><!-- elfinder -->
		<link href="<?=__UTILSAPP__?>/elFinder/css/elfinder.min.css" rel="stylesheet" type="text/css">
		<link href="<?=__UTILSAPP__?>/elFinder/css/theme.css" rel="stylesheet" type="text/css">

		<script src="<?=__UTILSAPP__?>elFinder/js/elfinder.min.js"></script>		
		<script src="<?=__THEMEURL__?>assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script type="text/javascript">
			/* ckeditor config */
			//CKEDITOR.config.contentsCss = '<?=__ADMINURL__?>admin.css' ; 
			CKEDITOR.config.extraPlugins = 'youtube';
			CKEDITOR.config.smiley_path  = '<?=__APPRESOURCESURL__?>smiley/';
		</script>		
		<script type="text/javascript">	
			(function(){
				var elfNode, elfInsrance, dialogName,
					elfUrl				= '<?=__UTILSAPP__?>elFinder/php/connector.php', // Your connector's URL
					elfDirHashMap = { // Dialog name / elFinder holder hash Map
						image : '', // 3st LocalFileVolume "/CKE_Imgs"
						flash : '',
						files : '',
						link  : '',
						fb    : 'l2_Lw'
					},
					customData = {};
				
				var getLang = function() {
					try {
						var full_lng;
						var loct = window.location.search;
						var locm;
						if (loct && (locm = loct.match(/lang=([a-zA-Z_-]+)/))) {
							full_lng = locm[1];
						} else {
							full_lng = (navigator.browserLanguage || navigator.language || navigator.userLanguage);
						}
						var lng = full_lng.substr(0,2);
						if (lng == 'ja') lng = 'jp';
						else if (lng == 'pt') lng = 'pt_BR';
						else if (lng == 'zh') lng = (full_lng.substr(0,5) == 'zh-tw')? 'zh_TW' : 'zh_CN';

						if (lng != 'en') {
							var script_tag		= document.createElement("script");
							script_tag.type		= "text/javascript";
							script_tag.src		= "./js/i18n/elfinder."+lng+".js";
							script_tag.charset = "utf-8";
							$("head").append(script_tag);
						}

						return lng;
					} catch(e) {
						return 'en';
					}
				},
				getShowImgSize = function(url, callback) {
					var ret = {};
					$('<img/>').attr('src', url).on('load', function() {
						var w = this.naturalWidth,
							h = this.naturalHeight,
							s = 400;
						if (w > s || h > s) {
							if (w > h) {
								h = h * (s / w);
								w = s;
							} else {
								w = w * (s / h);
								h = s;
							}
						}
						callback({width: w, height: h});
					});
				};

				CKEDITOR.on('dialogDefinition', function (event) {
					var editor = event.editor,
						dialogDefinition = event.data.definition,
						tabCount = dialogDefinition.contents.length,
						browseButton, uploadButton, submitButton, inputId;
					
					for (var i = 0; i < tabCount; i++) {
						browseButton = dialogDefinition.contents[i].get('browse');
						uploadButton = dialogDefinition.contents[i].get('upload');
						submitButton = dialogDefinition.contents[i].get('uploadButton');

						if (browseButton !== null) {
							browseButton.hidden = false;
							browseButton.onClick = function (dialog, i) {
								dialogName = CKEDITOR.dialog.getCurrent()._.name;
								if (elfNode) {
									if (elfDirHashMap[dialogName] && elfDirHashMap[dialogName] != elfInsrance.cwd().hash) {
										elfInsrance.request({
											data	 : {cmd	 : 'open', target : elfDirHashMap[dialogName]},
											notify : {type : 'open', cnt : 1, hideCnt : true},
											syncOnFail : true
										});
									}
									elfNode.dialog('open');
								}
							} 
						} 
						
						if (uploadButton !== null && submitButton !== null) {
							uploadButton.hidden = false;
							submitButton.hidden = false;
							uploadButton.onChange = function() {
								inputId = this.domId;
							}
							submitButton.onClick = function(e) {
								dialogName = CKEDITOR.dialog.getCurrent()._.name;
								var target = elfDirHashMap[dialogName]? elfDirHashMap[dialogName] : elfDirHashMap['fb'],
									name = $('#'+inputId),
									input = name.find('iframe').contents().find('form').find('input:file'),
									error = function(err) {
										alert(elfInsrance.i18n(err).replace('<br>', '\n'));
									};
								
								if (input.val()) {
									var fd = new FormData();
									fd.append('cmd', 'upload');
									fd.append('overwrite', 0);
									fd.append('target', target);
									$.each(customData, function(key, val) {
										fd.append(key, val);
									});
									fd.append('upload[]', input[0].files[0]);
									$.ajax({
										url: editor.config.filebrowserUploadUrl,
										type: "POST",
										data: fd,
										processData: false,
										contentType: false,
										dataType: 'json'
									})
									.done(function( data ) {
										if (data.added && data.added[0]) {
											var url = data.added[0].url;
											var dialog = CKEDITOR.dialog.getCurrent();
											if (dialogName == 'image') {
												var urlObj = 'txtUrl'
											} else if (dialogName == 'flash') {
												var urlObj = 'src'
											} else if (dialogName == 'files' || dialogName == 'link') {
												var urlObj = 'url'
											} else {
												return;
											}
											dialog.selectPage('info');
											dialog.setValueOf('info', urlObj, url);
											if (dialogName == 'image') {
												getShowImgSize(url, function(size) {
													dialog.setValueOf('info', 'txtWidth', size.width);
													dialog.setValueOf('info', 'txtHeight', size.height);
													dialog.preview.$.style.width = size.width+'px';
													dialog.preview.$.style.height = size.height+'px';
												});
											}
										} else {
											error(data.error || data.warning || 'errUploadFile');
										}
									})
									.fail(function() {
										error('errUploadFile');
									})
									.always(function() {
										input.val('');
									});
									
									/*
									elfInsrance.options.customData.overwrite = 0;
									elfInsrance.upload({input : input[0], type : 'files', target : target, renames : []})
										.fail(function(err) {
											error(err || 'errUploadFile');
										})
										.done(function(data) {
											if (data.added && data.added[0]) {
												var url = data.added[0].url;
												var dialog = CKEDITOR.dialog.getCurrent();
												if (dialogName == 'image') {
													var urlObj = 'txtUrl'
												} else if (dialogName == 'flash') {
													var urlObj = 'src'
												} else if (dialogName == 'files' || dialogName == 'link') {
													var urlObj = 'url'
												} else {
													return;
												}
												dialog.selectPage('info');
												dialog.setValueOf(dialog._.currentTabId, urlObj, url);
												if (dialogName == 'image') {
													dialog.setValueOf(dialog._.currentTabId, 'width', getShowImgSize(url).width);
												}
											} else {
												error(data.error || data.warning || 'errUploadFile');
											}
										})
										.always(function() {
											input.val('');
										});
									delete elfInsrance.options.customData.overwrite;
									*/
								}
								return false;
							}
						}

					} 
				});

				CKEDITOR.on('instanceReady', function(e) {
					elfNode = $('<div>');
					elfNode.dialog({
						autoOpen: false,
						modal: true,
						width: '80%',
						title: 'Server File Manager',
						create: function (event, ui) {
							var startPathHash = (elfDirHashMap[dialogName] && elfDirHashMap[dialogName])? elfDirHashMap[dialogName] : '';
							// elFinder configure
							elfInsrance = $(this).elfinder({
								startPathHash: startPathHash,
								useBrowserHistory: false,
								resizable: false,
								width: '100%',
								url: elfUrl,
								lang: getLang(),
								getFileCallback: function (file) {
									var url = file.url;
									var dialog = CKEDITOR.dialog.getCurrent();
									if (dialogName == 'image') {
										var urlObj = 'txtUrl'
									} else if (dialogName == 'flash') {
										var urlObj = 'src'
									} else if (dialogName == 'files' || dialogName == 'link') {
										var urlObj = 'url'
									} else {
										return;
									}
									dialog.setValueOf(dialog._.currentTabId, urlObj, url);
									elfNode.dialog('close');
									elfInsrance.disable();
								}
							}).elfinder('instance');
						},
						open: function() {
							elfNode.find('div.elfinder-toolbar input').blur();
							setTimeout(function(){
								elfInsrance.enable();
							}, 100);
						},
						resizeStop: function() {
							elfNode.trigger('resize');
						}
					}).parent().css({'zIndex':'11000'});

					var cke = e.editor;
					
					cke.widgets.registered.uploadimage.onUploaded = function(upload){
						var self = this,
						img = $('<img/>').attr('src', upload.url).on('load', function(){
							var w = this.naturalWidth,
								h = this.naturalHeight,
								s = 400;
							if (w > s || h > s) {
								if (w > h) {
									h = h * (s / w);
									w = s;
								} else {
									w = w * (s / h);
									h = s;
								}
							}
							self.replaceWith('<img src="'+encodeURI(upload.url)+'" width="'+w+'" height="'+h+'"></img>');
						});
					}
					
					cke.on('fileUploadRequest', function(e){
						var fileLoader = e.data.fileLoader,
							formData = new FormData(),
							xhr = fileLoader.xhr;
						xhr.open('POST', fileLoader.uploadUrl, true );
						formData.append('cmd', 'upload' );
						formData.append('target', elfDirHashMap.image);
						formData.append('upload[]', fileLoader.file, fileLoader.fileName );
						fileLoader.xhr.send( formData );
					});
					
					cke.on('fileUploadResponse', function(e){
						elfInsrance.exec('reload');
						e.stop();
						var data = e.data,
							res = JSON.parse(data.fileLoader.xhr.responseText);
						if (!res.added || res.added.length < 1) {
							data.message = 'Can not upload.';
							e.cancel();
						} else {
							var file	 = res.added[0];
							if (file.url && file.url != '1') {
								data.url = file.url;
							} else {
								data.url = elfInsrance.options.url + ((elfInsrance.options.url.indexOf('?') === -1)? '?' : '&') + 'cmd=file&target=' + file.hash;
							}
						}
					});
				});

			})();
		</script>
		<script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
		<!--<script src="<?=__THEMEURL__?>assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>-->
		
        <script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

		<script src="<?=__THEMEURL__?>assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/global/scripts/app.js" type="text/javascript"></script><!-- necesita minimizare -->
		
		<script src="<?=__THEMEURL__?>assets/pages/scripts/form-repeater.min.js" type="text/javascript"></script>
		<script src="<?=__THEMEURL__?>assets/pages/scripts/ui-sweetalert.min.js" type="text/javascript"></script>
		
				
		<script src="<?=__THEMEURL__?>assets/pages/scripts/components-bootstrap-tagsinput.min.js" type="text/javascript"></script>
		<!--<script src="<?=__THEMEURL__?>assets/pages/scripts/table-datatables-ajax.js" type="text/javascript"></script>--><!-- necesita minimizare -->
		
		<script src="<?=__THEMEURL__?>assets/pages/scripts/ui-blockui.min.js" type="text/javascript"></script>
		<script src="<?=__THEMEURL__?>assets/pages/scripts/ui-toastr.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/pages/scripts/components-select2.js" type="text/javascript"></script> <!-- necesita minimizare -->
        <script src="<?=__THEMEURL__?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
		
		<script src="<?=__THEMEURL__?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script><!-- necesita minimizare -->
		
		
        
                
        <!--<script src="<?=__THEMEURL__?>assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>-->		
        <!-- END PAGE LEVEL SCRIPTS -->
        <?php if ($this->parent->session_expire) { ?>
            <!-- SESSION EXPIRE -->
            <script src="<?=__THEMEURL__?>assets/global/plugins/jquery-idle-timeout/jquery.idletimeout.js" type="text/javascript"></script>
            <script src="<?=__THEMEURL__?>assets/global/plugins/jquery-idle-timeout/jquery.idletimer.js" type="text/javascript"></script>        
            <script type="text/javascript">
                var UIIdleTimeout = function () {
                    return {
                        //main function to initiate the module
                        init: function () {
                            // cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
                            var $countdown;
                            $('body').append('');                 
                            // start the idle timer plugin
                            $.idleTimeout('#idle-timeout-dialog', '.modal-content button:last', {
                                idleAfter: <?=$this->parent->session_expire*60?>, // seconds
                                timeout: 30000, //30 seconds to timeout
                                pollingInterval: 5, // 5 seconds
                                keepAliveURL: '../admin/utils/idletimeout_keepalive.php',
                                serverResponseEquals: 'OK',
                                onTimeout: function(){
                                    window.location = "<?=$this->parent->LinkToLogout()?>";
                                },
                                onIdle: function(){
                                    $('#idle-timeout-dialog').modal('show');
                                    $countdown = $('#idle-timeout-counter');
                                    $('#idle-timeout-dialog-keepalive').on('click', function () { 
                                        $('#idle-timeout-dialog').modal('hide');
                                    });
                                    $('#idle-timeout-dialog-logout').on('click', function () { 
                                        $('#idle-timeout-dialog').modal('hide');
                                        $.idleTimeout.options.onTimeout.call(this);
                                    });
                                },
                                onCountdown: function(counter){
                                    $countdown.html(counter); // update the counter
                                }
                            });       
                        }
                    };
                }();

                jQuery(document).ready(function() {    
                   UIIdleTimeout.init();
                });            
            </script>
            <!-- END SESSION EXPIRE -->
        <?php } ?>    
		
		<?php
			if (property_exists($this->parent, 'boxed_multiselect_grouped_table')) {
				?>
					<script type="text/javascript">
					var ComponentsDropdowns = function() {
						var e = function() {
								function e(e) {
									return e.id ? "<img class='flag' src='" + App.getGlobalImgPath() + "flags/" + e.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + e.text : e.text
								}

								function t(e) {
									var t = "<table class='movie-result'><tr>";
									return void 0 !== e.posters && void 0 !== e.posters.thumbnail && (t += "<td valign='top'><img src='" + e.posters.thumbnail + "'/></td>"), t += "<td valign='top'><h5>" + e.title + "</h5>", void 0 !== e.critics_consensus ? t += "<div class='movie-synopsis'>" + e.critics_consensus + "</div>" : void 0 !== e.synopsis && (t += "<div class='movie-synopsis'>" + e.synopsis + "</div>"), t += "</td></tr></table>"
								}

								function s(e) {
									return e.title
								}
							},
							t = function() {
								function e(e) {
									return e.id ? "<img class='flag' src='" + App.getGlobalImgPath() + "flags/" + e.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + e.text : e.text
								}

								function t(e) {
									var t = "<table class='movie-result'><tr>";
									return void 0 !== e.posters && void 0 !== e.posters.thumbnail && (t += "<td valign='top'><img src='" + e.posters.thumbnail + "'/></td>"), t += "<td valign='top'><h5>" + e.title + "</h5>", void 0 !== e.critics_consensus ? t += "<div class='movie-synopsis'>" + e.critics_consensus + "</div>" : void 0 !== e.synopsis && (t += "<div class='movie-synopsis'>" + e.synopsis + "</div>"), t += "</td></tr></table>"
								}

								function s(e) {
									return e.title
								}
							},
							s = function() {
								$(".bs-select").selectpicker({
									iconBase: "fa",
									tickIcon: "fa-check"
								})
							},
							l = function() {
								<?php
									if (property_exists($this->parent, 'boxed_multiselect_grouped_table')) {
										$cboxgr = 0;
										foreach ($this->parent->boxed_multiselect_grouped_table as $key => $value) {
											echo ($cboxgr>0 ? ',' : '').$value.PHP_EOL;
											$cboxgr++;
										}
									}
								?>
							};
						return {
							init: function() {
								e(), t(), l(), s()
							}
						}
					}();
					jQuery(document).ready(function() {
						ComponentsDropdowns.init()
					});	
					</script>
				<?php
			}
		?>

        <!-- BEGIN THEME LAYOUT SCRIPTS -->
		<!--<script src='<?=__CALENDARURL__?>lib/jquery.min.js'></script>--> <!-- necesar calendar -->
        <script src="<?=__THEMEURL__?>assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?=__THEMEURL__?>assets/layouts/layout/scripts/demo.js" type="text/javascript"></script><!-- necesita minimizare -->
        <script src="<?=__THEMEURL__?>assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        
	        
			<script src="<?=__THEMEURL__?>assets/global/plugins/plupload/js/plupload.full.min.js" type="text/javascript"></script>
			<!--<script src="<?=__THEMEURL__?>assets/pages/scripts/ecommerce-products-edit.js" type="text/javascript"></script>--><!-- necesita minimizare-->
			 <script type="text/javascript">
				var EcommerceProductsEdit = function () {
					var handleImages = function() {
						// see http://www.plupload.com/
						var uploader = new plupload.Uploader({
							runtimes : 'html5,flash,silverlight,html4',          
							browse_button : document.getElementById('tab_images_uploader_pickfiles'), // you can pass in id...
							container: document.getElementById('tab_images_uploader_container'), // ... or DOM Element itself             
							url : "content/template/<?=__THEME_FOLDER_NAME__?>/assets/global/plugins/plupload/upload.php?id=<?=$this->item_id_encripted?>",
							filters : {
								max_file_size : '<?=MAX_UPLOAD_FILE_SIZE?>mb',
								mime_types: [
									<?php
										$i=0;
										if (isset($this->upload_file_type)) {
											foreach ($this->upload_file_type as $arr_file_type) {												
												echo '{title : "'.$arr_file_type[0].'", extensions : "'.$arr_file_type[1].'"},'.PHP_EOL;
												$i++;
											}
										} else {
									?>
										{title : "Image files", extensions : "jpg,gif,png,jpeg,tiff"},
										{title : "Archive files", extensions : "zip,arj,ace,rar"},
										{title : "PDF files", extensions : "pdf"},
										{title : "MS Word files", extensions : "doc,docx"},
										{title : "MS Excel files", extensions : "xls,xslx "},
										{title : "Movie files", extensions : "mp4,avi,mpeg"},
										{title : "Audio files", extensions : "mp3,wav"}
									<?php } ?>
								]
							},

						   // Flash settings
							flash_swf_url : 'assets/plugins/plupload/js/Moxie.swf',    
							// Silverlight settings
							silverlight_xap_url : 'assets/plugins/plupload/js/Moxie.xap',             
							init: {
								PostInit: function() {
									$('#tab_images_uploader_filelist').html("");					 

									$('#tab_images_uploader_uploadfiles').click(function() {
										uploader.start();
										return false;
									});

									$('#tab_images_uploader_filelist').on('click', '.added-files .remove', function(){
										uploader.removeFile($(this).parent('.added-files').attr("id"));    
										$(this).parent('.added-files').remove();                     
									});
								},
						 

								FilesAdded: function(up, files) {
									plupload.each(files, function(file) {
										$('#tab_images_uploader_filelist').append('<div class="alert alert-warning added-files" id="uploaded_file_' + file.id + '">' + file.name + '(' + plupload.formatSize(file.size) + ') <span class="status label label-info"></span>&nbsp;<a href="javascript:;" style="margin-top:-5px" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> remove</a></div>');
									});
								},						 

								UploadProgress: function(up, file) {
									$('#uploaded_file_' + file.id + ' > .status').html(file.percent + '%');
								},


								FileUploaded: function(up, file, response) {
									
									var response = $.parseJSON(response.response);

									if (response.result && response.result == 'OK') {																				
										var id = response.id; // uploaded file's unique name. Here you can collect uploaded file names and submit an jax request to your server side script to process the uploaded files and update the images tabke										
										$('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-success").html('<i class="fa fa-check"></i> OK'); // set successfull upload
										$('#uploaded_file_' + file.id).delay(2000).remove();
										$('#filter_gallery').click();

									} else {
										$('#uploaded_file_' + file.id + ' > .status').removeClass("label-info").addClass("label-danger").html('<i class="fa fa-warning"></i> Failed'); // set failed upload
										//App.alert({type: 'danger', message: 'One of uploads failed. Please retry.', closeInSeconds: 10, icon: 'warning'});
										App.alert({type: 'danger', message: response.result, closeInSeconds: 10, icon: 'warning'});
									}
								},

								Error: function(up, err) {
									App.alert({type: 'danger', message: err.message, closeInSeconds: 10, icon: 'warning'});
								}
							}

						});

						uploader.init();
					}
					/* ---------- */
					var handleGallery = function () {

						var grid = new Datatable();

						grid.init({
							src: $("#datatable_upload"),
							onSuccess: function (grid, response) {
								// grid:        grid object
								// response:    json object of server side ajax response
								// execute some code after table records loaded
							},
							onError: function (grid) {
								// execute some code on network or other general error  
							},
							onDataLoad: function(grid) {
								// execute some code on ajax data load
							},							
							loadingMessage: 'Incarcare ...',
							dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

								// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
								// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
								// So when dropdowns used the scrollable div should be removed. 
								//"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
								"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
								"lengthMenu": [
									[10, 20, 50, 100, 150, -1],
									[10, 20, 50, 100, 150, "All"] // change per page values here
								],
								"pageLength": 10, // default record count per page
								"ajax": {
									"url": "action/ajax-archive-gallery.php?ida=<?=$this->item_id_encripted?><?=(isset($this->upload_tab_class) ? '&tab_class='.$this->upload_tab_class : '')?>", // ajax source
								},
								"columnDefs": [
									{orderable: false, targets: -1 },
									{orderable: false, targets: 0 },
									{orderable: true, targets: 1 },
									{orderable: false, targets: 2 },
									{orderable: true, targets: 3 },
									{orderable: true, targets: 4 },
									{orderable: true, targets: 5 },
								],
								"order": [
									[1, "desc"]
								] // set first column as a default sort by asc
							}
						});
						/* --------------------------------- */
						// handle group actionsubmit button click
						grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
							e.preventDefault();
							var action = $(".table-group-action-input", grid.getTableWrapper());
							if (action.val() != "" && grid.getSelectedRowsCount() > 0) {						
									icon = '<i class="icon-question fs18"></i> ';
									msg  = 'Confirmati stergerea inregistrarilor selectate ?';
									bootbox.confirm({
										title: cst_var_app_name,
										message: icon+''+msg+'',
										buttons: {
											'cancel': {
												label: 'Nu',
												className: 'btn-primary plr30'
											},
											'confirm': {
												label: 'Da',
												className: 'btn-default plr30'
											}
										},
										callback: function(result) {
											if (result) {
												grid.setAjaxParam("customActionType", "group_action");
												grid.setAjaxParam("customActionName", action.val());
												grid.setAjaxParam("id", grid.getSelectedRows());
												grid.getDataTable().ajax.reload();
												grid.clearAjaxParams();
												grid.submitFilter();
												//grid.clearAjaxParams();
											} 
										}
									});
							} else if (action.val() == "") {
								App.alert({
									type: 'danger',
									icon: 'warning',
									message: 'Selectati o actiune globala !',
									container: grid.getTableWrapper(),
									place: 'prepend'
								});
							} else if (grid.getSelectedRowsCount() === 0) {
								App.alert({
									type: 'danger',
									icon: 'warning',
									message: 'Nu ati selectat nici o inregistrare',
									container: grid.getTableWrapper(),
									place: 'prepend'
								});
							} 
							
						});
						
						/* --------------------------------- */
					}
					
					/* ---------- */
					return {

						//main function to initiate the module
						init: function () {
							handleImages();
							handleGallery();
						}
					};

				}();
				
				jQuery(document).ready(function() {    
				   EcommerceProductsEdit.init();
				});				
			 </script>			 
		
		<!-- END THEME LAYOUT SCRIPTS -->
		<script src="<?=__ADMINURL__?>app/ajaxloader/jquery.ajaxloader.1.5.1.js" type="text/javascript"></script>
		
		<script src="<?=__THEMEURL__?>assets/global/scripts/custom.js" type="text/javascript"></script>
		<!-- ==================================================================================== -->
		<script src="<?=__THEMEURL__?>assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>
		<!-- ==================================================================================== -->
		<script src="<?=__THEMEURL__?>assets/global/scripts/custom_app.js" type="text/javascript"></script>
		<!-- ==================================================================================== -->
		<script src="<?=__UTILSAPP__?>jquery-minicolors-master/jquery.minicolors.js"></script>
		<script>
			$(document).ready( function() {

			  $('.mycolorpicker').each( function() {
				$(this).minicolors({
				  control: $(this).attr('data-control') || 'hue',
				  defaultValue: $(this).attr('data-defaultValue') || '',
				  format: $(this).attr('data-format') || 'hex',
				  keywords: $(this).attr('data-keywords') || '',
				  inline: $(this).attr('data-inline') === 'true',
				  letterCase: $(this).attr('data-letterCase') || 'lowercase',
				  opacity: $(this).attr('data-opacity'),
				  position: $(this).attr('data-position') || 'bottom left',
				  swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
				  change: function(value, opacity) {
					if( !value ) return;
					if( opacity ) value += ', ' + opacity;
					if( typeof console === 'object' ) {
					  console.log(value);
					}
				  },
				  theme: 'bootstrap'
				});

			  });

			});
		</script>
		<!-- ==================================================================================== -->
		<!-- nested menu & itinerary -->
		<?php
			if (property_exists($this->parent, 'nested_list_menu')) {
				foreach ($this->parent->nested_list_menu as $key => $value) {
					echo $value.PHP_EOL;
				}
			}
		?>
		<script src="<?=__UTILSAPP__?>nested-list/jquery.domenu-0.99.77.min.js"></script>
		<!-- ==================================================================================== -->
		<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(
				{
					content: function () {
					  return $(this).prop('title');
					}
				});
			});
		</script>
		<!-- itinerary javascript sortable + add/mod/delete row -->
		<?php
			
			if (property_exists($this->parent, 'itinerary_scripts')) {
				foreach ($this->parent->itinerary_scripts as $key => $value) {
					echo $value.PHP_EOL;
				}
			}
		?>		
		<?php
			//if ($this->parent->user_is_admin) {
				?>
				<!-- =================================================================================== -->
				<script>
					function get_users_status_list(){
					   setTimeout(function(){
						  $.ajax({ url: "<?=__ACTIONURL__?>ajax-logged-users.php", cache: false,
						  success: function(data){
							$("#user_list").html(data);
							get_users_status_list();
						  }, dataType: "html"});
					  }, <?=AJAX_TIME_GET_USERS_STATUS_LIST?>);
					}
					$(document).ready(function(){
						get_users_status_list();
					});				
					
				</script>
				<!-- =================================================================================== -->
				<?php
			//}
		?>
		<script>
			function set_user_online_status(){
			   setTimeout(function(){
				  $.ajax({ url: "<?=__ACTIONURL__?>ajax-set-user_status.php", cache: false,
				  success: function(data){					
					set_user_online_status();
				  }, dataType: "html"});
			  }, <?=AJAX_TIME_SET_ONLINE_USER_STATUS?>);
			}
			$(document).ready(function(){
				set_user_online_status();
			});				
			
		</script>
		<script src="<?=__THEMEURL__?>assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
		
		<!-- qtip resources -->
		<!--
		<script type="text/javascript" src="<?=__ADMINURL__?>app/qtip2/jquery.qtip.js"></script>
		<script>
		
		$(document).ready(function() {
			$('a').qtip({ 
				content: {
					text: 'My common piece of text here'
				}
			});
		});			
		</script>		
		-->	
		<!-- calendar resources -->
		<!-- end calendar resources -->		
</body>

</html>