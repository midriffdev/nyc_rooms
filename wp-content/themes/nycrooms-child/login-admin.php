<?php
/* Template Name: Admin Login */
global $wpdb, $user_ID;
$errors = array();
$loginerror = ''; 
if(is_user_logged_in()){
  header( 'Location:' . site_url() . '/admin/');
} 

if(isset($_POST['login'])){  
   
    global $wpdb;  
   
    //We shall SQL escape all inputs  
    $username = esc_sql($_REQUEST['username']);  
    $password = esc_sql($_REQUEST['password']);
	 $remember = '';
     if(isset($_REQUEST['rememberme'])){
       $remember = esc_sql($_REQUEST['rememberme']);  
     }
	 
    if($remember != '') $remember = "true";  
    else $remember = "false";  
   
    $login_data = array();  
    $login_data['user_login'] = $username;  
    $login_data['user_password'] = $password;  
    $login_data['remember'] = $remember;  
    $userrolecheck = get_user_by('login', $username);
	if(!$userrolecheck){
	  $userrolecheck = get_user_by('email', $username);
	}
	
   
     if($userrolecheck->roles[0] != "administrator" ){
	   $loginerror = "Invalid login details";
	} else {
		$user_verify = wp_signon( $login_data, false );
	   
		if ( is_wp_error($user_verify) ) {  
			$loginerror = "Invalid login details";  
		   // Note, I have created a page called "Error" that is a child of the login page to handle errors. This can be anything, but it seemed a good way to me to handle errors.  
		 } else {    
		   echo "<script type='text/javascript'>window.location.href='". site_url().'/admin-dashboard/' ."'</script>";  
		   exit();  
		 }
   }
   
}
//Check whether the user is already logged in  
get_header();
?>

	<div id="primary" class="content-area">
		<!-- Wrapper -->
<div id="wrapper">




<!-- Contact
================================================== -->

<!-- Container -->
<div class="container">

	<div class="row">
	<div class="col-md-4 col-md-offset-4">
     
	<!--button class="button social-login via-twitter"><i class="fa fa-twitter"></i> Log In With Twitter</button--->

	<!--Tab -->
	<div class="my-account style-1 margin-top-5 margin-bottom-40">

		<ul class="tabs-nav">
			<li class=""><a href="#tab1">Log In</a></li>
		</ul>

		<div class="tabs-container alt">

			<!-- Login -->
			<div class="tab-content" id="tab1" style="display: none;">
			     <label class="form_errors" align="center"><?php echo $loginerror; ?></label>
				 <?php if(isset($_GET['action']) && $_GET['action'] == "reset_success") {?>
				      <label class="reset_success" align="center"><?php echo "Your New Password has been reset successfully.You can Login now with new credentials sent to your e-mail"; ?></label>
				 <?php } ?>
				<form method="post" class="login">

					<p class="form-row form-row-wide">
						<label for="username">Username or Email:
							<i class="im im-icon-Male"></i>
							<input type="text" class="input-text" name="username" id="username" value="" Placeholder="Username Or Email" />
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="password">Password:
							<i class="im im-icon-Lock-2"></i>
							<input class="input-text" type="password" name="password" id="password" Placeholder="Password" />
						</label>
					</p>

					<p class="form-row">
					    <label for="rememberme" class="rememberme">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> Remember Me</label>
						
						<input type="submit" class="button border margin-top-10" name="login" value="Login" />
					</p>

					<p class="lost_password">
						<a href="<?php  echo home_url() ."/forgot-password/"?>" >Lost Your Password?</a>
					</p>
					
				</form>
			</div>

		</div>
	</div>



	</div>
	</div>

</div>
<!-- Container / End -->

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>
	</div><!-- #primary -->
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