<?php
/* Template Name: Profile */
if(!is_user_logged_in()){
     header( 'Location:' . site_url() . '/login-register/');
}
$user = wp_get_current_user();
if($user->roles[0] == "tenant"){
    header( 'Location:' . site_url() . '/my-profile-tenant/');
} else if($user->roles[0] == "administrator"){
   header( 'Location:' . site_url(). '/admin-dashboard/');
}
if(isset($_POST['user_submit'])){
  
	 
      $userdata = array(
                    'ID' => get_current_user_id(),
					'user_nicename'  => $_POST['user_name'],
					'display_name'   => $_POST['user_name'],
					'user_email'    =>  $_POST['user_email']
	             );
    wp_update_user($userdata );
	 
   update_user_meta(get_current_user_id(),'nickname', $_POST['user_name']); 
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
		<?php get_template_part('sidebar/property-owner'); ?>

		<div class="col-md-8">
			<div class="row">
                  <label class="reset_success"><?php echo $message; ?></label>
				<div class="col-md-8 my-profile">
					<h4 class="margin-top-0 margin-bottom-30">My Account</h4>
                    <form method="post" class="profile"  action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
					<label>Your Name</label>
					<input value="<?php if(!empty($user->data->display_name)){echo $user->data->display_name;} ?>" type="text" name="user_name">

					<label>Phone</label>
					<input value="<?php echo get_user_meta(get_current_user_id(),'user_phone',true); ?>" type="text" name="user_phone">

					<label>Email</label>
					<input value="<?php if(!empty($user->data->user_email)){echo $user->data->user_email;} ?>" type="text" name="user_email">


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
				</form>
				</div>

				<div class="col-md-4">
					<!-- Avatar -->
					<div class="edit-profile-photo">
					<form action="<?php echo get_stylesheet_directory_uri() ?>/process_upload.php" method="post" enctype="multipart/form-data">
					      <?php $profile  = get_user_meta(get_current_user_id(),'profile_picture',true);
                               if($profile){
							   ?>
							    <img src="<?php echo $profile ;?>" alt="">
							<?php
							   } else {
						  ?><img src="<?php echo get_stylesheet_directory_uri() ?>/images/agent-02.jpg" alt="">
						  <?php
						      }
						  ?>
						
						<div class="change-photo-btn">
							<div class="photoUpload">
							    <span><i class="fa fa-upload"></i> Upload Photo</span>
							    <input type="file" class="upload" name="profilepicture" size="25" />
							</div>
						</div>
						<div style="float: left;margin-top: 4%;">
						   <input type="submit" name="submit" value="upload Profile" />
						</div>
					 </form>
					</div>

				</div>
               

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>
	</div><!-- #primary -->
<style>
label.reset_success {
    color: green;
}
</style>
<?php
get_footer();
