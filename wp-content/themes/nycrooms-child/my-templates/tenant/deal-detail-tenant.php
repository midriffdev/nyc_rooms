<?php
 $dealid = base64_decode(get_query_var( 'id' ));
 $get_post = get_post($dealid);
 if(!$get_post){
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

$query_args = array(
	'post_type'  => 'dealsorders',
	'meta_query' => array(
	    array(
			'key'   => 'deal_id',
			'value' => $dealid ,
	    ),
	)
);

$check_deal_orders = new WP_Query( $query_args );
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
			   <div class="col-md-6">
					<div class="leaddetail-teanentdetail dealdetail__tenantdetail">
					<h2>Your Details</h2>
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
			    <?php if($property_id){ ?>
				<div class="col-md-6">
				
					<div class="dealdetail-propertydetail">
						<h2>Property In Reference</h2>
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
							<?php if(count($check_deal_orders->posts) == 1){ ?>
							<span><?= get_post_meta($property_id,'address',true); ?> </span>
							
							
							<p>Owner: <span><?=get_post_meta($property_id,'contact_name',true) ?></span></p>
							<?php } ?>
							<span class="table-property-price">$<?= get_post_meta($property_id,'price',true); ?> / Weekly</span> <span class="active--property"><?= get_post_meta($property_id,'status',true); ?></span>
							</div>
							</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
                <?php } ?>
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
				   if($get_requested_agent && $get_requested_agent == 1 && $get_selected_agent ){
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
				
				<!------------- Start Aplication form  and Payment multstep form --------------------->
				<div class="col-md-12 progress-set-padding" id="multi-step-form">
							<div class="progress">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
							  </div>
							  <div class="alert alert-success hide"></div>
							  
							  <fieldset class="steps">
							       
									 <div class="submit-section">
										<h4> Step 1: Add Personnel Details</h4>
											<div class="form">
													<h5>Name(s)</h5>
													<input class="name" type="text" placeholder="Enter Name..">
													<span class="name-err"></span>
											</div>

												<!-- Row -->
												<div class="row with-forms">

													<div class="col-md-4">
														<h5>Contact Phone Number</h5>
														<input class="contact_no" type="text" placeholder="Enter Phone">
														<span class="contact_no-err"></span>
													</div>

													<div class="col-md-4">
														<h5>Secondary Phone Number</h5>
														<input class="secondary_contact_no" type="text" placeholder="Enter Secandary Phone">
														<span class="secondary_contact_no-err"></span>
													</div>
													<div class="col-md-4">
														<h5>Emergency Contact</h5>
														<input class="emergency_contact_no" type="text" placeholder="Enter Emergency Contact">
														<span class="emergency_contact_no-err"></span>
													</div>
												</div>
												<!-- Row / End -->

												<!-- Row -->
												<div class="row with-forms">
													<div class="col-md-6">
														<h5>Email Address </h5>
														<input class="email_address" type="text" placeholder="Enter Email..">
														<span class="email_address-err"></span>
													</div>

													<div class="col-md-6">
														<h5>Employer/School</h5>
														<input class="employer_school" type="text" placeholder="Enter Employer/School.." >
														<span class="employer_school-err"></span>
													</div>
												</div>
												<div class="form">
													<h5>Address</h5>
													<textarea class="address" cols="40" rows="3" id="address_text" spellcheck="true" placeholder="Enter Address.." ></textarea>
													<span class="address-err"></span>
												</div>
												<div class="row with-forms">
													<div class="col-md-6">
														<h5>Manager’s Name</h5>
														<input class="manager_name" type="text" placeholder="Enter Manager’s Name..">
														<span class="manager_name-err"></span>
													</div>

													<div class="col-md-6">
														<h5>EManager’s Contact</h5>
														<input class="manager_contact" type="text" placeholder="Enter EManager’s Contact">
														<span class="manager_contact-err"></span>
													</div>
												</div>
												<div class="row with-forms">
													<div class="col-md-6">
														<h5>Monthly Income</h5>
														<input class="month_income" type="text" placeholder="Enter Monthly Income..">
														<span class="month_income-err"></span>
													</div>

													<div class="col-md-6">
														<h5>Weekly Rent Budget </h5>
														<input class="week_rent_budget" type="text" placeholder="Enter Weekly Rent Budget">
														<span class="week_rent_budget-err"></span>
													</div>
												</div>
												<div class="row with-forms">
													<div class="col-md-6">
														<h5>How many people will be living in the room?</h5>
														<select class="chosen-select-no-single people_living_count">
															<option label="blank"></option>		
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="not sure">Not sure </option>
					                                    </select>
														<span class="people_living_count-err"></span>
													</div>

													<div class="col-md-6">
														<h5>How long are you looking to stay in the room?</h5>
														<select class="chosen-select-no-single Periods_of_living">
															<option label="blank"></option>		
															<option value="1 Month">1 Month</option>
															<option value="2 Month">2 Month</option>
															<option value="6 Month">6 Month</option>
															<option value="1 Year">1 year</option>
															<option value="Other">Other</option>
															
					                                    </select>
														<span class="Periods_of_living-err"></span>
													</div>
												</div>
												<div class="form">
													<h5>Where did you see our advertisement?</h5>
													<div class="advertisement_row in-row margin-bottom-20">
																	        
																			<input id="Google" type="radio" class="adversitement_check" name="adversitement_check" value="Google">
																			<label for="Google">Google</label>
																			
																			<input id="El Diario" type="radio" class="adversitement_check" name="adversitement_check" value="El Diario">
																			<label for="El Diario">El Diario</label>
																			
																			
																			<input id="Facebook" type="radio" class="adversitement_check" name="adversitement_check" value="Facebook">
																			<label for="Facebook">Facebook</label>
																			
																			
																			<input id="Amsterdam Newspaper" type="radio" class="adversitement_check" name="adversitement_check" value="Amsterdam Newspaper">
                                                                            <label for="Amsterdam Newspaper">Amsterdam Newspaper</label>
																			
																			
																			<input id="Craigslist" type="radio" class="adversitement_check" name="adversitement_check" value="Craigslist">
																			<label for="Craigslist">Craigslist</label>
																			
																			
                                                                            <input id="Metro Newspaper" type="radio" class="adversitement_check" name="adversitement_check" value="Metro Newspaper">
																			<label for="Metro Newspaper">Metro Newspaper </label>
																			
                                                                            
																			<input id="Referral" type="radio" class="adversitement_check" name="adversitement_check" value="Referral">
																			<label for="Referral">Referral</label>
																			
																			
																			<input id="Other" type="radio" class="adversitement_check" name="adversitement_check" value="Other">
																			<label for="Other">Other</label>
																			
													</div>
													<span class="adversitement_check-err"></span>
												</div>
												<div class="form">
													<h5><b>Policy</b></h5>

													<div class="checkboxes in-row margin-bottom-20">
																	
																			<input id="check-9" type="checkbox" class="privacy_policy" value=1>
																			<label for="check-9"><b>NYC ROOMS 4 RENT INC.</b> is a licensed apartment sharing agency whom for a non-refundable service fee refers you to a primary tenant or landlord for viewings of available rooms. Please be on time and wear proper attire when meeting with the primary tenant or landlord. We are not responsible for any negotiations agreed between you and the landlord or primary tenant. We will assist you until you find the first room that accommodates your needs. If you wish to transfer room we will assist you <b>ONE</b> time at no extra cost within the 30 days guaranteed service policy, except you’ve been evicted for illicit behavior or have a pending balance with the landlord. Our services expire 30 days after you have found a room. <b>Our service fee is non-refundable under no circumstances.</b></label>
																			<span class="privacy_policy-err"></span>
													</div>
													
												</div>
                                      
									</div>
								    <input type="button" class="button submit_application_form" value="Submit Application" id="submit_application_form"/>
									<input type="button" name="next" class="nextbutton btn btn-info" value="Next" />
								  
							  </fieldset>
							  <fieldset class="steps">
								<div class="form">
											<h5>Where did you see our advertisement?</h5>
											<!--div class="checkboxes in-row margin-bottom-20">
															
																	<input id="check-2" type="checkbox" name="check">
																	<label for="check-2">Google</label>

																	<input id="check-3" type="checkbox" name="check">
																	<label for="check-3">El Diario</label>

																	<input id="check-4" type="checkbox" name="check">
																	<label for="check-4">Facebook</label>

																	<input id="check-5" type="checkbox" name="check">
																	<label for="check-5">Amsterdam Newspaper</label>	

																	<input id="check-6" type="checkbox" name="check">
																	<label for="check-6">Craigslist</label>

																	<input id="check-7" type="checkbox" name="check">
																	<label for="check-7">Metro Newspaper </label>

																	<input id="check-8" type="checkbox" name="check">
																	<label for="check-8">Referral</label>
																	<input id="check-8" type="checkbox" name="check">
																	<label for="check-8">Other</label>
																</div-->
								</div>
								<input type="button" name="previous" class="previousbutton btn btn-default" value="Previous" />
							  </fieldset>
							 
				</div>
				
				<!------------- End Aplication form  and Payment multstep form --------------------->
				

				<!-------------- start commented section --------------------------- >

				<!--div class="col-md-12">
					<div class="deal-detail-payment-tobedone">
						
						<div class="deal-detail-tenant-subapp">
						<?php
						  // $application_download_link = site_url().'/tenant/application-form/?file=application_form_'.$dealid;
						?>
						
						<small>Download Sample Application Form <a href="<?php //$application_download_link ?>" target="_blank">here.</a> Fill The details mentioned in form, after that upload the filled application Form Below </small>
						
						<h3>Upload Filled Application Form</h3>
		                <div class="submit-section prop_app_form">
			               <form action="<?php //site_url() ?>/tenant/deal-details-tenant/?id=<?php //$dealid ?>" class="dropzone dropzone_application_form" ></form>
						    <button class="button save_file" id="save_document" >Save File</button>
		                </div>
						</div>
						<?php //if($deal_price): ?><h3>Amount to be Paid: <span>$<?php //$deal_price ?></span></h3> <?php //endif;  ?>
						<ul class="dealdetail-tenant-actionbuttons">
							<li>
							    <?php
								//if(empty($check_deal_orders->posts)){
								?>
								  <button class="dealdetail-tenant-paynowb" <?php //if(!$get_document_file){ echo "disabled";} ?>  data-toggle="modal" data-target="#Square_payment_form_js">Pay Now</button>
								<?php
								//}
								
                               // if(count($check_deal_orders->posts) == 1){
								?>
								<button class="dealdetail-tenant-paynowb" disabled>Payment Done</button>
								<?php
								//}
								?>
								
							</li>
							<li>
							  <?php //if(empty($check_deal_orders->posts)){ ?>
								<button class="dealdetail-tenant-reqagentb" <?php //if($get_requested_agent && $get_requested_agent == 1 ){ echo 'disabled';}  ?>>
								<?php //if($get_requested_agent && $get_requested_agent == 1 ){ echo 'Agent Allotted';} else { echo 'Request an Agent';} ?>
								</button>
							  <?php //} ?>
							</li>
						</ul>
					</div>
				</div-->
				
				<!----------- end commented section ----------------->
				
				<div class="col-md-12">
				    <?php if($admin_notes): ?>
					<div class="deal-detail-tenant-adminnotes">
						<h2>Admin Notes</h2>
						<p><?=$admin_notes ?></p>
					</div>
					<?php endif; ?>
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
         
		<?php if($selected_property){ ?>
		<!----Stage 2---->
		<div class="row deal-stage-2">
			<div class="current-stage-title">
				<h3>Stage 2</h3>
			</div>

			<div class="dealdetail-suggestedproperties-tenant">
				<h3>Suggested Properties</h3>
				
				<?php
				   if($selected_property){
				   ?>
				     <div class="row">
				   <?php
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
					    </div>
                       <div align="center"><button class="button selected_property_tnt" id="selected_property_tnt" >Select Property</button></div>				
					<?php
					}else { echo "<div class='row'><div class='col-md-4'>No Suggested properties founds!</div></div>"; } ?>
				
			</div>
		</div>
	    <?php } ?>
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
 fieldset.steps:not(:first-of-type) {
    display: none;
 }
 
 
 progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}
 @-o-keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}
 @keyframes progress-bar-stripes{from{background-position:40px 0}to{background-position:0 0}}
 
