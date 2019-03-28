cst_var_app_name = 'charity-sos.com';
cst_form_changed = false;
/* --------------------------------- */
//cst_DisableFieldsOnComboSwitch();
$( document ).ready(function() {
	/* ---------------------------------------- */
        $("#submit-form").submit(function (e) {
			for ( instance in CKEDITOR.instances ) {
				CKEDITOR.instances[instance].updateElement();
			}
			var postData = new FormData(this);
			var fields = $(this).serializeArray();
			$.each(fields,function(key,input){
				postData.append(input.name,input.value);
			});
			$.each($("input[type=file]"), function(i, obj) {
				var name_attr = $(this).attr('name');
				if (typeof name_attr !== typeof undefined && name_attr !== false) {
					//alert(name_attr);
					$.each(obj.files,function(j, file){
						//postData.append('file['+j+']', file);
						postData.append(name_attr+'['+j+']', file);
					})
				}
			});		
			//var postData = $(this).serializeArray();        
			var url = $(document.activeElement).attr('goto');			
			
			App.blockUI({message: 'Salvare date...'});
			var jqXHR=$.ajax({
				  url: "action/ajax-archive-update.php",
				  type: "POST",
				  data: postData,
				  processData: false,  
				  contentType: false,				  
				  async: false
				});    
			
			if (jqXHR.responseText!='') {
				data   = jqXHR.responseText;
				App.unblockUI();
				if (data != 'ok') { cst_message(data); }
				else {
					// ok submit                    						
					cst_notify('Data has been saved.');
					if (url) {
						window.location.href = url;
					} else {
						location.reload();
					}
				}
				
			}		
			e.preventDefault(); 
    	});        	
	
	/* ---------------------------------------- */
	$('#submit-form').change(function(){
	   cst_form_changed = true;
	});	
	/* ---------------------------------------- */
	$(window).bind('beforeunload', function(){
		/*
		if (cst_form_changed == true) {
			return 'Aveti date nesalvate. Parasiti pagina curenta ?';
		}
		*/
	});	
	/* ---------------------------------------- */
	
	cst_EditFormJavascript();
	
	/* ---------------------------------------------------------- */
	$('body').on("click",".editable", function(e) {	  		
		if ($(this).find("#input_edit").length==0) {
			cst_edit_text_inline_show(e);
		}
	});	
	$('body').on("keydown","#input_edit", function(e) {	  		
		  if(e.keyCode == 13) { // enter key was pressed		  
			cst_edit_text_inline_save();
			return false;
		  }
	});	
	/* ---------------------------------------------------------- */
	$('body').on("change","#day_selector", function(e) {	  		
		cst_LoadCalendar_Day();
	});	
	
/* ---------------------------------------------------------- */
	$('body').on('mouseover', '.timepicker-24' ,function(){
		$(this).timepicker({
			autoclose: true,
			minuteStep: 5,
			showSeconds: false,
			showMeridian: false
		});				
	});
/* ---------------------------------------------------------- */
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	 var target = $(e.target).attr("href").replace("#tab_", ""); // activated tab    
	 //var str = window.location.search.replace(/&?tab=\d+/, '');
	 var str = window.location.search;
	 str = replaceQueryParam('tab', target, str);
	 site_url = window.location.pathname + str;
	 //window.location.hash = site_url
	 window.history.pushState(null, null, site_url);
	});		
	
/* ---------------------------------------------------------- */
	$('body').on("keydown",".header-input-text", function(e) {	  		
		  if(e.keyCode == 13) { // enter key was pressed		  
			//alert('am dat enter');
			$("#filter_button_list").click();
			return false;
		  }
	});	
/* ---------------------------------------------------------- */
	$('body').on("change","#bg_color_calendar_terms", function(e) {
		$('#demo_colors_terms').css({'padding': '3px','border-radius': '3px', 'background': $('#bg_color_calendar_terms').val(), 'color': $('#font_color_calendar_terms').val()});
	});	
	$('body').on("change","#font_color_calendar_terms", function(e) {
		$('#demo_colors_terms').css({'padding': '3px','border-radius': '3px', 'background': $('#bg_color_calendar_terms').val(), 'color': $('#font_color_calendar_terms').val()});
	});		
	
	$('body').on("change","#bg_color_calendar_activity", function(e) {
		$('#demo_colors_activity').css({'padding': '3px','border-radius': '3px', 'background': $('#bg_color_calendar_activity').val(), 'color': $('#font_color_calendar_activity').val()});
	});	
	$('body').on("change","#font_color_calendar_activity", function(e) {
		$('#demo_colors_activity').css({'padding': '3px','border-radius': '3px', 'background': $('#bg_color_calendar_activity').val(), 'color': $('#font_color_calendar_activity').val()});
	});		
	
/* ---------------------------------------------------------- */	
	$('body').on("change","#change_moneda", function(e) {
		var currency_type = this.value;
		$('#valuta_incasare').text(cst_currency(currency_type));
		if (currency_type!=0) {
			$('#fg_echivaleaza_lei').show();
		} else {
			$('#fg_echivaleaza_lei').hide();
		}
		
	});	
