<?php
/* Template Name: Admin All Agents */
$argarray = array();
if(isset($_GET['search_users'])){

    
	 
    $argarray =  array(
                               'relation'    => 'AND',
								array(
									'key'          => 'user_full_name',
									'value'        => $_GET['agent'],
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								),
								array(
									'key'          => 'user_agent_email',
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
         'role__in' => 'sales_agent',
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
         'role__in' => 'sales_agent',
		 'number' => $users_per_page,
		 'offset'    => $offset,
         'orderby'	=> 'user_registered',	 

        );
		

if(!empty($argarray)){
   $args['meta_query'] = $argarray; 
}

$usersquery = new WP_User_Query( $args ); 

$all_users = $usersquery->get_results();

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
		<!-- Widget -->
		<?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">

				<div class="admin-advanced-searchfilter">
					<h2>Agents filter</h2>
					
					<div class="row with-forms">
					   
						<!-- Form -->
						<div class="main-search-box no-shadow">
                            
							<form method="get">
								<!-- Row With Forms -->
								<div class="row with-forms">
									<!-- Main Search Input -->
									<div class="col-md-12">
										<input type="text" placeholder="Enter Agent Name" value="" name="agent"/>
									</div>
									
								</div>
								<!-- Row With Forms / End -->

								<!-- Row With Forms -->
								<div class="row with-forms">
									<div class="col-md-6">
										<input type="email" id="email" name="email" placeholder="Enter Email">
									</div>
									<div class="col-md-6">
										<input type="text" placeholder="Enter Phone" value="" name="phone"/>
									</div>
								</div>
								<!-- Row With Forms / End -->	

								<!-- Search Button -->
								<div class="row with-forms">
									<div class="col-md-12">
										<button class="button fs-map-btn" type="submit" name="search_users">Search</button>
									</div>
								</div>
								
							</form>

						</div>
						<!-- Box / End -->
					</div>
				</div>
				
				    <div class="col-md-12">
					     <p class="showing-results"><?= count($all_users); ?> Results Found On Page <?php echo $page ;?> of <?php echo $total_pages;?> </p>
				    </div>

				<table class="manage-table responsive-table admin-teanent-maintable all_agents_table">
				<tbody>
				<tr>
				    <th><input type="checkbox" class="checkallagents"></th>
					<th><i class="fa fa-file-text"></i> Agent</th>
					<th><i class="fa fa-envelope"></i> Email</th>
					<th><i class="fa fa-phone" ></i> Phone</th>
					<th><i class="fa fa-toggle-on" ></i>status</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>

				<?php foreach($all_users as $agents){ ?>
				<!-- Item #1 -->
				<tr>
				    <td><input type="checkbox" class="checkagent" value="<?= $agents->ID ?>"></td>
					<td class="title-container teanent-title-container">
					     <?php
						  $profile_imgid =  get_user_meta($agents->ID,'profile_user_image',true);
						  if($profile_imgid){
								echo wp_get_attachment_image( $profile_imgid, array('150', '150'), "", array( "class" => "img-responsive" ) );
						   } else {
						 ?>
						       <img src="<?= get_stylesheet_directory_uri() ?>/images/agent-01.jpg" alt="">
						 <?php
						   }
						 ?>
						<div class="title">
							<h4><a href="<?= home_url() . '/agent-details/?agentid='.$agents->ID ?>"><?php echo $agents->data->display_name; ?></a></h4>
						</div>
					</td>
					<td class="owner--username"><?php echo $agents->data->user_email; ?></td>
					<td><div class="owner-phone-no"><?php echo get_user_meta($agents->ID,'user_phone',true); ?></div></td>
					<td><div class="owner-status"><?php echo get_user_meta($agents->ID,'user_agent_status',true); ?></div></td>
					<td class="action">
						<a href="<?= home_url() . '/agent-details/?agentid='.$agents->ID  ?>"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a  class="delete_agent_profile" data-id="<?= $agents->ID ?>" style="cursor:pointer;"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
			<?php } ?>


				</tbody>
				</table>
				
				<div>
			        <label>Select bulk action</label>
                  <div class="bulk_actions">
						<select class="select_action">
						 <option value="-1">Bulk Actions</option>
						 <option value="active">Active</option>
						 <option value="inactive">Inactive</option>
						 <option value="delete">Delete</option>
						</select>
                    <input type="button" value="Apply" class="apply_action">
                 </div>
                </div>

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
										<li class="prev"><!--a href="#" class="prev">Previous</a--> <?php previous_posts_link( 'Previous',$total_pages ); ?> </li>
										<li class="next"><!--a href="#" class="next">Next</a--> <?php next_posts_link( 'Next', $total_pages);  ?> </li>
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

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

<!-- Modal -->
  <div class="modal fade" id="Modalinactive" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Agent Inactivated Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 
 <!-- Modal -->
  <div class="modal fade" id="Modaldelete" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Agent Deleted Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 
 <!-- Modal -->
  <div class="modal fade" id="Modalactive" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Agent Activated Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
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
<!-- Wrapper / End -->
<?php
get_footer();