<?php
nyc_property_admin_authority();
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
'post_type'=> 'deals',
'post_status' => array('publish'),
'posts_per_page'   => -1,
'suppress_filters' => false,
'paged' => $paged
);
$meta_query = array();
if(isset($_GET['deal_stage']) && !empty($_GET['deal_stage'])){
	$meta_query[] =  array(
            'key'          => 'deal_stage',
            'value'        => $_GET['deal_stage'],
            'compare'      => '=',
    );	
}
if(isset($_GET['deal_name']) && !empty($_GET['deal_name'])){
	$meta_query[] =  array(
            'key'          => 'name',
            'value'        => $_GET['deal_name'],
            'compare'      => 'REGEXP',
    );	
}
if(isset($_GET['deal_email']) && !empty($_GET['deal_email'])){
	$meta_query[] =  array(
            'key'          => 'email',
            'value'        => $_GET['deal_email'],
            'compare'      => 'REGEXP',
    );	
}
if(isset($_GET['deal_no']) && !empty($_GET['deal_no'])){
	$args['post__in'] =  array($_GET['deal_no']);
}
if(!empty($meta_query)){
   $args['meta_query'] = $meta_query;
} 
$deals = new WP_Query( $args );
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
.deal_bulk_actions {
    display: flex;
}
select.select_action {
    width: 30%;
}
input.deal_apply_action {
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
		<?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">

				<div class="admin-advanced-searchfilter">
					<h2>Deals Filter</h2>
					<form>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-6">
									<input type="text" placeholder="Enter Deal Number" name="deal_no" value=""/>
								</div>
								<div class="col-md-6">
									<input type="text" placeholder="Enter Name" name="deal_name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<input type="text" placeholder="Enter Email" name="deal_email" value=""/>
								</div>
								<div class="col-md-6">
									<select data-placeholder="Any Status" name="deal_stage" class="chosen-select-no-single" >
										<option value="">Select Stage</option>	
										<option value="1">Stage 1</option>
										<option value="2">Stage 2</option>
										<option value="3">Stage 3</option>
									</select>
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
                 <div class="col-md-12">
					 <p class="showing-results"><?php echo $deals->found_posts; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $deals->max_num_pages;?> </p>
				 </div>
				 
				<table class="manage-table responsive-table deal--table">
				<tbody>
				<tr>
					<th><input type="checkbox" class="checkallbulk"></th>
					<th><i class="fa fa-list-ol"></i> Deal No</th>
					<th><i class="fa fa-user"></i>Name</th>
					<th><i class="fa fa-envelope"></i> Email</th>
					<th><i class="fa fa-phone" ></i> Phone</th>
					<th><i class="fa fa-check-square-o" ></i> Source</th>
					<th class="expire-date"><i class="fa fa-bars" aria-hidden="true"></i> Stage</th>
					<th></th>
				</tr>

				<?php 
				if($deals->have_posts()){
					while ( $deals->have_posts() ) {
						$deals->the_post();
						$deal_id = get_the_ID();
						$deal_stage =  get_post_meta($deal_id,'deal_stage',true); 
					?>
						<tr class="deal__stage-one deal-id-<?php echo $deal_id; ?>">
							<td><input type="checkbox" class="checkbulk" value="<?php echo $deal_id; ?>" ></td>
							<td class="deal_number"><?php echo $deal_id; ?></td>
							<td class="deal-member-name"><?php echo get_post_meta($deal_id,'name',true); ?></td>
							<td class="deal-email-address"><?php echo get_post_meta($deal_id,'email',true); ?></td>
							<td class="deal-phone-number"><?php echo get_post_meta($deal_id,'phone',true); ?></td>
							<td class="deal-phone-number"><?php echo get_post_meta($deal_id,'lead_source',true); ?></td>
							<td class="deal-stage-number"><?php echo 'Stage '.$deal_stage; ?></td>
							<td class="action">
								<a href="<?php echo get_site_url(); ?>/admin/deals/details/<?php echo $deal_id; ?>"><i class="fa fa-eye"></i> View</a>
								<a href="#" class="delete delete-deal" data-id="<?php echo $deal_id; ?>"><i class="fa fa-remove"></i> Delete</a>
								<a href="#" class="deal__link"><i class="fa fa-clone"></i> Deal Link</a>
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
				<div>
			        <label>Select bulk action</label>
                  <div class="deal_bulk_actions">
						<select class="select_action">
						 <option value="-1">Bulk Actions</option>
						 <option value="delete">Delete</option>
						</select>
                    <input type="button" value="Apply" class="deal_apply_action">
                 </div>
                </div>
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
										'total'  	=> $deals->max_num_pages,
										'prev_next'	=> false,
										'type' 		=> 'list',											
										) );
                              ?>
							 </ul>
							</nav>

							<nav class="pagination-next-prev">
								<ul>
									<li><?php previous_posts_link( 'Previous',$deals->max_num_pages ); ?></li>
									<li><?php next_posts_link( 'Next', $deals->max_num_pages);  ?></li>
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
jQuery('.delete-deal').click(function (e) {
	e.preventDefault();
	// escape here if the confirm is false;
	if (!confirm('Are you sure?')) return false;
	var deal_id=jQuery(this).attr('data-id');
	var form_data = new FormData();	
	form_data.append("deal_id", deal_id);
	form_data.append( "action", 'nyc_delete_deal_ajax');   
	jQuery.ajax({
		type : "post",
		url : my_ajax_object.ajax_url,
		data: form_data,
		processData: false,
		contentType: false,
		success: function(response) {
			if(response == "success"){
			var delete_tr= ".deal-id-"+deal_id;
			jQuery(delete_tr).fadeOut();	
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