/* ---------------------------------------------------------- */
	$('body').on("click","#echivaleaza_lei_but", function(e) {
		var confirmat=0;
		var suma_incasata = $('#suma_incasata').val();
		var currency_type = $('#change_moneda').val();
		swal({
		  html:true,
		  title: "Doresti sa calculezi echivalentul in LEI<br/>al sumei de <strong>"+suma_incasata+" "+cst_currency(currency_type)+"</strong> ?",
		  text: "Echivalentul in LEI se va calcula la <strong>cursul BNR</strong>!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Da, calculez",
		  cancelButtonText: "Renunt",
		  closeOnConfirm: false
		},
		function(){		 
						var date_receipt = $('#date_receipt').val();
						if (cst_isEmpty(date_receipt)) {
							cst_message('Completati data incasarii/documentului !');
						} else {
							//var suma_incasata = $('#suma_incasata').val();
							if ((cst_isEmpty(suma_incasata)) || (suma_incasata==0)) {
								cst_message('Completati suma incasata !');
							} else {
									//alert('Acum calculez');
									/* ------------- */
									
									App.blockUI({message: 'Calculez...'});
									var postData = 'ro_date='+encodeURIComponent(date_receipt)+'&valute='+currency_type;
									var jqXHR=$.ajax({
										  url: "action/ajax-get-exchange-rate-from-bnr.php",
										  type: "POST",
										  data: postData,
										  async: false
										});    							
									if (jqXHR.responseText!='') {
										var json = JSON.parse(jqXHR.responseText);
										if (json.error != '') { swal(json.error); }
										else {
											var echivalent_lei;
											echivalent_lei = (suma_incasata * json.exchange_rate).toFixed(2);
											$('#echivaleaza_lei').val(echivalent_lei);
											swal('Echivalenta in lei a fost calculata la cursul valutar de '+json.exchange_rate+' din data: '+json.ro_date_exchange);
										}
										App.unblockUI();								
									} else {
										App.unblockUI();
										cst_message('ATENTIE: Apel ajax fara rezultat !!!');
									}
									
									/* ------------- */
							}
							
						}		  
		});

	});	
/* ---------------------------------------------------------- */
	$('.btn_select_file').click(function(){
		//alert('selectez !');
		 var input_id = $(this).attr('rel');
		 
		 $('<div><\div>').dialog({modal: true, width: "95%", title: "File Manager", zIndex: 99999,
				create: function(event, ui) {
					$(this).elfinder({
						resizable: false,
						url: "app/elFinder/php/connector.php",
						commandsOptions: {
						  getfile: {
							oncomplete: 'destroy' 
						  }
						},                            
						getFileCallback: function(file) {
							//alert(file.url);														
							$('#'+input_id).val(file.url);							
							var preview_photo  = photo_src(file.url);
							$('#img'+input_id).html('<a href="' + file.url + '" download><img src="' + preview_photo + '" /></a>');
							$('#open'+input_id).attr('href',file.url);
							jQuery('button.ui-dialog-titlebar-close[role="button"]').click();
							$('#'+input_id).focus();
						}
					}).elfinder('instance')
				}
			});
			

			
	});
/* ------------------------------------------------------------ */
$('.file-input-elfinder').blur(function()
{
    if( !$(this).val() ) {			
          clear_file_input($(this).attr('id'));
    } else {
		input_id       = $(this).attr('id');
		file_url       = $(this).val();
		preview_photo  = photo_src(file_url);
		$('#img'+input_id).html('<a href="' + file_url + '" download><img src="' + preview_photo + '" /></a>');
	}
});
/* ------------------------------------------------------------ */
/////////////////////////////////////////////////////////////////////////////////// SHIP ////////////////////////////////////////////////////
	$('body').on("click","#toggle_price", function(e) {	
		if ($(this).hasClass('fa-calendar-plus-o')) {
			/* este extindere */
			$('.cabins_price').removeClass('hidden'); 
			 $(this).removeClass('fa-calendar-plus-o');
			 $(this).addClass('fa-calendar-minus-o');
			 $("#thumbnail-sortable-departures").find("[data-toggle-icon]").removeClass().addClass('fa fa-calendar-minus-o');
			
		} else {
			/* este restrangere */
			$('.cabins_price').removeClass('hidden').addClass("hidden"); 
			 $(this).removeClass('fa-calendar-minus-o');
			 $(this).addClass('fa-calendar-plus-o');
			 $("#thumbnail-sortable-departures").find("[data-toggle-icon]").removeClass().addClass('fa fa-calendar-plus-o');			
		}		
	});	
/* ------------------------------------------------------------ */
	$('body').on("click",".toggle_data", function(e) {
		 var parent_div = $(this).parent().parent().parent();
		 parent_div.find('.cabins_price').toggleClass("hidden");
		 if (parent_div.find('.cabins_price').hasClass("hidden")) {
			 $(this).children('i').removeClass().addClass('fa fa-calendar-plus-o');
		 } else {
			 $(this).children('i').removeClass().addClass('fa fa-calendar-minus-o');
		 }
		 var all_elem = 0, inchise = 0, deschise = 0;
		 $("[data-toggle-icon]").each(function(){
			if ($(this).hasClass("fa-calendar-plus-o")){
				inchise++;
			} else {
				deschise++;
			}
			all_elem++;
		 });
		 if (all_elem==inchise) {
			 $('#toggle_price').removeClass().addClass('fa fa-calendar-plus-o cursor_pointer');
		 }
		 if (all_elem==deschise) {
			 $('#toggle_price').removeClass().addClass('fa fa-calendar-minus-o cursor_pointer');
		 }
		 
	});
