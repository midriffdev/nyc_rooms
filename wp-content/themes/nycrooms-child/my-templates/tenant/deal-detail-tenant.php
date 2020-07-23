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
$get_document_file    =   get_post_meta($dealid,'application_doc',true);
$get_invoice_doc      =   get_post_meta($dealid,'payment_invoice_doc',true);
$get_requested_agent  =   get_post_meta($dealid,'request_an_agent',true);
$selected_property    =   get_post_meta($dealid, 'selected_property', true);
$application_submission  =   get_post_meta($dealid,'application_submission', 1);

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
				<div class="col-md-12">	 
						   
						 <div class="card">
                           <div class="card-content">
                             <ul class="stepper linear">
							  
							 <li class="step active">
							    <div data-step-label="There's labels too!" class="step-title waves-effect waves-dark">Step 1</div>
								    <div class="step-content">
									 <div class="submit-section">
										<h4>Add Personnel Details</h4>
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
								    <div class="step-actions">
                                    <input type="button" class="button submit_application_form" id="submit_application_form" value="Submit Aplication"><button class=" waves-effect waves-dark btn blue next-step">CONTINUE</button>
                                    </div>
								  </div>
							  </li>
							  <li class="step">
								    <div class="step-title waves-effect waves-dark">Step 2</div>
									    <div class="step-content">
										  <div class="row">
											<div class="col-md-12">
											    <div class="deal-detail-payment-tobedone mre_wdth">
												   <?php if(empty($check_deal_orders->posts)){ ?>
												    <div class="consent_terms">
												    <p>Below is the consent terms  which the tenant has to accept with the date and stamp:</p>
													<p><input type="checkbox" name="check_consents_terms" value="1">By clicking this box you are agreeing to the following:
													<span class="check_consents_terms_err"></span>
													</p>
													
													<p>1.	You are paying a service fee to NYC Rooms For Rent Inc. to provide listings of available rooms.</p>
													<p>2.	NYC Rooms for Rent will arrange, conduct, coordinate, handles or cause meetings between you and the current occupant of a legally occupied property, including apartment housing, who wishes to share that housing with you or more individuals as a private dwelling.</p>
													<p>3.	NYC Rooms For Rent Inc. will do the aforementioned for an unlimited amount of time until you are placed in a room of your likings.</p>
													<p>4.	NYC Rooms for Rent Inc. is not responsible if landlord rejects you for not meeting the landlord qualifications, however NYC Rooms for Rent Inc. will continue to provide you listings.</p>
													<p>5.	After you move into one of our listings NYC Rooms For Rent Inc. is not responsible for furnishing further listings.</p> 
													<p>6.	The service fee paid to NYC Rooms For Rent is non-refundable.</p>
													</div>
                                                     <?php } ?>
													 
													<?php
													if(empty($check_deal_orders->posts)){ if($deal_price){ ?><h3>Amount to be Paid: <span>$<?= $deal_price ?></span></h3> <?php } }  
													if(count($check_deal_orders->posts) == 1){ if($deal_price){ ?><h3>Amount Paid: <span>$<?= $deal_price ?></span></h3> <?php } }  ?>
													
													<ul class="dealdetail-tenant-actionbuttons">
														<li>
															<?php
															if(empty($check_deal_orders->posts)){
															?>
															  <button type="button" class="dealdetail-tenant-paynowb sqre_py_now" id="dealdetail-tenant-paynowb">Pay Now</button>
															  
															<?php
															}	
															
															if(count($check_deal_orders->posts) == 1){
															?>
															<button class="dealdetail-tenant-paynowb" disabled>Payment Done</button>
															<?php
															}
															?>
															
														</li>
														<li>
														  <?php if(empty($check_deal_orders->posts)){ ?>
															<button class="dealdetail-tenant-reqagentb" <?php if($get_requested_agent && $get_requested_agent == 1 ){ echo 'disabled';}  ?>>
															<?php if($get_requested_agent && $get_requested_agent == 1 ){ echo 'Agent Allotted';} else { echo 'Request an Agent';} ?>
															</button>
														  <?php } ?>
														  
														</li>
													</ul>
													<?php
													if($get_document_file) {
													?>
													<a class="button application_pdf" href="<?= wp_get_attachment_url($get_document_file) ?>" download >Download Application As Pdf </a> 
													<?php 
													}
													if($get_invoice_doc){
													?>
													 <a class="button payment_pdf" href="<?= wp_get_attachment_url($get_invoice_doc) ?>" download >Download Invoice As Pdf </a> 
													<?php
													}
													?>
													<span class="appcation_submission_err"></span>
												</div>
				                            </div>
										  </div>
								          <div class="step-actions">
									         <button class="button waves-effect waves-dark btn-flat previous-step">BACK</button>
                                          </div>
								        </div>
							  </li>
							</ul>
						</div>
			            </div>
				        </div>
				 
				   <div class="col-md-12">
						<h3>Kindly Upload The Documents Here</h3>
						<div class="submit-section prop_req_docs">
						   <form action="<?= site_url() ?>/tenant/deal-details-tenant/<?php echo $dealid; ?>" class="dropzone dropzone_tenant_documents" ></form>
						   <p align=center><button type="button" class="button save_tenant_doc">Save Documents</button></p>
					   </div>
				  </div>
				
				<!------------- End Aplication form  and Payment multstep form --------------------->
				

				
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
        <button type="button" class="btn btn-secondary agent_assign_popup" data-dismiss="modal">Close</button>
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
        <button type="button" class="btn btn-secondary finalise_property_tenant" data-dismiss="modal">Close</button>
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

					  <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">Pay Now</button>

					  <div id="error"></div>

					  <!--
						After a nonce is generated it will be assigned to this hidden input field.
					  -->
					  <input type="hidden" id="amount" name="amount" value="<?= $deal_price * 100 ?>">
					  <input type="hidden" id="deal_id_square_tenant" name="deal_id_square_tenant" value="<?= $dealid ?>">
					  <input type="hidden" id="email_square_teanant"  name="email_square_teanant"  value="<?= $email ?>">
					  <input type="hidden" id="name_square_teanant"   name="name_square_teanant"  value="<?= $name ?>">
					  <input type="hidden" id="phone_square_teanant"  name="phone_square_teanant"  value="<?= $phone ?>">
					  <input type="hidden" id="card-nonce" name="nonce">
					</form>
				  </div> <!-- end #sq-ccbox -->

           </div> <!-- end #form-container -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary Square_payment_form_js" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="applcation_submison_success_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="applcation-submison-success-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary applcation_submison_success_popup" data-dismiss="modal">Close</button>
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
        <button type="button" class="btn btn-secondary square_payment_success_popup" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="applcation_docs_tenant_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="applcation-docs-tenant-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary applcation_docs_tenant_popup" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="applcation_docs_tenant_delete_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="applcation-docs-tenant-delete-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary applcation_docs_tenant_delete_popup" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


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
    width: 20%;
    padding: 0%;
	margin: 0px 15px 0px 0px;
}

