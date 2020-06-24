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
    if ( is_page('admin/deals') ) {
        include get_stylesheet_directory() . '/my-templates/admin/all-deals.php';
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
			$loginoutlink = '<a href="'.wp_logout_url(get_page_link()).'">Log out</a>';
			ob_end_clean();
			$items .= '<li>'. $loginoutlink .'</li>';			
		}
	return $items;
}

function nyc_get_count_custom_post_type($type){
	$args = array(
	'post_type'=> $type,
	'post_status' => array('publish'),
	'posts_per_page'   => -1,
	'suppress_filters' => false,
	);

	$deals = new WP_Query( $args );
	$count = $deals->found_posts;
	return ($count) ? $count: 0;
}

function nyc_delete_deal_ajax(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_delete_deal_ajax'){
	   $deal=wp_delete_post($_POST['deal_id']);
	   if($deal){
		   echo 'success';
	   }
	}
	exit;
}
add_action( 'wp_ajax_nyc_delete_deal_ajax', 'nyc_delete_deal_ajax' );
add_action( 'wp_ajax_nopriv_nyc_delete_deal_ajax', 'nyc_delete_deal_ajax' );

function nyc_bulk_delete_deal(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_bulk_delete_deal'){
		global $wpdb;
		if($_POST['bulkaction'] == 'delete'){
			foreach($_POST['data'] as $ids){
			  wp_delete_post($ids);
			}
			echo "true";
		}
	}
	exit;
}
add_action( 'wp_ajax_nyc_bulk_delete_deal', 'nyc_bulk_delete_deal' );
add_action( 'wp_ajax_nopriv_nyc_bulk_delete_deal', 'nyc_bulk_delete_deal' );

add_action('init', 'dcc_rewrite_tags');
function dcc_rewrite_tags() {
    add_rewrite_tag('%view%', '([^&]+)');
    add_rewrite_tag('%id%', '([^&]+)');
}

add_action('init', 'dcc_rewrite_rules');
function dcc_rewrite_rules() {
	add_rewrite_rule('^admin/deals/([^/]+)/([^/]+)/?$','index.php?pagename=admin/deals&view=$matches[1]&id=$matches[2]','top');
}


add_filter( 'template_redirect', 'prefix_url_rewrite_templates',1 );
 
function prefix_url_rewrite_templates() {
	if(get_query_var('view') == 'details' && !empty(get_query_var('view'))){
	  include get_stylesheet_directory() . '/my-templates/admin/deal-detail.php';
	  exit;
	}
}

add_action( 'wp_ajax_demo-pagination-load-posts', 'cvf_demo_pagination_load_posts' );

add_action( 'wp_ajax_nopriv_demo-pagination-load-posts', 'cvf_demo_pagination_load_posts' ); 

