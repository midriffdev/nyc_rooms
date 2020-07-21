<?php
/* 
 * Template Name: Single Property
 * Template Post Type: property
 */
$user = wp_get_current_user();
$success_msg = '';
 if(isset($_POST['guest_checkout'])){
	
		
		 $lead_id = wp_insert_post(array (
			'post_type'		=> 'leads',
			'post_title' 	=> 'Lead submission',
			'post_content' 	=> 'Lead submission by guest user',
			'post_author' 	=> 1,
			'post_status'   => 'publish'
		));
		
		
		 if ($lead_id) {
			add_post_meta($lead_id, 'lead_name', $_POST['guest_name']);
			add_post_meta($lead_id, 'lead_email', $_POST['guest_email']);
			add_post_meta($lead_id, 'lead_phone', $_POST['guest_phone']);
			add_post_meta($lead_id, 'lead_summary', $_POST['guest_summary']);
			add_post_meta($lead_id, 'lead_checkout_property', $_POST['Property_search_id']);
			add_post_meta($lead_id, 'lead_checkout_property_name', get_the_title($_POST['Property_search_id']));
			add_post_meta($lead_id, 'lead_checkt_prp_owner', get_post_meta($_POST['Property_search_id'],'contact_name',true));
			add_post_meta($lead_id, 'lead_source','Property Form');
			add_post_meta($lead_id, 'lead_chckt_prp_owner_email', get_post_meta($_POST['Property_search_id'],'contact_email',true));
			add_post_meta($lead_id, 'lead_created_from', 'logined_user' );
			add_post_meta($lead_id, 'lead_created_user_id', $_POST['logined_user_id']);
			$notification = "A new lead submission by ".$_POST['guest_name'];
			nyc_add_noticication($notification);				 
						
			/*----------- Email to Tenant After Lead Submission --------*/
			 
			$subject1 = "Lead Submission Enquiry Recieved On NYCROOMS";
			$to1 = $_POST['guest_email'];
			$msg1  = '<h4>Hello '.$_POST['guest_name'].',</h4>';
			$msg1 .= '<p>Thank you For Lead Submission on NYC Rooms. We Have Recevied Your Enquiry Request for lead submission On Property : <a href="'.get_post_permalink($_POST['Property_search_id']).'">'.get_the_title($_POST['Property_search_id']).'</a> One of our Represntative will be in touch with you as soon as possible.</p>';
			$msg1 .=  '<p>Thanks!<p>';
			$headers1 = array('Content-Type: text/html; charset=UTF-8');
			$mail1 = wp_mail($to1, $subject1, $msg1,$headers1);
							
			/*---------- Email to Admin After Lead Submission --------*/
			
			$subject = "New Lead Submission";
			$to = get_option('admin_email');
			$msg  = __( '<h4>Hello Admin,</h4>') . "\r\n\r\n";
			$msg .= '<p>A new lead Submission by guest user with following Details:</p>';
			$msg .= '<p>Name:'.$_POST['guest_name'] .'</p>';
			$msg .= '<p>Email:'.$_POST['guest_email'] .'</p>';
			$msg .= '<p>Phone:'.$_POST['guest_phone'] .'</p>';
			$msg .= '<p>Property link: <a href="'.site_url() .'/single-property/?property_id='.$_POST['Property_search_id'].'">'.site_url().'/single-property/?property_id='.$_POST['Property_search_id'].'</a></p>';
			$msg .= '<p>Requirements:</p><p>'.$_POST['guest_summary'] .'</p>';
			$msg .=  '<p>Thanks!<p>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
		    $mail = wp_mail($to, $subject, $msg,$headers);
			if($mail){		
			    $success_msg = "We have recieved your request for property. We will contact you soon";		   
			}			
		}	
}