/* ------------------------------------------------------------ */	
	$('body').on("click","#sort_date", function(e) {	
		if ($(this).hasClass('fa-sort-numeric-asc')) {
			/* trebuie sortare ascendenta */
			
			$('.one-data-block').sort(function (a, b) {
			  var cdate1 = $(a).find('.mydate').val();
			  var day1   = parseInt(cdate1.substr(0, 2)); 
			  var month1 = parseInt(cdate1.substr(3, 2)); 
			  var year1  = parseInt(cdate1.substr(6, 4)); 
			  
			  var cdate2 = $(b).find('.mydate').val();
			  var day2   = parseInt(cdate2.substr(0, 2)); 
			  var month2 = parseInt(cdate2.substr(3, 2)); 
			  var year2  = parseInt(cdate2.substr(6, 4)); 
			  
			  var date2 = new Date(year2, month2-1, day2); // 1st argument = year, 2nd = month - 1 (because getMonth() return 0-11 not 1-12), 3rd = date
			  var date1 = new Date(year1, month1-1, day1);
			  var diference = date1.getTime() - date2.getTime();
			  diference = Math.ceil(diference / 1000 / 60 / 60 / 24); // convert milliseconds to days. ceil to round up.			  
			  return diference;
			}).each(function (_, container) {
			  $(container).parent().append(container);
			});			 
			
			 $(this).removeClass('fa-sort-numeric-asc');
			 $(this).addClass('fa-sort-numeric-desc');			
		} else {
			/* trebuie sortare descendenta */
			$('.one-data-block').sort(function (a, b) {
			  var cdate1 = $(a).find('.mydate').val();
			  var day1   = parseInt(cdate1.substr(0, 2)); 
			  var month1 = parseInt(cdate1.substr(3, 2)); 
			  var year1  = parseInt(cdate1.substr(6, 4)); 
			  
			  var cdate2 = $(b).find('.mydate').val();
			  var day2   = parseInt(cdate2.substr(0, 2)); 
			  var month2 = parseInt(cdate2.substr(3, 2)); 
			  var year2  = parseInt(cdate2.substr(6, 4)); 
			  
			  var date2 = new Date(year2, month2-1, day2); // 1st argument = year, 2nd = month - 1 (because getMonth() return 0-11 not 1-12), 3rd = date
			  var date1 = new Date(year1, month1-1, day1);
			  var diference = date2.getTime() - date1.getTime();
			  diference = Math.ceil(diference / 1000 / 60 / 60 / 24); // convert milliseconds to days. ceil to round up.			  
			  return diference;
			}).each(function (_, container) {
			  $(container).parent().append(container);
			});			 
			
			
			 $(this).removeClass('fa-sort-numeric-desc');
			 $(this).addClass('fa-sort-numeric-asc');
		}		
	});	
/* ------------------------------------------------------------ */
	$('body').on("click",".add-new-date", function(e) {	  		
		//$('#toggle_price').removeClass();
		//$('#toggle_price').addClass('fa fa-calendar-minus-o cursor_pointer');
		//$('.cabins_price').removeClass('hidden');
		$(".thumbnail-sortable-aditional").sortable({ 
					handle: '.swapper1',
					cursor: 'move',
					update: function  () {
						cst_SerializeItinerary_departures();
						}					
		});		
		$('html,body').animate({ scrollTop: 99999999 }, 'slow');
		
	});	
/* ------------------------------------------------------------ */
	$('body').on("click",".duplicate_date", function(e) {	  		
		if (confirm("Do you want to duplicate this date?")) {
			var clone = $(this).parent().parent().parent().clone(true, false);
			$(this).closest("#thumbnail-sortable-departures").append(clone);
			
			$(".thumbnail-sortable-aditional").sortable({ 
						handle: '.swapper1',
						cursor: 'move',
						update: function  () {
							cst_SerializeItinerary_departures();
							}					
			});	
						
			var initPickers = function () {
					$('.date-picker').datepicker({
						rtl: App.isRTL(),
						autoclose: true
					});
				}
			initPickers();
			$('html,body').animate({ scrollTop: 99999999 }, 'slow');
		}
	});	
/* ------------------------------------------------------------ */
	$('body').on("click",".add_note", function(e) {	  		
		if (confirm("Do you want add a note to this date?")) {
			var container=$(this).parent().parent().parent().children('.date_aditional_info');
			var new_item =`
										<div class="row repeat_aditional_info bt1 pt5 sortable-item">
											<div class="form-group mb5">
												<div class="col-md-2">
													<input type="text" class="form-control font-bold" placeholder="Title" name="aditional_title" required>
												</div>
												<div class="col-md-6">
													<input type="text" class="form-control" placeholder="Description" name="aditional_description">
												</div>
												<div class="col-md-2">
													<input type="number" class="form-control" placeholder="Price" name="aditional_price">
												</div>
												<div class="col-md-1">
													<a href="javascript:;" class="btn default btn-outline data-aditional-delete"><i class="fa fa-close"></i></a>												
												</div>
												<div class="col-md-1">
													<span class="btn default btn-outline swapper1"><i class="glyphicon glyphicon-move"></i></span>
												</div>
											</div>
										</div>
			
			`;
			container.append(new_item);
		}
	});	
/* ------------------------------------------------------------ */
	$('body').on("click",".data-aditional-delete", function(e) {	  		
		if (confirm("Do you want to delete this info ?")) {
			$(this).parent().parent().parent().remove();
		}
	});	
/* ------------------------------------------------------------ */
	$('body').on("change",".select_cruise", function(e) {	  		
		$('#name').val($("#id_subdestination").find("option:selected").text() +' cu '+ $("#id_ship").find("option:selected").text());
	});	

/* ------------------------------------------------------------ */
/////////////////////////////////////////////////////////////////////////////////// SHIP ////////////////////////////////////////////////////
	
});


