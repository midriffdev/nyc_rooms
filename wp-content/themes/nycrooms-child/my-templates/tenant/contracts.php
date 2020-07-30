<?php
/* Template Name: Contracts Tenant */
if(!is_user_logged_in()){
     header( 'Location:' . site_url() . '/tenant-registration/');
}
$user = wp_get_current_user();
if($user->roles[0] == "property_owner"){
    header( 'Location:' . site_url() . '/my-profile/');
} else if($user->roles[0] == "administrator"){
   header( 'Location:' . site_url() . '/admin-dashboard/');
}
get_header();
?>
<!-- Wrapper -->
<div id="wrapper">

<!-- Content
================================================== -->
<div class="container">
	<div class="row">
         <?php include(locate_template('sidebar/tenant-sidebar.php')); ?>
		<div class="col-md-8">
			<table class="manage-table responsive-table contracts--table">
				<tr>
					<th>Contract No</th>
					<th>Contract Name</th>
					<th class="expire-date"> Date</th>
					<th> Action</th>
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

	</div>
</div>

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>


</div>
<!-- Wrapper / End -->
<?php
get_footer();