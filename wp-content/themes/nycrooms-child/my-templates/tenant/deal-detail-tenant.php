<?php
if(isset($_GET['id']) && !empty($_GET['id'])){
  $dealid = $_GET['id'];
} else {
  wp_redirect(home_url());
}
$deal_source  =   get_post_meta($dealid,'lead_source',true);
$deal_stage   =   get_post_meta($dealid,'deal_stage',true);
$lead_source  =   get_post_meta($dealid,'lead_source',true);
$name         =   get_post_meta($dealid,'name',true);
$email        =   get_post_meta($dealid,'email',true);
$phone        =   get_post_meta($dealid,'phone',true);
$description  =   get_post_meta($dealid,'description',true);
$property_id  =   get_post_meta($dealid,'property_id',true);
$admin_notes  =   get_post_meta($dealid,'admin_notes',true);
$deal_price   =   get_post_meta($dealid,'deal_price',true);
$agent_saved_notes    =   get_post_meta($dealid,'agent_notes',true);
$get_selected_agent   =   get_post_meta($dealid,'selectedAgent',true);
$get_document_file    =   get_post_meta($dealid,'document_files',true);
$get_requested_agent  =   get_post_meta($dealid,'request_an_agent',true);
$selected_property    =   get_post_meta($dealid, 'selected_property', true);


get_header();
?>
<!-- Wrapper -->
<div id="wrapper">


