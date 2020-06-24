jQuery(document).ready(function($) {
    jQuery('.checkallbulk').click(function(){
	   jQuery(".checkbulk").prop('checked', jQuery(this).prop('checked'));
	});
	jQuery('.users_bulk_actions .user_apply_action').click(function(){  
    var myarray = new Array();  
    var value = jQuery('.users_bulk_actions select[class=select_action]').val();
	if(value == -1){
	  alert("please choose a option");
	}else{
		if(value == "delete"){
			var checkedNum = jQuery('input[class="checkbulk"]:checked').length;
		if(checkedNum == 0){
			alert('Please choose one or more user to delete');
		}else{
			if(checkedNum == 1){
				var r = confirm("Are you sure to delete this user");
			}else {
				var r = confirm("Are you sure to delete these users");
			}
			if(r == true){
				   jQuery('input[class="checkbulk"]:checked').each(function(){
						 myarray.push(jQuery(this).val());
				   });
				   var data = {
						'action': 'nyc_bulk_action_user',
						'data':   myarray,
						'bulkaction':'delete',
				   };
				// We can also pass the url value separately from ajaxurl for front end AJAX implementations
					jQuery.post(my_ajax_object.ajax_url, data, function(response) {						
						if(response == "true"){
							$('#ModalUser .modal-body p').html('User Deleted Successfully');
							$('#ModalUser').modal('show');
							setTimeout(function(){
							   window.location.reload();
							   // or window.location = window.location.href; 
							}, 2000);						 
						}
					});   
			}
		 
		}
		}else if(value == 'active') {
		var checkedNum = jQuery('input[class="checkbulk"]:checked').length;
		if(checkedNum == 0){
			 alert('Please choose one or more user to be active');
		} else {
			jQuery('input[class="checkbulk"]:checked').each(function(){
				myarray.push(jQuery(this).val());
			});			   
			var data = {
						'action': 'nyc_bulk_action_user',
						'data':   myarray,
						'bulkaction':'active',						
			};
			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.post(my_ajax_object.ajax_url, data, function(response) {			  
				if(response == "true"){
					$('#ModalUser .modal-body p').html('User Active Successfully');
					$('#ModalUser').modal('show');
					setTimeout(function(){
					   window.location.reload();
					   // or window.location = window.location.href; 
					}, 2000);	
				}
			});		 
		}
		}else if(value == 'inactive'){
		var checkedNum = jQuery('input[class="checkbulk"]:checked').length;
		if(checkedNum == 0){
			alert('Please choose one or more user to inactive');
		}else{
		jQuery('input[class="checkbulk"]:checked').each(function(){
			 myarray.push(jQuery(this).val());
		});
		var data = {
					'action': 'nyc_bulk_action_user',
					'data':   myarray,
					'bulkaction':'inactive',	
		};
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		jQuery.post(my_ajax_object.ajax_url, data, function(response) {			  
			if(response == "true"){
				$('#ModalUser .modal-body p').html('User Inactive Successfully');
				$('#ModalUser').modal('show');
				setTimeout(function(){
				   window.location.reload();
				}, 2000);
			}
		});
		}
		}else if(value == 'download-csv'){
		var checkedNum = jQuery('input[class="checkbulk"]:checked').length;
		if(checkedNum == 0){
			alert('Please choose one or more user to download csv');
		}else{
		jQuery('input[class="checkbulk"]:checked').each(function(){
			 myarray.push(jQuery(this).val());
		});
			var curr_page = window.location.href,
			next_page = "";
			if(curr_page.indexOf("?") > -1) {
				next_page = curr_page+"&action-csv="+myarray;
			} else {
				next_page = curr_page+"?action-csv="+myarray;
			}
			console.log(next_page);
			// Redirect to next page
			window.location.href = next_page;		
		}
		}
		}
   });
   
	jQuery('.deal_bulk_actions .deal_apply_action').click(function(){  
    var myarray = new Array();  
    var value = jQuery('.deal_bulk_actions select[class=select_action]').val();
	if(value == -1){
	  alert("please choose a option");
	}else{
			if(value == "delete"){
				var checkedNum = jQuery('input[class="checkbulk"]:checked').length;
				alert
				if(checkedNum == 0){
					alert('Please choose one or more deal to delete');
				}else{
					if(checkedNum == 1){
						var r = confirm("Are you sure to delete this deal");
					}else {
						var r = confirm("Are you sure to delete these deals");
					}
					if(r == true){
						   jQuery('input[class="checkbulk"]:checked').each(function(){
								 myarray.push(jQuery(this).val());
						   });
						   var data = {
								'action': 'nyc_bulk_delete_deal',
								'data':   myarray,
								'bulkaction':'delete',
						   };
						// We can also pass the url value separately from ajaxurl for front end AJAX implementations
							jQuery.post(my_ajax_object.ajax_url, data, function(response) {						
								if(response == "true"){
									$('#ModalUser .modal-body p').html('Deals Deleted Successfully');
									$('#ModalUser').modal('show');
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
									}, 2000);						 
								}
							});   
					}
				 
				}
			}
		}
   });
});