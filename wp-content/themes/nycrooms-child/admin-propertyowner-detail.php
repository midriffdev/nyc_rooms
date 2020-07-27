<?php 
/*
Template Name: Owner Detail
*/
$getuser = get_user_by('id',$_GET['uid']);
$usererror = '';
$usersuccess = '';
if(isset($_POST['update_owner'])){
        $phoneno = $_POST['phone'];
		   if( $_POST['email'] != $getuser->user_email  ) {
	     
	    if(email_exists( $_POST['email'] )){
            $usererror ="Sorry!! Email Already Exists";
		} else {
	  
	  
	               $user_data = wp_update_user( 
		                                 array(
											   'ID' => $getuser->ID, 
											   'user_email' => $_POST['email'],
											   'display_name' => $_POST['Your_name']
				                         ) 
				   
				   );
				   
				    if ( is_wp_error( $user_data ) ) {
    
                   $usererror =  'Error in update user';
                   } else {
		   
	   
						   if( isset($_FILES['profilepicture']['name']) && !empty($_FILES['profilepicture']['name'])){
								 
								 nyc_property_profile_all_image_upload($_FILES,$getuser->ID);
								 
						   }
								 update_user_meta($getuser->ID,'user_name', $_POST['Your_name']); 
								 update_user_meta($getuser->ID,'user_phone', $phoneno);
								 update_user_meta($getuser->ID,'user_email', $_POST['email']);
								 update_user_meta($getuser->ID,'about', $_POST['about']);
								 update_user_meta($getuser->ID,'user_twitter', $_POST['twitter']);
								 update_user_meta($getuser->ID,'user_facebook', $_POST['facebook']);
								 update_user_meta($getuser->ID,'user_google', $_POST['googleplus']);
								 update_user_meta($getuser->ID,'user_linkedin', $_POST['linkedin']); 
								 $usersuccess = "Owner updated Successfully";

                   }						
        }
		
      } else {
	  
	  
	        $user_data = wp_update_user( 
		                                 array(
											   'ID' => $getuser->ID, 
											   'user_email' => $_POST['email'],
											   'display_name' => $_POST['Your_name']
				                         ) 
				   
				   );
				   
				    if ( is_wp_error( $user_data ) ) {
    
                   $usererror =  'Error in update user';
                   } else {
		   
	   
						   if( isset($_FILES['profilepicture']['name']) && !empty($_FILES['profilepicture']['name'])){
								 
								 nyc_property_profile_all_image_upload($_FILES,$getuser->ID);
								 
						   }
								 update_user_meta($getuser->ID,'user_name', $_POST['Your_name']); 
								 update_user_meta($getuser->ID,'user_phone', $phoneno);
								 update_user_meta($getuser->ID,'user_email', $_POST['email']);
								 update_user_meta($getuser->ID,'about', $_POST['about']);
								 update_user_meta($getuser->ID,'user_twitter', $_POST['twitter']);
								 update_user_meta($getuser->ID,'user_facebook', $_POST['facebook']);
								 update_user_meta($getuser->ID,'user_google', $_POST['googleplus']);
								 update_user_meta($getuser->ID,'user_linkedin', $_POST['linkedin']); 
								 $usersuccess = "Owner updated Successfully";

                   }						
    }
	
 }
get_header();
?>


<!-- Wrapper -->
<div id="wrapper">

<!-- Content
================================================== -->
<div class="admin-teanent-detailpage">
	<div class="container">