input#submit_application_form {
    /* height: 57px; */
    margin: 0px 15px 0px 0px;
}


.advertisement_row input[type="radio"] {
    width: auto !important;
    margin: 0px 4px 0px 0px !important;
}

.advertisement_row label {
    display: inline-block !important;
    margin: 0px 8px 0px 0px !important;
}
.applction_frm_resp{
  color:green;
  font-size:16px;
}

.deal-detail-payment-tobedone.mre_wdth{
  width: 66%;
}
.consent_terms p {
    font-size: 11px;
    text-align: justify;
    margin: 0px !important;
    line-height: 24px;
}

.consent_terms p:first-child {
    font-size: 13px;
    padding-bottom: 1%;
}

input[name=check_consents_terms] {
    width: auto;
    margin: 0px 8px 0px 0px;
}

span.check_consents_terms_err {
    text-align: justify;
    width: 100%;
    float: left;
    color: red;
    font-size: 10px;
    position: relative;
    top: -18px;
    margin-left: 0px;
}

a.button.application_pdf {
    margin-top: 4%;
}

span.appcation_submission_err {
    color: red;
}


/* Stepper */
label.invalid {
   font-size: 12px;
   font-weight: 500;
   color: red !important;
   top: 50px !important;
}

label.invalid.active {
   -webkit-transform: translateY(0%) !important;
   transform: translateY(0%) !important;
}
/*Validate.js FIX*/

ul.stepper {
   counter-reset: section;
   list-style: none;
   /*max-width: 800px;*/
}

