<?php 
/*
Template Name: Owner Detail
*/
$getuser = get_user_by('id',$_GET['uid']);
$usererror = '';
$usersuccess = '';
if(isset($_POST['update_owner'])){

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
								 update_user_meta($getuser->ID,'user_phone', $_POST['phone']);
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
								 update_user_meta($getuser->ID,'user_phone', $_POST['phone']);
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
									<input  type="text" name="phone" placeholder="Phone" required pattern="[0-9]{10}" maxlength=10 value="<?php echo get_user_meta($getuser->ID,'user_phone',true); ?>">
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
						                      <img src="<?= get_stylesheet_directory_uri() ?>/images/agent-01.jpg" alt="">
												 <?php
												   }
												 ?>
										<div class="change-photo-btn">
											<div class="photoUpload">
												<span><i class="fa fa-upload"></i> Upload Photo</span>
												<input type="file" class="upload" name="profilepicture">
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

	<div class="admin-teanent-contract-details">
		<div class="row">
			<div class="col-md-12">
				<h4 class="margin-top-50 margin-bottom-30 admin-teanentdetail-title">Contract Details</h4>
			</div>
		</div>
		<table class="manage-table responsive-table contracts--table">
			<tr>
				<th><i class="fa fa-list-ol"></i> Contract No</th>
				<th><i class="fa fa-file-text"></i> Contract Name</th>
				<th class="expire-date"><i class="fa fa-calendar"></i> Date</th>
				<th><i class="fa fa-hand-pointer-o"></i> Action</th>
			</tr>

			<!-- Item #1 -->
			<tr>
				<td class="contact-number">#101</td>
				<td class="title-container-contract">
					<div class="title">
						<h4><a href="#">Contract Name 1</a></h4>
					</div>
				</td>
				<td class="expire-date">December 30, 2016</td>
				<td class="action">
					<a href="#"><i class="fa fa-eye"></i> View</a>
					<a href="#"><i class="fa fa-download"></i> Download</a>
				</td>
			</tr>

			<!-- Item #2 -->
			<tr>
				<td class="contact-number">#110</td>
				<td class="title-container-contract">
					<div class="title">
						<h4><a href="#">Contract Name 2</a></h4>
					</div>
				</td>
				<td class="expire-date">December 30, 2016</td>
				<td class="action">
					<a href="#"><i class="fa fa-eye"></i> View</a>
					<a href="#"><i class="fa fa-download"></i> Download</a>
				</td>
			</tr>

			<!-- Item #3 -->
			<tr>
				<td class="contact-number">#151</td>
				<td class="title-container-contract">
					<div class="title">
						<h4><a href="#">Contract Name 3</a></h4>
					</div>
				</td>
				<td class="expire-date">December 30, 2016</td>
				<td class="action">
					<a href="#"><i class="fa fa-eye"></i> View</a>
					<a href="#"><i class="fa fa-download"></i> Download</a>
				</td>
			</tr>

			<!-- Item #4 -->
			<tr>
				<td class="contact-number">#105</td>
				<td class="title-container-contract">
					<div class="title">
						<h4><a href="#">Contract Name 4</a></h4>
					</div>
				</td>
				<td class="expire-date">December 30, 2016</td>
				<td class="action">
					<a href="#"><i class="fa fa-eye"></i> View</a>
					<a href="#"><i class="fa fa-download"></i> Download</a>
				</td>
			</tr>

		</table>
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