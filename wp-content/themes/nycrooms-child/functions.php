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
	wp_enqueue_style( 'sqpaymentform-basic-css', get_stylesheet_directory_uri().'/css/sqpaymentform-basic.css');
	//wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_script( 'property-js', get_stylesheet_directory_uri().'/scripts/property.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'dashboard-js', get_stylesheet_directory_uri().'/inc/js/admin-dashboard.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri().'/scripts/bootstrap.min.js', array( 'jquery' ), '1.0', true );
	
	if ( is_page('tenant/deal-details-tenant')) {
		wp_enqueue_script( 'square-js', 'https://js.squareupsandbox.com/v2/paymentform', array( 'jquery' ), '1.0');
		wp_enqueue_script( 'sqpaymentform-js', get_stylesheet_directory_uri().'/scripts/sqpaymentform.js', array( 'jquery' ), '1.0');
		wp_localize_script( 'sqpaymentform-js', 'payment_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
	
    wp_localize_script( 'property-js', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	
	
	
	
}
add_action( 'wp_enqueue_scripts', 'zakra_child_enqueue_styles' );

add_action('wp_head','square_custom_js_file');

function square_custom_js_file(){
   if ( is_page('tenant/deal-details-tenant')) {
	   echo '<script>
		 document.addEventListener("DOMContentLoaded", function(event) {
		if (SqPaymentForm.isSupportedBrowser()) {
		  paymentForm.build();
		  paymentForm.recalculateSize();
		}
	  });
		</script>';
  }
  
}


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
.menu-item-object-page.menu-item-22{display: none !important;}
.menu-item-object-page.menu-item-42{display: none !important;}
</style> 
<?php
} else {
?>
<style>
.menu-item-object-page.menu-item-43{display: none !important;}
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
	     if(isset($_POST['selected_property_owner']) && !empty($_POST['selected_property_owner'])){
	        $checkid = $_POST['selected_property_owner'];
		 } else {
		    $checkid = get_current_user_id();
		 }
		 
		$property_id = wp_insert_post(array (
			'post_type'		=> 'property',
			'post_title' 	=> $_POST['title'],
			'post_content' 	=> $_POST['desc'],
			'post_author' 	=> $checkid,
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
			add_post_meta($property_id, 'document_files', $_POST['document_files']);
			add_post_meta($property_id, 'people_living_count', $_POST['people_living_count']);
			if(isset($_FILES)){
			  foreach($_FILES as $key=>$file){
				  nyc_property_gallery_image_upload($key,$property_id);
			  }
			}
			$notification = "A new property listed by ".$_POST['contact_name']." title is ".$_POST['title'];
			nyc_add_noticication($notification);			
			$subject = "New Property Listed - ".$_POST['title'];
			$to = get_option('admin_email');
			$msg  = __( 'Hello Admin,') . "\r\n\r\n";
			$msg .= sprintf( __( 'A new property listed by %s title is "%s".'), $_POST['contact_name'], $_POST['title'] ) . "\r\n\r\n";
			$msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
		    $sent = wp_mail($to, $subject, $msg);
			
			/* ------------ Sent mail to  tenant --------*/
			if(isset($_POST['selected_property_owner']) && !empty($_POST['selected_property_owner'])){
			     $p_id = $_POST['selected_property_owner'];
				 $get_user    =  get_user_by( 'ID', $p_id );
				 $user_email =    $get_user->user_email;
				// $user_name  = 
				 $subject1 = "New Property Listed - ".$_POST['title'];
			     $to1 = $user_email;
			     $msg1  = __( 'Hello Admin,') . "\r\n\r\n";
			     $msg1 .= sprintf( __( 'A new property listed by %s title is "%s".'), $_POST['contact_name'], $_POST['title'] ) . "\r\n\r\n";
			     $msg1 .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
		         $sent1 = wp_mail($to1, $subject1, $msg1);
			    
			}
			
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


function nyc_update_property_ajax(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_update_property_ajax'){
	            $gallery_files_post = array();
				$doc_files_post = array();
			    if(isset($_FILES) && !empty($_FILES)){
			      $meta_gallery = get_post_meta($_POST['property_id'], 'gallery_files', true);
				  $doc_gallery = get_post_meta($_POST['property_id'], 'document_files', true);
				  $gallery_files = explode(',',$meta_gallery);
				  $document_files = explode(',',$doc_gallery);
				  if($meta_gallery ||  $doc_gallery) {
				  $countgallery_meta = count($gallery_files);
				  $countdoc_meta = count($document_files);
				  
			      $i = 1; 
				  $k = 1;
			      $FILESIMG = array();
				  $FILESDOC = array();
				  $gallery_files_post  =  $gallery_files;
				  $doc_files_post      =  $document_files;
				  if($meta_gallery && $gallery_files[0] != ''){
			      foreach($_FILES as $key=>$file){
				     if("file_" == substr($key,0,5)){
						if($i == 1){
						  $key = 'file_'.$countgallery_meta;
						} else {
						   $incresecount = ($countgallery_meta + $i)- 1;
						  $key = 'file_'.$incresecount;
						}
						$FILESIMG[$key] = $file;
					   
					       nyc_property_gallery_image_upload_update($FILESIMG,$key,$_POST['property_id']);
						   $gallery_files_post[] = $key;
						   
						 $i++;
					 } 	 
			      }
				  } else {
				      foreach($_FILES as $key=>$file){
						   
                               if("file_" == substr($key,0,5)){
                                   nyc_property_gallery_image_upload_update($_FILES,$key,$_POST['property_id']);
							       $gallery_files_post[] = $key;   
							   }

			         }
				  }
				  if($doc_gallery && $document_files[0] != ''){
				  foreach($_FILES as $key=>$file){
					  if("doc_" == substr($key,0,4)){
							if($k == 1){
							  $key = 'doc_'.$countdoc_meta;
							} else {
							   $incresecount_doc = ($countdoc_meta + $k)- 1;
							  $key = 'doc_'.$incresecount_doc;
							}
							$FILESDOC[$key] = $file;
						   
							   nyc_property_gallery_image_upload_update($FILESDOC,$key,$_POST['property_id']);
							   $doc_files_post[] = $key;
							   
							 $k++;
					  } 
                  }
                 } else {
				         foreach($_FILES as $key=>$file){
							   
							   if("doc_" == substr($key,0,4)){
							       nyc_property_gallery_image_upload_update($_FILES,$key,$_POST['property_id']);
							       $doc_files_post[] = $key; 
							   }

			                }
				     
                 }				 
					 
				  
                   				  
			     } else {
				             
							foreach($_FILES as $key=>$file){
						   
                               if("file_" == substr($key,0,5)){
                                   nyc_property_gallery_image_upload_update($_FILES,$key,$_POST['property_id']);
							       $gallery_files_post[] = $key;   
							   }
							   
							   if("doc_" == substr($key,0,4)){
							       nyc_property_gallery_image_upload_update($_FILES,$key,$_POST['property_id']);
							       $doc_files_post[] = $key; 
							   }

			                }

				 }
				  
	         }
			   		  
			    if(empty($gallery_files_post)){
				        if(!empty($_POST['gallery_files'])){
						   $gallery_files_post = explode(',',$_POST['gallery_files']);
					   } else {
					       $meta_gallery = get_post_meta($_POST['property_id'], 'gallery_files', true);
				           $gallery_files = explode(',',$meta_gallery);
				           $gallery_files_post = $gallery_files;
					        
					   }
				}
				 if($gallery_files_post[0] == ''){
				    unset($gallery_files_post[0]);
				 }
				  
				
				if(empty($doc_files_post)){
				       if(!empty($_POST['document_files'])){
				         $doc_files_post = explode(',',$_POST['document_files']);
					   } else {
					        $doc_gallery = get_post_meta($_POST['property_id'], 'document_files', true);
							$document_files = explode(',',$doc_gallery);
							$doc_files_post = $document_files;
					   }
				}
				
				  if($doc_files_post[0] == ''){
				    unset($doc_files_post[0]);
				 }
				    
			  
			   $property_id = wp_update_post(array (
					'ID'		=> $_POST['property_id'],
					'post_title' 	=> $_POST['title'],
					'post_content' 	=> $_POST['desc'],
					'post_author' 	=> $_POST['post_author'],
					'post_status' 	=> $_POST['post_status'],
				));
				if ($property_id) {
					wp_set_post_terms($property_id, $_POST['type'], 'types' );
					update_post_meta($property_id, 'status', $_POST['status']);
					update_post_meta($property_id, 'price', $_POST['price']);
					update_post_meta($property_id, 'accomodation', $_POST['accomodation']);
					update_post_meta($property_id, 'rooms', $_POST['rooms']);
					update_post_meta($property_id, 'hear', $_POST['hear']);
					update_post_meta($property_id, 'gender', $_POST['gender']);
					update_post_meta($property_id, 'rm_lang', $_POST['rm_lang']);
					update_post_meta($property_id, 'relationship', $_POST['relationship']);
					update_post_meta($property_id, 'couple_price', $_POST['couple_price']);
					update_post_meta($property_id, 'payment_method', $_POST['payment_method']);
					update_post_meta($property_id, 'address', $_POST['address']);
					update_post_meta($property_id, 'city', $_POST['city']);
					update_post_meta($property_id, 'state', $_POST['state']);
					update_post_meta($property_id, 'zip', $_POST['zip']);
					update_post_meta($property_id, 'agent', $_POST['agent']);
					update_post_meta($property_id, 'amenities', $_POST['amenities']);
					update_post_meta($property_id, 'contact_name', $_POST['contact_name']);
					update_post_meta($property_id, 'contact_email', $_POST['contact_email']);
					update_post_meta($property_id, 'contact_phone', $_POST['contact_phone']);
					update_post_meta($property_id, 'gallery_files', implode(',',$gallery_files_post));
					update_post_meta($property_id, 'document_files', implode(',',$doc_files_post));
					update_post_meta($property_id, 'people_living_count', $_POST['people_living_count']);
					echo 'success';
				}else{
					echo 'false';
				}
	}else{
	    echo 'false';
	}
	exit;
}
add_action( 'wp_ajax_nyc_update_property_ajax', 'nyc_update_property_ajax' );
add_action( 'wp_ajax_nopriv_nyc_update_property_ajax', 'nyc_update_property_ajax' );





add_action( 'wp_ajax_nyc_get_existing_file_ajax', 'nyc_get_existing_file_ajax' );
add_action( 'wp_ajax_nopriv_nyc_get_existing_file_ajax', 'nyc_get_existing_file_ajax' );

function nyc_get_existing_file_ajax(){
          $gallery_files_ids   = explode(',',get_post_meta($_POST['property_id'],'gallery_files',true)); 
		  $arrayfiles = array();
		    foreach($gallery_files_ids as $gallery_files){
			   $ids = get_post_meta($_POST['property_id'],$gallery_files,true);
			   $filename = basename(get_attached_file($ids));
			   $arrayfiles[] = $filename;
			   
			}

			 $file_list = array();
			 $uploaddir = wp_upload_dir();

			  $dir       =  $uploaddir['path'].'/';
			  $pathurl   =  $uploaddir['url'].'/';
			 
			 
			  foreach($arrayfiles as $file){
			 // File path
                $file_path = $dir.$file;
				$file_pathurl  = $pathurl.$file;
				$type = pathinfo($file_pathurl, PATHINFO_EXTENSION);
				$data = file_get_contents($file_pathurl);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				
				if(!is_dir($file_path)){
                   $size = filesize($file_path);
                   $file_list[] = array('name'=>$file,'size'=>$size,'path'=> $base64);
				}
            }
           echo json_encode($file_list);  
				
  exit; 
}

add_action( 'wp_ajax_nyc_delete_existing_file_ajax', 'nyc_delete_existing_file_ajax' );
add_action( 'wp_ajax_nopriv_nyc_delete_existing_file_ajax', 'nyc_delete_existing_file_ajax' );

function nyc_delete_existing_file_ajax(){
   if(isset($_POST['action']) && $_POST['action'] == 'nyc_delete_existing_file_ajax'){
     $uploaddir = wp_upload_dir();
	 $dir       =  $uploaddir['path'].'/';
	 $pathurl   =  $uploaddir['url'].'/';
     $property_id = $_POST['property_id'];
	 $file_name  =  $_POST['file_name'];
	 $file_url   = $pathurl . $file_name;
	 $gallery_files_meta = get_post_meta($property_id,'gallery_files',true);
	 $gallery_files = explode(',',$gallery_files_meta);
	  foreach($gallery_files as $key => $metakeyattach){
	        $attachment_id = get_post_meta($_POST['property_id'],$metakeyattach,true);
		    $attachment_url = wp_get_attachment_url($attachment_id);
			if($attachment_url == $file_url){
			   wp_delete_attachment($attachment_id, true);
			   delete_post_meta( $property_id, $metakeyattach,$attachment_id); 
			   unset($gallery_files[$key]);
			  
			}	
	  }
	  
	  $i = 0;
	  foreach($gallery_files as $key => $newgalleryfiles){
	      $attachment_id = get_post_meta($_POST['property_id'],$newgalleryfiles,true);
		  if($attachment_id){
			  delete_post_meta($_POST['property_id'],$newgalleryfiles,$attachment_id);
			  unset($gallery_files[$key]);
			  add_post_meta($_POST['property_id'],'file_'.$i,$attachment_id);
			  $gallery_files[$i] = 'file_'.$i;
		  }
		  
	   $i++;
	  
	  }      
              
	         if(empty($gallery_files)){
	              delete_post_meta($_POST['property_id'],'gallery_files', implode(',',$gallery_files));
	          } else {
			      update_post_meta($_POST['property_id'],'gallery_files', implode(',',$gallery_files));	
			  }
             
			
	  echo "success";
	   
   } else {
      echo "faliure";
   }
  exit; 
}


add_action( 'wp_ajax_nyc_get_existing_file_doc_ajax', 'nyc_get_existing_file_doc_ajax' );
add_action( 'wp_ajax_nopriv_nyc_get_existing_file_doc_ajax', 'nyc_get_existing_file_doc_ajax' );

function nyc_get_existing_file_doc_ajax(){
          $gallery_files_ids   = explode(',',get_post_meta($_POST['property_id'],'document_files',true)); 
		  $arrayfiles = array();
		    foreach($gallery_files_ids as $gallery_files){
			   $ids = get_post_meta($_POST['property_id'],$gallery_files,true);
			   $filename = basename(get_attached_file($ids));
			   $arrayfiles[] = $filename;
			   
			}

			 $file_list = array();
			 $uploaddir = wp_upload_dir();

			  $dir       =  $uploaddir['path'].'/';
			  $pathurl   =  $uploaddir['url'].'/';
			 
			 
			  foreach($arrayfiles as $file){
			 // File path
                $file_path = $dir.$file;
				$file_pathurl  = $pathurl.$file;
				$type = pathinfo($file_pathurl, PATHINFO_EXTENSION);
				$data = file_get_contents($file_pathurl);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				
				if(!is_dir($file_path)){
                   $size = filesize($file_path);
                   $file_list[] = array('name'=>$file,'size'=>$size,'path'=> $base64);
				}
            }
           echo json_encode($file_list);  
				
  exit; 
}


add_action( 'wp_ajax_nyc_delete_existing_file_doc_ajax', 'nyc_delete_existing_file_doc_ajax' );
add_action( 'wp_ajax_nopriv_nyc_delete_existing_file_doc_ajax', 'nyc_delete_existing_file_doc_ajax' );

function nyc_delete_existing_file_doc_ajax(){
   if(isset($_POST['action']) && $_POST['action'] == 'nyc_delete_existing_file_doc_ajax'){
     $uploaddir = wp_upload_dir();
	 $dir       =  $uploaddir['path'].'/';
	 $pathurl   =  $uploaddir['url'].'/';
     $property_id = $_POST['property_id'];
	 $file_name  =  $_POST['file_name'];
	 $file_url   = $pathurl . $file_name;
	 $gallery_files_meta = get_post_meta($property_id,'document_files',true);
	 $gallery_files = explode(',',$gallery_files_meta);
	  foreach($gallery_files as $key => $metakeyattach){
	        $attachment_id = get_post_meta($_POST['property_id'],$metakeyattach,true);
		    $attachment_url = wp_get_attachment_url($attachment_id);
			 if($attachment_url == $file_url){
			   wp_delete_attachment($attachment_id, true);
			   delete_post_meta( $property_id, $metakeyattach,$attachment_id); 
			   unset($gallery_files[$key]);
			  
			}	
	  }
	  $i = 0;
	  foreach($gallery_files as $key => $newgalleryfiles){
	      $attachment_id = get_post_meta($_POST['property_id'],$newgalleryfiles,true);
		  delete_post_meta($_POST['property_id'],$newgalleryfiles,$attachment_id);
		  unset($gallery_files[$key]);
		  add_post_meta($_POST['property_id'],'doc_'.$i,$attachment_id);
		  $gallery_files[$i] = 'doc_'.$i;
	   $i++;
	  }
	   
	   if(empty($gallery_files)){
	       delete_post_meta($_POST['property_id'],'document_files', implode(',',$gallery_files));
	   } else {
	       update_post_meta($_POST['property_id'],'document_files', implode(',',$gallery_files));
	   }
	  
	  
	  echo "success";
	   
   } else {
      echo "faliure";
   }
  exit; 
}



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

function nyc_property_gallery_image_upload_update($files,$file_name,$post_id){
		$uploaddir = wp_upload_dir();
		$tmp_file = $files[$file_name]["tmp_name"];
		$uploadfile = $uploaddir['path'] . '/' . $files[$file_name]['name'];
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
				update_post_meta($post_id, $file_name, $attach_id);

}



function nyc_property_profile_image_upload($FILES,$userid){
		$uploaddir = wp_upload_dir();
		$tmp_file = $FILES['agent_profile_picture']["tmp_name"];
		$uploadfile = $uploaddir['path'] . '/' . $FILES['agent_profile_picture']['name'];
		
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
	   update_user_meta($userid,'profile_user_image', $attach_id);
}


function nyc_property_profile_all_image_upload($FILES,$userid){
		$uploaddir = wp_upload_dir();
		$tmp_file = $FILES['profilepicture']["tmp_name"];
		$uploadfile = $uploaddir['path'] . '/' . $FILES['profilepicture']['name'];
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



function nyc_property_owner_authority(){
	if( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;
		if(in_array('administrator',$roles) || in_array('property_owner',$roles)){
		  
		} else {
		   wp_redirect(get_site_url().'/property-owner');
		}
	}else{
		wp_redirect(get_site_url().'/property-owner');
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
 	 $message .= __('You can now login with your new password at: ').'<a href="'.get_option('siteurl')."/owner-registeration/" .'" >' . get_option('siteurl')."/login-register/" . "</a> <br><br>";
	 } else if($user_role == 'tenant'){
	  $message .= __('You can now login with your new password at: ').'<a href="'.get_option('siteurl')."/tenant-registration/" .'" >' . get_option('siteurl')."/tenant-registration/" . "</a> <br><br>";
	 } else if($user_role == 'administrator'){
	  $message .= __('You can now login with your new password at: ').'<a href="'.get_option('siteurl')."/login-admin/" .'" >' . get_option('siteurl')."/login-admin/" . "</a> <br><br>";
	 }
	 
      $headers = array('Content-Type: text/html; charset=UTF-8');
  	if ( $message && !wp_mail($user_email, 'Your New Password to login into eimams', $message,$headers) ) {
  	 	$msg = false; 
 	 } else {
  	 	$msg = true; 
  	} 

  	return $msg; 
}

add_action('admin_menu', 'my_menu_pages');
function my_menu_pages(){
                          add_menu_page('Agents', 'Agents', 'manage_options', 'agents', 'nyc_rooms_add_agent' );
                          add_submenu_page('agents', 'Add Agent', 'Add Agent', 'manage_options', 'agents');
   $submenuagentall =     add_submenu_page('agents', 'All Agents', 'All Agents', 'manage_options', 'all-agents', 'nyc_rooms_all_agents');
	                      add_submenu_page('agents', 'Edit Agent', 'Edit Agent', 'manage_options', 'edit-agent', 'nyc_rooms_edit_agents');
						  add_submenu_page('agents', 'Delete Agent', 'Delete Agent', 'manage_options', 'delete-agent', 'nyc_rooms_delete_agents');
						  
			
	add_action( 'admin_print_styles-' .$submenuagentall, 'admin_custom_css' );
	add_action( 'admin_print_scripts-' .$submenuagentall, 'admin_custom_js' );
	
	?>
<?php


}

function wpdocs_enqueue_custom_admin_style() {
        wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style' );


function admin_custom_css(){ 
   wp_enqueue_style( 'jquery-datatable-css', get_stylesheet_directory_uri() . '/admin-scripts/jquery.dataTables.min.css');
}

function admin_custom_js() { 
   wp_enqueue_script( 'jquery-datatable-js', get_stylesheet_directory_uri() . '/admin-scripts/jquery.dataTables.min.js');
   wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/admin-scripts/main.js');
   wp_localize_script( 'main-js', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
};

function nyc_rooms_add_agent(){
if(isset($_POST['agent_submission'])){
  
   if( email_exists( $_POST['email'] ) ) {
     $usererror ="Sorry!! Email Already Exists";
  } else {
      $userdata = array(
					'user_login'  => $_POST['email'],
					'user_pass'   =>  wp_generate_password(), // random password, you can also send a notification to new users, so they could set a password themselves
					'user_email' => $_POST['email'],
					'first_name' => $_POST['first_name'],
					'last_name' => $_POST['last_name'],
					'role'  => 'sales_agent'
				);
	   $user_id = wp_insert_user( $userdata );
	   
	    if($user_id){
	        update_user_meta( $user_id, 'user_phone', $_POST['phone'] );
			update_user_meta( $user_id, 'user_personal_address', $_POST['address'] );
			update_user_meta( $user_id, 'user_designation', $_POST['designation'] );
			update_user_meta( $user_id, 'user_agent_status','active');
			$usersuccess = "Agent Added.";	
	   }
	   
  
  }
  if($usererror){
  ?>
   <div class="notice notice-error">
        <p><?php _e( $usererror, 'sample-text-domain' ); ?></p>
    </div> 
  <?php    
  }
  if($usersuccess){
  ?>
   <div class="notice notice-success is-dismissible">
        <p><?php _e( $usersuccess, 'sample-text-domain' ); ?></p>
    </div> 
  <?php   
  }
	
  
}

 ?>
 <h2 class="agent-title">Add Agent:</h2>
   <form method="post" class="wp_agent_form">
    <div class="form-agent">
		<label>First Name:</label></br>
		<input type="text" name="first_name" Placeholder="Enter First Name" required />
	</div>
	<div class="form-agent">
		<label>Last Name:</label></br>
		<input type="text" name="last_name" Placeholder="Enter Last Name"  required />
	</div>
	<div class="form-agent">
		<label>Email:</label></br>
		<input type="email" name="email" Placeholder="Enter email" required  />
	</div>
	<div class="form-agent">
		<label>phone:</label></br>
		<input type="text" id="phone" name="phone" pattern="[0-9]{10}" maxlength=10 required Placeholder="Enter Phone">
	</div>
	<div class="form-agent">
		<label>Designation:</label></br>
		<input type="text"  name="designation"  required Placeholder="Enter Designation">
	</div>
	<div class="form-agent">
		<label>Adress:</label></br>
		<textarea  name="address" required Placeholder="Enter Your address"></textarea>
	</div>
	<div class="form-agent">
	<button type="submit" name="agent_submission" class="button action">Add Agent</button>
	</div>
   </form>
   
 <?php 
}
function nyc_rooms_all_agents(){

  $useragents = get_users( [ 'role__in' => [ 'sales_agent' ] ] );
     
/*   echo "<pre>";
  print_r($useragents); */
  ?>
  
  <div id="data-table-div">
  <h1>All Agents</h1>
  
  <table id="table_id" class="display">
    <thead>
        <tr>
		    <th><input type="checkbox" class="Select_all_agent" id="all_selected_agent"></th>
            <th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Status</th>
			<th>Actions</th>
			
        </tr>
    </thead>
    <tbody>
	   <?php
	     foreach($useragents as $agents){
	   ?>
        <tr>
		    <th><input type="checkbox" class="agent_selected" value="<?= $agents->ID ?>" /></th>
            <td><?php echo $agents->data->display_name; ?></td>
			<td><?php echo $agents->data->user_email; ?></td>
			<td><?php echo get_user_meta($agents->ID,'user_phone',true); ?></td>
			<td><?php echo get_user_meta($agents->ID,'user_agent_status',true); ?></td>
			<td><a href="<?php echo site_url().'/wp-admin/admin.php?page=edit-agent&&userid='.$agents->ID ?>">Edit</a>&nbsp;&nbsp;<a href="<?php echo site_url().'/wp-admin/admin.php?page=delete-agent&&userid='.$agents->ID ?>">Delete</a> </td>
			
        </tr>
		<?php
		}
		?>
    </tbody>
</table>
<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-bottom" class="screen-reader-text">Select bulk action</label>
			<select name="action2" id="bulk-action-selector-bottom">
			 <option value="-1">Bulk Actions</option>
			 <option value="active" class="hide-if-no-js">Active</option>
			 <option value="inactive" class="hide-if-no-js">Inactive</option>
			 <option value="delete" class="hide-if-no-js">Delete</option>
            </select>
        <input type="submit" id="doaction2" class="button action" value="Apply">
</div>
</div>
 <?php
  
  
  
}

function nyc_rooms_edit_agents(){
    $getuser = get_user_by('id',$_GET['userid']);
	
	if(isset($_POST['agent_submission'])){
	  
	    $user_data = wp_update_user( 
		            array(
					       'ID' => $_POST['agent_id'], 
		                   'user_email' => $_POST['email'],
						   'display_name' => $_POST['first_name'].' ' .$_POST['last_name']
				    ) 
				   
				   );
 
           if ( is_wp_error( $user_data ) ) {
    
                   $usererror =  'Error in update user';
           } else {
		   
		          update_user_meta( $_POST['agent_id'], 'first_name', $_POST['first_name'] );
			      update_user_meta( $_POST['agent_id'], 'last_name', $_POST['last_name'] );
		          update_user_meta( $_POST['agent_id'], 'user_phone', $_POST['phone'] );
				  update_user_meta( $_POST['agent_id'], 'user_designation', $_POST['designation'] );
			      update_user_meta( $_POST['agent_id'], 'user_personal_address', $_POST['address'] );
			      update_user_meta( $_POST['agent_id'], 'user_agent_status',$_POST['set_status_agent']);
		   
                  $usersuccess = 'User profile updated.';
          }
		  
		  
      if($usererror){
    ?>
	   <div class="notice notice-error">
			<p><?php _e( $usererror, 'sample-text-domain' ); ?></p>
		</div> 
  <?php    
     }
     if($usersuccess){
    ?>
	   <div class="notice notice-success is-dismissible">
			<p><?php _e( $usersuccess, 'sample-text-domain' ); ?></p>
		</div> 
  <?php   
     }
		  
	}
	
    
	?>
	
	<h2 class="agent-title">Update Agent:</h2>
   <form method="post" class="wp_agent_form">
    <div class="form-agent">
		<label>First Name:</label></br>
		<input type="text" name="first_name"  value="<?php echo get_user_meta($getuser->ID,'first_name',true); ?>" required  />
	</div>
	<div class="form-agent">
		<label>Last Name:</label></br>
		<input type="text" name="last_name" value="<?php echo get_user_meta($getuser->ID,'last_name',true); ?>"  required />
	</div>
	<div class="form-agent">
		<label>Email:</label></br>
		<input type="email" name="email" value="<?php echo $getuser->data->user_email; ?>" required  />
	</div>
	<div class="form-agent">
		<label>phone:</label></br>
		<input type="text" id="phone" name="phone" pattern="[0-9]{10}" maxlength=10 required value="<?php echo get_user_meta($getuser->ID,'user_phone',true); ?>">
	</div>
	<div class="form-agent">
		<label>Designation:</label></br>
		<input type="text"  name="designation"  required value="<?php echo get_user_meta($getuser->ID,'user_designation',true); ?>">
	</div>
	<div class="form-agent">
		<label>Adress:</label></br>
		<textarea  name="address" required><?php echo get_user_meta($getuser->ID,'user_personal_address',true); ?></textarea>
	</div>
	<div class="form-agent">
		<label>Set Status:</label></br>
		<select name="set_status_agent">
			<option value="active" <?= (get_user_meta($getuser->ID,'user_agent_status',true) == 'active')? 'selected':'' ?>>Active</option>
			<option value="inactive" <?= (get_user_meta($getuser->ID,'user_agent_status',true) == 'inactive')? 'selected':'' ?> >Inactive</option>
		</select>
	</div>
	
	<div class="form-agent">
	<input type="hidden" name="agent_id" value="<?= $getuser->ID ?>">
	<button type="submit" name="agent_submission" class="button action">Update Agent</button>
	</div>
   </form>
   
<?php	
}

function nyc_rooms_delete_agents(){
   $getuser = get_user_by('id',$_GET['userid']);
   if(isset($_POST['submit'])){
      $success = wp_delete_user($_POST['users_delete']);
	  if($success){
	      $usersuccess = 'User Deleted';
	  }
	  
	  if($usersuccess){
    ?>
	   <div class="notice notice-success is-dismissible">
			<p><?php _e( $usersuccess, 'sample-text-domain' ); ?></p>
		</div> 
  <?php
        
     }
	  
	  
   }
   
?>
             <?php 
			  if($getuser){
			 ?>
             <form method="post">
              <div class="wrap">
                <h1>Delete Users</h1>
	                  <p>You have specified these users for deletion:</p>
					 <ul>
					   <li><input type="hidden" name="users_delete" value="<?= $_GET['userid']?>">ID #<?= $getuser->ID;?>: <?= $getuser->data->user_email; ?></li>
					</ul>
					 <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Confirm Deletion"></p> 
              </div>
             </form>
			
<?php
 }
}


add_action( 'wp_ajax_nopriv_delete_multiple_agents', 'delete_multiple_agents' );
add_action( 'wp_ajax_delete_multiple_agents', 'delete_multiple_agents' );
function delete_multiple_agents() {
	global $wpdb;
	foreach($_POST['data'] as $ids){
	  wp_delete_user($ids);
	}
	echo "true";
	wp_die();
}

add_action( 'wp_ajax_nopriv_delete_multiple_leads', 'delete_multiple_leads' );
add_action( 'wp_ajax_delete_multiple_leads', 'delete_multiple_leads' );
function delete_multiple_leads() {
	global $wpdb;
	foreach($_POST['data'] as $ids){
	  wp_delete_post($ids);
	}
	echo "true";
	wp_die();
}

add_action( 'wp_ajax_nopriv_adding_multiple_deals', 'adding_multiple_deals' );
add_action( 'wp_ajax_adding_multiple_deals', 'adding_multiple_deals' );
function adding_multiple_deals(){
	global $wpdb;
	  if(isset($_POST['action']) && $_POST['action'] == 'adding_multiple_deals'){
	   foreach($_POST['data'] as $ids){
	      $lead_source     =  get_post_meta($ids,'lead_source',true);
		  if($lead_source == "Property Form"){
			  $DealDescription =  get_post_meta($ids,'lead_summary',true);
			  $property_id     =  get_post_meta($ids, 'lead_checkout_property', true);
			  $lead_user_id    =  get_post_meta($ids, 'lead_created_user_id',true);
			  $lead_name       =  get_post_meta($ids, 'lead_name',true);
			  $lead_email	   =  get_post_meta($ids, 'lead_email',true);
			  $lead_phone	   =  get_post_meta($ids, 'lead_phone',true);
			  $deal_id = wp_insert_post(array (
											'post_type'		=> 'deals',
											'post_title' 	=> 'deal submission',
											'post_content' 	=> $DealDescription,
											'post_author' 	=> get_current_user_id(),
											'post_status'   => 'publish'
								   ));
			
			
							 if ($deal_id) {
								add_post_meta($deal_id, 'lead_source',$lead_source);
								add_post_meta($deal_id, 'property_id',$property_id);
								add_post_meta($deal_id, 'user_id',$lead_user_id);
								add_post_meta($deal_id, 'name',$lead_name);
								add_post_meta($deal_id, 'email',$lead_email);
								add_post_meta($deal_id, 'phone',$lead_phone);
								add_post_meta($deal_id, 'lead_id',$ids);
								add_post_meta($deal_id, 'description',$DealDescription);
								add_post_meta($deal_id, 'deal_stage',1);
								add_post_meta($deal_id, 'deal_created_by',get_current_user_id());
								add_post_meta($ids,'is_deal_created','yes');
								add_post_meta($ids,'deal_id',$deal_id);
								
							}
		 }
		 
		 if($lead_source == "Appointment Form"){
			  $DealDescription  =  get_post_meta($ids,'lead_summary',true);
			  $lead_user_id     =  get_post_meta($ids, 'lead_created_user_id',true);
			  $lead_name        =  get_post_meta($ids, 'lead_name',true);
			  $lead_email	    =  get_post_meta($ids, 'lead_email',true);
			  $lead_phone	    =  get_post_meta($ids, 'lead_phone',true);
			  $lead_datetime    =  get_post_meta($ids, 'lead_datetime',true);	
			  $deal_id = wp_insert_post(array (
											'post_type'		=> 'deals',
											'post_title' 	=> 'deal submission',
											'post_content' 	=> $DealDescription,
											'post_author' 	=> get_current_user_id(),
											'post_status'   => 'publish'
								   ));
			
			
							 if ($deal_id) {
							 
								add_post_meta($deal_id, 'lead_source',$lead_source);
								add_post_meta($deal_id, 'user_id',$lead_user_id);
								add_post_meta($deal_id, 'name',$lead_name);
								add_post_meta($deal_id, 'email',$lead_email);
								add_post_meta($deal_id, 'phone',$lead_phone);
								add_post_meta($deal_id, 'lead_id',$ids);
								add_post_meta($deal_id, 'lead_datetime',$lead_datetime);
								add_post_meta($deal_id, 'description',$DealDescription);
								add_post_meta($deal_id, 'deal_stage',1);
								add_post_meta($deal_id, 'deal_created_by',get_current_user_id());
								add_post_meta($ids,'is_deal_created','yes');
								add_post_meta($ids,'deal_id',$deal_id);
								
							}
							
		 }
							
	 
	   }
	   echo "true";
	 }
	wp_die();
}

/*--------- Delete Property --------------*/

add_action( 'wp_ajax_nopriv_delete_multiple_properties', 'delete_multiple_properties' );
add_action( 'wp_ajax_delete_multiple_properties', 'delete_multiple_properties' );
function delete_multiple_properties() {
	global $wpdb;
	foreach($_POST['data'] as $ids){
	  wp_trash_post($ids);
	}
	echo "true";
	wp_die();
}

/*--------- Activate Property --------------*/

add_action( 'wp_ajax_nopriv_activate_multiple_properties', 'activate_multiple_properties' );
add_action( 'wp_ajax_activate_multiple_properties', 'activate_multiple_properties' );
function activate_multiple_properties() {
	global $wpdb;
	foreach($_POST['data'] as $ids){
	  delete_post_meta($ids,'property_inactive');
	}
	echo "true";
	wp_die();
}

/*--------- Deactivate Property --------------*/

add_action( 'wp_ajax_nopriv_deactivate_multiple_properties', 'deactivate_multiple_properties' );
add_action( 'wp_ajax_deactivate_multiple_properties', 'deactivate_multiple_properties' );
function deactivate_multiple_properties() {
	global $wpdb;
	foreach($_POST['data'] as $ids){
	   update_post_meta($ids,'property_inactive',1);
	}
	echo "true";
	wp_die();
}


add_action( 'wp_ajax_nopriv_active_multiple_agents', 'active_multiple_agents' );
add_action( 'wp_ajax_active_multiple_agents', 'active_multiple_agents' );
function active_multiple_agents() {
	global $wpdb;
	foreach($_POST['data'] as $ids){
	update_user_meta( $ids, 'user_agent_status','active' );
	}
	echo "true";
	wp_die();
}

add_action( 'wp_ajax_nopriv_inactive_multiple_agents', 'inactive_multiple_agents' );
add_action( 'wp_ajax_inactive_multiple_agents', 'inactive_multiple_agents' );
function inactive_multiple_agents() {
	global $wpdb;
	foreach($_POST['data'] as $ids){
	 update_user_meta( $ids, 'user_agent_status','inactive');
	}
	echo "true";
	wp_die();
}


add_action( 'wp_ajax_nopriv_approve_multiple_properties', 'approve_multiple_properties' );
add_action( 'wp_ajax_approve_multiple_properties', 'approve_multiple_properties' );
function approve_multiple_properties() {

	global $wpdb;
	foreach($_POST['data'] as $ids){
	
	$status = get_post_meta( $ids, 'status',true);
	   wp_update_post(array(
			'ID'    =>  $ids,
			'post_status'   =>  $status
	   ));
	   
	 
	 /*---------- Email After Approval of Property -------------*/
	 $name                =  get_post_meta( $ids, 'contact_name',true);
	 $email               =  get_post_meta( $ids, 'contact_email',true);
	 $property_link       =  '<a href="'. get_post_permalink($ids) .'">'. get_the_title( $ids ) .'</a>';
			   
	 $subject = "Property Approval From NYC Rooms";
	 $to = $email;
	 $msg  = sprintf(__( 'Hello %s'),$name);
	 $msg .= sprintf( __("<p>Congratulation!! Your Property %s Has Been Approved. Now it is live on NYC ROOMS and comes in User's Search.</p>"),$property_link);
	 $msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
	 $headers = array('Content-Type: text/html; charset=UTF-8');
	 $sent = wp_mail($to,$subject,$msg,$headers);
	 
	}
	echo "true";
	wp_die();
	
}



add_action( 'wp_ajax_nopriv_unapprove_multiple_properties', 'unapprove_multiple_properties' );
add_action( 'wp_ajax_unapprove_multiple_properties', 'unapprove_multiple_properties' );
function unapprove_multiple_properties() {
	global $wpdb;
	foreach($_POST['data'] as $ids){
	$getpropstatus = get_post_status( $ids );
	   if($getpropstatus != 'draft'){
			   wp_update_post(array(
					'ID'    =>  $ids,
					'post_status'   => 'draft'
			   ));
	   }
	}
	echo "true";
	wp_die();
}






function nyc_add_to_favorite() {
    // Get the existing meta for 'meta_key'
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_add_to_favorite'){
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
add_action( 'wp_ajax_nyc_add_to_favorite', 'nyc_add_to_favorite' );
add_action( 'wp_ajax_nopriv_nyc_add_to_favorite', 'nyc_add_to_favorite' );

function nyc_check_is_bookmark($post_id=''){
$is_bookmark='';
$user_id=get_current_user_id(); 
if($user_id){
	$b_data = get_user_meta($user_id,'nyc_bookmark', true);
	if(in_array($post_id, $b_data)){
       $is_bookmark='liked';
	}
}
return $is_bookmark;
}

function get_lat_long($address,$region){	

    $address = str_replace(" ", "+", $address);	
	$region  = str_replace(" ", "+", $region);	
	

    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyDkB8x8TIEGgMQIeZjIEJILbKOn_5uEP8I&&address=$address&&region=$region");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return array( 
	              'longitude' => $long,
	              'latitude' => $lat,
				 );
}

add_action( 'init', 'nyc_create_custom_post_leads', 0 );
function nyc_create_custom_post_leads() {
	$labels = array(
		'name'                => __( 'Leads' ),
		'singular_name'       => __( 'leads'),
		'menu_name'           => __( 'Leads'),
		'parent_item_colon'   => __( 'Parent Leads'),
		'all_items'           => __( 'All Leads'),
		'view_item'           => __( 'View Leads'),
		'add_new_item'        => __( 'Add New Lead'),
		'add_new'             => __( 'Add New'),
		'edit_item'           => __( 'Edit Leads'),
		'update_item'         => __( 'Update Leads'),
		'search_items'        => __( 'Search Leads'),
		'not_found'           => __( 'Not Found'),
		'not_found_in_trash'  => __( 'Not found in Trash')
	);
	$args = array(
		'label'               => __( 'leads'),
		'description'         => __( 'Best Leads'),
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
	register_post_type( 'leads', $args );
}

add_action( 'init', 'nyc_create_custom_post_deals', 0 );

function nyc_create_custom_post_deals() {
	$labels = array(
		'name'                => __( 'Deals' ),
		'singular_name'       => __( 'Deals'),
		'menu_name'           => __( 'Deals'),
		'parent_item_colon'   => __( 'Parent Deals'),
		'all_items'           => __( 'All Deals'),
		'view_item'           => __( 'View Deals'),
		'add_new_item'        => __( 'Add New Deals'),
		'add_new'             => __( 'Add New'),
		'edit_item'           => __( 'Edit Deals'),
		'update_item'         => __( 'Update Deals'),
		'search_items'        => __( 'Search Deals'),
		'not_found'           => __( 'Not Found'),
		'not_found_in_trash'  => __( 'Not found in Trash')
	);
	$args = array(
		'label'               => __( 'deals'),
		'description'         => __( 'Best Deals'),
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
	register_post_type( 'deals', $args );
}


function get_all_agents(){
   $argspage = array(
         'role__in' => 'sales_agent',
		 'number' => -1

        );
		
$users = new WP_User_Query( $argspage ); 
$user_count_agents = $users->get_results();
  return count($user_count_agents);
}

function get_all_leads(){
   $args = array(
         'post_type'        => 'leads',
		 'post_status'       => 'publish',
         'posts_per_page'   => -1,
         //'no_found_rows'    => true,
         'suppress_filters' => false,
        );
	$all_leads = new WP_Query( $args );
	$count = $all_leads->found_posts;
	 return $count;

}

function get_all_property_owner_counts(){

$argspage = array(
         'role__in' => 'property_owner',
		 'number' => -1

        );
		
$users = new WP_User_Query( $argspage ); 
$user_count_propowner = $users->get_results();

return count($user_count_propowner);

}

function get_all_property_owner_recent_counts(){
$argspage = array(
         'role__in' => 'property_owner',
		 'number' => -1

        );
$users = new WP_User_Query( $argspage ); 
$user_count_propowner = $users->get_results();
$count = count($user_count_propowner);
if($count <= 20){
      $count = $count;
} else{
      $count = 20;
}
return $count;

}


function get_recent_leads(){
    $args = array(
         'post_type'        => 'leads',
		 'post_status'       => 'publish',
         //'no_found_rows'    => true,
         'suppress_filters' => false,
		 'orderby'          => 'post_date',
         'order'            => 'DESC',
		 'numberposts'      => 20,

        );
    $all_leads = wp_get_recent_posts($args);
	return count($all_leads);
	
						 
}

function nyc_property_admin_authority(){
	if( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;
		if(!in_array('administrator',$roles)){
		   wp_redirect(home_url());
		}
	}else{
		wp_redirect(home_url());
	}
}

function nyc_get_properties_admin_by_status($status){
	$properties = new WP_Query(array(
		'posts_per_page' 	=> -1,
		'post_type' 		=> 'property',
		'post_status' 		=> $status,
	));
	return $properties;
}
function nyc_get_recent_properties(){
$args =  array(
					'numberposts'      => -1,
					'post_type'        => 'property',
					'post_status'      => 'draft',
         );
$properties = new WP_Query( $args );
return $properties->found_posts;
}

function nyc_get_admin_approved_properties(){
$args =  array(
					'numberposts'      => -1,
					'post_type'        => 'property',
					'post_status'      => array('available','rented'),
         );
$properties = new WP_Query( $args );
return $properties->found_posts;
}


function pagination_bar() { ?>
<div class="row fs-listings">
					<div class="col-md-12">

						<!-- Pagination -->
						<div class="clearfix"></div>
						<div class="pagination-container margin-top-10 margin-bottom-45">
							<nav class="pagination">
							<ul>
							
								<?php
    global $wp_query;
    $big = 9999999;
          ?>
		  
		  <?php
         echo paginate_links(array(
            'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))),
            'format' =>  '/paged/%#%',
            'current' => max(1,get_query_var('paged')),
            'total' => $wp_query->max_num_pages
        )); 
		?>
 
	
	</ul>
	</div>
	</nav>
	</div>
	</div>
	
	<?php 
}
function nyc_get_properties_by_property_owner($id){
	$properties = new WP_Query(array(
		'posts_per_page' 	=> -1,
		'post_type' 		=> 'property',
		'post_status' 		=> array('available','rented','inherit'),
		'author' 			=>  'property-owner',
		'post_author'       => $id,
	));
	return $properties;
}



add_filter( 'posts_where', 'nyc_get_properties_by_title', 10, 2 );
function nyc_get_properties_by_title( $where, $wp_query )
{
    global $wpdb;
    if ( $wpse18703_title = $wp_query->get( '_meta_or_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( $wpdb->esc_like( $wpse18703_title ) ) . '%\'';
    }
    return $where;
}

function img_exist($url = NULL)
{
    if (!$url) return false;
    $headers = get_headers($url);
    return stripos($headers[0], "200 OK") ? true : false;
}

function RemoveSpaces($url){
     
	  $url = preg_replace('/\s+/', '-', trim($url));
	  $url = str_replace("         ","-",$url);
	  $url = str_replace("        ","-",$url);
	  $url = str_replace("       ","-",$url);
	  $url = str_replace("      ","-",$url);
	  $url = str_replace("     ","-",$url);
	  $url = str_replace("    ","-",$url);
	  $url = str_replace("   ","-",$url);
	  $url = str_replace("  ","-",$url);
	  $url = str_replace(" ","-",$url);
	
     return $url;
     
}

function RemoveUrlSpaces($url){

        $url = preg_replace('/\s+/', '%20', trim($url));  
        $url = str_replace("         ","%20",$url);
        $url = str_replace("        ","%20",$url);
        $url = str_replace("       ","%20",$url);
        $url = str_replace("      ","%20",$url);
        $url = str_replace("     ","%20",$url);
        $url = str_replace("    ","%20",$url);
	    $url = str_replace("   ","%20",$url);
	    $url = str_replace("  ","%20",$url);
	    $url = str_replace(" ","%20",$url);
		
        return $url;
     
}

function DownloadAnything($file, $newfilename = '', $mimetype='', $isremotefile = false){
         
        $formattedhpath = "";
        $filesize = "";

        if(empty($file)){
           die('Please enter file url to download...!');
           exit;
        }
     
         //Removing spaces and replacing with %20 ascii code
         $file = RemoveUrlSpaces($file);
          
          
        if(preg_match("#http://#", $file)){
          $formattedhpath = "url";
        }else{
          $formattedhpath = "filepath";
        }
		
		 if(preg_match("#https://#", $file)){
          $formattedhpath = "url";
         }else{
          $formattedhpath = "filepath";
         }
		
		
		
        if($formattedhpath == "url"){

          $file_headers = @get_headers($file);
  
          if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
           die('File is not readable or not found...!');
           exit;
          }
          
        }elseif($formattedhpath == "filepath"){

          if(@is_readable($file)) {
               die('File is not readable or not found...!');
               exit;
          }
        }
        
        
       //Fetching File Size Located in Remote Server
       if($isremotefile && $formattedhpath == "url"){
          
          
          $data = @get_headers($file, true);
          
          if(!empty($data['Content-Length'])){
          $filesize = (int)$data["Content-Length"];
          
          }else{
               
               ///If get_headers fails then try to fetch filesize with curl
               $ch = @curl_init();

               if(!@curl_setopt($ch, CURLOPT_URL, $file)) {
                 @curl_close($ch);
                 @exit;
               }
               
               @curl_setopt($ch, CURLOPT_NOBODY, true);
               @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               @curl_setopt($ch, CURLOPT_HEADER, true);
               @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
               @curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
               @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
               @curl_exec($ch);
               
               if(!@curl_errno($ch))
               {
                    
                    $http_status = (int)@curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if($http_status >= 200  && $http_status <= 300)
                    $filesize = (int)@curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
               
               }
               @curl_close($ch);
               
          }
          
       }elseif($isremotefile && $formattedhpath == "filepath"){
         
	   die('Error : Need complete URL of remote file...!');
           exit;
		   
       }else{
         
		   if($formattedhpath == "url"){
		   
			   $data = @get_headers($file, true);
			   $filesize = (int)$data["Content-Length"];
			   
		   }elseif($formattedhpath == "filepath"){
		   
		       $filesize = (int)@filesize($file);
			   
		   }
		   
       }
       
       if(empty($newfilename)){
          $newfilename =  @basename($file);
       }else{
          //Replacing any spaces with (-) hypen
          $newfilename = RemoveSpaces($newfilename);
       }
       
       if(empty($mimetype)){
          
       ///Get the extension of the file
       $path_parts = @pathinfo($file);
       $myfileextension = $path_parts["extension"];

        switch($myfileextension)
        {
          
            ///Image Mime Types
            case 'jpg':
            $mimetype = "image/jpg";
            break;
            case 'jpeg':
            $mimetype = "image/jpeg";
            break;
            case 'gif':
            $mimetype = "image/gif";
            break;
            case 'png':
            $mimetype = "image/png";
            break;
            case 'bm':
            $mimetype = "image/bmp";
            break;
            case 'bmp':
            $mimetype = "image/bmp";
            break;
            case 'art':
            $mimetype = "image/x-jg";
            break;
            case 'dwg':
            $mimetype = "image/x-dwg";
            break;
            case 'dxf':
            $mimetype = "image/x-dwg";
            break;
            case 'flo':
            $mimetype = "image/florian";
            break;
            case 'fpx':
            $mimetype = "image/vnd.fpx";
            break;
            case 'g3':
            $mimetype = "image/g3fax";
            break;
            case 'ief':
            $mimetype = "image/ief";
            break;
            case 'jfif':
            $mimetype = "image/pjpeg";
            break;
            case 'jfif-tbnl':
            $mimetype = "image/jpeg";
            break;
            case 'jpe':
            $mimetype = "image/pjpeg";
            break;
            case 'jps':
            $mimetype = "image/x-jps";
            break;
            case 'jut':
            $mimetype = "image/jutvision";
            break;
            case 'mcf':
            $mimetype = "image/vasa";
            break;
            case 'nap':
            $mimetype = "image/naplps";
            break;
            case 'naplps':
            $mimetype = "image/naplps";
            break;
            case 'nif':
            $mimetype = "image/x-niff";
            break;
            case 'niff':
            $mimetype = "image/x-niff";
            break;
            case 'cod':
            $mimetype = "image/cis-cod";
            break;
            case 'ief':
            $mimetype = "image/ief";
            break;
            case 'svg':
            $mimetype = "image/svg+xml";
            break;
            case 'tif':
            $mimetype = "image/tiff";
            break;
            case 'tiff':
            $mimetype = "image/tiff";
            break;
            case 'ras':
            $mimetype = "image/x-cmu-raster";
            break;
            case 'cmx':
            $mimetype = "image/x-cmx";
            break;
            case 'ico':
            $mimetype = "image/x-icon";
            break;
            case 'pnm':
            $mimetype = "image/x-portable-anymap";
            break;
            case 'pbm':
            $mimetype = "image/x-portable-bitmap";
            break;
            case 'pgm':
            $mimetype = "image/x-portable-graymap";
            break;
            case 'ppm':
            $mimetype = "image/x-portable-pixmap";
            break;
            case 'rgb':
            $mimetype = "image/x-rgb";
            break;
            case 'xbm':
            $mimetype = "image/x-xbitmap";
            break;
            case 'xpm':
            $mimetype = "image/x-xpixmap";
            break;
            case 'xwd':
            $mimetype = "image/x-xwindowdump";
            break;
            case 'rgb':
            $mimetype = "image/x-rgb";
            break;
            case 'xbm':
            $mimetype = "image/x-xbitmap";
            break;
            case "wbmp":
            $mimetype = "image/vnd.wap.wbmp";
            break;
          
            //Files MIME Types
            
            case 'css':
            $mimetype = "text/css";
            break;
            case 'htm':
            $mimetype = "text/html";
            break;
            case 'html':
            $mimetype = "text/html";
            break;
            case 'stm':
            $mimetype = "text/html";
            break;
            case 'c':
            $mimetype = "text/plain";
            break;
            case 'h':
            $mimetype = "text/plain";
            break;
            case 'txt':
            $mimetype = "text/plain";
            break;
            case 'rtx':
            $mimetype = "text/richtext";
            break;
            case 'htc':
            $mimetype = "text/x-component";
            break;
            case 'vcf':
            $mimetype = "text/x-vcard";
            break;
           
           
            //Applications MIME Types
            
            case 'doc':
            $mimetype = "application/msword";
            break;
            case 'xls':
            $mimetype = "application/vnd.ms-excel";
            break;
            case 'ppt':
            $mimetype = "application/vnd.ms-powerpoint";
            break;
            case 'pps':
            $mimetype = "application/vnd.ms-powerpoint";
            break;
            case 'pot':
            $mimetype = "application/vnd.ms-powerpoint";
            break;
          
            case "ogg":
            $mimetype = "application/ogg";
            break;
            case "pls":
            $mimetype = "application/pls+xml";
            break;
            case "asf":
            $mimetype = "application/vnd.ms-asf";
            break;
            case "wmlc":
            $mimetype = "application/vnd.wap.wmlc";
            break;
            case 'dot':
            $mimetype = "application/msword";
            break;
            case 'class':
            $mimetype = "application/octet-stream";
            break;
            case 'exe':
            $mimetype = "application/octet-stream";
            break;
            case 'pdf':
            $mimetype = "application/pdf";
            break;
            case 'rtf':
            $mimetype = "application/rtf";
            break;
            case 'xla':
            $mimetype = "application/vnd.ms-excel";
            break;
            case 'xlc':
            $mimetype = "application/vnd.ms-excel";
            break;
            case 'xlm':
            $mimetype = "application/vnd.ms-excel";
            break;
           
            case 'msg':
            $mimetype = "application/vnd.ms-outlook";
            break;
            case 'mpp':
            $mimetype = "application/vnd.ms-project";
            break;
            case 'cdf':
            $mimetype = "application/x-cdf";
            break;
            case 'tgz':
            $mimetype = "application/x-compressed";
            break;
            case 'dir':
            $mimetype = "application/x-director";
            break;
            case 'dvi':
            $mimetype = "application/x-dvi";
            break;
            case 'gz':
            $mimetype = "application/x-gzip";
            break;
            case 'js':
            $mimetype = "application/x-javascript";
            break;
            case 'mdb':
            $mimetype = "application/x-msaccess";
            break;
            case 'dll':
            $mimetype = "application/x-msdownload";
            break;
            case 'wri':
            $mimetype = "application/x-mswrite";
            break;
            case 'cdf':
            $mimetype = "application/x-netcdf";
            break;
            case 'swf':
            $mimetype = "application/x-shockwave-flash";
            break;
            case 'tar':
            $mimetype = "application/x-tar";
            break;
            case 'man':
            $mimetype = "application/x-troff-man";
            break;
            case 'zip':
            $mimetype = "application/zip";
            break;
            case 'xlsx':
            $mimetype = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
            break;
            case 'pptx':
            $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
            break;
            case 'docx':
            $mimetype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
            break;
            case 'xltx':
            $mimetype = "application/vnd.openxmlformats-officedocument.spreadsheetml.template";
            break;
            case 'potx':
            $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.template";
            break;
            case 'ppsx':
            $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.slideshow";
            break;
            case 'sldx':
            $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.slide";
            break;
          
            ///Audio and Video Files
            
            case 'mp3':
            $mimetype = "audio/mpeg";
            break;
            case 'wav':
            $mimetype = "audio/x-wav";
            break;
            case 'au':
            $mimetype = "audio/basic";
            break;
            case 'snd':
            $mimetype = "audio/basic";
            break;
            case 'm3u':
            $mimetype = "audio/x-mpegurl";
            break;
            case 'ra':
            $mimetype = "audio/x-pn-realaudio";
            break;
            case 'mp2':
            $mimetype = "video/mpeg";
            break;
            case 'mov':
            $mimetype = "video/quicktime";
            break;
            case 'qt':
            $mimetype = "video/quicktime";
            break;
            case 'mp4':
            $mimetype = "video/mp4";
            break;
            case 'm4a':
            $mimetype = "audio/mp4";
            break;
            case 'mp4a':
            $mimetype = "audio/mp4";
            break;
            case 'm4p':
            $mimetype = "audio/mp4";
            break;
            case 'm3a':
            $mimetype = "audio/mpeg";
            break;
            case 'm2a':
            $mimetype = "audio/mpeg";
            break;
            case 'mp2a':
            $mimetype = "audio/mpeg";
            break;
            case 'mp2':
            $mimetype = "audio/mpeg";
            break;
            case 'mpga':
            $mimetype = "audio/mpeg";
            break;
            case '3gp':
            $mimetype = "video/3gpp";
            break;
            case '3g2':
            $mimetype = "video/3gpp2";
            break;
            case 'mp4v':
            $mimetype = "video/mp4";
            break;
            case 'mpg4':
            $mimetype = "video/mp4";
            break;
            case 'm2v':
            $mimetype = "video/mpeg";
            break;
            case 'm1v':
            $mimetype = "video/mpeg";
            break;
            case 'mpe':
            $mimetype = "video/mpeg";
            break;
            case 'avi':
            $mimetype = "video/x-msvideo";
            break;
            case 'midi':
            $mimetype = "audio/midi";
            break;
            case 'mid':
            $mimetype = "audio/mid";
            break;
            case 'amr':
            $mimetype = "audio/amr";
            break;
            
            
            default:
            $mimetype = "application/octet-stream";
        
            
        }
        
        
       }
        
        
          //off output buffering to decrease Server usage
          @ob_end_clean();
        
          if(ini_get('zlib.output_compression')){
            ini_set('zlib.output_compression', 'Off');
          }
        
          header('Content-Description: File Transfer');
          header('Content-Type: '.$mimetype);
          header('Content-Disposition: attachment; filename='.$newfilename.'');
          header('Content-Transfer-Encoding: binary');
          header("Expires: Wed, 07 May 2013 09:09:09 GMT");
	      header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	      header('Cache-Control: post-check=0, pre-check=0', false);
	      header('Cache-Control: no-store, no-cache, must-revalidate');
	      header('Pragma: no-cache');
          header('Content-Length: '.$filesize);
        
        
          ///Will Download 1 MB in chunkwise
          $chunk = 1 * (1024 * 1024);
          $nfile = @fopen($file,"rb");
          while(!feof($nfile))
          {
                 
              print(@fread($nfile, $chunk));
              @ob_flush();
              @flush();
          }
          @fclose($filen);
               


}

add_action( 'wp_ajax_nyc_upload_application_form', 'nyc_upload_application_form' );
add_action( 'wp_ajax_nopriv_nyc_upload_application_form', 'nyc_upload_application_form' );

function nyc_upload_application_form(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_upload_application_form'){
		//global $wpdb;
		
		$deal_id = $_POST['deal_id'];
		if(isset($_FILES)){
			foreach($_FILES as $key=>$file){
				  nyc_property_gallery_application_form_upload($key,$deal_id);
			}
		}
		echo "success";
	}
	exit;
}


function nyc_property_gallery_application_form_upload($file_name,$post_id){
		$uploaddir = wp_upload_dir();
		$meta_key = 'document_files';
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
	   update_post_meta($post_id, $meta_key, $attach_id);
	   
}

add_action( 'wp_ajax_nyc_get_existing_application_form_ajax', 'nyc_get_existing_application_form_ajax' );
add_action( 'wp_ajax_nopriv_nyc_get_existing_application_form_ajax', 'nyc_get_existing_application_form_ajax' );

function nyc_get_existing_application_form_ajax(){
      if(isset($_POST['action']) && $_POST['action'] == 'nyc_get_existing_application_form_ajax'){
             $arrayfiles = array();
			 $attchment_id = get_post_meta($_POST['deal_id'],'document_files',true);
			 $filename = basename(get_attached_file($attchment_id));
			 $arrayfiles[] = $filename;
			  

			 $file_list = array();
			 $uploaddir = wp_upload_dir();

			  $dir       =  $uploaddir['path'].'/';
			  $pathurl   =  $uploaddir['url'].'/';
			 
			 
			  foreach($arrayfiles as $file){
			 // File path
                $file_path = $dir.$file;
				$file_pathurl  = $pathurl.$file;
				$type = pathinfo($file_pathurl, PATHINFO_EXTENSION);
				$data = file_get_contents($file_pathurl);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
				
				if(!is_dir($file_path)){
                   $size = filesize($file_path);
                   $file_list[] = array('name'=>$file,'size'=>$size,'path'=> $base64);
				}
            }
           echo json_encode($file_list);  
		 }
				
  exit; 
}

add_action( 'wp_ajax_nyc_delete_existing_application_form_ajax', 'nyc_delete_existing_application_form_ajax' );
add_action( 'wp_ajax_nopriv_nyc_delete_existing_application_form_ajax', 'nyc_delete_existing_application_form_ajax' );

function nyc_delete_existing_application_form_ajax(){
   if(isset($_POST['action']) && $_POST['action'] == 'nyc_delete_existing_application_form_ajax'){
     $uploaddir  =  wp_upload_dir();
	 $dir        =  $uploaddir['path'].'/';
	 $pathurl    =  $uploaddir['url'].'/';
     $deal_id    = $_POST['deal_id'];
	 $file_name  =  $_POST['file_name'];
	 $file_url   = $pathurl . $file_name;
	 $attchment_id = get_post_meta($deal_id,'document_files',true);
     $attachment_url = wp_get_attachment_url($attchment_id);
			if($attachment_url == $file_url){
			   wp_delete_attachment($attchment_id, true);
			   delete_post_meta( $deal_id,'document_files',$attchment_id); 
			    echo "success";
			} else {
			    echo "faliure";
            }			
	 
	   
   } else {
      echo "faliure";
   }
  exit; 
}

add_action( 'wp_ajax_nyc_request_agent_ajax', 'nyc_request_agent_ajax' );
add_action( 'wp_ajax_nopriv_nyc_request_agent_ajax', 'nyc_request_agent_ajax' );

function nyc_request_agent_ajax(){
   if(isset($_POST['action']) && $_POST['action'] == 'nyc_request_agent_ajax'){
     $deal_id    = $_POST['deal_id'];			
	 $meta_key   = 'request_an_agent';
	 $notification = "Tenant Requested for an agent on Deal no ".$deal_id;
	 nyc_add_noticication($notification);
	 update_post_meta($deal_id,$meta_key,1);
	        $subject = "New Agent Request";
	        $to = get_option('admin_email');
			$msg  = __( 'Hello Admin,') . "\r\n\r\n";
			$msg .= sprintf( __('<p>A New Agent has been Requested by Tenant on Deal no. %s.</p>'),$deal_id);
			$msg .= sprintf( __('<p>Please Follow this deal link <a href="%s/admin/deals/details/%s">%s/admin/deals/details/%s</a>in by open your dashboard for more information.</p>'),get_site_url(),$deal_id,get_site_url(),$deal_id);
			$msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
			$headers = array('Content-Type: text/html; charset=UTF-8');
		    $sent = wp_mail($to, $subject, $msg,$headers);
	 echo "success";
   } else {
      echo "faliure";
   }
  exit; 
}

add_action( 'wp_ajax_nyc_tenant_final_selected_property_ajax', 'nyc_tenant_final_selected_property_ajax' );
add_action( 'wp_ajax_nopriv_nyc_tenant_final_selected_property_ajax', 'nyc_tenant_final_selected_property_ajax' );

function nyc_tenant_final_selected_property_ajax(){
   if(isset($_POST['action']) && $_POST['action'] == 'nyc_tenant_final_selected_property_ajax'){
     $deal_id    = $_POST['deal_id'];
	 $name         =   get_post_meta($deal_id,'name',true);
     $email        =   get_post_meta($deal_id,'email',true);
     $phone        =   get_post_meta($deal_id,'phone',true);
     $property_id    = $_POST['property_id'];	 
	 $meta_key   = 'property_id';
	 update_post_meta($deal_id,$meta_key,$property_id);
	 update_post_meta($deal_id,'property_finalization',1);
	$notification = "A Property has been Finalized by Tenant on Deal no ".$deal_id;
	nyc_add_noticication($notification);		 
	 $subject = "New Property Finalization Request on Deal No-".$deal_id;
	  /*----------- admin mail -------------*/
	 $to = get_option('admin_email');
	 $msg  = __( 'Hello Admin,') . "\r\n\r\n";
	 $msg .= sprintf( __('<p>A New Property has been finalized  by Tenant With name: %s,email: %s,phone: %s on deal no: %s.</p>'),$name,$email,$phone,$deal_id);
	 $msg .= sprintf( __('<p>Please Follow this deal link <a href="%s/admin/deals/details/%s">%s/admin/deals/details/%s</a>in by open your dashboard for more information.</p>'),get_site_url(),$deal_id,get_site_url(),$deal_id);
	 $msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
	 $headers = array('Content-Type: text/html; charset=UTF-8');
	 $sent = wp_mail($to, $subject, $msg,$headers);
	 
	 /*----------- tenant mail -------------*/
	 
	 $subject1 = "Property Finaliztion On Deal No-".$deal_id;
	 $to1 = $email;
	 $msg1  = sprintf(__( 'Hello %s'),$name);
	 $msg1 .= sprintf( __('<p>We Have Recieved Your Request on deal no: %s.</p><p>One of our representative will be in touch with you and Process your request as soon as Possible</p>'),$deal_id);
	 $msg1 .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
	 $headers1 = array('Content-Type: text/html; charset=UTF-8');
	 $sent = wp_mail($to1, $subject1, $msg1,$headers1);
	 echo "success";
   } else {
      echo "faliure";
   }
  exit; 
}

require get_stylesheet_directory(). '/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;

define('IMGPATH','images/cropped-logo.jpg');


add_action( 'wp_ajax_nyc_tenant_payment_square_ajax', 'nyc_tenant_payment_square_ajax' );
add_action( 'wp_ajax_nopriv_nyc_tenant_payment_square_ajax', 'nyc_tenant_payment_square_ajax' );

function nyc_tenant_payment_square_ajax(){
   if(isset($_POST['action']) && $_POST['action'] == 'nyc_tenant_payment_square_ajax'){
   
	  $production_mode = false;
	  if($production_mode){
	      $urlslug = "squareup";
	  } else {
	      $urlslug = "squareupsandbox";
	  }
	  $nonce              =  $_POST['nonce'];
	  $amount             =  (int) $_POST['amountvalue'];
	  $payment_url        =  "https://connect.". $urlslug .".com/v2/payments";
	  $accesstoken        =  "EAAAELlAyEc4jT3NtaKrozS8u8KOUyVpoKu3deWKA7LoZEvi8i34T_hKIhLs5MHC";
	  $square_version     =  "2020-06-25";
	  $content_type       =  "application/json";
	  $method             =  "POST";
	  $requestbody        =  array(
	                          "idempotency_key" => md5(uniqid(uniqid())),
							  "source_id" =>  $nonce,
							  "amount_money" => array(
													  "currency"=>"USD",
													  "amount"=> $amount 
							                    )
						    );
							
	  $headers            =  array(
								"Square-Version: ". $square_version,
								"Authorization: Bearer ". $accesstoken,
								"Content-Type: ". $content_type
                            );				
	
      $response          =   nyc_get_tenant_payment_square_ajax_curl($payment_url,$headers,$method,json_encode($requestbody));
	  
	  if( isset($response->payment->status) && isset($response->payment->id)){
	      $invoice_id                =  uniqid();
	      $deal_id                   =   $_POST['deal_id'];
		  $get_selected_agent        =   get_post_meta($deal_id,'selectedAgent',true);
		  $get_requested_agent       =   get_post_meta($deal_id,'request_an_agent',true);
		  $email_teanant             =   $_POST['email_teanant'];
		  $name_teanant              =   $_POST['name_teanant'];
		  $phone_teanant             =   $_POST['phone_teanant'];
	      $payment_id                =   $response->payment->id;
		  $payment_created_at        =   $response->payment->created_at;
		  $paymentamount             =   intdiv($response->payment->amount_money->amount , 100);
		  $paymentcurrency           =   $response->payment->amount_money->currency;
		  $paymentstatus             =   $response->payment->status;
		  $payment_source_type       =   $response->payment->source_type;
		  $order_id                  =   $response->payment->order_id;
		  $receipt_number            =   $response->payment->receipt_number;
		  $receipt_url               =   $response->payment->receipt_url;
		  
		  $dealorderid = wp_insert_post(array (
								'post_type'		=> 'dealsorders',
								'post_title' 	=> '#'.$invoice_id,
								'post_content' 	=> 'New Order Created',
								'post_author' 	=> 1,
								'post_status' 	=> 'publish',
		                  ));
		  
		  if($dealorderid){
		     
		     if($get_requested_agent && $get_requested_agent == 1 && $get_selected_agent ){
			    $agent_name = get_user_meta($get_selected_agent, 'user_full_name', true);
			    $agent_email = get_user_meta($get_selected_agent, 'user_agent_email', true);
			    $agent_phone = get_user_meta($get_selected_agent, 'user_phone', true);
				update_post_meta($dealorderid, 'agent_involved', $get_selected_agent);
			    update_post_meta($dealorderid, 'agent_name', $agent_name);
				update_post_meta($dealorderid, 'agent_email', $agent_email);
				update_post_meta($dealorderid, 'agent_phone', $agent_phone); 
			 }
			 update_post_meta($dealorderid, 'invoice_id', $invoice_id);
		     update_post_meta($dealorderid, 'deal_id', $deal_id);
			 update_post_meta($dealorderid, 'email_teanant', $email_teanant);
			 update_post_meta($dealorderid, 'name_teanant', $name_teanant);
			 update_post_meta($dealorderid, 'phone_teanant', $phone_teanant);
			 update_post_meta($dealorderid, 'payment_id', $payment_id);
			 update_post_meta($dealorderid, 'payment_created_at', $payment_created_at);
			 update_post_meta($dealorderid, 'payment_amount', $paymentamount);
			 update_post_meta($dealorderid, 'payment_currency', $paymentcurrency);
			 update_post_meta($dealorderid, 'payment_status', $paymentstatus);
			 update_post_meta($dealorderid, 'payment_source_type', $payment_source_type);
			 update_post_meta($dealorderid, 'order_id', $order_id);
			 update_post_meta($dealorderid, 'receipt_number', $receipt_number);
			 update_post_meta($dealorderid, 'receipt_url', $receipt_url);
			 update_post_meta($dealorderid, 'payment_mode', 'square_payment');
			 /*----------------Start creating invoice ---------------------------- */
														  $html = '<html>
										<head>
											<meta http-equiv="Content-Type" content="charset=utf-8" />
											<style type="text/css">
												@page {
													margin: 0;
												}
												* { padding: 0; margin: 0; }
												@font-face {
													font-family: "varelaround";           
													src: local("VarelaRound-Regular"), url("fonts/VarelaRound-Regular.ttf") format("truetype");
													font-weight: normal;
													font-style: normal;
												}
												body{
													font-family: "varelaround";
													color: #333;
													background-color: #fff;
													height:100%;
												}
												body b, table th{
													font-weight: normal;
													font-family: "varelaround";
												}
												table td, table th{
													vertical-align: top;
												}
												span{
													font-family: "varelaround";
													color: #333;
													font-size:14px;
												}
												h2,p{
												  font-family: "varelaround";
												  color: #333;  
												}
											</style>
										</head>
										<body>
										<table style="width:100%;padding:20px;">
										   <tr>
											  <td colspan="2">
												 <table style="width:100%;">
													<tbody>
													   <tr>
														  <td colspan="2" style="padding-bottom:10px;">
															 <table style="width:100%;">
																<tbody>
																   <tr>
																	  <td style="width:50%;">
																		 <img src="https://nycrooms.midriffdevelopers.live/wp-content/uploads/2020/06/logo.png" style="width:150px;">
																	  </td>
																	  <td style="width:50%;padding: 0 0px 0 10%;text-align: right;">
																		 <h2 style="text-align: right;margin-top: 0;margin-bottom: 0;">NYC Room 4 Rent</h2>
																		 <p>606 WEST 145TH STREET NY NY 10031<br>212-368-2685<br>WWW.NYCROOMS4RENT.COM
																		 </p>
																	  </td>
																   </tr>
																   </tbody>
															 </table>
														  </td>
													   </tr>
													   <tr>
														  <td colspan="2" style="border-top:1px solid #000;padding-top:10px;">
																<table style="width:100%;border-collapse: collapse;">
																   <tbody>
																	  <tr>
																		 <td>
																			<h2 style="margin: 0;font-weight:normal;font-size: 1.4em;">INVOICE TO:</h2>
																			<p style="font-size: 1em;font-weight: normal;margin: 0;">'.$name_teanant.'</p>
																			<p style="font-size: 1em;font-weight: normal;margin: 0;">Phone No: '.$phone_teanant.'</p>
																			<p font-size: 1em;font-weight: normal;margin: 0;">'.$email_teanant.'</p>
																		 </td>
																		 <td style="text-align: right;">
																		 <h2 style="margin: 0;font-weight:normal;font-size: 1.4em;">INVOICE DETAIlS:</h2>
																		 <p style="font-size: 1em;font-weight: normal;margin: 0;">Invoice No. '.$invoice_id.'</p>
																		 <p style="font-size: 1em;font-weight: normal;margin: 0;">Date: '.date("F j, Y").'</p>
																		 </td>
																	  </tr>
																  </tbody>
																</table>
														  </td>
													   </tr>
													   <tr>
														  <td colspan="2" style="padding-top:50px;padding-right:5px;">
															 <table style="width:100%;border-collapse:collapse;">
																<tbody>
																   <tr>
																	  <td colspan="2">
																		 <table style="width:100%;border-collapse:collapse;">
																			<tr style="background-color:#a3b687;">
																			   <td style="90%;padding:0 2px;">
																			   <p style="text-align:left;color:#fff;margin:0px 0px 4px 0px;">Description</p>
																			   </td>
																			   <td style="10%;padding:0 2px;">
																			   <p style="text-align:right;color:#fff;margin:0px 0px 4px 0px;">Amount</p>
																			   </td>
																			</tr>
																		 </table>
																	  </td>
																   </tr>
																   <tr>
																	   <td style="width:90%;padding:0 2px;">
																		 <table style="width:100%;">
																			<tr>
																			   <td><p style="font-size: 14px;font-weight: normal;margin: 0;">Deal #'.$deal_id.':</p></td>
																			</tr>
																		 </table>
																	   </td>
																	   <td  style="width:10%;padding:0 2px;">
																		 <table style="width:100%;">
																			<tr>
																			   <td><p style="font-size: 14px;text-align:right;font-weight: normal;margin: 0;">$'.$paymentamount.'</p></td>
																			</tr>
																		 </table>
																	   </td>
																   </tr>
																   <tr>
																   <td style="width:90%;padding:0 2px;">
																		 <table style="width:100%;">
																			<tr>
																			   <td><p style="font-size: 14px;font-weight: normal;margin: 0;">Transaction ID : '.$payment_id .'</p></td>
																			</tr>
																			
																		 </table>
																	   </td>
																	   <td  style="width:10%;padding:0 2px;">
																		 <table style="width:100%;">
																			<tr>
																			    <td><p style="font-size: 14px;text-align:right;font-weight: normal;margin: 0;"></p></td>
																			   
																			</tr>
																			
																		 </table>
																	   </td>
																	</tr>
																	<tr>
																		   <td style="width:90%;padding:0 2px;">
																			 <table style="width:100%;">
																				<tr>
																				   <td><p style="font-size: 14px;font-weight: normal;margin: 0;">Payment Mode : Online</p></td>
																				</tr>
																				
																			 </table>
																		   </td>
																		   <td  style="width:10%;padding:0 2px;">
																			 <table style="width:100%;">
																				<tr>
																					<td><p style="font-size: 14px;text-align:right;font-weight: normal;margin: 0;"></p></td>
																				   
																				</tr>
																				
																			 </table>
																		   </td>
																	</tr>
																    <tr>
																	   <td colspan="2" style="padding-right:5px;padding-top:5px">
																	   <table style="width:100%;border-top:1px solid #000">
																	   <tr>
																	   <td style="width:70%;"></td>
																	   <td style="width:20%;;">
																	     <p style="font-size: 14px;font-weight: normal;margin: 0;"><b>Total:</b></p>
																	   </td>
																	   <td style="width:10%;">
																	   <p style="font-size: 14px;font-weight: normal;margin: 0;text-align:right">$'.$paymentamount.'</p>
																	   </tr>
																	   </table>
																	   </td>
																   </tr>
																</tbody>
															 </table>
														  </td>
													   </tr>
													   <tr>
													   <td colspan="2" style="">
													   <table style="width:100%;margin-top:50px;">
													   <tr><td>
										<p style="font-size: 16px;font-weight: 500;margin: 20px 0 15px 0 ;"><span style="font-weight:bold">Payments Terms:</span></p>
										<ul style="padding-left:10px;"><li style="font-size: 14px;font-weight: normal;margin: 0;">You are paying a service fee to NYC Rooms For Rent Inc. to provide listings of available rooms. </li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">NYC Rooms for Rent will arrange, conduct, coordinate, handles or cause meetings between you and the current occupant of a legally occupied property, including apartment housing, who wishes to share that housing with you or more individuals as a private dwelling.</li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">NYC Rooms For Rent Inc. will do the aforementioned for an unlimited amount of time until you are placed in a room of your likings.</li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">NYC Rooms for Rent Inc. is not responsible if landlord rejects you for not meeting the landlord qualifications, however NYC Rooms for Rent Inc. will continue to provide you listings. </li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">After you move into one of our listings NYC Rooms For Rent Inc. is not responsible for furnishing further listings.</li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">The service fee paid to NYC Rooms For Rent is non-refundable.</li></ul>
													   </td></tr>
													   </table>
													   </td>
													   </tr>
													</tbody>
												 </table>
											  </td>
										   </tr>
										</table>
										</div>
										</body>
										</html>';
										
										// instantiate and use the dompdf class
										$dompdf = new Dompdf();
										$dompdf->loadHtml($html, 'UTF-8');
                                        $dompdf->set_option('isRemoteEnabled', TRUE);
										// (Optional) Setup the paper size and orientation
										$dompdf->setPaper('A4');

										$dompdf->set_option('defaultMediaType', 'all');
										$dompdf->set_option('isFontSubsettingEnabled', true);

										// Render the HTML as PDF
										$dompdf->render();
										$uploaddir = wp_upload_dir();
										$uploadfile = $uploaddir['path'].'/invoice_'.$invoice_id.'_'.$deal_id.'.pdf';
										//save the pdf file on the server
										file_put_contents($uploadfile, $dompdf->output()); 
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
										update_post_meta($deal_id,'payment_invoice_doc', $attach_id);
                                        update_post_meta($dealorderid, 'payment_invoice', $attach_id);
										
										
			 /*----------------End creating invoice ---------------------------- */
			    
		    /*----------- start sending mail to admin -----------------------*/
			$attachment_id = get_post_meta($deal_id,'payment_invoice_doc',true);
			$invoice_attchment = '<a href="'. wp_get_attachment_url($attachment_id) . '" download >'.wp_get_attachment_url($attachment_id).'</a>';
			$subject = "New payment created on deal no -".$deal_id;
			$to = get_option('admin_email');
			$msg  = __( 'Hello Admin,') . "\r\n\r\n";
			$msg .= sprintf( __("<p>New Payment has been done on Deal no. : %s with Following Invoice No. : %s via Square Payment Gateway <p><p>Following are Details of Payment.</p>"),$deal_id,$invoice_id);
			$msg .= sprintf( __("<p>Invoice No. : %s</p>"),$invoice_id);
			$msg .= sprintf( __("<p>Deal No. : %s</p>"),$deal_id);
			$msg .= sprintf( __("<p> Invoice Attachment Url : %s</p>"),$invoice_attchment);
			$msg .= sprintf( __("<p>Admin Deal link : <a href='%s/admin/deals/details/%s'>%s/admin/deals/details/%s</a></p>",get_site_url(),$deal_id,get_site_url(),$deal_id));
			$msg .= sprintf( __("<p>Payment By Tenant: %s</p>"),$name_teanant);
			$msg .= sprintf( __("<p>Tenant Email : %s</p>"),$email_teanant);
			$msg .= sprintf( __("<p>Tenant Phone : %s</p>"),$phone_teanant);
			$msg .= sprintf( __("<p>Payment ID : %s</p>"),$payment_id);
			if($get_requested_agent && $get_requested_agent == 1 && $get_selected_agent ){
			
			   $msg .= sprintf( __("<p>Agent Involved : %s</p>"),$agent_name);
			   $msg .= sprintf( __("<p>Agent Email : %s</p>"),$agent_email);
			   $msg .= sprintf( __("<p>Agent Phone : %s</p>"),$agent_phone);
			   
			}
			$msg .= sprintf( __("<p>Order Id  : %s</p>"),$order_id);
			$msg .= sprintf( __("<p>Payment Date : %s</p>"),date("F j, Y",strtotime($payment_created_at)));
			$msg .= sprintf( __("<p>Payment Amount : %s</p>"),$paymentamount);
			$msg .= sprintf( __("<p>Payment Currency : %s</p>"),$paymentcurrency);
			$msg .= sprintf( __("<p>Payment Status : %s</p>"),$paymentstatus);
			$msg .= sprintf( __("<p>Payment Source Type : %s</p>"),$payment_source_type);
			$msg .= sprintf( __("<p>Payment Mode : %s</p>"),'Square Payment');
		    $msg .= sprintf( __("<p>Collection Method : %s</p>"),'Online');
			$msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
			$headers = array('Content-Type: text/html; charset=UTF-8');
		    $sent = wp_mail($to, $subject, $msg,$headers);
			
			/* ----------- End Sending mail to admin  ---------------- */
			
			/* ----------- Start Sending mail to Tenant  ---------------- */
			
			$subject1 = "Payment Done On Deal No. -".$deal_id;
			$to1 = $email_teanant;
			$msg1  = sprintf( __('Hello %s',$name_teanant));
			$msg1 .= sprintf( __("<p>Your Payment has been done on Deal no. : %s with Following Invoice No. : %s via Square Payment Gateway.<p><p>Following are Details of Payment.</p>"),$deal_id,$invoice_id);
			$msg1 .= sprintf( __("<p>Invoice No. : %s</p>"),$invoice_id);
			$msg1 .= sprintf( __("<p>Invoice No. : %s</p>"),$invoice_id);
			$msg1 .= sprintf( __("<p>Deal No. : %s</p>"),$deal_id);
			$msg1 .= sprintf( __("<p> Invoice Attachment Url : %s</p>"),$invoice_attchment);
			$msg1 .= sprintf( __("<p>Payment ID : %s</p>"),$payment_id);
			$msg1 .= sprintf( __("<p>Order Id  : %s</p>"),$order_id);
			$msg1 .= sprintf( __("<p>Payment Date : %s</p>"),date("F j, Y",strtotime($payment_created_at)));
			$msg1 .= sprintf( __("<p>Payment Amount : %s</p>"),$paymentamount);
			$msg1 .= sprintf( __("<p>Payment Currency : %s</p>"),$paymentcurrency);
			$msg1 .= sprintf( __("<p>Payment Status : %s</p>"),$paymentstatus);
			$msg1 .= sprintf( __("<p>Payment Source Type : %s</p>"),$payment_source_type);
			$msg1 .= sprintf( __("<p>Payment Mode : %s</p>"),'Square Payment');
		    $msg1 .= sprintf( __("<p>Collection Method : %s</p>"),'Online');
			$msg1 .= sprintf( __("<p>Download  Payment invoice By clicking on button Below:</p><p>%s</p>"),$invoice_attchment);
			$msg1 .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
			$headers1 = array('Content-Type: text/html; charset=UTF-8');
		    $sent1 = wp_mail($to1, $subject1, $msg1,$headers1);
			$notification = "A Payment has been Done by Tenant on Deal no ".$deal_id;
			nyc_add_noticication($notification);			
			/* ----------- End Sending mail to Tenant  ---------------- */
			
			 echo "success";
		  }
		  
	  } else {
	     echo "faliure";
	  }
	  
   } else {
      echo "faliure";
   }
  exit; 
}


add_action( 'init', 'nyc_create_custom_post_deals_orders', 0 );

function nyc_create_custom_post_deals_orders() {
	$labels = array(
		'name'                => __( 'Deals Orders' ),
		'singular_name'       => __( 'Deals Orders'),
		'menu_name'           => __( 'Deals Orders'),
		'parent_item_colon'   => __( 'Parent Deals Orders'),
		'all_items'           => __( 'All Orders'),
		'view_item'           => __( 'View Orders'),
		'search_items'        => __( 'Search Orders'),
		'not_found'           => __( 'Not Found'),
		'not_found_in_trash'  => __( 'Not found in Trash')
	);
	$args = array(
		'label'               => __( 'dealsorders'),
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
	register_post_type( 'dealsorders', $args );
}


function nyc_get_tenant_payment_square_ajax_curl($payment_url,$headers,$method,$reqbody){   

   $curl = curl_init();

  curl_setopt_array($curl, array(
						  CURLOPT_URL => $payment_url,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 0,
						  CURLOPT_FOLLOWLOCATION => true,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => $method,
						  CURLOPT_POSTFIELDS =>$reqbody,
						  CURLOPT_HTTPHEADER => $headers,
                       )
  );

 $response = curl_exec($curl);

 curl_close($curl);
 return json_decode($response);

}

function nyc_application_form_pdf_ajax(){
    if(isset($_POST['action']) && $_POST['action'] == 'nyc_application_form_pdf_ajax'){
	   $tenant_application_data = array();
	   $deal_id = $_POST['deal_id'];
	   foreach($_POST as $key => $tenant_data){
	       if($key != 'action'){
		     $tenant_application_data[$key] = $tenant_data;
		   }
	   }
         update_post_meta($deal_id,'tenant_application_data',$tenant_application_data);
	     $get_application_tenant = get_post_meta($deal_id,'tenant_application_data',true);
		 $imageurl = get_stylesheet_directory_uri() . '/images/cropped-logo.jpg';
		 $checkedgoogle = '';
		 $checkedElDiario = '';
		 $checkedFacebook = '';
		 $checkedAmsterdamNewspaper = '';
		 $checkedCraigslist = '';
		 $checkedMetroNewspaper = '';
		 $checkedReferral = '';
		 $checkedOther = '';
		 
		 if($get_application_tenant['adversitement_check'] == 'Google'){
		    $checkedgoogle = 'checked';
		 } else if($get_application_tenant['adversitement_check'] == 'El Diario'){
		    $checkedElDiario = 'checked';
		 } else if($get_application_tenant['adversitement_check'] == 'Facebook'){
		     $checkedFacebook = 'checked';
		 } else if($get_application_tenant['adversitement_check'] == 'Amsterdam Newspaper'){
		     $checkedAmsterdamNewspaper = 'checked';
		 } else if($get_application_tenant['adversitement_check'] == 'Craigslist'){
		     $checkedCraigslist = 'checked';
		 } else if($get_application_tenant['adversitement_check'] == 'Metro Newspaper'){
		     $checkedMetroNewspaper = 'checked';
		 } else if($get_application_tenant['adversitement_check'] == 'Referral'){
		     $checkedReferral = 'checked';
		 } else if($get_application_tenant['adversitement_check'] == 'Other'){
		     $checkedOther = 'checked';
		 }
		 
		 
		 
		  $html = '<html>
<head>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <style type="text/css">
        @page {
            margin: 0;
        }
        * { padding: 0; margin: 0; }
        @font-face {
            font-family: "varelaround";           
            src: local("VarelaRound-Regular"), url("fonts/VarelaRound-Regular.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;
        }
        body{
            font-family: "varelaround";
            color: #333;
            background-color: #fff;
            height:100%;
        }
        body b, table th{
            font-weight: normal;
            font-family: "varelaround";
        }
        table td, table th{
            vertical-align: top;
        }
        span{
            font-family: "varelaround";
            color: #333;
            font-size:14px;
        }
        h2,p{
          font-family: "varelaround";
          color: #333;  
        }
    </style>
</head>
<body>
<table style="width:100%;padding:20px;">
   <tr>
      <td colspan="2">
         <table style="width:100%;">
            <tbody>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="width:50%;">
                                 <img src="https://nycrooms.midriffdevelopers.live/wp-content/uploads/2020/06/logo.png" style="width:150px;">
                              </td>
                              <td style="width:50%;padding: 0 0px 0 10%;text-align: right;">
                                 <h2 style="text-align: right;margin-top: 0;margin-bottom: 0;">NYC Room 4 Rent</h2>
                                 <p>606 WEST 145TH STREET NY NY 10031<br>212-368-2685<br>WWW.NYCROOMS4RENT.COM</p>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
         <table style="width:100%;margin-top: 20px;margin-bottom:20px;">
            <tr>
               <td style="text-align: center;">
                  <p style="font-weight: 500;font-size:22px;margin: 0 0 5px;">Application Form</p>
               </td>
            </tr>
         </table>
         <table style="width:100%;">
            <tbody>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style=" bottom;width:10%">
                                 <span>Name(s)</span>
                              </td>
                              <td style="width:90%">
                                 <p style="font-size:14px;margin:0;border-bottom: 1px solid #333;">'.$get_application_tenant['name'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="width:20%;">
                                 <span>Contact Phone Number</span>
                              </td>
                              <td style="width:70%">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['contact_no'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="width:25%;vertical-align:bottom;">
                                 <span>Secondary Phone Number</span>
                              </td>
                              <td style="width:75%;">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['secondary_contact_no'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="width:19%;">
                                 <span>Emergency Contact</span>
                              </td>
                              <td style="width:81%;">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['emergency_contact_no'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="width:14%;vertical-align:bottom;">
                                 <span>Email Address</span>
                              </td>
                              <td style="width:86%;">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['email_address'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="width:17%;">
                                 <span>Employer/School</span>
                              </td>
                              <td style="width:83%;">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['employer_school'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="width:9%;">
                                 <span>Address</span>
                              </td>
                              <td style="width:91%;">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['address'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="
                                 width: 17%;
                                 ">
                                 <span>Manager’s Name</span>
                              </td>
                              <td style="
                                 width: 83%;
                                 ">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['manager_name'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="
                                 width: 18%;
                                 ">
                                 <span>Manager’s Contact</span>
                              </td>
                              <td style="
                                 width: 78%;
                                 ">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['manager_contact'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="
                                 width: 16%;
                                 ">
                                 <span>Monthly Income</span>
                              </td>
                              <td style="width:84%;"
                                 ">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['month_income'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="
                                 width: 20%;
                                 ">
                                 <span>Weekly Rent Budget </span>
                              </td>
                              <td style="
                                 width: 80%;
                                 ">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['week_rent_budget'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="
                                 width: 40%;
                                 ">
                                 <span>How many people will be living in the room?  </span>
                              </td>
                              <td style="
                                 width: 60%;
                                 ">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['people_living_count'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="
                                 width: 45%;
                                 ">
                                 <span>How long are you looking to stay in the room?  </span>
                              </td>
                              <td style="
                                 width: 55%;
                                 ">
                                 <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;">'.$get_application_tenant['Periods_of_living'].'</p>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td>
                                 <span>Where did you see our advertisement?
                                 </span>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td colspan="2">
                                 <table style="width:100%;">
                                    <tbody>
                                       <tr>
                                          <td style="width:33%;">
                                             <p style="display:inline-block;font-size:14px;margin:0;">
                                                <input style="margin-top:6px;" type="checkbox" id="advertisement" '.$checkedgoogle.'>Google
                                             </p>
                                          </td>
                                          <td style="width:33%;">
                                             <p style="display:inline-block;font-size:14px;margin:0;">
                                                <input style="margin-top:6px;" type="checkbox" id="advertisement" '.$checkedElDiario.'>El Diario 
                                             </p>
                                          </td>
										  <td style="width:33%;">
                                             <p style="display:inline-block;font-size:14px;margin:0;">
                                                <input style="margin-top:6px;" type="checkbox" id="advertisement" '.$checkedFacebook.'>Facebook
                                             </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="width:33%;">
                                             <p style="display:inline-block;font-size:14px;margin:0;">
                                                <input style="margin-top:6px;" type="checkbox" id="advertisement" '.$checkedAmsterdamNewspaper.'>Amsterdam Newspaper 
                                             </p>
                                          </td>
										  <td style="width:33%;">
                                             <p style="display:inline-block;font-size:14px;margin:0;">
                                                <input style="margin-top:6px;" type="checkbox" id="advertisement" '.$checkedCraigslist.'>
                                                Craigslist 
                                             </p>
                                          </td>
										   <td style="width:33%;">
                                             <p style="display:inline-block;font-size:14px;margin:0;">
                                                <input style="margin-top:6px;" type="checkbox" id="advertisement" '.$checkedMetroNewspaper.'>Metro Newspaper 
                                             </p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td style="width:33%;">
                                             <p style="display:inline-block;font-size:14px;margin:0;">
                                                <input style="margin-top:6px;" type="checkbox" id="advertisement" '.$checkedReferral.'>Referral
                                             </p>
                                          </td>
										  <td style="width:33%;">
                                             <p style="display:inline-block;font-size:14px;margin:0;">
                                                <input style="margin-top:6px;" type="checkbox" id="advertisement" '.$checkedOther.'>Other
                                             </p>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="
                                 padding-bottom:5px;">
                                 <span><b>Policy</b>
                                 </span>
                              </td>
                           </tr>
                           <tr>
                              <td style="vertical-align:top;"><input style="margin-top:6px;" type="checkbox" checked>
                                 <span style="font-size:12px;margin-left:-10px;margin:0;line-height:14px;">
                                 <b>NYC ROOMS 4 RENT INC.</b> is a licensed apartment sharing agency whom for a non-refundable service fee refers you to a primary tenant or landlord for viewings of available rooms. Please be on time and wear proper attire when meeting with the primary tenant or landlord. We are not responsible for any negotiations agreed between you and the landlord or primary tenant. We will assist you until you find the first room that accommodates your needs. If you wish to transfer room we will assist you <b>ONE</b> time at no extra cost within the 30 days guaranteed service policy, except you’ve been evicted for illicit behavior or have a pending balance with the landlord. Our services expire 30 days after you have found a room.<b>Our service fee is non-refundable under no circumstances.</b>
                                 </span>
                              </td>
                              <td>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2" style="padding-top:25px;">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td style="width:50%;padding-right:50px;">
                                 <table style=" width: 100%;">
                                    <tr>
                                       <td colspan="2">
                                          <table style="width:100%;">
                                             <tr>
                                                <td style="width:16%;">
                                                   <span>Name:</span>
                                                </td>
                                                <td style="width:84%;">
                                                   <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;margin:0;">'.$get_application_tenant['name'].'</p>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="2">
                                          <table style="width:100%;">
                                             <tr>
                                                <td style="width:22%;"><span>Signature:</span></td>
                                                <td style="width:78%;">
                                                   <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;margin:0;">'.$get_application_tenant['name'].'</p>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                              <td style="width:50%;padding-left:50px;">
                                 <table style=" width: 100%;">
                                    <tr>
                                       <td colspan="2">
                                          <table style="width:100%;">
                                             <tr>
                                                <td style="width:11%;"><span>Date:</span></td>
                                                <td style="width:89%;">
                                                   <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;margin:0;">'.date("d-m-Y H:i:s").'</p>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td colspan="2">
                                          <table style="width:100%;">
                                             <tr>
                                                <td style="width:17%;"><span>Location:</span></td>
                                                <td style="width:83%;">
                                                   <p style="font-size:14px;margin: 0;border-bottom: 1px solid #000;margin:0;">---------</p>
                                                </td>
                                             </tr>
                                          </table>
                                       </td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
   </tr>
   </td>
</table>

</body>
</html>';
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->set_option('isRemoteEnabled', TRUE);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4');
$dompdf->set_option('defaultMediaType', 'all');
$dompdf->set_option('isFontSubsettingEnabled', true);
// Render the HTML as PDF

$dompdf->render();
$uploaddir = wp_upload_dir();
$uploadfile = $uploaddir['path'].'/file_'.$deal_id.'.pdf';
//save the pdf file on the server
file_put_contents($uploadfile, $dompdf->output()); 
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
update_post_meta($deal_id,'application_doc', $attach_id);
update_post_meta($deal_id,'application_submission', 1);
$notification = "Application Form Submitted by Tenant on Deal no ".$deal_id;
nyc_add_noticication($notification);
echo "success";

}
 exit;
}

add_action( 'wp_ajax_nyc_application_form_pdf_ajax', 'nyc_application_form_pdf_ajax' );
add_action( 'wp_ajax_nopriv_nyc_application_form_pdf_ajax', 'nyc_application_form_pdf_ajax' );


function nyc_export_payments_as_CSV() {
	 ob_start();
	 $csv = '';
	 $headers = array(
		'S NO',
		'Invoice No.',
		'Order No .',
		'Payment No.',
		'Deal No.',
		'Payment Amount',
		'Payment By',
		'Payment Status',
		'Payment Source',
		'Payment Date',
		'Agent Involved',
		'Collection Method'
	); 
	$args = array(
                    'post_type'=> 'dealsorders',
                    'post_status' => 'publish',
                    'numberposts'   => -1
            );
	 $dealsorders = new WP_Query( $args );
	 $deal_order_posts = $dealsorders->posts;
	 $handle = fopen('php://output', 'w'); 
	 fputcsv($handle, $headers, ',', '"');

	foreach($deal_order_posts as $key=>$results1)
	{
	     
		 $post_order_id = $results1->ID;
		 
		 $invoice_id          =  get_post_meta($post_order_id,'invoice_id',true);
		 $checkorderno        =  get_post_meta($post_order_id,'order_id',true);
		 $checkpaymentno      =  get_post_meta($post_order_id,'payment_id',true);
		 $deal_id             =  get_post_meta($post_order_id,'deal_id',true);
		 $payment_amount      =  get_post_meta($post_order_id,'payment_amount',true);
		 $payment_by          =  get_post_meta($post_order_id,'email_teanant',true);
		 $payment_status      =  get_post_meta($post_order_id,'payment_status',true);
		 $payment_source_type =  get_post_meta($post_order_id,'payment_source_type',true);
		 $payment_created_at  =  date("F j, Y h:i A",strtotime(get_post_meta($post_order_id,'payment_created_at',true)));
		 $checkagent          =  get_post_meta($post_order_id,'agent_involved',true); 
		 $payment_mode        =  get_post_meta($post_order_id,'payment_mode',true); 
		 if($payment_mode == 'square_payment'){
			$collection_method = "Online";
		} else {
			$collection_method =  "Offline";
		}
		if($checkorderno){
		    $checkorderno = $checkorderno;
		} else {
		    $checkorderno = 'N.A';
		}
		
		if($checkpaymentno){
		    $checkpaymentno = $checkpaymentno;
		} else {
		    $checkpaymentno = 'N.A';
		}
		
		if($checkagent){
		    $checkagent = $checkagent;
		} else {
		    $checkagent = 'N.A';
		}
		
		 $row = array(
			$key+1,
			$invoice_id,
			$checkorderno,
			$checkpaymentno ,
			$deal_id,
			$payment_amount,
			$payment_by,
			$payment_status,
			$payment_source_type,
			$payment_created_at,
			$checkagent,
			$collection_method
		);

		fputcsv($handle, $row, ',', '"');
		
	}


	$now = gmdate('D, d M Y H:i:s') . ' GMT';

	header('Content-Type: text/csv');
	header('Expires: ' . $now);

	header('Content-Disposition: attachment; filename="payments.csv"');
	header('Pragma: no-cache'); 

	echo $csv; 
	exit();
}

function nyc_get_count_order_post_type(){
     
	 $args = array(
                    'post_type'=> 'dealsorders',
                    'post_status' => 'publish',
                    'numberposts'   => -1
            );
	 $dealsorders = new WP_Query( $args );
	 $deal_order_posts = $dealsorders->posts;
	  $payment_amount = 0;
	 foreach($deal_order_posts as $deal_orders) {
	     
		 $post_order_id   = $deal_orders->ID;
		 $payment_amount  +=  (int) get_post_meta($post_order_id,'payment_amount',true);
		 
	 }
	    echo '$'.$payment_amount;
	 
   
}

require_once( 'inc/init-function.php');
?>