ul.stepper.horizontal {
   position: relative;
   display: -webkit-box;
   display: -ms-flexbox;
   display: flex;
   -webkit-box-pack: justify;
   -ms-flex-pack: justify;
   justify-content: space-between;
   min-height: 458px;
}

.card-content ul.stepper.horizontal {
   margin-left: -20px;
   margin-right: -20px;
   padding-left: 20px;
   padding-right: 20px;
   overflow: hidden;
}

.card-content ul.stepper.horizontal:first-child {
   margin-top: -20px;
}

ul.stepper.horizontal::before {
   content: '';
   background-color: transparent;
   width: 100%;
   min-height: 84px;
   box-shadow: 0px 2px 1px -1px rgba(0,0,0,0.2),0px 1px 1px 0px rgba(0,0,0,0.14),0px 1px 3px 0px rgba(0,0,0,0.12);
   position: absolute;
   left: 0;
}

ul.stepper .wait-feedback {
   left: 0;
   right: 0;
   top: 0;
   z-index: 2;
   position: absolute;
   width: 100%;
   height: 100%;
   text-align: center;
   display: -webkit-box;
   display: -ms-flexbox;
   display: flex;
   -webkit-box-pack: center;
   -ms-flex-pack: center;
   justify-content: center;
   -webkit-box-align: center;
   -ms-flex-align: center;
   align-items: center;
}

ul.stepper:not(.horizontal) .step {
   position: relative;
}

ul.stepper .step.feedbacking .step-content>*:not(.wait-feedback) {
   opacity: 0.1;
}

ul.stepper.horizontal .step {
   width: 100%;
   display: -webkit-box;
   display: -ms-flexbox;
   display: flex;
   -webkit-box-align: center;
   -ms-flex-align: center;
   align-items: center;
   height: 84px;
}

ul.stepper.horizontal .step:last-child {
   width: auto;
}

ul.stepper.horizontal .step:not(:last-child)::after {
   content: '';
   display: inline-block;
   width: 100%;
   height: 1px;
   background-color: rgba(0,0,0,0.1);
}

ul.stepper:not(.horizontal) .step:not(:last-child) {
   margin-bottom: 10px;
   -webkit-transition:margin-bottom 0.4s;
   transition:margin-bottom 0.4s;
}

ul.stepper:not(.horizontal) .step:not(:last-child).active {
   margin-bottom: 36px;
}

ul.stepper:not(.horizontal) .step::before {
   left:0;
   position: absolute;
   top: 12px;
   counter-increment: section;
   content: counter(section);
   height: 28px;
   width: 28px;
   color: white;
   background-color: rgba(0,0,0,0.3);
   border-radius: 50%;
   text-align: center;
   line-height: 28px;
   font-weight: 400;
}

ul.stepper:not(.horizontal) .step.active::before, ul.stepper:not(.horizontal) .step.done::before, ul.stepper.horizontal .step.active .step-title::before, ul.stepper.horizontal .step.done .step-title::before {
   background-color: #2196f3;
}

ul.stepper:not(.horizontal) .step.done::before, ul.stepper.horizontal .step.done .step-title::before {
   content: '\e5ca';
   font-size: 16px;
   font-family: 'Material Icons';
}

ul.stepper:not(.horizontal) .step.wrong::before, ul.stepper.horizontal .step.wrong .step-title::before {
   content: '\e001';
   font-size: 24px;
   font-family: 'Material Icons';
   background-color: red !important;
}

ul.stepper:not(.horizontal) .step-title {
   text-align: left;
   margin: 0 -20px;
   cursor: pointer;
   padding: 15.5px 44px 24px 60px;
   display: block;
}

ul.stepper.horizontal .step-title {
   line-height: 84px;
   height: 84px;
   padding-left: 65px;
   padding-right: 25px;
   display: inline-block;
   max-width: 220px;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   -ms-flex-negative: 0;
   flex-shrink: 0;
}

ul.stepper.horizontal .step .step-title::before {
   position: absolute;
   top: 28.5px;
   left: 19px;
   counter-increment: section;
   content: counter(section);
   height: 28px;
   width: 28px;
   color: white;
   background-color: rgba(0,0,0,0.3);
   border-radius: 50%;
   text-align: center;
   line-height: 28px;
   font-weight: 400;
}

