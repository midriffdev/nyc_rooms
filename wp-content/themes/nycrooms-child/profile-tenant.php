<?php
/* Template Name: Profile Tenant */
if(!is_user_logged_in()){
     header( 'Location:' . site_url() . '/tenant-registration/');
}
$user = wp_get_current_user();
if($user->roles[0] == "property_owner"){
    header( 'Location:' . site_url() . '/property-owner/');
} else if($user->roles[0] == "administrator"){
   header( 'Location:' . site_url() . '/admin/');
}
if(isset($_POST['user_submit'])){
      
  
	 
      $userdata = array( 
	            'ID' => get_current_user_id(),
	            'user_nicename'  => $_POST['user_name'],
				'display_name'   => $_POST['user_name'],
				'user_email'    =>  $_POST['user_email']
	             );
    wp_update_user($userdata );
	
	if( isset($_FILES['profilepicture']['name']) && !empty($_FILES['profilepicture']['name'])){
	         
	    nyc_property_profile_all_image_upload($_FILES,get_current_user_id());
			 
	}
	
	 
   update_user_meta(get_current_user_id(),'user_name', $_POST['user_name']); 
   update_user_meta(get_current_user_id(),'user_phone', $_POST['user_phone']);
   update_user_meta(get_current_user_id(),'about', $_POST['about']);
   update_user_meta(get_current_user_id(),'user_twitter', $_POST['user_twitter']);
   update_user_meta(get_current_user_id(),'user_facebook', $_POST['user_facebook']);
   update_user_meta(get_current_user_id(),'user_google', $_POST['user_google']);
   update_user_meta(get_current_user_id(),'user_linkedin', $_POST['user_linkedin']); 
   
   
   $message =  "User Updated Successfully";
   
}
get_header();
?>
 <div id="primary" class="content-area">
<div id="wrapper">


<!-- Titlebar
================================================== -->


<!-- Content
================================================== -->
<div class="container">
	<div class="row">
		<!-- Widget -->
		<?php include(locate_template('sidebar/tenant-sidebar.php')); ?>
		<div class="col-md-8">
			<div class="row">
                  <label class="reset_success"><?php //echo $message; ?></label>
				<form method="post" class="profile"  action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype='multipart/form-data'>
				<div class="col-md-8 my-profile">
					<h4 class="margin-top-0 margin-bottom-30">My Account</h4>
                   
					<label>Your Name</label>
					<input value="<?php if(!empty($user->data->display_name)){echo $user->data->display_name;} ?>" type="text" name="user_name">

					<label>Phone</label>
					<input value="<?php echo get_user_meta(get_current_user_id(),'user_phone',true); ?>" type="text" name="user_phone" pattern="[0-9]{10}" maxlength=10>

					<label>Email</label>
					<input value="<?php if(!empty($user->data->user_email)){echo $user->data->user_email;} ?>" type="email" name="user_email">


					<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
					<textarea name="about" id="about" cols="30" rows="10" name="user_about"><?php echo get_user_meta(get_current_user_id(),'about',true); ?></textarea>
				

					<h4 class="margin-top-50 margin-bottom-0">Social</h4>

					<label><i class="fa fa-twitter"></i> Twitter</label>
					<input value="<?php echo get_user_meta(get_current_user_id(),'user_twitter',true); ?>" type="text" name="user_twitter">

					<label><i class="fa fa-facebook-square"></i> Facebook</label>
					<input value="<?php echo get_user_meta(get_current_user_id(),'user_facebook',true); ?>" type="text" name="user_facebook">

					<label><i class="fa fa-google-plus"></i> Google+</label>
					<input value="<?php echo get_user_meta(get_current_user_id(),'user_google',true); ?>" type="text" name="user_google">

					<label><i class="fa fa-linkedin"></i> Linkedin</label>
					<input value="<?php echo get_user_meta(get_current_user_id(),'user_linkedin',true); ?>" type="text" name="user_linkedin" >
					<button class="button margin-top-20 margin-bottom-20" type="submit" name="user_submit" >Save Changes</button>
				</div>

				<div class="col-md-4">
					<!-- Avatar -->
					<div class="edit-profile-photo">
				
					       <?php
						  $profile_imgid =  get_user_meta(get_current_user_id(),'profile_picture',true);
						  if($profile_imgid){
								echo wp_get_attachment_image( $profile_imgid, array('150', '150'), "", array( "class" => "img-responsive" ) );
						   } else {
						 ?>
						       <img src="<?= get_stylesheet_directory_uri() ?>/images/agent-01.jpg" alt="">
						 <?php
						   }
						 ?>
						
						<div class="change-photo-btn">
							<div class="photoUpload">
							    <span><i class="fa fa-upload"></i> Upload Photo</span>
							    <input type="file" class="upload" name="profilepicture" size="25" />
							</div>
						</div>
					
					
					</div>

				</div>
               </form>

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>
   <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p><?=$message ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
	</div><!-- #primary -->
<style>
label.reset_success {
    color: green;
}
</style>
<?php
get_footer();
if($message){
   echo "<script>
         jQuery(window).load(function(){
             $('#myModal').modal('show');
         });
    </script>";
}