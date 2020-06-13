<?php
function nyc_count_user_by_role($roles=''){
	$args = array(   
		'role__in' => $roles,
		'count_total' => true
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
?>