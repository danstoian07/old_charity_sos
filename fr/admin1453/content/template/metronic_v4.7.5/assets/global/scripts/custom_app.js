$( document ).ready(function() {

	$('body').on("click","#code_generator_input_but", function(e) {	  		
			App.blockUI({message: 'Procesare...'});
			var postData = '';
			var jqXHR=$.ajax({
				  url: "action/ajax-generate-ui.php",
				  type: "POST",
				  data: postData,
				  async: false
				});    
			
			if (jqXHR.responseText!='') {
				data   = jqXHR.responseText;
				$('#code_generator_input').val(data);
				App.unblockUI();
			} else {
				App.unblockUI();
				cst_message('ATENTIE: Apel ajax fara rezultat !!!');
			}
						
		});		
		
		
		$("#promotion_type").trigger("change");
});	