/* ---------------------------------------------------------- */
cst_change_date_in_url = function(rodate) {	 
	 //var str = window.location.search.replace(/&?cdate=\d+/, '');
	 var str = window.location.search;
	 str = replaceQueryParam('cdate', rodate, str);
	 site_url = window.location.pathname + str;
	 window.history.pushState(null, null, site_url);	
}
/* ---------------------------------------------------------- */
function replaceQueryParam(param, newval, search) {
    var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
    var query = search.replace(regex, "$1").replace(/&$/, '');

    return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
}
/* ---------------------------------------------------------- */
cst_edit_text_inline_show = function(e) {		
			$(".editable").each(function(){
				$lastbutton = $(this).find('*').filter(':button:visible:last');
				if ($lastbutton.parent().attr('id')!=e.target.id) {
					var old_text = $lastbutton.attr("data-org");
					var $parent  = $lastbutton.parent();
					$parent.empty().append(old_text);
				}
			});                             

			var $outer = $("#"+e.target.id);
			var text_desc = $outer.text().replace("'", "&#39;").replace('"', "&#34;");	  
			$outer.empty().append('<input id="input_edit" class="form-control" placeholder="max 2000 characters" maxlength="2000" value="' + (text_desc=='Click to edit' ? '' : text_desc) + '"><button onclick="cst_edit_text_inline_save()" class="btn green btn-xs mt5" type="button">Save <i class="fa fa-save"></i></button><button onclick="cst_edit_text_inline_cancel(this)" data-org="' + text_desc + '" target-myid="' + e.target.id + '" class="btn grey-cascade btn-xs mt5" type="button">Cancel <i class="fa fa-remove"></i></button>');
			$('#input_edit').focus();		
}
/* ------------------------------------------------------------------ */
cst_edit_text_inline_cancel = function(elem) {
	var old_text = $(elem).attr("data-org");
	var $parent  = $(elem).parent();
	$parent.empty().append(old_text);
}

/* ------------------------------------------------------------------ */
cst_edit_text_inline_save = function() {
	$input       = $('#input_edit');
	$parent      = $input.parent();
	$encoded_id  = $parent.attr('id').substring(4, 100);
	if ( $('#datatable_upload').length == 0 ) {
		//it doesn't exist
		enc_tbl      =  'THVTV1hvdS9LWTB5S2xQWHNIRCs5Zz09';
	} else {
		enc_tbl      =  $('#datatable_upload').attr('table-upload');
	}
	text_to_save = $input.val().trim();	
	App.blockUI({message: 'Processing...'});    
	
		$.ajax({ 
			type: "POST",
			url: "action/ajax-archive-save-gallery-description.php",
			data: 'id='+$encoded_id+'&item_text='+encodeURIComponent(text_to_save)+'&enc_tbl='+encodeURIComponent(enc_tbl),
			dataType: "html",
			success: function(msg){				
				if (msg != 'ok') {
					$lastbutton = $parent.find('*').filter(':button:visible:last');
					cst_edit_text_inline_cancel($lastbutton);
					cst_message(msg); 
				}
				else {
					if (text_to_save.length == 0) {
						$parent.removeClass("text-info").addClass("font-grey-salsa").text('Click to edit');
					} else {
						$parent.removeClass("font-grey-salsa").addClass("text-info").text(text_to_save);
					}					
				}
				App.unblockUI();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				App.unblockUI();
			}			
		});	
	
}
/* ------------------------------------------------------------------ */
cst_message_load_html = function (mytitle, htmlfile) {
		//alert(htmlfile);
		mytitle='<i class="fa fa-info-circle" aria-hidden="true"></i> '+mytitle;
		$.get(htmlfile, function (data) {					
			
			bootbox.alert({ size: "medium", title: mytitle, message: data,  callback: function(){ /* your callback code */ }});	
			
        });		
		
}
/* ------------------------------------------------------------------ */
cst_message = function (msg) {
		bootbox.alert(msg, function() {
		    //console.log("Alert Callback");
		});	
}
/* ------------------------------------------------------------------- */
cst_notify = function (message, title='', type=0, TimeOut=2000) {
	// type : 0 - success,1 - error, 2 - warning, 3 - info
	toastr.options.timeOut = TimeOut; 
	if (title=='') { title= cst_var_app_name; }
	switch (type) {
		case 0: toastr.success(message,title); break;
		case 1: toastr.error(message,title); break;
		case 2: toastr.warning(message,title); break;
		case 3: toastr.info(message,title); break;		
	} 		
}

