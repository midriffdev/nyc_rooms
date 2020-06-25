<?php 
/*
Template Name: Admin Edit Property
*/
nyc_property_admin_authority();
$property = get_post($_GET['pid']);
$propertyID = $property->ID;
$post_status = $property->post_status;
$post_author = $property->post_author;
$propertyTerm = get_the_terms( $propertyID,'types' );
get_header();
?>
<!-- Wrapper -->
<div id="wrapper">
<!-- Content
================================================== -->
<div class="container">
<div class="row">
			<?php 
			if(isset($_GET['action']) && $_GET['action'] == "success"){ 
			echo "<h3 class='nyc_success'>Your property Updated successfully.</h3>";
			}
			if(isset($_GET['action']) && $_GET['action'] == "false"){
			echo "<h3 class='nyc_false'>Sorry! Something went wrong please try again later.</h3>"; 
			}
			?>
	<!-- Submit Page -->
	<div class="col-md-12">
		<div class="submit-page add-property-page" id="prop_form_data">
        
		<!-- Section -->
		<h3>Basic Information</h3>
		<div class="submit-section">
			<div class="form">
				<h5>Property Title <i class="tip" data-tip-content="Type title that will also contains an unique feature of your property (e.g. renovated, air contidioned)"></i></h5>
				<input class="search-field" id="prop_title" type="text" value="<?= get_the_title($propertyID); ?>"/>
				<span id="title-err"></span>
			</div>

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-6">
					<h5>Status</h5>
					<select class="chosen-select-no-single" id="prop_status">
						<option label="blank"></option>	
						<option value="available"<?= (get_post_meta($propertyID,'status',true) == 'available')? 'selected': '' ?>>Available</option>
						<option value="rented" <?= (get_post_meta($propertyID,'status',true) == 'rented')? 'selected': '' ?> >Rented</option>
					</select>
					<span id="status-err"></span>
				</div>

				<div class="col-md-6">
					<h5>Type</h5>
					<select class="chosen-select-no-single" id="prop_type">
						<option label="blank"></option>		
						<?php 
						$types = get_terms([
							'taxonomy' => 'types',
							'hide_empty' => false,
						]); 
						
						foreach($types as $type)
						{
						?>
							<option value="<?=$type->term_id ?>" <?php if($propertyTerm){if($propertyTerm[0]->term_id == $type->term_id){echo 'selected';}} ?>> <?= $type->name ?> </option>
					  <?php
						}				
						?>
					</select>
					<span id="type-err"></span>
				</div>

			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-4">
					<h5>Price <i class="tip" data-tip-content="Type overall or monthly price if property is for rent"></i></h5>
					<div class="select-input disabled-first-option">
						<input type="text" id="prop_price" data-unit="USD" value="<?= get_post_meta($propertyID,'price',true)  ?>">
					</div>
					<span id="price-err"></span>
				</div>

				<div class="col-md-4">
					<h5>Type of Accomodation</h5>
					<select class="chosen-select-no-single" id="prop_accomodation">
						<option label="blank"></option>		
						<option value="Apartment" <?= (get_post_meta($propertyID,'accomodation',true) == 'Apartment')? 'selected': '' ?>>Apartment</option>
						<option value="Room" <?= (get_post_meta($propertyID,'accomodation',true) == 'Room')? 'selected': '' ?>>Room</option>
					</select>
					<span id="accomodation-err"></span>
				</div>
				
				<div class="col-md-4">
					<h5>Rooms</h5>
					<select class="chosen-select-no-single" id="prop_rooms">
						<option label="blank"></option>	
						<option value="1" <?= (get_post_meta($propertyID,'rooms',true) == '1')?  'selected': '' ?> >1</option>
						<option value="2" <?= (get_post_meta($propertyID,'rooms',true) == '2')?  'selected': '' ?> >2</option>
						<option value="3" <?= (get_post_meta($propertyID,'rooms',true) == '3')?  'selected': '' ?> >3</option>
						<option value="4" <?= (get_post_meta($propertyID,'rooms',true) == '4')?  'selected': '' ?> >4</option>
						<option value="5" <?= (get_post_meta($propertyID,'rooms',true) == '5')?  'selected': '' ?> >5</option>
						<option value="5+" <?=(get_post_meta($propertyID,'rooms',true) == '5+')? 'selected': '' ?> >More than 5</option>
					</select>
					<span id="rooms-err"></span>
				</div>
			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-4">
					<h5>How'd You Hear About Us?</h5>
					<select class="chosen-select-no-single" id="prop_hear">
						<option label="blank"></option>	
						<option value="Google" <?=(get_post_meta($propertyID,'hear',true) == 'Google')? 'selected': '' ?>>Google</option>
						<option value="Business Card" <?=(get_post_meta($propertyID,'hear',true) == 'Business Card')? 'selected': '' ?>>Business Card</option>
						<option value="NYC Rooms for rent" <?=(get_post_meta($propertyID,'hear',true) == 'NYC Rooms for rent')? 'selected': '' ?> >NYC Rooms for rent</option>
						<option value="Flyer" <?=(get_post_meta($propertyID,'hear',true) == 'Flyer')? 'selected': '' ?> >Flyer</option>
						<option value="Supermarket" <?=(get_post_meta($propertyID,'hear',true) == 'Supermarket')? 'selected': '' ?> >Supermarket</option>
						<option value="News paper" <?=(get_post_meta($propertyID,'hear',true) == 'News paper')? 'News paper': '' ?> >News paper</option>
						<option value="Facebook" <?=(get_post_meta($propertyID,'hear',true) == 'Facebook')? 'selected': '' ?> >Facebook</option>
						<option value="Agent found" <?=(get_post_meta($propertyID,'hear',true) == 'Agent found')? 'selected': '' ?> >Agent found</option>
						<option value="Other" <?=(get_post_meta($propertyID,'hear',true) == 'Other')? 'selected': '' ?> >Other</option>
					</select>
					<span id="hear-err"></span>
				</div>

				<div class="col-md-4">
					<h5>Gender preference</h5>
					<select class="chosen-select-no-single" id="prop_gender">
						<option label="blank"></option>		
						<option value="Female" <?=(get_post_meta($propertyID,'gender',true) == 'Female')? 'selected': '' ?> >Female</option>
						<option value="Male" <?=(get_post_meta($propertyID,'gender',true) == 'Male')? 'selected': '' ?> >Male</option>
						<option value="Any" <?=(get_post_meta($propertyID,'gender',true) == 'Any')? 'selected': '' ?> >Any</option>
					</select>
					<span id="gender-err"></span>
				</div>

				<div class="col-md-4">
					<h5>Preferred Language of Roommate</h5>
					<select class="chosen-select-no-single" id="prop_rm_lang">
						<option label="blank"></option>	
						<option value="English" <?=(get_post_meta($propertyID,'rm_lang',true) == 'English')? 'selected': '' ?> >English</option>
						<option value="Spanish" <?=(get_post_meta($propertyID,'rm_lang',true) == 'Spanish')? 'selected': '' ?> >Spanish</option>
						<option value="Any" <?=(get_post_meta($propertyID,'rm_lang',true) == 'Any')? 'selected': '' ?> >Any</option>
					</select>
					<span id="rm_lang-err"></span>
				</div>
			</div>
			<!-- Row / End -->

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-4">
					<h5>Single / Couples</h5>
					<select class="chosen-select-no-single" id="prop_relationship">
						<option label="blank"></option>	
						<option value="Single" <?=(get_post_meta($propertyID,'relationship',true) == 'Single')? 'selected': '' ?> >Single</option>
						<option value="Couple" <?=(get_post_meta($propertyID,'relationship',true) == 'Couple')? 'selected': '' ?> >Couple</option>
						<option value="Any" <?=(get_post_meta($propertyID,'relationship',true) == 'Any')? 'selected': '' ?> >Any</option>
					</select>
					<span id="relationship-err"></span>					
				</div>

				<div class="col-md-4">
					<h5>Price for Couples</h5>
					<div class="select-input disabled-first-option">
						<input type="text" data-unit="USD" id="prop_couple_price" value="<?= get_post_meta($propertyID,'couple_price',true) ?>">
					</div>
					<span id="couple_price-err"></span>
				</div>

				<div class="col-md-4">
					<h5>Payment</h5>
					<select class="chosen-select-no-single" id="prop_payment_method">
						<option label="blank"></option>	
						<option value="Weekly" <?=(get_post_meta($propertyID,'payment_method',true) == 'Weekly')? 'selected': '' ?> >Weekly</option>
						<option value="Bi-Weekly" <?=(get_post_meta($propertyID,'payment_method',true) == 'Bi-Weekly')? 'selected': '' ?> >Bi-Weekly</option>
						<option value="Monthly" <?=(get_post_meta($propertyID,'payment_method',true) == 'Monthly')? 'selected': '' ?> >Monthly</option>
					</select>
					<span id="payment_method-err"></span>
				</div>
			</div>
			<!-- Row / End -->
			
			<div class="row with-forms">
			   <div class="col-md-8">
					<h5>How many people will living the property?</h5>
					<select class="chosen-select-no-single" id="people_living_count" >
						<option label="blank"></option>		
						<option value="1" <?=(get_post_meta($propertyID,'people_living_count',true) == '1')? 'selected': '' ?>  >1</option>
						<option value="2" <?=(get_post_meta($propertyID,'people_living_count',true) == '2')? 'selected': '' ?>  >2</option>
						<option value="3" <?=(get_post_meta($propertyID,'people_living_count',true) == '3')? 'selected': '' ?>  >3</option>
						<option value="not sure" <?=(get_post_meta($propertyID,'people_living_count',true) == 'not sure')? 'selected': '' ?>  >Not sure </option>
					</select>
					<span id="people_living_count-err"></span>
				</div>
			</div>

		</div>
		<!-- Section / End -->

		<!-- Section -->
		<h3>Gallery</h3>
		<div class="submit-section prop_gallery">
			<form action="<?= site_url() ?>/edit-property-admin/?pid="<?= $propertyID ?> class="dropzone dropzone_media" ></form>
		</div>
		<!-- Section / End -->
		
		<!-- Section -->
		<h3>Required Documents</h3>
		<div class="submit-section prop_req_docs">
			<form action="<?= site_url() ?>/edit-property-admin/?pid="<?= $propertyID ?> class="dropzone dropzone_documents_update" ></form>
		</div>
		<!-- Section / End -->


		<!-- Section -->
		<h3>Location</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-6">
					<h5>Address</h5>
					<input type="text" id="prop_address" value="<?= get_post_meta($propertyID,'address',true) ?>">
					<span id="address-err"></span>
				</div>

				<div class="col-md-6">
					<h5>City</h5>
					<input type="text" id="prop_city" value="<?= get_post_meta($propertyID,'city',true) ?>" >
					<span id="city-err"></span>
				</div>

				<div class="col-md-6">
					<h5>State</h5>
					<input type="text" id="prop_state" value="<?= get_post_meta($propertyID,'state',true) ?>" >
					<span id="state-err"></span>
				</div>

				<div class="col-md-6">
					<h5>Zip-Code</h5>
					<input type="text" id="prop_zip" value="<?= get_post_meta($propertyID,'zip',true) ?>">
					<span id="zip-err"></span>
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->


		<!-- Section -->
		<h3>Detailed Information</h3>
		<div class="submit-section">

			<!-- Description -->
			<div class="form">
				<h5>Description</h5>
				<textarea class="WYSIWYG" name="summary" cols="40" rows="3" id="prop_desc" spellcheck="true"><?= get_the_content(null,false,$propertyID) ?></textarea>
				<span id="desc-err"></span>
			</div>

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-6">
					<h5>Agent</h5>
					<select class="chosen-select-no-single" id="prop_agent">
						<option label="blank"></option>	
					<?php 
						$args = array(
						 'role' => 'sales_agent',
						 'orderby' => 'user_nicename',
						 'order' => 'ASC'
						);
						 $agents = get_users($args);
						 foreach ($agents as $agent) {
					 ?>
						<option value="<?= $agent->ID ?>" <?= ($agent->ID == get_post_meta($propertyID,'agent',true))? 'selected':'' ?>> <?= $agent->display_name ?> </option>
					<?php 
						 }
					 ?>
					</select>
					<span id="agent-err"></span>
				</div>

				<div class="col-md-6">
					<!-- Checkboxes -->
					<h5>Amenities</h5>
					<div class="checkboxes in-row margin-bottom-20" id="prop_amenities">
				         <?php
                           $animites = get_post_meta($propertyID,'amenities',true);
						   $animites = explode(',',$animites);
						  

						 ?>
						<input id="check-2" type="checkbox" name="check" value="Bed" <?= (in_array("Bed", $animites)) ? 'checked':'' ?> >
						<label for="check-2">Bed</label>

						<input id="check-3" type="checkbox" name="check" value="Share Kitchen" <?= (in_array("Share Kitchen", $animites)) ? 'checked':'' ?> >
						<label for="check-3">Share Kitchen</label>

						<input id="check-4" type="checkbox" name="check" value="Closet"  <?= (in_array("Closet", $animites)) ? 'checked':'' ?> >
						<label for="check-4">Closet</label>

						<input id="check-5" type="checkbox" name="check" value="Night Stand" <?= (in_array("Night Stand", $animites)) ? 'checked':'' ?> >
						<label for="check-5">Night Stand</label>	

						<input id="check-6" type="checkbox" name="check" value="Dresser" <?= (in_array("Dresser", $animites)) ? 'checked':'' ?> >
						<label for="check-6">Dresser</label>

						<input id="check-7" type="checkbox" name="check" value="Wi-fi" <?= (in_array("Wi-fi", $animites)) ? 'checked':'' ?> >
						<label for="check-7">Wi-fi</label>

						<input id="check-8" type="checkbox" name="check" value="Cable" <?= (in_array("Cable", $animites)) ? 'checked':'' ?> >
						<label for="check-8">Cable</label>

						<input id="check-9" type="checkbox" name="check" value="TV" <?= (in_array("TV", $animites)) ? 'checked':'' ?> >
						<label for="check-9">TV</label>
						
						<input id="check-9" type="checkbox" name="check" value="Refrigerator" <?= (in_array("Refrigerator", $animites)) ? 'checked':'' ?> >
						<label for="check-9">Refrigerator</label>

						<input id="check-10" type="checkbox" name="check" value="AC" <?= (in_array("AC", $animites)) ? 'checked':'' ?> >
						<label for="check-10">AC</label>
					</div>
					<!-- Checkboxes / End -->
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->


		<!-- Section -->
		<h3>Contact Details</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<!-- Name -->
				<div class="col-md-4">
					<h5>Name</h5>
					<input type="text" id="contact_name" value="<?= get_post_meta($propertyID,'contact_name',true) ?>">
					<span id="contact_name-err"></span>
				</div>

				<!-- Email -->
				<div class="col-md-4">
					<h5>E-Mail</h5>
					<input type="text" id="contact_email" value="<?= get_post_meta($propertyID,'contact_email',true) ?>" >
					<span id="contact_email-err"></span>
				</div>

				<!-- Name -->
				<div class="col-md-4">
					<h5>Phone <span>(optional)</span></h5>
					<input type="text" id="contact_phone" value="<?= get_post_meta($propertyID,'contact_phone',true) ?>">
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->


		<div class="divider"></div>
		<input type="hidden" id="property_id" class="property_id" value="<?= $propertyID ?>">
		<input type="hidden" id="post_status" class="post_status" value="<?= $post_status ?>">
		<input type="hidden" id="post_author" class="post_author" value="<?= $post_author ?>">
		
		<button href="#" class="button preview-update margin-top-5">UPDATE PROPERTY <i class="fa fa-arrow-circle-right"></i></button>

		</div>
	</div>

