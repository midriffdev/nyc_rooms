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
	//wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri().'/css/bootstrap.min.css');
	wp_enqueue_script( 'property-js', get_stylesheet_directory_uri().'/scripts/property.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'dashboard-js', get_stylesheet_directory_uri().'/inc/js/admin-dashboard.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri().'/scripts/bootstrap.min.js', array( 'jquery' ), '1.0', true );
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
			add_post_meta($property_id, 'document_files', $_POST['document_files']);
			add_post_meta($property_id, 'people_living_count', $_POST['people_living_count']);
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


function nyc_update_property_ajax(){
	if(isset($_POST['action']) && $_POST['action'] == 'nyc_update_property_ajax'){
	            $gallery_files_post = array();
				$doc_files_post = array();
			    if(isset($_FILES) && !empty($_FILES)){
			      $meta_gallery = get_post_meta($_POST['property_id'], 'gallery_files', true);
				  $doc_gallery = get_post_meta($_POST['property_id'], 'document_files', true);
				  $gallery_files = explode(',',$meta_gallery);
				  $document_files = explode(',',$doc_gallery);
				  if($meta_gallery  || $doc_gallery){
				  $countgallery_meta = count($gallery_files);
				  $countdoc_meta = count($document_files);
				  
			      $i = 1; 
				  $k = 1;
			      $FILESIMG = array();
				  $FILESDOC = array();
				  $gallery_files_post  =  $gallery_files;
				  $doc_files_post      =  $document_files;
				  if($meta_gallery){
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
				  if($doc_gallery){
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
				
				if(empty($doc_files_post)){
				       if(!empty($_POST['document_files'])){
				         $doc_files_post = explode(',',$_POST['document_files']);
					   } else {
					        $doc_gallery = get_post_meta($_POST['property_id'], 'document_files', true);
							$document_files = explode(',',$doc_gallery);
							$doc_files_post = $document_files;
					   }
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
            update_post_meta($_POST['property_id'],'gallery_files', implode(',',$gallery_files));
			$check = get_post_meta($_POST['property_id'],'gallery_files', implode(',',$gallery_files));
			 if($check == 'file_0'){
			     delete_post_meta($_POST['property_id'],'gallery_files', 'file_0');
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
	  update_post_meta($_POST['property_id'],'document_files', implode(',',$gallery_files));
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
 	 $message .= __('You can now login with your new password at: ').'<a href="'.get_option('siteurl')."/signup/" .'" >' . get_option('siteurl')."/login-register/" . "</a> <br><br>";
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
		 'post_status'       => 'available',
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
		 'post_status'       => 'available',
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
require_once( 'inc/init-function.php');
?>