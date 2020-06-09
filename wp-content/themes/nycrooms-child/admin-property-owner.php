<?php 
/*
Template Name: Property Owner
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

				<div class="admin-advanced-searchfilter">
					<h2>Property Owner filter</h2>
					<form>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Owner Name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<input type="email" id="email" name="email" placeholder="Enter Email">
								</div>
								<div class="col-md-6">
									<input type="text" placeholder="Enter Phone" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->	

							<!-- Search Button -->
							<div class="row with-forms">
								<div class="col-md-12">
									<button class="button fs-map-btn">Search</button>
								</div>
							</div>

						</div>
						<!-- Box / End -->
					</div>
					</form>
				</div>
				<?php 

$args = array(
    'role'    => 'property_owner',
    'orderby' => 'user_nicename',
    'order'   => 'ASC'
);
$users = get_users($args);



?>
				<table class="manage-table responsive-table admin-teanent-maintable">
				<tbody>
				<tr>
					<th><i class="fa fa-file-text"></i> Owner</th>
					<th class="expire-date"><i class="fa fa-home" ></i>Properties</th>
					<th><i class="fa fa-envelope"></i> Email</th>
					<th><i class="fa fa-phone" ></i> Phone</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>

				<!-- Item #1 -->
				<?php foreach ( $users as $user ) {
                   $phone = get_user_meta($user->ID,'phone',true);
				    $profile_picture = get_user_meta($user->ID,'profile_picture',true);
					?>
				<tr>
					<td class="title-container teanent-title-container">
		
						<img src="<?php echo $profile_picture;?>" alt="">
						<div class="title">
							<h4><a href="<?php echo get_site_url();?>/property-owner-details"><?php echo $user->user_nicename ; ?></a></h4>
						</div>
					</td>
					<td class="admin-owner-propertycount"><?php echo nyc_get_properties_by_property_owner($user->ID)->post_count;?></td>
					<td class="owner--username"><?php echo $user->user_email ;?></td>
					<td><div class="owner-phone-no"><?php echo $phone ;?></div></td>
					<td class="action">
						<a href="<?php echo get_site_url();?>/property-owner-details/?uid=<?php echo $user->ID;?>"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete delete-property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
				<?php } ?>
				</tbody>
				</table>

				<!-- Pagination Container -->
				<div class="row fs-listings">
					<div class="col-md-12">

						<!-- Pagination -->
						<div class="clearfix"></div>
						<div class="pagination-container margin-top-10 margin-bottom-45">
							<nav class="pagination">
								<ul>
									<li><a href="#" class="current-page">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li class="blank">...</li>
									<li><a href="#">22</a></li>
								</ul>
							</nav>

							<nav class="pagination-next-prev">
								<ul>
									<li><a href="#" class="prev">Previous</a></li>
									<li><a href="#" class="next">Next</a></li>
								</ul>
							</nav>
						</div>

					</div>
				</div>
				<!-- Pagination Container / End -->

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>


<!-- Scripts
================================================== --

</div>
<!-- Wrapper / End -->

<?php 
get_footer();
?>