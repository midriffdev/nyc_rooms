<?php 
/*
Template Name: Admin Approved Properties
*/
nyc_property_admin_authority();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
         'post_type'        => 'property',
		 'post_status'       => array('available','rented'),
         //'no_found_rows'    => true,
         'suppress_filters' => false,
		 'orderby'          => 'post_date',
         'order'            => 'DESC',
		 'numberposts'      => -1,
		 'posts_per_page'   => 6,
		 'paged' => $paged
		 
		 
        );
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
			<div class="dashboard-main--cont">
			
			    <div class="col-md-12">
					 <p class="showing-results"><?= $properties->found_posts; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $properties->max_num_pages;?> </p>
				 </div>

				<table class="manage-table responsive-table all_properties_table">
				<tbody>
				<tr>
				    <th><input type="checkbox" class="checkallproperties"></th>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th><i class="fa fa-user"></i> Owner</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
					<th></th>
				</tr>
				<?php 
				


//$properties = new WP_Query( $args );
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
							$document_files = explode(',',get_post_meta($post_id, 'document_files',true));
				?>
				<!-- Item #1 -->
				<tr>
				    <td><input type="checkbox" class="checkproperties" value="<?= $post_id ?>"></td>
					<td class="title-container">
						<img src="<?php if($prop_image){ echo $prop_image; } ?>"alt="">
						<div class="title">
							<h4><a href="<?= get_post_permalink( get_the_ID()) ?>"><?php echo get_the_title($post_id); ?></a></h4>
							<span><?php echo $address;?> </span>
							<span class="table-property-price"><?php echo $price . '$ / Week';?></span> <span class="rented--property recently_prop">Recently</span>
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
						<div class="owner--name"><a href="#"><?php echo $contact_name;?></a></div>
					</td>
					<td class="action">
						<a href="<?= get_post_permalink( get_the_ID()) ?>"><i class="fa fa-eye"></i> View</a>
						<a href="<?php echo site_url();?>/edit-property-admin/?pid=<?php echo $post_id ;?>"><i class="fa fa-pencil"></i> Edit</a>
						<a style="cursor:pointer;" class="delete_admin_property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
					<td class="recently-approved-btn">
				       <button class="unapprove_property" data-id="<?php echo $post_id; ?>">UnApprove</button>
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
				
				<div>
			        <label>Select bulk action</label>
                  <div class="bulk_actions_properties">
						<select class="select_action_properties">
							 <option value="-1">Bulk Actions</option>
							 <option value="delete">Delete</option>
							 <option value="unapprove">UnApprove</option>
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


</div>
<!-- Wrapper / End -->

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
<?php 
get_footer();
?>