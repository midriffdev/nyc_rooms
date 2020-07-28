<?php
/*
Template Name: Unapproved Properties
*/
nyc_property_owner_authority();

$argarray = array();
if(isset($_GET['update_search'])){

    $argarray =  array(
        //comparison between the inner meta fields conditionals
        'relation'    => 'AND',
        //meta field condition one
		array(
            'key'          => 'accomodation',
            'value'        => $_GET['property_type'],
            'compare'      => 'LIKE',	
        ),
        //meta field condition one
        array(
            'key'          => 'rooms',
            'value'        => $_GET['rooms'],
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => 'LIKE',
        )
		
	);
	
	
	if(!empty($_GET['min-price-input']) && empty($_GET['max-price-input']) ){
     $argarray[] =  array(
            'key'          => 'price',
            'value'        => str_replace(' ', '', $_GET['min-price-input']),
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => '<=',
			'type'          => 'NUMERIC'
                   );
	}
	
	if(empty($_GET['min-price-input']) && !empty($_GET['max-price-input']) ){
     $argarray[] =  array(
            'key'          => 'price',
            'value'        => str_replace(' ', '', $_GET['max-price-input']),
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => '<=',
			'type'          => 'NUMERIC'
                   );
	}
	
	if(!empty($_GET['min-price-input']) && !empty($_GET['max-price-input']) ){
     $argarray[] =  array(
							'key'          => 'price',
							'value'        => str_replace(' ', '', $_GET['min-price-input']),
							//I think you really want != instead of NOT LIKE, fix me if I'm wrong
							//'compare'      => 'NOT LIKE',
							'compare'      => '>=',
							'type'          => 'NUMERIC'
                   );
	
    $argarray[] =  array(
					'key'          => 'price',
					'value'        => str_replace(' ', '', $_GET['max-price-input']),
					//I think you really want != instead of NOT LIKE, fix me if I'm wrong
					//'compare'      => 'NOT LIKE',
					'compare'      => '<=',
					'type'          => 'NUMERIC'
                   );	
				   
	}
		
		
	

}

$args = array(
			'posts_per_page' 	=> -1,
			'post_type' 		=> 'property',
			'post_status' 		=> 'draft',
			'author' 			=> get_current_user_id(),
	    );

if(isset($_GET['Property_name']) && !empty($_GET['Property_name'])){
   
   $args['_meta_or_title'] = $_GET['Property_name'];

}


if(isset($_GET['furnish_unfurnish_type']) && !empty($_GET['furnish_unfurnish_type'])){

   
			  $args['tax_query'] = array(
												array(
													'taxonomy' => 'types',
													'field' => 'slug',
													'terms' => $_GET['furnish_unfurnish_type'],
												)
								   );
						  
	   
	   
						   
}

if(!empty($argarray)){
   $args['meta_query'] = $argarray;
} 
	
