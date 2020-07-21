<?php
use Dompdf\Dompdf;
$contract_id = base64_decode(get_query_var('id')); 
$post = get_post($contract_id);
$current_user = wp_get_current_user();
if(empty($post) || ($post->post_type != 'contracts') || (get_post_meta($post->ID,'tenant_email',true) != $current_user->user_email)){
	wp_redirect(get_site_url().'/tenants/all-contracts'); 
}
$post_id = get_post_meta($contract_id,'deal_id',true); 
nyc_tenant_check_authentication();
get_header();
$property_id = get_post_meta($post_id,'property_id',true);
$auth = get_post($property_id);
$authid = $auth->post_author;
$email = get_post_meta($post_id,'email',true);
$name = get_post_meta($post_id,'name',true);
$contract_created = get_post_meta($post_id,'deal_created',true);

$contract_data = '';
$contract_file_id = '';
$contract_id = get_post_meta($post_id,'contract_id',true);
if($contract_id){
	$contract_data = get_post_meta($contract_id,'contract_data', true); 
	$contract_file_id = get_post_meta($contract_id,'contract_pdf', true);
}

$lead_source = get_post_meta($post_id,'lead_source',true);
$phone = get_post_meta($post_id,'phone',true);
$description = get_post_meta($post_id,'description',true);
$tenant_application = get_post_meta($post_id,'application_doc',true);
$tenant_application_check = get_post_meta($post_id,'application_submission',true);
$deal_price = get_post_meta($post_id,'deal_price',true);
$admin_notes = get_post_meta($post_id,'admin_notes',true);
$selected_property = get_post_meta($post_id, 'selected_property', true);
$selectedAgent = get_post_meta($post_id, 'selectedAgent', true);
$request_an_agent = get_post_meta($post_id, 'request_an_agent', true);
$document_files = get_post_meta($post_id, 'document_files', true);
$query_args = array(
	'post_type'  => 'dealsorders',
	'meta_query' => array(
	    array(
			'key'   => 'deal_id',
			'value' => $post_id,
	    ),
	)
);
$check_deal_orders = new WP_Query( $query_args );
if(count($check_deal_orders->posts) == 1){
	$dealorderid        = $check_deal_orders->posts[0]->ID;
	$payment_status     = get_post_meta($dealorderid,'payment_status',true);
	$payment_amount     = get_post_meta($dealorderid,'payment_amount',true);
	$payment_created_at = get_post_meta($dealorderid,'payment_created_at',true);
	$payment_source_type = get_post_meta($dealorderid,'payment_source_type',true);
	$payment_mode = get_post_meta($dealorderid,'payment_mode',true);
	$strtotime          = strtotime($payment_created_at);
	$date =  date("F j, Y", $strtotime); 
	$time =  date("h:i A", $strtotime); 
	
} else {
   $payment_status = get_post_meta($post_id,'payment_status',true);
}

?>
<style>
.agent-space {
    width: 78%;
}
.top-right-heading.date-space {
    width: 80%;
}
.agent-sign-space {
    width: 73%;
}
.date-last-space {
    width: 90%;
}
.customer-space {
    width: 75%;
}
.customer-sign-space {
    width: 70%;
}
.address-space {
    width: 75%;
}
.set-space {
    margin-top: 20px;
}
.set-space textarea {
    margin-bottom: 50px;
}
.image_wrapper {
    display: flex;
    justify-content: space-between;
}
.logo_pannel img {
	width:100%;
}
.top_heading h3 {
    margin: 0;
}
.header_top_content_pannel {
    border: 1px solid #000;
    padding: 20px;
    margin-top: 20px;
}
.header_top_content {
    display: flex;
    justify-content: space-between;
}
.header_top_content .top-right-heading {
    display: inline-block;
}
.form-input {
    width: 100% !important;
    border: none !important;
    background-color: #fff !important;
    border-bottom: 1px solid #000 !important;
    border-radius: unset !important;
    margin-bottom: 0 !important;
    color: #333;
    height: 20px !important;
    font-size: 15px;
    padding: 0 2px !important;
}
.top-right-heading span {
    font-size: 17px;
}
.agreement-pannel {
    clear: both;
    margin-top: 20px;
}
.agreement-pannel .agreement-pannel-content {
    float: left;
}
.agreement-pannel .agreement-pannel-content.first {
    width:15%;
    margin-bottom:10px;
}
.agreement-pannel .agreement-pannel-content.second {
    width:85%;
}
.agreement-pannel-content span {
    font-size: 16px;
}
.form-content {
    clear: both;
    padding-top: 20px;
}
p.sub-heading {
    font-size: 16px;
    font-weight: 600;
}
sub-heading2{
    font-size: 14px;
}
.form-content-pannel {
    display: flex;
    justify-content: space-between;
}

