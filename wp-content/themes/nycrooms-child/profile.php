<?php
/* Template Name: Profile */
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
		<div class="col-md-4">
			<div class="sidebar left">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>
						<li><a href="#"><i class="sl sl-icon-screen-desktop"></i> Dashboard</a></li>
						<li><a href="my-profile.html" class="current"><i class="sl sl-icon-user"></i> My Profile</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li><a href="my-properties.html"><i class="sl sl-icon-docs"></i> My Properties</a></li>
						<li><a href="submit-property.html"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li><a href="change-password.html"><i class="sl sl-icon-lock"></i> Change Password</a></li>
						<li><a href="<?php echo wp_logout_url(home_url().'/login-register/'); ?>"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>

				</div>

			</div>
		</div>

		<div class="col-md-8">
			<div class="row">


				<div class="col-md-8 my-profile">
					<h4 class="margin-top-0 margin-bottom-30">My Account</h4>

					<label>Your Name</label>
					<input value="Jennie Wilson" type="text">

					<label>Phone</label>
					<input value="(123) 123-456" type="text">

					<label>Email</label>
					<input value="jennie@example.com" type="text">


					<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
					<textarea name="about" id="about" cols="30" rows="10">Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet ullamcorper phasellus semper</textarea>
				

					<h4 class="margin-top-50 margin-bottom-0">Social</h4>

					<label><i class="fa fa-twitter"></i> Twitter</label>
					<input value="https://www.twitter.com/" type="text">

					<label><i class="fa fa-facebook-square"></i> Facebook</label>
					<input value="https://www.facebook.com/" type="text">

					<label><i class="fa fa-google-plus"></i> Google+</label>
					<input value="https://www.google.com/" type="text">

					<label><i class="fa fa-linkedin"></i> Linkedin</label>
					<input value="https://www.linkedin.com/" type="text">


					<button class="button margin-top-20 margin-bottom-20">Save Changes</button>
				</div>

				<div class="col-md-4">
					<!-- Avatar -->
					<div class="edit-profile-photo">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/images/agent-02.jpg" alt="">
						<div class="change-photo-btn">
							<div class="photoUpload">
							    <span><i class="fa fa-upload"></i> Upload Photo</span>
							    <input type="file" class="upload" />
							</div>
						</div>
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

<?php
get_footer();