<div class="admin-teanent-account-details">
				<div class="row">
				
				   <?php if(isset($_GET['prpage']) && $_GET['prpage'] == 'admin-property-owner-all'): ?>
				     <p style="color:#274abb"><a href="<?= site_url().'/admin-property-owner-all/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></p>
				   <?php endif; ?>
				   
				    <?php if(isset($_GET['prpage']) && $_GET['prpage'] == 'recent-property-owner'): ?>
				      <p style="color:#274abb"><a href="<?= site_url().'/recent-property-owner/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></p>
				   <?php endif; ?>
				   
				   
					<div class="col-md-12">
						<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Account Details</h4>
					</div>
				</div>
				<div class="row">
				        
						
				    <form method="post" enctype="multipart/form-data">
						<div class="col-md-6 my-profile">
							
							<div class="row">
								<div class="col-md-6">
									<label>Your Name</label>
									<?php 
									 $get_username_meta = get_user_meta($getuser->ID,'user_name',true);
									?>
									<input type="text" name="Your_name" placeholder="Enter Your Name" value="<?php if($get_username_meta){ echo get_user_meta($getuser->ID,'user_name',true); } else { echo $getuser->data->display_name ;} ?>">
								</div>
								<div class="col-md-6">
									<label>Phone</label>
									<input  type="text" name="phone" placeholder="Enter Phone With +1.." required pattern="[+1]{2}[0-9]{10}"  oninvalid="setCustomValidity('Please Enter Valid No With Country Code +1.')" onchange="try{setCustomValidity('')}catch(e){}"  maxlength=12 value="<?php echo get_user_meta($getuser->ID,'user_phone',true); ?>">
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-md-12">
									<label>Email</label>
									<input type="text" name="email" placeholder="Email" required value="<?php echo $getuser->data->user_email; ?>">
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
									<textarea name="about" id="about" cols="30" rows="10" placeholder="About"><?php echo get_user_meta($getuser->ID,'about',true); ?></textarea>
								</div>
							</div>
							
						</div>

						<div class="col-md-6 admin-teanent-right">

							<div class="row">
								<div class="col-md-12">
									<!-- Avatar -->
									<div class="edit-profile-photo">
										<?php
												  $profile_imgid =  get_user_meta($getuser->ID,'profile_picture',true);
												  if($profile_imgid){
														echo wp_get_attachment_image( $profile_imgid, array('300', '225'), "", array( "class" => "img-responsive" ) );
												   } else {
						                  ?>
						                      <img src="<?= get_stylesheet_directory_uri() ?>/images/male-icon.png" alt="">
												 <?php
												   }
												 ?>
										<div class="change-photo-btn">
											<div class="photoUpload">
												<span><i class="fa fa-upload"></i> Upload Photo</span>
												<input type="file" class="upload" id="imgupload" name="profilepicture">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="margin-top-50">Social</h4>
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-twitter"></i> Twitter</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_twitter',true); ?>" type="text" placeholder="Twitter" name="twitter">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-facebook-square"></i> Facebook</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_facebook',true); ?>" type="text" placeholder="Facebook" name="facebook">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-google-plus"></i> Google+</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_google',true); ?>" type="text" placeholder="Googleplus" name="googleplus" >
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-linkedin"></i> Linkedin</label>
									<input value="<?php echo get_user_meta($getuser->ID,'user_linkedin',true); ?>" type="text" placeholder="linkedin" name="linkedin">
								</div>
							</div>
							<button class="button margin-top-20 margin-bottom-20" type="submit" name="update_owner">Save Changes</button>
						</div>
					</form>
				</div>
			</div>
			
	<div class="admin-teanent-property-details">
		<div class="row">
			<div class="col-md-12">
				<h4 class="margin-top-50 margin-bottom-30 admin-teanentdetail-title">Property Details</h4>
			</div>
		</div>
		<table class="manage-table responsive-table">
				<tbody>
				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th><i class="fa fa-user"></i> Owner</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>
				<?php
				$properties = nyc_get_properties_by_property_owner($user_id);
				if ( $properties->have_posts() ) {

						while ( $properties->have_posts() ) {
							$properties->the_post(); 
						    $post_id = get_the_ID();
							$address = get_post_meta($post_id, 'address',true)." ";
							$address .= get_post_meta($post_id, 'city',true)." ";
							$address .= get_post_meta($post_id, 'state',true).", ";
							$address .= get_post_meta($post_id, 'zip',true)." ";
							$price = get_post_meta($post_id, 'price',true);
							$payment_method = get_post_meta($post_id, 'payment_method',true);
							$prop_image = wp_get_attachment_url(get_post_meta($post_id, 'file_0',true));
							
				?>

				<!-- Item #1 -->
				<tr>
					<td class="title-container">
						<img src="<?php if($prop_image){ echo $prop_image; } ?>" alt="">
						<div class="title">
							<h4><a href="<?php echo get_the_guid(); ?>"><?php echo get_the_title(); ?></a></h4>
							<span><?php echo $address; ?> </span>
							<span class="table-property-price"><?php echo $price; ?></span> <span class="rented--property">Rented</span>
						</div>
					</td>
					<td>
						<div class="owner--name"><a href="#"><?php echo $name;?></a></div>
					</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete delete-property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
<?php 
						}

					}else{
					    echo "<tr class='nyc-no-properties'><td>No Properties Found !</td></tr>";
					}
				?>
				</tbody>
		</table>
		<a href="<?php echo get_site_url(); ?>/add-property" class="margin-top-40 button">Submit New Property</a>
	</div>

	<div class="admin-teanent-contract-details">
	    
		<div class="row">
			<div class="col-md-12">
				<h4 class="margin-top-50 margin-bottom-30 admin-teanentdetail-title">Contract Details</h4>
			</div>
		</div>
		<div class="admin-advanced-searchfilter" style="margin-bottom:2%">
					<h2>Contract Filter</h2>
					<form>
						<div class="row with-forms">
							<!-- Form -->
							<div class="main-search-box no-shadow">

								<!-- Row With Forms -->
								<div class="row with-forms">
									<!-- Main Search Input -->
									<div class="col-md-6">
										<input type="text" placeholder="Contract Number" name="contract_no" value=""/>
									</div>
									<div class="col-md-6">
										<input type="text" id="date-picker-from" placeholder="Date Range" name="date_range" readonly="readonly">								
									</div>
								</div>	
								<!-- Row With Forms -->
								<div class="row with-forms">
									<div class="col-md-6">
										<input type="text" placeholder="Deal No" name="deal_no" value=""/>
									</div>
									<div class="col-md-6">
										<input type="text" placeholder="Enter Tenant / Property Owner" name="filter_by_name" value=""/>
									</div>
								</div>
								<!-- Search Button -->
								<div class="row with-forms">
								    <input type="hidden" value="<?= ($_GET['prpage'])? $_GET['prpage'] : '' ?>" name="prpage" >
									<input type="hidden" value="<?= ($_GET['uid'])? $_GET['uid'] : '' ?>" name="uid" >
									
									<div class="col-md-12">
										<button class="button fs-map-btn">Search</button>
									</div>
								</div>

							</div>
							<!-- Box / End -->
						</div>
					</form>
		</div>
				
		<table class="manage-table responsive-table contracts--table">
			<tr>
				<th><i class="fa fa-list-ol"></i> Contract ID</th>
				<th><i class="fa fa-list-ol"></i> Deal ID</th>
				<th><i class="fa fa-list-ol"></i> Tenant Name</th>
				<th><i class="fa fa-list-ol"></i> Tenant Email</th>
				<th><i class="fa fa-list-ol"></i> Contract PDF</th>
				<th>Action</th>
			</tr>
		<?php
		global $paged;
        $paged = (get_query_var('id')) ? get_query_var('id') : 1;
		$args = array(
			'post_type'=> 'contracts',
			'post_status' => array('publish'),
			'posts_per_page'   => 6,
			'suppress_filters' => false,
            'paged' => $paged
		);
		$meta_query = array();
		$meta_query[] =  array(
				'key'          => 'property_owner_email',
				'value'        => $getuser->data->user_email,
				'compare'      => 'REGEXP',
		);	
		/*--------- Meta Queries -----------*/
		if(isset($_GET['date_range']) && !empty($_GET['date_range'])){
				$date = explode('-',$_GET['date_range']);
				$start_date =  date('Y-m-d',strtotime($date['0']));
				$end_date = date('Y-m-d',strtotime($date['1']));
				$date_query = array(
				'after' => $start_date,
				'before' => $end_date,
				'inclusive' => true,
				);	
	    }
		
	    if(isset($_GET['deal_no']) && !empty($_GET['deal_no'])){
				$meta_query[] =  array(
						'key'          => 'deal_id',
						'value'        => $_GET['deal_no'],
						'compare'      => 'REGEXP',
				);	
	    }

	    if(isset($_GET['filter_by_name']) && !empty($_GET['filter_by_name'])){
			$meta_query[] = array(
			'relation'    => 'OR',
			array(
					'key'          => 'tenant_name',
					'value'        => $_GET['filter_by_name'],
					'compare'      => 'LIKE',
			),
			array(
					'key'          => 'property_owner_name',
					'value'        => $_GET['filter_by_name'],
					'compare'      => 'LIKE',
			)
			);
	    }

	    if(isset($_GET['contract_no']) && !empty($_GET['contract_no'])){
			$args['post__in'] =  array($_GET['contract_no']);
	    }

		
		if(!empty($meta_query)){
		    $args['meta_query'] = $meta_query;
		} 
		if(isset($date_query) && !empty($date_query)){
	        $args['date_query'] = $date_query;
        }

		$contracts = new WP_Query( $args );
		if($contracts->have_posts()){
			while ($contracts->have_posts() ) {
				$contracts->the_post(); 
				$contract_id = get_the_ID();
				$contract_data = get_post_meta($contract_id,'contract_data', true); 
				$contract_pdf_id = get_post_meta($contract_id,'contract_pdf', true); 
				$deal_id = get_post_meta($contract_id,'deal_id', true);
				$property_id = get_post_meta($deal_id,'property_id',true);
				$auth = get_post($property_id);
				$authid = $auth->post_author;	
				?>
				<!-- Item #1 -->
				<tr class="contract-id-<?php echo $contract_id; ?>">
					<td class="deal_number"><?php echo $contract_id; ?></td>
					<td class="deal_number"><?php echo $deal_id; ?></td>
					<td class="deal_number"><?php echo get_post_meta($deal_id,'name', true); ?></td>
					<td class="deal_number"><?php echo get_post_meta($deal_id,'email', true); ?></td>
					<td class="deal_number"><?php echo  '<a href="'.wp_get_attachment_url($contract_pdf_id).'" download>'.pathinfo(basename ( get_attached_file( $contract_pdf_id ) ),PATHINFO_FILENAME).'</a>'; ?></td>
					<td class="action">
						<a href="<?php echo get_site_url(); ?>/admin/all-contracts/view/<?php echo base64_encode($contract_id); ?>" ><i class="fa fa-eye"></i> View</a>				
					</td>
				</tr>
				<?php 
			} 
		}else{
			echo "<tr><td colspan='4'>No Contract Found !</td></tr>";
		}

		?>
		</table>
	</div>

	</div>