ul.stepper .step-title::after {
   content: attr(data-step-label);
   display: block;
   position: absolute;
   font-size: 0.8rem;
   color: #424242;
   font-weight: 400;
}

ul.stepper.horizontal .step-title::after {
   top:15px;
}

ul.stepper .step-title:hover {
   background-color: rgba(0, 0, 0, 0.06);
}

ul.stepper .step.active .step-title {
   font-weight: 500;
}

ul.stepper .step-content {
	text-align: left;
   position: relative;
   display: none;
   height: calc(100% - 132px);
   width: inherit;
   overflow: visible;
   padding: 15.5px 15px 24px 60px;
}

ul.stepper.horizontal .step-content {
   position: absolute;
   height: calc(100% - 84px);
   top: 84px;
   left: 0;
   width: 100%;
   overflow-y: auto;
   overflow-x: hidden;
   margin: 0;
   padding: 20px 20px 76px 20px;
}

.card-content ul.stepper.horizontal .step-content {
   padding-left: 40px;
   padding-right: 40px;
}

ul.stepper:not(.horizontal)>.step:not(:last-child)::after {
   content: '';
   position: absolute;
   top: 50px;
   left: 13.5px;
   width: 1px;
   height: calc(100% - 38px);
   background-color: rgba(0,0,0,0.1);
   -webkit-transition:height 0.4s;
   transition:height 0.4s;
}

ul.stepper:not(.horizontal)>.step.active:not(:last-child)::after {
   height: calc(100% - 12px);
}

ul.stepper .step-actions {
   padding-top: 16px;
   -webkit-display: flex;
   -moz-display: flex;
   -ms-display: flex;
   display: -webkit-box;
   display: flex;
   -webkit-box-pack: start;
   -ms-flex-pack: start;
   justify-content: flex-start;
}

ul.stepper:not(.horizontal) .step-actions .btn:not(:last-child), ul.stepper:not(.horizontal) .step-actions .btn-flat:not(:last-child), ul.stepper:not(.horizontal) .step-actions .btn-large:not(:last-child) {
   margin-right:5px;
}

ul.stepper.horizontal .step-actions .btn:not(:last-child), ul.stepper.horizontal .step-actions .btn-flat:not(:last-child), ul.stepper.horizontal .step-actions .btn-large:not(:last-child) {
   margin-left:5px;
}

ul.stepper.horizontal .step-actions {
   position: absolute;
   bottom: 0;
   left: 0;
   width: 100%;
   padding: 20px;
   background-color: #fff;
   -webkit-box-orient: horizontal;
   -webkit-box-direction: reverse;
   -ms-flex-direction: row-reverse;
   flex-direction: row-reverse;
}

.card-content ul.stepper.horizontal .step-actions {
   padding-left: 40px;
   padding-right: 40px;
}

ul.stepper .step-content .row {
   margin-bottom: 7px;
}
.step-content .form, .step-content .with-forms{
  	margin-bottom:20px;
  }
  .step-content .form input, .step-content .with-forms input{
  	margin-bottom:0px;
  }

.next-step:hover {
    color: #fff;
    }
 .content {
  flex: 1 0 auto;
}

/*Handle the CHROME yellow background for autofill*/
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus input:-webkit-autofill,
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
  border: none !important;
  -webkit-text-fill-color: inherit !important;
  -webkit-box-shadow: 0 0 0px 1000px #FFFFFF inset;
  transition: background-color 5000s ease-in-out 0s;
}

svg:not(:root),
svg {
  display: block;
  overflow:auto;
}


/* Icons */
.material-icons.md-18 {
  font-size: 18px;
}
.material-icons.md-24 {
  font-size: 24px;
}
.material-icons.md-36 {
  font-size: 36px;
}
.material-icons.md-48 {
  font-size: 48px;
}
/* Rules for using icons as black on a light background. */
.material-icons.md-dark {
  color: rgba(0, 0, 0, 0.54);
}
.material-icons.md-dark.md-inactive {
  color: rgba(0, 0, 0, 0.26);
}
/* Rules for using icons as white on a dark background. */
.material-icons.md-light {
  color: rgba(255, 255, 255, 1);
}
.material-icons.md-light.md-inactive {
  color: rgba(255, 255, 255, 0.3);
}

