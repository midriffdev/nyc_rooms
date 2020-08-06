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
    if ( is_page('admin/add-deal') ) {
        include get_stylesheet_directory() . '/my-templates/admin/add-deal.php';
        die;
    }
     
	if ( is_page('admin/dealsorders') ) {
        include get_stylesheet_directory() . '/my-templates/admin/all-orders.php';
        die;
    }
     
	if ( is_page('admin/all-contracts') ) {
        include get_stylesheet_directory() . '/my-templates/admin/all-contracts.php';
        die;
    }
	
	if ( is_page('admin/all-notifications') ) {
        include get_stylesheet_directory() . '/my-templates/admin/all-notification.php';
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
	 
	 if ( is_page('tenant/application-form')) {
        include get_stylesheet_directory() . '/my-templates/tenant/application-form.php';
        die;
     }
	 
	 if ( is_page('tenant/deal-details-tenant')) {
        include get_stylesheet_directory() . '/my-templates/tenant/deal-detail-tenant.php';
        die;
     }
	 
	 if ( is_page('tenant/all-contracts')) {
        include get_stylesheet_directory() . '/my-templates/tenant/all-contracts.php';
        die;
     }
	 
	 if ( is_page('tenant/deals')) {
        include get_stylesheet_directory() . '/my-templates/tenant/all-deals.php';
        die;
     }	 
	 
	 if ( is_page('tenant/hired-property')) {
        include get_stylesheet_directory() . '/my-templates/tenant/hired-property.php';
        die;
     }
	 	 
	 if ( is_page('agent/deal-details-agent')) {
        include get_stylesheet_directory() . '/my-templates/agent/deal-details-agent.php';
        die;
     }
	  
	 if ( is_page('property-owner/all-contracts')) {
        include get_stylesheet_directory() . '/my-templates/property-owner/all-contracts.php';
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
function nyc_export_as_CSV_Prop_Owner($ids='') {
	ob_start();
	$csv = '';
	$headers = array(
		'S NO',
		'Account ID',
		'Owner Name',
		'Email',
		'Phone',
		'Date'
	);
	$args = array(
		'role'   	  => 'property_owner',
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

	header('Content-Disposition: attachment; filename="referralsowners.csv"');
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
		header( 'Location:' . site_url() . '/property-owner/');
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
		     $currentuser = wp_get_current_user();
			  if($currentuser->roles[0] == 'administrator'){
					$loginoutlink = '<a href="'.wp_logout_url(home_url().'/login-admin/').'">Log out</a>';
					ob_end_clean();
					$items .= '<li>'. $loginoutlink .'</li>';
              }
			  
			  if($currentuser->roles[0] == 'property_owner'){
					$loginoutlink = '<a href="'.wp_logout_url(home_url().'/owner-registeration/').'">Log out</a>';
					ob_end_clean();
					$items .= '<li>'. $loginoutlink .'</li>';
              }
			  
			  if($currentuser->roles[0] == 'tenant'){
					$loginoutlink = '<a href="'.wp_logout_url(home_url().'/tenant-registration/').'">Log out</a>';
					ob_end_clean();
					$items .= '<li>'. $loginoutlink .'</li>';
              }
			  
			
		}
		$appointment = '<button class="appointment-button" data-toggle="modal" data-target="#bookappntmntpopup">Book Appointment</button>';
		$items .= '<li>'. $appointment .'</li>';			
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

function nyc_get_count_post_type_meta($type,$key,$value){
	$args = array(
	'post_type'=> $type,
	'post_status' => array('publish'),
	'posts_per_page'   => -1,
	'suppress_filters' => false,
	'meta_query'	=> array(
		array(
            'key'          => $key,
            'value'        => $value,
            'compare'      => '=',
		)
    ),
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

function nyc_delete_single_contract(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_delete_single_contract'){
	    $ids = $_POST['deal_id'];
		$contract_pdf_id = get_post_meta($ids,'contract_pdf', true); 
		$deal_id = get_post_meta($ids,'deal_id', true); 
		update_post_meta($deal_id,'deal_created', 0);		
		if($contract_pdf_id){
			wp_delete_attachment($contract_pdf_id, true);
		}
		$contract= wp_delete_post($ids);	   	   
		if($contract){
			echo 'success';
		}
	}
	exit;
}

add_action( 'wp_ajax_nyc_delete_single_contract', 'nyc_delete_single_contract' );
add_action( 'wp_ajax_nopriv_nyc_delete_single_contract', 'nyc_delete_single_contract' );

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

function nyc_bulk_delete_contract(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_bulk_delete_contract'){
		global $wpdb;
		if($_POST['bulkaction'] == 'delete'){
			foreach($_POST['data'] as $ids){
			    $contract_pdf_id = get_post_meta($ids,'contract_pdf', true); 
			    $deal_id = get_post_meta($ids,'deal_id', true); 
				update_post_meta($deal_id,'deal_created', 0);		
				if($contract_pdf_id){
					wp_delete_attachment($contract_pdf_id, true);
				}
				wp_delete_post($ids);
			}
			echo "true";
		}
	}
	exit;
}
add_action( 'wp_ajax_nyc_bulk_delete_contract', 'nyc_bulk_delete_contract' );
add_action( 'wp_ajax_nopriv_nyc_bulk_delete_contract', 'nyc_bulk_delete_contract' );

/*------------ Delete Deal Orders ------------*/

function nyc_delete_deal_order_ajax(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_delete_deal_order_ajax'){
	   $deal=wp_trash_post($_POST['deal_order_id']);
	   if($deal){
		   echo 'success';
	   }
	}
	exit;
}

add_action( 'wp_ajax_nyc_delete_deal_order_ajax', 'nyc_delete_deal_order_ajax' );
add_action( 'wp_ajax_nopriv_nyc_delete_deal_order_ajax', 'nyc_delete_deal_order_ajax' );


function nyc_bulk_delete_deal_orders(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_bulk_delete_deal_orders'){
		global $wpdb;
		if($_POST['bulkaction'] == 'delete'){
			foreach($_POST['data'] as $ids){
			  wp_trash_post($ids);
			}
			echo "true";
		}
	}
	exit;
}

add_action( 'wp_ajax_nyc_bulk_delete_deal_orders', 'nyc_bulk_delete_deal_orders' );
add_action( 'wp_ajax_nopriv_nyc_bulk_delete_deal_orders', 'nyc_bulk_delete_deal_orders' );

add_action('init', 'dcc_rewrite_tags');
function dcc_rewrite_tags() {
    add_rewrite_tag('%view%', '([^&]+)');
    add_rewrite_tag('%id%', '([^&]+)');
}

add_action('init', 'dcc_rewrite_tags_new');
function dcc_rewrite_tags_new() {
	add_rewrite_tag('%vieworder%', '([^&]+)');
    add_rewrite_tag('%orderid%', '([^&]+)');
}


add_action('init', 'dcc_rewrite_rules');
function dcc_rewrite_rules() {
	add_rewrite_rule('^admin/deals/([^/]+)/([^/]+)/?$','index.php?pagename=admin/deals&view=$matches[1]&id=$matches[2]','top');
	add_rewrite_rule('^admin/all-contracts/([^/]+)/([^/]+)/?$','index.php?pagename=admin/all-contracts&view=$matches[1]&id=$matches[2]','top');
	add_rewrite_rule('^property-owner/all-contracts/([^/]+)/([^/]+)/?$','index.php?pagename=property-owner/all-contracts&view=$matches[1]&id=$matches[2]','top');
	add_rewrite_rule('^tenant/all-contracts/([^/]+)/([^/]+)/?$','index.php?pagename=tenant/all-contracts&view=$matches[1]&id=$matches[2]','top');
}

add_action('init', 'dcc_rewrite_rules_new');
function dcc_rewrite_rules_new() {
	add_rewrite_rule('^admin/dealsorders/([^/]+)/([^/]+)/?$','index.php?pagename=admin/dealsorders&vieworder=$matches[1]&orderid=$matches[2]','top');
	add_rewrite_rule('^tenant/deal-details-tenant/([^/]+)/?$','index.php?pagename=tenant/deal-details-tenant&id=$matches[1]','top');
	add_rewrite_rule('^agent/deal-details-agent/([^/]+)/?$','index.php?pagename=agent/deal-details-agent&id=$matches[1]','top');
	
	
}


add_filter( 'template_redirect', 'prefix_url_rewrite_templates',1 );
 
function prefix_url_rewrite_templates() {
	if ( is_page('admin/deals') ) {
		if(get_query_var('view') == 'details' && !empty(get_query_var('view'))){
		  add_filter('zakra_title', function (){
			  return "Deal Details";
		  }, 10, 2);		
		  include get_stylesheet_directory() . '/my-templates/admin/deal-detail.php';
		  exit;
		}
	}
	if ( is_page('admin/all-contracts') ) {
		if(get_query_var('view') == 'view' && !empty(get_query_var('id'))){
		  include get_stylesheet_directory() . '/my-templates/admin/single-contract.php';
		   exit;
		}		
	}
	
	if ( is_page('property-owner/all-contracts') ) {
		if(get_query_var('view') == 'view' && !empty(get_query_var('id'))){
		  include get_stylesheet_directory() . '/my-templates/property-owner/single-contract.php';
		   exit;
		}		
	}
	
	if ( is_page('tenant/all-contracts') ) {
		if(get_query_var('view') == 'view' && !empty(get_query_var('id'))){
		  include get_stylesheet_directory() . '/my-templates/tenant/single-contract.php';
		   exit;
		}		
	}
	
	if(get_query_var('vieworder') == 'orderdetails' && !empty(get_query_var('vieworder'))){
	  include get_stylesheet_directory() . '/my-templates/admin/orders-detail.php';
	  exit;
	}
	
	if(get_query_var('view') == 'contract' && !empty(get_query_var('view'))){
	  add_filter('zakra_title', function (){
		  return "Contract";
	  }, 10, 2);
	  include get_stylesheet_directory() . '/my-templates/admin/contract.php';
	  exit;
	}
}

add_action( 'wp_ajax_nyc_load_selcted_property', 'nyc_load_selcted_property' );
add_action( 'wp_ajax_nopriv_nyc_load_selcted_property', 'nyc_load_selcted_property' ); 
function nyc_load_selcted_property() {
	$selected_property = get_post_meta($_POST['deal_id'], 'selected_property', true);
	if($selected_property){
	foreach($selected_property as $property_id){ 
	$price = get_post_meta($property_id, 'price',true);	
	?>
		<li class="selected_property-<?php echo $property_id; ?>">
			<div class="listing-item compact">
				<div class="listing-badges">
					<span class="featured">Featured</span>
					<span>For Rent</span>
				</div>
				<div class="listing-img-content">
					<span class="listing-compact-title"><?php echo get_the_title($property_id); ?> <i>$<?php echo $price; ?> / Weekly</i></span>

					<ul class="listing-hidden-content">
						<li>Rooms <span><?php echo get_post_meta($property_id,'rooms',true); ?></span></li>
					</ul>
				</div>
				<img src="<?php echo wp_get_attachment_url(get_post_meta($property_id,'file_0',true)); ?>" alt="">
			</div>
			<span class="desellect-sellectedproperty"><i class="fa fa-times selected-property-close" data-id="<?php echo $property_id; ?>" aria-hidden="true"></i></span>
		</li>
	<?php } }else { echo "<li class='no-property-found'>No selected property founds!</li>"; } 	
	exit;
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
		$meta_query = array();
        $p_args = array(
					'post_type'         => 'property',
					'orderby'           => 'post_date',
					'order'             => 'DESC',
					'posts_per_page'    => $per_page,
					'offset'            => $start,
					'post__not_in'		=> $selected_property,
				);
		
		$c_args = array(
					'post_type'         => 'property',
					'posts_per_page'    => -1,
					'post__not_in'		=> $selected_property,
				);
		//Seacrh by title 		
		if($_POST['search_name']){
			$search_name = $_POST['search_name'];
			$p_args['s'] = $search_name;
			$c_args['s'] = $search_name;
		}
		
		//Seacrh by post status 	
		if($_POST['search_status']){
			$p_args['post_status'] = array($_POST['search_status']);
			$c_args['post_status'] = array($_POST['search_status']);
		}else{
			$p_args['post_status'] = array('available','rented');
			$c_args['post_status'] = array('available','rented');
		}

        //Seacrh by type  
		if($_POST['search_type']){
			$term_args = array(
							array(
							'taxonomy' => 'types',
							'field' => 'term_id',
							'terms' => $_POST['search_type']
							)
						);	
			$p_args['tax_query'] = $term_args;
			$c_args['tax_query'] = $term_args;						
		}
		
        //Seacrh by accomdation  
		if($_POST['search_accom']){
			$meta_query[] = array(
						'key'          => 'accomodation',
						'value'        => $_POST['search_accom'],
						'compare'      => '=',
					   );						
		}
		
        //Seacrh by rooms  
		if($_POST['search_rooms']){
			$meta_query[] = array(
						'key'          => 'rooms',
						'value'        => $_POST['search_rooms'],
						'compare'      => '=',
					   );						
		}
		
        //Seacrh by min price   
		if($_POST['search_min_price']){
			$meta_query[] = array(
						'key'          => 'price',
						'value'        => $_POST['search_min_price'],
						'compare'      => '>=',
						'type'          => 'NUMERIC'
					   );						
		}
		
        //Seacrh by rooms  
		if($_POST['search_max_price']){
			$meta_query[] = array(
						'key'          => 'price',
						'value'        => $_POST['search_max_price'],
						'compare'      => '<=',
						'type'          => 'NUMERIC'
					   );						
		}
		
		if(!empty($meta_query)){
			$p_args['meta_query'] = $meta_query;
			$c_args['meta_query'] = $meta_query;
		}
		
		$properties = new WP_Query($p_args);
        $count = new WP_Query($c_args);
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
									<h4><a href="'.get_post_permalink($property_id).'">'.get_the_title().'</a></h4>
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
        <div class='cvf-universal-pagination '>
		<div class='pagination-container margin-top-10 margin-bottom-45'>
		<nav class='pagination'>
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
			</nav>
		  </div>
        </div>";

        // We echo the final output
        echo $msg. 
        '<div class = "cvf-pagination-nav">' . $pag_container . '</div>';

    }
    // Always exit to avoid further execution
    exit();
}

