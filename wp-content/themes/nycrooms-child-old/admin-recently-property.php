<?php 
/*
Template Name: Recently Properties
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

				<table class="manage-table responsive-table">
				<tbody>
				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th><i class="fa fa-user"></i> Owner</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
					<th></th>
				</tr>
				<?php 
$args = wp_get_recent_posts( array(
	'numberposts'      => 10,
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'property',
	'post_status'      => 'draft'
) );
$properties = new WP_Query( $args );
if ( $properties->have_posts() ) {

						while ( $properties->have_posts() ) {
							$properties->the_post();
							$post_id = get_the_ID();
							$address = get_post_meta($post_id, 'address',true)." ";
							$address .= get_post_meta($post_id, 'city',true)." ";
							$address .= get_post_meta($post_id, 'state',true).", ";
							$address .= get_post_meta($post_id, 'zip',true)." ";
							$price = get_post_meta($post_id, 'price',true);
							$payment_method = get_post_meta($post_id, 'payment_method',true);
							$prop_image = wp_get_attachment_url(get_post_meta($post_id, 'file_0',true));
							$contact_name = get_post_meta($post_id, 'contact_name',true);
							$status = get_post_meta($post_id, 'status',true);
				?>
				<!-- Item #1 -->
				<tr>
					<td class="title-container">
						<img src="<?php if($prop_image){ echo $prop_image; } ?>"alt="">
						<div class="title">
							<h4><a href="<?php echo get_the_guid(); ?>"><?php echo get_the_title(); ?></a></h4>
							<span><?php echo $address;?> </span>
							<span class="table-property-price"><?php echo $price;?></span> <span class="rented--property recently_prop">Recently</span>
						</div>
					</td>
					<td>
						<div class="owner--name"><a href="#"><?php echo $contact_name;?></a></div>
					</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
						<a href="<?php echo get_site_url();?>/edit-property/?pid=<?php echo $post_id ;?>"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete delete-property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
					<td class="recently-approved-btn"><button>Approve</button></td>
				</tr>
<?php 
						}
					}
					else{
					    echo "<tr class='nyc-no-properties'><td>No Properties Found !</td></tr>";
					}
				?>
				

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
									<li><a href="#" class="prev"><?php previous_posts_link("Geri"); ?></a></li>
									<li><a href="#" class="next"><?php next_posts_link("İleri"); ?></a></li>
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

</div>
<!-- Wrapper / End -->

<?php 
get_footer();
?>