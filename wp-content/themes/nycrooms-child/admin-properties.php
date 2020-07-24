<?php 
/*
Template Name: Admin Properties
*/
nyc_property_admin_authority();
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
	
	if(isset($_GET['property_lang']) && !empty($_GET['property_lang']) ){	
		$argarray[] =  array
		(
			'key'          => 'rm_lang',
			'value'        => $_GET['property_lang'],
			'compare'      => '=',
		);
	}
	
	if(isset($_GET['property_gender']) && !empty($_GET['property_gender']) ){	
		$argarray[] =  array
		(
			'key'          => 'gender',
			'value'        => $_GET['property_gender'],
			'compare'      => '=',
		);
	}
	
	if(isset($_GET['property_Act_inact']) && !empty($_GET['property_Act_inact']) ){	
	
	    if($_GET['property_Act_inact'] == 1 or $_GET['property_Act_inact'] == 2):
		
			$argarray[] =  array
			(
				'key'          => 'prop_active_inactive',
				'value'        => (int)$_GET['property_Act_inact'],
				'compare'      => '=',
			);
			
		endif;
		
	}
	
	
	if(isset($_GET['property_location']) && !empty($_GET['property_location']) ){	
		$argarray[] = array(
		    'relation'    => 'OR',
			array
			(
				'key'          => 'address',
				'value'        => $_GET['property_location'],
				'compare'      => '%LIKE%',
			),
			array
			(
				'key'          => 'city',
				'value'        => $_GET['property_location'],
				'compare'      => '%LIKE%',
			),
			array
			(
				'key'          => 'state',
				'value'        => $_GET['property_location'],
				'compare'      => '%LIKE%',
			),
		);
	}
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
	'post_type'=> 'property',
	'post_status' => array('draft', 'available', 'rented','Pending Review'),
	'posts_per_page'   => 6,
			 //'no_found_rows'    => true,
	'suppress_filters' => false,
	'paged' => $paged
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

if(isset($_GET['property_Act_inact']) && !empty($_GET['property_Act_inact']) ){	
	
	    if($_GET['property_Act_inact'] == "approved"):
			$args['post_status'] = array('available' , 'rented');
		endif;
		
		if($_GET['property_Act_inact'] == "unapproved"):
	        $args['post_status'] = array('draft');
		endif;
		
		
		
}
	

if(!empty($argarray)){
   $args['meta_query'] = $argarray;
} 