/* ------------------------------------------------------------------- */
cst_confirm = function (msg, icon=true) {
	if (icon) {
	    icon = '<i class="icon-question fs18"></i> ';
	}		
	bootbox.confirm({
	    title: cst_var_app_name,
	    message: icon+'<strong class=fs16>'+msg+'</strong>',
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
	             //return true;
	             alert('Am confirmat');
	        } 
	    }
	});	
}
/* ------------------------------------------------------------------- */
cst_UpdateThemePanelSettings = function () {
	//alert('am intrat');
	var p1,p2,p3,p4,p5,p6,p7,p8,p9;
	$('#th_colors li').each(function(i){
	   if ($(this).hasClass("current")) {
	   		p1=i;
	   }
	});	
	/* ----------- */
	p2=0; if ($(".layout-style-option option:selected").val()==='rounded')                { p2=1; }
	p3=0; if ($(".page-header-option option:selected").val()==='fixed')                   { p3=1; }
	p4=0; if ($(".page-header-top-dropdown-style-option option:selected").val()==='dark') { p4=1; }
	p5=0; if ($(".sidebar-option option:selected").val()==='fixed') 					  { p5=1; }
	p6=0; if ($(".sidebar-menu-option option:selected").val()==='hover') 				  { p6=1; }
	p7=0; if ($(".sidebar-style-option option:selected").val()==='light') 				  { p7=1; }
	p8=0; if ($(".sidebar-pos-option option:selected").val()==='right') 				  { p8=1; }
	p9=0; if ($(".page-footer-option option:selected").val()==='fixed') 				  { p9=1; }
	ThemeSettings = p1 + ',' + p2 + ',' + p3 + ',' + p4 + ',' + p5 + ',' + p6 + ',' + p7 + ',' + p8 + ',' + p9;				
	/* ----------- */
    $.ajax({ 
        type: "POST",
        url: "action/ajax-theme-update-settings.php",
        data: "settings="+ThemeSettings,
        dataType: "html",
        success: function(msg){
            if (parseInt(msg, 0) !== 0) {
                var msg_splits = msg.split("|");
                if (msg_splits[0] === "success") {
                	// success
                } else {      
                	// error  
                }
            }
        }
    });	
}
/* ------------------------------------------------------------------ */
/* enable/disable fields for combo switch*/
cst_DisableFieldsOnComboSwitch = function() {
	$('.combo_sw_areas').each(function(){
		if ($(this).attr('activecontrol') == 'true') {
			$(this).find('input.required2:not(".el_rights_ckb"), textarea.required2:not(".el_rights"), select.required2:not(".el_rights")').prop('required', true);
		} else {
			//$(this).find('select.required2:not(".el_rights")').change();
			$(this).find('input.required2:not(".el_rights_ckb"), textarea.required2:not(".el_rights"), select.required2:not(".el_rights")').removeAttr('required');
		}
	 });
}
/* ------------------------------------------------------------------ */
$.fn.serializeArrayWithCheckboxes = function() {
var rCRLF = /\r?\n/g;
return this.map(function(){
    return this.elements ? jQuery.makeArray( this.elements ) : this;
})

    .map(function( i, elem ){
        var val = jQuery( this ).val();


        if (val == null) {
          return val == null
        //next 2 lines of code look if it is a checkbox and set the value to blank 
        //if it is unchecked
        } else if (this.type == "checkbox" && this.checked == false) {
          return { name: this.name, value: this.checked ? this.value : ""}
        //next lines are kept from default jQuery implementation and 
        //default to all checkboxes = on
        } else {
          return jQuery.isArray( val ) ?
                jQuery.map( val, function( val, i ){
                    return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
                }) :
            { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
        }
    }).get();
};
/* ------------------------------------------------------------------ */
cst_EnableDisableFieldsUserRights = function() {
	$('.el_rights').each(function(){
		var combo_name   = $(this).attr('name');
		var option_value = $('select[name="' + combo_name + '"] option:selected').val();
		var id_rights    = 'archive_' + combo_name;
		if (option_value!=0) {
			/* drepturile trebuiesc afisate */
			$("#"+id_rights).show();
		} else {
			$("#"+id_rights).hide();
		}
	 });		
}
/* ------------------------------------------------------------------ */
$('.el_rights').on('change', function() {
  
		var combo_name   = $(this).attr('name');
		var option_value = this.value;
		var id_rights    = 'archive_' + combo_name;
		if (option_value!=0) {
			/* drepturile trebuiesc afisate */
			$("#"+id_rights).show();
		} else {
			$("#"+id_rights).hide();
		}  
		cst_SerializeRights();
});
/* ------------------------------------------------------------------ */
$('.el_rights_ckb').change(function() {
	cst_SerializeRights();
});
/* ------------------------------------------------------------------ */
cst_SerializeRights = function() {
	 //$('#json_rights').val(JSON.stringify($('#rights_area :input').serializeArray()));
	 $('#json_rights').val(JSON.stringify($('#rights_area :input').serializeArrayWithCheckboxes()));
}
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
/* function will be called at the end of the edit archive form */
cst_EditFormJavascript = function() {
	/* ----- scan all <select> with class "combo_switch_select" and show corresponding div for selected value */
	$("select.combo_switch_select").each(function(){
		select_name = $(this).attr('name');
		$('.combo_switch_'+select_name).hide(0).attr('activecontrol', 'false');
		var id_to_show = '#' + select_name+'_'+$(this).val();
		$(id_to_show).show(0).attr('activecontrol', 'true');
	});
	cst_DisableFieldsOnComboSwitch();
	cst_EnableDisableFieldsUserRights();
	cst_SerializeRights();
	/* ------------ */
}
/* ------------------------------------------------------------------ */
reload_combo_when_change = function (index_of_combo, selected_value, id_schema, filter_categ_table, filter_id_archive, filter_fields, value_fields, title_fields, order_by, first_values) {

      //var cc=$('#'+id_schema+'' option:selected').text();
      var cc= $('#'+id_schema+'_'+index_of_combo.toString()+' option:selected').text();
      //alert(cc);
      $('#'+id_schema+'_copy').val(cc);
      var reload_index       = index_of_combo-1;
      var str_reload_index   = reload_index.toString();
      var filter_array       = filter_categ_table.split(";");
      var arr_len            = filter_array.length;
      var first_values_array = first_values.split(";");

      for (var i=reload_index;i>=0;i--) { 
        $('#'+id_schema+'_'+i.toString()).find('option:gt(0)').remove();
        //$('#uniform-'+id_schema+'_'+i.toString()).find('span').text(first_values_array[arr_len-i]);
      }
      if (selected_value!='') {
          //$('#uniform-'+id_schema+'_'+index_of_combo.toString()).removeClass('border_red');
          if (reload_index>0) {              
              var archive_array      = filter_id_archive.split(";");
              var fields_array       = filter_fields.split(";");
              var value_fields_array = value_fields.split(";");
              var title_fields_array = title_fields.split(";");
              var order_by_array     = order_by.split(";");
              
              var table_to_reload = filter_array[arr_len-reload_index];
              var ida             = archive_array[arr_len-reload_index];
              var filter_field    = fields_array[arr_len-reload_index];
              var field_for_value = value_fields_array[arr_len-reload_index];
              var field_for_title = title_fields_array[arr_len-reload_index];
              var order_value     = order_by_array[arr_len-reload_index];
              var first_title     = first_values_array[arr_len-reload_index];
              //+'&first_title='+first_title
              
              // categ0, categ, subctg
              $('#'+id_schema+'_'+str_reload_index).attr('disabled', 'disabled');
			  
              var ajax_str      ='table='+table_to_reload+'&ida='+ida+'&filter_field='+filter_field+'&value='+selected_value+'&field_for_value='+field_for_value+'&field_for_title='+field_for_title+'&order_value='+encodeURIComponent(order_value)+'&first_title='+encodeURIComponent(first_title);
			  //alert(ajax_str);
			  
              $('#'+id_schema+'_'+str_reload_index).ajaxloader('load',{load:'action/ajax-page-article-edit-get-combo.php?'+ajax_str, fadespeed: 'slow',
                        readycallback: function(){                
                            $('#'+id_schema+'_'+str_reload_index).removeAttr('disabled');                                                                                
							
                        }
              });
			  
          }
      } 
}

/* ------------------------------------------------------------------ */
cst_BackFromEditArchive = function ($url){
	if (cst_form_changed == true) {
		/* ------- */
		icon = '<i class="icon-question fs18"></i> ';
		msg  = 'Datele formularului curent nu au fost salvate !<br> Parasiti pagina curenta fara salvarea datelor ?';
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
					 //return true;
					 window.location.href= $url;
				} 
			}
		});	
		
		/* ------- */
	} else {
		window.location.href= $url;
	}
}
/* ------------------------------------------------------------------ */
cst_DeleteItemArchive2 = function ($encoded_id, $encoded_archive, grid_id){
			App.blockUI({message: 'Procesare...'});
			var postData = 'id='+$encoded_id+'&en_archtype='+$encoded_archive;
			var jqXHR=$.ajax({
				  url: "action/ajax-archive-get-item-info.php",
				  type: "POST",
				  data: postData,
				  async: false
				});    
			
			if (jqXHR.responseText!='') {
				data   = jqXHR.responseText;
				App.unblockUI();
				var json = JSON.parse(data);
				if (json.error == 'true') { cst_message(json.message); }
				else {
					/* ============================================ */
					icon = '<i class="icon-question fs18"></i> ';
					msg  = json.message;
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
								/* ---------------- */
								$.ajax({ 
									type: "POST",
									url: "action/ajax-archive-delete-item.php",
									data: "id="+$encoded_id+"&en_archtype="+$encoded_archive,
									dataType: "html",
									success: function(msg){
										var json = JSON.parse(msg);
										if (json.error == 'true') { cst_message(json.message); }											
										else {
											if (json.redirect) {												
												if ((grid_id === undefined) || (grid_id=='')) {
													bootbox.alert('Inregistrarea a fost stearsa !', function() {
														window.location.href=decodeURIComponent(json.redirect);
													});								
												} else {
													var objGrid = 'grid'+grid_id;
													mygrid = eval(objGrid);
													mygrid.getDataTable().ajax.reload('',false);
													//grid.getDataTable().ajax.reload('',false);
													cst_notify('Inregistrarea a fost stearsa !');													
												}
											} else {
												var objGrid = 'grid'+grid_id;
												mygrid = eval(objGrid);
												mygrid.getDataTable().ajax.reload('',false);
												//grid.getDataTable().ajax.reload('',false);
												cst_notify('Inregistrarea a fost stearsa !');
											}											
										}
									}
								});	

								
								/* ---------------- */
							} 
						}
					});	
					/* ============================================ */
				}
			}		
}
/* ------------------------------------------------------------------ */
cst_DeleteItemArchive = function ($encoded_id, $encoded_archive, grid_id){
			App.blockUI({message: 'Procesare...'});
			var postData = 'id='+$encoded_id+'&en_archtype='+$encoded_archive;
			var jqXHR=$.ajax({
				  url: "action/ajax-archive-get-item-info.php",
				  type: "POST",
				  data: postData,
				  async: false
				});    
			
			if (jqXHR.responseText!='') {
				data   = jqXHR.responseText;
				App.unblockUI();
				var json = JSON.parse(data);
				if (json.error == 'true') { cst_message(json.message); }
				else {
					/* ============================================ */
					msg  = json.message;
					swal({
					  html:true,
					  title: msg,
					  text: "Odata stearsa, inregistrarea nu mai poate fi recuperata !",
					  type: "warning",
					  showCancelButton: true,
					  confirmButtonClass: "btn-danger",
					  confirmButtonText: "Da, sterge!",
					  cancelButtonText: "Nu, renunt!",
					  closeOnConfirm: true,
					  closeOnCancel: true
					},
					function(isConfirm) {
					  if (isConfirm) {
							/* ------------------------ */
								$.ajax({ 
									type: "POST",
									url: "action/ajax-archive-delete-item.php",
									data: "id="+$encoded_id+"&en_archtype="+$encoded_archive,
									dataType: "html",
									success: function(msg){
										var json = JSON.parse(msg);
										if (json.error == 'true') { cst_message(json.message); }											
										else {
											if (json.redirect) {												
												if ((grid_id === undefined) || (grid_id=='')) {
													bootbox.alert('Inregistrarea a fost stearsa !', function() {
														window.location.href=decodeURIComponent(json.redirect);
													});								
												} else {
													var objGrid = 'grid'+grid_id;
													mygrid = eval(objGrid);
													mygrid.getDataTable().ajax.reload('',false);
													//grid.getDataTable().ajax.reload('',false);
													cst_notify('Inregistrarea a fost stearsa !');													
												}
											} else {
												var objGrid = 'grid'+grid_id;
												mygrid = eval(objGrid);
												mygrid.getDataTable().ajax.reload('',false);
												//grid.getDataTable().ajax.reload('',false);
												cst_notify('Inregistrarea a fost stearsa !');
											}											
										}
									}
								});	
							/* ------------------------ */
					  } else {
						//swal("Cancelled", "Your imaginary file is safe :)", "error");
					  }
					});					
					/* ============================================ */
				}
			}		
}