<!-- Content
================================================== -->
<div class="deal-detail-container">		
	<div class="container">

		<!------Stage 1---->
		<div class="dealdetail--stageonecont">
			<div class="row">
				<div class="col-md-12">
					<div class="current-stage-title">
						<h3>Stage 1</h3>
					</div>
				</div>
			</div>
              
			<div class="row dealdetail--stageinnersection">
			   <?php  if($lead_source == "Property Form"){
			   $property_id  =   get_post_meta($dealid,'property_id',true);

			   ?>
			    <?php if($property_id){ ?>
				<div class="col-md-6">
				
					<div class="dealdetail-propertydetail">
						<h2>Basic Property Details</h2>
						<table class="manage-table responsive-table">
						<tbody>
						<!-- Item #1 -->
							<tr>
							<td class="title-container lead-detail-propertytitlesec">
							<?php 
						     $galleryfiles =  get_post_meta($property_id,'gallery_files',true);
						     if($galleryfiles){
								$galleryfiles = explode(',',$galleryfiles);
								$attachment_id = get_post_meta($property_id,$galleryfiles[0],true);
							    $imgsrc = wp_get_attachment_image_src( $attachment_id,array('300', '200'));
								echo wp_get_attachment_image( $attachment_id, array('768', '512'), "", array( "class" => "img-responsive" ) );
						     }
						    ?>
							<div class="title">
							<h4><a href="<?= get_post_permalink($property_id) ?>"><?php echo get_the_title($property_id); ?></a></h4>
							<span><?= get_post_meta($property_id,'address',true); ?> </span>
							<p>Owner: <span><?=get_post_meta($property_id,'contact_name',true) ?></span></p>
							<span class="table-property-price">$<?= get_post_meta($property_id,'price',true); ?> / Weekly</span> <span class="active--property"><?= get_post_meta($property_id,'status',true); ?></span>
							</div>
							</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
                <?php } ?>
				<div class="col-md-6">
					<div class="leaddetail-teanentdetail dealdetail__tenantdetail">
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
				<div class="col-md-12">
					<?php if($lead_source == "Appointment Form"){ ?>
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
										<span>
										<?php 
											$strtotime = get_post_meta($dealid, 'lead_datetime', true);
											$date =  date("F j, Y", $strtotime); 
											echo $date;
							            ?>
							           </span>
									</li>
									<li>
										<p>Time:</p>
										<span>
											<?php 
												$strtotime = get_post_meta($dealid, 'lead_datetime', true);
												$time =  date("h:i A", $strtotime);
												echo $time;
											?>
										</span>
									</li>
									<li>
										<p>Description:</p>
										<?php 
										 if($description){
										?>
										<span><?php echo $description; ?></span>
										<?php
										} else {
										?>
										<span><?php echo "N . A"; ?></span>
										<?php 
										}
										?>
									</li>
								</ul>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>

				<div class="col-md-6">
                   <?php 
				   if($get_selected_agent){
				     $agent_name = get_user_meta($get_selected_agent, 'user_full_name', true);
					 $agent_email = get_user_meta($get_selected_agent, 'user_agent_email', true);
					 $agent_phone = get_user_meta($get_selected_agent, 'user_phone', true);
				      
				   ?>
					<div class="dealdetail-allocateagent-section">
						<h2>Agent Details</h2>
						<ul>
							<li>
								<p>Name: </p>
								<span><?= $agent_name ?></span>
							</li>
							<li>
								<p>Email:</p>
								<span><?= $agent_email ?></span>
							</li>
							<li>
								<p>Phone:</p>
								<span><?= $agent_phone ?></span>
							</li>

						</ul>
					</div>
					<?php 
					if($agent_saved_notes){
					?>
					<div class="dealdetail--agentnotes-sec">
						<h2>Agent Notes:</h2>
						<p><?= $agent_saved_notes ?></p>
					</div>
					<?php
					}
					}
					?>
					
				</div>

				<div class="col-md-12">
				    <?php if($admin_notes): ?>
					<div class="deal-detail-tenant-adminnotes">
						<h2>Admin Notes</h2>
						<p><?=$admin_notes ?></p>
					</div>
					<?php endif; ?>
				</div>

				<div class="col-md-12">
					<div class="deal-detail-payment-tobedone">
						
						<div class="deal-detail-tenant-subapp">
						<?php
						   $application_download_link = site_url().'/tenant/application-form/?file=application_form_'.$dealid;
						?>
						
						<small>Download Sample Application Form <a href="<?= $application_download_link ?>" target="_blank">here.</a> Fill The details mentioned in form, after that upload the filled application Form Below </small>
						
						<h3>Upload Filled Application Form</h3>
		                <div class="submit-section prop_app_form">
			               <form action="<?= site_url() ?>/tenant/deal-details-tenant/?id=<?= $dealid ?>" class="dropzone dropzone_application_form" ></form>
						    <button class="button save_file" id="save_document" >Save File</button>
		                </div>
						</div>
						<?php if($deal_price): ?><h3>Amount to be Paid: <span>$<?= $deal_price ?></span></h3> <?php endif;  ?>
						<ul class="dealdetail-tenant-actionbuttons">
							<li>
								<button class="dealdetail-tenant-paynowb" <?php if(!$get_document_file){ echo "disabled";} ?>  data-toggle="modal" data-target="#Square_payment_form_js">Pay Now</button>
							</li>
							<li>
								<button class="dealdetail-tenant-reqagentb" <?php if($get_requested_agent && $get_requested_agent == 1 ){ echo 'disabled';}  ?>>Request an Agent</button>
							</li>
						</ul>
					</div>
				</div>

				<div class="col-md-12">
					<div class="dealdetail-instruction section">
						<h3>Instructions</h3>
						<ul>
							<li>1. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
							<li>2. it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</li>
							<li>3. "On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment.</li>
							<li>4. "But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system.</li>
							<li>5. "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</li>
							<li>6. "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
							<li>7. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</li>
						</ul>
					</div>
				</div>

			</div>

		</div>

		<!----Stage 2---->
		<div class="row deal-stage-2">
			<div class="current-stage-title">
				<h3>Stage 2</h3>
			</div>

			<div class="dealdetail-suggestedproperties-tenant">
				<h3>Suggested Properties</h3>
				<div class="row">
				<?php
				   if($selected_property){
	                    foreach($selected_property as $property_ids){ 
	                      $price = get_post_meta($property_ids, 'price',true);	
	            ?>
				   
					<div class="col-md-4">
					    <input type="radio" name="select_property_tenant" value="<?= $property_ids ?>" <?= ($property_ids == $property_id)? "checked" : "" ?> > 
						<div class="listing-item compact">
							<a href="<?= get_post_permalink($property_ids) ?>" class="listing-img-container" target="_blank">
								<div class="listing-badges">	
									<span class="featured">Featured</span>
									<span>For Rent</span>
								</div>
								<div class="listing-img-content">
									<span class="listing-compact-title"><?php echo get_the_title($property_ids); ?> <i>$<?php echo $price; ?> / monthly</i></span>

									<ul class="listing-hidden-content">
										<li>Rooms <span><?php echo get_post_meta($property_ids,'rooms',true); ?></span></li>
									</ul>
								</div>
								<img src="<?php echo wp_get_attachment_url(get_post_meta($property_ids,'file_0',true)); ?>" alt="">
							</a>
						</div>
						
					</div>
					<?php }
                    ?>
                       <div align="center"><button class="button selected_property_tnt" id="selected_property_tnt" >Select Property</button></div>				
					<?php
					}else { echo "<li>No selected property founds!</li>"; } ?>
				</div>
			</div>
		</div>
	
	</div>
</div>


<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

<!-- Modal for Amount details -->
<div class="modal fade popup-main--section" id="fillamountdetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="fillamount-popup">
        	<h3>Fill Amount Details</h3>
 			<ul>
 				<li>
 					<h5>Price <i class="tip" data-tip-content="Type overall or monthly price if property is for rent"></i></h5>
					<div class="select-input disabled-first-option">
						<input type="text" data-unit="USD">
					</div>
 				</li>
 				<li>
 					<h5>Date</h5>
 					<input class="search-field" type="text" value=""/>
 				</li>
 				<li>
 					<h5>Time</h5>
 					<input class="search-field" type="text" value=""/>
 				</li>
 			</ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-secondary dealdetail-popupsub">Submit</button>
      </div>
    </div>
  </div>
</div>


<!--Modal for Contact Details -->
<div class="modal fade popup-main--section" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="dealsend-popup">
        	<h3>Contact Details</h3>
        	<div class="submit-section">
			<!-- Row -->
			<div class="row with-forms">
				<!-- Email -->
				<div class="col-md-6">
					<h5>E-Mail</h5>
					<input type="text">
				</div>
				<!-- Phone -->
				<div class="col-md-6">
					<h5>Phone</h5>
					<input type="text">
				</div>
			</div>
			<!-- Row / End -->
		</div>
		<!-- Section / End -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-secondary dealdetail-popupsub">Submit</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for Sign Application Form-->
<div class="modal fade popup-main--section" id="signapplicationform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered dealdetail-applicationform-modal" role="document">
    <div class="modal-content dealdetail-applicationformpop">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="dealdetail-applicationformpop-body">
        	<h3>Application Form Details</h3>
        	<ul>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Name: <span>Akash</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Contact Phone Number: <span>+918295585505</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Secondary Phone Number: <span>+91895689546</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Emergency Contact: <span>+91963654855</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Email Address: <span>shubham@gmail.com</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Employer/School: <span>DAV Public Sr. Sec School</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Address: <span>H.No- 145, Near hotel paris, Naraingarh.</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Manager’s Name: <span>Madrid</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Manager’s Contact: <span>+91659865685</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Monthly Income: <span>$1000</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Weekly Rent Budget: <span>$200</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>How many people will be living in the room?: <span>1</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>How long are you looking to stay in the room?: <span>1 Year</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Where did you see our advertisement? : <span>Google</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-singlerow">
        				<h5>Policy</h5>
        				<p><b>NYC ROOMS 4 RENT INC.</b> is a licensed apartment sharing agency whom for a non-refundable service fee refers you to a primary tenant or landlord for viewings of available rooms. Please be on time and wear proper attire when meeting with the primary tenant or landlord. We are not responsible for any negotiations agreed between you and the landlord or primary tenant. We will assist you until you find the first room that accommodates your needs. If you wish to transfer room we will assist you <b>ONE</b> time at no extra cost within the 30 days guaranteed service policy, except you’ve been evicted for illicit behavior or have a pending balance with the landlord. Our services expire 30 days after you have found a room. <b>Our service fee is non-refundable under no circumstances.</b></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Signature: <span>Shubham</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Date: <span> December 30, 2016</span></p>
        			</div>
        		</li>
        	</ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


</div>
<!--Modal for Contact Details -->
<div class="modal fade popup-main--section" id="application_form_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="application-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Modal for Contact Details -->
<div class="modal fade popup-main--section" id="agent_assign_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="agent-assign-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="removed_file_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="removed-file-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="finalise_property_tenant" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="finalise-property-tenant">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="Square_payment_form_js" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        	<div id="form-container">
				  <div id="sq-ccbox">
					<!--
					  Be sure to replace the action attribute of the form with the path of
					  the Transaction API charge endpoint URL you want to POST the nonce to
					  (for example, "/process-card")
					-->
					<form id="nonce-form" novalidate>
					  <fieldset>
						<span class="label">Card Number</span>
						<div id="sq-card-number"></div>

						<div class="third">
						  <span class="label">Expiration</span>
						  <div id="sq-expiration-date"></div>
						</div>

						<div class="third">
						  <span class="label">CVV</span>
						  <div id="sq-cvv"></div>
						</div>

						<div class="third">
						  <span class="label">Postal</span>
						  <div id="sq-postal-code"></div>
						</div>
					  </fieldset>

					  <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">Create Payment</button>

					  <div id="error"></div>

					  <!--
						After a nonce is generated it will be assigned to this hidden input field.
					  -->
					  <input type="hidden" id="amount" name="amount" value="<?= $deal_price * 100 ?>">
					  <input type="hidden" id="deal_id_square_tenant" name="deal_id_square_tenant" value="<?= $dealid ?>">
					  <input type="hidden" id="email_square_teanant"  name="email_square_teanant"  value="<?= $email ?>">
					  <input type="hidden" id="card-nonce" name="nonce">
					</form>
				  </div> <!-- end #sq-ccbox -->

           </div> <!-- end #form-container -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="square_payment_success_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="square-payment-success-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php
get_footer();
?>
<style>
.deal-detail-tenant-subapp a {
    font-size: 17px;
    margin: 0;
    display: inherit;
}
.deal-detail-payment-tobedone h3{margin-top:15px}
</style>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/dropzone.js"></script>
<script>

 	$(".dropzone.dropzone_application_form").dropzone({
		dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
		addRemoveLinks: true,
		acceptedFiles: "application/pdf,.doc,.docx",
		maxFiles: 1,
		init: function() { 
			myDropzoneFiles = this;
			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	        var deal_id = '<?php echo $dealid; ?>';
			jQuery.ajax({
			  type: 'post',
			  dataType: 'json',
			  url: ajaxurl,
			  data: {action:'nyc_get_existing_application_form_ajax',deal_id:deal_id},
			  success: function(response){
				  $.each(response, function(key,value) {
                          if(value.size != false){
						     var mockFile = { name: value.name, size: value.size };
							  myDropzoneFiles.emit("addedfile", mockFile);
							 // myDropzoneFiles.emit("thumbnail", mockFile, value.path);
							  myDropzoneFiles.emit("complete", mockFile);
						  }
						 
				  }); 

			  }
			 });
			 
        },
        removedfile: function(file) {
			 var file_name    = file.name;
			 var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	         var deal_id = '<?php echo $dealid; ?>';
			 jQuery.ajax({
					  type: 'post',
					  url: ajaxurl,
					  data: {action:'nyc_delete_existing_application_form_ajax',deal_id:deal_id,file_name:file_name},
					  success: function(response){
							 if(response == "success"){
								jQuery('.removed-file-popup h3').html('Document Removed Successfully');
								jQuery('#removed_file_popup').modal('show');
								location.reload();
					         }
					  }
			  });
			var _ref;
			return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0; 
	
        }
   
	});
	
	
	

	jQuery(document).ready(function(){
	
	    $('#alocateagent-select').on('change', function() {
	        $(".allocategent-tostage").show();
	    });

	    $(".desellect-sellectedproperty").click(function(){
	    	$(this).parent().addClass('selected-property-none'); 
	    });
		
		$("#save_document").click(function(e){
		   e.preventDefault();
		   jQuery('.loading').show();
		   var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	       var deal_id = '<?php echo $dealid; ?>';
		   jQuery(this).attr("disabled", true);
		   var drop_doc_data = $('.dropzone.dropzone_application_form')[0].dropzone.getAcceptedFiles();
		   var form_data = new FormData();
           form_data.append("deal_id", deal_id);
		   var document_files=[];
		   for(var i = 0;i<drop_doc_data.length;i++){
				form_data.append("doc_"+i, drop_doc_data[i]);
				document_files.push("doc_"+i);
		   }
		   
		   form_data.append( "action" , 'nyc_upload_application_form');	
		   
		   jQuery.ajax({
				type : "post",
				url : ajaxurl,
				data: form_data,
				processData: false,
				contentType: false,
				success: function(response) {
				     if(response == "success"){
						jQuery('.loading').hide();
						jQuery('.application-popup h3').html('Application Saved Successfully');
			            jQuery('#application_form_popup').modal('show');
						location.reload();
					}
					
				}
			});	
		
		});
		
		$('.dealdetail-tenant-reqagentb').click(function(){
		    jQuery(this).attr("disabled", true);
		    jQuery('.loading').show();
		    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	        var deal_id = '<?php echo $dealid; ?>';
			 
			 jQuery.ajax({
					  type: 'post',
					  url: ajaxurl,
					  data: {action:'nyc_request_agent_ajax',deal_id:deal_id},
					  success: function(response){
							 if(response == "success"){
								jQuery('.loading').hide();
								jQuery('.agent-assign-popup h3').html('Agent Assigned Successfully');
								jQuery('#agent_assign_popup').modal('show');
								location.reload();
					         }
					  }
					  
			  }); 
			  
		});
		
		$('#selected_property_tnt').click(function(){
		
		    var checkproperty = $('input[name="select_property_tenant"]:checked').length;
			
		    if(checkproperty == 0){
			  alert("Please Select an property");
			} else {
			    var property_id = $('input[name="select_property_tenant"]:checked').val();
				jQuery('.loading').show();
				var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
				var deal_id = '<?php echo $dealid; ?>';
				 
				 jQuery.ajax({
						  type: 'post',
						  url: ajaxurl,
						  data: {action:'nyc_tenant_final_selected_property_ajax',deal_id:deal_id,property_id:property_id},
						  success: function(response){
								  if(response == "success"){
									jQuery('.loading').hide();
									jQuery('.finalise-property-tenant h3').html('Property Assigned Successfully');
									jQuery('#finalise_property_tenant').modal('show');
									location.reload();
								 }	 
						  }
						  
				  }); 
			  
			 }
			  
		});
		
		
		
	});

	
</script>