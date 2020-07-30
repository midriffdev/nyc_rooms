jQuery(document).ready(function($) {
     /*------------- Edit Property ---------------*/
	jQuery(".preview").click(function(e){
		e.preventDefault();
		jQuery(".preview").attr("disabled", true);
		jQuery('.error').remove();
		var is_error  = false;
		var title = jQuery('#prop_title').val();
		var status = jQuery('#prop_status').val();
		var type = jQuery('#prop_type').val();
		var price = jQuery('#prop_price').val();
		var accomodation = jQuery('#prop_accomodation').val();
		var rooms = jQuery('#prop_rooms').val();
		var hear = jQuery('#prop_hear').val();
		var gender = jQuery('#prop_gender').val();
		var rm_lang = jQuery('#prop_rm_lang').val();
		var relationship = jQuery('#prop_relationship').val();
		var couple_price = jQuery('#prop_couple_price').val();
		var payment_method = jQuery('#prop_payment_method').val();
		var address = jQuery('#prop_address').val();
		var city = jQuery('#prop_city').val();
		var state = jQuery('#prop_state').val();
		var zip = jQuery('#prop_zip').val();
		var desc = jQuery('#prop_desc').val();
		var agent = jQuery('#prop_agent').val();
		var amenities= [];
		jQuery("#prop_amenities input:checked").each(function(){
			amenities.push(jQuery(this).val());
		});
		var contact_name = jQuery('#contact_name').val();
		var contact_email = jQuery('#contact_email').val();
		var contact_phone = jQuery('#contact_phone').val();
		var people_living_count = jQuery('#people_living_count').val();
		var selected_property_owner  = jQuery('#selected_property_owner').val();
		var phoneValid = /^[+1]{2}[0-9]{10}$/;
		if(contact_phone != ''){
			if(!(contact_phone.match(phoneValid))){
				jQuery('#contact_phone-err').html('<span class="error">Please enter Valid phone with +1 code.</span>');
				is_error = true;				
			}
		}
		if(title == ''){
			jQuery('#title-err').html('<span class="error">Please enter title</span>');
			$('#prop_title').focus();
			is_error = true;		
		}
		if(status == ''){
			jQuery('#status-err').html('<span class="error">Please select status</span>');
			$('#prop_status').focus();
			is_error = true;				
		}
		if(type == ''){
			jQuery('#type-err').html('<span class="error">Please select type</span>');
			$('#prop_type').focus();
			is_error = true;		
		}
		if(price == ''){
			jQuery('#price-err').html('<span class="error">Please enter price</span>');
			$('#prop_price').focus();
			is_error = true;		
		}
		if(accomodation == ''){
			jQuery('#accomodation-err').html('<span class="error">Please enter accomodation</span>');
			$('#prop_accomodation').focus();
			is_error = true;		
		}
		if(rooms == ''){
			jQuery('#rooms-err').html('<span class="error">Please select rooms</span>');
			$('#prop_rooms').focus();
			is_error = true;		
		}
		if(hear == ''){
			jQuery('#hear-err').html('<span class="error">Please select How You Hear About Us?</span>');
			$('#prop_hear').focus();
			is_error = true;		
		}		
		if(gender == ''){
			jQuery('#gender-err').html('<span class="error">Please select gender</span>');
			$('#prop_gender').focus();
			is_error = true;		
		}	
		if(rm_lang == ''){
			jQuery('#rm_lang-err').html('<span class="error">Please select roommate language</span>');
			$('#prop_rm_lang').focus();
			is_error = true;		
		}		
		if(relationship == ''){
			jQuery('#relationship-err').html('<span class="error">Please select relationship</span>');
			$('#prop_relationship').focus();
			is_error = true;		
		}		
		if(payment_method == ''){
			jQuery('#payment_method-err').html('<span class="error">Please select payment method</span>');
			$('#prop_payment_method').focus();
			is_error = true;		
		}	
		if(address == ''){
			jQuery('#address-err').html('<span class="error">Please enter address</span>');
			$('#prop_address').focus();
			is_error = true;		
		}		
		if(city == ''){
			jQuery('#city-err').html('<span class="error">Please enter city</span>');
			$('#prop_city').focus();
			is_error = true;		
		}		
		if(state == ''){
			jQuery('#state-err').html('<span class="error">Please enter state</span>');
			$('#prop_state').focus();
			is_error = true;		
		}		
		if(zip == ''){
			jQuery('#zip-err').html('<span class="error">Please enter zip</span>');
			$('#prop_zip').focus();
			is_error = true;		
		}		
		if(desc == ''){
			jQuery('#desc-err').html('<span class="error">Please enter desc</span>');
			$('#prop_desc').focus();
			is_error = true;		
		}	
		if(contact_name == ''){
			jQuery('#contact_name-err').html('<span class="error">Please enter contact name</span>');
			is_error = true;		
		}		
		if(contact_email == ''){
			jQuery('#contact_email-err').html('<span class="error">Please enter contact email</span>');
			is_error = true;		
		}
		
		if(people_living_count == ''){
			jQuery('#people_living_count-err').html('<span class="error">Please enter how people many living</span>');
			is_error = true;		
		}
		if(is_error == false ){
			jQuery('.loading').show();
			var drop_doc_data = $('.dropzone_documents')[0].dropzone.getAcceptedFiles();
			var file_data = $('.dropzone_gallery')[0].dropzone.getAcceptedFiles();
			var form_data = new FormData();	
			form_data.append("title", title);
			form_data.append("status", status);
			form_data.append("type", type);
			form_data.append("price", price);
			form_data.append("accomodation", accomodation);
			form_data.append("rooms", rooms);
			form_data.append("hear", hear);
			form_data.append("gender", gender);
			form_data.append("rm_lang", rm_lang);
			form_data.append("relationship", relationship);
			form_data.append("couple_price", couple_price);
			form_data.append("payment_method", payment_method);
			form_data.append("address", address);
			form_data.append("city", city);
			form_data.append("state", state);
			form_data.append("zip", zip);
			form_data.append("desc", desc);
			form_data.append("agent", agent);
			form_data.append("amenities", amenities);
			form_data.append("contact_name", contact_name);
			form_data.append("contact_email", contact_email);
			form_data.append("contact_phone", contact_phone);
			form_data.append("people_living_count", people_living_count);
			if(selected_property_owner != null){
				form_data.append("selected_property_owner", selected_property_owner);
			}				
			var gallery_files=[];
			for(var i = 0;i<file_data.length;i++){
				form_data.append("file_"+i, file_data[i]);
				gallery_files.push("file_"+i);
			}
			var document_files=[];
			for(var i = 0;i<drop_doc_data.length;i++){
				form_data.append("doc_"+i, drop_doc_data[i]);
				document_files.push("doc_"+i);
			}
			form_data.append("gallery_files", gallery_files);
			form_data.append("document_files", document_files);
			form_data.append( "action", 'nyc_add_property_ajax');   
			jQuery.ajax({
				type : "post",
				url : my_ajax_object.ajax_url,
				data: form_data,
				processData: false,
				contentType: false,
				success: function(response) {
				       if(response == "success"){
					      jQuery('.loading').hide();
						  jQuery('#successModal .modal-body p').html('<h3 class="nyc_success">Your property listed successfully. It will publish after administrative review.</h3>');
						  jQuery('#successModal').modal('show');
							setTimeout(function() {
								window.location.href = window.location.href;
							}, 5000);
					   } else {
						  jQuery('#successModal .modal-body p').html('<h3 class="nyc_false">Sorry! Something went wrong please try again later.</h3>');
						  jQuery('#successModal').modal('show');						   
							setTimeout(function() {
								window.location.href = window.location.href;
							}, 5000);
					   } 
				}
			})		
		}
		jQuery(".preview").attr("disabled", false);
		
	});
	
	
	
	
	
	
	jQuery('.delete-property').click(function (e) {
	    e.preventDefault();
		// escape here if the confirm is false;
		if (!confirm('Are you sure?')) return false;
		var property_id=jQuery(this).attr('data-id');
		jQuery('.loading').show();
		var form_data = new FormData();	
		form_data.append("property_id", property_id);
		form_data.append( "action", 'nyc_delete_property_ajax');   
		jQuery.ajax({
			type : "post",
			url : my_ajax_object.ajax_url,
			data: form_data,
			processData: false,
			contentType: false,
			success: function(response) {
				if(response == "success"){
				  jQuery('.loading').hide();
				var delete_tr= ".property-id-"+property_id;
				jQuery(delete_tr).fadeOut("slow");	
				}
			}
		});
	});
	
	/*----------Bulk Actions on Agents -------------*/
	
	jQuery('.bulk_actions .apply_action').click(function(){
	  
     var myarray = new Array();
     
    var value = jQuery('.bulk_actions select[class=select_action]').val();
	if(value == -1){
	  alert("please choose a option");
	} else {
	
	      if(value == "delete"){
	         var checkedNum = jQuery('input[class="checkagent"]:checked').length;
		    if(checkedNum == 0){
		        alert('Please choose one or more user to delete');
		    } else {
		       if(checkedNum == 1){
		        var r = confirm("Are you sure to delete this user");
			  } else {
			    var r = confirm("Are you sure to delete these users");
			  }
				if(r == true) {
                       jQuery('input[class="checkagent"]:checked').each(function(){
			                 myarray.push(jQuery(this).val());
			           });
					   jQuery('.loading').show();
					   var data = {
							'action': 'delete_multiple_agents',
							'data':   myarray
	                   };
					// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(my_ajax_object.ajax_url, data, function(response) {
						        
								  if(response == "true"){
								    jQuery('.loading').hide();
									$('#Modaldelete').modal('show');
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								 }, 2000);
								 
								  }
						});   
               }
		     
		     }
		 
		 } else if(value == 'active') {
		    
			 var checkedNum = jQuery('input[class="checkagent"]:checked').length;
		     if(checkedNum == 0){
		         alert('Please choose one or more agent to be active');
		     } else {
		       
				       jQuery('.loading').show();
                       jQuery('input[class="checkagent"]:checked').each(function(){
			                 myarray.push(jQuery(this).val());
			           });
					   
					   var data = {
									'action': 'active_multiple_agents',
									'data':   myarray
	                   };
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(my_ajax_object.ajax_url, data, function(response) {
						          
								  if(response == "true"){
								     jQuery('.loading').hide();
								    $('#Modalactive').modal('show');
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								 }, 2000);
								 
								 }
						  });
		
		     
		     }
		 
		 
		 
		    
		 } else if(value == 'inactive'){
		 
		      var checkedNum = jQuery('input[class="checkagent"]:checked').length;
		     if(checkedNum == 0){
		         alert('Please choose one or more agent to inactive');
		     } else {
		       
				         jQuery('.loading').show();
                       jQuery('input[class="checkagent"]:checked').each(function(){
			                 myarray.push(jQuery(this).val());
			           });
					   
					   var data = {
									'action': 'inactive_multiple_agents',
									'data':   myarray
	                   };
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(my_ajax_object.ajax_url, data, function(response) {
						          
								  if(response == "true"){
								       jQuery('.loading').hide();
									 $('#Modalinactive').modal('show');
									 
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								 }, 2000);
								 
								 }
						  });
		
		     
		     }
			 
		    
		 }
	}
	
    });
   
   jQuery('.checkallagents').click(function(){
	   jQuery(".checkagent").prop('checked', jQuery(this).prop('checked'));
	});
	
	jQuery('.delete_agent_profile').click(function(){
	              var checkedNum = jQuery(this).closest('tr').find('input[class="checkagent"]:checked').length;
				  var mydeletearray = new Array();
	              var id = jQuery(this).data('id');
				  
				  if(checkedNum == 0){
		               alert('Please Select this user to delete');
		          } else {
		       
	                        var r = confirm("Are you sure to delete this user");
					            if(r == true) {
								
											   mydeletearray.push(id);
											 var data = {
													'action': 'delete_multiple_agents',
													'data':   mydeletearray
											   };
											   jQuery('.loading').show();
											// We can also pass the url value separately from ajaxurl for front end AJAX implementations
												jQuery.post(my_ajax_object.ajax_url, data, function(response) {
														
														  if(response == "true"){
														    jQuery('.loading').hide();
															$('#Modaldelete').modal('show'); 
															setTimeout(function(){
															   window.location.reload();
															   // or window.location = window.location.href; 
														 }, 2000);
														 
														 }
												}); 
							   }
			  
	            }

	});
	
	
	
	
	
	
	
	/*------------ bulk actions on leads -------------*/
	
	jQuery('.bulk_actions_leads .apply_action_leads').click(function(){
	  
     var myarrayleads = new Array();
     
    var value = jQuery('.bulk_actions_leads select[class=select_action_leads]').val();
	if(value == -1){
	  alert("please choose a option");
	} else {
	      if(value == "delete"){
	         var checkedNum = jQuery('input[class="checkleads"]:checked').length;
		    if(checkedNum == 0){
		        alert('Please choose one or more lead to delete');
		    } else {
		       if(checkedNum == 1){
		        var r = confirm("Are you sure to delete this lead");
			  } else {
			    var r = confirm("Are you sure to delete these leads");
			  }
				if(r == true) {
                       jQuery('input[class="checkleads"]:checked').each(function(){
			                 myarrayleads.push(jQuery(this).val());
			           });
					   jQuery('.loading').show();
					   var data = {
							'action': 'delete_multiple_leads',
							'data':   myarrayleads
	                   };
					// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(my_ajax_object.ajax_url, data, function(response) {
						
								  if(response == "true"){
								    jQuery('.loading').hide();
									$('#Modaldelete').modal('show');
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								 }, 2000);
								 
								 }
								 
						});   
               }
		     
		     }
		 
		 } else if(value == "intodeal"){
		        var checkedNum = jQuery('input[class="checkleads"]:checked').length;
				if(checkedNum == 0){
					alert('Please choose one or more lead to convert into deal');
				} else {
				          jQuery('.loading').show();
				          jQuery('input[class="checkleads"]:checked').each(function(){
								 myarrayleads.push(jQuery(this).val());
						   });
						   
						   var data = {
								'action': 'adding_multiple_deals',
								'data':   myarrayleads
						   };
						   
						 
						    
						// We can also pass the url value separately from ajaxurl for front end AJAX implementations
							jQuery.post(my_ajax_object.ajax_url, data, function(response) {
					            
									  if(response == "true"){
									     jQuery('.loading').hide();
										$('#ModalDeals').modal('show');
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
   
   jQuery('.checkallleads').click(function(){
        
	   jQuery(".checkleads").not(":disabled").prop('checked', jQuery(this).prop('checked'));
	   
	});
	
	 jQuery('.all_leads_table .delete').click(function(){
	              var checkedNum = jQuery(this).closest('tr').find('input[class="checkleads"]:checked').length;
				   
	              var myarrayleads = new Array();
	              var id = jQuery(this).data('id');
				  
				  if(checkedNum == 0){
		               alert('Please Select this lead to delete');
		          } else {
		       
	                        var r = confirm("Are you sure to delete this lead");
					            if(r == true) {
											   jQuery('.loading').show();
											   myarrayleads.push(id);
											   
											   
											 var data = {
													'action': 'delete_multiple_leads',
													'data':   myarrayleads
											   };
											// We can also pass the url value separately from ajaxurl for front end AJAX implementations
												jQuery.post(my_ajax_object.ajax_url, data, function(response) {
														
														  if(response == "true"){
														    jQuery('.loading').hide();
															$('#Modaldelete').modal('show'); 
															setTimeout(function(){
															   window.location.reload();
															   // or window.location = window.location.href; 
														 }, 2000);
														 
														 }
												}); 
							   }
			  
	            }
	   
	    
	   
	}); 
	
	jQuery('.all_leads_table .into--deal').click(function(){
	         
	        var checkedNum = jQuery(this).closest('tr').find('input[class="checkleads"]:checked').length;
	        var myarrayleads = new Array();
	        var id = jQuery(this).data('id');
				if(checkedNum == 0){
					alert('Please select this lead to convert to deal');
				} else {
				           jQuery('.loading').show();
				           $(this).css('pointer-events','none');
						
				           myarrayleads.push(id);
						   var data = {
								'action': 'adding_multiple_deals',
								'data':   myarrayleads
						   };
						   
						 
						    
						// We can also pass the url value separately from ajaxurl for front end AJAX implementations
							jQuery.post(my_ajax_object.ajax_url, data, function(response) {
					                  console.log(response);
									  /* if(response == "true"){
									    jQuery('.loading').hide();
										$('#ModalDeals').modal('show');
										setTimeout(function(){
										   window.location.reload();
										   // or window.location = window.location.href; 
										}, 2000);
									 } */
									 
							});   
				 
				}
	    
	});
	
	/*-------------- Bulk Actions on Properties --------------*/
	
	
   jQuery('.bulk_actions_properties .apply_action_properties').click(function(){
	  
		 var myarrayproperties = new Array();
		 
		var value = jQuery('.bulk_actions_properties select[class=select_action_properties]').val();
		if(value == -1){
		  alert("please choose a option");
		} else {
			  if(value == "delete"){
				 var checkedNum = jQuery('input[class="checkproperties"]:checked').length;
				if(checkedNum == 0){
					alert('Please choose one or more properties to delete');
				} else {
				   if(checkedNum == 1){
					var r = confirm("Are you sure to trash this property");
				  } else {
					var r = confirm("Are you sure to trash these properties");
				  }
					if(r == true) {
					       jQuery('.loading').show();
						   jQuery('input[class="checkproperties"]:checked').each(function(){
								 myarrayproperties.push(jQuery(this).val());
						   });
						   
						   var data = {
								'action': 'delete_multiple_properties',
								'data':   myarrayproperties
						   };
						// We can also pass the url value separately from ajaxurl for front end AJAX implementations
							jQuery.post(my_ajax_object.ajax_url, data, function(response) {
									
									  
									
									  if(response == "true"){
									    jQuery('.loading').hide();
										$('#Modaldelete').modal('show');
										setTimeout(function(){
										   window.location.reload();
										   // or window.location = window.location.href; 
									 }, 2000);
									 
									 }
									 
									 
							});   
				   }
				 
				 }
			 
			 } else if(value == 'activate'){
		       var checkedNum = jQuery('input[class="checkproperties"]:checked').length;
				 if(checkedNum == 0){
					 alert('Please choose one or more properties to activate');
				 } else {
				   
						   jQuery('.loading').show();
						   jQuery('input[class="checkproperties"]:checked').each(function(){
								 myarrayproperties.push(jQuery(this).val());
						   });
						   
						   var data = {
										'action': 'activate_multiple_properties',
										'data':   myarrayproperties
						   };
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
							jQuery.post(my_ajax_object.ajax_url, data, function(response) {
									 
									   if(response == "true"){
										 jQuery('.loading').hide();
										 $('#Modalactivate').modal('show');
										setTimeout(function(){
										   window.location.reload();
										   // or window.location = window.location.href; 
										}, 2000);
									 
									   }
									 
							  });
			
				 
				   }
			 //jQuery('.agent_selected').each()
		     } else if(value == 'deactivate') {
		       var checkedNum = jQuery('input[class="checkproperties"]:checked').length;
		     if(checkedNum == 0){
		         alert('Please choose one or more properties to deactivate');
		     } else {
		       
				       jQuery('.loading').show();
                       jQuery('input[class="checkproperties"]:checked').each(function(){
			                 myarrayproperties.push(jQuery(this).val());
			           });
					   
					   var data = {
									'action': 'deactivate_multiple_properties',
									'data':   myarrayproperties
	                   };
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(my_ajax_object.ajax_url, data, function(response) {
						         
								   if(response == "true"){
								     jQuery('.loading').hide();
									 $('#Modaldeactivate').modal('show');
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								    }, 2000);
								 
								   }
								 
						  });
		
		     
		       }
			 //jQuery('.agent_selected').each()
		     } else if(value == 'approve'){
		       var checkedNum = jQuery('input[class="checkproperties"]:checked').length;
		     if(checkedNum == 0){
		         alert('Please choose one or more properties to approve');
		     } else {
		       
				       jQuery('.loading').show();
                       jQuery('input[class="checkproperties"]:checked').each(function(){
			                 myarrayproperties.push(jQuery(this).val());
			           });
					   
					   var data = {
									'action': 'approve_multiple_properties',
									'data':   myarrayproperties
	                   };
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(my_ajax_object.ajax_url, data, function(response) {
						         
								   if(response == "true"){
								     jQuery('.loading').hide();
									 $('#ModalApproveProp').modal('show');
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								    }, 2000);
								 
								   }
								 
						  });
		
		     
		       }
			 //jQuery('.agent_selected').each()
		     } else if(value == 'unapprove'){
		       var checkedNum = jQuery('input[class="checkproperties"]:checked').length;
		     if(checkedNum == 0){
		         alert('Please choose one or more properties to approve');
		     } else {
		       
				       jQuery('.loading').show();
                       jQuery('input[class="checkproperties"]:checked').each(function(){
			                 myarrayproperties.push(jQuery(this).val());
			           });
					   
					   var data = {
									'action': 'unapprove_multiple_properties',
									'data':   myarrayproperties
	                   };
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
						jQuery.post(my_ajax_object.ajax_url, data, function(response) {
						            console.log(response);
								    if(response == "true"){
									 jQuery('.loading').hide();
									 $('#ModalUnApproveProp').modal('show');
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
								    }, 2000);
								 
								   }
								 
						  });
		
		     
		       }
			 //jQuery('.agent_selected').each()
		     } 
	}
	
   });
   
   jQuery('.checkallproperties').click(function(){
	   jQuery(".checkproperties").prop('checked', jQuery(this).prop('checked'));
	});
	
	jQuery('.all_properties_table .delete_admin_property').click(function(){
	              var checkedNum = jQuery(this).closest('tr').find('input[class="checkproperties"]:checked').length;
				   
	              var myarrayprop = new Array();
	              var id = jQuery(this).data('id');
				  
				  if(checkedNum == 0){
		               alert('Please Select this Property to Trash');
		          } else {
		       
	                        var r = confirm("Are you sure to trash this Property");
					            if(r == true) {
											  jQuery('.loading').show(); 
											  myarrayprop.push(id);
											  
											  var data = {
													'action': 'delete_multiple_properties',
													'data':   myarrayprop
											   };
											// We can also pass the url value separately from ajaxurl for front end AJAX implementations
												jQuery.post(my_ajax_object.ajax_url, data, function(response) {
														
														  if(response == "true"){
														    jQuery('.loading').hide();
															$('#Modaldelete').modal('show'); 
															setTimeout(function(){
															   window.location.reload();
															   // or window.location = window.location.href; 
														     }, 2000);
														 
														 }
												}); 
							   }
			  
	            }
	   
	    
	   
	});  
	
	/* ------------- Activate Property ----------------------- */
	
	jQuery('.all_properties_table .actvate_prperty').click(function(){
	              var checkedNum = jQuery(this).closest('tr').find('input[class="checkproperties"]:checked').length;
				   
	              var myarrayprop = new Array();
	              var id = jQuery(this).data('id');
				  
				  if(checkedNum == 0){
		               alert('Please select this property to activate');
		          } else {
		                      jQuery('.loading').show(); 
							  myarrayprop.push(id);
							  
                              var data = {
									'action': 'activate_multiple_properties',
									'data':   myarrayprop
							   };
							// We can also pass the url value separately from ajaxurl for front end AJAX implementations
								jQuery.post(my_ajax_object.ajax_url, data, function(response) {
										
										  if(response == "true"){
											jQuery('.loading').hide();
											$('#Modalactivate').modal('show'); 
											setTimeout(function(){
											   window.location.reload();
											   // or window.location = window.location.href; 
											 }, 2000);
										 
										 }
								}); 
	            }
	   
	    
	   
	});  
	
	
	/* ------------- Deactivate Property ----------------------- */
	
	jQuery('.all_properties_table .deactvate_prperty').click(function(){
	              var checkedNum = jQuery(this).closest('tr').find('input[class="checkproperties"]:checked').length;
				   
	              var myarrayprop = new Array();
	              var id = jQuery(this).data('id');
				  
				  if(checkedNum == 0){
		               alert('Please select this property to deactivate');
		          } else {
		                      jQuery('.loading').show(); 
							  myarrayprop.push(id);
							  
                              var data = {
									'action': 'deactivate_multiple_properties',
									'data':   myarrayprop
							   };
							// We can also pass the url value separately from ajaxurl for front end AJAX implementations
								jQuery.post(my_ajax_object.ajax_url, data, function(response) {
										
										  if(response == "true"){
											jQuery('.loading').hide();
											$('#Modaldeactivate').modal('show'); 
											setTimeout(function(){
											   window.location.reload();
											   // or window.location = window.location.href; 
											 }, 2000);
										 
										 }
								}); 
	            }
	   
	    
	   
	});  
	
	
	
	
	jQuery('.approve_property').click(function(){
	
	              var checkedNum = jQuery(this).closest('tr').find('input[class="checkproperties"]:checked').length;
				  var myapprovearray = new Array();
	              var id = jQuery(this).data('id');
				  
				  if(checkedNum == 0){
		               alert('Please select this property to approve');
		          } else {
		                                       jQuery('.loading').show();
								               myapprovearray.push(id);
											   var data = {
													'action': 'approve_multiple_properties',
													'data':   myapprovearray
											   };
											// We can also pass the url value separately from ajaxurl for front end AJAX implementations
												jQuery.post(my_ajax_object.ajax_url, data, function(response) {
														
														  if(response == "true"){
														    jQuery('.loading').hide();
															$('#ModalApproveProp').modal('show'); 
															setTimeout(function(){
															   window.location.reload();
															   // or window.location = window.location.href; 
														 }, 2000);
														 
														 }
														 
												}); 
							  
			  
	            }

	});
	
	jQuery('.unapprove_property').click(function(){
	
	              var checkedNum = jQuery(this).closest('tr').find('input[class="checkproperties"]:checked').length;
				  var myunapprovearray = new Array();
	              var id = jQuery(this).data('id');
				  
				  if(checkedNum == 0){
		               alert('Please select this property to unApprove');
		          } else {
		                                     jQuery('.loading').show();
								             myunapprovearray.push(id);
											 var data = {
													'action': 'unapprove_multiple_properties',
													'data':   myunapprovearray
											   };
											// We can also pass the url value separately from ajaxurl for front end AJAX implementations
												jQuery.post(my_ajax_object.ajax_url, data, function(response) {
														
														  if(response == "true"){
														    jQuery('.loading').hide();
															$('#ModalUnApproveProp').modal('show'); 
															setTimeout(function(){
															   window.location.reload();
															   // or window.location = window.location.href; 
														 }, 2000);
														 
														 }
														 
												}); 
							  
			  
	            }

	});
	
	
	
});