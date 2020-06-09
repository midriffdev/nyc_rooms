<?php
/* Template Name: Admin Dashboard */
if(!is_user_logged_in()){
     header( 'Location:' . site_url() . '/login-admin/');
}
$user = wp_get_current_user();
if($user->roles[0] == "tenant"){
    header( 'Location:' . site_url() . '/my-profile-tenant/');
} else if($user->roles[0] == "property_owner"){
    header( 'Location:' . site_url() . '/my-profile/');
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
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">


<!-- Content
================================================== -->
<div class="container">
	<div class="row">


		<!-- Widget -->
		<?php get_template_part('sidebar/admin-sidebar'); ?>

		<div class="col-md-9">
			<div class="dashboard-main--cont">

				<div class="recent-activity">
	                <div class="act-title">
	                    <h5>Recent Activities</h5>
	                </div>
	                <ul class="act-wrap">
	                    <li class="alert br-o fade show">
	                        A new property <span class="review-stat">Villa On Hartford</span> has been added!
	                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                            <span aria-hidden="true"><i class="sl sl-icon-close"></i></span>
	                        </button>
	                        <p>30 mins ago</p>
	                    </li>
	                    <li class="alert br-o fade show">
	                        <span class="review-stat">Andrew</span> sends a Booking request for <span class="review-stat">Villa on Sunbury</span> Property!
	                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                            <span aria-hidden="true"><i class="sl sl-icon-close"></i></span>
	                        </button>
	                        <p>5 hours ago</p>
	                    </li>
	                </ul>
	            </div>

	            <div class="dashboard-stats-section">
				<div class="dashboard-stat-sectioncont">
					<ul>
						<li class="statistic__item item--red">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">2000</h2>
	                            		<span class="desc">Total Properties</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--blue">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">20</h2>
	                            		<span class="desc">Available Properties</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--green">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">500</h2>
	                            		<span class="desc">Rented Properties</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
					</ul>

					<ul>
						<li class="statistic__item item--blue">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">5</h2>
	                            		<span class="desc">Recently Added </span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--dark">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">1000</h2>
	                            		<span class="desc">Property Owners</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/stats-proprtyowner.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--orange">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">500</h2>
	                            		<span class="desc">Tenants</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/stats-teanent.png" alt="...">
									</div>
								</div>
							</a>
						</li>
					</ul>

					<ul>
						<li class="statistic__item item--blue2">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">50</h2>
	                            		<span class="desc">Active Deals </span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--black">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">3000</h2>
	                            		<span class="desc">Total Contracts</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/stats-proprtyowner.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--orange">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value">50</h2>
	                            		<span class="desc">Recently Added Tenants</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/stats-teanent.png" alt="...">
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="dadhboard-featuredproperties_section">
				<div class="row">
					<div class="col-md-12"><h2>Featured Properties</h2></div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<table class="manage-table responsive-table">
						<tbody>
						<!-- Item #1 -->
						<tr>
						<td class="title-container">
						<img src="<?= get_stylesheet_directory_uri() ?>/images/listing-02.jpg" alt="">
						<div class="title">
						<h4><a href="#">Serene Uptown</a></h4>
						<span>6 Bishop Ave. Perkasie, PA </span>
						<span class="table-property-price">$900 / monthly</span> <span class="active--property">Available</span>
						</div>
						</td>
						</tr>
						<!-- Item #2 -->
						<tr>
						<td class="title-container">
						<img src="<?= get_stylesheet_directory_uri() ?>/images/listing-05.jpg" alt="">
						<div class="title">
						<h4><a href="#">Oak Tree Villas</a></h4>
						<span>71 Lower River Dr. Bronx, NY</span>
						<span class="table-property-price">$700 / monthly</span> <span class="active--property">Available</span>
						</div>
						</td>
						</tr>

						</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<table class="manage-table responsive-table">
						<tbody>
						<!-- Item #3 -->
						<tr>
						<td class="title-container">
						<img src="<?= get_stylesheet_directory_uri() ?>/images/listing-04.jpg" alt="">
						<div class="title">
						<h4><a href="#">Selway Apartments</a></h4>
						<span>33 William St. Northbrook, IL </span>
						<span class="table-property-price">$200 / monthly</span> <span class="active--property">Available</span>
						</div>
						</td>
						</tr>

						<!-- Item #4 -->
						<tr>
						<td class="title-container">
						<img src="<?= get_stylesheet_directory_uri() ?>/images/listing-06.jpg" alt="">
						<div class="title">
						<h4><a href="#">Old Town Manchester</a></h4>
						<span> 7843 Durham Avenue, MD  </span>
						<span class="table-property-price">$500 / monthly</span> <span class="active--property">Available</span>
						</div>
						</td>
						</tr>

						</tbody>
						</table>
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


<!-- Scripts
================================================== -->

</div>
<style>
label.reset_success {
    color: green;
}
</style>
<?php
get_footer();