.progress {
    height: 20px;
    margin-bottom: 20px;
    overflow: hidden;
    background-color: #f5f5f5;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
	margin-top: 5%;
}

 .progress-bar {
    float: left;
    width: 0%;
    height: 100%;
    font-size: 12px;
    line-height: 20px;
    color: #fff;
    text-align: center;
    background-color: #337ab7;
    -webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
    -webkit-transition: width .6s ease;
    -o-transition: width .6s ease;
    transition: width .6s ease;
}

.progress-bar.active, .progress.active .progress-bar {
    -webkit-animation: progress-bar-stripes 2s linear infinite;
    -o-animation: progress-bar-stripes 2s linear infinite;
    animation: progress-bar-stripes 2s linear infinite;
}
.progress-bar-striped, .progress-striped .progress-bar {
    background-image: -webkit-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
    background-image: -o-linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
    background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
    -webkit-background-size: 40px 40px;
    background-size: 40px 40px;
}

input.nextbutton {
    width: 11%;
    padding: 0%;
}
input.previousbutton {
    width: 11%;
    padding: 0%;
}

input.submit_application_form {
    width: 17%;
    padding: 0%;
}

.advertisement_row input[type="radio"] {
    width: auto !important;
    margin: 0px 4px 0px 0px !important;
}

