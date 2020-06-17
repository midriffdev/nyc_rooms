<?php
/* Template Name: Admin Edit Tenant */

$getuser = wp_get_current_user();
$user_id = $getuser->ID;
nyc_tenant_check_authentication();
if(isset($_POST['update_user'])){
    $userdata = array( 
	            'ID' => $user_id,
	            'user_nicename'		=>  $_POST['first_name'].' ' .$_POST['last_name'],
				'display_name'		=> 	$_POST['first_name'].' ' .$_POST['last_name'],
	             );
    wp_update_user($userdata );
	if( isset($_FILES['profile_picture']['name']) && !empty($_FILES['profile_picture']['name'])){		 
		nyc_user_profile_image_upload($_FILES,'profile_picture',$user_id);	 
	}	
	update_user_meta($user_id, 'first_name', $_POST['first_name'] );
	update_user_meta($user_id, 'last_name', $_POST['last_name'] );
	update_user_meta($user_id, 'user_full_name', $_POST['first_name'] .' '.$_POST['last_name']);
	update_user_meta($user_id, 'user_email', $_POST['email']);
	update_user_meta($user_id, 'user_phone', $_POST['phone'] );
	update_user_meta($user_id, 'user_personal_address', $_POST['address']);
	update_user_meta($user_id, 'user_about',$_POST['about']);
	update_user_meta($user_id, 'user_twitter', $_POST['twitter'] );
	update_user_meta($user_id, 'user_facebook', $_POST['facebook'] );
	update_user_meta($user_id, 'user_googleplus', $_POST['googleplus'] );
	update_user_meta($user_id, 'user_linkedin', $_POST['linkedin'] );
	$usersuccess =  "Profile Updated Successfully";
   
}
get_header();
?>
<!-- Wrapper -->
<div id="wrapper">

<div class="container">
	<div class="row">
		<!-- Widget -->
		<?php include(locate_template('sidebar/admin-sidebar.php')); ?>
	<div class="col-md-9">
	<div class="admin-agent-account-details">
		<div class="row">
			<div class="col-md-12">
				<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Account Details</h4>
			</div>
		</div>
		<div class="row">
						<?php
                         if(isset($usersuccess) && $usersuccess){
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
									<input value="<?php echo get_user_meta($user_id,'first_name',true); ?>" type="text" name="first_name" placeholder="First Name" required>
								</div>
								<div class="col-md-6">
									<label>Last Name</label>
									<input value="<?php echo get_user_meta($user_id,'last_name',true); ?>" type="text" name="last_name" placeholder="Last Name" required>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<label>Phone</label>
									<input value="<?php echo get_user_meta($user_id,'user_phone',true); ?>" type="text" name="phone" placeholder="Phone" required>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>Email</label>
									<input value="<?php echo $getuser->data->user_email; ?>" type="text" name="email" placeholder="Email" readonly>
								</div>
							</div>

							<div class="row">
							
								 <div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">Address</h4>
									<textarea name="address" id="address" cols="30" rows="10" name="address" placeholder="Address"><?php echo get_user_meta($user_id,'user_personal_address',true); ?></textarea>
								</div>
								
								<div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
									<textarea name="about" id="about" cols="30" rows="10" placeholder="About"><?php echo get_user_meta($user_id,'user_about',true); ?></textarea>
								</div>
								
							</div>
							
						</div>

						<div class="col-md-6 admin-teanent-right">

							<div class="row">
								<div class="col-md-12">
									<!-- Avatar -->
									<div class="edit-profile-photo">
									      <?php
												$profile_imgid =  get_user_meta($user_id,'profile_picture',true);
												if($profile_imgid){
													echo wp_get_attachment_image( $profile_imgid, array('300', '225'), "", array( "class" => "img-responsive" ) );
												} else {
						                  ?>
						                      <img src="<?php echo get_stylesheet_directory_uri() ?>/images/male-icon.png" alt="">
												 <?php
												   }
												 ?>
										
										<div class="change-photo-btn">
											<div class="photoUpload">
												<span><i class="fa fa-upload"></i> Upload Photo</span>
												<input type="file" class="upload" id="imgupload" name="profile_picture">
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
									<input value="<?php echo get_user_meta($user_id,'user_twitter',true); ?>" type="text" placeholder="Twitter" name="twitter">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-facebook-square"></i> Facebook</label>
									<input value="<?php echo get_user_meta($user_id,'user_facebook',true); ?>" type="text" placeholder="Facebook" name="facebook">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-google-plus"></i> Google+</label>
									<input value="<?php echo get_user_meta($user_id,'user_googleplus',true); ?>" type="text" placeholder="Googleplus" name="googleplus" >
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-linkedin"></i> Linkedin</label>
									<input value="<?php echo get_user_meta($user_id,'user_linkedin',true); ?>" type="text" placeholder="linkedin" name="linkedin">
								</div>
							</div>
							<button class="button margin-top-20 margin-bottom-20" type="submit" name="update_user">Save Changes</button>
						</div>
					</form>
		</div>
	</div>
	</div>
	</div>
</div>
<div class="margin-top-55"></div>


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
<script>
jQuery(document).ready(function(){
 jQuery(document).on('change', '.upload', function(){
  var name = document.getElementById("imgupload").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  var error = false;
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
  {
   alert("Invalid Image File");
   error = true;
  }
  var oFReader = new FileReader();
	oFReader.onload = (function(imgupload){ //trigger function on successful read
	return function(e) {
		var img = jQuery('.edit-profile-photo img').attr('srcset', e.target.result); //create image element 
	};
	})(imgupload);
  oFReader.readAsDataURL(document.getElementById("imgupload").files[0]);
  });
  jQuery('#sidebar-profile').addClass('current');
});
</script>
<?php
get_footer();