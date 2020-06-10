<?php
/* Template Name: Change Password */
global $wpdb;
$errors = array();
if(isset($_POST['reset_pass_Sbumit'])){

	 if(empty($_POST['password'])) 
		{   
            $errors['password'] = "Please enter a password";  
        } elseif(0 === preg_match("/.{12,}/", $_POST['password']))
        {  
          $errors['password'] = "Password must be at least six characters";  
        }  
        if(empty($_POST['cpassword'])) 
		{   
            $errors['password_confirmation'] = "Please enter a confirm password";  
        }  elseif(0 !== strcmp($_POST['password'], $_POST['cpassword'])) {  
              $errors['password_confirmation'] = "Passwords do not match";
        }
		
		if(empty($errors)) { 
			 $new_password = $_POST['password'];
			 $ID           = get_current_user_id();
	         wp_set_password( $new_password, $ID );
			 $message = "Password Updated Sucessfully.";
	    }


}
get_header();
?>
 <div id="primary" class="content-area">
<div id="wrapper">

<!-- Titlebar
================================================== -->


<!-- Content
================================================== -->
<div class="container">
	<div class="row">
		<!-- Widget -->
		<div class="col-md-4">
			<div class="sidebar left">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>
						<li><a href="#"><i class="sl sl-icon-screen-desktop"></i> Dashboard</a></li>
						<li><a href="<?php echo home_url(); ?>/my-profile/" class="current"><i class="sl sl-icon-user"></i> My Profile</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li><a href="my-properties.html"><i class="sl sl-icon-docs"></i> My Properties</a></li>
						<li><a href="submit-property.html"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li><a href="<?php echo home_url(); ?>/change-password/"><i class="sl sl-icon-lock"></i> Change Password</a></li>
						<li><a href="<?php echo wp_logout_url(home_url().'/login-register/'); ?>"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>

				</div>

			</div>
		</div>

		<div class="col-md-8">
			<div class="row">
				<div class="col-md-6  my-profile">
					<h4 class="margin-top-0 margin-bottom-30">Change Password</h4>
					<?php
						 if(!empty($errors)){
						   foreach($errors as $err){
							?>
							<label class="form_errors"><?php echo $err; ?></label>
							<?php
						   }
						 }
						 
                   ?>
				    <label class="reset_password_change"><?php echo $message; ?></label>
					<form role="form" action="<?php echo "http://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']; ?>" method="post" >
					<label>New Password</label>
					<input type="password" name="password" class="form-control" placeholder="Enter New Password" required />

					<label>Confirm New Password</label>
					<input type="password" name="cpassword" class="form-control" placeholder="Enter Confirm Password" required />
                       <input type="hidden" name="reset_pass_Sbumit" value="kv_yes" >
			           <input type="submit" class="margin-top-20 button" value="Save Changes" > 
					</form>
				</div>

				<div class="col-md-6">
					<div class="notification notice">
						<p>Your password should be at least 12 random characters long to be safe</p>
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
	</div><!-- #primary -->
<style>
label.reset_password_change {
    color: green;
}
label.form_errors {
    color: red;
}
</style>
<?php
get_footer();
