<?php
/* Template Name: Admin Agent Details */
$getuser = get_user_by('id',$_GET['agentid']);
$usererror = '';
$usersuccess = '';
if(isset($_POST['add_agent'])){

	  
 
       if( $_POST['email'] != $getuser->user_email  ) {
	     
	    if(email_exists( $_POST['email'] )){
            $usererror ="Sorry!! Email Already Exists";
		} else {
	  
	  
	        $user_data = wp_update_user( 
		            array(
					       'ID' => $getuser->ID, 
		                   'user_email' => $_POST['email'],
						   'display_name' => $_POST['first_name'].' ' .$_POST['last_name']
				    ) 
				   
				   );
				   
				    if ( is_wp_error( $user_data ) ) {
    
                   $usererror =  'Error in update user';
                   } else {
		   
	   
						   if( isset($_FILES['agent_profile_picture']['name']) && !empty($_FILES['agent_profile_picture']['name'])){
								 
								 nyc_property_profile_image_upload($_FILES,$getuser->ID);
								 
						   }
								update_user_meta($getuser->ID, 'user_full_name', $_POST['first_name'] .' '.$_POST['last_name']);
								update_user_meta($getuser->ID, 'user_agent_email', $_POST['email']);
								update_user_meta($getuser->ID, 'user_phone', $_POST['phone'] );
								update_user_meta($getuser->ID, 'user_personal_address', $_POST['address']);
								update_user_meta($getuser->ID, 'user_agent_about',$_POST['about']);
								update_user_meta($getuser->ID, 'user_agent_twitter', $_POST['twitter'] );
								update_user_meta($getuser->ID, 'user_agent_facebook', $_POST['facebook'] );
								update_user_meta($getuser->ID, 'user_agent_googleplus', $_POST['googleplus'] );
								update_user_meta($getuser->ID, 'user_agent_linkedin', $_POST['linkedin'] );
								update_user_meta($getuser->ID, 'user_designation', $_POST['designation'] );
								update_user_meta($getuser->ID, 'user_agent_status','active');
								$usersuccess = "Agent updated Successfully";

                   }						
        }
		
      } else {
	  
	  
	        $user_data = wp_update_user( 
		            array(
					       'ID' => $getuser->ID, 
		                   'user_email' => $_POST['email'],
						   'display_name' => $_POST['first_name'].' ' .$_POST['last_name']
				    ) 
				   
				   );
				   
				    if ( is_wp_error( $user_data ) ) {
    
                   $usererror =  'Error in update user';
                   } else {
		   
	   
						   if( isset($_FILES['agent_profile_picture']['name']) && !empty($_FILES['agent_profile_picture']['name'])){
								 
								 nyc_property_profile_image_upload($_FILES,$getuser->ID);
								 
						   }
						        update_user_meta($getuser->ID, 'first_name', $_POST['first_name'] );
			                    update_user_meta($getuser->ID, 'last_name', $_POST['last_name'] );
								update_user_meta($getuser->ID, 'user_full_name', $_POST['first_name'] .' '.$_POST['last_name']);
								update_user_meta($getuser->ID, 'user_agent_email', $_POST['email']);
								update_user_meta($getuser->ID, 'user_phone', $_POST['phone'] );
								update_user_meta($getuser->ID, 'user_personal_address', $_POST['address']);
								update_user_meta($getuser->ID, 'user_agent_about',$_POST['about']);
								update_user_meta($getuser->ID, 'user_agent_twitter', $_POST['twitter'] );
								update_user_meta($getuser->ID, 'user_agent_facebook', $_POST['facebook'] );
								update_user_meta($getuser->ID, 'user_agent_googleplus', $_POST['googleplus'] );
								update_user_meta($getuser->ID, 'user_agent_linkedin', $_POST['linkedin'] );
								update_user_meta($getuser->ID, 'user_designation', $_POST['designation'] );
								update_user_meta($getuser->ID, 'user_agent_status','active');
								$usersuccess = "Agent updated Successfully";

                   }						
    }
}
get_header();
?>
<!-- Wrapper -->
<div id="wrapper">


