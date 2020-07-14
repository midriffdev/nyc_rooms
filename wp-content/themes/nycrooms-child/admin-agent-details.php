<?php
/* Template Name: Admin Agent Details */
$getuser = get_user_by('id',$_GET['agentid']);
if(isset($_POST['add_agent'])){

	  $phoneno = $_POST['phone'];

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
								update_user_meta($getuser->ID, 'user_phone', $phoneno );
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
								update_user_meta($getuser->ID, 'user_phone', $phoneno );
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
			 <p><a href="<?php echo site_url() . "/all-agent/" ?>"><i class="fa fa-arrow-left"></i> Back</a></p>
			</div>
			<div class="col-md-12">
				<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Account Details</h4>
			</div>
		</div>
		<div class="row">
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
									<input value="<?php echo get_user_meta($getuser->ID,'user_phone',true); ?>" type="text" name="phone" placeholder="Enter Phone With +1.." required pattern="[+1]{2}[0-9]{10}"  oninvalid="setCustomValidity('Please Enter Valid No With Country Code +1.')" onchange="try{setCustomValidity('')}catch(e){}" maxlength="12" required>
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
												<input type="file" class="upload" id="imgupload" name="agent_profile_picture">
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
<?php 
if(isset($usererror) || !empty($usererror)){ 
$msg = '';
$msg .= '<p><span style="color:#f81515;font-size: large">'.$usererror.'</span></p>'; 
?>
<script>
jQuery(document).ready(function(){
	var msg ='<?php echo $msg; ?>';
	jQuery('#successModal .modal-body p').html(msg);
	jQuery('#successModal').modal('show');
});
</script>
<?php 
} 

if(isset($usersuccess) || !empty($usersuccess)){ 
$msg = '';
$msg .= '<p><span style="color:#1db40a;font-size: large">'.$usersuccess.'</span></p>'; 
?>
<script>
jQuery(document).ready(function(){
	var msg ='<?php echo $msg; ?>';
	jQuery('#successModal .modal-body p').html(msg);
	jQuery('#successModal').modal('show');
});
</script>
<?php 
} 
?>
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