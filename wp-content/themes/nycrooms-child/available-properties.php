<?php 
/*
Template Name: Available Properties
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
					<h2>Advanced filter</h2>
					<form>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Property Name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<select data-placeholder="Any Type" class="chosen-select-no-single" >
										<option>Any Type</option>	
										<option>Furnished</option>
										<option>Unfurnished</option>
									</select>
								</div>
								<div class="col-md-6">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Type of Accomodation</option>	
										<option>Apartment</option>
										<option>Room</option>
									</select>
								</div>
							</div>
							<!-- Row With Forms / End -->	
							

							<!-- Row With Forms -->
							<div class="row with-forms">

								<div class="col-md-4">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Rooms</option>	
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
										<option>5</option>
										<option>More than 5</option>
									</select>
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" placeholder="Min Price" data-unit="USD">
										<select>		
											<option>Min Price</option>
											<option>1 000</option>
											<option>2 000</option>	
											<option>3 000</option>	
											<option>4 000</option>	
											<option>5 000</option>	
											<option>10 000</option>	
											<option>15 000</option>	
											<option>20 000</option>	
											<option>30 000</option>
											<option>40 000</option>
											<option>50 000</option>
											<option>60 000</option>
											<option>70 000</option>
											<option>80 000</option>
											<option>90 000</option>
											<option>100 000</option>
											<option>110 000</option>
											<option>120 000</option>
											<option>130 000</option>
											<option>140 000</option>
											<option>150 000</option>
										</select>
									</div>
									<!-- Select Input / End -->
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" placeholder="Max Price" data-unit="USD">
										<select>		
											<option>Max Price</option>
											<option>1 000</option>
											<option>2 000</option>	
											<option>3 000</option>	
											<option>4 000</option>	
											<option>5 000</option>	
											<option>10 000</option>	
											<option>15 000</option>	
											<option>20 000</option>	
											<option>30 000</option>
											<option>40 000</option>
											<option>50 000</option>
											<option>60 000</option>
											<option>70 000</option>
											<option>80 000</option>
											<option>90 000</option>
											<option>100 000</option>
											<option>110 000</option>
											<option>120 000</option>
											<option>130 000</option>
											<option>140 000</option>
											<option>150 000</option>
										</select>
									</div>
									<!-- Select Input / End -->
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

				<table class="manage-table responsive-table">
				<tbody>
				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th><i class="fa fa-user"></i> Owner</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>
				<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
 'posts_per_page' 	=> 2,
'post_type'=> 'property',
'post_status' => array('available') ,
'paged' => $paged ,


);
$properties = new WP_Query( $args );
query_posts($args);
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
						<img src="<?php if($prop_image){ echo $prop_image; } ?>" alt="">
						<div class="title">
							<h4><a href="<?php echo get_the_guid(); ?>"><?php echo get_the_title(); ?></a></h4>
							<span><?php echo $address;?> </span>
							<span class="table-property-price"><?php echo $price;?></span> <span class="active--property">Available</span>
						</div>
					</td>
					<td>
						<div class="owner--name"><a href="#"><?php echo $contact_name ; ?></a></div>
					</td>
					<td class="action">
						<a href="<?php echo get_site_url();?>/edit-property/?pid=<?php echo $post_id ;?>"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete delete-property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
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
				<div class="row fs-listings">
					<div class="col-md-12">

						<!-- Pagination -->
						<div class="clearfix"></div>

							 <nav class="pagination">
								<div class="pagination">
    <?php 
        pagination_bar();
    ?>
</div>
							</nav> 
							<nav class="pagination-next-prev">
							
									<ul>
									<li><a href="#" class="prev"><?php previous_posts_link("Previous"); ?></a></li>
									<li><a href="#" class="next"><?php next_posts_link("Next"); ?></a></li>
							
								</ul>
							</nav>
						
				
				</div>
				</div>
				</div>
				<!-- Pagination Container / End -->

			</div>
		</div>

	</div>


<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>


<!-- Scripts
================================================== -->


</div>
<!-- Wrapper / End -->

<?php
get_footer();
?>
