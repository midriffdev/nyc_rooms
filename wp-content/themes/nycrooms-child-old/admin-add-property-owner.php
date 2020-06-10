<?php 
/*
Template Name: Admin Add Property Owner
*/
nyc_property_admin_authority();
get_header();
?>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">


<!-- Content
================================================== -->
<div class="container">
	<div class="row">
      <?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">

				<div class="admin-owner-account-details">
					<div class="row">
						<div class="col-md-12">
							<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Account Details</h4>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 my-profile">
							
							<div class="row">
								<div class="col-md-6">
									<label>Your Name</label>
									<input value="Jennie Wilson" type="text">
								</div>
								<div class="col-md-6">
									<label>Phone</label>
									<input value="(123) 123-456" type="text">
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<label>Email</label>
									<input value="jennie@example.com" type="text">
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
									<textarea name="about" id="about" cols="30" rows="10">Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet ullamcorper phasellus semper</textarea>
								</div>
							</div>
							<button class="button margin-top-20 margin-bottom-20">Save Changes</button>
						</div>

						<div class="col-md-6 admin-teanent-right">

							<div class="row">
								<div class="col-md-12">
									<!-- Avatar -->
									<div class="edit-profile-photo">
										<img src="images/agent-03.jpg" alt="">
										<div class="change-photo-btn">
											<div class="photoUpload">
											    <span><i class="fa fa-upload"></i> Upload Photo</span>
											    <input type="file" class="upload">
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
									<input value="https://www.twitter.com/" type="text">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-facebook-square"></i> Facebook</label>
									<input value="https://www.facebook.com/" type="text">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-google-plus"></i> Google+</label>
									<input value="https://www.google.com/" type="text">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-linkedin"></i> Linkedin</label>
									<input value="https://www.linkedin.com/" type="text">
								</div>
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
<!-- Wrapper / End -->
<?php
get_footer();
?>