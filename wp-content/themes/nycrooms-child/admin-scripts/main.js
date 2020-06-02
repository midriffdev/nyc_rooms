jQuery(document).ready(function(){
  jQuery('#table_id').DataTable();
  
  jQuery('#doaction2.button.action').click(function(){
  
       var myarray = new Array();
     
    var value = jQuery('select[name=action2]').val();
	if(value == -1){
	  alert("please choose a option");
	} else {
	      if(value == "delete"){
	         var checkedNum = jQuery('input[class="agent_selected"]:checked').length;
		    if(checkedNum == 0){
		        alert('Please choose one or more agent to delete');
		    } else {
		       if(checkedNum == 1){
		        var r = confirm("Are you sure to delete this user");
			  } else {
			    var r = confirm("Are you sure to delete these users");
			  }
				if(r == true) {
                       jQuery('input[class="agent_selected"]:checked').each(function(){
			                 myarray.push(jQuery(this).val());
			           });
					   
					   var data = {
							'action': 'delete_multiple_agents',
							'data':   myarray
	                   };
					// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(ajax_object.ajax_url, data, function(response) {
								 if(response == "true"){
									 alert("users Deleted successfully");
									setTimeout(function(){
									   window.location.reload();
									   /* or window.location = window.location.href; */
								 }, 2000);
								 
								 }
						});   
               }
		     
		     }
		 
		 } else if(value == 'active') {
		    
			 var checkedNum = jQuery('input[class="agent_selected"]:checked').length;
		     if(checkedNum == 0){
		         alert('Please choose one or more agent to be active');
		     } else {
		       
				
                       jQuery('input[class="agent_selected"]:checked').each(function(){
			                 myarray.push(jQuery(this).val());
			           });
					   
					   var data = {
									'action': 'active_multiple_agents',
									'data':   myarray
	                   };
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(ajax_object.ajax_url, data, function(response) {
						           console.log(response);
								  if(response == "true"){
									 alert("users activated successfully");
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								 }, 2000);
								 
								 }
						  });
		
		     
		     }
		 
		 
		 
		    
		 } else if(value == 'inactive'){
		 
		      var checkedNum = jQuery('input[class="agent_selected"]:checked').length;
		     if(checkedNum == 0){
		         alert('Please choose one or more agent to inactive');
		     } else {
		       
				
                       jQuery('input[class="agent_selected"]:checked').each(function(){
			                 myarray.push(jQuery(this).val());
			           });
					   
					   var data = {
									'action': 'inactive_multiple_agents',
									'data':   myarray
	                   };
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(ajax_object.ajax_url, data, function(response) {
						          console.log(response);
								 if(response == "true"){
									 alert("users inactive successfully");
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								 }, 2000);
								 
								 }
						  });
		
		     
		     }
			 
		    
		 }
		 
		 
	    //jQuery('.agent_selected').each()
	}
	
  });
  
    jQuery('#all_selected_agent').click(function(){
	   jQuery(".agent_selected").prop('checked', jQuery(this).prop('checked'));
	});
  
});

