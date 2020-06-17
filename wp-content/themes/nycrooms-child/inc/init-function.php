<?php
function nyc_count_user_by_role($roles=''){
	$args = array(   
		'role__in' => $roles,
		'count_total' => true
	);
	$users = new WP_User_Query($args);
	return $users->get_total();
}

function nyc_count_user_by_role_today($roles=''){
	$args = array(   
		'role__in' => $roles,
		'count_total' => true,
		'date_query' => [
			[ 'after'  => 'today', 'inclusive' => true ],
		],
	);
	$users = new WP_User_Query($args);
	return $users->get_total();
}

function nyc_all_user_by_role($roles=''){
	$args = array(
		'role'    => $roles,
		'orderby' => 'user_nicename',
		'order'   => 'ASC'
	);
	$users = get_users( $args );
	return $users;
}

function previous_user_trailingslashit( $label = null ) {
    $class = "class='prev'";
	return $class;
}
add_filter( 'previous_posts_link_attributes', 'previous_user_trailingslashit' );

function next_user_trailingslashit( $label = null ) {
    $class = "class='next'";
	return $class;
}
add_filter( 'next_posts_link_attributes', 'next_user_trailingslashit' );

function nyc_delete_tenant_ac_ajax(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_delete_tenant_ac_ajax'){
	   $user=wp_delete_user($_POST['tenant_id']);
	   if($user){
		   echo 'success';
	   }
	}
	exit;
}
add_action( 'wp_ajax_nyc_delete_tenant_ac_ajax', 'nyc_delete_tenant_ac_ajax' );
add_action( 'wp_ajax_nopriv_nyc_delete_tenant_ac_ajax', 'nyc_delete_tenant_ac_ajax' );


add_action( 'template_redirect', function(){
    if ( is_page('admin') ) {
        include get_stylesheet_directory() . '/my-templates/admin/dashboard.php';
        die;
    }
    if ( is_page('admin/edit-profile') ) {
        include get_stylesheet_directory() . '/my-templates/admin/edit-profile.php';
        die;
    }
    if ( is_page('admin/all-tenants') ) {
        include get_stylesheet_directory() . '/my-templates/admin/all-tenants.php';
        die;
    }
    if ( is_page('admin/add-tenant') ) {
        include get_stylesheet_directory() . '/my-templates/admin/add-tenant.php';
        die;
    }
    if ( is_page('tenant') ) {
        include get_stylesheet_directory() . '/my-templates/tenant/profile.php';
        die;
    }
    if ( is_page('tenant/active-properties') ) {
        include get_stylesheet_directory() . '/my-templates/tenant/active-properties.php';
        die;
    }	
    if ( is_page('tenant/bookmarked-properties') ) {
        include get_stylesheet_directory() . '/my-templates/tenant/bookmark-properties.php';
        die;
    }	
    if ( is_page('tenant/past-properties') ) {
        include get_stylesheet_directory() . '/my-templates/tenant/past-properties.php';
        die;
    }		
    if ( is_page('tenant/contracts') ) {
        include get_stylesheet_directory() . '/my-templates/tenant/contracts.php';
        die;
    }	
} );

function nyc_user_profile_image_upload($FILES,$name,$userid){
		$uploaddir = wp_upload_dir();
		$tmp_file = $FILES[$name]["tmp_name"];
		$uploadfile = $uploaddir['path'] . '/' . $FILES[$name]['name'];
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
	   update_user_meta($userid,'profile_picture', $attach_id);
}

add_action( 'wp_ajax_nopriv_nyc_bulk_action_user', 'nyc_bulk_action_user' );
add_action( 'wp_ajax_nyc_bulk_action_user', 'nyc_bulk_action_user' );
function nyc_bulk_action_user() {
	global $wpdb;
	if($_POST['bulkaction'] == 'delete'){
		foreach($_POST['data'] as $ids){
		  wp_delete_user($ids);
		}
		echo "true";
	}
	if($_POST['bulkaction'] == 'active'){
		foreach($_POST['data'] as $ids){
		 update_user_meta( $ids, 'user_status','active');
		}
		echo "true";
	}
	if($_POST['bulkaction'] == 'inactive'){
		foreach($_POST['data'] as $ids){
		 update_user_meta( $ids, 'user_status','inactive');
		}
		echo "true";
	}
	wp_die();
}

