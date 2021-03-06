<?php
/* Template Name: Forget Password */
$success = array();
if(isset($_POST['forgot_pass_Sbumit'])) {
    
   if ( isset($_POST['emailToreceive']) && empty($_POST['emailToreceive']) ){
 	    $errors['userName'] = __("<strong>ERROR</strong>: Username/e-mail Shouldn't be empty.");
   } else {
		$emailToreceive = $_POST['emailToreceive']; 
		$user_input = esc_sql(trim($emailToreceive));
   }
   if ( strpos($user_input, '@') ) {
 	$user_data = get_user_by( 'email', $user_input ); 
 	if(empty($user_data) ) {
 		$errors['invalid_email'] = 'Invalid E-mail address!'; 
 	}
    } else {
 	$user_data = get_user_by( 'login', $user_input ); 
 	if(empty($user_data) ) { 
 		$errors['invalid_usename'] = 'Invalid Username!'; 
 	}
	}
	
	if(empty($errors)) {
	          
			if(kv_forgot_password_reset_email($user_data->user_email)) {
				$success['reset_email'] = "We have just sent you an email with Password reset instructions.";
			} else {
				$errors['emailError'] = "Email failed to send for some unknown reason."; 
			} //emailing password change request details to the user 
			
    }
}
get_header();
?>
<div id="primary" class="content-area">
		<!-- Wrapper -->
<div id="wrapper">
<div id="password-lost-form" class="widecolumn">
   
        <h3><?php _e( 'Forgot Your Password?', 'personalize-login' ); ?></h3>
 
    <p>
        <?php
		   if(!isset($_POST['forgot_pass_Sbumit'])){
            _e(
                "Enter your email address and we'll send you a link you can use to pick a new password.",
                'personalize_login'
            );
			}
        ?>
    </p>
      <?php
         if(!empty($errors)){
		   foreach($errors as $err){
		    ?>
			<label class="form_errors"><?php echo $err; ?></label>
			<?php
		   }
		 } else {
		    ?>
			<label class="form_sucess"><?php if(!empty($success)) { if(isset($success['reset_email'])){ echo $success['reset_email'];}} ?></label>
			<?php
		 }
	  ?>  
    <form role="form" action="<?php echo "https://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI']; ?>" method="post" id="forgetPassword" >
			<div class="form-group input-group">
				<span class="input-group-addon">E-Mail or Username </span>
				<input type="text" name="emailToreceive" class="form-control" id="emailToreceive" placeholder="Your Username or Email" />
			</div>
			 <input type="hidden" name="forgot_pass_Sbumit" value="kv_yes" >
			<input type="submit" class="btn btn-primary" value="Get Password" > 
   </form>
</div>
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

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/jquery.validate.min.js"></script>
<script>
jQuery('#forgetPassword').validate({
rules: {
        emailToreceive:{
		  required: true,
		}
    },
    messages: {
        emailToreceive: {
            required: "Please Enter Email or UserName"
        }
    },
    submitHandler: function(form) {
       form.submit();
   }
   

});
</script>