.form-content-inner-pannel {
    width: 100%;
}

.form-content-inner-pannel:first-child {
    padding-right: 15px;
}
.form-content-inner-pannel:last-child {
    padding-left: 15px;
}
.form-content-inner-pannel.form-pannel-1 .pannel2 {
    width: 75%;
}
.form-content-pannel select {
    border: unset !important;
    background-color: #fff !important;
    border-bottom: 1px solid #000 !important;
    border-radius: unset !important;
    padding: 0 20px !important;
    height: 20px !important;
}
.form-content-pannel .radio-inline span {
    width: 60px;
}
.form-content-pannel .radio-inline {
    display: flex;
    padding-left: 0;
    margin-left: 30px;
}
.form-content-pannel .radio-inline span input {
    width: 15px !important;
    height: 15px !important;
}
.agreement-pannel-content.second-1 {
    width: 85%;
}
.chk-inline span {
    width: unset !important;
    font-size: 14px !important;
    padding-right: 10px;
}
.form-content textarea {
    background-color: #fff !important;
}
.create_contract {
    margin: 25px;
    text-align: center;
}

input:required:focus {
  border: 1px solid red;
  outline: none;
}

textarea:required:focus {
 border: 1px solid red;
 outline: none;
}
</style>
<!-- Wrapper -->
<div id="wrapper">