get_header();
$post_id = get_the_ID();
$address = get_post_meta($post_id, 'address',true)." ";
$address .= get_post_meta($post_id, 'city',true)." ";
$address .= get_post_meta($post_id, 'state',true).", ";
$address .= get_post_meta($post_id, 'zip',true)." ";
$price = get_post_meta($post_id, 'price',true);
$payment_method = get_post_meta($post_id, 'payment_method',true);
$gallery_files = explode(",",get_post_meta($post_id, 'gallery_files',true));
?>
<!-- Wrapper -->
<div id="wrapper">
<?php if(is_user_logged_in()){
                       $userrole = wp_get_current_user();
					if($userrole->roles[0] == "administrator"){
			 ?>
		              <p style="color:#274abb"><a href="<?= site_url().'/admin/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To DashBoard</a></p>
					  
			       <?php
                    } else if($userrole->roles[0] == "property_owner"){
					?>
					  <p style="color:#274abb"><a href="<?= site_url().'/property-owner/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Profile</a></p>
					  
					<?php
					} 
			 
			 } else { ?>
			 
			   <p style="color:#274abb"><a href="<?= site_url().'/property-search/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a></p>
					  
			 <?php
			 }
			 ?>
<!-- Titlebar
================================================== -->
<div id="titlebar"  class="property-titlebar margin-bottom-0">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="property-title" style="margin:0;">
					<h2><?php echo get_the_title($post_id); ?><span class="property-badge">For Rent</span></h2>
					<span>
						<a href="#location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							<?php echo $address; ?>
						</a>
					</span>
				</div>
				<div class="property-pricing">
					<?php if( current_user_can('editor') || current_user_can('administrator') ) { ?><a href="<?php echo get_site_url(); ?>/edit-property-admin/?pid=<?php echo $post_id; ?>"><span class="property-badge">Edit Property</span></a><?php } ?>
					<div class="property-price">$<?php echo ($price) ? $price : 'N/A'; ?>/<?php echo  'Weekly'; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row margin-bottom-50">
		<div class="col-md-12">
		
			<!-- Slider -->
			<div class="property-slider default">
			<?php
				foreach($gallery_files as $file){
				    $img_src=wp_get_attachment_url(get_post_meta($post_id, $file ,true ));
					if($img_src){
					    if(img_exist($img_src)){
					       echo '<a href="'.$img_src.'" data-background-image="'.$img_src.'" class="item mfp-gallery"></a>';
						}
					}
				}
			?>
			</div>

			<!-- Slider Thumbs -->
			<div class="property-slider-nav">
			<?php
				foreach($gallery_files as $file){
				    $img_src=wp_get_attachment_url(get_post_meta($post_id, $file ,true ));
					if($img_src){
					   if(img_exist($img_src)){
					   echo '<div class="item"><img src="'.$img_src.'" alt=""></div>';
					   }
					}
				}
			?>
			</div>

		</div>
	</div>
</div>