/* ------------------------------------------------------------------ */
// get item archive info
cst_GetItemInfo = function ($encoded_id, $encoded_archive, grid_id){
			App.blockUI({message: 'Procesare...'});
			var postData = 'id='+$encoded_id+'&en_archtype='+$encoded_archive;
			var jqXHR=$.ajax({
				  url: "action/ajax-archive-get-item-general-info.php",
				  type: "POST",
				  data: postData,
				  async: false
				});    
			
			if (jqXHR.responseText!='') {
				data   = jqXHR.responseText;
				App.unblockUI();
				var json = JSON.parse(data);
				if (json.error == 'true') { cst_message(json.message); }
				else {
					/* ============================================ */
					msg  = json.message;
					swal({
					  html:true,
					  title: 'Informatii inregistrare',
					  text: msg,
					  type: "info",
					  showCloseButton: true,
					  confirmButtonClass: "btn-default",
					  confirmButtonText: "Inchide",
					  closeOnConfirm: true
					});
					/* ============================================ */
				}
			}		
}

/* ------------------------------------------------------------------ */
cst_DeleteItemUploadFiles = function ($encoded_id, $encoded_tab_upload_class){
			App.blockUI({message: 'Procesare...'});
			var postData = 'id='+$encoded_id+'&tab_class='+$encoded_tab_upload_class;
			var jqXHR=$.ajax({
				  url: "action/ajax-archive-get-gallery-item-info.php",
				  type: "POST",
				  data: postData,
				  async: false
				});    
			
			if (jqXHR.responseText!='') {
				data   = jqXHR.responseText;
				App.unblockUI();
				var json = JSON.parse(data);
				if (json.error == 'true') { cst_message(json.message); }
				else {
					/* ============================================ */
					icon = '<i class="icon-question fs18"></i> ';
					msg  = json.message;
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
								/* ---------------- */
								$.ajax({ 
									type: "POST",
									url: "action/ajax-archive-delete-gallery-item.php",
									data: 'id='+$encoded_id+'&tab_class='+$encoded_tab_upload_class,
									dataType: "html",
									success: function(msg){
										var json = JSON.parse(msg);
										if (json.error == 'true') { cst_message(json.message); }											
										else {
											$('#filter_gallery').click();
											cst_notify('Inregistrarea a fost stearsa !');
										}
									}
								});	

								
								/* ---------------- */
							} 
						}
					});	
					/* ============================================ */
				}
			}		
}
/* ------------------------------------------------------------------ */
cst_LoadFromEcris = function (e){
		var confirmat=0;
		swal({
		  title: "Confirmati importul datelor din ECRIS ?",
		  text: "Procedura va importa detaliile generale despre dosar, termenele si partile din dosar !",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Da, import datele",
		  cancelButtonText: "Renunt",
		  closeOnConfirm: false
		},
		function(){		 
						var dosar_no = $('#nr_dosar').val();
						if (cst_isEmpty(dosar_no)) {
							cst_message('Completati Numarul dosarului !');
						} else {
							App.blockUI({message: 'Procesare...'});
							var postData = 'dosar='+encodeURIComponent(dosar_no);
							var jqXHR=$.ajax({
								  url: "action/app-ajax-get-info-from-ecris.php",
								  type: "POST",
								  data: postData,
								  async: false
								});    							
							if (jqXHR.responseText!='') {
								var json = JSON.parse(jqXHR.responseText);
								if (json.error != '') { swal(json.error); }
								else {									
									$('#instanta').val(json.instanta);
									$('#sectie').val(json.sectie);
									$('#obiect').val(json.obiect);
									$('#materie_juridica').val(json.materie);
									$('#stadiu_procesual').val(json.stadiu);
									$('#date_reg_tribunal').val(json.data);
									$('#must_update').val(json.must_update);
									$('#last_soap_response').val(json.raspuns);
									//$("#but_refresh_termene").click();									
									if (typeof grid1 != "undefined") {
										grid1.getDataTable().ajax.reload('',false);
									}
									if (typeof grid2 != "undefined") {
										grid2.getDataTable().ajax.reload('',false);
									}
									swal('Importul a fost finalizat !');
								}
								App.unblockUI();								
							} else {
								App.unblockUI();
								cst_message('ATENTIE: Apel ajax fara rezultat !!!');
							}
							
						}		  
		});
}
/* ------------------------------------------------------------------ */
cst_LoadFromEcris2 = function (e){
		var confirmat=0;
		swal({
		  title: "Confirmati importul datelor din ECRIS ?",
		  text: "Procedura va importa detaliile generale despre dosar, termenele si partile din dosar !",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Da, import datele",
		  cancelButtonText: "Renunt",
		  closeOnConfirm: false
		},
		function(){		 
						var dosar_no = $('#nr_dosar_1').val();
						if (cst_isEmpty(dosar_no)) {
							cst_message('Completati Numarul dosarului !');
						} else {
							App.blockUI({message: 'Procesare...'});
							var postData = 'dosar='+encodeURIComponent(dosar_no);
							var jqXHR=$.ajax({
								  url: "action/app-ajax-get-info-from-ecris.php",
								  type: "POST",
								  data: postData,
								  async: false
								});    							
							if (jqXHR.responseText!='') {
								var json = JSON.parse(jqXHR.responseText);
								if (json.error != '') { swal(json.error); }
								else {									
									//$('#instanta').val(json.instanta);
									$('#sectie_1').val(json.sectie);
									$('#obiect_1').val(json.obiect);
									$('#materie_juridica_1').val(json.materie);
									$('#stadiu_procesual_1').val(json.stadiu);
									$('#date_reg_tribunal_1').val(json.data);
									$('#must_update').val(json.must_update);
									$('#last_soap_response').val(json.raspuns);
									//$("#but_refresh_termene").click();
									grid1.getDataTable().ajax.reload('',false);
									grid2.getDataTable().ajax.reload('',false);
									swal('Importul a fost finalizat !');
								}
								App.unblockUI();								
							} else {
								App.unblockUI();
								cst_message('ATENTIE: Apel ajax fara rezultat !!!');
							}
							
						}		  
		});
}
/* ------------------------------------------------------------------ */
cst_ResetCalendarColors = function (e){
		var confirmat=0;
		swal({
		  title: "Confirmati resetarea culorilor calendarului la valorile implicite ?",
		  text: "Procedura va inlocui culorile actuale folosite la afisarea calandarului cu culorile implicite !",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Da, resetez culorile",
		  cancelButtonText: "Renunt",
		  closeOnConfirm: true
		},
		function(){	
			$('#bg_color_calendar_terms').minicolors('value','#00A19D');
			$('#font_color_calendar_terms').minicolors('value','#ffffff');
			$('#bg_color_calendar_activity').minicolors('value','#00CFD3');
			$('#font_color_calendar_activity').minicolors('value','#ffffff');
		});
}