add_action( 'wp_ajax_add-deal-pagination-load-posts', 'add_deal_pagination_load_posts' );
add_action( 'wp_ajax_nopriv_add-deal-pagination-load-posts', 'add_deal_pagination_load_posts' ); 
function add_deal_pagination_load_posts() {

    global $wpdb;
    // Set default variables
    $msg = '';
    if(isset($_POST['page'])){
        // Sanitize the received page   
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
		$meta_query = array();
        $p_args = array(
					'post_type'         => 'property',
					'orderby'           => 'post_date',
					'order'             => 'DESC',
					'posts_per_page'    => $per_page,
					'offset'            => $start,
				);
		
		$c_args = array(
					'post_type'         => 'property',
					'posts_per_page'    => -1,
				);
		//Seacrh by title 		
		if($_POST['search_name']){
			$search_name = $_POST['search_name'];
			$p_args['s'] = $search_name;
			$c_args['s'] = $search_name;
		}
		
		//Seacrh by post status 	
		if($_POST['search_status']){
			$p_args['post_status'] = array($_POST['search_status']);
			$c_args['post_status'] = array($_POST['search_status']);
		}else{
			$p_args['post_status'] = array('available','rented');
			$c_args['post_status'] = array('available','rented');
		}

        //Seacrh by type  
		if($_POST['search_type']){
			$term_args = array(
							array(
							'taxonomy' => 'types',
							'field' => 'term_id',
							'terms' => $_POST['search_type']
							)
						);	
			$p_args['tax_query'] = $term_args;
			$c_args['tax_query'] = $term_args;						
		}
		
        //Seacrh by accomdation  
		if($_POST['search_accom']){
			$meta_query[] = array(
						'key'          => 'accomodation',
						'value'        => $_POST['search_accom'],
						'compare'      => '=',
					   );						
		}
		
        //Seacrh by rooms  
		if($_POST['search_rooms']){
			$meta_query[] = array(
						'key'          => 'rooms',
						'value'        => $_POST['search_rooms'],
						'compare'      => '=',
					   );						
		}
		
        //Seacrh by min price   
		if($_POST['search_min_price']){
			$meta_query[] = array(
						'key'          => 'price',
						'value'        => $_POST['search_min_price'],
						'compare'      => '>=',
						'type'          => 'NUMERIC'
					   );						
		}
		
        //Seacrh by rooms  
		if($_POST['search_max_price']){
			$meta_query[] = array(
						'key'          => 'price',
						'value'        => $_POST['search_max_price'],
						'compare'      => '<=',
						'type'          => 'NUMERIC'
					   );						
		}
		
		if(!empty($meta_query)){
			$p_args['meta_query'] = $meta_query;
			$c_args['meta_query'] = $meta_query;
		}
		
		$properties = new WP_Query($p_args);
        $count = new WP_Query($c_args);
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
									<h4><a href="'.get_post_permalink($property_id).'">'.get_the_title().'</a></h4>
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
		if(!is_array($new_data)){
			$new_data = array();
		}
		foreach($propertyArray as $property){
			if(!in_array($property, $new_data)){
				$new_data[] = $property;
			}
		}
		update_post_meta($deal_id,$meta_key,$new_data);
	}
	exit();
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
		$tenant_deal_link = get_site_url().'/tenant/deal-details-tenant/'.base64_encode($deal_id);
		$agent_deal_link  = get_site_url().'/agent/deal-details-agent/'.base64_encode($deal_id);
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

require get_stylesheet_directory().'/textmagic-rest-php-v2/vendor/autoload.php';
use TextMagic\Models\SendMessageInputObject;
use TextMagic\Api\TextMagicApi;
use TextMagic\Configuration;	
add_action( 'wp_ajax_nyc-deal-send-sms', 'nyc_deal_send_sms' );
add_action( 'wp_ajax_nopriv_nyc-deal-send-sms', 'nyc_deal_send_sms' ); 
function nyc_deal_send_sms(){
	if(isset($_POST['deal_id'])){
		$deal_id = $_POST['deal_id'];
		$tenant_phone = get_post_meta($deal_id,'phone',true);
		$selectedAgent = get_post_meta($deal_id, 'selectedAgent', true);
		$tenant_deal_link = get_site_url().'/tenant/deal-details-tenant/'.base64_encode($deal_id);
		$agent_deal_link = get_site_url().'/agent/deal-details-agent/'.base64_encode($deal_id);
		$return_msg = array();
		// Include the TextMagic PHP lib
		// put your Username and API Key from https://my.textmagic.com/online/api/rest-api/keys page.
		$config = Configuration::getDefaultConfiguration()
			->setUsername('nycroomsforrent@gmail.com')
			->setPassword('gv1HzsGhaBvV60bVUd2cgBEtJVmHA3');
		
		$api = new TextMagicApi(
			new GuzzleHttp\Client(),
			$config
		);
		if($tenant_phone){
			$input = new SendMessageInputObject();
			$msg = "Hi, Here's the link where you can check deal details: ".$tenant_deal_link;
			$input->setText($msg);
			$input->setPhones($tenant_phone);	
			try {
				$result = $api->sendMessage($input);
				if($result){
					$return_msg['tenant_status']= true;
				}
			} catch (Exception $e) {
				$return_msg['tenant_error'] = 'Exception when calling TextMagicApi->sendMessage: '.$e->getMessage().PHP_EOL;
			}			
		}
		if($selectedAgent){
			$agent_phone = get_user_meta($selectedAgent,'user_phone',true);
			if($agent_phone){
				$return_msg['agent_allowed'] = true;
				$input = new SendMessageInputObject();
				$msg = "You are assigned for tenant deals. Click on the link for more details. ".$agent_deal_link;
				$input->setText($msg);
				$input->setPhones($agent_phone);	
				try {
					$result = $api->sendMessage($input);
					if($result){
						$return_msg['agent_status'] = true;
					}
				} catch (Exception $e) {
					$return_msg['agent_error'] = 'Exception when calling TextMagicApi->sendMessage: '.$e->getMessage().PHP_EOL;
				}					
			}			
		}
		echo json_encode($return_msg);	
	}
	exit;
}

add_action( 'wp_ajax_nyc-deal-select-agent', 'nyc_deal_select_agent' );
add_action( 'wp_ajax_nopriv_nyc-deal-select-agent', 'nyc_deal_select_agent' ); 
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

add_action( 'wp_ajax_add-new-custom-deal', 'add_new_custom_deal' );
add_action( 'wp_ajax_nopriv_add-new-custom-deal', 'add_new_custom_deal' ); 
function add_new_custom_deal(){
	if(isset($_POST['action']) && $_POST['action'] == 'add-new-custom-deal'){
	$deal_id = wp_insert_post(
			array(
				'post_type'		=> 'deals',
				'post_title' 	=> 'deal submission',
				'post_content' 	=> $_POST['t_description'],
				'post_status'   => 'publish'
			));		
	if($deal_id){
		add_post_meta($deal_id, 'lead_source','Custom Deal');
		add_post_meta($deal_id, 'property_id',$_POST['property_id']);
		add_post_meta($deal_id, 'name',$_POST['t_name']);
		add_post_meta($deal_id, 'email',$_POST['t_email']);
		add_post_meta($deal_id, 'phone',$_POST['t_phone']);
		add_post_meta($deal_id, 'description',$_POST['t_description']);
		add_post_meta($deal_id, 'admin_notes',$_POST['admin_notes']);
		add_post_meta($deal_id, 'deal_price',$_POST['deal_price']);
		echo "success";
	}
	}	
	exit;
}

function contract_created_notification_tenant($email,$property_name='',$attchment_id){
	if($email){
		$attachments =wp_get_attachment_url($attchment_id);
		$headers = '';		
		$message  = __( 'Hi there,' ) . "\r\n\r\n";
		$message .= sprintf( __( "Welcome to %s!" ), get_option('blogname') ) . "\r\n\r\n";
		$message .= sprintf( __('Your contract created successfully for property %s'), $property_name ) . "\r\n\r\n";
		$message .= sprintf( __('If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "\r\n\r\n";
		$message .= __( 'Thanks!' );
		wp_mail($email, sprintf(__('[%s] Contract Created Successfully'), get_option('blogname')), $message,$headers,$attachments);
	}
}

function contract_created_notification_property_owner($email,$property_name='',$tenant_name='',$attchment_id){
	if($email){
		$attachments = wp_get_attachment_url($attchment_id);
		$headers = '';
		$message  = __( 'Hi there,' ) . "\r\n\r\n";
		$message .= sprintf( __( "Welcome to %s!" ), get_option('blogname') ) . "\r\n\r\n";
		$message .= sprintf( __('Congratulation! Your property %s is now rented. Contract created for %s '), $property_name, $tenant_name ) . "\r\n\r\n";
		$message .= sprintf( __('If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "\r\n\r\n";
		$message .= __( 'Thanks!' );
		wp_mail($email, sprintf(__('[%s] Contract Created Successfully'), get_option('blogname')), $message,$headers,$attachments);
	}
}

function count_tenant_hired_property(){
	$current_user = wp_get_current_user();
	$args = array(
		'post_type'=> 'contracts',
		'post_status' => array('publish'),
		'posts_per_page'   => -1,
	);
	$meta_query = array();
	$meta_query[] =  array(
			'key'          => 'tenant_email',
			'value'        => $current_user->user_email,
			'compare'      => '=',
	);	
	if(!empty($meta_query)){
	   $args['meta_query'] = $meta_query;
	} 
	$contracts = new WP_Query( $args );
	$property_ids = array();
	if($contracts->have_posts()){
		while ( $contracts->have_posts() ) {
			$contracts->the_post();
			$contract_id = get_the_ID();
			$property_ids[] = get_post_meta($contract_id, 'property_id',true);
		}
	}	
	return ($property_ids) ? count($property_ids): 0;
}

add_action('init','nyc_create_additional_table');
function nyc_create_additional_table(){
	global $wpdb;
	$notification_table_name = $wpdb->prefix."notification";
	if($wpdb->get_var("show tables like '$notification_table_name'") != $notification_table_name) {

		$sql = "CREATE TABLE " . $notification_table_name . " (
			id int(11) NOT NULL AUTO_INCREMENT,
			message VARCHAR(255) NOT NULL,
			is_read enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=>unread, 1=>read',
			created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			UNIQUE KEY id (id)
		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}	
}

function nyc_add_noticication($message){
        if(empty($message)){
			return;
		}
		global $wpdb;
		$table = $wpdb->prefix.'notification';
		$data = array('message' => $message, 'is_read' => 0, 'created_at' => current_time('mysql'));
		$format = array('%s','%s','%s');
		$wpdb->insert($table,$data,$format);
}

function nyc_time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

add_action( 'wp_ajax_nyc_remove_notification', 'nyc_remove_notification' );
add_action( 'wp_ajax_nopriv_nyc_remove_notification', 'nyc_remove_notification' ); 
function nyc_remove_notification(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_remove_notification'){
		global $wpdb;
		$table_name = $wpdb->prefix . 'notification';
		$wpdb->query( 
		$wpdb->prepare("DELETE FROM $table_name WHERE id = %d",$_POST['noti_id']));		
	}	
	exit;
}

function submit_book_appointment_form(){
	if(isset($_POST['book_appointment'])){
	  $user = wp_get_current_user();
	  $user_id = null;
      if(is_user_logged_in()){
			if($user->roles[0] == "tenant"){
			  $user_id = $user->ID;
			}
	  } 
       $lead_id = wp_insert_post(array (
						'post_type'		=> 'leads',
						'post_title' 	=> 'Lead submission',
						'post_content' 	=> 'Lead submission by guest user',
						'post_author' 	=> 1,
						'post_status'   => 'publish'
		           ));
		
		
		 if ($lead_id) {
			add_post_meta($lead_id, 'lead_name', $_POST['user_name']);
			add_post_meta($lead_id, 'lead_email', $_POST['user_email']);
			add_post_meta($lead_id, 'lead_phone', $_POST['user_num']);
			add_post_meta($lead_id, 'lead_datetime', strtotime($_POST['date'] . ' '.$_POST['time']));
			add_post_meta($lead_id, 'lead_summary', $_POST['appointment_description']);
			add_post_meta($lead_id, 'lead_source','Appointment Form');
			add_post_meta($lead_id, 'lead_created_from', 'Appointment_user' );
			add_post_meta($lead_id, 'lead_created_user_id', $user_id);
			$notification = "A new lead submission from Book Appointment by ".$_POST['user_name'];
			nyc_add_noticication($notification);				
			
			$strtotime =  strtotime($_POST['date'] . ' '.$_POST['time']);
			$datetime =  date("F j, Y h:i:s A", $strtotime);
			
			/*----------- Email to Tenant After Lead Submission --------*/
			
			$subject1 = "Appointment Lead Submission Enquiry Recieved On NYCROOMS";
			$to1 = $_POST['user_email'];
			$msg1  = '<h4>Hello '.$_POST['user_name'].',</h4>';
			$msg1 .= '<p>Thank you For Lead Submission on NYC Rooms. We Have Recevied Your Appointment Enquiry Request for lead submission. One of our Represntative will be in touch with you as soon as possible.</p>';
			$msg1 .=  '<p>Thanks!<p>';
			$headers1 = array('Content-Type: text/html; charset=UTF-8');
			$mail1 = wp_mail($to1, $subject1, $msg1,$headers1);
			
	       /*---------- Email to Admin After Lead Submission --------*/
			
			$subject = "New Lead Submission";
			$to = get_option('admin_email');
			$msg  = __( '<h4>Hello Admin,</h4>') . "\r\n\r\n";
			$msg .= '<p>A new lead Submission by Appointment Form with following Details:</p>';
			$msg .= '<p>Name:'.$_POST['user_name'] .'</p>';
			$msg .= '<p>Email:'.$_POST['user_email'] .'</p>';
			$msg .= '<p>Phone:'.$_POST['user_num'] .'</p>';
			$msg .= '<p>Date & time:'. $datetime .'</p>';
			$msg .= '<p>Requirements:</p><p>'.$_POST['appointment_description'] .'</p>';
			$msg .=  '<p>Thanks!<p>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
		    $mail = wp_mail($to, $subject, $msg,$headers);
				?>
				<script>
				jQuery(document).ready(function(){
					jQuery('#successModal .modal-body p').html('We have recieved your request for property. We will contact you soon');
					jQuery('#successModal').modal('show');
				});
				</script>				
				<?php 				
		}		
	}
}
add_action('wp_footer','submit_book_appointment_form');

function count_deal_of_tenant($user_email){
	$args = array(
		'post_type'=> 'deals',
		'post_status' => array('publish'),
		'posts_per_page'   => -1,
	);
	$meta_query = array();
	$meta_query[] =  array(
			'key'          => 'email',
			'value'        => $user_email,
			'compare'      => 'LIKE',
	);	
	if(!empty($meta_query)){
	   $args['meta_query'] = $meta_query;
	} 	
	$deals = new WP_Query( $args );
	$count = $deals->found_posts;
	return ($count) ? $count: 0;
}
?>