</div>
</div>

<div class="margin-top-55"></div>

</div>
<?php
get_footer();
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/dropzone.js"></script>
<script type="text/javascript">
  Dropzone.autoDiscover = false;
  jQuery(".dropzone.dropzone_media").dropzone({
  dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
  addRemoveLinks: true,
  init: function() { 
			myDropzoneFiles = this; 		
			var property_id = $('.property_id').val(); 
			jQuery.ajax({
			  type: 'post',
			  dataType: 'json',
			  url: my_ajax_object.ajax_url,
			  data: {action:'nyc_get_existing_file_ajax',property_id:property_id},
			  success: function(response){
				  $.each(response, function(key,value) {
                          if(value.size != false){
						     var mockFile = { name: value.name, size: value.size };
							  myDropzoneFiles.emit("addedfile", mockFile);
							  myDropzoneFiles.emit("thumbnail", mockFile, value.path);
							  myDropzoneFiles.emit("complete", mockFile);
						  }
						 
				  }); 

			  }
			 });
			 
   },
   removedfile: function(file) {
     var file_name    = file.name;
     var property_id  = $('.property_id').val(); 
	 jQuery.ajax({
			  type: 'post',
			  url: my_ajax_object.ajax_url,
			  data: {action:'nyc_delete_existing_file_ajax',property_id:property_id,file_name:file_name},
			  success: function(response){
                     console.log(response);
			  }
	  });
	var _ref;
	return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0; 
	
   }
   
   
}); 