/*Helpers*/
.no-pad {
  padding: 0 !important;
}

/*Scroll bars*/

::-webkit-scrollbar {
  width: 3px;
  height: 2px;
}

::-webkit-scrollbar-button {
  width: 3px;
  height: 2px;
}

::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.54);
  border: 3px none rgba(0, 0, 0, 0.54);
  border-radius: 1px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(0, 0, 0, 0.64);
}

::-webkit-scrollbar-thumb:active {
  background: rgba(0, 0, 0, 0.54);
}

::-webkit-scrollbar-track {
  background: #fff;
  border: 2px none #fff;
  border-radius: 1px;
}

::-webkit-scrollbar-track:hover {
  background: #fff;
}

::-webkit-scrollbar-track:active {
  background: #fff;
}

::-webkit-scrollbar-corner {
  background: transparent;
}



.drag-target {
  z-index: 997 !important;
}

.dark-1 {
  background-color: #000000;
}

.dark-2 {
  background-color: #212121;
}

.dark-3 {
  background-color: #303030;
}

.dark-4 {
  background-color: #424242;
}

.light-1 {
  background-color: #E0E0E0;
}

.light-2 {
  background-color: #F5F5F5;
}

.light-3 {
  background-color: #FAFAFA;
}

.light-4 {
  background-color: #FFFFFF;
}

.primary-500 {
  background-color: #cddc39;
}

.primary-50 {
  background-color: #f9fbe7;
}

.primary-100 {
  background-color: #f0f4c3;
}

.primary-700 {
  background-color: #afb42b;
}

.accent-50 {
  background-color: #e0f7fa;
}

.accent-A100 {
  background-color: #84ffff;
}

.accent-A200 {
  background-color: #18ffff;
}

.accent-A400 {
  background-color: #00e5ff;
}

.warn-500 {
  background-color: #ff5722;
}

.warn-100 {
  background-color: #ffccbc;
}

.warn-700 {
  background-color: #e64a19;
}

.dropdown-content {
  overflow: visible !important;
  background-color: #e5e5e5 !important;
  margin-top: -4px !important;
}

.dropdown-content.sub-menu {
  margin-top: -0.3rem;
}

.button-collapse {
  width: 64px;
  text-align: -webkit-center;
}

a.button-collapse:hover {
  background: rgba(0, 0, 0, 0.13);
  border-radius: 50%;
}
.previous-step {
    background: #efefef !important;
    border-radius: 3px !important;
    border: 1px solid !important;
}
.next-step {
    background-color: #274abb !important;
    color: #fff !important;
    border-radius: 3px !important;
}
span.appcation_submission_err {
    color: red;
    font-size: 10px;
}
</style>

