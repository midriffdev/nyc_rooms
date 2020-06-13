<?php 
/* Template Name: Admin Dashboard */
nyc_property_admin_authority();
get_header();
?>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<!-- Content
================================================== -->
<div class="container">
	<div class="row">
	<?php include(locate_template('sidebar/admin-sidebar.php')); 
	$result = wp_get_recent_posts( array(
	'numberposts'      => 5,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'property',
	'post_status'      => 'draft, publish, available ,rented'
) );
?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">

				<div class="recent-activity">
	                <div class="act-title">
	                    <h5>Recent Activities</h5>
	                </div>
	                <ul class="act-wrap">
					<?php foreach( $result as $post ){
					   $post_id = $post['ID'];
	                   $title = $post['post_title'];
					   $date = $post['post_date'];
					   $Human_time =  human_time_diff(strtotime($date) , current_time ('timestamp', 1));
?>
	                    <li class="alert br-o fade show" data-id="<?php echo $post_id ; ?>">
	                        A new property <span class="review-stat"><?php echo $title;?></span> has been added!
							
	                        <button type="button" class="close recently_properties_close" data-id="<?php echo $post_id ; ?>" data-dismiss="alert" aria-label="Close">
	                            <span aria-hidden="true"><i class="sl sl-icon-close"></i></span>
	                        </button>
	                        <p><?php echo $Human_time ; ?> ago </p>
	                    </li>
					<?php } ?>
	                </ul>
	            </div>

	            <div class="dashboard-stats-section">
				<div class="dashboard-stat-sectioncont">
					<ul>
					
						<li class="statistic__item item--red">
							<a href="<?php echo get_site_url();?>/admin-properties">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo nyc_get_properties_admin_by_status(array('draft', 'available', 'rented',))->post_count;?></h2>
	                            		<span class="desc">Total Properties</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/property-stats.png" alt="..">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--blue">
							<a href= "<?php echo get_site_url();?>/admin-available-properties">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo nyc_get_properties_admin_by_status(array('available'))->post_count; ?></h2>
	                            		<span class="desc">Available Properties</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--green">
							<a href="<?php echo get_site_url();?>/admin-rented-properties">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo nyc_get_properties_admin_by_status(array('rented'))->post_count; ?></h2>
	                            		<span class="desc">Rented Properties</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
					</ul>

					<ul>
						<li class="statistic__item item--blue">
							<a href="<?php echo get_site_url();?>/admin-recently-properties">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo nyc_get_recent_properties('draft')->post_count; ?></h2>
	                            		<span class="desc">Recently Added </span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<?php 
						$user_count_data = count_users();
						$avail_roles = $user_count_data['avail_roles'];
						$tenant = $avail_roles['tenant'];
						$administrator = $avail_roles['administrator']; 
						$sales_agent = $avail_roles['sales_agent'];
						$property_owner = $avail_roles['property_owner'];
?>
						<li class="statistic__item item--dark">
							<a href="<?php echo get_site_url();?>/admin-property-owner"> 
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo $property_owner;?></h2>
	                            		<span class="desc">Property Owners</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/stats-proprtyowner.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--orange">
							<a href="<?php echo get_site_url(); ?>/admin/all-tenants/">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo $tenant;?></h2>
	                            		<span class="desc">Tenants</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/stats-teanent.png" alt="...">
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
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/property-stats.png" alt="...">
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
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/stats-proprtyowner.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--orange">
							<a href="#">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo nyc_count_user_by_role_today('tenant'); ?></h2>
	                            		<span class="desc">Recently Added Tenants</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/stats-teanent.png" alt="...">
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
						<img src="images/listing-02.jpg" alt="">
						<div class="title">
						<h4><a href="#">Serene Uptown</a></h4>
						<span>6 Bishop Ave. Perkasie, PA </span>
						<span class="table-property-price">$900 / Weekly</span> <span class="active--property">Available</span>
						</div>
						</td>
						</tr>
						<!-- Item #2 -->
						<tr>
						<td class="title-container">
						<img src="images/listing-05.jpg" alt="">
						<div class="title">
						<h4><a href="#">Oak Tree Villas</a></h4>
						<span>71 Lower River Dr. Bronx, NY</span>
						<span class="table-property-price">$700 / Weekly</span> <span class="active--property">Available</span>
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
						<img src="images/listing-04.jpg" alt="">
						<div class="title">
						<h4><a href="#">Selway Apartments</a></h4>
						<span>33 William St. Northbrook, IL </span>
						<span class="table-property-price">$200 / Weekly</span> <span class="active--property">Available</span>
						</div>
						</td>
						</tr>

						<!-- Item #4 -->
						<tr>
						<td class="title-container">
						<img src="images/listing-06.jpg" alt="">
						<div class="title">
						<h4><a href="#">Old Town Manchester</a></h4>
						<span> 7843 Durham Avenue, MD  </span>
						<span class="table-property-price">$500 / Weekly</span> <span class="active--property">Available</span>
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

</div>
<!-- Wrapper / End -->

<?php
get_footer();
?>
<script>
jQuery(document).ready(function($) {
	jQuery(".recently_properties_close").click(function(){
     var post_id = jQuery(this).attr("data-id");
	   jQuery("li[data-id='" + post_id + "']").remove();
	 
	});
	jQuery('#sidebar-dashboard').addClass('current');
});
</script>