$properties = new WP_Query( $args );

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
		    <p style="color:#274abb"><a href="<?= site_url() . '/admin/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To DashBoard</a></p>
			<div class="dashboard-main--cont">

				<div class="admin-advanced-searchfilter">
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
								
								<div class="row with-forms">
									<div class="col-md-4">
										<input type="text" placeholder="Enter Location" value="" name="property_location"/>
									</div>
									<div class="col-md-4">
										<select data-placeholder="Any Status" class="chosen-select-no-single" name="property_lang" >
											<option value="">Select Language</option>	
											<option value="English">English</option>
											<option value="Spanish">Spanish</option>
											<option value="">Any</option>
										</select>
									</div>
									<div class="col-md-4">
										<select data-placeholder="Any Status" class="chosen-select-no-single" name="property_gender" >
											<option value="">Select Gender</option>	
											<option value="Female">Female</option>
											<option value="Male">Male</option>
											<option value="">Any</option>
										</select>
									</div>
									<div class="col-md-4">
										<select data-placeholder="Any Status" class="chosen-select-no-single" name="property_Act_inact" >
											<option value="">Filter By Status</option>
                                            <option value="approved">Approved</option>
                                            <option value="unapproved">Unapproved</option>											
											<option value="1">Active</option>
											<option value="2">Inactive</option>
										</select>
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
                 <div class="col-md-12">
					 <p class="showing-results"><?= $properties->found_posts; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $properties->max_num_pages;?> </p>
				 </div>

				<table class="manage-table responsive-table all_properties_table">
				<tbody>
				<tr>
				    <th style="width: 8%"><input type="checkbox" class="checkallproperties"></th>
					<th style="width: 50%"><i class="fa fa-file-text"></i> Property</th>
					<th style="width: 25%"><i class="fa fa-user"></i> Owner</th>
					<th style="width: 18%"><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>

				<!-- Item #1 --><?php
					
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
							$status =  get_post_status();
							if(!$prop_image){
							   $prop_image = wp_get_attachment_url(get_post_meta($post_id, 'file_1',true));
							}
							$document_files = explode(',',get_post_meta($post_id, 'document_files',true));
							$property_inactive = get_post_meta($post_id,'prop_active_inactive',true);
							
				?>
					
				<tr>
				    <td><input type="checkbox" class="checkproperties" value="<?= $post_id ?>"></td>
					<td class="title-container">
						<img src="<?php if($prop_image){ echo $prop_image; } ?>" alt="">
						<div class="title">
							<h4><a href="<?= ($status == 'draft') ? get_post_permalink( get_the_ID()).'&prpage=admin-properties' : get_post_permalink( get_the_ID()).'?prpage=admin-properties' ?>"><?php echo get_the_title($post_id); ?></a></h4>
							<span><?php echo $address;?> </span>
							<span class="table-property-price"><?php echo $price . '$ / Week' ;?></span> <span class="active--property"><?php echo ucfirst($status);?></span>
							<span class="active--property"><?php echo ($property_inactive == 1) ? 'Active' : 'Inactive';?></span>
							<?php 
							if($document_files){
								echo "</br></br>";
								echo "<span>Document Files </span>";
								foreach($document_files as $file){
										$attc_id = get_post_meta($post_id,$file,true);
										$checkattachment = wp_get_attachment_link($attc_id);
										if($checkattachment == 'Missing Attachment'){
										   echo "No Files Attachment";
										} else {
										   echo $checkattachment;
										}
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
					      <?php if($status == 'draft'){ ?>
					      <a href="<?= get_post_permalink( get_the_ID()).'&prpage=admin-properties'  ?> "><i class="fa fa-eye"></i> View</a>
						  <?php
						   } else {
						   ?>
						  <a href="<?= get_post_permalink( get_the_ID()).'?prpage=admin-properties'  ?> "><i class="fa fa-eye"></i> View</a> 
						<?php
						}
						if($property_inactive == 1){
						?>
						<a style="cursor:pointer;" class="deactvate_prperty" data-id="<?php echo $post_id; ?>" ><i class="fa fa-key"></i>Inactivate</a>
						<?php
						} else {
						?>
						<a style="cursor:pointer;" class="actvate_prperty" data-id="<?php echo $post_id; ?>" ><i class="fa fa-eye-slash"></i>Activate</a>
						<?php
						}
						?>						
						<a href= "<?php echo get_site_url();?>/edit-property-admin/?prpage=admin-properties&&pid=<?php echo $post_id ;?>"><i class="fa fa-pencil"></i> Edit</a>
						<a style="cursor:pointer;" class="delete_admin_property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
						<?php if($status == 'draft') { ?>
						   <button class="button approve_property" data-id="<?php echo $post_id; ?>">Approve</button>
						<?php 
						} else if($status == 'available' or $status == 'rented'){
						?>
						   <button class="button unapprove_property" data-id="<?php echo $post_id; ?>">UnApprove</button>
						<?php
						}
						?>
						
						
					</td>
				</tr>
<?php 
						}
					}
					else{
					    echo "<tr class='nyc-no-properties'><td class='no_property_found' colspan='4'>No Properties Found !</td></tr>";
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
								<?php 
									echo paginate_links( array(
											'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
											'total'        => $properties->max_num_pages,
											'current'      => max( 1, get_query_var( 'paged' ) ),
											'format'       => '?paged=%#%',
											'show_all'     => false,
											'type'         => 'list',
											'end_size'     => 2,
											'mid_size'     => 1,
											'prev_next'    => false,
											'add_args'     => false,
											'add_fragment' => '',
										) );
                              ?>
							</nav>

							<nav class="pagination-next-prev">
								<ul>
									<li class="prev"><?php previous_posts_link( 'Previous',$properties->max_num_pages ); ?></li>
									<li class="next"><?php next_posts_link( 'Next', $properties->max_num_pages);  ?></li>
								</ul>
							</nav>
						</div>

					</div>
				</div>
				<!-- Pagination Container / End -->
				
				<div class="admin-advanced-searchfilter">
			        <label>Select bulk action</label>
                  <div class="bulk_actions_properties">
						<select class="select_action_properties">
							 <option value="-1">Bulk Actions</option>
							 <option value="approve">Approve</option>
							 <option value="unapprove">UnApprove</option>
							 <option value="activate">Activate</option>
							 <option value="deactivate">Inactive</option>						 
							 <option value="delete">Delete</option>
						</select>
                    <input type="button" value="Apply" class="apply_action_properties">
                 </div>
                </div>
				

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

<!-- Modal -->
  <div class="modal fade" id="Modaldelete" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Properties Deleted Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal Activate Property -->
  <div class="modal fade" id="Modalactivate" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Properties Activated Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <!-- Modal Dectivate Property -->
  <div class="modal fade" id="Modaldeactivate" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Properties Inactived Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--------- Approved Property Modal ----------->
  <div class="modal fade" id="ModalApproveProp" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Properties Approved Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <!--------- UnApproved Property Modal ----------->
  <div class="modal fade" id="ModalUnApproveProp" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Properties UnApproved Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
  

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
.bulk_actions_properties {
    display: flex;
}
select.select_action_properties {
    width: 30%;
}
input.apply_action_properties {
    width: 30%;
    margin-left: 5%;
    padding: 0;
}
</style>
<script>
jQuery(document).ready(function($) {
	jQuery('.admin-propertieslistings').addClass('show--submenu');
	jQuery('#sidebar-all_propert').addClass('current');
});
</script>
</div>
<!-- Wrapper / End -->
<?php
get_footer();
?>