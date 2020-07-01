<?php
require_once get_stylesheet_directory().'/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
if(isset($_GET['create_contract'])){
	$invoice_html = '<!DOCTYPE html>
	<html lang="en">
	  <head>
		<meta charset="utf-8">
		<title>PDF</title>
	  </head>
	<body>

	</body>
	</html>';
	$options = new Options();
	$options->set('isRemoteEnabled', TRUE);	
	$file_name = uniqid().'.pdf';		
	$pdf  = new Dompdf($options);
	$pdf->load_html($invoice_html);
	$pdf->set_paper('A4', 'landscape');
	$pdf->render();
	ob_end_clean();
	$pdf->stream($file_name);
	$pdf->output();	
}
nyc_property_admin_authority();
$post_id = get_query_var( 'id' ); 
$post = get_post($post_id);
if(empty($post) || ($post->post_type != 'deals')){
	wp_redirect(get_site_url().'/admin/deals'); 
}
get_header();

$lead_source = get_post_meta($post_id,'lead_source',true);
$name = get_post_meta($post_id,'name',true);
$email = get_post_meta($post_id,'email',true);
$phone = get_post_meta($post_id,'phone',true);
$description = get_post_meta($post_id,'description',true);
$property_id = get_post_meta($post_id,'property_id',true);
$auth = get_post($property_id);
$authid = $auth->post_author;
$tenant_application = get_post_meta($post_id,'document_files',true);
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
									<a href="<?php echo get_post_permalink($property_id); ?>" class="details button border">Details</a>
								</div>
								<ul class="listing-details">
									<li>Rooms <?php echo get_post_meta($property_id,'rooms',true); ?></li>
								</ul>
								<div class="listing-footer">
									<a href="#"><i class="fa fa-user"></i> <?php echo get_the_author_meta( 'display_name' , $authid); ?></a>
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
				<p><?php echo get_post_meta($post_id,'deal_agent_notes',true);  ?></p>
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
						<a href="#" data-toggle="modal" data-target="<?php ($tenant_application) ? 'Complete' : 'Pending'; ?>"><h3>Application Form Status <span> <?php echo ($tenant_application) ? 'Complete' : 'Pending'; ?> <i class="fa fa-check" aria-hidden="true"></i></span></h3></a>
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

		</div>


		<div class="row contract-detail-formsection">
			<div class="col-md-12">
				<h3>Form Details</h3>
				
					<div class="contract-form-row">
						<div class="row">
						<div class="col-md-6 ">
							<div class="contract-from-tno">
							<h3>Tenant Details</h3>
							<ul>
								<li>
									<h5>Name*</h5>
									<input class="search-field" type="text" value=""/>
								</li>
								<li>
									<h5>Phone</h5>
									<input type="text">
								</li>
								<li>
									<h5>E-Mail</h5>
									<input type="text">
								</li>
							</ul>
							</div>
						</div>

						<div class="col-md-6 ">
							<div class="contract-from-tno">
							<h3>Property Owner Details</h3>
							<ul>
								<li>
									<h5>Name*</h5>
									<input class="search-field" type="text" value=""/>
								</li>
								<li>
									<h5>Phone</h5>
									<input type="text">
								</li>
								<li>
									<h5>E-Mail</h5>
									<input type="text">
								</li>
							</ul>
							</div>
						</div>
						</div>
					</div>

					<div class="contract-form-row">
						<div class="row">
						<div class="col-md-6">
							<h3> Contract Start Date</h3>
        					<input type="date" name="date" value="" required="">
						</div>
						<div class="col-md-6">
							<h3> Contract End Date</h3>
        					<input type="date" name="date" value="" required="">
						</div>
						</div>
					</div>

					<div class="contract-form-row">
						<div class="row">
							<div class="col-md-6" >
								<h3>Description</h3>
								<textarea class="WYSIWYG" name="summary" cols="40" rows="3" id="summary" spellcheck="true"></textarea>
							</div>
							<div class="col-md-6">
								<h3>Add Document</h3>
								<div class="submit-section">
									<form action="http://www.vasterad.com/file-upload" class="dropzone"></form>
								</div>
							</div>
						</div>
					</div>

					<div class="contract-form-row">
						<div class="row">
							<a href="<?php echo get_site_url(); ?>/admin/deals/contract/681?create_contract"><button class="contract-form-submit">Send Contract</button></a>
						</div>
					</div>
			
			</div>
		</div>


	</div>
</div>
<div class="margin-top-55"></div>
</div>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/dropzone.js"></script>
<script>
	jQuery(".dropzone").dropzone({
		dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
	});
</script>

<?php
get_footer();
?>
