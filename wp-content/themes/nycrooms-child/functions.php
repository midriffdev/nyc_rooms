<?php
/* 
 * Child theme functions file
 * 
 */
add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}
function zakra_child_enqueue_styles() {

	$parent_style = 'zakra-style'; //parent theme style handle 'zakra-style'

	//Enqueue parent and chid theme style.css
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' ); 
	wp_enqueue_style( 'zakra_child_style',
	    get_stylesheet_directory_uri() . '/style.css',
	    array( $parent_style ),
	    wp_get_theme()->get('Version')
	);
	
	wp_enqueue_style( 'color-css', get_stylesheet_directory_uri().'/css/color.css');
	
}
add_action( 'wp_enqueue_scripts', 'zakra_child_enqueue_styles' );

function xx__update_custom_roles() {
       add_role( 'property_owner', 'Property Owner', array( 'read' => true, 'level_0' => true ) );
	   add_role( 'tenant', 'Tenant', array( 'read' => true, 'level_0' => true ) );
	   
}
add_action( 'init', 'xx__update_custom_roles' );

add_action('wp_footer', 'hide_login_menu_for_logged_in_user');

function hide_login_menu_for_logged_in_user(){
if(is_user_logged_in()){
?>
<style>
.menu-item-object-page.menu-item-36{display: none !important;}
.menu-item-object-page.menu-item-81{display: none !important;}
</style> 
<?php
} else {
?>
<style>
.menu-item-object-page.menu-item-37{display: none !important;}
</style> 
<?php
}
}

add_filter( 'wp_new_user_notification_email', 'custom_wp_new_user_notification_email', 10, 3 );
function custom_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {
 
    $user_login = stripslashes( $user->user_login );
    $user_email = stripslashes( $user->user_email );
	if($user->roles[0] == "tenant"){
        $login_url  = home_url().'/tenant-registration/';
	} else if($user->roles[0] == "property_owner"){
        $login_url  =  home_url().'/login-register/';
	}
    $message  = __( '<p>Hi there,</p>' );
    $message .= sprintf( __( "<p>Welcome to %s!</p><p>Here's how to log in:</p><p>"), get_option('blogname') );
    $message .= $login_url ."</p><p>";
    $message .= sprintf( __('Username: %s'), $user_login ) ."</p><p>";
    $message .= sprintf( __('Email: %s'), $user_email ) . "</p>";
    $message .= __( '<p>Password: The one you entered in the registration form. (For security reason, we save encripted password)</p>' );
    $message .= sprintf( __('<p>If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "</p>";
    $message .= __( '<p>bye!</p>' );
 
    $wp_new_user_notification_email['subject'] = sprintf( '[%s] New User Registration', $blogname );
    $wp_new_user_notification_email['headers'] = array('Content-Type: text/html; charset=UTF-8');
    $wp_new_user_notification_email['message'] = $message;
 
    return $wp_new_user_notification_email;
}



function kv_forgot_password_reset_email($user_input) {
 	global $wpdb; 
 	$user_data = get_user_by( 'email', $user_input ); 
 	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;
 
 	$key = $wpdb->get_var("SELECT user_activation_key FROM $wpdb->users WHERE user_login ='".$user_login."'");
 	if(empty($key)) {
 	//generate reset key
		 $key = wp_generate_password(20, false);
		 $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
	 }
 
 	$message = __('Someone requested that the password be reset for the following account:') . "<br><br><br>";
 	$message .= get_option('siteurl') . "<br><br>";
 	$message .= sprintf(__('Username: %s'), $user_login) . "<br><br><br>";
 	$message .= __('If this was a error, just ignore this email as no action will be taken.') . "<br><br>";
 	$message .= __('To reset your password, visit the following address:') . "<br><br>";
 	$message .= '<a href="'.tg_validate_url() . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login) . '" > '.tg_validate_url() . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login) ."</a><br><br>";
    $headers = array('Content-Type: text/html; charset=UTF-8');
	 
 	if ( $message && !wp_mail($user_email, 'Password Reset Request', $message,$headers) ) {
 	$msg = false ; 
 	}
	 else $msg = true; 

 	return $msg ; 
}
function tg_validate_url() {
	
	$page_url = site_url().'/reset-password/';
	$urlget = strpos($page_url, "?");
	if ($urlget === false) {
		$concate = "?";
	} else {
		$concate = "&";
	}
	return $page_url.$concate;
}

function kv_rest_setting_password($reset_key, $user_login, $user_email, $ID ,$new_password) {
 
  	 $new_password = $new_password; //you can change the number 7 to whatever length needed for the new password
 	 wp_set_password( $new_password, $ID ); //mailing the reset details to the user
     $checkuserrole = get_user_meta($ID,'nyc_capabilities',true);
     $userrole      =  array_keys($checkuserrole);
	 $user_role      =  $userrole[0];
	 
  	 $message = __('Your new password for the account at:') . "<br><br>";
 	 $message .= get_bloginfo('name') . "<br><br>";
 	 $message .= sprintf(__('Username: %s'), $user_login) . "<br><br>";
  	 $message .= sprintf(__('Password: %s'), $new_password) . "<br><br>";
	 if($user_role == 'property_owner'){
 	 $message .= __('You can now login with your new password at: ').'<a href="'.get_option('siteurl')."/login-register/" .'" >' . get_option('siteurl')."/login-register/" . "</a> <br><br>";
	 } else if($user_role == 'tenant'){
	  $message .= __('You can now login with your new password at: ').'<a href="'.get_option('siteurl')."/tenant-registration/" .'" >' . get_option('siteurl')."/tenant-registration/" . "</a> <br><br>";
	 }
      $headers = array('Content-Type: text/html; charset=UTF-8');
  	if ( $message && !wp_mail($user_email, 'Your New Password to login into eimams', $message,$headers) ) {
  	 	$msg = false; 
 	 } else {
  	 	$msg = true; 
  	} 

  	return $msg; 
}
