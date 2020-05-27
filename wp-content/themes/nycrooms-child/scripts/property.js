jQuery(document).ready(function($) {
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
		if(title == ''){
			jQuery('#title-err').html('<span class="error">Please enter title</span>');
			is_error = true;		
		}
		if(status == ''){
			jQuery('#status-err').html('<span class="error">Please select status</span>');
			is_error = true;		
		}
		if(type == ''){
			jQuery('#type-err').html('<span class="error">Please select type</span>');
			is_error = true;		
		}
		if(price == ''){
			jQuery('#price-err').html('<span class="error">Please enter price</span>');
			is_error = true;		
		}
		if(accomodation == ''){
			jQuery('#accomodation-err').html('<span class="error">Please enter accomodation</span>');
			is_error = true;		
		}
		if(rooms == ''){
			jQuery('#rooms-err').html('<span class="error">Please select rooms</span>');
			is_error = true;		
		}
		if(hear == ''){
			jQuery('#hear-err').html('<span class="error">Please select How You Hear About Us?</span>');
			is_error = true;		
		}		
		if(gender == ''){
			jQuery('#gender-err').html('<span class="error">Please select gender</span>');
			is_error = true;		
		}		
		if(gender == ''){
			jQuery('#gender-err').html('<span class="error">Please select gender</span>');
			is_error = true;		
		}		
		if(rm_lang == ''){
			jQuery('#rm_lang-err').html('<span class="error">Please select roommate language</span>');
			is_error = true;		
		}		
		if(relationship == ''){
			jQuery('#relationship-err').html('<span class="error">Please select relationship</span>');
			is_error = true;		
		}		
		if(relationship == ''){
			jQuery('#couple_price-err').html('<span class="error">Please select Couple price</span>');
			is_error = true;		
		}		
		if(payment_method == ''){
			jQuery('#payment_method-err').html('<span class="error">Please select payment method</span>');
			is_error = true;		
		}		
		if(address == ''){
			jQuery('#address-err').html('<span class="error">Please enter address</span>');
			is_error = true;		
		}		
		if(city == ''){
			jQuery('#city-err').html('<span class="error">Please enter city</span>');
			is_error = true;		
		}		
		if(state == ''){
			jQuery('#state-err').html('<span class="error">Please enter state</span>');
			is_error = true;		
		}		
		if(zip == ''){
			jQuery('#zip-err').html('<span class="error">Please enter zip</span>');
			is_error = true;		
		}		
		if(desc == ''){
			jQuery('#desc-err').html('<span class="error">Please enter desc</span>');
			is_error = true;		
		}		
		if(agent == ''){
			jQuery('#agent-err').html('<span class="error">Please select agent</span>');
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
		if(is_error == false ){
			var file_data = $('.dropzone')[0].dropzone.getAcceptedFiles();
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
			var gallery_files=[];
			for(var i = 0;i<file_data.length;i++){
				form_data.append("file_"+i, file_data[i]);
				gallery_files.push("file_"+i);
			}
			form_data.append("gallery_files", gallery_files);
			form_data.append( "action", 'nyc_add_property_ajax');   
			jQuery.ajax({
				type : "post",
				url : my_ajax_object.ajax_url,
				data: form_data,
				processData: false,
				contentType: false,
				success: function(response) {
				    if(response == "success"){
						window.location.href = window.location.href + "?action=success";
					}else{
						window.location.href = window.location.href + "?action=false";
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
				var delete_tr= ".property-id-"+property_id;
				jQuery(delete_tr).fadeOut("slow");	
				}
			}
		});
	});
});