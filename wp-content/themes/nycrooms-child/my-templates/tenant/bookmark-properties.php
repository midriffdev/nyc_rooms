<?php
/* Template Name: Bookmarked Properties Tenant */
$getuser = wp_get_current_user();
$user_id = $getuser->ID;
nyc_tenant_check_authentication();
get_header();
$bookmark_properties = get_user_meta($user_id,'nyc_bookmark',true);
if($bookmark_properties){
$bookmark_properties = array_filter($bookmark_properties);
}
?>
<!-- Wrapper -->
<div id="wrapper">

<div class="container">
	<div class="row">

		<!-- Widget -->
		<?php include(locate_template('sidebar/tenant-sidebar.php')); ?>

		<div class="col-md-8">
		    <p style="color:#274abb"><a href="<?= site_url() ?>/tenant/"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Profile</a></p>
			<table class="manage-table bookmarks-table responsive-table">

				<tr class="bookmark_table_head">
					<th><i class="fa fa-file-text"></i> Property</th>
					<th></th>
				</tr>

				<!-- Item #1 -->
				<?php 
				if($bookmark_properties){
					foreach($bookmark_properties as $property){ 
						$property = get_post($property);
						$post_id = $property->ID;
						$title = $property->post_title;
						$address = get_post_meta($post_id, 'city',true)." ";
						$address .= get_post_meta($post_id, 'state',true).", ";
						$address .= get_post_meta($post_id, 'zip',true)." ";
						$price = get_post_meta($post_id, 'price',true);
						$prop_image = wp_get_attachment_url(get_post_meta($post_id, 'file_0',true));				
					?>
					<tr class="bookmark-id-<?php echo $post_id; ?> bookmark_property">
						<td class="title-container">
							<img src="<?php if($prop_image){ echo $prop_image; } ?>" alt="">
							<div class="title">
								<h4><a href="<?php echo $property->guid; ?>"><?php echo $title; ?></a></h4>
								<span><?php echo $address; ?></span>
								<span class="table-property-price">$<?php echo $price; ?> / Weekly</span>
							</div>
						</td>
						<td class="action">
							<a href="#" data-id="<?php echo $post_id; ?>" class="delete nyc_remove_bookmark"><i class="fa fa-remove"></i> Remove</a>
						</td>
					</tr>
					<?php 
					} 
				}else{
					echo "<tr><td colspan='2' class='no_property_found'>No Bookmark Propery Found !</td></tr>";
				}
				?>

			</table>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

</div>
<script>
jQuery('.nyc_remove_bookmark').click(function (e) {
	e.preventDefault();
	var id=jQuery(this).attr('data-id');
	jQuery.ajax({
		type : "post",
		url : my_ajax_object.ajax_url,
		data: { action: 'nyc_remove_add_to_favorite', property_id:id },
		success: function(response) {
			var classname = ".bookmark-id-"+id;
			console.log(classname);
			jQuery(classname).remove();
			if (!$(".bookmark_property")[0]){
				jQuery(".bookmark_table_head").after("<tr><td colspan='2'><strong>No Bookmark propery founds!</strong></td></tr>");
			}
		}
	});
});
jQuery(document).ready(function($) {
	jQuery('#sidebar-bookmark').addClass('current');
});
</script>
<!-- Wrapper / End -->
<?php
get_footer();