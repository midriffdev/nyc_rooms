<?php 
if(isset($_GET['download-csv']) && $_GET['download-csv'] == 'true'){
	ob_end_clean();   
	nyc_export_as_CSV();	
}
if(isset($_GET['action-csv']) && $_GET['action-csv'] != ''){
	ob_end_clean();   
	nyc_export_as_CSV($_GET['action-csv']);	
}
global $wp;
$current_url = home_url( add_query_arg( array(), $wp->request ) );
nyc_property_admin_authority();
get_header();
$serachname = '';
$searchphone = '';
if(isset($_GET['tname'])){
$serachname = $_GET['tname'];
}
if(isset($_GET['phone'])){
$searchphone = $_GET['phone'];
}
$number   = 6;
$paged    = (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset   = ($paged - 1) * $number;
$countargs= array(
	'role'			=> 'tenant',
    'search'        => '*'.esc_attr($serachname).'*',
    'search_columns' => array(
        'user_login',
        'user_nicename',
        'user_email',
        'display_name',
    ),
	'orderby'=>'ID',
	'order'=>'DESC',
);
$args= array(
	'offset'     	=> $offset,
	'number'	  	=> $number,
	'role'			=> 'tenant',
    'search'        => '*'.esc_attr($serachname).'*',
    'search_columns' => array(
        'user_login',
        'user_nicename',
        'user_email',
        'display_name',
    ),
	'orderby'=>'ID',
	'order'=>'DESC',
);
if($searchphone){
	$countargs['meta_query']=array( array( 'key'   => 'user_phone', 'value' => $searchphone, 'compare' => 'LIKE' ) );
	$args['meta_query']=array( array( 'key'   => 'user_phone', 'value' => $searchphone, 'compare' => 'LIKE' )	);
}
$users    = get_users($countargs);
$query    = get_users($args);
$total_users = count($users);
$total_query = count($query);
$total_pages = ceil($total_users / $number);

?>
<!-- Wrapper -->
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
.users_bulk_actions {
    display: flex;
}
select.select_action {
    width: 30%;
}
input.user_apply_action {
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
<div id="wrapper" class="dashbaord__wrapper">
<div class="container">
	<div class="row">
       <?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">
			    <p style="color:#274abb"><a href="<?= site_url() . '/admin/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To DashBoard</a></p>
                <div class="admin-advanced-searchfilter">
					<h2>Tenant filter</h2>
					<form action='' >
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<input type="text" id="email" name="tname" placeholder="Enter Name or Email" value="<?php if(isset($serachname)) { echo $serachname; } ?>">
								</div>
								<div class="col-md-6">
									<input type="text" placeholder="Enter Phone" name="phone" value="<?php if(isset($searchphone)) { echo $searchphone; } ?>"/>
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
				<div class="col-md-10">
					 <p class="showing-results"><?php echo $total_query; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $total_pages;?> </p>
				</div>
				<div class="col-md-2 mx-auto">
					 <p class="showing-results"><?php if($total_query){ echo '<a href="'.$current_url.'/?download-csv=true">Download CSV</a>'; } ?></p>
				</div>
				<table class="manage-table responsive-table admin-teanent-maintable all_agents_table">
				<tbody>
				<tr>
					<th style="width:8%;"><input type="checkbox" class="checkallbulk"></th>
					<th><i class="fa fa-file-text"></i> Tenants</th>
					<th><i class="fa fa-envelope"></i> Email</th>
					<th><i class="fa fa-phone" ></i> Phone</th>
					<th style="width:15%;"><i class="fa fa-toggle-on" ></i>Status</th>
					<th style="width:15%;"><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>

				<!-- Item #1 -->
				<?php 
				if($query){
				foreach($query as $tenants){
				$user_id = $tenants->ID;
				$profile_image_id = get_user_meta($user_id,'profile_picture',true);
				if($profile_image_id){
					$image_url  =  wp_get_attachment_url($profile_image_id);
				}else{
					$image_url  =  get_stylesheet_directory_uri()."/images/placeholder-image-profile.png";
				}
				?>
				<tr class="tenant-id-<?php echo $user_id; ?>">
					<td><input type="checkbox" class="checkbulk" value="<?php echo $user_id; ?>" ></td>
					<td class="title-container teanent-title-container">
						<img src="<?php echo $image_url; ?>" alt="">
						<div class="title">
							<h4><a href="<?= site_url()?>/tenant-details/"><?php echo $tenants->data->display_name; ?></a></h4>
						</div>
					</td>
					<td class="teanent--username"><?php echo $tenants->data->user_email; ?></td>
					<td><div class="teanent-phone-no"><?php echo get_user_meta($user_id,'user_phone',true); ?></div></td>
					<td><div class="teanent-status"><?php
                         $checkstatus = get_user_meta($user_id,'user_status',true);
						 if(!$checkstatus){
						    echo "inactive";
						 } else if($checkstatus == 'inactive'){
						     echo $checkstatus;
                         }	else {
						     echo $checkstatus;
						 }
					
					
					?></div></td>					
					<td class="action">
					
					   <?php if(!$checkstatus){ ?>
					    <a style="cursor:pointer;" class="active active-tenant" data-id="<?php echo $user_id; ?>"><i class="fa fa-eye-slash"></i> Activate</a>
						<?php } else if($checkstatus == 'inactive'){
						?>
						    <a style="cursor:pointer;" class="active active-tenant" data-id="<?php echo $user_id; ?>"><i class="fa fa-eye-slash"></i> Activate</a>
						<?php
						  } else {?>
						     <a style="cursor:pointer;" class="inactive inactive-tenant" data-id="<?php echo $user_id; ?>"><i class="fa fa-key"></i> Inactivate</a>
						<?php } ?>
						
						<a href="<?= site_url()?>/admin/edit-profile/?prpage=all-tenants&&uid=<?php echo $user_id; ?>"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#" class="delete delete-tenant" data-id="<?php echo $user_id; ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
				<?php 
				} 
				}else{
				echo "<tr><td colspan='6' class='no_property_found'>No Tenant Found !</td></tr>";
				}
				?>
				</tbody>
				</table>
				
				<div class="admin-advanced-searchfilter">
			        <label>Select bulk action</label>
                  <div class="users_bulk_actions">
						<select class="select_action">
						 <option value="-1">Bulk Actions</option>
						 <option value="active">Active</option>
						 <option value="inactive">Inactive</option>
						 <option value="delete">Delete</option>
						 <option value="download-csv">Downlaod CSV</option>
						</select>
                    <input type="button" value="Apply" class="user_apply_action">
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
							if ($total_users > $total_query) { 
								$current_page = max(1, get_query_var('paged')); 
									  echo paginate_links(array(
										'base' 		=> get_pagenum_link(1) . '%_%',
										'format' 	=> 'page/%#%/',
										'current' 	=> $current_page,
										'total'  	=> $total_pages,
										'prev_next'	=> false,
										'type' 		=> 'list',
								));
							} 							
								?>
							</ul>
							</nav>

							<nav class="pagination-next-prev">
								<ul>
								<?php 
								if ( $prev_posts_link = get_previous_posts_link( __( 'Previous' ) ) ) : 
								  echo '<li>'.$prev_posts_link.'</li>';
								endif;
								if ( $next_posts_link = get_next_posts_link( 'Next',$total_pages  ) ) :
									echo '<li>'.$next_posts_link.'</li>';
								endif;
								?>
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
jQuery('.delete-tenant').click(function (e) {
	e.preventDefault();
	// escape here if the confirm is false;
	if (!confirm('Are you sure?')) return false;
	var tenant_id=jQuery(this).attr('data-id');
	var form_data = new FormData();	
	form_data.append("tenant_id", tenant_id);
	form_data.append( "action", 'nyc_delete_tenant_ac_ajax');   
	jQuery.ajax({
		type : "post",
		url : my_ajax_object.ajax_url,
		data: form_data,
		processData: false,
		contentType: false,
		success: function(response) {
			if(response == "success"){
			var delete_tr= ".tenant-id-"+tenant_id;
			jQuery(delete_tr).fadeOut();	
			}
		}
	});
});
jQuery(document).ready(function($) {
	jQuery('#sidebar-alltenant').addClass('current');
	
	jQuery('.active.active-tenant').click(function (e) {
	e.preventDefault();
	var checkedNum = jQuery(this).closest('tr').find('input[class="checkbulk"]:checked').length;
	if(checkedNum == 0){
		  alert('Please select this user to activate');
    } else {
			jQuery('.loading').show(); 
			var myarraytenant = new Array();
			var tenant_id = jQuery(this).attr('data-id');
			myarraytenant.push(tenant_id);
			
			var data = {
								'action': 'nyc_bulk_action_user',
								'data':   myarraytenant,
								'bulkaction':'active',						
					};
					// We can also pass the url value separately from ajaxurl for front end AJAX implementations
					jQuery.post(my_ajax_object.ajax_url, data, function(response) {			  
						if(response == "true"){
							jQuery('.loading').hide(); 
							$('#ModalUser .modal-body p').html('User Active Successfully');
							$('#ModalUser').modal('show');
							setTimeout(function(){
							   window.location.reload();
							   // or window.location = window.location.href; 
							}, 2000);	
						}
			});
	
	}
	
    });

    jQuery('.inactive.inactive-tenant').click(function (e) {
			e.preventDefault();
			var checkedNum = jQuery(this).closest('tr').find('input[class="checkbulk"]:checked').length;
			if(checkedNum == 0){
				  alert('Please select this user to inactivate');
			} else {
			
					jQuery('.loading').show(); 
					var myarraytenant = new Array();
					var tenant_id = jQuery(this).attr('data-id');
					myarraytenant.push(tenant_id);
					
					var data = {
										'action': 'nyc_bulk_action_user',
										'data':   myarraytenant,
										'bulkaction':'inactive',						
							};
							// We can also pass the url value separately from ajaxurl for front end AJAX implementations
							jQuery.post(my_ajax_object.ajax_url, data, function(response) {			  
								if(response == "true"){
									jQuery('.loading').hide(); 
									$('#ModalUser .modal-body p').html('User Inactive Successfully');
									$('#ModalUser').modal('show');
									setTimeout(function(){
									   window.location.reload();
									   // or window.location = window.location.href; 
									}, 2000);	
								}
					});
					
			}
			
	});

	
});





</script>
<!-- Wrapper / End -->
<?php
get_footer();
?>