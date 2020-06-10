<?php
/* Template Name: Reset Password */
global $wpdb;
$errors = array();
if(isset($_POST['reset_pass_Sbumit'])){

	 if(empty($_POST['password'])) 
		{   
            $errors['password'] = "Please enter a password";  
        } elseif(0 === preg_match("/.{6,}/", $_POST['password']))
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
		     $reset_key  =  $_POST['reset_pass_key'];
	         $user_login = $_POST['reset_pass_login'];
 	         $user_data  =  $wpdb->get_row("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = '".$reset_key."' AND user_login = '". $user_login."'");
	         $user_login = $user_data->user_login;
	         $user_email = $user_data->user_email;
			 $new_password = $_POST['password'];
	     if(!empty($reset_key) && !empty($user_data)) {
				 if (!kv_rest_setting_password($reset_key, $user_login, $user_email, $user_data->ID,$new_password)) {
					 $errors['emailError'] = "Email failed to sent for some unknown reason"; 
				 } else {
				      $checkuserrole = get_user_meta($user_data->ID,'nyc_capabilities',true);
                      $userrole      =  array_keys($checkuserrole);
	                  $user_role      =  $userrole[0];
					  if($user_role == 'property_owner'){
						  $redirect_to = get_site_url()."/login-register/?action=reset_success";
						  wp_safe_redirect($redirect_to);
						  exit();
					  } else if($user_role == 'tenant'){
					      $redirect_to = get_site_url()."/tenant-registration/?action=reset_success";
						  wp_safe_redirect($redirect_to);
						  exit();
					  }
					 
		         }
	     } else {
	                $errors['emailError'] = 'Not a Valid Key.'; 
	     }
		    
	    }


}
get_header();
?>
<div id="primary" class="content-area">
		<!-- Wrapper -->
<div id="wrapper">
   <?php
         if(!empty($errors)){
		   foreach($errors as $err){
		    ?>
			<label class="form_errors"><?php echo $err; ?></label>
			<?php
		   }
		 }
   ?>
  <form role="form" action="<?php echo "https://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']; ?>" method="post" >
			<div class="form-group input-group">
				<span class="input-group-addon">New Password</span>
				<input type="password" name="password" class="form-control" placeholder="Enter New Password" required />
			</div>
		    <div class="form-group input-group">
				<span class="input-group-addon">Confirm Password</span>
				<input type="password" name="cpassword" class="form-control" placeholder="Enter Confirm Password" required />
			</div>
			<input type="hidden" name="reset_pass_key" value="<?php echo $_GET['key']; ?>" >
			<input type="hidden" name="reset_pass_login" value="<?php echo $_GET['login']; ?>" >
			<input type="hidden" name="reset_pass_Sbumit" value="kv_yes" >
			<input type="submit" class="btn btn-primary" value="Get Password" > 
   </form>
</div>
</div>
<style>
label.form_errors {
    color: red;
}
</style>
<?php
get_footer();
?>