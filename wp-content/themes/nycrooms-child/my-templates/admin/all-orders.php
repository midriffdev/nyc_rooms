<?php
nyc_property_admin_authority();
global $wp;
global $wpdb;
if(isset($_GET['download-csv']) && $_GET['download-csv'] == 'true'){
	nyc_export_payments_as_CSV();	
}

$current_url = home_url( add_query_arg( array(), $wp->request ) );
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
'post_type'=> 'dealsorders',
'post_status' => array('publish'),
'posts_per_page'   => -1,
'suppress_filters' => false,
'orderby'          => 'ID',
'order'            => 'DESC',
'paged' => $paged
);

$date_query = array();
if(isset($_GET['search_payments_date'])){
	if(isset($_GET['search_by_date']) && !empty($_GET['search_by_date'])){
		 $date = explode('-',$_GET['search_by_date']);
		 $year =  (int)$date[0];
		 $month = (int)$date[1];
		 $day   = (int) $date[2];
		 $date_query[] =  array(
								'after' =>  array(
												 'year'  => $year,
												 'month' => $month,
												 'day'   => $day,
										   )
							   
						   );
					 
						  
	}

	 if(isset($_GET['search_to_date']) && !empty($_GET['search_to_date'])){
		 $dateto = explode('-',$_GET['search_to_date']);
		 $yearto =  (int) $dateto[0];
		 $monthto = (int) $dateto[1];
		 $dayto   = (int) $dateto[2];
		 $date_query[0]['before']  =    array(
												 'year'  => $yearto,
												 'month' => $monthto,
												 'day'   => $dayto,
										   );
								
										  
	 }

     $date_query[0]['inclusive'] = true;

}

if(isset($_GET['search_payments_month'])){
if(isset($_GET['search_by_month']) && !empty($_GET['search_by_month'])){
	 $month = (int) $_GET['search_by_month'];
	 $date_query[] =  array(
								'month' => $month		
					  );
				      
                 
      				  
}
}

if(isset($_GET['search_payments_year'])){
if(isset($_GET['search_by_year']) && !empty($_GET['search_by_year'])){
	 $year = (int) $_GET['search_by_year'];
	 $date_query[] =  array(
								'year' => $year		
					  );
				      
                 
      				  
}
}

if(isset($_GET['search_payments_week'])){

	if(isset($_GET['search_by_week']) && !empty($_GET['search_by_week'])){
		 $weekcheck =  $_GET['search_by_week'];
		 if($weekcheck == "current week"){
		   $date_query[] =  array(
									'year' => date( 'Y' ),
									'week' => date( 'W' )							
						    );
		 } 
		 
		 if($weekcheck == "previous week"){
		   $date_query[] =  array(
									'year' => date( 'Y' ),
									'week' => date('W',strtotime('-1 weeks'))						
						    );
							
		 } 
		 
		 
		 
	}
	
	
	
}



if(!empty($date_query)){
   $args['date_query'] = $date_query;
}

