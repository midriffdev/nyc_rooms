<?php 
/*
Template Name: Edit Property
*/
//nyc_property_owner_authority();
get_header();

?>
<!-- Wrapper -->
<div id="wrapper">
<!-- Content
================================================== -->
<div class="container">
<div class="row">
			
	<!-- Submit Page -->
	<div class="col-md-12">
		<div class="submit-page edit-property-page" id="prop_form_data">
        
				<?php
							        $post_id = $_GET['pid'];
							
									
									$address = get_post_meta($post_id, 'address',true)." ";
									$city= get_post_meta($post_id, 'city',true)." ";
									$state= get_post_meta($post_id, 'state',true).", ";
									$zip= get_post_meta($post_id, 'zip',true)." ";
									$price = get_post_meta($post_id, 'price',true);
									$status = get_post_meta($post_id, 'status',true);
									$agent = get_post_meta($post_id, 'agent',true);
									$amenities = get_post_meta($post_id, 'amenities',true);
									$contact_name = get_post_meta($post_id, 'contact_name',true);
									$contact_email = get_post_meta($post_id, 'contact_email',true);
									$contact_phone = get_post_meta($post_id, 'contact_phone',true);
									$gallery_files = get_post_meta($post_id, 'gallery_files',true);
									$accomodation = get_post_meta($post_id, 'accomodation',true); 
									$rooms = get_post_meta($post_id, 'rooms',true);
									$relationship = get_post_meta($post_id,'relationship',true);
									$couple_price = get_post_meta($post_id, 'couple_price',true);
									$hear = get_post_meta($post_id, 'hear',true);
									$gender = get_post_meta($post_id, 'gender',true);
									$rm_lang = get_post_meta($post_id, 'rm_lang',true);
									$payment_method = get_post_meta($post_id, 'payment_method',true);
									$gallery_files = explode(",",get_post_meta($post_id, 'gallery_files',true));
						
										
				?>
		<!-- Section -->
		<h3>Basic Information</h3>
		<div class="submit-section">
			<div class="form">
				<h5>Property Title <i class="tip" data-tip-content="Type title that will also contains an unique feature of your property (e.g. renovated, air contidioned)"></i></h5>
				<input class="search-field" id="prop_title" type="text" value="<?php echo get_the_title($post_id);?>"/>
				<span id="title-err"></span>
			</div>

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-6">
					<h5>Status</h5>
					<select class="chosen-select-no-single" id="prop_status"  value ="hello">
						<option value="<?php echo $status ;?>"><?php echo $status ;?></option>	
						<option value="available">Available</option>
						<option value="rented">Rented</option>
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
							echo '<option value="'.$type->term_id.'">'.$type->name.'</option>';
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
						<input type="text" id="prop_price" data-unit="USD" value ="<?php echo $price ;?>">
					</div>
					<span id="price-err"></span>
				</div>

				<div class="col-md-4">
					<h5>Type of Accomodation</h5>
					<select class="chosen-select-no-single" id="prop_accomodation">
						<option value="<?php echo $accomodation ;?>"><?php echo $accomodation ;?></option>		
						<option value="Apartment">Apartment</option>
						<option value="Room">Room</option>
					</select>
					<span id="accomodation-err"></span>
				</div>
				
				<div class="col-md-4">
					<h5>Rooms</h5>
					<select class="chosen-select-no-single" id="prop_rooms">
						<option label="<?php echo $rooms;?>"><?php echo $rooms;?></option>	
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="5+">More than 5</option>
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
						<option label="<?php echo $hear ;?>"><?php echo $hear ;?></option>	
						<option value="Google">Google</option>
						<option value="Business Card">Business Card</option>
						<option value="NYC Rooms for rent">NYC Rooms for rent</option>
						<option value="Flyer">Flyer</option>
						<option value="Supermarket">Supermarket</option>
						<option value="News paper">News paper</option>
						<option value="Facebook">Facebook</option>
						<option value="Agent found">Agent found</option>
						<option value="Other">Other</option>
					</select>
					<span id="hear-err"></span>
				</div>

				<div class="col-md-4">
					<h5>Gender preference</h5>
					<select class="chosen-select-no-single" id="prop_gender">
						<option label="<?php echo $gender ;?>"><?php echo $gender ;?></option>		
						<option value="Female">Female</option>
						<option value="Male">Male</option>
						<option value="Any">Any</option>
					</select>
					<span id="gender-err"></span>
				</div>

				<div class="col-md-4">
					<h5>Preferred Language of Roommate</h5>
					<select class="chosen-select-no-single" id="prop_rm_lang">
						<option label="<?php echo $rm_lang;?>"><?php echo $rm_lang;?></option>	
						<option value="English">English</option>
						<option value="Spanish">Spanish</option>
						<option value="Any">Any</option>
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
						<option label="<?php echo $relationship;?>"><?php echo $relationship;?></option>	
						<option value="Single">Single</option>
						<option value="Couple">Couple</option>
						<option value="Any">Any</option>
					</select>
					<span id="relationship-err"></span>					
				</div>

				<div class="col-md-4">
					<h5>Price for Couples</h5>
					<div class="select-input disabled-first-option">
						<input type="text" data-unit="USD" id="prop_couple_price" value= "<?php echo $couple_price;?>">
					</div>
					<span id="couple_price-err"></span>
				</div>

				<div class="col-md-4">
					<h5>Payment</h5>
					<select class="chosen-select-no-single" id="prop_payment_method">
						<option label="<?php echo $payment_method;?>"><?php echo $payment_method;?></option>	
						<option value="Weekly">Weekly</option>
						<option value="Bi-Weekly">Bi-Weekly</option>
						<option value="Monthly">Monthly</option>
					</select>
					<span id="payment_method-err"></span>
				</div>
			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->

		<!-- Section -->
		<h3>Gallery</h3>
		<div class="submit-section prop_gallery">
			<form action="http://localhost:81/nycrooms/edit-property/" class="dropzone" ></form>
			<?php
				foreach($gallery_files as $file){
				    $img_src=wp_get_attachment_url(get_post_meta($post_id, $file ,true ));
					echo '<div class="item"><img src="'.$img_src.'" alt=""></div>';
				}
			?>
		</div>
		<!-- Section / End -->


		<!-- Section -->
		<h3>Location</h3>
		<div class="submit-section">

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-6">
					<h5>Address</h5>
					<input type="text" id="prop_address" value ="<?php echo $address;?>">
					<span id="address-err"></span>
				</div>

				<div class="col-md-6">
					<h5>City</h5>
					<input type="text" id="prop_city" value="<?php echo $city;?>">
					<span id="city-err"></span>
				</div>

				<div class="col-md-6">
					<h5>State</h5>
					<input type="text" id="prop_state" value="<?php echo $state;?>">
					<span id="state-err"></span>
				</div>

				<div class="col-md-6">
					<h5>Zip-Code</h5>
					<input type="text" id="prop_zip" value="<?php echo $zip;?>">
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
				<textarea class="WYSIWYG" name="summary" cols="40" rows="3" id="prop_desc" spellcheck="true"></textarea>
				<span id="desc-err"></span>
			</div>

			<!-- Row -->
			<div class="row with-forms">

				<div class="col-md-6">
					<h5>Agent</h5>
					<select class="chosen-select-no-single" id="prop_agent">
						<option label="<?php echo $agent;?>"><?php echo $agent;?></option>	
					<?php 
						$args = array(
						 'role' => 'sales_agent',
						 'orderby' => 'user_nicename',
						 'order' => 'ASC'
						);
						 $agents = get_users($args);
						 foreach ($agents as $agent) {
						 echo '<option value="'.$agent->ID.'">'.$agent->display_name.'</option>';
						 }
					 ?>
					</select>
					<span id="agent-err"></span>
				</div>

				<div class="col-md-6">
					<!-- Checkboxes -->
					<h5>Amenities</h5>
					<div class="checkboxes in-row margin-bottom-20" id="prop_amenities">
				
						<input id="check-2" type="checkbox" name="check" value="Bed" <?php if($amenities==$_POST['value']){?> checked = "<?php echo $amenities;?>"<?php
						}?>  >
						<label for="check-2">Bed</label>

						<input id="check-3" type="checkbox" name="check" value="Share Kitchen" <?php if($amenities==$_POST['value']){?> checked = "<?php echo $amenities;?>"<?php
						}?>  >
						<label for="check-3">Share Kitchen</label>

						<input id="check-4" type="checkbox" name="check" value="Closet" checked="<?php echo $amenities;?>">
						<label for="check-4">Closet</label>

						<input id="check-5" type="checkbox" name="check" value="Night Stand" checked="<?php echo $amenities;?>">
						<label for="check-5">Night Stand</label>	

						<input id="check-6" type="checkbox" name="check" value="Dresser" checked="<?php echo $amenities;?>">
						<label for="check-6">Dresser</label>

						<input id="check-7" type="checkbox" name="check" value="Wi-fi" checked="<?php echo $amenities;?>">
						<label for="check-7">Wi-fi</label>

						<input id="check-8" type="checkbox" name="check" value="Cable" <?php if($amenities==$_POST['value']){?> checked = "<?php echo $amenities;?>"<?php
						}?>  >
						<label for="check-8">Cable</label>

						<input id="check-9" type="checkbox" name="check" value="TV" checked="<?php echo $amenities;?>">
						<label for="check-9">TV</label>
						
						<input id="check-9" type="checkbox" name="check" value="Refrigerator" checked="<?php echo $amenities;?>">
						<label for="check-9">Refrigerator</label>

						<input id="check-10" type="checkbox" name="check" value="AC" checked="<?php echo $amenities;?>">
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
					<input type="text" id="contact_name" value="<?php echo $contact_name;?>">
					<span id="contact_name-err"></span>
				</div>

				<!-- Email -->
				<div class="col-md-4">
					<h5>E-Mail</h5>
					<input type="text" id="contact_email" value="<?php echo $contact_email;?>">
					<span id="contact_email-err"></span>
				</div>

				<!-- contact -->
				<div class="col-md-4">
					<h5>Phone <span>(optional)</span></h5>
					<input type="text" id="contact_phone" value="<?php echo $contact_phone;?>">
				</div>

			</div>
			<!-- Row / End -->

		</div>
		<!-- Section / End -->


		<div class="divider"></div>
		<button href="#" class="button edit-property margin-top-5" data-id="<?php echo $post_id; ?>">EDIT PROPERTY <i class="fa fa-arrow-circle-right"></i></button>
								
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
<script>				
jQuery(".dropzone").dropzone({
	dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
});
</script>