<?php
get_footer();
?>
<script>
 
  jQuery(document).ready(function() {
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
								$('.modal').modal({
						           dismissible: true
					            }); 
						        $('#agent_assign_popup').modal('open');
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
									$('.modal').modal({
						               dismissible: true
					                }); 
									jQuery('#finalise_property_tenant').modal('open');
									location.reload();
								 }	 
						  }
						  
				  }); 
			  
			 }
			  
		});
		
	 <?php if($application_submission) { ?>	  
		   jQuery('#submit_application_form').prop("disabled", true);
		   jQuery('#submit_application_form').val("Application Submitted");
		   jQuery('#submit_application_form').css("background","#ccd1e3");
	  <?php 
	    } 
	  ?>
	 
	 $('#submit_application_form').click(function(e){
	    e.preventDefault();
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
		
		/* if(secondary_contact_no == ''){
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
		} */
		
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
		/* if(employer_school == ''){
			jQuery('.employer_school-err').html('<span class="error">Please enter employer/school</span>');
			jQuery( ".employer_school" ).focus();
			is_error = true;		
		} */
		/* if(address == ''){
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
		} */
		if(typeof privacy_policy == 'undefined'){
			jQuery('.privacy_policy-err').html('<span class="error">Please check privacy policy before Submission</span>');
			jQuery( ".privacy_policy" ).focus();
			is_error = true;		
		}
		if(is_error == false){
		   jQuery('.loading').show();
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
				     if(response == "success"){
					 
					    jQuery('.loading').hide();
						$('.applcation-submison-success-popup').html('Application Submitted Successfully');
						$('.modal').modal({
						    dismissible: true
					      }); 
						$('#applcation_submison_success_popup').modal('open');
						jQuery('#submit_application_form').prop("disabled", true);
						jQuery('#submit_application_form').css("background","#ccd1e3");
						jQuery('#submit_application_form').val("Application Submitted");
						setTimeout(function(){
						    window.location.reload();
                        }, 2000);
						
					 }
				}
			});
			
			
			
		   
		}
		
		
		
	
		
	 
	 });
	 
	 
	 
     $("#dealdetail-tenant-paynowb").click(function(e){
	    e.preventDefault();
	    var consent_aggrement = $("input[name=check_consents_terms]:checked").val();
		if(typeof consent_aggrement == 'undefined'){
		    $('.check_consents_terms_err').html('Please check the consent agreement to continue further');
			$("input[name=check_consents_terms]").focus();
		} else {
		      <?php 
			    if(!$application_submission){
			  ?>
			      $('.appcation_submission_err').html('Please Submit The Application Form in the Previous Step Before Payment.');
			  <?php
			  } else {
			  ?>
			     //initialize all modals
 					 $('.modal').modal({
						dismissible: true
					}); 

					//call the specific div (modal)
					$('#Square_payment_form_js').modal('open');
					
					
					
			  <?php
			  }
			  ?>
		     
		}
		 
		 
	 });
	 
	  $("input[name=check_consents_terms]").click(function(){
	   if($(this).prop('checked') == true){
	      $('.check_consents_terms_err').html('');
	   }
	 });
	 
	 $('.Square_payment_form_js').click(function(){
	     $('#Square_payment_form_js').modal('close');
	 });
	 
	 $('.applcation_submison_success_popup').click(function(){
	     $('#applcation_submison_success_popup').modal('close');
	 });
	 
	 $('.square_payment_success_popup').click(function(){
	     $('#square_payment_success_popup').modal('close');
	 });
	 
	 $('.agent_assign_popup').click(function(){
	     $('#agent_assign_popup').modal('close');
	 });
	 
	 $('.finalise_property_tenant').click(function(){
	     $('#finalise_property_tenant').modal('close');
	 });
	  
	 $('.applcation_docs_tenant_popup').click(function(){
	     $('#applcation_docs_tenant_popup').modal('close');
	 });
	 
	 $('.applcation_docs_tenant_delete_popup').click(function(){
	     $('#applcation_docs_tenant_delete_popup').modal('close');
	 });
	 
	  
		
	});

</script>

<!--script src="https://code.jquery.com/jquery-2.1.1.min.js"></script-->
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/jquery.validate.min.js"></script>
<!--script type="text/javascript" src="<?php //echo get_stylesheet_directory_uri(); ?>/scripts/prism.min.js"></script-->


<script type="text/javascript">

var validation = $.isFunction($.fn.valid) ? 1 : 0;

$.fn.isValid = function() {
  if (validation) {
    return this.valid();
  } else {
    return true;
  }
};

if (validation) {
  $.validator.setDefaults({
    errorClass: 'invalid',
    validClass: "valid",
    errorPlacement: function(error, element) {
      if (element.is(':radio') || element.is(':checkbox')) { // Input checkboxes or radio, maybe switches?
        error.insertBefore($(element).parent());
      } else {
        error.insertAfter(element); // default error placement.
        // element.closest('label').data('error', error);
        // element.next().attr('data-error', error);
      }
    },
    success: function(element) {
      if (!$(element).closest('li').find('label.invalid:not(:empty)').length) {
        $(element).closest('li').removeClass('wrong');
      }
    }
  });
}

$.fn.getActiveStep = function() {
  active = this.find('.step.active');
  return $(this.children('.step:visible')).index($(active)) + 1;
};

$.fn.activateStep = function() {
  $(this).addClass("step").stop().slideDown(function() {
    $(this).css({
      'height': 'auto',
      'margin-bottom': ''
    });
  });
};

$.fn.deactivateStep = function() {
  $(this).removeClass("step").stop().slideUp(function() {
    $(this).css({
      'height': 'auto',
      'margin-bottom': '10px'
    });
  });
};

