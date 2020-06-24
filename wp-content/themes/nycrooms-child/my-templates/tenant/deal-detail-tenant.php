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
					<div class="dealdetail-allocateagent-section">
						<h2>Agent Details</h2>
						<ul>
							<li>
								<p>Name: </p>
								<span>Ashutosh Joshi</span>
							</li>
							<li>
								<p>Email:</p>
								<span>ashujoshi@gmail.com</span>
							</li>
							<li>
								<p>Phone:</p>
								<span>+918295585505</span>
							</li>

						</ul>
					</div>

					<div class="dealdetail--agentnotes-sec">
						<h2>Agent Notes:</h2>
						<p>I need room with 2 beds and proper air circulation with personal space. We are total 3 persons which are actively looking room for rent. </p>
					</div>
				</div>

				<div class="col-md-12">
					<div class="deal-detail-tenant-adminnotes">
						<h2>Admin Notes</h2>
						<p>You can pay online as well as request for agent, If agent will come to your door step than you can pay in this project also with the help of agent. You can pay online as well as request for agent, If agent will come to your door step than you can pay in this project also with the help of agent.</p>
					</div>
				</div>

				<div class="col-md-12">
					<div class="deal-detail-payment-tobedone">
						<h3>Amount to be Paid: <span>$400</span></h3>
						<div class="deal-detail-tenant-subapp">
						<?php
						   $application_download_link = site_url().'/tenant/application-form/?file=application_form_'.$dealid;
						?>
						<a href="<?= $application_download_link ?>" target="_blank">Submit Application Form *</a>
			
						</div>
						<ul class="dealdetail-tenant-actionbuttons">
							<li>
								<button class="dealdetail-tenant-paynowb">Pay Now</button>
							</li>
							<li>
								<button class="dealdetail-tenant-reqagentb">Request an Agent</button>
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
					<div class="col-md-4">
						<div class="listing-item compact">
						<a href="single-property.html" class="listing-img-container">
							<div class="listing-badges">
								<span class="featured">Featured</span>
								<span>For Rent</span>
							</div>
							<div class="listing-img-content">
								<span class="listing-compact-title">Eagle Apartments <i>$200 / monthly</i></span>

								<ul class="listing-hidden-content">
									<li>Rooms <span>3</span></li>
									<li>Beds <span>1</span></li>
									<li>Baths <span>1</span></li>
								</ul>
							</div>
							<img src="<?= get_stylesheet_directory_uri() ?>/images/listing-01.jpg" alt="">
						</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="listing-item compact">
						<a href="single-property.html" class="listing-img-container">
							<div class="listing-badges">
								<span class="featured">Featured</span>
								<span>For Rent</span>
							</div>
							<div class="listing-img-content">
								<span class="listing-compact-title">Eagle Apartments <i>$200 / monthly</i></span>

								<ul class="listing-hidden-content">
									<li>Rooms <span>3</span></li>
									<li>Beds <span>1</span></li>
									<li>Baths <span>1</span></li>
								</ul>
							</div>
							<img src="<?= get_stylesheet_directory_uri() ?>/images/listing-01.jpg" alt="">
						</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="listing-item compact">
						<a href="single-property.html" class="listing-img-container">
							<div class="listing-badges">
								<span class="featured">Featured</span>
								<span>For Rent</span>
							</div>
							<div class="listing-img-content">
								<span class="listing-compact-title">Eagle Apartments <i>$200 / monthly</i></span>

								<ul class="listing-hidden-content">
									<li>Rooms <span>3</span></li>
									<li>Beds <span>1</span></li>
									<li>Baths <span>1</span></li>
								</ul>
							</div>
							<img src="<?= get_stylesheet_directory_uri() ?>/images/listing-01.jpg" alt="">
						</a>
						</div>
					</div>
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
<?php
get_footer();
?>
<script>
	$(".dropzone").dropzone({
		dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
	});

	$(document).ready(function(){
	    $('#alocateagent-select').on('change', function() {
	        $(".allocategent-tostage").show();
	    });

	    $(".desellect-sellectedproperty").click(function(){
	    	$(this).parent().addClass('selected-property-none'); 
	    });
	});
</script>