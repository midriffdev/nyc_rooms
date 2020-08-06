<?php
/* Template Name: Admin Add New Lead */
$usersuccess = '';
nyc_property_admin_authority();

$args = array(
         'post_type'        => 'property',
		 'post_status'       => 'available',
         'posts_per_page'   => -1,
         //'no_found_rows'    => true,
         'suppress_filters' => false,
        );
$properties = new WP_Query( $args );
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
			add_post_meta($lead_id, 'lead_datetime', strtotime($_POST['date'] . ' '.$_POST['time']));
			add_post_meta($lead_id, 'lead_summary', $_POST['guest_summary']);
			if(!empty($_POST['properties_leads']) && $_POST['lead_source'] == 'Property Form'){
			
				add_post_meta($lead_id, 'lead_checkout_property', $_POST['properties_leads']);
				add_post_meta($lead_id, 'lead_checkout_property_name', get_the_title($_POST['properties_leads']));
				add_post_meta($lead_id, 'lead_checkt_prp_owner', get_post_meta($_POST['properties_leads'],'contact_name',true));
				add_post_meta($lead_id, 'lead_chckt_prp_owner_email', get_post_meta($_POST['properties_leads'],'contact_email',true));
				
			}
			if(!empty($_POST['lead_source'])){
			    add_post_meta($lead_id, 'lead_source',$_POST['lead_source']);
			} else {
			    add_post_meta($lead_id, 'lead_source','Custom Deal');
			}
			
			add_post_meta($lead_id, 'lead_created_from', 'admin' );
			add_post_meta($lead_id, 'lead_created_user_id',get_current_user_id());
			$notification = "A new lead submission by admin";
		    nyc_add_noticication($notification);
            $success_msg = "Lead Created Sucessfully!!";
		 }
   
}
get_header();
?>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<!-- Titlebar
================================================== -->


<!-- Content
================================================== -->
<div class="container">
	<div class="row">
         <!-- Widget -->
		 <?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">
                <p style="color:#274abb"><a href="<?= site_url().'/admin/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To DashBoard</a></p>
			<div class="admin-teanent-account-details">
				<div class="row">
					<div class="col-md-12">
						<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Add New Lead</h4>
					</div>
				</div>
				<div class="row">
				        <form method="post" class="guest--checkout add-new_leadform">

							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<label>Name:</label>
										<input type="text" class="input-text" name="guest_name" id="username2" required />
									</div>
									<div class="col-md-12">
										<label>Phone:</label>
										<input type="text" id="phone" name="guest_phone" required pattern="[+1]{2}[0-9]{10}"  oninvalid="setCustomValidity('Please Enter Valid No With Country Code +1.')" onchange="try{setCustomValidity('')}catch(e){}" maxlength="12" required>
									</div>
									<div class="col-md-12">
										<label for="date">Date*:</label>
        				                <input type="date" name="date" value="<?php echo date("Y-m-d"); ?>" required>
									</div>
									<div class="col-md-12">
										<label >Descprition:</label>
										<textarea class="WYSIWYG" name="guest_summary" id="summary" spellcheck="true" required></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-12">
										<label>Email Address:</label>
										<input type="email" class="input-text" name="guest_email" id="email2" required />
									</div>
									<div class="col-md-12">
										<label>Select Property:</label>
										<select name="properties_leads">
										<option value="">Select Property</option>
										<?php
										foreach($properties->posts as $properties){
										?>
										<option value="<?=$properties->ID ?>"><?= $properties->post_title ?></option>
										<?php
										}
										?>
										</select>
									</div>
									<div class="col-md-12">
										<label for="time">Time*:</label>
        				                <input type="time" name="time" value="<?php echo date("H:i"); ?>" required>
									</div>
									<div class="col-md-12">
										<label >Select Lead Source:</label>
										<select name="lead_source">
											<option value="">Select Lead Source</option>
											<option value="Appointment Form">Appointment Form</option>
											<option value="Property Form">Property Form</option>
										</select>
									</div>
								</div>
							</div>
						    
							<div class="col-md-12">
								<input type="submit" class="button border fw margin-top-10" name="guest_checkout" value="Submit" />
							</div>
				        </form>
				
				</div>
			</div>

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>
		  <?php		
		    if($success_msg){
	          echo $success_msg; 
			} 
		    ?>
		  </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- Wrapper / End -->

<?php
get_footer();
if(!empty($success_msg)){
   echo "<script>
         jQuery(window).load(function(){
             $('#myModal').modal('show');
         });
    </script>";
}
?>