jQuery(".dropzone.dropzone_documents_update").dropzone({
  dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
  addRemoveLinks: true,
  init: function() { 
			myDropzonedoc = this; 		
			 var property_id = $('.property_id').val(); 
			jQuery.ajax({
			  type: 'post',
			  dataType: 'json',
			  url: my_ajax_object.ajax_url,
			  data: {action:'nyc_get_existing_file_doc_ajax',property_id:property_id},
			  success: function(response){
				  $.each(response, function(key,value) {
                          if(value.size != false){
						     var mockFile = { name: value.name, size: value.size };
							  myDropzonedoc.emit("addedfile", mockFile);
							  //myDropzonedoc.emit("thumbnail", mockFile, value.path);
							  myDropzonedoc.emit("complete", mockFile);
						  }
						 
				  }); 

			  }
			 });	 
   },
   removedfile: function(file) {
     var file_name    = file.name;
     var property_id  = $('.property_id').val(); 
	 jQuery.ajax({
			  type: 'post',
			  url: my_ajax_object.ajax_url,
			  data: {action:'nyc_delete_existing_file_doc_ajax',property_id:property_id,file_name:file_name},
			  success: function(response){
                     console.log(response);
			  }
	  });
	var _ref;
	return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0; 
	
   }
   
   
});
  

jQuery(document).ready(function($) {
   
jQuery(".preview-update").click(function(e){
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
		var property_id  = jQuery('#property_id').val();
		var post_status  = jQuery('#post_status').val();
		var post_author  = jQuery('#post_author').val();
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
			var file_data = $('.dropzone.dropzone_media')[0].dropzone.getAcceptedFiles();
			var drop_doc_data = $('.dropzone.dropzone_documents_update')[0].dropzone.getAcceptedFiles();
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
			form_data.append("property_id", property_id);
			form_data.append("post_status", post_status);
			form_data.append("post_author", post_author);
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
			form_data.append( "action" , 'nyc_update_property_ajax');	
			 jQuery.ajax({
				type : "post",
				url : my_ajax_object.ajax_url,
				data: form_data,
				processData: false,
				contentType: false,
				success: function(response) {
				     console.log(response);
				     if(response == "success"){
						window.location.href = window.location.href + "&&action=success";
					} else {
						window.location.href = window.location.href + "&&action=false";
					}
					
				}
			});	
		}
		jQuery(".preview-update").attr("disabled", false);
	});
	
});
 

</script>