$dealsorders = new WP_Query( $args );
$years_query = "SELECT DISTINCT YEAR(post_date) FROM `nyc_posts` WHERE post_status = 'publish' AND `post_type` = 'dealsorders' ORDER BY post_date DESC";
$paymentsyears = $wpdb->get_col($years_query);
get_header();
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
</style>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<div class="container">
	<div class="row">
		<?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">
                   <p style="color:#274abb"><a href="<?= site_url().'/admin/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To DashBoard</a></p>
				<div class="admin-advanced-searchfilter">
					<h2>Payments Filter</h2>
					
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								
								    <div class="col-md-12">
									<form method="get" name="search_by_date">
									   <h4>Filter By Date:</h4>
									  <div style="display:flex">
									   <div class="fltr_dtes">
										   <h6>From Date:</h6>
										   <input type="date" placeholder="date from.." name="search_by_date" required/>
									   </div>
									   <div class="fltr_dtes">
										   <h6>To Date:</h6>
										   <input type="date" placeholder="date To" name="search_to_date"  />
									   </div>
									   
									   <button type="submit" name="search_payments_date" value="Search" class="button fltr_dte">filter</button>
									  </div>
									</form>
									</div>
									<div class="col-md-4">
									  <h4>Filter By Weekly:</h4>
									   <select name="weekly_payments">
									        <option value="">Select Option</option>
											<option value="current week">Current Week</option>
											<option value="previous week">Previous Week</option>
                                       </select>
								    </div>
						            <div class="col-md-4">
									  <h4>Filter By Month:</h4>
									   <select name="monthly_payments">
									        <option value="">Select Month</option>
											<option value="1">January</option>
											<option value="2">February</option>
											<option value="3">March</option>
											<option value="4">April</option>
											<option value="5">May</option>
											<option value="6">June</option>
											<option value="7">July</option>
											<option value="8">August</option>
											<option value="9">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>
								    </div>
									<div class="col-md-4">
									  <h4>Filter By Year:</h4>
									   <select name="yearly_payments">
									       <option value="">Select Year</option>
									       <?php foreach($paymentsyears as $yearlypayments ){ ?>
											<option value="<?= $yearlypayments ?>"><?= $yearlypayments ?></option>
										   <?php } ?>
									   </select>
								    </div>
									<div class="col-md-12" >
									<h4>Reset Filters:</h4>
									<button type="button" class="button reset_filter" >Reset Filters</button>
									</div>
							</div>
						</div>
						<!-- Box / End -->
					</div>
					
				</div>
                 <div class="col-md-10">
					 <p class="showing-results"><?php echo $dealsorders->found_posts; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $dealsorders->max_num_pages;?> </p>
				 </div>
				 <div class="col-md-2 mx-auto">
					 <p class="showing-results"><?php if($dealsorders->found_posts > 0){ echo '<a href="'.$current_url.'/?download-csv=true">Download CSV</a>'; } ?></p>
				</div>

				<div class="table-wrapper_section">
				<table class="manage-table responsive-table deal--table">
				<tbody>
				<tr>
					<th><input type="checkbox" class="checkallbulkorders"></th>
					<th>Invoice No</th>
					<th>Deal No</th>
					<th>Payment Amount</th>
					<th>Payment By</th>
					<th>Agent Involved</th>
					<th>Payment Date</th>
					<th>Collection Method</th>
					<th>Payment Status</th>
					
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
							<td class="deal_invoice_number"><?php echo get_post_meta($dealorders_id,'invoice_id',true);; ?></td>
							<td class="deal_number"><?php echo get_post_meta($dealorders_id,'deal_id',true); ?></td>
							<td class="deal_payment_amount"><?php echo "$".get_post_meta($dealorders_id,'payment_amount',true)."/week"; ?></td>
							<td class="deal_payment_by"><?php  echo get_post_meta($dealorders_id,'name_teanant',true); ?></td>
							<td class="deal_agent_involved"><?php   
							$checkagent = get_post_meta($dealorders_id,'agent_involved',true); 
							if($checkagent){
							   echo get_post_meta($dealorders_id,'agent_name',true);
							} else {
							   echo "N . A";
							}
							
							?></td>
							
							<td class="deal_date_time"><?php echo date("d-m-Y",strtotime(get_post_meta($dealorders_id,'payment_created_at',true))); ?></td>
							<td class="deal_phone_number"><?php 
							$payment_mode =  get_post_meta($dealorders_id,'payment_mode',true); 
							if($payment_mode == 'square_payment'){
							    echo "Online";
							} else {
							   echo "Offline";
							}
							
							?></td>
							<td class="deal-stage-number"><?php echo get_post_meta($dealorders_id,'payment_status',true); ?></td>
							<td class="action">
								<a href="<?php echo get_site_url(); ?>/admin/dealsorders/orderdetails/<?php echo $dealorders_id; ?>"><i class="fa fa-eye"></i> View</a>
								<a style="cursor:pointer;" class="delete delete-deal-order" data-id="<?php echo $dealorders_id; ?>"><i class="fa fa-remove"></i> Delete</a>
							</td>
						</tr>
					<?php 
					}
				}else{
					echo "<tr><td class='no_property_found' colspan='10'>No Orders found!</td></tr>";
				}
				?>
				</tbody>
				</table>
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
				
				<div class="admin-advanced-searchfilter">
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
<style>
button.button.fltr_dte {
    padding: 0px 10%;
    height: 50px;
    margin-top: 4%;
}

.fltr_dtes{
   width: 35%;
   margin-right: 5%;
}

</style>
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
    var site_url = "<?= site_url(); ?>";
	jQuery('#sidebar-allorders').addClass('current');
	$('select[name="monthly_payments"]').change(function(){
	     var monthval = $(this).val();
		  if(monthval != ''){
			  var url  = site_url + "/admin/dealsorders/?search_by_month="+ monthval +"&&search_payments_month=Monthly Payments";
			  window.location.href = url;
		  }
	});
	
	$('select[name="yearly_payments"]').change(function(){
	     var yearval = $(this).val();
		 if(monthval != ''){
			  var url  = site_url + "/admin/dealsorders/?search_by_year="+ yearval +"&&search_payments_year=Yearly Payments";
			  window.location.href = url;
		 }
	});
	
	$('select[name="weekly_payments"]').change(function(){
	     var weakval = $(this).val();
		 if(weakval != ''){
		   var url  = site_url + "/admin/dealsorders/?search_by_week="+ weakval +"&&search_payments_week=Weekly Payments";
		   window.location.href = url;
		 }
	});
	
	
	
	
	
	$('.button.reset_filter').click(function(){
		  var url  = site_url + "/admin/dealsorders/";
		  window.location.href = url;
	});
	
});

</script>
<?php 
get_footer();
?>