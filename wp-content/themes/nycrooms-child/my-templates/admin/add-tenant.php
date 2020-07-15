<?php
get_header();

/* Adding a tenant */

if(isset($_POST['add_tenant'])){
	$errors = false;
	$email = $_POST['email'];
	$username = $_POST['username'];
	$fname = $_POST['first_name'];
	$lname = $_POST['last_name'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$about = $_POST['about'];
	$twitter = $_POST['twitter'];
	$facebook = $_POST['facebook'];
	$googleplus = $_POST['googleplus'];
	$linkedin = $_POST['linkedin'];
	$about = $_POST['about'];
	if( email_exists($email) ) {
	    $erroremail = "Email ID already exist.";
		$errors = true;
	}
	if( empty($username) ) {
	    $errorusername = "Username is required.";
		$errors = true;
	}elseif( username_exists($username) ) {
	    $errorusername = "Username already exist.";
		$errors = true;
	}
	if($errors == false){
		$userPass = wp_generate_password();
		$userdata = array(
						'user_login'  	=> $username,
						'user_pass'   	=> $userPass, // random password, you can also send a notification to new users, so they could set a password themselves
						'user_email' 	=> $email,
						'first_name'	=> $fname,
						'last_name' 	=> $lname,
						'role'      	=> 'tenant'
		);
		$user_id = wp_insert_user( $userdata );	   
		if( isset($_FILES['profile_picture']['name']) && !empty($_FILES['profile_picture']['name'])){		 
			 nyc_user_profile_image_upload($_FILES,'profile_picture',$user_id);		 
		}	   
		if($user_id){
			update_user_meta($user_id, 'user_full_name', $fname .' '.$lname);
			update_user_meta($user_id, 'user_email', $email);
			update_user_meta($user_id, 'user_phone', $phone );
			update_user_meta($user_id, 'user_personal_address', $address);
			update_user_meta($user_id, 'user_about',$about);
			update_user_meta($user_id, 'user_twitter', $twitter );
			update_user_meta($user_id, 'user_facebook', $facebook );
			update_user_meta($user_id, 'user_googleplus', $googleplus );
			update_user_meta($user_id, 'user_linkedin', $linkedin );
			update_user_meta( $user_id, 'user_status','active');
			nyc_wp_new_user_notification($user_id,$userPass);
			$createmsg = "Tenant profile added successfully";	
		}
	}
}
?>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

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
				    
				    <form method="post" id="add_tenant_form" enctype="multipart/form-data">
						<div class="col-md-6 my-profile">
							<div class="row">
								<div class="col-md-6">
									<label>First Name</label>
									<input type="text" name="first_name" placeholder="First Name" value="<?php if(isset($fname)){ echo $fname; } ?>" required>
								</div>
								<div class="col-md-6">
									<label>Last Name</label>
									<input type="text" name="last_name" placeholder="Last Name" value="<?php if(isset($lname)){ echo $lname; } ?>" required>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6">
									<label>Phone</label>
									<input  type="text" name="phone" placeholder="Enter Phone With +1.."  value="<?php if(isset($phone)){ echo $phone; } ?>" pattern="[+1]{2}[0-9]{10}"  oninvalid="setCustomValidity('Please Enter Valid No With Country Code +1.')" onchange="try{setCustomValidity('')}catch(e){}" maxlength="12"  required>
								</div>
								<div class="col-md-6">
									<label>Username</label>
									<input  type="text" name="username" placeholder="Username" value="<?php if(isset($username)){ echo $username; } ?>"  required>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-md-12">
									<label>Email</label>
									<input type="text" name="email" placeholder="Email" value="<?php if(isset($email)){ echo $email; } ?>" required>
								</div>
							</div>

							<div class="row">
							
								 <div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">Address</h4>
									<textarea name="address" id="address" cols="30" rows="10" name="address" placeholder="Address"><?php if(isset($address)){ echo $address; } ?></textarea>
								</div>
								
								<div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
									<textarea name="about" id="about" cols="30" rows="10" placeholder="About"><?php if(isset($about)){ echo $about; } ?></textarea>
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
									<input  type="text" placeholder="Twitter" name="twitter" value="<?php if(isset($twitter)){ echo $twitter; } ?>">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-facebook-square"></i> Facebook</label>
									<input type="text" placeholder="Facebook" name="facebook" value="<?php if(isset($facebook)){ echo $facebook; } ?>"  >
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-google-plus"></i> Google+</label>
									<input type="text" placeholder="Googleplus" name="googleplus" value="<?php if(isset($googleplus)){ echo $googleplus; } ?>"  >
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-linkedin"></i> Linkedin</label>
									<input type="text" placeholder="linkedin" name="linkedin" value="<?php if(isset($linkedin)){ echo $linkedin; } ?>"  >
								</div>
							</div>
							<button class="button margin-top-20 margin-bottom-20" type="submit" name="add_tenant">Save Changes</button>
						</div>
					</form>
				</div>
			</div>

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

</div>
<!-- Wrapper / End -->

<?php 
if(isset($errorusername) || isset($erroremail)){ 
$msg = '';
$msg .= '<p><span style="color:#f81515;font-size: large">'.$errorusername.'</span></p>'; 
$msg .= '<p><span style="color:#f81515;font-size: large">'.$erroremail.'</span></p>'; 
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

if(isset($createmsg)){
$msg = '';
$msg .= '<p><span style="color:#1db40a;font-size: large">'.$createmsg.'</span></p>'; 
?>
<script>
jQuery(document).ready(function(){
	var msg ='<?php echo $msg; ?>';
	jQuery('#successModal .modal-body p').html(msg);
	jQuery('#successModal').modal('show');
	jQuery('#add_tenant_form').find("input[type=text], textarea").val("");
});
</script>
<?php 	
}
?>

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
});
jQuery(document).ready(function($) {
	jQuery('#sidebar-addtenant').addClass('current');
});
</script>
<?php
get_footer();