/* ------------------------------------------------------------------ */	
	$("#form_reset").submit(function (e) {		
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");		
		$('#form_message').hide();
        $("#form_reset input[type='submit']").attr('disabled', 'disabled');
		$('#loader').show();
        $.ajax(
        {
            url: formURL,
            type: "POST",
            data: postData,
            success: function (data, textStatus, jqXHR) {
				$('#loader').hide();
                $("#form_reset input[type='submit']").removeAttr('disabled');
                if (data != 'ok') { 					
					$('#form_message').html('<span style="color:red !important">'+data+'</span>').show().delay(5000).fadeOut();
					$("#form_reset").find('input[type="text"], input[type="email"], select, textarea').val("");
					}
                else {					
					$("#form_reset").find('input[type="text"], input[type="email"], select, textarea').val("");
					$('#form_message').html('<span>Please check your email and click the link to reset your password.</span>').show().delay(5000).fadeOut();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Eroare trimitere mesaj (2) !');
            }
        });
        e.preventDefault(); 		
    }); 
	$('.forget-form1').hide();
	$('#forget-password').click(function() {
		$('.login-form').hide();
		$('.forget-form1').show();
	});

	$('#back-btn').click(function() {
		$('.login-form').show();
		$('.forget-form1').hide();
	});
/* ------------------------------------------------------------------ */	
	$("#form_update_pass").submit(function (e) {		
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");		
		$('#form_message').hide();
        $("#form_update_pass input[type='submit']").attr('disabled', 'disabled');
		$('#loader').show();
        $.ajax(
        {
            url: formURL,
            type: "POST",
            data: postData,
            success: function (data, textStatus, jqXHR) {
				$('#loader').hide();
                $("#form_update_pass input[type='submit']").removeAttr('disabled');
                if (data != 'ok') { 					
					$('#form_message').html('<span style="color:red !important">'+data+'</span>').show().delay(5000).fadeOut();
					$("#form_update_pass").find('input[type="password"]').val("");
					}
                else {					
					$("#form_update_pass").find('input[type="password"]').val("");
					$('#form_message').html('<span>Parola a fost modificata. Acceseaza sectiunea Login pentru autentificare.</span>').show().delay(5000).fadeOut();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Eroare update parola (2) !');
            }
        });
        e.preventDefault(); 		
		
    }); 
	
/* ------------------------------------------------------------------ */

cst_about = function (CustomImg){
	swal({
	  html:true,
	  title: "<strong>Easy Law</strong>",
	  text: "Software pentru avocati",
	  imageUrl: CustomImg
	});
}
/* ------------------------------------------------------------------ */
/* ------------------------------------------------------------------ */

/* ------------------------------------------------------------------ */
getExtension = function (filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}
/* ------------------------------------------------------------------ */
photo_src = function (filename) {
    var parts = filename.split('.');
    var ext  = parts[parts.length - 1];
	var resource_folder = window.location.origin + window.location.pathname + 'resources/img/';
    switch (ext.toLowerCase()) {
		case 'jpg' :
		case 'jpeg':
		case 'gif' :
		case 'bmp' :
		case 'png' :
		case 'tiff':
		case 'tif' :
		case 'jp2' :
		case 'ico' :
			return filename;
		case 'pdf': 
			return resource_folder + "pdf.png";
		case 'doc' : 
		case 'docx': 
			return resource_folder + "doc.png";
		case 'ppt' : 
		case 'pptx': 
			return resource_folder + "ppt.png";
		case 'xls' : 
		case 'xlsx': 
			return resource_folder + "ppt.png";
		case 'txt': 
			return resource_folder + "txt.png";	
		case "zip" :	
		case "rar" :			
		case "7z"  :	
		case "tar" :	
		case "arj" :	
		case "ace" :	
		case "gzip":	
		case "lzip":	
			return resource_folder + "arh.png";
		case "mp3" :
		case "wav" :
		case "wma" :
			return resource_folder + "audio.png";
		case "mp4" :
		case "avi" :
		case "mpg" :
		case "mpeg":
			return resource_folder + "video.png";
		default:
			return resource_folder + "file.png";
    }
    
}
/* ------------------------------------------------------------------ */
clear_file_input = function (input_id) {
	$('#img'+input_id).html('');
	$('#'+input_id).val('');
	$('#open'+input_id).attr('href','javascript:;');	
}
activate_file_input = function (input_id) {
	$('#'+input_id).prop('readonly', false);
	$('#'+input_id).focus();
}
/* ------------------------------------------------------------------ */
cst_isEmpty = function (value) {
  return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}
/* ------------------------------------------------------------------ */
cst_currency = function (type) {
	currency = '';
	switch (type) {
		case '0': currency = 'LEI'; break;
		case '1': currency = 'EUR'; break;
		case '2': currency = 'USD'; break;
		case '3': currency = 'GBP'; break;
		case '4': currency = 'CHF'; break;
	}
	return currency;
}
/* ------------------------------------------------------------------ */