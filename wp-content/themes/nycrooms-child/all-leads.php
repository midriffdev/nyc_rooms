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
									'key'          => 'lead_checkt_prp_owner',
									'value'        => $_GET['property_owner_name'],
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								),
								array(
									'key'          => 'lead_chckt_prp_owner_email',
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
		 'post_status'       => 'available',
         'posts_per_page'   => 6,
         //'no_found_rows'    => true,
         'suppress_filters' => false,
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
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<h2>All Leads</h2>

				<!-- Breadcrumbs -->
				<nav id="breadcrumbs">
					<ul>
						<li><a href="#">Home</a></li>
						<li>All Leads</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row">


		<?php get_template_part('sidebar/admin-sidebar'); ?>

		<div class="col-md-9">
			<div class="dashboard-main--cont">

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

				<table class="manage-table responsive-table">
				<tbody>
				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th><i class="fa fa-user"></i>Name</th>
					<th class="expire-date"><i class="fa fa-envelope" ></i>Email</th>
					<th></th>
				</tr>
                 
				 
				 <?php
				 if ( $all_leads->have_posts() ) { 

                 while ( $all_leads->have_posts() ) { 
                      $all_leads->the_post();
					  
					
				     $property_id = get_post_meta(get_the_ID(),'lead_checkout_property',true);
					  
					        
								
                    ?> 
					<tr>
					<td class="title-container">
						
						<?php 
						 $galleryfiles =  get_post_meta($property_id,'gallery_files',true);
						 if($galleryfiles){
								$galleryfiles = explode(',',$galleryfiles);
								$attachment_id = get_post_meta($property_id,$galleryfiles[0],true);
							    $imgsrc = wp_get_attachment_image_src( $attachment_id,array('300', '200'));
								echo wp_get_attachment_image( $attachment_id, array('768', '512'), "", array( "class" => "img-responsive" ) );
						 }
						?>
						
						<div class="title">
							<h4><a href="<?= site_url().'/single-property/?property_id='.$property_id ?>"><?= get_the_title($property_id) ?></a></h4>
							<span><?= get_post_meta($property_id,'address',true); ?></span>
							<span class="table-property-price">$<?= get_post_meta($property_id,'price',true); ?> / <?= get_post_meta($property_id,'payment_method',true); ?></span> <span class="active--property"><?= get_post_meta($property_id,'status',true); ?></span>
						</div>
					</td>
					<td><div class="Lead--name"><a href="#"><?= get_post_meta($property_id,'contact_name',true); ?></a></div></td>
					<td class="lead-email-address"><?= get_post_meta($property_id,'contact_email',true); ?></td>
					<td class="action">
						<a href="<?= site_url() . '/lead-details/?leadid='.get_the_ID() ?>"><i class="fa fa-eye"></i> View</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete" data-id="<?= get_the_ID() ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
					
					<?php  } 

               } else { ?>

                      <li><h3>No Leads Found</h3></li>

          <?php } ?> 

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
			
				<!-- Pagination Container / End -->

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>


<!-- Scripts
================================================== -->


</div>
<!-- Wrapper / End -->

<style>
.tg-container {
    width: 100%;
    max-width: 100%;
}
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
</style>


<?php
get_footer();