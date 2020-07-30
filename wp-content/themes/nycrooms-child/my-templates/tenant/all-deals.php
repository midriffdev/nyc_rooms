<?php
nyc_tenant_check_authentication();
get_header();
$current_user = wp_get_current_user();
$user_email = $current_user->user_email;
global $paged;
$paged = (get_query_var('id')) ? get_query_var('id') : 1;
$args = array(
	'post_type'=> 'deals',
	'post_status' => array('publish'),
	'posts_per_page'   => 6,
	'suppress_filters' => false,
	'paged' => $paged
);
$meta_query = array();
$meta_query[] =  array(
		'key'          => 'email',
		'value'        => $user_email,
		'compare'      => 'LIKE',
);	
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
if(isset($_GET['deal_name']) && !empty($_GET['deal_name'])){
	$meta_query[] =  array(
            'key'          => 'name',
            'value'        => $_GET['deal_name'],
            'compare'      => 'REGEXP',
    );	
}

if(isset($_GET['deal_no']) && !empty($_GET['deal_no'])){
	$args['post__in'] =  array($_GET['deal_no']);
}
if(!empty($meta_query)){
   $args['meta_query'] = $meta_query;
} 
if(isset($date_query) && !empty($date_query)){
	$args['date_query'] = $date_query;
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
    height: 13px;
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
									<input type="text" id="date-picker-from" placeholder="Date Range" name="date_range" readonly="readonly">								
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
				<div >
				<table class="manage-table responsive-table deal--table tenant-alldeals_table">
				
				<tbody>
				<tr>
					<th><input type="checkbox" class="checkallbulk"></th>
					<th>Deal No</th>
					<th>Tenant Name</th>
					<th>Phone</th>
					<th>Source</th>
					<th>Date</th>
					<th>Application Status</th>
					<th>Invoice Status</th>
					<th>Attachments</th>
					<th>View</th>
				</tr>

				<?php 
				if($deals->have_posts()){
					while ( $deals->have_posts() ) {
						$deals->the_post();
						$deal_id = get_the_ID();
						$deal_stage =  get_post_meta($deal_id,'deal_stage',true); 
						$document_files = explode(',',get_post_meta($deal_id, 'tenant_docs_all',true));
						$application_form =  get_post_meta($deal_id, 'application_doc',true);
						$invoice =  get_post_meta($deal_id, 'payment_invoice_doc',true);
						
					?>
						<tr class="deal-id-<?php echo $deal_id; ?>">
							<td><input type="checkbox" class="checkbulk" value="<?php echo $deal_id; ?>" ></td>
							<td class="deal_number"><?php echo $deal_id; ?></td>
							<td class="deal-member-name"><?php echo get_post_meta($deal_id,'name',true); ?></td>
							<td class="deal-phone-number"><?php echo get_post_meta($deal_id,'phone',true); ?></td>
							<td class="deal-phone-number"><?php echo get_post_meta($deal_id,'lead_source',true); ?></td>
							<td class="deal-phone-number"><?php echo get_the_date( 'Y-m-d' ); ?></td>
							<td class="deal-phone-number"><?php 
							if(!$application_form){
							?>
							 <button style="background:#a1b789;padding: 14px 15px;color:#fff">Pending</button>    
							<?php
                            } else {
							  $application_form_attch = wp_get_attachment_link($application_form);
							?>
							 <a class="deal-send-button deal-send-text dealdetail_view" href="<?php echo $application_form_attch; ?>" target="_blank">Complete &nbsp;<i class="fa fa-eye" aria-hidden="true"></i></a>
							<?php
							}
							?>
							
							</td>
							<td class="deal-phone-number">
							<?php 
                            if(!$invoice){
							?>
							 <button style="background:#a1b789;padding: 14px 15px;color:#fff">Pending</button>  
							 <?php
                            } else {
							   $invoice_attch = wp_get_attachment_link($invoice);
							?>
							<a class="deal-send-button deal-send-text dealdetail_view" href="<?php echo $invoice_attch; ?>" target="_blank">Complete &nbsp;<i class="fa fa-eye" aria-hidden="true"></i></a>
							<?php
							}
							?>
							
							</td>
							<td class="deal-phone-number">
							<?php 
							if($document_files){
								echo "</br></br>";
								echo "<span>Document Files </span>";
								foreach($document_files as $file){
										$attc_id = get_post_meta($deal_id,$file,true);
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
							
							</td>
							<td>
							<a href="<?php echo get_site_url(); ?>/tenant/deal-details-tenant/<?php echo base64_encode($deal_id); ?>"><i class="fa fa-eye"></i></a>
							</td>
						</tr>
					<?php 
					}
				}else{
					echo "<tr><td colspan='7' class='no_property_found'>No Deal found !</td></tr>";
				}
				?>
				</tbody>
				</table>
				</div>
				<div class="admin-advanced-searchfilter new_margin">
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
										'current' 	=> max( 1, get_query_var( 'id' ) ),
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
	$('.deal__link').click(function (e) {
			   e.preventDefault();
			   var copyText = $(this).attr('href');

			   document.addEventListener('copy', function(e) {
				  e.clipboardData.setData('text/plain', copyText);
				  e.preventDefault();
			   }, true);

			   document.execCommand('copy');  
			   console.log('copied text : ', copyText);
			   alert('copied text: ' + copyText); 
    });

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