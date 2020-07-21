<?php
/* Template Name: Admin Add Agent */
$usererror = '';
$usersuccess = '';
nyc_property_admin_authority();
if(isset($_POST['add_agent'])){
     $phone = $_POST['phone'];
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
	        update_user_meta($user_id, 'user_phone', $phone );
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
						<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Account Details</h4>
					</div>
				</div>
				<div class="row">
				        
						
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
									<input  type="text" name="phone" placeholder="Enter Phone With +1.." pattern="[+1]{2}[0-9]{10}"  oninvalid="setCustomValidity('Please Enter Valid No With Country Code +1.')" onchange="try{setCustomValidity('')}catch(e){}" maxlength="12" required>
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
										<img src="<?= get_stylesheet_directory_uri() ?>/images/male-icon.png" alt="">
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
            if($usererror){
		         echo $usererror;
						
			}
					
		    if($usersuccess){
	          echo $usersuccess; 
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
if(!empty($usererror)){
   echo "<script>
         jQuery(window).load(function(){
             $('#myModal').modal('show');
         });
    </script>";
}
if(!empty($usersuccess)){
   echo "<script>
         jQuery(window).load(function(){
             $('#myModal').modal('show');
         });
    </script>";
}
?>