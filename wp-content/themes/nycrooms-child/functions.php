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
	
	wp_enqueue_script( 'property-js', get_stylesheet_directory_uri().'/scripts/property.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'property-js', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	
}
add_action( 'wp_enqueue_scripts', 'zakra_child_enqueue_styles' );

function xx__update_custom_roles() {
       add_role( 'property_owner', 'Property Owner', array( 'read' => true, 'level_0' => true ) );
       add_role( 'sales_agent', 'Sales Agent', array( 'read' => true, 'level_0' => true ) );
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


//Create a custom post type property
add_action( 'init', 'nyc_create_custom_post_property', 0 );
function nyc_create_custom_post_property() {
	$labels = array(
		'name'                => __( 'Properties' ),
		'singular_name'       => __( 'property'),
		'menu_name'           => __( 'Properties'),
		'parent_item_colon'   => __( 'Parent Property'),
		'all_items'           => __( 'All Properties'),
		'view_item'           => __( 'View Property'),
		'add_new_item'        => __( 'Add New Property'),
		'add_new'             => __( 'Add New'),
		'edit_item'           => __( 'Edit Property'),
		'update_item'         => __( 'Update Property'),
		'search_items'        => __( 'Search Property'),
		'not_found'           => __( 'Not Found'),
		'not_found_in_trash'  => __( 'Not found in Trash')
	);
	$args = array(
		'label'               => __( 'properties'),
		'description'         => __( 'Best Properties'),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
		'public'              => true,
		'hierarchical'        => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'has_archive'         => true,
		'can_export'          => true,
		'exclude_from_search' => false,
	    'yarpp_support'       => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);
	register_post_type( 'property', $args );

	$cat_labels = array(
		'name' => _x( 'Types', 'taxonomy general name' ),
		'singular_name' => _x( 'Type', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Types' ),
		'all_items' => __( 'All Types' ),
		'parent_item' => __( 'Parent Type' ),
		'parent_item_colon' => __( 'Parent Type:' ),
		'edit_item' => __( 'Edit Type' ), 
		'update_item' => __( 'Update Type' ),
		'add_new_item' => __( 'Add New Type' ),
		'new_item_name' => __( 'New Type Name' ),
		'menu_name' => __( 'Types' ),
	); 	
	register_taxonomy('types',array('property'), array(
		'hierarchical' => true,
		'labels' => $cat_labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'type' ),
	));
}


//Create additional custom post status
function nyc_custom_post_status(){
    register_post_status( 'available', array(
        'label'                     => _x( 'Available', 'property' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Available <span class="count">(%s)</span>', 'Available <span class="count">(%s)</span>' ),
    ) );
    register_post_status( 'rented', array(
        'label'                     => _x( 'Rented', 'property' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Rented <span class="count">(%s)</span>', 'Rented <span class="count">(%s)</span>' ),
    ) );
}
add_action( 'init', 'nyc_custom_post_status' );

// Using jQuery to add it to post status dropdown
function nyc_add_to_post_status_dropdown()
{
	global $post;
	if($post->post_type != 'property')
	return false;
	$status = ($post->post_status == 'available') ? "jQuery( '#post-status-display' ).text( 'Available' );
	jQuery( 'select[name=\"post_status\"]' ).val('available');" : '';
	echo "<script>
	jQuery(document).ready( function() {
	jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"available\">Available</option>' );
	".$status."
	});
	</script>";
	$status1 = ($post->post_status == 'rented') ? "jQuery( '#post-status-display' ).text( 'Rented' );
	jQuery( 'select[name=\"post_status\"]' ).val('rented');" : '';
	echo "<script>
	jQuery(document).ready( function() {
	jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"rented\">Rented</option>' );
	".$status1."
	});
	</script>";
}
add_action( 'post_submitbox_misc_actions', 'nyc_add_to_post_status_dropdown');
function nyc_custom_status_add_in_quick_edit() {
	global $post;
	if($post->post_type != 'property')
	return false;
	echo "<script>
	jQuery(document).ready( function() {
	jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"available\">Available</option>' );
	});
	</script>";
	echo "<script>
	jQuery(document).ready( function() {
	jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"rented\">Rented</option>' );
	});
	</script>";
}
add_action('admin_footer-edit.php','nyc_custom_status_add_in_quick_edit');
function display_archive_state( $states ) {
	global $post;
	if($post->post_status == 'rented'){
	echo "<script>
	jQuery(document).ready( function() {
	jQuery( '#post-status-display' ).text( 'Rented' );
	});
	</script>";
	}
}

add_filter('wp_insert_post_data', 'nyc_post_data_validator', '99');
function nyc_post_data_validator($data) {
  if ($data['post_type'] == 'property') {
    // If post data is invalid then
	if($data['post_status'] == 'publish'){
		$data['post_status'] = 'available';
	}
    add_filter('redirect_post_location', 'nyc_my_post_redirect_filter', '99');
  }
  return $data;
}

function nyc_my_post_redirect_filter($location) {
  remove_filter('redirect_post_location', __FILTER__, '99');
  return add_query_arg('my_message', 1, $location);
}

function nyc_add_property_ajax(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_add_property_ajax'){
		$property_id = wp_insert_post(array (
			'post_type'		=> 'property',
			'post_title' 	=> $_POST['title'],
			'post_content' 	=> $_POST['desc'],
			'post_author' 	=> get_current_user_id(),
			'post_status' 	=> 'draft',
		));
		if ($property_id) {
			wp_set_post_terms($property_id, $_POST['type'], 'types' );
			add_post_meta($property_id, 'status', $_POST['status']);
			add_post_meta($property_id, 'price', $_POST['price']);
			add_post_meta($property_id, 'accomodation', $_POST['accomodation']);
			add_post_meta($property_id, 'rooms', $_POST['rooms']);
			add_post_meta($property_id, 'hear', $_POST['hear']);
			add_post_meta($property_id, 'gender', $_POST['gender']);
			add_post_meta($property_id, 'rm_lang', $_POST['rm_lang']);
			add_post_meta($property_id, 'relationship', $_POST['relationship']);
			add_post_meta($property_id, 'couple_price', $_POST['couple_price']);
			add_post_meta($property_id, 'payment_method', $_POST['payment_method']);
			add_post_meta($property_id, 'address', $_POST['address']);
			add_post_meta($property_id, 'city', $_POST['city']);
			add_post_meta($property_id, 'state', $_POST['state']);
			add_post_meta($property_id, 'zip', $_POST['zip']);
			add_post_meta($property_id, 'agent', $_POST['agent']);
			add_post_meta($property_id, 'amenities', $_POST['amenities']);
			add_post_meta($property_id, 'contact_name', $_POST['contact_name']);
			add_post_meta($property_id, 'contact_email', $_POST['contact_email']);
			add_post_meta($property_id, 'contact_phone', $_POST['contact_phone']);
			add_post_meta($property_id, 'gallery_files', $_POST['gallery_files']);
			if(isset($_FILES)){
			  foreach($_FILES as $key=>$file){
				  nyc_property_gallery_image_upload($key,$property_id);
			  }
			}
			$subject = "New Property Listed - ".$_POST['title'];
			$to = get_option('admin_email');
			$msg  = __( 'Hello Admin,') . "\r\n\r\n";
			$msg .= sprintf( __( 'A new property listed by %s title is "%s".'), $_POST['contact_name'], $_POST['title'] ) . "\r\n\r\n";
			$msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
		    $sent = wp_mail($to, $subject, $msg);
			echo 'success';
		}else{
		    echo 'false';
		}
	}else{
	    echo 'false';
	}
	exit;
}
add_action( 'wp_ajax_nyc_add_property_ajax', 'nyc_add_property_ajax' );
add_action( 'wp_ajax_nopriv_nyc_add_property_ajax', 'nyc_add_property_ajax' );

function nyc_delete_property_ajax(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_delete_property_ajax'){
	   $post=wp_delete_post($_POST['property_id'],true);
	   if($post){
		   echo 'success';
	   }
	}
	exit;
}
add_action( 'wp_ajax_nyc_delete_property_ajax', 'nyc_delete_property_ajax' );
add_action( 'wp_ajax_nopriv_nyc_delete_property_ajax', 'nyc_delete_property_ajax' );

function nyc_property_gallery_image_upload($file_name,$post_id){
		$uploaddir = wp_upload_dir();
		$tmp_file = $_FILES[$file_name]["tmp_name"];
		$uploadfile = $uploaddir['path'] . '/' . $_FILES[$file_name]['name'];
		move_uploaded_file($tmp_file, $uploadfile);
		$wp_filetype = wp_check_filetype(basename($uploadfile), null);
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($uploadfile)),
			'post_status' => 'inherit',
		);
	   $attach_id = wp_insert_attachment($attachment, $uploadfile); // adding the image to th media
	   require_once(ABSPATH . 'wp-admin/includes/image.php');
	   $attach_data = wp_generate_attachment_metadata($attach_id, $uploadfile);
	   $update = wp_update_attachment_metadata($attach_id, $attach_data); // Updated the image details
	   add_post_meta($post_id, $file_name, $attach_id);
}

function nyc_property_owner_authority(){
	if( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;
		if(!in_array('property_owner',$roles)){
		   wp_redirect(home_url());
		}
	}else{
		wp_redirect(home_url());
	}
}

function nyc_get_properties_by_status($status){
	$properties = new WP_Query(array(
		'posts_per_page' 	=> -1,
		'post_type' 		=> 'property',
		'post_status' 		=> $status,
		'author' 			=> get_current_user_id(),
	));
	return $properties;
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
