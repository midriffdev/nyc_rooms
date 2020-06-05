<?php
/* Template Name: Admin Add Agent */
if(isset($_POST['add_agent'])){

if( email_exists( $_POST['email'] ) ) {
     $usererror ="Sorry!! Email Already Exists";
  } else {
      $userdata = array(
					'user_login'  => $_POST['email'],
					'user_pass'   =>  wp_generate_password(), // random password, you can also send a notification to new users, so they could set a password themselves
					'user_email' => $_POST['email'],
					'first_name' => $_POST['first_name'],
					'last_name' => $_POST['last_name'],
					'role'  => 'sales_agent'
				);
	   $user_id = wp_insert_user( $userdata );
	   
	   if( isset($_FILES['agent_profile_picture']['name']) && !empty($_FILES['agent_profile_picture']['name'])){
	         
			 nyc_property_profile_image_upload($_FILES,$user_id);
			 
	   }
	   
	    if($user_id){
		    update_user_meta($user_id, 'user_full_name', $_POST['first_name'] .' '.$_POST['last_name']);
			update_user_meta($user_id, 'user_agent_email', $_POST['email']);
	        update_user_meta($user_id, 'user_phone', $_POST['phone'] );
			update_user_meta($user_id, 'user_personal_address', $_POST['address']);
			update_user_meta($user_id, 'user_agent_about',$_POST['about']);
			update_user_meta($user_id, 'user_agent_twitter', $_POST['twitter'] );
			update_user_meta($user_id, 'user_agent_facebook', $_POST['facebook'] );
			update_user_meta($user_id, 'user_agent_googleplus', $_POST['googleplus'] );
			update_user_meta($user_id, 'user_agent_linkedin', $_POST['linkedin'] );
			update_user_meta($user_id, 'user_designation', $_POST['designation'] );
			update_user_meta( $user_id, 'user_agent_status','active');
			$usersuccess = "Agent Added Successfully";	
	   }
	   
  
  }
}
get_header();
?>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>Add Agent</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>Add Agent</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row">
         <!-- Widget -->
		<?php get_template_part('sidebar/admin-sidebar'); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">

			<div class="admin-teanent-account-details">
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
									<input type="text" name="first_name" placeholder="First Name" required>
								</div>
								<div class="col-md-6">
									<label>Last Name</label>
									<input type="text" name="last_name" placeholder="Last Name" required>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<label>Designation</label>
									<input type="text" name="designation" placeholder="Designation">
								</div>
								<div class="col-md-6">
									<label>Phone</label>
									<input  type="text" name="phone" placeholder="Phone" required>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-md-12">
									<label>Email</label>
									<input type="text" name="email" placeholder="Email" required>
								</div>
							</div>

							<div class="row">
							
								 <div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">Address</h4>
									<textarea name="address" id="address" cols="30" rows="10" name="address" placeholder="Address"></textarea>
								</div>
								
								<div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
									<textarea name="about" id="about" cols="30" rows="10" placeholder="About"></textarea>
								</div>
								
							</div>
							
						</div>

						<div class="col-md-6 admin-teanent-right">

							<div class="row">
								<div class="col-md-12">
									<!-- Avatar -->
									<div class="edit-profile-photo">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/agent-01.jpg" alt="">
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
									<input  type="text" placeholder="Twitter" name="twitter">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-facebook-square"></i> Facebook</label>
									<input type="text" placeholder="Facebook" name="facebook">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-google-plus"></i> Google+</label>
									<input type="text" placeholder="Googleplus" name="googleplus" >
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-linkedin"></i> Linkedin</label>
									<input type="text" placeholder="linkedin" name="linkedin">
								</div>
							</div>
							<button class="button margin-top-20 margin-bottom-20" type="submit" name="add_agent">Save Changes</button>
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