</div>


<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>



<!-- Scripts
================================================== -->

</div>
<!-- Wrapper / End -->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>
		  <?php
            if(!empty($usererror)){
		         echo $usererror;
						
			}
					
		    if(!empty($usersuccess)){
	          echo $usersuccess; 
			}
		    ?>
		  </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
<script>
jQuery(document).ready(function(){
 jQuery(document).on('change', '.upload', function(){
  var name = document.getElementById("imgupload").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  var error = false;
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
  {
   alert("Invalid Image File");
   error = true;
  }
  var oFReader = new FileReader();
	oFReader.onload = (function(imgupload){ //trigger function on successful read
	return function(e) {
		var img = jQuery('.edit-profile-photo img').attr('srcset', e.target.result); //create image element 
	};
	})(imgupload);
  oFReader.readAsDataURL(document.getElementById("imgupload").files[0]);
  });
  jQuery('#sidebar-profile').addClass('current');
  
    jQuery('#date-picker-from').daterangepicker({
		autoUpdateInput: false,
			locale: {
			cancelLabel: 'Clear'
		}		
	});
	

	jQuery('#date-picker-from').on('show.daterangepicker', function(ev, picker) {
		jQuery('.daterangepicker').addClass('calendar-visible');
		jQuery('.daterangepicker').removeClass('calendar-hidden');
	});
	jQuery('#date-picker-from').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
	});

	jQuery('#date-picker-from').on('cancel.daterangepicker', function(ev, picker) {
		  $(this).val('');
	});
  
});
</script>

<?php
get_footer();
if(!empty($usererror)){
   echo "<script>
         jQuery(window).load(function(){
             $('#myModal').modal('show');
         });
    </script>";
}
if(!empty($usersuccess)){
   echo "<script>
         jQuery(window).load(function(){
             $('#myModal').modal('show');
         });
    </script>";
}
?>