<?php
/*
Template Name: Rented Properties
*/
nyc_property_owner_authority();
get_header();
?>

<!-- Wrapper -->
<div id="wrapper">

<!-- Content
================================================== -->
<div class="container">
	<div class="row">
		<!-- Widget -->
		<?php get_template_part('sidebar/property-owner'); ?>
		<div class="col-md-8">
			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Expiration Date</th>
					<th></th>
				</tr>
				<?php
					$properties = nyc_get_properties_by_status(array('rented'));
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
				?>
							<tr class="property-id-<?php echo $post_id; ?>">
								<td class="title-container">
									<img src="<?php if($prop_image){ echo $prop_image; } ?>" alt="">
									<div class="title">
										<h4><a href="<?php echo get_the_guid(); ?>"><?php echo get_the_title(); ?></a></h4>
										<span><?php echo $address; ?></span>
										<span class="table-property-price">$<?php echo ($price) ? $price : 'N/A'; ?>/<?php echo ($payment_method) ? $payment_method : 'N/A'; ?></span> <span class="rented--property">Rented</span>
									</div>
								</td>
								<td class="expire-date">December 30, 2016</td>
								<td class="action">
									<a href="#"><i class="fa fa-pencil"></i> Edit</a>
									<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
									<a href="#" class="delete delete-property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
								</td>
							</tr>
				<?php 
						}

					}else{
					    echo "<tr class='nyc-no-properties'><td>No Properties Found !</td></tr>";
					}
				?>

			</table>
			<a href="submit-property.html" class="margin-top-40 button">Submit New Property</a>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

</div>
<?php
get_footer();
?>