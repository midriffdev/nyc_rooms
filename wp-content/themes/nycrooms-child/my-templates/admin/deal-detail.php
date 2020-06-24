<?php
nyc_property_admin_authority();
$post_id = get_query_var( 'id' ); 
$post = get_post($post_id);
if(empty($post) || ($post->post_type != 'deals')){
	wp_redirect(get_site_url().'/admin/deals'); 
}
get_header();
$deal_stage = get_post_meta($post_id,'deal_stage',true);
$lead_source = get_post_meta($post_id,'lead_source',true);
$name = get_post_meta($post_id,'name',true);
$email = get_post_meta($post_id,'email',true);
$phone = get_post_meta($post_id,'phone',true);
$description = get_post_meta($post_id,'description',true);
$property_id = get_post_meta($post_id,'property_id',true);
$deal_agent = get_post_meta($post_id,'deal_agent',true);
$tenant_application = get_post_meta($post_id,'tenant_application',true);
$payment_status = get_post_meta($post_id,'payment_status',true);
if(isset($_POST['upadte_stag1'])){
	update_post_meta($post_id,'deal_price',$_POST['deal_price']);
	update_post_meta($post_id,'admin_notes',$_POST['admin_notes']);
}
$deal_price = get_post_meta($post_id,'deal_price',true);
$admin_notes = get_post_meta($post_id,'admin_notes',true);
$selected_property = get_post_meta($post_id, 'selected_property', true);
$selectedAgent = get_post_meta($post_id, 'selectedAgent', true);
?>
<!-- Wrapper -->
<style>
.cvf_pag_loading {padding: 20px;}
.cvf-universal-pagination ul {margin: 0; padding: 0;}
.cvf-universal-pagination ul li {display: inline; margin: 3px; padding: 4px 8px; background: #FFF; color: black; }
.cvf-universal-pagination ul li.active:hover {cursor: pointer; background: #1E8CBE; color: white; }
.cvf-universal-pagination ul li.inactive {background: #7E7E7E;}
.cvf-universal-pagination ul li.selected {background: #1E8CBE; color: white;}
</style>
<div id="wrapper">
<div class="deal-detail-container">		
	<div class="container">

		<div class="row deal-detail-upperunifrm-sect">
			<div class="col-md-3">
				<div class="deal-detail-stagesec">
					<h3>Select Stage</h3>
					<select data-placeholder="Any Status" class="chosen-select-no-single" >
						<option >Select Stage</option>	
						<option value="1" <?php if($deal_stage == 1){ echo "selected";} ?>>Stage 1</option>
						<option value="2" <?php if($deal_stage == 2){ echo "selected";} ?>>Stage 2</option>
						<option value="3" <?php if($deal_stage == 3){ echo "selected";} ?>>Stage 3</option>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="deal-deail-allocateagent">
					<h3>Allocate Agent</h3>
					<select data-placeholder="Any Status" id="alocateagent-select" class="chosen-select-no-single" >
						<option value='-1'>Select Agent</option>	
						<?php
						$args = array(
						 'role' => 'sales_agent',
						 'orderby' => 'user_nicename',
						 'order' => 'ASC'
						);
						 $agents = get_users($args);
						 foreach ($agents as $agent) {
						 if($selectedAgent == $agent->ID){
							$selected = "selected";
						 }else{
							$selected = "";
						 }
						 echo '<option value="'.$agent->ID.'" '.$selected.'>'.$agent->display_name.'</option>';
						 }						
						?>
					</select>
					
					<div class="allocategent-tostage">
						<p>To</p>
					<select data-placeholder="Any Status" class="chosen-select-no-single" >
						<option>Select Stage</option>	
						<option>Stage 1</option>
						<option>Stage 2</option>
						<option>Stage 3</option>
					</select>
					</div>
					
				</div>
			</div>
			<div class="col-md-6">
				<div class="dealdetal-currentstage-status">Current Status:	<span>Stage <?php echo $deal_stage; ?></span></div>
				<div class="deal-detail-uniformbutton">
					<ul>
						<li><a href="#" class="deal-send-button deal-send-email">Send as Email</a></li>
						<li><a href="#" class="deal-send-button deal-send-text" data-toggle="modal" data-target="#fillamountdetails">Send as Text</a></li>
						<li><a href="#" class="convert-to-contract button_disable">Convert to Contract</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		
        <div class="row deal-stage-2 active">
		<form action='' method="post"> 
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
			
			    <?php  if($lead_source == "Property Form"){ ?>
				
				<div class="col-md-12">
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
				?>
				<div class="col-md-6">
					<div class="dealdetail-propertydetail">
						<h2>Property Details</h2>
						<table class="manage-table responsive-table">
						<tbody>
						<!-- Item #1 -->
							<tr>
							<td class="title-container lead-detail-propertytitlesec">
							<img src="<?php echo wp_get_attachment_url(get_post_meta($property_id,'file_0',true)); ?>" alt="">
							<div class="title">
							<h4><a href="#"><?php echo get_the_title($property_id); ?></a></h4>
							<span><?php echo $address; ?></span>
							<p>Owner: <span><?php the_author_meta( 'display_name' , $authid );  ?></span></p>
							<span class="table-property-price">$<?php echo $price; ?> / Weekly</span> <span class="active--property"><?php echo ucfirst($status); ?></span>
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
										<span>December 30, 2016</span>
									</li>
									<li>
										<p>Time:</p>
										<span>9:00 AM</span>
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
				</div>
				<?php if($deal_agent){ ?>
				<div class="col-md-6">
					<div class="dealdetail-allocateagent-section">
						<h2>Agent Details</h2>
						<ul>
							<li>
								<p>Name: </p>
								<span><?php the_author_meta( 'display_name' , $authid ); ?></span>
							</li>
							<li>
								<p>Email:</p>
								<span><?php the_author_meta( 'user_email' , $authid ); ?></span>
							</li>
							<li>
								<p>Phone:</p>
								<span><?php the_author_meta( 'phone' , $authid ); ?></span>
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
					<div class="dealdetail-signapplicationform">
						<a href="#" data-toggle="modal" data-target="<?php echo ($tenant_application) ? '#signapplicationform' : ''; ?>"><h3>Application Form Status <span> <?php echo ($tenant_application) ? $tenant_application : 'Pending'; ?> <i class="fa fa-check" aria-hidden="true"></i></span></h3></a>
					</div>
				</div>

				<div class="col-md-6">
					<div class="dealdetail--selectprice">
						<h2>Select Price</h2>
						<!-- Select Input -->
						<div class="select-input disabled-first-option">
							<input type="text" name="deal_price" value="<?php echo $deal_price; ?>" placeholder="Enter Price" data-unit="USD">
							<select>		
								<option>Price</option>
								<option>100</option>
								<option>200</option>	
								<option>300</option>	
								<option>400</option>	
								<option>500</option>	
								<option>600</option>	
								<option>700</option>	
								<option>800</option>	
								<option>900</option>
								<option>1000</option>
								<option>1100</option>
								<option>1200</option>
								<option>1300</option>
							</select>							
						</div>
						<!-- Select Input / End -->
					</div>
				</div>

				<div class="col-md-6">
					<div class="deal-detail-paymentstatus">
						<h3>Payment Status
						<span><?php echo ($payment_status) ? '$payment_status' : 'Pending'; ?> <i class="fa fa-check" aria-hidden="true"></i></span></h3>
						<?php if($payment_status){ ?>
						<ul>
							<li>Paymet: <span>$300</span></li>
							<li>Date: <span>December 30, 2016</span></li>
							<li>Time: <span>9:00 AM</span></li>
						</ul>
						<?php } ?>
					</div>
				</div>

				<div class="col-md-6">
					<div class="deal-detail-adminnotes-sec">
						<h3>Admin Notes</h3>
						<textarea class="WYSIWYG" name="admin_notes" cols="40" rows="3" id="summary" spellcheck="true"><?php echo $admin_notes; ?></textarea>
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
				<div class="col-md-12 text-center">
					<button type="submit" class="button" name="upadte_stag1">Save Details</button>
				</div>
			</div>
		</div>
		</form>
        </div>
		
		<!----Stage 2---->
		<div class="row deal-stage-2">
			<div class="current-stage-title">
				<h3>Stage 2</h3>
			</div>

			<div class="deal-detail__suggestedpropertysec">
				<h3>Selected Properties</h3>
				<ul class='nyc_deal_selected_property_section'>
				<?php 
				if($selected_property){
				foreach($selected_property as $property_id){ 
				$price = get_post_meta($property_id, 'price',true);	
				?>
					<li class="selected_property-<?php echo $property_id; ?>">
						<div class="listing-item compact">
							<div class="listing-badges">
								<span class="featured">Featured</span>
								<span>For Rent</span>
							</div>
							<div class="listing-img-content">
								<span class="listing-compact-title"><?php echo get_the_title($property_id); ?> <i>$<?php echo $price; ?> / Weekly</i></span>

								<ul class="listing-hidden-content">
									<li>Rooms <span><?php echo get_post_meta($property_id,'rooms',true); ?></span></li>
								</ul>
							</div>
							<img src="<?php echo wp_get_attachment_url(get_post_meta($property_id,'file_0',true)); ?>" alt="">
						</div>
						<span class="desellect-sellectedproperty"><i class="fa fa-times selected-property-close" data-id="<?php echo $property_id; ?>" aria-hidden="true"></i></span>
					</li>
				<?php } }else { echo "<li>No selected property founds!</li>"; } ?>
				</ul>
			</div>

			<div class="deal-stage-property-suggest">
				<div class="deal-proprtysug-title">
					<h2>Suggest Property</h2>
				</div>
				<div class="admin-advanced-searchfilter">
					<h2>Advanced filter</h2>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Property Name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-4">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Any Status</option>	
										<option>Available</option>
										<option>Rented</option>
									</select>
								</div>
								<div class="col-md-4">
									<select data-placeholder="Any Type" class="chosen-select-no-single" >
										<option>Any Type</option>	
										<option>Furnished</option>
										<option>Unfurnished</option>
									</select>
								</div>
								<div class="col-md-4">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Type of Accomodation</option>	
										<option>Apartment</option>
										<option>Room</option>
									</select>
								</div>
							</div>
							<!-- Row With Forms / End -->	
							

							<!-- Row With Forms -->
							<div class="row with-forms">

								<div class="col-md-4">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Rooms</option>	
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>More than 5</option>
									</select>
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" placeholder="Min Price" data-unit="USD">
										<select>		
											<option>Min Price</option>
											<option>1 000</option>
											<option>2 000</option>	
											<option>3 000</option>	
											<option>4 000</option>	
											<option>5 000</option>	
											<option>10 000</option>	
											<option>15 000</option>	
											<option>20 000</option>	
											<option>30 000</option>
											<option>40 000</option>
											<option>50 000</option>
											<option>60 000</option>
											<option>70 000</option>
											<option>80 000</option>
											<option>90 000</option>
											<option>100 000</option>
											<option>110 000</option>
											<option>120 000</option>
											<option>130 000</option>
											<option>140 000</option>
											<option>150 000</option>
										</select>
									</div>
									<!-- Select Input / End -->
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" placeholder="Max Price" data-unit="USD">
										<select>		
											<option>Max Price</option>
											<option>1 000</option>
											<option>2 000</option>	
											<option>3 000</option>	
											<option>4 000</option>	
											<option>5 000</option>	
											<option>10 000</option>	
											<option>15 000</option>	
											<option>20 000</option>	
											<option>30 000</option>
											<option>40 000</option>
											<option>50 000</option>
											<option>60 000</option>
											<option>70 000</option>
											<option>80 000</option>
											<option>90 000</option>
											<option>100 000</option>
											<option>110 000</option>
											<option>120 000</option>
											<option>130 000</option>
											<option>140 000</option>
											<option>150 000</option>
										</select>
									</div>
									<!-- Select Input / End -->
								</div>

							</div>
							<!-- Row With Forms / End -->

							<!-- Search Button -->
							<div class="row with-forms">
								<div class="col-md-12">
									<button class="button fs-map-btn deal_search_property">Search</button>
								</div>
							</div>

						</div>
						<!-- Box / End -->
					</div>
				</div>
				<div class='nyc_load_property'>

				</div>
				<div class="create-deal-btnsec deal-detail-dealbutton">
					<button type="button" class="btn btn-primary popup__button deal_select_property">
					 Select Properties
					</button>
				</div>

			</div>

		</div>

		<!-----Stage 3------->
		<div class="row deal-stage-3">
			<div class="current-stage-title">
				<h3>Stage 3(Final)</h3>
			</div>
			<div class="deal-stage3-mainsec">
				<div class="stahe3-selectedproprtysec">
				<div class="row">
					<div class="col-md-6">
						<div class="dealdetail-propertydetail">
						<h2>Selected Property Details</h2>
						<table class="manage-table responsive-table">
						<tbody>
						<!-- Item #1 -->
							<tr>
							<td class="title-container lead-detail-propertytitlesec">
							<img src="images/listing-02.jpg" alt="">
							<div class="title">
							<h4><a href="#">Serene Uptown</a></h4>
							<span>6 Bishop Ave. Perkasie, PA </span>
							<p>Owner: <span>Teri Dactyl</span></p>
							<span class="table-property-price">$900 / monthly</span> <span class="active--property">Available</span>
							</div>
							</td>
							</tr>
						</tbody>
						</table>
						</div>
					</div>
					<div class="col-md-6">
						<h3>Add Notes</h3>
						<textarea class="WYSIWYG" name="summary" cols="40" rows="3" id="summary" spellcheck="true"></textarea>
					</div>
				</div>
				</div>
			</div>

			<div class="create-deal-btnsec deal-detail-dealbutton ">
				<button type="button" class="btn btn-primary popup__button stage3-convertdeal-but">
				 Convert Deal to Contract
				</button>
			</div>
		</div>
	</div>
</div>


<div class="margin-top-55"></div>

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


<!-- Modal for property select details -->
<div class="modal fade popup-main--section" id="stagechange-propoertyselect" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered selectproperty-stagechange-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="fillamount-popup">
        	<h3>Select Property</h3>

 			<div class="admin-advanced-searchfilter">
					<h2>Advanced filter</h2>
					<form>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Property Name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-4">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Any Status</option>	
										<option>Available</option>
										<option>Rented</option>
									</select>
								</div>
								<div class="col-md-4">
									<select data-placeholder="Any Type" class="chosen-select-no-single" >
										<option>Any Type</option>	
										<option>Furnished</option>
										<option>Unfurnished</option>
									</select>
								</div>
								<div class="col-md-4">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Type of Accomodation</option>	
										<option>Apartment</option>
										<option>Room</option>
									</select>
								</div>
							</div>
							<!-- Row With Forms / End -->	
							

							<!-- Row With Forms -->
							<div class="row with-forms">

								<div class="col-md-4">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Rooms</option>	
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>More than 5</option>
									</select>
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" placeholder="Min Price" data-unit="USD">
										<select>		
											<option>Min Price</option>
											<option>1 000</option>
											<option>2 000</option>	
											<option>3 000</option>	
											<option>4 000</option>	
											<option>5 000</option>	
											<option>10 000</option>	
											<option>15 000</option>	
											<option>20 000</option>	
											<option>30 000</option>
											<option>40 000</option>
											<option>50 000</option>
											<option>60 000</option>
											<option>70 000</option>
											<option>80 000</option>
											<option>90 000</option>
											<option>100 000</option>
											<option>110 000</option>
											<option>120 000</option>
											<option>130 000</option>
											<option>140 000</option>
											<option>150 000</option>
										</select>
									</div>
									<!-- Select Input / End -->
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" placeholder="Max Price" data-unit="USD">
										<select>		
											<option>Max Price</option>
											<option>1 000</option>
											<option>2 000</option>	
											<option>3 000</option>	
											<option>4 000</option>	
											<option>5 000</option>	
											<option>10 000</option>	
											<option>15 000</option>	
											<option>20 000</option>	
											<option>30 000</option>
											<option>40 000</option>
											<option>50 000</option>
											<option>60 000</option>
											<option>70 000</option>
											<option>80 000</option>
											<option>90 000</option>
											<option>100 000</option>
											<option>110 000</option>
											<option>120 000</option>
											<option>130 000</option>
											<option>140 000</option>
											<option>150 000</option>
										</select>
									</div>
									<!-- Select Input / End -->
								</div>

							</div>
							<!-- Row With Forms / End -->

							<!-- Search Button -->
							<div class="row with-forms">
								<div class="col-md-12">
									<button class="button fs-map-btn">Search</button>
								</div>
							</div>

						</div>
						<!-- Box / End -->
					</div>
					</form>
				</div>

				<table class="manage-table responsive-table deal-suggestproperty-table">
				<tbody>
				<tr>
					<th><i class="fa fa-check-square-o"></i> Select</th>
					<th class="deal-suggest-proptab-prop"><i class="fa fa-file-text"></i> Property</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Expiration Date</th>
					<th><i class="fa fa-user"></i> Owner</th>
					<th></th>
				</tr>

				<!-- Item #1 -->
				<tr>
					<td class="select_property"><input id="check-2" type="checkbox" name="check"></td>
					<td class="title-container">
						<img src="images/listing-02.jpg" alt="">
						<div class="title">
							<h4><a href="#">Serene Uptown</a></h4>
							<span>6 Bishop Ave. Perkasie, PA </span>
							<span class="table-property-price">$900 / monthly</span> <span class="active--property">Available</span>
						</div>
					</td>
					<td class="expire-date"></td>
					<td>
						<div class="owner--name"><a href="#">Teri Dactyl</a></div>
					</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>

				<!-- Item #2 -->
				<tr>
					<td class="select_property"><input id="check-2" type="checkbox" name="check"></td>
					<td class="title-container">
						<img src="images/listing-05.jpg" alt="">
						<div class="title">
							<h4><a href="#">Oak Tree Villas</a></h4>
							<span>71 Lower River Dr. Bronx, NY</span>
							<span class="table-property-price">$700 / monthly</span> <span class="rented--property">Rented</span>
						</div>
					</td>
					<td class="expire-date">December 12, 2016</td>
					<td>
						<div class="owner--name"><a href="#">Teri Dactyl</a></div>
					</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
				</tbody>
				</table>
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
<div class="modal fade popup-main--section" id="selected_property_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="dealsend-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
<script>
	jQuery(document).ready(function(){


	    jQuery(".desellect-sellectedproperty").click(function(){
	    	jQuery(this).parent().addClass('selected-property-none'); 
	    });
	});
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	// This is required for AJAX to work on our page
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	var deal_id = '<?php echo $post_id; ?>';

	function cvf_load_all_posts(page){
		// Data to receive from our server
		// the value in 'action' is the key that will be identified by the 'wp_ajax_' hook 
		var data = {
			page: page,
			deal_id: deal_id,
			action: "demo-pagination-load-posts"
		};

		// Send the data
		$.post(ajaxurl, data, function(response) {
			// If successful Append the data into our html container
			$(".nyc_load_property").html(response);
		});
	}

	// Load page 1 as the default
	cvf_load_all_posts(1);

	// Handle the clicks
	$('.cvf-universal-pagination li.active').live('click',function(){
		var page = $(this).attr('p');
		cvf_load_all_posts(page);
	});
	$('.deal_select_property').live('click',function(){
		var myarray = [];  
		var checkedNum = jQuery('input[class="check_property"]:checked').length;
		if(checkedNum == 0){
			alert('Please choose one or more property');
		}else{
			jQuery('input[class="check_property"]:checked').each(function(){
				myarray.push(jQuery(this).val());
			});
			var data = {
				deal_id: deal_id,
				propertyArray: myarray,
				action: "nyc-deal-select-property-assign",
			};

			// Send the data
			$.post(ajaxurl, data, function(response) {
				jQuery('.dealsend-popup h3').html('Property Selected Successfully');
				jQuery('#selected_property_popup').modal('show');
				setTimeout(function(){
				   window.location.reload();
				   // or window.location = window.location.href; 
				}, 2000);				
			});			
		}
	});
	$('.selected-property-close').live('click',function(){
			var property_id = jQuery(this).attr('data-id');
			var data = {
				deal_id: deal_id,
				property_id: property_id,
				action: "nyc-deal-remove-property-assign",
			};
			$.post(ajaxurl, data, function(response) {
				cvf_load_all_posts(1);
			});
	});
	
	$('.deal-send-email').live('click',function(e){
			e.preventDefault();
			jQuery('.loading').show();
			var data = {
				deal_id: deal_id,
				action: "nyc-deal-send-email",
			};
			$.post(ajaxurl, data, function(response) {
				jQuery('.loading').hide();
				jQuery('.dealsend-popup h3').html('Email sent successfully');
				jQuery('#selected_property_popup').modal('show');
			});
	});
	jQuery('#alocateagent-select').chosen().change(function() {
        var selectedAgent = $(this).children("option:selected").val();
		jQuery('.loading').show();
		var data = {
			deal_id: deal_id,
			selectedAgent: selectedAgent,
			action: "nyc-deal-select-agent",
		};
		$.post(ajaxurl, data, function(response) {
			jQuery('.loading').hide();
			jQuery('.dealsend-popup h3').html(response);
			jQuery('#selected_property_popup').modal('show');				
		});			
	});	
}); 
</script>
<!-- Wrapper / End -->
<?php
get_footer();
?>