<!-- Content
================================================== -->
<div class="contract-detail-container">		
	<div class="container">

		<div class="row contractdetail--stageinnersection">
			<div class="col-md-12">
				<div class="contract-property_detail">
					<?php 
					if($property_id){ 
					$auth = get_post($property_id);
					$authid = $auth->post_author;
					$address = get_post_meta($property_id, 'address',true)." ";
					$address .= get_post_meta($property_id, 'city',true)." ";
					$address .= get_post_meta($property_id, 'state',true).", ";
					$address .= get_post_meta($property_id, 'zip',true)." ";	
					$price = get_post_meta($property_id, 'price',true);				
					$status = get_post_meta($property_id, 'status',true);	
					$images = get_post_meta($property_id, 'images',true);	
					$gallery_files_meta = get_post_meta($property_id,'gallery_files',true);
					$gallery_files = explode(',',$gallery_files_meta);
					?>
					<h2>Property Details</h2>
					<div class="listings-container list-layout">
					<!-- Listing Item -->
						<div class="listing-item">
							<a href="<?php echo get_post_permalink($property_id); ?>" class="listing-img-container">
								<div class="listing-img-content">
									<span class="listing-price">$<?php echo $price; ?> / Weekly</span>
								</div>
								<div class="listing-carousel">
								    <?php
									foreach($gallery_files as $key => $metakeyattach){
								    ?>
									<div><img src="<?php echo wp_get_attachment_url(get_post_meta($property_id,$metakeyattach,true)); ?>" alt=""></div>
									<?php
									} 
									?>
								</div>
							</a>
							<div class="listing-content">
								<div class="listing-title">
									<h4><a href="<?php echo get_post_permalink($property_id); ?>"><?php echo get_the_title($property_id); ?></a></h4>
									<a href="https://maps.google.com/maps?q=<?php echo $address; ?>" class="listing-address popup-gmaps">
										<i class="fa fa-map-marker"></i>
										<?php echo $address; ?>
									</a>
									<a href="<?php echo get_post_permalink($property_id); ?>" target="_blank" class="details button border">Details</a>
								</div>
								<ul class="listing-details">
									<li>Rooms <?php echo get_post_meta($property_id,'rooms',true); ?></li>
								</ul>
								<div class="listing-footer">
									<a><i class="fa fa-user"></i> <?php echo get_the_author_meta( 'display_name' , $authid); ?></a>
								</div>
							</div>
						</div>
					<!-- Listing Item / End -->
					</div>
					<?php } ?>
				</div>
			</div>
			<?php  if($lead_source == "Property Form"){ ?>
			<div class="col-md-6">
				<div class="leaddetail-teanentdetail dealdetail__tenantdetail contract-tenantdetail">
				<h2>Tenant Details</h2>
				<div class="lead-teanent_details">
					<ul>
						<li>
							<p>Name: </p>
							<span><?php echo $name; ?></span>
						</li>
						<li>
							<p>Email:</p>
							<span><?php echo $email; ?></span>
						</li>
						<li>
							<p>Phone:</p>
							<span><?php echo $phone; ?></span>
						</li>
						<li>
							<p>Description:</p>
							<span><?php echo $description; ?></span>
						</li>
					</ul>
				</div>
				</div>
			</div>
			<?php } ?>
		<?php if($lead_source == "Appointment Form" || $lead_source == "Custom Deal"){ ?>		
			<div class="col-md-6">
				<div class="dealdetal__appointmentdetail-sec">
					<div class="leaddetail-teanentdetail dealdetail__tenantdetail">
						<h2>Appointment Details</h2>
						<div class="lead-teanent_details">
							<ul>
								<li>
									<p>Name: </p>
									<span><?php echo $name; ?></span>
								</li>
								<li>
									<p>Email:</p>
									<span><?php echo $email; ?></span>
								</li>
								<li>
									<p>Phone:</p>
									<span><?php echo $phone; ?></span>
								</li>
								<li>
									<p>Date:</p>
									<span><?php echo get_the_date('l F j, Y',$post_id); ?></span>
								</li>
								<li>
									<p>Description:</p>
									<span><?php echo $description; ?></span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>			
			<div class="col-md-6">
				<div class="contract-owner-detail">
					<h2>Property Owner Detail</h2>
					<?php 
					$property_owner = get_userdata($authid);
					$owner_id = $property_owner->data->ID;
					?>
					<div class="contract-ownerdetail-cont">
						<ul>
						<li>
							<p>Name: </p>
							<span><?php echo $property_owner->data->display_name; ?></span>
						</li>
						<li>
							<p>Email:</p>
							<span><?php echo $property_owner->data->user_email; ?></span>
						</li>
						<li>
							<p>Phone:</p>
							<span><?php echo get_user_meta($owner_id,'user_phone',true); ?></span>
						</li>
					</ul>
					</div>
				</div>
			</div>

			<?php if($selectedAgent){ ?>
			<div class="col-md-6">
				<div class="dealdetail-allocateagent-section">
					<h2>Agent Details</h2>
					<ul>
						<li>
							<p>Name: </p>
							<span><?php the_author_meta( 'display_name' , $selectedAgent ); ?></span>
						</li>
						<li>
							<p>Email:</p>
							<span><?php the_author_meta( 'user_email' , $selectedAgent ); ?></span>
						</li>
						<li>
							<p>Phone:</p>
							<span><?php the_author_meta( 'user_phone' , $selectedAgent ); ?></span>
						</li>

					</ul>
				</div>
			</div>
			<div class="dealdetail--agentnotes-sec col-md-6">
				<h2>Agent Notes:</h2>
				<p><?php echo get_post_meta($post_id,'agent_notes',true);  ?></p>
			</div>
			<?php } ?>


			<div class="col-md-6">
				<div class="contract-admin-notes">
					<h2>Admin Notes</h2>
					<p><?php echo $admin_notes; ?></p>
				</div>
			</div>

			<div class="col-md-6">
				<div class="dealdetail-signapplicationform">
						<h3>Application Form Status <br><?= ($tenant_application_check == 1) ? ' <a class="deal-send-button deal-send-text dealdetail_view" href="'.wp_get_attachment_url($tenant_application).'" target="_blank">Complete &nbsp;<i class="fa fa-eye" aria-hidden="true"></i></a>' : 'Pending'; ?> </h3>
				</div>
			</div>

			<div class="col-md-6">
				<div class="deal-detail-paymentstatus">
						<h3>Payment Status
						<span><?php echo ($payment_status) ? $payment_status : 'Pending'; ?> <i class="fa fa-check" aria-hidden="true"></i></span></h3>
						<?php if($payment_status){ ?>
						<ul>
							<li>Payment: <span><?= '$'.$payment_amount ?></span></li>
							<li>Payment Source : <span><?= ucfirst($payment_source_type) ?></span></li>
							<li>Payment mode : <span><?= ucfirst(str_replace('_',' ',$payment_mode)) ?></span></li>
							
							<li>Date: <span><?= $date ?></span></li>
							<li>Time: <span><?= $time ?></span></li>
						</ul>
						<?php } ?>
				</div>
			</div>
			
			<?php if(!empty($contract_file_id)){ ?>
			<div class="col-md-6">
				<div class="deal-detail-paymentstatus">
						<h3>Contract Created <span> <a href="<?php echo wp_get_attachment_url($contract_file_id); ?>" download><i class="fa fa-download" aria-hidden="true"></i></a> <a href="<?php echo wp_get_attachment_url($contract_file_id); ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></span></h3>
				</div>
			</div>
			<?php } ?>
			
		</div>
        <form action="" id="contract_form" method="post">
		<div class="row contract-detail-formsection">
						<div class="image_wrapper">
							<div class="logo_pannel">
								<?php echo get_custom_logo(); ?>
							</div>
							<div class="top_heading">
								<h3>Apartment Sharing Contract</h3>
								<div class="header_top_content_pannel">
									<div class="header_top_content">
										<div class="top-right-heading"><span>Contact #</span></div>
										<div class="top-right-heading"><input type="text" class="form-input" id="contact_no" value="<?php if(!empty($contract_data)) { echo $contract_data['contact_no']; }  ?>" name="contact_no" required></div>
									</div>
									<div class="header_top_content">
										<div class="top-right-heading"><span>File No.</span></div>
										<div class="top-right-heading"><input type="text" class="form-input" id="contact_file_no" name="contact_file_no" value="<?php if(!empty($contract_data)) { echo $contract_data['contact_file_no']; }  ?>" required></div>
									</div>
									<div class="header_top_content">
										<div class="top-right-heading"><span>Date</span></div>
										<div class="top-right-heading date-space"><input type="date" class="form-input" id="contact_date" name="contact_date" value="<?php if(!empty($contract_data)) { echo $contract_data['contact_date']; }  ?>" required></div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-main">
							<div class="agreement-pannel">
							<div class="agreement-pannel-content first">
								<span>Agreement between:</span>
							</div>
							<div class="agreement-pannel-content second">
								<span><input type="text" class="form-input" name="agreement_between" value="<?php if(!empty($contract_data)) { echo $contract_data['agreement_between']; }  ?>" required></span></div>
							</div>
							<div class="agreement-pannel">
							<div class="agreement-pannel-content first">
								<span>And (customer):</span>
							</div>
							<div class="agreement-pannel-content second">
								<span><input type="text" class="form-input" name="and_customer" value="<?php if(!empty($contract_data)) { echo $contract_data['and_customer']; }  ?>" required></span></div>
							</div>
						</div>
						<div class="form-content">
							<p class="sub-heading">(1)Customer seeks information regarding shared living accomodations with the following:</p>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Date Available:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
										<span><input type="date" class="form-input" name="customer_date_available" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_date_available']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Monthly/ Weekly rental Range $:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="text" class="form-input" name="customer_rental_range" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_rental_range']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Geographical Location:</span>
										</div>
										<div class="agreement-pannel-content pannel2 location-space">
										<span><input type="text" class="form-input" name="customer_geo_location" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_geo_location']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Type of Accomodation:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><select name="accomodation"><option <?php if(!empty($contract_data)) { if($contract_data['accomodation'] == "Appartment" ){ echo "selected"; } } ?> value="Appartment">Appartment</option><option  <?php if(!empty($contract_data)) { if($contract_data['accomodation'] == "Room" ){ echo "selected"; } } ?> value="Room">Room</option></select></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Elevator Service required:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
											<div class="radio-inline">
										<span><input type="radio" class="form-input" value="Yes" name="customer_elevator" <?php if(!empty($contract_data)) { if($contract_data['customer_elevator'] == "Yes" ){ echo "checked"; } } ?> required>Yes</span>
										<span><input type="radio" class="form-input" value="No" name="customer_elevator"  <?php if(!empty($contract_data)) { if($contract_data['customer_elevator'] == "No" ){ echo "checked"; } } ?> required>No</span></div>
									</div>
									</div>
								</div>
						</div>
						<div class="form-main">
							<div class="agreement-pannel">
							<div class="agreement-pannel-content first-1">
								<span>Other Requirements:</span>
							</div>
							<div class="agreement-pannel-content second-1">
								<span><input type="text" class="form-input" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_other_requirement']; }  ?>" name="customer_other_requirement" required></span></div>
							</div>
						</div>
						<div class="form-content form-content2">
							<p class="sub-heading">