function cvf_demo_pagination_load_posts() {

    global $wpdb;
    // Set default variables
    $msg = '';
    if(isset($_POST['page'])){
        // Sanitize the received page   
		$selected_property = get_post_meta($_POST['deal_id'], 'selected_property', true);
        $page = sanitize_text_field($_POST['page']);
        $cur_page = $page;
        $page -= 1;
        // Set the number of results to display
        $per_page = 3;
        $previous_btn = true;
        $next_btn = true;
        $first_btn = true;
        $last_btn = true;
        $start = $page * $per_page;

        $properties = new WP_Query(
            array(
                'post_type'         => 'property',
                'post_status '      => array('available'),
                'orderby'           => 'post_date',
                'order'             => 'DESC',
                'posts_per_page'    => $per_page,
                'offset'            => $start,
				'post__not_in'		=> $selected_property,
            )
        );

        $count = new WP_Query(
            array(
                'post_type'         => 'property',
                'post_status '      => array('available'),
                'posts_per_page'    => -1,
				'post__not_in'		=> $selected_property,
            )
        );
		$count = $count->post_count; 
		$msg .= '<table class="manage-table responsive-table deal-suggestproperty-table">
				<tbody>
				<tr>
					<th><i class="fa fa-check-square-o"></i> Select</th>
					<th class="deal-suggest-proptab-prop"><i class="fa fa-file-text"></i> Property</th>
					<th><i class="fa fa-user"></i> Owner</th>
				</tr>';
        // Loop into all the posts
        if ( $properties->have_posts() ) {
			while ( $properties->have_posts() ) { 
                $properties->the_post();
				$property_id = get_the_ID();
				$auth = get_post($property_id);
				$authid = $auth->post_author;
				$address = get_post_meta($property_id, 'address',true)." ";
				$address .= get_post_meta($property_id, 'city',true)." ";
				$address .= get_post_meta($property_id, 'state',true).", ";
				$address .= get_post_meta($property_id, 'zip',true)." ";	
				$price = get_post_meta($property_id, 'price',true);
				$status = get_post_meta($property_id, 'status',true);					
				// Set the desired output into a variable
				$msg .='<tr>
							<td class="select_property"><input class="check_property" type="checkbox" value="'.$property_id.'" name="check"></td>
							<td class="title-container">
								<img src="'.wp_get_attachment_url(get_post_meta($property_id,'file_0',true)).'" alt="">
								<div class="title">
									<h4><a href="#">'.get_the_title().'</a></h4>
									<span>'.$address.'</span>
									<span class="table-property-price">$'.$price.' / Weekly</span> <span class="active--property">'.ucfirst(get_post_status()).'</span>
								</div>
							</td>
							<td>
								<div class="owner--name">'.get_the_author_meta( 'display_name' , $authid).'</div>
							</td>
						</tr>';
				}
        }else{
			$msg .='<tr colsapan="3"><td>No property founds!</td></tr>';
		}
		wp_reset_query();
		$msg .= '</tbody></table>';

        // This is where the magic happens
        $no_of_paginations = ceil($count / $per_page);

        if ($cur_page >= 7) {
            $start_loop = $cur_page - 3;
            if ($no_of_paginations > $cur_page + 3)
                $end_loop = $cur_page + 3;
            else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                $start_loop = $no_of_paginations - 6;
                $end_loop = $no_of_paginations;
            } else {
                $end_loop = $no_of_paginations;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 7)
                $end_loop = 7;
            else
                $end_loop = $no_of_paginations;
        }

        // Pagination Buttons logic     
        $pag_container .= "
        <div class='cvf-universal-pagination'>
            <ul>";

        if ($first_btn && $cur_page > 1) {
            $pag_container .= "<li p='1' class='active'>First</li>";
        } else if ($first_btn) {
            $pag_container .= "<li p='1' class='inactive'>First</li>";
        }

        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $pag_container .= "<li p='$pre' class='active'>Previous</li>";
        } else if ($previous_btn) {
            $pag_container .= "<li class='inactive'>Previous</li>";
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {

            if ($cur_page == $i)
                $pag_container .= "<li p='$i' class = 'selected' >{$i}</li>";
            else
                $pag_container .= "<li p='$i' class='active'>{$i}</li>";
        }

        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            $pag_container .= "<li p='$nex' class='active'>Next</li>";
        } else if ($next_btn) {
            $pag_container .= "<li class='inactive'>Next</li>";
        }

        if ($last_btn && $cur_page < $no_of_paginations) {
            $pag_container .= "<li p='$no_of_paginations' class='active'>Last</li>";
        } else if ($last_btn) {
            $pag_container .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
        }

        $pag_container = $pag_container . "
            </ul>
        </div>";

        // We echo the final output
        echo $msg. 
        '<div class = "cvf-pagination-nav">' . $pag_container . '</div>';

    }
    // Always exit to avoid further execution
    exit();
}