$.fn.showError = function(error) {
  if (validation) {
    name = this.attr('name');
    form = this.closest('form'); // Change if not using FORM elements
    var obj = {};
    obj[name] = error;
    form.validate().showErrors(obj);
    this.closest('li').addClass('wrong');
  } else {
    this.removeClass('valid').addClass('invalid');
    this.next().attr('data-error', error);
  }
};


$.fn.resetStepper = function(step) {
  if (!step) step = 1;
  form = $(this).closest('form'); // Change if not using FORM elements
  $(form)[0].reset();
  Materialize.updateTextFields();
  return $(this).openStep(step);
};

$.fn.submitStepper = function(step) {
  form = this.closest('form'); // Change if not using FORM elements
  if (form.isValid()) {
    form.submit();
  }
};

$.fn.nextStep = function(ignorefb) {
  stepper = this;
  form = this.closest('form');
  active = this.find('.step.active');
  next = $(this.children('.step:visible')).index($(active)) + 2;
  feedback = $(active.find('.step-content').find('.step-actions').find('.next-step')).data("feedback");
  if (form.isValid()) {
    if (feedback && ignorefb) {
      stepper.activateFeedback();
      return window[feedback].call();
    }
    active.removeClass('wrong').addClass('done');
    this.openStep(next);
    return this.trigger('nextstep');
  } else {
    return active.removeClass('done').addClass('wrong');
  }
};

$.fn.prevStep = function() {
  active = this.find('.step.active');
  prev = $(this.children('.step:visible')).index($(active));
  active.removeClass('wrong');
  this.openStep(prev);
  return this.trigger('prevstep');
};

$.fn.openStep = function(step, callback) {
  $this = this;
  step_num = step - 1;
  step = this.find('.step:visible:eq(' + step_num + ')');
  if (step.hasClass('active')) return;
  active = this.find('.step.active');
  prev_active = next = $(this.children('.step:visible')).index($(active));
  order = step_num > prev_active ? 1 : 0;
  if (active.hasClass('feedbacking')) $this.destroyFeedback();
  active.closeAction(order);
  step.openAction(order, function() {
    $this.trigger('stepchange').trigger('step' + (step_num + 1));
    if (step.data('event')) $this.trigger(step.data('event'));
    if (callback) callback();
  });
};

$.fn.closeAction = function(order, callback) {
  closable = this.removeClass('active').find('.step-content');
  if (!this.closest('ul').hasClass('horizontal')) {
    closable.stop().slideUp(300, "easeOutQuad", callback);
  } else {
    if (order == 1) {
      closable.animate({
        left: '-100%'
      }, function() {
        closable.css({
          display: 'none',
          left: '0%'
        }, callback);
      });
    } else {
      closable.animate({
        left: '100%'
      }, function() {
        closable.css({
          display: 'none',
          left: '0%'
        }, callback);
      });
    }
  }
};

$.fn.openAction = function(order, callback) {
  openable = this.removeClass('done').addClass('active').find('.step-content');
  if (!this.closest('ul').hasClass('horizontal')) {
    openable.slideDown(300, "easeOutQuad", callback);
  } else {
    if (order == 1) {
      openable.css({
        left: '100%',
        display: 'block'
      }).animate({
        left: '0%'
      }, callback);
    } else {
      openable.css({
        left: '-100%',
        display: 'block'
      }).animate({
        left: '0%'
      }, callback);
    }
  }
};

$.fn.activateStepper = function() {
  $(this).each(function() {
    var $stepper = $(this);
    if (!$stepper.parents("form").length) {
      method = $stepper.data('method');
      action = $stepper.data('action');
      method = (method ? method : "GET");
      action = (action ? action : "?");
      $stepper.wrap('<form action="' + action + '" method="' + method + '"></div>');
    }
    $stepper.find('li.step.active').openAction(1);

    $stepper.on("click", '.step:not(.active)', function() {
      object = $($stepper.children('.step:visible')).index($(this));
      if (!$stepper.hasClass('linear')) {
        $stepper.openStep(object + 1);
      } else {
        active = $stepper.find('.step.active');
        if ($($stepper.children('.step:visible')).index($(active)) + 1 == object) {
          $stepper.nextStep(true);
        } else if ($($stepper.children('.step:visible')).index($(active)) - 1 == object) {
          $stepper.prevStep();
        }
      }
    }).on("click", '.next-step', function(e) {
      e.preventDefault();
      $stepper.nextStep(true);
    }).on("click", '.previous-step', function(e) {
      e.preventDefault();
      $stepper.prevStep();
      // May want to ammend to 'a' tag for R purposes or more than likely use an ID selector
      // for shiny observer purposes... so for R if the action button for submissions was 
      // `input$form_step_submit`:
      //}).on("click", "#form_step_submit", function(e) { 
    }).on("click", "button:submit:not(.next-step, .previous-step)", function(e) {
      e.preventDefault();
      form = $stepper.closest('form');
      if (form.isValid()) {
        form.submit();
      }
    });
  });
};
 