(2) Vender represent that the following listings meet customers specification as set forth in Paragraph(1):</p>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Address:</span>
										</div>
										<div class="agreement-pannel-content pannel2 address-space">
										<span><input type="text" class="form-input" name="vender_address" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_address']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Name of Owner or Primary Tenant:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="text" class="form-input" name="vender_name_of_owner" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_name_of_owner']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Geographical Location:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
										<span><input type="text" class="form-input" name="vender_geo_location" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_geo_location']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Phone # of Owner:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="text" class="form-input" name="vender_phone_owner" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_phone_owner']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Utility required:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
											<div class="radio-inline">
										<span><input type="radio" class="form-input" name="vender_utility" value="Yes" <?php if(!empty($contract_data)) { if($contract_data['vender_utility'] == "Yes" ){ echo "checked"; } } ?> required>Yes</span>
										<span><input type="radio" class="form-input" name="vender_utility" value="No" <?php if(!empty($contract_data)) { if($contract_data['vender_utility'] == "No" ){ echo "checked"; } } ?> required>No</span></div>
									</div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Floor Location:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="text" class="form-input" name="vender_floor_location" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_floor_location']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Elevator Service required:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
											<div class="radio-inline">
										<span><input type="radio" class="form-input" name="vender_elevator" value="Yes" <?php if(!empty($contract_data)) { if($contract_data['vender_elevator'] == "Yes" ){ echo "checked"; } } ?> required>Yes</span>
										<span><input type="radio" class="form-input" name="vender_elevator" value="No" <?php if(!empty($contract_data)) { if($contract_data['vender_elevator'] == "No" ){ echo "checked"; } } ?> required>No</span></div>
									</div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Date:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="date" class="form-input" name="vender_date" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_date']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
						</div>
						<div class="form-content form-content2">
							<div class="form-content-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<p class="sub-heading">(3)Non-Refundable Fee Paid:$</p>
										</div>
										<div class="agreement-pannel-content pannel2">
										<span><input type="text" class="form-input" name="non_refundable_free_paid" value="<?php if(!empty($contract_data)) { echo $contract_data['non_refundable_free_paid']; }  ?>" required></span></div>
									</div>
								</div>
						</div>
						<div class="form-content form-content2">
							<p class="sub-heading">(4)Contract Terms:</p>
						
							
							<div class="form-content-pannel">

								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Contract start Date:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="date" class="form-input" name="contact_start_date" value="<?php if(!empty($contract_data)) { echo $contract_data['contact_start_date']; }  ?>" required></span></div>
							</div>
								</div>
								<div class="form-content-inner-pannel">

									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Approximate Duration:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
											<div class="radio-inline chk-inline">
										<span><input type="radio" class="form-input" name="approximate_duration" value="1 Month" <?php if(!empty($contract_data)) { if($contract_data['approximate_duration'] == "1 Month" ){ echo "checked"; } } ?> required>1 Month</span>
										<span><input type="radio" class="form-input" name="approximate_duration" value="2 Months" <?php if(!empty($contract_data)) { if($contract_data['approximate_duration'] == "2 Months" ){ echo "checked"; } } ?> required>2 Months</span>
										<span><input type="radio" class="form-input" name="approximate_duration" value="3 Months" <?php if(!empty($contract_data)) { if($contract_data['approximate_duration'] == "3 Months" ){ echo "checked"; } } ?> required>3 Months</span>
										<span><input type="radio" class="form-input" name="approximate_duration" value="1 Year" <?php if(!empty($contract_data)) { if($contract_data['approximate_duration'] == "1 Year" ){ echo "checked"; } } ?> required>1 Year</span></div>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-content form-content2">
							<p class="sub-heading">(5) The Vendor Agrees To Be Personally Responsible And Liable For Carrying Out The Terms Of This Agreement.</p>
						
						</div>
						<div class="form-content form-content2">
							<p class="sub-heading">(6) Any Complaints About This Apartment Sharing, AGENT SHOULD BE MADE TO:</p>
							<p class="sub-heading2">New York State, Department of state office of the New York State, 123 William Street 19th FL Department of State New York, NY 10038 .<br><b>Telephone:</b> (212) - 417-5747</p>
						
						</div>
						<div class="form-content">
							<p class="sub-heading">
