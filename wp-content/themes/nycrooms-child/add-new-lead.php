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
			add_post_meta($lead_id, 'lead_summary', $_POST['guest_summary']);
			add_post_meta($lead_id, 'lead_checkout_property', $_POST['properties_leads']);
			add_post_meta($lead_id, 'lead_checkout_property_name', get_the_title($_POST['properties_leads']));
			add_post_meta($lead_id, 'lead_checkt_prp_owner', get_post_meta($_POST['properties_leads'],'contact_name',true));
			add_post_meta($lead_id, 'lead_source',$_POST['lead_source']);
			add_post_meta($lead_id, 'lead_chckt_prp_owner_email', get_post_meta($_POST['properties_leads'],'contact_email',true));
			add_post_meta($lead_id, 'lead_created_from', 'admin' );
			add_post_meta($lead_id, 'lead_created_user_id',get_current_user_id());
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
				        <form method="post" class="guest--checkout">
					        <p class="form-row form-row-wide">
								<label for="username2">Name:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="guest_name" id="username2" required />
								</label>
							</p>
						    <p class="form-row form-row-wide">
								<label for="email2">Email Address:
									<i class="im im-icon-Mail"></i>
									<input type="email" class="input-text" name="guest_email" id="email2" required />
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="password1">Phone:
									<i class="im im-icon-Phone"></i>
									<input type="text" id="phone" name="guest_phone" required pattern="[+1]{2}[0-9]{10}"  oninvalid="setCustomValidity('Please Enter Valid No With Country Code +1.')" onchange="try{setCustomValidity('')}catch(e){}" maxlength="12" required>
								</label>
							</p>

							<p class="form-row form-row-wide guest-check-descp-sec">
								<label for="password2">Select Property:
									<i class="im im-icon-Lock-2"></i>
									<select name="properties_leads" required>
									<option value=""></option>
									<?php
									foreach($properties->posts as $properties){
									 ?>
									 <option value="<?=$properties->ID ?>"><?= $properties->post_title ?></option>
									 <?php
									}
									?>
									</select>
								</label>
							</p>
							
							<p class="form-row form-row-wide guest-check-descp-sec">
								<label for="password2">Select Lead Source:
									<i class="im im-icon-Lock-2"></i>
									<select name="lead_source" required>
										 <option value="">Select Lead Source</option>
										 <option value="Appointment Form">Appointment Form</option>
										 <option value="Property Form">Property Form</option>
									</select>
								</label>
							</p>
							
							<p class="form-row form-row-wide guest-check-descp-sec">
								<label for="password2">Descprition:
									<i class="im im-icon-Lock-2"></i>
									<textarea class="WYSIWYG" name="guest_summary" id="summary" spellcheck="true" required></textarea>
								</label>
							</p>
							
							
							

							<p class="form-row">
							    
								
								<input type="submit" class="button border fw margin-top-10" name="guest_checkout" value="Submit" />
							</p>

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