add_action( 'wp_ajax_nopriv_nyc_export_as_CSV', 'nyc_export_as_CSV' );
add_action( 'wp_ajax_nyc_export_as_CSV', 'nyc_export_as_CSV' );
function nyc_export_as_CSV($ids='') {
	ob_start();
	$csv = '';
	$headers = array(
		'S NO',
		'Account ID',
		'Display Name',
		'Email',
		'Phone',
		'Date'
	);
	$args = array(
		'role'   	  => 'tenant',
	);
	if($ids){
		$args['include']=explode(",",$ids);
	}
	$users = get_users($args);
	$handle = fopen('php://output', 'w'); 
	fputcsv($handle, $headers, ',', '"');

	foreach($users as $key=>$results1)
	{
		$row = array(
			$key+1,
			$results1->data->ID,
			$results1->data->display_name,
			$results1->data->user_email,
			get_user_meta($results1->data->ID,'user_phone',true),
			date('Y-m-d',strtotime($results1->data->user_registered))
		);

		fputcsv($handle, $row, ',', '"');
	}


	$now = gmdate('D, d M Y H:i:s') . ' GMT';

	header('Content-Type: text/csv');
	header('Expires: ' . $now);

	header('Content-Disposition: attachment; filename="referrals.csv"');
	header('Pragma: no-cache'); 

	echo $csv; 
	exit();
}
function nyc_wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);

	$message  = sprintf(__('New user registration on your blog %s:'), get_option('blogname')) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n";
	$message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";
	wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message);

	if ( empty($plaintext_pass) )
		return;

    $user_login = stripslashes( $user->user_login );
    $user_email = stripslashes( $user->user_email );
    $login_url  = wp_login_url();
    $message  = __( 'Hi there,' ) . "\r\n\r\n";
    $message .= sprintf( __( "Welcome to %s! Here's how to log in:" ), get_option('blogname') ) . "\r\n\r\n";
    $message .= wp_login_url() . "\r\n";
    $message .= sprintf( __('Username: %s'), $user_login ) . "\r\n";
    $message .= sprintf( __('Email: %s'), $user_email ) . "\r\n";
    $message .= sprintf( __('Password: %s'), $plaintext_pass ) . "\r\n";
    $message .= sprintf( __('If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "\r\n\r\n";
    $message .= __( 'bye!' );

	wp_mail($user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message);
}

function nyc_tenant_check_authentication(){
	if(!is_user_logged_in()){
     header( 'Location:' . site_url() . '/tenant-registration/');
	}
	$user = wp_get_current_user();
	if($user->roles[0] == "property_owner"){
		header( 'Location:' . site_url() . '/my-profile/');
	} else if($user->roles[0] == "administrator"){
	   header( 'Location:' . site_url() . '/admin/');
	}
}

function nyc_remove_add_to_favorite() {
    // Get the existing meta for 'meta_key'
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_remove_add_to_favorite'){
		$user_id=get_current_user_id(); 
		if($user_id){
		$meta_key='nyc_bookmark';
		$new_value=$_POST['property_id'];
		$new_data = array();
		$old_data= get_user_meta($user_id, $meta_key, true);
		if(in_array($new_value, $old_data)){
		$pos = array_search($new_value, $old_data);
		unset($old_data[$pos]);
		}else{
			$new_data[] = $new_value;
		}
		foreach($old_data as $data){
			$new_data[] = $data;
		}
		update_user_meta($user_id, $meta_key, $new_data);
		}else{
			echo "false";
		}
	}
	exit;
}
add_action( 'wp_ajax_nyc_remove_add_to_favorite', 'nyc_remove_add_to_favorite' );
add_action( 'wp_ajax_nopriv_nyc_remove_add_to_favorite', 'nyc_remove_add_to_favorite' );

add_filter('wp_nav_menu_items', 'add_login_logout_link' , 10, 2 );
function add_login_logout_link($items, $args) {
		ob_start();
		if(is_user_logged_in()){
			$loginoutlink = '<a href="'.wp_logout_url(home_url()).'">Log out</a>';
			ob_end_clean();
			$items .= '<li>'. $loginoutlink .'</li>';			
		}
	return $items;
}
?>