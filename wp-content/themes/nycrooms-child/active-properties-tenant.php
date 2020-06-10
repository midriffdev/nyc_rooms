<?php
/* Template Name: Active Properties Tenant */
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
			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Expiration Date</th>
					<th></th>
				</tr>

				<!-- Item #1 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-02.jpg" alt="">
						<div class="title">
							<h4><a href="#">Serene Uptown</a></h4>
							<span>6 Bishop Ave. Perkasie, PA </span>
							<span class="table-property-price">$900 / monthly</span> <span class="active--property">Active</span>
						</div>
					</td>
					<td class="expire-date">December 30, 2016</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
					</td>
				</tr>

				<!-- Item #2 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-05.jpg" alt="">
						<div class="title">
							<h4><a href="#">Oak Tree Villas</a></h4>
							<span>71 Lower River Dr. Bronx, NY</span>
							<span class="table-property-price">$700 / monthly</span> <span class="active--property">Active</span>
						</div>
					</td>
					<td class="expire-date">December 12, 2016</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
					</td>
				</tr>

				<!-- Item #3 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-04.jpg" alt="">
						<div class="title">
							<h4><a href="#">Selway Apartments</a></h4>
							<span>33 William St. Northbrook, IL </span>
							<span class="table-property-price">$200 / monthly</span> <span class="active--property">Active</span>
						</div>
					</td>
					<td class="expire-date">December 04, 2016</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
					</td>
				</tr>

				<!-- Item #4 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-06.jpg" alt="">
						<div class="title">
							<h4><a href="#">Old Town Manchester</a></h4>
							<span> 7843 Durham Avenue, MD  </span>
							<span class="table-property-price">$500 / monthly</span> <span class="active--property">Active</span>
						</div>
					</td>
					<td class="expire-date">November 27, 2016</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
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