$properties = new WP_Query($args);

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
		      <p style="color:#274abb"><a href="<?= site_url() ?>/property-owner/"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Profile</a></p>
			<table class="manage-table responsive-table">
                 <div class="admin-advanced-searchfilter" style="margin-bottom: 5%;">
		            <h2>Advanced filter</h2>
					<form method="get" id="advance-search">
						<div class="row with-forms">
							<!-- Form -->
							<div class="main-search-box no-shadow">

								<!-- Row With Forms -->
								<div class="row with-forms">
									<!-- Main Search Input -->
									<div class="col-md-12">
										<input type="text" placeholder="Enter Property Name" value="" name="Property_name"/>
									</div>
								</div>
								<!-- Row With Forms / End -->

								<!-- Row With Forms -->
								<div class="row with-forms">
									<div class="col-md-6">
										<select data-placeholder="Any Type" class="chosen-select-no-single" name="furnish_unfurnish_type">
											<option value="">Any Type</option>	
											<option value="furnished">Furnished</option>
											<option value="unfurnished">Unfurnished</option>
										</select>
									</div>
									<div class="col-md-6">
										<select data-placeholder="Any Status" class="chosen-select-no-single" name="property_type" >
											<option value="">Type of Accomodation</option>	
											<option value="apartment">Apartment</option>
											<option value="room">Room</option>
										</select>
									</div>
								</div>
								<!-- Row With Forms / End -->	
								

								<!-- Row With Forms -->
								<div class="row with-forms">

									<div class="col-md-4">
										<select data-placeholder="Any Status" class="chosen-select-no-single" name="rooms">
											<option value="">Rooms</option>	
											<option value="1" >1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="more than 5">More than 5</option>
										</select>
									</div>
									<div class="col-md-4">
										<!-- Select Input -->
										<div class="select-input disabled-first-option">
											<input type="text" placeholder="Min Price" data-unit="USD" name="min-price-input">
											<select name="min-price">		
												<option value="">Min Price</option>
												<option value="1000">1 000</option>
												<option value="2000">2 000</option>	
												<option value="3000">3 000</option>	
												<option value="4000">4 000</option>	
												<option value="5000">5 000</option>	
												<option value="10000">10 000</option>	
												<option value="15000">15 000</option>	
												<option value="20000">20 000</option>	
												<option value="30000">30 000</option>
												<option value="40000">40 000</option>
												<option value="50000">50 000</option>
												<option value="60000">60 000</option>
												<option value="70000">70 000</option>
												<option value="80000">80 000</option>
												<option value="90000">90 000</option>
												<option value="100000">100 000</option>
												<option value="110000">110 000</option>
												<option value="120000">120 000</option>
												<option value="130000">130 000</option>
												<option value="140000">140 000</option>
												<option value="150000">150 000</option>
											</select>
										</div>
										<!-- Select Input / End -->
									</div>
									<div class="col-md-4">
										<!-- Select Input -->
										<div class="select-input disabled-first-option">
											<input type="text" placeholder="Max Price" data-unit="USD" name="max-price-input">
											<select name="max-price">		
												<option value="">Max Price</option>
												<option value="1000">1 000</option>
												<option value="2000">2 000</option>	
												<option value="3000">3 000</option>	
												<option value="4000">4 000</option>	
												<option value="5000">5 000</option>	
												<option value="10000">10 000</option>	
												<option value="15000">15 000</option>	
												<option value="20000">20 000</option>	
												<option value="30000">30 000</option>
												<option value="40000">40 000</option>
												<option value="50000">50 000</option>
												<option value="60000">60 000</option>
												<option value="70000">70 000</option>
												<option value="80000">80 000</option>
												<option value="90000">90 000</option>
												<option value="100000">100 000</option>
												<option value="110000">110 000</option>
												<option value="120000">120 000</option>
												<option value="130000">130 000</option>
												<option value="140000">140 000</option>
												<option value="150000">150 000</option>
											</select>
										</div>
										<!-- Select Input / End -->
									</div>

								</div>
								<!-- Row With Forms / End -->

								<!-- Search Button -->
								<div class="row with-forms">
									<div class="col-md-12">
										<button class="button fs-map-btn" name="update_search" type="submit">Search</button>
									</div>
								</div>

							</div>
							<!-- Box / End -->
						</div>
					</form>
			    </div>
				
				<tr>
				    <th><input type="checkbox" class="checkallproperties"></th>
					<th style="width:70%;"><i class="fa fa-file-text"></i> Property</th>
					<th style="width:30%;"></th>
				</tr>
				<?php
				
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
							$document_files = explode(',',get_post_meta($post_id, 'document_files',true));
				?>
							<tr class="property-id-<?php echo $post_id; ?>">
								<td class="title-container">
									<img src="<?php if($prop_image){ echo $prop_image; } ?>" alt="">
									<div class="title">
										<h4><a href="<?= get_post_permalink($post_id).'&prpage=unapproved-properties'  ?>"><?php echo get_the_title(); ?></a></h4>
										<span><?php echo $address; ?></span>
										<span class="table-property-price">$<?php echo ($price) ? $price : 'N/A'; ?>/ Weekly</span> <span class="unapproved--property">Unapproved</span>
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
								<td class="action">
								     <a href="<?= get_post_permalink( $post_id).'&prpage=unapproved-properties' ?>"><i class="fa fa-eye"></i> View</a>
									<a href="<?= site_url().'/edit-property-owner/?pid='. $post_id .'&prpage=unapproved-properties' ?>"><i class="fa fa-pencil"></i> Edit</a>
									<a href="#" class="delete delete-property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
								</td>
							</tr>
				<?php 
						}

					}else{
					    echo "<tr class='nyc-no-properties'><td class='no_property_found' colspan='3'>No Properties Found !</td></tr>";
					}
				?>
			</table>
		      <a href="<?php echo get_site_url(); ?>/add-property" class="margin-top-40 button">Submit New Property</a>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>
</div>
<script>
jQuery(document).ready(function($) {
	jQuery('.propertyOwnerList').addClass('show--submenu');
	jQuery('#sidebar-unapproveproperty').addClass('current');
});
</script>
<?php
get_footer();
?>