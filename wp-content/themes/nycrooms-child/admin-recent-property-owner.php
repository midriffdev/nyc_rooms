<?php 
/*
Template Name: Admin Recent Property Owner
*/
nyc_property_admin_authority();
$argarray = array();
if(isset($_GET['search_owner'])){

    
	 
    $argarray =  array(
                               'relation'    => 'AND',
								array(
									'key'          => 'user_name',
									'value'        => $_GET['ownername'],
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								),
								array(
									'key'          => 'user_email',
									'value'        => $_GET['email'],
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								),
								array(
									'key'          => 'user_phone',
									'value'        => $_GET['phone'],
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								)
                                								
                    ); 
 
}






$argspage = array(
         'role__in' => 'property_owner',
		 'number' => -1

        );
		
$users = new WP_User_Query( $argspage ); 
$user_count_agents = $users->get_results();
// count the number of users found in the query
$total_users_agents = $user_count_agents ? count($user_count_agents) : 1;

$page = (get_query_var('paged')) ? get_query_var('paged') : 1;

// how many users to show per page
$users_per_page = 6;

// calculate the total number of pages.
$total_pages = 1;
$offset = $users_per_page * ($page - 1);
$total_pages = ceil($total_users_agents / $users_per_page);

$args = array(
         'role__in' => 'property_owner',
		 'number' => $users_per_page,
		 'offset'    => $offset,
         'orderby'	=> 'user_registered',	 
		 'order'      => 'DESC',

        );
		

if(!empty($argarray)){
   $args['meta_query'] = $argarray; 
}

$usersquery = new WP_User_Query( $args ); 

$all_users = $usersquery->get_results();
global $wp;
$current_url = home_url( add_query_arg( array(), $wp->request ) );
if(isset($_GET['download-csv']) && $_GET['download-csv'] == 'true'){
	ob_end_clean();   
	nyc_export_as_CSV_Prop_Owner();	
}
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
                    <p style="color:#274abb"><a href="<?= site_url().'/admin/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To DashBoard</a></p>
				<div class="admin-advanced-searchfilter">
				    
					<h2>Property Owner filter</h2>
					<form method="get">
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Owner Name"  name="ownername"/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<input type="email" id="email" name="email" placeholder="Enter Email">
								</div>
								<div class="col-md-6">
									<input type="text" placeholder="Enter Phone" name="phone"/>
								</div>
							</div>
							<!-- Row With Forms / End -->	

							<!-- Search Button -->
							<div class="row with-forms">
								<div class="col-md-12">
									<button class="button fs-map-btn" name="search_owner" type="submit">Search</button>
								</div>
							</div>

						</div>
						<!-- Box / End -->
					</div>
					</form>
				</div>
				 <div class="col-md-10">
					     <p class="showing-results"><?= count($all_users); ?> Results Found On Page <?php echo $page ;?> of <?php echo $total_pages;?> </p>
				 </div>
				 <div class="col-md-2 mx-auto">
					 <p class="showing-results"><?php if(count($all_users) > 0){ echo '<a href="'.$current_url.'/?download-csv=true">Download CSV</a>'; } ?></p>
				</div>
				<table class="manage-table responsive-table admin-teanent-maintable all_agents_table">
				<tbody>
				<tr>
				    <th><input type="checkbox" class="checkallagents"></th>
					<th> Owner</th>
					<th class="expire-date">Properties</th>
					<th> Email</th>
					<th> Phone</th>
					<th> Action</th>
				</tr>

				<!-- Item #1 -->
				<?php 
				if($all_users){	
				foreach ( $all_users as $user ) {
                   $phone = get_user_meta($user->ID,'user_phone',true);
				   $profile_picture = get_user_meta($user->ID,'profile_picture',true);
					?>
					<tr>
					    <td><input type="checkbox" class="checkagent" value="<?= $user->ID ?>"></td>
						<td class="title-container teanent-title-container">
						   <?php if($profile_picture){
						       echo wp_get_attachment_image( $profile_picture, array('150', '150'), "", array( "class" => "img-responsive" ) );
						   ?>
							<?php } else { ?>
							  <img src="<?= get_stylesheet_directory_uri() ?>/images/male-icon.png" alt="">
							<?php } ?>
							<div class="title">
							 <h4><!--a href="<?php //echo get_site_url();?>/property-owner-details"---><?php echo $user->display_name; ?><!--/a--></h4>
							</div>
						</td>
						<td class="admin-owner-propertycount"><?php echo nyc_get_properties_by_property_owner($user->ID)->post_count;?></td>
						<td class="owner--username"><?php echo $user->user_email ;?></td>
						<td><div class="owner-phone-no"><?php echo $phone ;?></div></td>
						<td class="action">
							<a href="<?php echo get_site_url();?>/property-owner-details/?prpage=recent-property-owner&&uid=<?php echo $user->ID;?>"><i class="fa fa-pencil"></i> Edit</a>
							<a style="cursor:pointer;" class="delete_agent_profile" data-id="<?php echo $user->ID; ?>"><i class="fa fa-remove"></i> Delete</a>
						</td>
					</tr>
				<?php
                   if(count($all_users) > 20){
				      break;
				   }

				}
				}else{
					echo "<tr class='nyc-no-properties'><td class='no_property_found' colspan='6'>No Property Owner Found !</td></tr>";
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
													'total'        => $total_pages,
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
									    <li class="prev"> <?php previous_posts_link( 'Previous',$total_pages ); ?> </li>
										<li class="next"> <?php next_posts_link( 'Next', $total_pages);  ?> </li>
								</ul>
							</nav>
						</div>

					</div>
				</div>
				<!-- Pagination Container / End -->
				<div class="admin-advanced-searchfilter">
			        <label>Select bulk action</label>
                  <div class="bulk_actions">
						<select class="select_action">
							 <option value="-1">Bulk Actions</option>
							 <option value="delete">Delete</option>
						</select>
                    <input type="button" value="Apply" class="apply_action">
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
          <p>Owner Deleted Successfully</p>
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
.bulk_actions {
    display: flex;
}
select.select_action {
    width: 30%;
}
input.apply_action {
    width: 30%;
    margin-left: 5%;
    padding: 0;
}
</style>
<script>
jQuery(document).ready(function($) {
	jQuery('.admin-propertiesowner').addClass('show--submenu');
	jQuery('#sidebar-recentowner').addClass('current');
});
</script>

<?php 
get_footer();
?>