jQuery(document).ready(function() {
  $('ul.tabs').tabs()
  $('.rt-select').material_select();
  //Init for stepper
  $('.stepper').activateStepper();
  //$(selector).nextStep();

});
</script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/dropzone.js"></script>
<script>
 var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
 var deal_id = '<?php echo $dealid; ?>';
Dropzone.autoDiscover = false;		
jQuery(".dropzone").dropzone({
	dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
	addRemoveLinks: true,
	init: function() { 
			myDropzoneFiles = this; 		
			jQuery.ajax({
			  type: 'post',
			  dataType: 'json',
			  url: ajaxurl,
			  data: {action:'nyc_get_existing_doc_tenant_ajax',deal_id:deal_id},
			  success: function(response){
			          console.log(response);
				   $.each(response, function(key,value) {
                          if(value.size != false){
						  
						     var mockFile = { name: value.name, size: value.size };
							 var extension = value.name.substr( (value.name.lastIndexOf('.') +1) );
							 if(extension == 'jpg' || extension == 'png' || extension == 'gif' ){
								  myDropzoneFiles.emit("addedfile", mockFile);
								  myDropzoneFiles.emit("thumbnail", mockFile, value.path);
								  myDropzoneFiles.emit("complete", mockFile);
							 } else {
							      myDropzoneFiles.emit("addedfile", mockFile);
								  myDropzoneFiles.emit("complete", mockFile);
							 }
							  
							  
						  }
						 
				  }); 

			  }
			 });
			 
   },
   removedfile: function(file) {
     var file_name    = file.name; 
	   jQuery.ajax({
			  type: 'post',
			  url: ajaxurl,
			  data: {action:'nyc_delete_existing_doc_tenant_ajax',deal_id:deal_id,file_name:file_name},
			  success: function(response){
                     if(response == "success"){
					    jQuery('.applcation-docs-tenant-delete-popup h3').html('Documents Removed successfully.</h3>');
						$('.modal').modal({
						dismissible: true
					    }); 
						jQuery('#applcation_docs_tenant_delete_popup').modal('open');
					    setTimeout(function() {
							window.location.reload();
						}, 1000);
							
					 }
			  }
	  });
	var _ref;
	return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0; 
	
   }
   
});	

jQuery(document).ready(function($) {
   jQuery(".save_tenant_doc").click(function(e){
      e.preventDefault();
	  $(this).prop('disabled',true);
	  var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	  var deal_id = '<?php echo $dealid; ?>';
	  var tenant_docs = $('.dropzone.dropzone_tenant_documents')[0].dropzone.getAcceptedFiles();
	  jQuery('.loading').show();
	  var form_data = new FormData();
      form_data.append("deal_id", deal_id); 
	  var tenant_docs_all =[];
			for(var i = 0;i<tenant_docs.length;i++){
				form_data.append("doc_tenant_"+i, tenant_docs[i]);
				tenant_docs_all.push("doc_tenant_"+i);
	        }
		
	   form_data.append("tenant_docs_all", tenant_docs_all);
	   form_data.append( "action" , 'nyc_upload_tenant_docs');	
			 jQuery.ajax({
				type : "post",
				url : ajaxurl,
				data: form_data,
				processData: false,
				contentType: false,
				success: function(response) {
				        if(response == "success"){
					      jQuery('.loading').hide();
						  jQuery('.applcation-docs-tenant-popup h3').html('Documents uploaded successfully.</h3>');
						  $('.modal').modal({
						     dismissible: true
					      }); 
					      jQuery('#applcation_docs_tenant_popup').modal('open');
						  setTimeout(function() {
								window.location.reload();
							}, 3000);
					   }
				}
			});
	   
			
			
       
   });
});


</script>