(7) This Document Has Been Filled Out And Signed By:</p>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Agent Name:</span>
										</div>
										<div class="agreement-pannel-content pannel2 agent-space">
										<span><input type="text" class="form-input" name="agent_name" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_name']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Customer Name:</span>
							</div>
							<div class="agreement-pannel-content pannel2 customer-space">
								<span><input type="text" class="form-input" name="customer_name" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_name']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>
Agent Signature:</span>
										</div>
										<div class="agreement-pannel-content pannel2 agent-sign-space">
										<span><input type="text" class="form-input" name="agent_signature" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_signature']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Customer Signature:</span>
							</div>
							<div class="agreement-pannel-content pannel2 customer-sign-space">
								<input type="text" class="form-input" name="customer_signature" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_signature']; }  ?>" required></span></div></div>
							</div>
								</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>
Date:</span>
										</div>
										<div class="agreement-pannel-content pannel2 date-last-space">
										<span><input type="date" class="form-input" name="agent_date" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_date']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Date:</span>
							</div>
							<div class="agreement-pannel-content pannel2 date-last-space">
								<input type="date" class="form-input" name="customer_date" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_date']; }  ?>" required></span></div></div>
							</div>
								</div>
							</div>
								<div class="form-content set-space">
							<p class="sub-heading text-center">Additional Notes</p>
							<textarea cols="20" rows="10" name="additional_notes"><?php if(!empty($contract_data)) { echo $contract_data['additional_notes']; }  ?></textarea>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Agent Name:</span>
										</div>
										<div class="agreement-pannel-content pannel2 agent-space">
										<span><input type="text" class="form-input" name="agent_name_two" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_name_two']; }  ?>"></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Customer Name:</span>
							</div>
							<div class="agreement-pannel-content pannel2 customer-space">
								<span><input type="text" class="form-input" name="customer_name_two" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_name_two']; }  ?>"></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>