<!-- Content
================================================== -->
<div class="admin-teanent-detailpage">
	<div class="container">

	<div class="admin-agent-account-details">
		<div class="row">
			<div class="col-md-12">
				<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Account Details</h4>
			</div>
		</div>
		<div class="row">
		            <?php
                         if($usererror){
						?>
						    <label class="form_errors"><?= $usererror ?></label>
						<?php
						 }
						?>
						<?php
                         if($usersuccess){
						?>
						    <label class="reset_success"><?= $usersuccess ?></label>
						<?php
						 }
						?>
						
				   <form method="post" enctype="multipart/form-data">
						<div class="col-md-6 my-profile">
							
							<div class="row">
								<div class="col-md-6">
									<label>First Name</label>
									<input value="<?php echo get_user_meta($getuser->ID,'first_name',true); ?>" type="text" name="first_name" placeholder="First Name" required>
								</div>
								<div class="col-md-6">
									<label>Last Name</label>
									<input value="<?php echo get_user_meta($getuser->ID,'last_name',true); ?>" type="text" name="last_name" placeholder="Last Name" required>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<label>Designation</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_designation',true); ?>" type="text" name="designation" placeholder="Designation">
								</div>
								<div class="col-md-6">
									<label>Phone</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_phone',true); ?>" type="text" name="phone" placeholder="Phone" required>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-md-12">
									<label>Email</label>
									<input value="<?php echo $getuser->data->user_email; ?>" type="text" name="email" placeholder="Email" required>
								</div>
							</div>

							<div class="row">
							
								 <div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">Address</h4>
									<textarea name="address" id="address" cols="30" rows="10" name="address" placeholder="Address"><?php echo get_user_meta($getuser->ID,'user_personal_address',true); ?></textarea>
								</div>
								
								<div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
									<textarea name="about" id="about" cols="30" rows="10" placeholder="About"><?php echo get_user_meta($getuser->ID,'user_agent_about',true); ?></textarea>
								</div>
								
							</div>
							
						</div>

						<div class="col-md-6 admin-teanent-right">

							<div class="row">
								<div class="col-md-12">
									<!-- Avatar -->
									<div class="edit-profile-photo">
									      <?php
												  $profile_imgid =  get_user_meta($getuser->ID,'profile_user_image',true);
												  if($profile_imgid){
														echo wp_get_attachment_image( $profile_imgid, array('300', '225'), "", array( "class" => "img-responsive" ) );
												   } else {
						                  ?>
						                      <img src="<?= get_stylesheet_directory_uri() ?>/images/male-icon.png" alt="">
												 <?php
												   }
												 ?>
										
										<div class="change-photo-btn">
											<div class="photoUpload">
												<span><i class="fa fa-upload"></i> Upload Photo</span>
												<input type="file" class="upload" name="agent_profile_picture">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="margin-top-50">Social</h4>
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-twitter"></i> Twitter</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_agent_twitter',true); ?>" type="text" placeholder="Twitter" name="twitter">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-facebook-square"></i> Facebook</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_agent_facebook',true); ?>" type="text" placeholder="Facebook" name="facebook">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-google-plus"></i> Google+</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_agent_googleplus',true); ?>" type="text" placeholder="Googleplus" name="googleplus" >
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-linkedin"></i> Linkedin</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_agent_linkedin',true); ?>" type="text" placeholder="linkedin" name="linkedin">
								</div>
							</div>
							<button class="button margin-top-20 margin-bottom-20" type="submit" name="add_agent">Save Changes</button>
						</div>
					</form>
		</div>
	</div>

	</div>
</div>


<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>
<!-- Wrapper / End -->
<style>
label.form_errors {
    color: red;
}
label.reset_success {
    color: green;
}
</style>
<?php
get_footer();