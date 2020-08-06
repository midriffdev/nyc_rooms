<?php
/* Template Name: All Leads */
$argarray = array();
if(isset($_GET['search_leadsall'])){

    $argarray =  array(
								//comparison between the inner meta fields conditionals
								'relation'    => 'AND',
								array(
										'key'          => 'lead_checkout_property_name',
										'value'        => $_GET['property_name'],
										'compare'      => 'LIKE',
                                 ),
								//meta field condition one
								array(
									'key'          => 'lead_name',
									'value'        => $_GET['property_owner_name'],
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								),
								array(
									'key'          => 'lead_email',
									'value'        => $_GET['property_owner_email'] ,
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								)
		
                    ); 
 
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
         'post_type'        => 'leads',
		 'numberposts'      => 1,
		 'post_status'       => 'publish',
         'posts_per_page'   => 6,
         //'no_found_rows'    => true,
         'suppress_filters' => false,
		 'orderby'          => 'post_date',
         'order'            => 'DESC',
		 'paged' => $paged

        );
		
if(!empty($argarray)){
   $args['meta_query'] = $argarray; 
}
		
$all_leads = new WP_Query( $args );

get_header();
?>

<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<!-- Titlebar
================================================== -->



<!-- Content
================================================== -->
<div class="container">
	<div class="row">


		<?php include(locate_template('sidebar/admin-sidebar.php')); ?>

		<div class="col-md-9">
			<div class="dashboard-main--cont">
                 <p style="color:#274abb"><a href="<?= site_url().'/admin/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To DashBoard</a></p>
				<div class="admin-advanced-searchfilter">
					<h2>Property Lead Filter</h2>
				<form method="get" name="search_leads">
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Property Name"  name="property_name"/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<input type="text" placeholder="Enter Name" name="property_owner_name" />
								</div>
								<div class="col-md-6">
									<input type="email" id="email" name="property_owner_email" placeholder="Enter Email">
								</div>
							</div>
							<!-- Row With Forms / End -->	

							<!-- Search Button -->
							<div class="row with-forms">
								<div class="col-md-12">
									<button class="button fs-map-btn" type="submit" name="search_leadsall">Search</button>
								</div>
							</div>

						</div>
						<!-- Box / End -->
					</div>
					</form>
				</div>
                 <div class="col-md-12">
					 <p class="showing-results"><?= $all_leads->found_posts; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $all_leads->max_num_pages;?> </p>
				 </div>
					
				<table class="manage-table responsive-table all_leads_table">
				<tbody>
				<tr>
				    <th><input type="checkbox" class="checkallleads"></th>
					<th> Lead No</th>
					<th>Name</th>
					<th> Phone</th>
					<th class="expire-date">Email</th>
					<th> Lead Source</th>
					<th>Action</th>
				</tr>
                 
				 
				 <?php
				 if ( $all_leads->have_posts() ) { 

                 while ( $all_leads->have_posts() ) { 
                      $all_leads->the_post();
						 $checkdeal   = get_post_meta(get_the_ID(),'is_deal_created',true);
					     $checkdealid = get_post_meta(get_the_ID(),'deal_id',true);	
                    ?> 
					<tr>
						<td>
						<input type="checkbox" class="checkleads" value="<?= get_the_ID() ?>" <?php if($checkdeal && $checkdealid){ ?> disabled <?php } ?> >
						
						</td>
						<td class="lead_number">#<?= get_the_ID() ?></td>
						<td><div class="Lead--name"><a href="<?= get_post_permalink(get_the_ID()) ?>"><?= get_post_meta(get_the_ID(),'lead_name',true); ?></a></div></td>
						<td class="lead-phone"><?= get_post_meta(get_the_ID(),'lead_phone',true); ?></td>
						<td class="lead-email-address"><?= get_post_meta(get_the_ID(),'lead_email',true); ?></td>
						<td><?= get_post_meta(get_the_ID(),'lead_source',true); ?></td>
						<td class="action">
							<a href="<?= get_post_permalink(get_the_ID()).'?prpage=all-leads' ?>"><i class="fa fa-eye"></i> View</a>
							<a class="delete" data-id="<?= get_the_ID() ?>" style="cursor:pointer;"><i class="fa fa-remove"></i> Delete</a>
							<?php 
							   if($checkdeal && $checkdealid){
							?>
							   <a class="deal--done" disabled><i class="fa fa-check-square-o" aria-hidden="true"></i> Deal Created</a>
							<?php
							 } else {
							?>
							   <a style="cursor:pointer;" class="into--deal" data-id="<?= get_the_ID() ?>"><i class="fa fa-share" aria-hidden="true"></i> Into Deal</a>
							<?php
							}
							?>
						</td>
				    </tr>
					
					<?php  } 

               } else { 
						echo "<tr class='nyc-no-properties'><td class='no_property_found' colspan='7'>No Leads Found !</td></tr>";
			   } ?> 

                <?php 
				wp_reset_query();
                 ?> 
				 
				<!-- Item #1 -->
				

				</tbody>
				</table>
				<div class="row fs-listings">
						<div class="col-md-12">

							<!-- Pagination -->
							<div class="clearfix"></div>
							<div class="pagination-container margin-top-10 margin-bottom-45">
								<nav class="pagination">
									<?php 
											echo paginate_links( array(
													'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
													'total'        => $all_leads->max_num_pages,
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
										<li class="prev"><!--a href="#" class="prev">Previous</a--> <?php previous_posts_link( 'Previous',$all_leads->max_num_pages ); ?> </li>
										<li class="next"><!--a href="#" class="next">Next</a--> <?php next_posts_link( 'Next', $all_leads->max_num_pages);  ?> </li>
									</ul>
								</nav>
							</div>

						</div>
			    </div>
			    <div class="admin-advanced-searchfilter">
			        <label>Select bulk action</label>
                  <div class="bulk_actions_leads">
						<select class="select_action_leads">
							 <option value="-1">Bulk Actions</option>
							 <option value="intodeal">Into Deal</option>
							 <option value="delete">Delete</option>
						</select>
                    <input type="button" value="Apply" class="apply_action_leads">
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

 <!-- Modal -->
  <div class="modal fade" id="Modaldelete" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Leads Deleted Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <!-- Modal -->
  <div class="modal fade" id="ModalDeals" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Deals Created Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  

<!-- Scripts
================================================== -->


</div>
<!-- Wrapper / End -->

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

.bulk_actions_leads {
    display: flex;
}
select.select_action_leads {
    width: 30%;
}
input.apply_action_leads {
    width: 30%;
    margin-left: 5%;
    padding: 0;
}
</style>
<script>
jQuery(document).ready(function($) {
	jQuery('#sidebar-allleads').addClass('current');
});
</script>
<?php
get_footer();