<div class="container">
	<div class="row">

		<!-- Property Description -->
		<?php if(is_user_logged_in() && $user->roles[0] == "administrator" ){ ?>
		<div class="col-md-12 sp-content">
		<?php }else{ ?>
		<div class="col-lg-8 col-md-7 sp-content">
		<?php }?>
			<div class="property-description">

				<!-- Main Features -->
				<ul class="property-main-features">
					<li>Rooms <span><?php echo get_post_meta($post_id, 'rooms',true); ?></span></li>
				</ul>


				<!-- Description -->
				<h3 class="desc-headline">Description</h3>
				<div class="show-more">
					<?php echo get_the_content(null,false,$post_id); ?>
					<a href="#" class="show-more-button">Show More <i class="fa fa-angle-down"></i></a>
				</div>

				<!-- Details -->
				<h3 class="desc-headline">Details</h3>
				<ul class="property-features margin-top-0">
					<li>Type of Accomodation: <span><?php echo get_post_meta($post_id, 'accomodation',true); ?></span></li>
					<li>Rooms: <span><?php echo get_post_meta($post_id, 'rooms',true); ?></span></li>
					<li>Gender preference: <span><?php echo get_post_meta($post_id, 'gender',true); ?></span></li>
					<li>Preferred Language: <span><?php echo get_post_meta($post_id, 'rm_lang',true); ?></span></li>
					<li>Single / CouplesL: <span><?php echo get_post_meta($post_id, 'relationship',true); ?></span></li>
					<li>Payment: <span><?php echo ($payment_method) ? $payment_method : 'N/A'; ?></span></li>
					<li>Type: <span><?php
						$types = get_the_terms( $post_id, 'types' );     
						foreach ( $types as $type){
						   echo $type->name;
						}					
					?></span></li>
				</ul>


				<!-- Features -->
				<h3 class="desc-headline">Features</h3>
				<ul class="property-features checkboxes margin-top-0">
				<?php 
					$features = explode(",",get_post_meta($post_id,'amenities',true));
					foreach($features as $feature){
						echo "<li>".$feature."</li>";
					}
				?>			
				</ul>
	
				<!-- Location -->
				<?php
						 $propertyaddress = get_post_meta($post_id,'address',true);
						 $region = get_post_meta($post_id,'state',true);
						 $longlat = get_lat_long($propertyaddress,$region);
						 $longitude  =   $longlat['longitude'];
						 $latitude   =   $longlat['latitude'];
			    ?>
				<h3 class="desc-headline no-border" id="location">Location</h3>
				<div id="propertyMap-container">
					<div id="propertyMap" data-latitude="<?= $latitude ?>" data-longitude="<?= $longitude; ?>"></div>
					<a href="#" id="streetView">Street View</a>
				</div>
                 
				<div class="checkoutproperty">
				<?php
				$user = wp_get_current_user();
				$user_name  =  get_user_meta($user->ID ,'user_full_name',true);
				$user_phone =  get_user_meta($user->ID ,'user_phone',true);
				$user_email =  $user->user_email;

				
				if(!is_user_logged_in()){
                ?>
				  <a href="<?= site_url() ?>/tenant-registration/?request=guest_checkout&&property_id=<?= $post_id ?>" class="button checkout_property">Guest Checkout</a>
				 
				<?php
                } else {
				  if($user->roles[0] == "tenant"){
                ?>
				<button type="button" class="btn btn-info btn-lg button checkout_property popup" data-toggle="modal" data-target="#myModal">Request Info</button>

				  <!-- Modal -->
				<div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Request Info</h4>
					  </div>
					  <div class="modal-body">
						<form method="post" class="guest--checkout">
					        <p class="form-row form-row-wide guest-check-descp-sec">
							    
								<label for="password2">Descprition:
									<input type="hidden" name="guest_name" value="<?=  $user_name ?>" />
								    <input type="hidden" name="guest_email" value="<?= $user_email ?>" />
									<input type="hidden" name="guest_phone" value="<?= $user_phone ?>">
									<input type="hidden" name="logined_user_id" value="<?= $user->ID ?>">
									<i class="im im-icon-Lock-2"></i>
									<textarea class="WYSIWYG" name="guest_summary" id="summary" spellcheck="true" required></textarea>
								</label>
							</p>
							<p class="form-row">
							    <input type="hidden" value="<?= $post_id ?>" name="Property_search_id">
								
								<input type="submit" class="button border fw margin-top-10" name="guest_checkout" value="Submit" />
							</p>
						</form>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>

				  </div>
				</div>
				<?php
				 }
				}
				?> 
				</div>

				<!-- Similar Listings Container -->
				<h3 class="desc-headline no-border margin-bottom-35 margin-top-60">Similar Properties</h3>

				<!-- Layout Switcher -->

				<div class="layout-switcher hidden"><a href="#" class="list"><i class="fa fa-th-list"></i></a></div>
				<div class="listings-container list-layout">
				<?php
				$similar_property = get_posts( array(
					 'posts_per_page' => 3,
					 'orderby'        => 'rand',
					 'post_type'      => 'property',
					 'post_status'    => 'available',
					 'exclude'        => $post_id,
				) );	
				if($similar_property ){
				foreach($similar_property as $property){
				$sim_id=$property->ID;
				$address = get_post_meta($sim_id, 'city',true)." ";
				$address .= get_post_meta($sim_id, 'state',true).", ";
				$address .= get_post_meta($sim_id, 'zip',true)." ";
				$price = get_post_meta($sim_id, 'price',true);
				$payment_method = get_post_meta($sim_id, 'payment_method',true);
				$prop_image = wp_get_attachment_url(get_post_meta($sim_id, 'file_0',true));
				?>
					<!-- Listing Item -->
					<div class="listing-item">

						<a href="#" class="listing-img-container">

							<div class="listing-badges">
								<span>For Rent</span>
							</div>

							<div class="listing-img-content">
								<span class="listing-price">$<?php echo ($price) ? $price : 'N/A'; ?><i><?php echo ($payment_method) ? $payment_method : 'N/A'; ?></i></span>
								<span data-id="<?php echo $sim_id; ?>" class="like-icon nyc_bookmark <?php echo nyc_check_is_bookmark($sim_id); ?>"></span>
							</div>

							<img src="<?php echo $prop_image; ?>" alt="">

						</a>
						
						<div class="listing-content">

							<div class="listing-title">
								<h4><a href="<?php echo get_post_permalink($sim_id); ?>"><?php echo $property->post_title; ?></a></h4>
								<a href="https://maps.google.com/maps?q=<?php echo $address; ?>&amp;hl=en&amp;t=v&amp;hnear=<?php echo $address; ?>" class="listing-address popup-gmaps">
									<i class="fa fa-map-marker"></i>
									<?php echo $address; ?>
								</a>

								<a href="<?php echo get_post_permalink($sim_id); ?>"  class="details button border">Details</a>
							</div>

							<ul class="listing-details">
								<li><?php echo get_post_meta($sim_id, 'rooms',true); ?> Rooms</li>
							</ul>

						</div>
						<!-- Listing Item / End -->

					</div>
					<!-- Listing Item / End -->
				<?php } 
				}else{
					echo "<p class='no+property_found'><span>No Similar Property Found !</span></p>";
				}?>

				</div>
				<!-- Similar Listings Container / End -->

			</div>
		</div>
		<!-- Property Description / End -->


		<!-- Sidebar -->
		<div class="col-lg-4 col-md-5 sp-sidebar">
			<div class="sidebar sticky right">

				<!-- Widget -->
				<?php if( !current_user_can('editor') && !current_user_can('administrator') ) { ?>
				<?php if( is_user_logged_in() ) { ?>
				<div class="widget margin-bottom-30">
					<button class="widget-button with-tip nyc_bookmark <?php echo nyc_check_is_bookmark($post_id); ?>" data-id="<?php echo $post_id; ?>" data-tip-content="Add to Bookmarks"><i class="fa fa-star-o"></i></button>
					<div class="clearfix"></div>
				</div>
				<?php } ?>
				<!-- Widget / End -->

                
				<!-- Booking Widget -->
				<div class="widget">
					<div id="booking-widget-anchor" class="boxed-widget booking-widget margin-top-35">
						<h3><i class="fa fa-calendar-check-o"></i> Schedule a Tour</h3>
						<div class="row with-forms  margin-top-0">

							<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
							<div class="col-lg-12">
								<input type="text" id="date-picker" placeholder="Date" readonly="readonly">
							</div>

							<!-- Panel Dropdown -->
							<div class="col-lg-12">
								<div class="panel-dropdown time-slots-dropdown">
									<a href="#">Time</a>
									<div class="panel-dropdown-content padding-reset">
										<div class="panel-dropdown-scrollable">
											
											<!-- Time Slot -->
											<div class="time-slot">
												<input type="radio" name="time-slot" id="time-slot-1">
												<label for="time-slot-1">
													<strong>8:30 am - 9:00 am</strong>
													<span>1 slot available</span>
												</label>
											</div>

											<!-- Time Slot -->
											<div class="time-slot">
												<input type="radio" name="time-slot" id="time-slot-2">
												<label for="time-slot-2">
													<strong>9:00 am - 9:30 am</strong>
													<span>2 slots available</span>
												</label>
											</div>

											<!-- Time Slot -->
											<div class="time-slot">
												<input type="radio" name="time-slot" id="time-slot-3">
												<label for="time-slot-3">
													<strong>9:30 am - 10:00 am</strong>
													<span>1 slots available</span>
												</label>
											</div>

											<!-- Time Slot -->
											<div class="time-slot">
												<input type="radio" name="time-slot" id="time-slot-4">
												<label for="time-slot-4">
													<strong>10:00 am - 10:30 am</strong>
													<span>3 slots available</span>
												</label>
											</div>

											<!-- Time Slot -->
											<div class="time-slot">
												<input type="radio" name="time-slot" id="time-slot-5">
												<label for="time-slot-5">
													<strong>13:00 pm - 13:30 pm</strong>
													<span>2 slots available</span>
												</label>
											</div>

											<!-- Time Slot -->
											<div class="time-slot">
												<input type="radio" name="time-slot" id="time-slot-6">
												<label for="time-slot-6">
													<strong>13:30 pm - 14:00 pm</strong>
													<span>1 slots available</span>
												</label>
											</div>

											<!-- Time Slot -->
											<div class="time-slot">
												<input type="radio" name="time-slot" id="time-slot-7">
												<label for="time-slot-7">
													<strong>14:00 pm - 14:30 pm</strong>
													<span>1 slots available</span>
												</label>
											</div>

										</div>
									</div>
								</div>
							</div>
							<!-- Panel Dropdown / End -->

						</div>
						
						<!-- Book Now -->
						<a href="#" class="button book-now fullwidth margin-top-5">Send Request</a>
					</div>

				</div>
				<?php } ?>
				<!-- Booking Widget / End -->

				<!-- Widget -->
				<!--div class="widget"-->
					<!--h3 class="margin-bottom-35">Featured Properties</h3>

					<div class="listing-carousel outer"-->
						<!-- Item -->
						<!--div class="item">
							<div class="listing-item compact">

								<a href="#" class="listing-img-container">

									<div class="listing-badges">
										<span class="featured">Featured</span>
										<span>For Sale</span>
									</div>

									<div class="listing-img-content">
										<span class="listing-compact-title">Eagle Apartments <i>$275,000</i></span>

										<ul class="listing-hidden-content">
											<li>Area <span>530 sq ft</span></li>
											<li>Rooms <span>3</span></li>
											<li>Beds <span>1</span></li>
											<li>Baths <span>1</span></li>
										</ul>
									</div>

									<img src="<?php //echo get_stylesheet_directory_uri(); ?>/images/listing-01.jpg" alt="">
								</a>

							</div>
						</div-->
						<!-- Item / End -->

						<!-- Item -->
						<!--div class="item">
							<div class="listing-item compact">

								<a href="#" class="listing-img-container">

									<div class="listing-badges">
										<span class="featured">Featured</span>
										<span>For Sale</span>
									</div>

									<div class="listing-img-content">
										<span class="listing-compact-title">Selway Apartments <i>$245,000</i></span>

										<ul class="listing-hidden-content">
											<li>Area <span>530 sq ft</span></li>
											<li>Rooms <span>3</span></li>
											<li>Beds <span>1</span></li>
											<li>Baths <span>1</span></li>
										</ul>
									</div>

									<img src="<?php //echo get_stylesheet_directory_uri(); ?>/images/listing-02.jpg" alt="">
								</a>

							</div>
						</div>
						<!-- Item / End -->

						<!-- Item -->
						<!--div class="item">
							<div class="listing-item compact">

								<a href="#" class="listing-img-container">

									<div class="listing-badges">
										<span class="featured">Featured</span>
										<span>For Sale</span>
									</div>

									<div class="listing-img-content">
										<span class="listing-compact-title">Oak Tree Villas <i>$325,000</i></span>

										<ul class="listing-hidden-content">
											<li>Area <span>530 sq ft</span></li>
											<li>Rooms <span>3</span></li>
											<li>Beds <span>1</span></li>
											<li>Baths <span>1</span></li>
										</ul>
									</div>

									<img src="<?php //echo get_stylesheet_directory_uri(); ?>/images/listing-03.jpg" alt="">
								</a>

							</div>
						</div>
						<!-- Item / End -->
					<!--/div>

				</div--->
				<!-- Widget / End -->

			</div>
		</div>
		<!-- Sidebar / End -->

	</div>
