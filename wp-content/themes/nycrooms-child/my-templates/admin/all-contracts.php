<?php
nyc_property_admin_authority();
get_header();
global $paged;
$paged = (get_query_var('id')) ? get_query_var('id') : 1;
$args = array(
'post_type'=> 'contracts',
'post_status' => array('publish'),
'posts_per_page'   => 6,
'suppress_filters' => false,
'paged' => $paged
);
$meta_query = array();

if(isset($_GET['date_range']) && !empty($_GET['date_range'])){
	$date = explode('-',$_GET['date_range']);
	$start_date =  date('Y-m-d',strtotime($date['0']));
	$end_date = date('Y-m-d',strtotime($date['1']));
	$date_query = array(
	'after' => $start_date,
	'before' => $end_date,
	'inclusive' => true,
	);	

}
if(isset($_GET['deal_no']) && !empty($_GET['deal_no'])){
	$meta_query[] =  array(
            'key'          => 'deal_id',
            'value'        => $_GET['deal_no'],
            'compare'      => 'REGEXP',
    );	
}

if(isset($_GET['contract_no']) && !empty($_GET['contract_no'])){
	$args['post__in'] =  array($_GET['contract_no']);
}
if(!empty($meta_query)){
   $args['meta_query'] = $meta_query;
} 
if(isset($date_query) && !empty($date_query)){
	$args['date_query'] = $date_query;
}
$contracts = new WP_Query( $args );
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
		<?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">

				<div class="admin-advanced-searchfilter">
					<h2>Contract Filter</h2>
					<form>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-6">
									<input type="text" placeholder="Contract Number" name="contract_no" value=""/>
								</div>
								<div class="col-md-6">
									<input type="text" id="date-picker-from" placeholder="Date Range" name="date_range" readonly="readonly">								
								</div>
							</div>	
							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<input type="text" placeholder="Deal No" name="deal_no" value=""/>
								</div>
							</div>
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
					 <p class="showing-results"><?php echo $contracts->found_posts; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $contracts->max_num_pages;?> </p>
				 </div>
				 <div style="overflow-x:auto !important;width:100%">
				<table class="manage-table responsive-table deal--table">
				<tbody>
				<tr>
					<th style="width: 3% "><input type="checkbox" class="checkallbulk"></th>
					<th style="width: 13% "><i class="fa fa-list-ol"></i> Contract ID</th>
					<th style="width: 10% "><i class="fa fa-list-ol"></i> Deal ID</th>
					<th style="width: 15% "><i class="fa fa-list-ol"></i> Tenant Name</th>
					<th style="width: 15% "><i class="fa fa-list-ol"></i> Tenant Email</th>
					<th style="width: 15% "><i class="fa fa-list-ol"></i> Owner Email</th>
					<th style="width: 19% "><i class="fa fa-list-ol"></i> Contract PDF</th>
					<th style="width: 10% ">Action</th>
				</tr>

				<?php 
				if($contracts->have_posts()){
					while ( $contracts->have_posts() ) {
						$contracts->the_post();
						$contract_id = get_the_ID();
						$contract_data = get_post_meta($contract_id,'contract_data', true); 
						$contract_pdf_id = get_post_meta($contract_id,'contract_pdf', true); 
						$deal_id = get_post_meta($contract_id,'deal_id', true);
						$property_id = get_post_meta($deal_id,'property_id',true);
						$auth = get_post($property_id);
						$authid = $auth->post_author;						
					?>
						<tr class="deal__stage-one contract-id-<?php echo $contract_id; ?>">
							<td><input type="checkbox" class="checkbulk" value="<?php echo $contract_id; ?>" ></td>
							<td class="deal_number"><?php echo $contract_id; ?></td>
							<td class="deal_number"><?php echo $deal_id; ?></td>
							<td class="deal_number"><?php echo get_post_meta($deal_id,'name', true); ?></td>
							<td class="deal_number"><?php echo get_post_meta($deal_id,'email', true); ?></td>
							<td class="deal_number"><?php echo the_author_meta( 'user_email' , $authid ); ?></td>
							<td class="deal_number"><?php echo  '<a href="'.wp_get_attachment_url($contract_pdf_id).'" download>'.pathinfo(basename ( get_attached_file( $contract_pdf_id ) ),PATHINFO_FILENAME).'</a>'; ?></td>
							<td class="action">
								<a href="<?php echo get_site_url(); ?>/admin/all-contracts/view/<?php echo base64_encode($contract_id); ?>" ><i class="fa fa-eye"></i> View</a>
								<a href="#" class="delete delete-contract" data-id="<?php echo $contract_id; ?>"><i class="fa fa-remove"></i> Delete</a>					
							</td>
						</tr>
					<?php 
					}
				}else{
					echo "<tr><td colspan='7'>No Contracts Found!</td></tr>";
				}
				?>
				</tbody>
				</table></div>
				<div class="admin-advanced-searchfilter new_margin">
			        <label>Select bulk action</label>
                  <div class="contract_bulk_actions">
						<select class="select_action">
						 <option value="-1">Bulk Actions</option>
						 <option value="delete">Delete</option>
						</select>
                    <input type="button" value="Apply" class="contract_apply_action">
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
										'current' 	=> max( 1, get_query_var( 'id' ) ),
										'total'  	=> $contracts->max_num_pages,
										'prev_next'	=> false,
										'type' 		=> 'list',											
										) );
                              ?>
							 </ul>
							</nav>

							<nav class="pagination-next-prev">
								<ul>
									<li><?php previous_posts_link( 'Previous',$contracts->max_num_pages ); ?></li>
									<li><?php next_posts_link( 'Next', $contracts->max_num_pages);  ?></li>
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
jQuery('.delete-contract').click(function (e) {
	e.preventDefault();
	// escape here if the confirm is false;
	if (!confirm('Are you sure?')) return false;
	var deal_id=jQuery(this).attr('data-id');
	var form_data = new FormData();	
	form_data.append("deal_id", deal_id);
	form_data.append( "action", 'nyc_delete_single_contract');   
	jQuery.ajax({
		type : "post",
		url : my_ajax_object.ajax_url,
		data: form_data,
		processData: false,
		contentType: false,
		success: function(response) {
			if(response == "success"){
			var delete_tr= ".contract-id-"+deal_id;
			jQuery(delete_tr).fadeOut();	
			}
		}
	});
});
jQuery(document).ready(function($) {
	jQuery('#sidebar-allcontracts').addClass('current');
	jQuery('#date-picker-from').daterangepicker({
		autoUpdateInput: false,
			locale: {
			cancelLabel: 'Clear'
		}		
	});
	

	jQuery('#date-picker-from').on('show.daterangepicker', function(ev, picker) {
		jQuery('.daterangepicker').addClass('calendar-visible');
		jQuery('.daterangepicker').removeClass('calendar-hidden');
	});
	jQuery('#date-picker-from').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
	  });

	 jQuery('#date-picker-from').on('cancel.daterangepicker', function(ev, picker) {
		  $(this).val('');
	  });

});
</script>
<?php 
get_footer();
?>