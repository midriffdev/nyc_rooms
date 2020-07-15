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
					<?php 
					global $wpdb;
					$get_notification = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."notification ORDER BY id DESC LIMIT 8;");
					if($get_notification){
						foreach($get_notification as $notification){
					?>
	                    <li class="alert br-o fade show noti-row-<?php echo $notification->id; ?>">
	                        <?php echo $notification->message; ?>
	                        <button type="button" data-id="<?php echo $notification->id; ?>" class="close close_notification" >
	                            <span aria-hidden="true"><i class="sl sl-icon-close"></i></span>
	                        </button>
	                        <p><?php echo nyc_time_elapsed_string($notification->created_at); ?></p>
	                    </li>
					<?php } } else{ ?>
	                    <li class="alert br-o fade show">
	                       No Notification Found
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
										<h2 class="counter-value"><?php echo nyc_get_recent_properties(); ?></h2>
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
						if($user_count_data){
							if(isset($user_count_data['avail_roles'])){
								$avail_roles = $user_count_data['avail_roles'];
								if(isset($avail_roles['tenant'])){
									$tenant = $avail_roles['tenant'];
								}
								if(isset($avail_roles['administrator'])){
									$administrator = $avail_roles['administrator']; 
								}
								if(isset($avail_roles['sales_agent'])){
									$sales_agent = $avail_roles['sales_agent'];
								}
								if(isset($avail_roles['property_owner'])){
									$property_owner = $avail_roles['property_owner'];
								}
							}
						}
?>
						<li class="statistic__item item--dark">
							<a href="<?php echo get_site_url();?>/admin-property-owner"> 
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo (isset($property_owner)) ? $property_owner : 0;?></h2>
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
										<h2 class="counter-value"><?php echo (isset($tenant)) ? $tenant : 0;?></h2>
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
							<a href="<?php echo get_site_url(); ?>/admin/deals/">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo nyc_get_count_custom_post_type('deals'); ?></h2>
	                            		<span class="desc">Active Deals </span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
						<li class="statistic__item item--black">
							<a href="<?php echo get_site_url(); ?>/admin/all-contracts/">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo nyc_get_count_custom_post_type('contracts'); ?></h2>
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
					<ul>
					  <li class="statistic__item item--blue2">
							<a href="<?php echo get_site_url(); ?>/admin/deals/">
								<div class="statistic__item_cont">
									<div class="statistic__item_title-sec">
										<h2 class="counter-value"><?php echo nyc_get_count_order_post_type(); ?></h2>
	                            		<span class="desc">Total Earning</span>
									</div>
									<div class="statistic__item_img-sec">
										<img src="<?php echo get_stylesheet_directory_uri();?>/images/property-stats.png" alt="...">
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</div>



			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>
</div>
<!-- Wrapper / End -->

<?php
get_footer();
?>
<script>
jQuery(document).ready(function($) {
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';	
	jQuery(".close_notification").click(function(e){
		e.preventDefault();
		var noti_id = jQuery(this).attr("data-id");
		jQuery(".noti-row-"+noti_id).remove();
		var data = {
			noti_id: noti_id,
			action: "nyc_remove_notification",
		};	   
		$.post(ajaxurl, data, function(response) {
		});
	});
	jQuery('#sidebar-dashboard').addClass('current');
});
</script>