</div>

<div class="margin-top-55"></div>

</div>
<style>
a.checkout_property {
    margin-top: 6%;
}
</style>
<?php
if(!empty($success_msg)):
?>
<div id="myModal1" class="modal fade" role="dialog">
		 <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			  </div>
			  <div class="modal-body">
			    <?= $success_msg ?>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		    </div>
</div>
<?php
endif;
get_footer();
?>


<!-- Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkB8x8TIEGgMQIeZjIEJILbKOn_5uEP8I"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/infobox.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/markerclusterer.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/maps.js"></script>

<!-- Date Range Picker - docs: http://www.daterangepicker.com/ -->
<script type="text/javascript"  src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/moment.min.js"></script>
<script type="text/javascript"  src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/daterangepicker.js"></script>
<script>
// Calendar Init
jQuery(function() {
	jQuery('#date-picker').daterangepicker({
		"opens": "left",
		singleDatePicker: true,

		// Disabling Date Ranges
		isInvalidDate: function(date) {
		// Disabling Date Range
		var disabled_start = moment('09/02/2018', 'MM/DD/YYYY');
		var disabled_end = moment('09/06/2018', 'MM/DD/YYYY');
		return date.isAfter(disabled_start) && date.isBefore(disabled_end);

		// Disabling Single Day
		// if (date.format('MM/DD/YYYY') == '08/08/2018') {
		//     return true; 
		// }
		
		}
	});
});

