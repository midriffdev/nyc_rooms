<?php
/* Template Name: Signup */
global $wpdb, $user_ID;
$errors = array(); 
if(is_user_logged_in()){
  header( 'Location:' . site_url() . '/my-profile/');
}
   
     if(isset($_REQUEST['register']) && $_SERVER['REQUEST_METHOD'] == "POST") 
      {  
		  
         // Check username is present and not already in use  
        $username = $wpdb->escape($_REQUEST['username']);  
        if ( strpos($username, ' ') !== false )
        {   
            $errors['username'] = "Sorry, no spaces allowed in usernames";  
        }  
        if(empty($username)) 
        {   
            $errors['username'] = "Please enter a username";  
        } elseif( username_exists( $username ) ) 
        {  
            $errors['username'] = "Username already exists, please try another";  
        }  
   
        // Check email address is present and valid  
        $email = $wpdb->escape($_REQUEST['email']);  
        if( !is_email( $email ) ) 
        {   
            $errors['email'] = "Please enter a valid email";  
        } elseif( email_exists( $email ) ) 
        {  
            $errors['email'] = "This email address is already in use";  
        }  
   
        // Check password is valid  
        if(0 === preg_match("/.{6,}/", $_POST['password1']))
        {  
          $errors['password'] = "Password must be at least six characters";  
        }  
   
        // Check password confirmation_matches  
        if(0 !== strcmp($_POST['password1'], $_POST['password2']))
         {  
          $errors['password_confirmation'] = "Passwords do not match";  
        }  
     
   
        if(0 === count($errors)) 
         {  
   
            $password = $_POST['password1'];  
            $signin_data =  array(
									  'user_login' => $username,
									  'user_pass' => $password,
									  'user_email' => $email,
									  'role'  => 'property_owner'
                           );
			  
			$user =  wp_insert_user($signin_data);
			 
			 if($user){
			   $login_data = array(
			                    'user_login' => $username,
							    'user_password' => $password,
								'remember' => 'false'
			                 );
			     
			    $user_verify = wp_signon( $login_data, false ); 
				
				 if(!is_wp_error($user_verify)){
				   header( 'Location:' . site_url() . '/my-profile/?success=1&u=' . $username );  
				}
				
			 }
   
            // You could do all manner of other things here like send an email to the user, etc. I leave that to you.  
   
        }
   
    }
	
	if(isset($_POST['login'])){  
   
    global $wpdb;  
   
    //We shall SQL escape all inputs  
    $username = $wpdb->escape($_REQUEST['username']);  
    $password = $wpdb->escape($_REQUEST['password']);  
    $remember = $wpdb->escape($_REQUEST['rememberme']);  
   
    if($remember != '') $remember = "true";  
    else $remember = "false";  
   
    $login_data = array();  
    $login_data['user_login'] = $username;  
    $login_data['user_password'] = $password;  
    $login_data['remember'] = $remember;  
   
    $user_verify = wp_signon( $login_data, false );
   
    if ( is_wp_error($user_verify) ) {  
        echo "Invalid login details";  
       // Note, I have created a page called "Error" that is a child of the login page to handle errors. This can be anything, but it seemed a good way to me to handle errors.  
     } else {    
       echo "<script type='text/javascript'>window.location.href='". site_url().'/my-profile/' ."'</script>";  
       exit();  
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

	<button class="button social-login via-twitter"><i class="fa fa-twitter"></i> Log In With Twitter</button>
	<button class="button social-login via-gplus"><i class="fa fa-google-plus"></i> Log In With Google Plus</button>
	<button class="button social-login via-facebook"><i class="fa fa-facebook"></i> Log In With Facebook</button>

	<!--Tab -->
	<div class="my-account style-1 margin-top-5 margin-bottom-40">

		<ul class="tabs-nav">
			<li class=""><a href="#tab1">Log In</a></li>
			<li><a href="#tab2">Register</a></li>
		</ul>

		<div class="tabs-container alt">

			<!-- Login -->
			<div class="tab-content" id="tab1" style="display: none;">
				<form method="post" class="login">

					<p class="form-row form-row-wide">
						<label for="username">Username:
							<i class="im im-icon-Male"></i>
							<input type="text" class="input-text" name="username" id="username" value="" />
						</label>
					</p>

					<p class="form-row form-row-wide">
						<label for="password">Password:
							<i class="im im-icon-Lock-2"></i>
							<input class="input-text" type="password" name="password" id="password"/>
						</label>
					</p>

					<p class="form-row">
					    <label for="rememberme" class="rememberme">
						<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> Remember Me</label>
						
						<input type="submit" class="button border margin-top-10" name="login" value="Login" />
					</p>

					<p class="lost_password">
						<a href="#" >Lost Your Password?</a>
					</p>
					
				</form>
			</div>

			<!-- Register -->
			<div class="tab-content" id="tab2" style="display: none;">

				<form method="post" class="register"  action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
					
				<p class="form-row form-row-wide">
					<label for="username2">Username:
						<i class="im im-icon-Male"></i>
						<input type="text" class="input-text" name="username" id="username2" value="" />
					</label>
				</p>
					
				<p class="form-row form-row-wide">
					<label for="email2">Email Address:
						<i class="im im-icon-Mail"></i>
						<input type="text" class="input-text" name="email" id="email2" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="password1">Password:
						<i class="im im-icon-Lock-2"></i>
						<input class="input-text" type="password" name="password1" id="password1"/>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="password2">Repeat Password:
						<i class="im im-icon-Lock-2"></i>
						<input class="input-text" type="password" name="password2" id="password2"/>
					</label>
				</p>

				<p class="form-row">
					<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
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

<?php
get_footer();
