<?php
/* Template Name: Signup Tenant */
require_once 'google-api/vendor/autoload.php';
global $wpdb, $user_ID;
$errors = array(); 
if(is_user_logged_in()){
  header( 'Location:' . site_url() . '/my-profile-tenant/');
}
   
     if(isset($_REQUEST['register']) && $_SERVER['REQUEST_METHOD'] == "POST") 
      {  
		  
         // Check username is present and not already in use  
        $username = $wpdb->escape($_REQUEST['username']);  
          
        if(empty($_REQUEST['username'])) 
        {   
            $errors['username'] = "Please enter a username";  
        } else if ( strpos($username, ' ') !== false )
        {   
            $errors['username'] = "Sorry, no spaces allowed in usernames";  
        } elseif( username_exists( $username ) ) 
        {  
            $errors['username'] = "Username already exists, please try another";  
        }  
   
        // Check email address is present and valid  
        $email = $wpdb->escape($_REQUEST['email']); 
		if(empty($_REQUEST['email'])) 
        {   
            $errors['email'] = "Please enter a email";  
        } elseif( !is_email( $email ) ) 
        {   
            $errors['email'] = "Please enter a valid email";  
        } elseif( email_exists( $email ) ) 
        {  
            $errors['email'] = "This email address is already in use";  
        } 
           
		 if(empty($_REQUEST['password1'])) 
		{   
            $errors['password'] = "Please enter a password";  
        } elseif(0 === preg_match("/.{6,}/", $_REQUEST['password1']))
        {  
          $errors['password'] = "Password must be at least six characters";  
        }  
        if(empty($_REQUEST['password2'])) 
		{   
            $errors['password_confirmation'] = "Please enter a confirm password";  
        }  elseif(0 !== strcmp($_REQUEST['password1'], $_REQUEST['password2'])) {  
              $errors['password_confirmation'] = "Passwords do not match";
        }  
     
   
        if(0 === count($errors)) 
         {  
   
            $password = $_REQUEST['password1'];  
            $signin_data =  array(
									  'user_login' => $username,
									  'user_pass' => $password,
									  'user_email' => $email,
									  'role'  => 'tenant'
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
				   wp_new_user_notification($user, null, 'both');
				   header( 'Location:' . site_url() . '/my-profile-tenant/?success=1&u=' . $username );  
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

    $userrolecheck = get_user_by('login', $username);
	if(!$userrolecheck){
	  $userrolecheck = get_user_by('email', $username);
	}
	
    if($userrolecheck->roles[0] != "tenant"){
	   $loginerror = "Invalid login details";
	} else {
	      $user_verify = wp_signon( $login_data, false );
		   if ( is_wp_error($user_verify)) {  
			$loginerror = "Invalid login details";  
		   // Note, I have created a page called "Error" that is a child of the login page to handle errors. This can be anything, but it seemed a good way to me to handle errors.  
		   } else {    
			   echo "<script type='text/javascript'>window.location.href='". site_url().'/my-profile-tenant/' ."'</script>";  
			   exit();  
		   } 
	}
   
}

/*------------ Guest Checkout ----------------------*/

if(isset($_POST['guest_checkout'])){
		
		
	
		
		$lead_id = wp_insert_post(array (
			'post_type'		=> 'leads',
			'post_title' 	=> 'Lead submission',
			'post_content' 	=> 'Lead submission by guest user',
			'post_author' 	=> 1,
			'post_status'   => 'available'
		));
		
		
		 if ($lead_id) {
			add_post_meta($lead_id, 'lead_name', $_POST['guest_name']);
			add_post_meta($lead_id, 'lead_email', $_POST['guest_email']);
			add_post_meta($lead_id, 'lead_phone', $_POST['guest_phone']);
			add_post_meta($lead_id, 'lead_summary', $_POST['guest_summary']);
			add_post_meta($lead_id, 'lead_checkout_property', $_SESSION['action']['property_id']);
			add_post_meta($lead_id, 'lead_checkout_property_name', get_the_title($_SESSION['action']['property_id']));
			add_post_meta($lead_id, 'lead_checkt_prp_owner', get_post_meta($_SESSION['action']['property_id'],'contact_name',true));
			add_post_meta($lead_id, 'lead_chckt_prp_owner_email', get_post_meta($_SESSION['action']['property_id'],'contact_email',true));
			add_post_meta($lead_id, 'lead_created_from', 'guest_user' );
			
			
			
			
			$subject = "New Lead Submission";
			$to = get_option('admin_email');
			$msg  = __( '<h4>Hello Admin,</h4>') . "\r\n\r\n";
			$msg .= '<p>A new lead Submission by guest user with following Details:</p>';
			$msg .= '<p>Name:'.$_POST['guest_name'] .'</p>';
			$msg .= '<p>Email:'.$_POST['guest_email'] .'</p>';
			$msg .= '<p>Phone:'.$_POST['guest_phone'] .'</p>';
			$msg .= '<p>Property link: <a href="'.site_url() .'/single-property/?property_id='.$_SESSION['action']['property_id'].'">'.site_url().'/single-property/?property_id='.$_SESSION['action']['property_id'].'</a></p>';
			$msg .= '<p>Requirements:</p><p>'.$_POST['guest_summary'] .'</p>';
			$msg .=  '<p>Thanks!<p>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
		    $mail = wp_mail($to, $subject, $msg,$headers);
			if($mail){
			
			    $success_msg = "We have recieved your request for property. We will contact you soon";
				
				
			   
			}
		
		}
		
}


/*----------------- Facebook Login -------------------------*/

$client_id = '675017533078473'; // Facebook APP Client ID
$client_secret = 'a2183f77e4e5c2944b2c5f1ed9fcabb6'; // Facebook APP Client secret
$redirect_uri = 'http://localhost/nycrooms/tenant-registration/'; // URL of page/file that processes a request
 
 
 
// in our case we ask facebook to redirect to the same page, because processing code is also here
// processing code
if ( isset( $_GET['code'] ) && $_GET['code'] ) {
 
	// first of all we should receive access token by the given code
	$params = array(
		'client_id'     => $client_id,
		'redirect_uri'  => $redirect_uri,
		'client_secret' => $client_secret,
		'code'          => $_GET['code'] 
	);
 
	// connect Facebook Grapth API using WordPress HTTP API
	$tokenresponse = wp_remote_get( 'https://graph.facebook.com/v2.7/oauth/access_token?' . http_build_query( $params ) );
 
	$token = json_decode( wp_remote_retrieve_body( $tokenresponse ) );
 
	if ( isset( $token->access_token )) {
 
		// now using the access token we can receive informarion about user
		$params = array(
			'access_token'	=> $token->access_token,
			'fields'		=> 'id,name,email,picture,link,locale,first_name,last_name' // info to get
		);
 
		// connect Facebook Grapth API using WordPress HTTP API
		$useresponse = wp_remote_get('https://graph.facebook.com/v2.7/me' . '?' . urldecode( http_build_query( $params ) ) );
 
		$fb_user = json_decode( wp_remote_retrieve_body( $useresponse ) );
        
		 // if ID and email exist, we can try to create new WordPress user or authorize if he is already registered
		if ( isset( $fb_user->id ) && isset( $fb_user->email ) ) {
 
			// if no user with this email, create him
			if( !email_exists( $fb_user->email ) ) {
 
				$userdata = array(
					'user_login'  =>  $fb_user->email,
					'user_pass'   =>  wp_generate_password(), // random password, you can also send a notification to new users, so they could set a password themselves
					'user_email' => $fb_user->email,
					'first_name' => $fb_user->first_name,
					'last_name' => $fb_user->last_name,
					'role'  => 'tenant'
				);
				$user_id = wp_insert_user( $userdata );
				
				update_user_meta( $user_id, 'facebook', $fb_user->link );
				
				
				
				
				
 
			} else {
				// user exists, so we need just get his ID
				$user = get_user_by( 'email', $fb_user->email );
				$user_id = $user->ID;
				
			}
			
			if( $user_id ) {
			    wp_set_auth_cookie( $user_id, true );
				wp_redirect( home_url() . '/my-profile-tenant/');
				exit;
			}
 
		}
 
	}
}
?>

<?php
 
$params = array(
	'client_id'     => $client_id,
	'redirect_uri'  => $redirect_uri,
	'response_type' => 'code',
	'scope'         => 'email'
);
 
$login_url = 'https://www.facebook.com/dialog/oauth?' . urldecode( http_build_query( $params ) );

/*----------------- Google Login  ---------------------*/

// init configuration
$clientID = '442563866929-35p9pvj6om2jepgi700mgs0blocjh839.apps.googleusercontent.com';
$clientSecret = '3mzvZQJVFDFBbTQhOO5EOcZx';
$redirectUri = 'http://localhost/nycrooms/tenant-registration/';
  
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  if(isset($google_account_info->email) && isset($google_account_info->id)){
  
         // if no user with this email, create him
			if( !email_exists( $google_account_info->email ) ) {
 
				$userdata = array(
					'user_login'  =>  $google_account_info->email,
					'user_pass'   =>  wp_generate_password(), // random password, you can also send a notification to new users, so they could set a password themselves
					'user_email' => $google_account_info->email,
					'first_name' => $google_account_info->givenName,
					'last_name' =>  $google_account_info->familyName,
					'role'  => 'tenant'
				);
				$user_id = wp_insert_user( $userdata );
				
				
 
			} else {
				// user exists, so we need just get his ID
				$user = get_user_by( 'email', $google_account_info->email );
				$user_id = $user->ID;
				
			}
			
			if( $user_id ) {
			    wp_set_auth_cookie( $user_id, true );
				wp_redirect( home_url() . '/my-profile-tenant/');
				exit;
			}
			
  
  
  }
  
 
  // now you can use this profile info to create account in your website and make user logged in.
} else {
  $google_uri = $client->createAuthUrl();
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
	<a href = "<?php echo $google_uri; ?>"><button class="button social-login via-gplus"><i class="fa fa-google-plus"></i> Log In With Google Plus</button></a>
	<a href="<?php echo $login_url ?>"><button class="button social-login via-facebook"><i class="fa fa-facebook"></i> Log In With Facebook</button></a>

	<!--Tab -->
	<div class="my-account style-1 margin-top-5 margin-bottom-40">

		<ul class="tabs-nav">
			<li class=""><a href="#tab1">Log In</a></li>
			<li><a href="#tab2">Register</a></li>
			<li><a href="#tab3">Guest Checkout</a></li>
		</ul>

		<div class="tabs-container alt">

			<!-- Login -->
			<div class="tab-content" id="tab1" style="display: none;">
			     <label class="form_errors" align="center"><?php echo $loginerror; ?></label>
				 <?php if(isset($_GET['action']) && $_GET['action'] == "reset_success") {?>
				      <label class="reset_success" align="center"><?php echo "Your New Password has been reset successfully.You can Login now with new credentials sent to your e-mail"; ?></label>
					 
					  
				 <?php }
                   if($success_msg):
				 ?>
				       <label class="reset_success" align="center"><?php echo $success_msg ;?></label>
				  <?php
				  endif;
				  ?>
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

			<!-- Register -->
			<div class="tab-content" id="tab2" style="display: none;">
                
				<form method="post" class="register"  action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
					
				<p class="form-row form-row-wide">
					<label for="username2">Username:
						<i class="im im-icon-Male"></i>
						<input type="text" class="input-text" name="username" id="username2" value="" />
					</label>
					<label class="form_errors"><?php if(!empty($errors['username'])){ echo $errors['username'];} ?></label>
				</p>
					
				<p class="form-row form-row-wide">
					<label for="email2">Email Address:
						<i class="im im-icon-Mail"></i>
						<input type="text" class="input-text" name="email" id="email2" value="" />
					</label>
					<label class="form_errors"><?php if(!empty($errors['email'])){ echo $errors['email'];} ?></label>
				</p>

				<p class="form-row form-row-wide">
					<label for="password1">Password:
						<i class="im im-icon-Lock-2"></i>
						<input class="input-text" type="password" name="password1" id="password1"/>
					</label>
					<label class="form_errors"><?php if(!empty($errors['password'])){ echo $errors['password'];} ?></label>
				</p>

				<p class="form-row form-row-wide">
					<label for="password2">Repeat Password:
						<i class="im im-icon-Lock-2"></i>
						<input class="input-text" type="password" name="password2" id="password2"/>
					</label>
					<label class="form_errors"><?php if(!empty($errors['password_confirmation'])){ echo $errors['password_confirmation'];} ?></label>
				</p>

				<p class="form-row">
					<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
				</p>

				</form>
			</div>
			
			<!-- Guest Checkout -->
			<div class="tab-content" id="tab3" style="display: none;">
				<form method="post" class="guest--checkout">
					
							<p class="form-row form-row-wide">
								<label for="username2">Name:
									<i class="im im-icon-Male"></i>
									<input type="text" class="input-text" name="guest_name" id="username2" value="" />
								</label>
							</p>
								
							<p class="form-row form-row-wide">
								<label for="email2">Email Address:
									<i class="im im-icon-Mail"></i>
									<input type="text" class="input-text" name="guest_email" id="email2" value="" />
								</label>
							</p>

							<p class="form-row form-row-wide">
								<label for="password1">Phone:
									<i class="im im-icon-Phone"></i>
									<input type="tel" id="phone" name="guest_phone">
								</label>
							</p>

							<p class="form-row form-row-wide guest-check-descp-sec">
								<label for="password2">Descprition:
									<i class="im im-icon-Lock-2"></i>
									<textarea class="WYSIWYG" name="guest_summary" id="summary" spellcheck="true"></textarea>
								</label>
							</p>

							<p class="form-row">
								<input type="submit" class="button border fw margin-top-10" name="guest_checkout" value="Submit" />
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