// Calendar animation
jQuery('#date-picker').on('showCalendar.daterangepicker', function(ev, picker) {
	jQuery('.daterangepicker').addClass('calendar-animated');
});
jQuery('#date-picker').on('show.daterangepicker', function(ev, picker) {
	jQuery('.daterangepicker').addClass('calendar-visible');
	jQuery('.daterangepicker').removeClass('calendar-hidden');
});
jQuery('#date-picker').on('hide.daterangepicker', function(ev, picker) {
	jQuery('.daterangepicker').removeClass('calendar-visible');
	jQuery('.daterangepicker').addClass('calendar-hidden');
});
</script>


<!-- Replacing dropdown placeholder with selected time slot -->
<script>
jQuery(".time-slot").each(function() {
	var timeSlot = jQuery(this);
	jQuery(this).find('input').on('change',function() {
		var timeSlotVal = timeSlot.find('strong').text();

		jQuery('.panel-dropdown.time-slots-dropdown a').html(timeSlotVal);
		jQuery('.panel-dropdown').removeClass('active');
	});
});
jQuery('.nyc_bookmark').click(function (e) {
	var id=jQuery(this).attr('data-id');
	jQuery.ajax({
		type : "post",
		url : my_ajax_object.ajax_url,
		data: { action: 'nyc_add_to_favorite', property_id:id },
		success: function(response) {
			console.log(response);
		}
	});
});
</script>
<?php
if(!empty($success_msg)):
   echo "<script>
         jQuery(window).load(function(){
             $('#myModal1').modal('show');
         });
    </script>";
endif;