add_action( 'wp_ajax_nyc-deal-select-property-assign', 'nyc_deal_property_assign' );
add_action( 'wp_ajax_nopriv_nyc-deal-select-property-assign', 'nyc_deal_property_assign' ); 
function nyc_deal_property_assign(){
	if(isset($_POST['propertyArray'])){
		$propertyArray = $_POST['propertyArray'];
		$deal_id = $_POST['deal_id'];
		$meta_key = 'selected_property';
		$new_data = get_post_meta($deal_id, $meta_key, true);
		foreach($propertyArray as $property){
			if(!in_array($property, $new_data)){
				$new_data[] = $property;
			}
		}
		update_post_meta($deal_id,$meta_key,$new_data);
	}
	exit;
}

add_action( 'wp_ajax_nyc-deal-remove-property-assign', 'nyc_deal_property_remove' );
add_action( 'wp_ajax_nopriv_nyc-deal-remove-property-assign', 'nyc_deal_property_remove' ); 
function nyc_deal_property_remove(){
	if(isset($_POST['deal_id'])){
		$deal_id = $_POST['deal_id'];
		$new_value = $_POST['property_id'];
		$meta_key = 'selected_property';
		$old_data = get_post_meta($deal_id, $meta_key, true);
		foreach($old_data as $property){
			if(in_array($new_value, $old_data)){
				$pos = array_search($new_value, $old_data);
				unset($old_data[$pos]);
			}
		}
		update_post_meta($deal_id,$meta_key,$old_data);
	}
	exit;
}

add_action( 'wp_ajax_nyc-deal-send-email', 'nyc_deal_send_email' );
add_action( 'wp_ajax_nopriv_nyc-deal-send-email', 'nyc_deal_send_email' ); 
function nyc_deal_send_email(){
	if(isset($_POST['deal_id'])){
		$deal_id = $_POST['deal_id'];
		$user_email = get_post_meta($deal_id,'email',true);
		$selectedAgent = get_post_meta($deal_id, 'selectedAgent', true);
		$tenant_deal_link = get_site_url().'/tenant/deal-details/?id='.$deal_id;
		$agent_deal_link = get_site_url().'/agent/deal-details/?id='.$deal_id;
		if($user_email){
			$message  = __( 'Hi there,' ) . "\r\n\r\n";
			$message .= sprintf( __( "Welcome to %s! Here's the link where you can check deal details:" ), get_option('blogname') ) . "\r\n\r\n";
			$message .= sprintf( __('Link : %s'), $tenant_deal_link ) . "\r\n\r\n";
			$message .= sprintf( __('If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "\r\n\r\n";
			$message .= __( 'Thanks!' );
			if($user_email){
				$mail_send = wp_mail($user_email, sprintf(__('[%s] Deal Created Successfully'), get_option('blogname')), $message);	
			}
		}
		if($selectedAgent){
			$user = get_userdata($selectedAgent);
			$message  = __( 'Hi there,' ) . "\r\n\r\n";
			$message .= sprintf( __( "Welcome to %s! You are assigned for tenant deals. Click on the link for more details.:" ), get_option('blogname') ) . "\r\n\r\n";
			$message .= sprintf( __('Link : %s'), $agent_deal_link ) . "\r\n\r\n";
			$message .= sprintf( __('If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "\r\n\r\n";
			$message .= __( 'Thanks!' );
			if($user->user_email){
				$mail_send = wp_mail($user->user_email, sprintf(__('[%s] Assigned for deals'), get_option('blogname')), $message);	
			}			
		}
	}
	exit;
}

add_action( 'wp_ajax_nyc-deal-select-agent', 'nyc_deal_select_agent' );
add_action( 'wp_ajax_nyc-deal-select-agent', 'nyc_deal_select_agent' ); 
function nyc_deal_select_agent(){
	if(isset($_POST['deal_id'])){
		$deal_id = $_POST['deal_id'];
		$selectedAgent = $_POST['selectedAgent'];
		if($selectedAgent != '-1'){
			update_post_meta($deal_id,'selectedAgent',$selectedAgent);
			echo "Agent assign successfully";
		}else{
			delete_post_meta($deal_id,'selectedAgent');
			echo "Agent removed successfully";
		}
	}
	exit;
}

?>