.advertisement_row label {
    display: inline-block !important;
    margin: 0px 8px 0px 0px !important;
}

  
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
		
		var current = 1,current_step,next_step,steps;
               steps = $("fieldset.steps").length;
               $(".nextbutton").click(function(){
						current_step = $(this).parent();
						next_step = $(this).parent().next();
						next_step.show();
						current_step.hide();
						setProgressBarTenant(++current);
              });
			  $(".previousbutton").click(function(){
				current_step = $(this).parent();
				next_step = $(this).parent().prev();
				next_step.show();
				current_step.hide();
				setProgressBarTenant(--current);
			  });
              setProgressBarTenant(current);
  // Change progress bar action
		function setProgressBarTenant(curStep){
				var percent = parseFloat(100 / steps) * curStep;
				percent = percent.toFixed();
				$(".progress-bar")
				  .css("width",percent+"%")
				  .html(percent+"%");   
			  }
			  
	 $('#submit_application_form').click(function(e){
	    e.preventDefault();
		//jQuery(".preview").attr("disabled", true);
		var regEx = new RegExp("^[0-9-+]+$");
		var regExEmail = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		jQuery('.error').remove();
		var is_error  = false;
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		var deal_id = '<?php echo $dealid; ?>';
		var name = jQuery('.name').val();
		var contact_no = jQuery('.contact_no').val();
		var secondary_contact_no = jQuery('.secondary_contact_no').val();
		var emergency_contact_no = jQuery('.emergency_contact_no').val();
		var email_address = jQuery('.email_address').val();
		var employer_school = jQuery('.employer_school').val();
		var address = jQuery('.address').val();
		var manager_name = jQuery('.manager_name').val();
		var manager_contact = jQuery('.manager_contact').val();
		var month_income = jQuery('.month_income').val();
		var week_rent_budget = jQuery('.week_rent_budget').val();
		var people_living_count = jQuery('.people_living_count').val();
		var Periods_of_living = jQuery('.Periods_of_living').val();
		var adversitement_check = jQuery(".adversitement_check:checked").val();
		var privacy_policy  =  jQuery('.privacy_policy:checked').val(); 
		
		
        if(name == ''){
			jQuery('.name-err').html('<span class="error">Please enter name</span>');
			jQuery( ".name" ).focus();
			is_error = true;		
		}
		if(contact_no == ''){
			jQuery('.contact_no-err').html('<span class="error">Please enter contact no.</span>');
			jQuery( ".contact_no" ).focus();
			is_error = true;			
		} else if(!regEx.test(contact_no)){
			jQuery('.contact_no-err').html('<span class="error">Contact Phone must be in digits</span>');
			jQuery( ".contact_no" ).focus();
			is_error = true;			
		} else if(contact_no.length != 12){
		     jQuery('.contact_no-err').html('<span class="error">Contact Phone must be 10 digits long with +1 as country code.</span>');
			 jQuery( ".contact_no" ).focus();
			  is_error = true;	
		}
		
		if(secondary_contact_no == ''){
			jQuery('.secondary_contact_no-err').html('<span class="error">Please enter secandary contact</span>');
			jQuery( ".secondary_contact_no" ).focus();
			is_error = true;		
		} else if(!regEx.test(secondary_contact_no)){
			jQuery('.secondary_contact_no-err').html('<span class="error">Contact Phone must be in digits</span>');
			jQuery( ".secondary_contact_no" ).focus();
			is_error = true;			
		} else if(secondary_contact_no.length != 12){
		     jQuery('.secondary_contact_no-err').html('<span class="error">Contact Phone must be 10 digits long with +1 as country code.</span>');
			 jQuery( ".secondary_contact_no" ).focus();
			  is_error = true;	
		}
		
		if(emergency_contact_no == ''){
			jQuery('.emergency_contact_no-err').html('<span class="error">Please enter emergency contact</span>');
			jQuery( ".emergency_contact_no" ).focus();
			is_error = true;		
		} else if(!regEx.test(emergency_contact_no)){
			jQuery('.emergency_contact_no-err').html('<span class="error">Contact Phone must be in digits</span>');
			jQuery( ".emergency_contact_no" ).focus();
			is_error = true;			
		} else if(emergency_contact_no.length != 12){
		     jQuery('.emergency_contact_no-err').html('<span class="error">Contact Phone must be 10 digits long with +1 as country code.</span>');
			 jQuery( ".emergency_contact_no" ).focus();
			  is_error = true;	
		}
		
		if(email_address == ''){
			jQuery('.email_address-err').html('<span class="error">Please enter email address</span>');
			jQuery( ".email_address" ).focus();
			is_error = true;		
		} else if(!regExEmail.test(email_address)){
			jQuery('.email_address-err').html('<span class="error">Please enter valid email address</span>');
			jQuery( ".email_address" ).focus();
			is_error = true;			
		}
		if(employer_school == ''){
			jQuery('.employer_school-err').html('<span class="error">Please enter employer/school</span>');
			jQuery( ".employer_school" ).focus();
			is_error = true;		
		}
		if(address == ''){
			jQuery('.address-err').html('<span class="error">Please enter address</span>');
			jQuery( ".address" ).focus();
			is_error = true;		
		}
		if(manager_name == ''){
			jQuery('.manager_name-err').html("<span class='error'>Please enter manager's Name</span>");
			jQuery( ".manager_name" ).focus();
			is_error = true;		
		}
		if(manager_contact == ''){
			jQuery('.manager_contact-err').html('<span class="error">Please enter manager contact</span>');
			jQuery( ".manager_contact" ).focus();
			is_error = true;		
		} else if(!regEx.test(manager_contact)){
			jQuery('.manager_contact-err').html('<span class="error">Contact Phone must be in digits</span>');
			jQuery( ".manager_contact" ).focus();
			is_error = true;			
		} else if(manager_contact.length != 12){
		     jQuery('.manager_contact-err').html('<span class="error">Contact Phone must be 10 digits long with +1 as country code.</span>');
			 jQuery( ".manager_contact" ).focus();
			  is_error = true;	
		}
		
		
		if(month_income == ''){
			jQuery('.month_income-err').html('<span class="error">Please enter monthly income</span>');
			jQuery( ".month_income" ).focus();
			is_error = true;		
		} else if(!regEx.test(month_income)){
			jQuery('.month_income-err').html('<span class="error">Monthly Income must be in digits</span>');
			jQuery( ".month_income" ).focus();
			is_error = true;			
		}
		if(week_rent_budget == ''){
			jQuery('.week_rent_budget-err').html('<span class="error">Please enter week rent budget</span>');
			jQuery( ".week_rent_budget" ).focus();
			is_error = true;		
		} else if(!regEx.test(week_rent_budget)){
			jQuery('.week_rent_budget-err').html('<span class="error">Monthly Income must be in digits</span>');
			jQuery( ".week_rent_budget" ).focus();
			is_error = true;			
		}
		
		if(people_living_count == ''){
			jQuery('.people_living_count-err').html('<span class="error">Please enter people living in</span>');
			jQuery( ".people_living_count" ).focus();
			is_error = true;		
		}
		if( Periods_of_living == ''){
			jQuery('.Periods_of_living-err').html('<span class="error">Please enter duration of stay</span>');
			jQuery( ".Periods_of_living" ).focus();
			is_error = true;		
		}
		if(typeof adversitement_check == 'undefined'){
			jQuery('.adversitement_check-err').html('<span class="error">Please choose any advertisement option above</span>');
			jQuery( ".adversitement_check" ).focus();
			is_error = true;		
		}
		if(typeof privacy_policy == 'undefined'){
			jQuery('.privacy_policy-err').html('<span class="error">Please check privacy policy before Submission</span>');
			jQuery( ".privacy_policy" ).focus();
			is_error = true;		
		}
		if(is_error == false){
		
		   var form_data = new FormData();
           form_data.append("deal_id", deal_id);		   
		   form_data.append("name", name);
		   form_data.append("contact_no", contact_no);
		   form_data.append("secondary_contact_no", secondary_contact_no);
		   form_data.append("emergency_contact_no", emergency_contact_no);
		   form_data.append("email_address", email_address);
		   form_data.append("employer_school", employer_school);
		   form_data.append("address", address);
		   form_data.append("manager_name", manager_name);
		   form_data.append("manager_contact", manager_contact);
		   form_data.append("month_income", month_income);
		   form_data.append("week_rent_budget", week_rent_budget);
		   form_data.append("people_living_count", people_living_count);
		   form_data.append("Periods_of_living", Periods_of_living);
		   form_data.append("adversitement_check", adversitement_check);
		   form_data.append("privacy_policy", privacy_policy);
		   form_data.append( "action", 'nyc_application_form_pdf_ajax');  
		   
		   jQuery.ajax({
				type : "post",
				url : ajaxurl,
				data: form_data,
				processData: false,
				contentType: false,
				success: function(response) {
				   console.log(response);
				   
				    /* if(response == "success"){
						window.location.href = window.location.href + "?action=success";
					} else {
						window.location.href = window.location.href + "?action=false";
					} */
				}
			});
			
			
			
		   
		}
		
		
		
	
		
	 
	 });
  
		
	});

	
</script>