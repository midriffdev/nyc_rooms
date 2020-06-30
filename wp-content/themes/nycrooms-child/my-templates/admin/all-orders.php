<?php
nyc_property_admin_authority();
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
'post_type'=> 'dealsorders',
'post_status' => array('publish'),
'posts_per_page'   => -1,
'suppress_filters' => false,
'paged' => $paged
);

$meta_query = array();
if(isset($_GET['search_order'])){
if(isset($_GET['deal_no']) && !empty($_GET['deal_no'])){
	$meta_query[] =  array(
            'key'          => 'deal_id',
            'value'        => $_GET['deal_no'],
            'compare'      => '=',
    );	
}
if(isset($_GET['order_no']) && !empty($_GET['order_no'])){
	$meta_query[] =  array(
            'key'          => 'order_id',
            'value'        => $_GET['order_no'],
            'compare'      => '=',
    );	
}
if(!empty($meta_query)){
   $args['meta_query'] = $meta_query;
}
}

$dealsorders = new WP_Query( $args );
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
.deal_bulk_actions_orders {
    display: flex;
}
select.select_action_orders {
    width: 30%;
}
input.deal_apply_action_orders {
    width: 30%;
    margin-left: 5%;
    padding: 0;
}
input.checkallbulkorders{
    height: 18px;
}
input.checkbulkorders{
    height: 18px;
    margin: 0 13px !important;
}
</style>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<div class="container">
	<div class="row">
		<?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">

				<div class="admin-advanced-searchfilter">
					<h2>Deals Filter</h2>
					<form method="get">
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-6">
									<input type="text" placeholder="Enter Order No." name="order_no" value=""/>
								</div>
								<div class="col-md-6">
									<input type="text" placeholder="Enter Deal Number" name="deal_no" value=""/>
								</div>
								
							</div>

							<!-- Search Button -->
							<div class="row with-forms">
								<div class="col-md-12">
									<button class="button fs-map-btn" type="submit" name="search_order">Search</button>
								</div>
							</div>

						</div>
						<!-- Box / End -->
					</div>
					</form>
				</div>
                 <div class="col-md-12">
					 <p class="showing-results"><?php echo $dealsorders->found_posts; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $dealsorders->max_num_pages;?> </p>
				 </div>
				 
				<table class="manage-table responsive-table deal--table">
				<tbody>
				<tr>
					<th><input type="checkbox" class="checkallbulkorders"></th>
					<th><i class="fa fa-list-ol"></i> Order No . </th>
					<th><i class="fa fa-user"></i>Deal No.</th>
					<th><i class="fa fa-envelope"></i> Payment Amount</th>
					<th><i class="fa fa-phone" ></i>Payment Mode</th>
					<th><i class="fa fa-phone" ></i>Payment Source</th>
					<th><i class="fa fa-check-square-o" ></i>Payment Status</th>
					<th></th>
				</tr>

				<?php 
				if($dealsorders->have_posts()){
					while ( $dealsorders->have_posts() ) {
						$dealsorders->the_post();
						$dealorders_id = get_the_ID();
					?>
						<tr class="deal__stage-one deal-order-id-<?php echo $dealorders_id; ?>">
							<td><input type="checkbox" class="checkbulkorders" value="<?php echo $dealorders_id; ?>" ></td>
							<td class="deal_order_number"><?php echo get_post_meta($dealorders_id,'order_id',true);; ?></td>
							<td class="deal_number"><?php echo get_post_meta($dealorders_id,'deal_id',true); ?></td>
							<td class="deal_phone_number"><?php echo "$".get_post_meta($dealorders_id,'payment_amount',true); "/Week" ?></td>
							<td class="deal_phone_number"><?php echo ucfirst(str_replace("_"," ",get_post_meta($dealorders_id,'payment_mode',true))); ?></td>
							<td class="deal-stage-number"><?php echo get_post_meta($dealorders_id,'payment_source_type',true); ?></td>
							<td class="deal-stage-number"><?php echo get_post_meta($dealorders_id,'payment_status',true); ?></td>
							<td class="action">
								<a href="<?php echo get_site_url(); ?>/admin/dealsorders/orderdetails/<?php echo $dealorders_id; ?>"><i class="fa fa-eye"></i> View</a>
								<a style="cursor:pointer;" class="delete delete-deal-order" data-id="<?php echo $dealorders_id; ?>"><i class="fa fa-remove"></i> Delete</a>
							</td>
						</tr>
					<?php 
					}
				}else{
					echo "<tr><td colspan='7'>No deals found!</td></tr>";
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
								<?php 
									echo paginate_links( array(
										'base' 		=> get_pagenum_link(1) . '%_%',
										'format' 	=> 'page/%#%/',
										'current' 	=> max( 1, get_query_var( 'paged' ) ),
										'total'  	=> $dealsorders->max_num_pages,
										'prev_next'	=> false,
										'type' 		=> 'list',											
										) );
                              ?>
							 </ul>
							</nav>

							<nav class="pagination-next-prev">
								<ul>
									<li><?php previous_posts_link( 'Previous',$dealsorders->max_num_pages ); ?></li>
									<li><?php next_posts_link( 'Next', $dealsorders->max_num_pages);  ?></li>
								</ul>
							</nav>
						</div>

					</div>
				</div>
				<!-- Pagination Container / End -->
				
				<div>
			        <label>Select bulk action</label>
                  <div class="deal_bulk_actions_orders">
						<select class="select_action_orders">
						 <option value="-1">Bulk Actions</option>
						 <option value="delete">Delete</option>
						</select>
                    <input type="button" value="Apply" class="deal_apply_action_orders">
                 </div>
                </div>

			</div>
		</div>

	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalUser" role="dialog">
	<div class="modal-dialog">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
		  <p></p>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  </div>
	  
	</div>
</div>
<div class="margin-top-55"></div>
</div>
<script>

jQuery('.delete-deal-order').click(function (e) {
	e.preventDefault();
	// escape here if the confirm is false;
	if (!confirm('Are you sure?')) return false;
	var deal_order_id=jQuery(this).attr('data-id');
	var form_data = new FormData();	
	form_data.append("deal_order_id", deal_order_id);
	form_data.append( "action", 'nyc_delete_deal_order_ajax');   
	jQuery.ajax({
		type : "post",
		url : my_ajax_object.ajax_url,
		data: form_data,
		processData: false,
		contentType: false,
		success: function(response) {
			if(response == "success"){
			var delete_tr= ".deal-order-id-"+deal_order_id;
			jQuery(delete_tr).fadeOut();
			$('#ModalUser .modal-body p').html('User Deleted Successfully');
			$('#ModalUser').modal('show');
			setTimeout(function(){
             window.location.reload();	
            }, 2000);			 
			}
		}
	});
});



jQuery(document).ready(function($) {
	jQuery('#sidebar-alldeals').addClass('current');
});
</script>
<?php 
get_footer();
?>