Agent Signature:</span>
										</div>
										<div class="agreement-pannel-content pannel2 agent-sign-space">
										<span><input type="text" class="form-input" name="agent_signature_two" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_signature_two']; }  ?>"></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Customer Signature:</span>
							</div>
							<div class="agreement-pannel-content pannel2 customer-sign-space">
								<input type="text" class="form-input" name="customer_signature_two" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_signature_two']; }  ?>"></div></div>
							</div>
								</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>
Date:</span>
										</div>
										<div class="agreement-pannel-content pannel2 date-last-space">
										<span><input type="date" class="form-input" name="agent_date_two" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_date_two']; }  ?>"></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Date:</span>
							</div>
							<div class="agreement-pannel-content pannel2 date-last-space">
								<input type="date" class="form-input" name="customer_date_two" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_date_two']; }  ?>"></div></div>
							</div>
								</div>
							</div>
						</div>		
    </form>
</div>
</div>
<div class="margin-top-55"></div>
</div>

<!--Modal for Contract Create -->
<div class="modal fade popup-main--section" id="create_contract_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="contract-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/dropzone.js"></script>
<script>
	jQuery(".dropzone").dropzone({
		dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
	});
</script>
<script type="text/javascript">
function lockForm(objForm) {
  var elArr = objForm.elements;
  for(var i=0; i<elArr.length; i++) { 
    switch (elArr[i].type) {
      case 'radio': elArr[i].disabled = true; break;
      case 'checkbox': elArr[i].disabled = true; break;
      case 'select-one': elArr[i].disabled = true; break;
      case 'select-multiple': elArr[i].disabled = true; break;
      case 'text': elArr[i].readOnly = true; break;
      case 'textarea': elArr[i].readOnly = true; break;
      case 'button': elArr[i].disabled = true; break;
      case 'submit': elArr[i].disabled = true; break;
      case 'reset': elArr[i].disabled = true; break;
      default: elArr[i].disabled = true; break;
    }
  }
}
jQuery(document).ready(function($) {
	<?php 
		if(!empty($contract_file_id)){
			?>
			lockForm(contract_form);
			<?php 
		}
	?>
});
</script>
<?php
get_footer();
?>
