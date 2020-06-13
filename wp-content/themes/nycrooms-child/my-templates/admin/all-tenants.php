<?php 
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
	'order_by'=>'registered',
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
	'order_by'=>'registered',
	'order'=>'DESC',
);
if($searchphone){
	$countargs['meta_query']=array( array( 'key'   => 'user_phone', 'value' => $searchphone, 'compare' => 'REGEXP' ) );
	$args['meta_query']=array( array( 'key'   => 'user_phone', 'value' => $searchphone, 'compare' => 'REGEXP' )	);
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
                <div class="admin-advanced-searchfilter">
					<h2>Teanent filter</h2>
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
				<div class="col-md-12">
					 <p class="showing-results"><?php echo $total_query; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $total_pages;?> </p>
				</div>
				<table class="manage-table responsive-table admin-teanent-maintable all_agents_table">
				<tbody>
				<tr>
					<th><input type="checkbox" class="checkallbulk"></th>
					<th><i class="fa fa-file-text"></i> Teanent</th>
					<th><i class="fa fa-envelope"></i> Email</th>
					<th><i class="fa fa-phone" ></i> Phone</th>
					<th><i class="fa fa-toggle-on" ></i>Status</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
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
					<td><div class="teanent-status"><?php echo get_user_meta($user_id,'user_status',true); ?></div></td>					
					<td class="action">
						<a href="<?= site_url()?>/admin/edit-profile/?uid=<?php echo $user_id; ?>"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#" class="delete delete-tenant" data-id="<?php echo $user_id; ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
				<?php 
				} 
				}else{
				echo "<tr><td colspan='6'>No record founds</td></tr>";
				}
				?>
				</tbody>
				</table>
				
				<div>
			        <label>Select bulk action</label>
                  <div class="users_bulk_actions">
						<select class="select_action">
						 <option value="-1">Bulk Actions</option>
						 <option value="active">Active</option>
						 <option value="inactive">Inactive</option>
						 <option value="delete">Delete</option>
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
});
</script>
<!-- Wrapper / End -->
<?php
get_footer();
?>