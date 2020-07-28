<?php
nyc_tenant_check_authentication();
get_header();
$current_user = wp_get_current_user();
$args = array(
	'post_type'=> 'contracts',
	'post_status' => array('publish'),
	'posts_per_page'   => -1,
);
$meta_query = array();
$meta_query[] =  array(
		'key'          => 'tenant_email',
		'value'        => $current_user->user_email,
		'compare'      => '=',
);	
if(!empty($meta_query)){
   $args['meta_query'] = $meta_query;
} 
$contracts = new WP_Query( $args );
$property_ids = array();
if($contracts->have_posts()){
	while ( $contracts->have_posts() ) {
		$contracts->the_post();
		$contract_id = get_the_ID();
		$property_ids[] = get_post_meta($contract_id, 'property_id',true);
	}
}

$properties = '';
global $paged;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if($property_ids){
	//Getting Property 
	$args_prop = array(
		'post_type'=> 'property',
		'post_status' => array('draft', 'available', 'rented','Pending Review','publish'),
		'posts_per_page'   => 6,
		'suppress_filters' => false,
		'paged' => $paged,
		'post__in' => $property_ids,
	);
	$properties = new WP_Query( $args_prop );
}
?>
<style>
.pagination-next-prev ul li.prev a {
    left: 0;
    position: absolute;
    top: 0;
}
.pagination-next-prev ul li.next a {
    right: 0;
    position: absolute;
    top: 0;
}

.pagination ul span.page-numbers.current {
    background: #274abb;
    color: #fff;
    padding: 8px 0;
    width: 42px;
    display: inline-block;
    border-radius: 3px;
}
.contract_bulk_actions {
    display: flex;
}
select.select_action {
    width: 30%;
}
input.contract_apply_action {
    width: 30%;
    margin-left: 5%;
    padding: 0;
}
input.checkallbulk{
    height: 18px;
}
input.checkbulk{
    height: 18px;
    margin: 0 13px !important;
}
</style>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<div class="container">
	<div class="row">
		<?php include(locate_template('sidebar/tenant-sidebar.php')); ?>
		<div class="col-md-8">
			<div class="dashboard-main--cont">
                 <p style="color:#274abb"><a href="<?= site_url() ?>/tenant/"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Profile</a></p>
                 <div class="col-md-12">
					 <p class="showing-results"><?php echo $contracts->found_posts; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $contracts->max_num_pages;?> </p>
				 </div>
				 
				<table class="manage-table responsive-table deal--table">
				<tbody>
				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th><i class="fa fa-user"></i> Owner</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>

				<?php 
				
				if(!empty($properties) && $properties->have_posts()){
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
							if(!$prop_image){
							   $prop_image = wp_get_attachment_url(get_post_meta($post_id, 'file_1',true));
							}
							$document_files = explode(',',get_post_meta($post_id, 'document_files',true));
				?>
							<tr>
								<td class="title-container">
									<img src="<?php if($prop_image){ echo $prop_image; } ?>" alt="">
									<div class="title">
										<h4><a href="<?= get_post_permalink( get_the_ID()) . '?prpage=hired-property' ?>"><?php echo get_the_title($post_id); ?></a></h4>
										<span><?php echo $address;?> </span>
										<span class="table-property-price"><?php echo $price . '$ / Week' ;?></span> <span class="active--property"><?php echo $status ;?></span>
										<?php 
										if($document_files){
											echo "</br></br>";
											echo "<span>Document Files </span>";
											foreach($document_files as $file){
													$attc_id = get_post_meta($post_id,$file,true);
													echo wp_get_attachment_link($attc_id);
													echo "</br>";
											}
										} 	
										?>							
									</div>
								</td>
								<td>
									<div class="owner--name"><a href="#"><?php echo $contact_name ; ?></a></div>
								</td>
								<td class="action">
									<a href="<?= get_post_permalink( get_the_ID()) . '?prpage=hired-property' ?>"><i class="fa fa-eye"></i> View</a>
								</td>
							</tr>
			    <?php 
					}
				}else{
					echo "<tr><td colspan='3' class='no_property_found'>No Hired Property Found!</td></tr>";
				}
				?>
				</tbody>
				</table>
				<!-- Pagination Container -->
				<div class="row fs-listings">
					<div class="col-md-12">

						<!-- Pagination -->
						<div class="clearfix"></div>
						<?php if(!empty($properties)){ ?>
						<div class="pagination-container margin-top-10 margin-bottom-45">
							<nav class="pagination">
							<ul>
								<?php 
									echo paginate_links( array(
										'base' 		=> get_pagenum_link(1) . '%_%',
										'format' 	=> 'page/%#%/',
										'current' 	=> max( 1, get_query_var( 'paged' ) ),
										'total'  	=> $properties->max_num_pages,
										'prev_next'	=> false,
										'type' 		=> 'list',											
										) );
                              ?>
							 </ul>
							</nav>

							<nav class="pagination-next-prev">
								<ul>
									<li><?php previous_posts_link( 'Previous',$properties->max_num_pages ); ?></li>
									<li><?php next_posts_link( 'Next', $properties->max_num_pages);  ?></li>
								</ul>
							</nav>
						</div>
						<?php } ?>
					</div>
				</div>
				<!-- Pagination Container / End -->

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>
</div>
<script>
jQuery(document).ready(function($) {
	jQuery('#sidebar-hiredproperty').addClass('current');
});
</script>
<?php 
get_footer();
?>