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

$agent_notes = '';
if(isset($_POST['save_notes'])){
  update_post_meta($_POST['deal_id'],'agent_notes',$_POST['summary']);
  $agent_notes = "Notes saved successfully";
}
$agent_saved_notes  =  get_post_meta($dealid,'agent_notes',true);
$successorder = '';
if(isset($_POST['deal_ordersubmit'])){
   $deal_id = $_POST['deal_id'];
          $deal_id                   =   $_POST['deal_id'];
		  $email_teanant             =   get_post_meta($dealid,'email',true);
	      $payment_id                =   md5(uniqid(uniqid(uniqid())));
		  $payment_created_at        =   $_POST['deal_order_date'] .' '.$_POST['deal_order_time'];
		  $paymentamount             =   $_POST['deal_order_price'];
		  $paymentcurrency           =   'USD';
		  $paymentstatus             =   'COMPLETED';
		  $payment_source_type       =   'CASH';
		  $order_id                  =    md5(uniqid(uniqid()));
          $dealorderid = wp_insert_post(array (
								'post_type'		=> 'dealsorders',
								'post_title' 	=> '#'.$order_id,
								'post_content' 	=> 'New Order Created',
								'post_author' 	=> 1,
								'post_status' 	=> 'publish',
		                  ));
		  
		  if($dealorderid){
		     add_post_meta($dealorderid, 'deal_id', $deal_id);
			 add_post_meta($dealorderid, 'email_teanant', $email_teanant);
			 add_post_meta($dealorderid, 'payment_id', $payment_id);
			 add_post_meta($dealorderid, 'payment_created_at', $payment_created_at);
			 add_post_meta($dealorderid, 'payment_amount', $paymentamount);
			 add_post_meta($dealorderid, 'payment_currency', $paymentcurrency);
			 add_post_meta($dealorderid, 'payment_status', $paymentstatus);
			 add_post_meta($dealorderid, 'payment_source_type', $payment_source_type);
			 add_post_meta($dealorderid, 'order_id', $order_id);
			 add_post_meta($dealorderid, 'payment_mode', 'Cash_payment');
			$subject = "New payment created on deal no -".$deal_id;
			$to = get_option('admin_email');
			$msg  = __( 'Hello Admin,') . "\r\n\r\n";
			$msg .= sprintf( __("<p>New Payment has been created on deal no. %s with Following Order Id : %s via Square Payment Gateway <p><p>Following are Details of Payment order.</p>"),$deal_id,$order_id);
			$msg .= sprintf( __("<p>Deal No. : %s</p>"),$deal_id);
			$msg .= "<p>Admin Deal link : <a href='".get_site_url()."/admin/deals/details/".$deal_id."'>". get_site_url() ."/admin/deals/details/".$deal_id."</a></p>";
			$msg .= sprintf( __("<p>Tenant Email : %s</p>"),$email_teanant);
			$msg .= sprintf( __("<p>Payment ID : %s</p>"),$payment_id);
			$msg .= sprintf( __("<p>Order Id  : %s</p>"),$order_id);
			$msg .= sprintf( __("<p>payment created on : %s</p>"),$payment_created_at);
			$msg .= sprintf( __("<p>Payment Amount : %s</p>"),$paymentamount);
			$msg .= sprintf( __("<p>Payment Currency : %s</p>"),$paymentcurrency);
			$msg .= sprintf( __("<p>Payment Status : %s</p>"),$paymentstatus);
			$msg .= sprintf( __("<p>Payment Source Type : %s</p>"),$payment_source_type);
			$msg .= sprintf( __("<p>Payment Mode : %s</p>"),'Cash Payment');
			$msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
			$headers = array('Content-Type: text/html; charset=UTF-8');
		    $sent = wp_mail($to, $subject, $msg,$headers);
			$successorder = "Order Successfully Created";
			
		  }
		  
  
}

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
									?>in
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
                <?php } ?>
				<div class="col-md-12">
					<?php if($lead_source == "Appointment Form" || $lead_source == "Custom Deal"){ ?>
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
										<span><?php echo get_the_date('l F j, Y',$dealid); ?></span>
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
					<div class="dealdetail-agent-addnotes">
						<h3>Agent Notes:</h3>
						<form method="post">
						<input type="hidden" name="deal_id" value="<?= $dealid ?>">
						<textarea class="WYSIWYG" name="summary" cols="40" rows="3" id="summary" spellcheck="true"><?php if($agent_saved_notes){echo $agent_saved_notes;}?></textarea>
						<input type="submit" name="save_notes" value="Save notes">
						</form>
					</div>
				</div>

				<div class="col-md-12">
					<div class="deal-detail-payment-tobedone">
						<?php if($deal_price): ?><h3>Amount to be Paid: <span>$<?= $deal_price ?></span></h3> <?php endif;  ?>
						<ul class="dealdetail-tenant-actionbuttons dealdetail-agent-actionbuttons">
							<li>
							<?php if(empty($check_deal_orders->posts)){ ?>
								<button class="dealdetail-tenant-paynowb" data-toggle="modal" data-target="#agentlogpayment">Log Payment</button>
							 <?php } else { ?>
							  <button class="dealdetail-tenant-paynowb" disabled>Payment Done</button>
							 <?php
							 }
							 ?>
							</li>
							<li>
							    <?php if(empty($check_deal_orders->posts)){ ?>
								<button class="dealdetail-tenant-reqagentb" data-toggle="modal" data-target="#send_payment_link_by_agent" >Send Payment Link</button>
								<?php 
								}
								?>
							</li>
						</ul>
					</div>
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

			<div class="deal-detail__suggestedpropertysec">
				<h3>Selected Properties</h3>
				<ul class='nyc_deal_selected_property_section'>
				
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
									<input type="text" placeholder="Enter Property Name" id="search_name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-4">
									<select data-placeholder="Any Status" id="search_status" class="chosen-select-no-single" >
										<option value="">Any Status</option>	
										<option value="available">Available</option>
										<option value="rented">Rented</option>
									</select>
								</div>
								<div class="col-md-4">
									<select data-placeholder="Any Type" id="search_type" class="chosen-select-no-single" >
										<option value="">Any Type</option>	
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
								</div>
								<div class="col-md-4">
									<select data-placeholder="Any Status" id="search_accom" class="chosen-select-no-single" >
										<option value="">Type of Accomodation</option>	
										<option value="Apartment">Apartment</option>
										<option value="Room">Room</option>
									</select>
								</div>
							</div>
							<!-- Row With Forms / End -->	
							

							<!-- Row With Forms -->
							<div class="row with-forms">

								<div class="col-md-4">
									<select data-placeholder="Any Status" id="search_rooms" class="chosen-select-no-single" >
										<option value="">Rooms</option>	
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="5+">More than 5</option>
									</select>
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" id="search_min_price" placeholder="Min Price" data-unit="USD">
										<select>		
											<option>Min Price</option>
											<option>1000</option>
											<option>2000</option>	
											<option>3000</option>	
											<option>4000</option>	
											<option>5000</option>	
											<option>10000</option>	
											<option>15000</option>	
											<option>20000</option>	
											<option>30000</option>
											<option>40000</option>
											<option>50000</option>
											<option>60000</option>
											<option>70000</option>
											<option>80000</option>
											<option>90000</option>
											<option>100000</option>
											<option>110000</option>
											<option>120000</option>
											<option>130000</option>
											<option>140000</option>
											<option>150000</option>
										</select>
									</div>
									<!-- Select Input / End -->
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" id="search_max_price" placeholder="Max Price" data-unit="USD">
										<select>		
											<option>Max Price</option>
											<option>1000</option>
											<option>2000</option>	
											<option>3000</option>	
											<option>4000</option>	
											<option>5000</option>	
											<option>10000</option>	
											<option>15000</option>	
											<option>20000</option>	
											<option>30000</option>
											<option>40000</option>
											<option>50000</option>
											<option>60000</option>
											<option>70000</option>
											<option>80000</option>
											<option>90000</option>
											<option>100000</option>
											<option>110000</option>
											<option>120000</option>
											<option>130000</option>
											<option>140000</option>
											<option>150000</option>
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


<!-- Modal for Agent Log payment -->
<div class="modal fade popup-main--section" id="agentlogpayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form method="post">
      <div class="modal-body">
        <div class="fillamount-popup">
        	<h3>Fill Amount Details</h3>
 			<ul>
 				<li>
 					<h5>Price <i class="tip" data-tip-content="Type overall or monthly price if property is for rent"></i></h5>
					<div class="select-input disabled-first-option">
						<input type="text" data-unit="USD" value="<?= $deal_price ?>" name="deal_order_price">
					</div>
 				</li>
 				<li>
 					<h5>Date</h5>
 					<input class="search-field" type="date"  name="deal_order_date"/>
 				</li>
 				<li>
 					<h5>Time</h5>
 					<input class="search-field" type="time" name="deal_order_time"/>
					<input type="hidden" name="deal_id" value="<?= $dealid ?>">
 				</li>
 			</ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-secondary dealdetail-popupsub" name="deal_ordersubmit">Submit</button>
      </div>
	  </form>
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

<div class="modal fade popup-main--section" id="modal_agent_notes_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="dealsend-popup">
        	<h3><?= $agent_notes ?></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="send_payment_link_by_agent" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="send-payment-link-by-agent">
		<h5>Select an option for send payment link</h5>
        	<select name="send_message_opt">
			    <option value="">Choose an option</option>
				<option value="send_as_email">Send As Email</option>
				<option value="send_as_text">Send As Text</option>
			</select>
			
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="button send_message_tenant">Send</button>
      </div>
    </div>
  </div>
</div>

<!--Modal for Contact Details -->
<div class="modal fade popup-main--section" id="selected_property_popup_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="dealsend-popup-message">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade popup-main--section" id="modal_agent_order_deal_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="modal-agent-order-deal-popup">
        	<h3><?= $successorder ?></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	// This is required for AJAX to work on our page
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	var deal_id = '<?php echo $dealid; ?>';
	
	function cvf_load_all_posts(page){ 
		var data = {
			page: page,
			deal_id: deal_id,
			action: "demo-pagination-load-posts"
		};

		$.post(ajaxurl, data, function(response) {
			$(".nyc_load_property").html(response);
		});
	}	
	
	function nyc_load_selcted_property(){
		var data = {
			deal_id: deal_id,
			action: "nyc_load_selcted_property"
		};
		$.post(ajaxurl, data, function(response) {
			$(".nyc_deal_selected_property_section").html(response);
		});
	}
	
	cvf_load_all_posts(1);
	nyc_load_selcted_property();
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
				cvf_load_all_posts(1);
				nyc_load_selcted_property();				
				jQuery('.dealsend-popup h3').html('Property Selected Successfully');
				jQuery('#selected_property_popup').modal('show');			
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
				 nyc_load_selcted_property();
			});
	});
	$(".desellect-sellectedproperty").live('click',function(){
		jQuery(this).parent().addClass('selected-property-none'); 
	});	
	
	$('.deal_search_property').live('click',function(e){
			jQuery('.loading').show();
			var search_name = jQuery('#search_name').val();
			var search_status = jQuery('#search_status').val();
			var search_type = jQuery('#search_type').val();
			var search_accom = jQuery('#search_accom').val();
			var search_rooms = jQuery('#search_rooms').val();
			var search_min_price = jQuery('#search_min_price').val();
			var search_max_price = jQuery('#search_max_price').val();
			var data = {
				page: 1,
				deal_id: deal_id,
				search_name: search_name,
				search_status: search_status,
				search_type: search_type,
				search_accom: search_accom,
				search_rooms: search_rooms,
				search_min_price: search_min_price,
				search_max_price: search_max_price,
				action: "demo-pagination-load-posts"
			};

			// Send the data
			$.post(ajaxurl, data, function(response) {
				// If successful Append the data into our html container
				$(".nyc_load_property").html(response);
				jQuery('.loading').hide();
			}); 
	});	
	
	$('.send_message_tenant').live('click',function(e){
	   var optionval = $('select[name="send_message_opt"]').val();
	   if(optionval == ""){
	      alert("please choose an option to send Payment Link");
	   } else {
	       if(optionval == "send_as_email"){
		        jQuery('#send_payment_link_by_agent').modal('hide');
				jQuery('.loading').show();
				var data = {
					deal_id: deal_id,
					action: "nyc-deal-send-email",
				};
				$.post(ajaxurl, data, function(response) {
					jQuery('.loading').hide();
					jQuery('.dealsend-popup-message h3').html('Email sent successfully');
					jQuery('#selected_property_popup_message').modal('show');
				});
				
		   }
		   
		   if(optionval == "send_as_text"){
		        jQuery('#send_payment_link_by_agent').modal('hide');
				jQuery('.loading').show();
				var data = {
					deal_id: deal_id,
					action: "nyc-deal-send-sms",
				};
				var html='';
				$.post(ajaxurl, data, function(response) {
					var response = JSON.parse(response);
					if(response.tenant_status == true){
						html += "SMS sent successfully to tenant.</br>";
					}else{
						html += response.tenant_error;
					}
					if(response.agent_allowed== true){
						if(response.agent_status == true){
							html += "SMS sent successfully to agent.</br>";
						}else{
							html += response.agent_error;
						}
					}
					jQuery('.loading').hide();
					jQuery('.dealsend-popup-message h3').html(html);
					jQuery('#selected_property_popup_message').modal('show');
				});
				
		   }
		   
		   
	   }
	   
	});
	
	
	
	
});
</script>
<?php
get_footer();

if(!empty($agent_notes)){
   echo "<script>
         jQuery(window).load(function(){
             $('#modal_agent_notes_popup').modal('show');
         });
    </script>";
}


if(!empty($successorder)){
   echo "<script>
         jQuery(window).load(function(){
             $('#modal_agent_order_deal_popup').modal('show');
         });
    </script>";
}
?>