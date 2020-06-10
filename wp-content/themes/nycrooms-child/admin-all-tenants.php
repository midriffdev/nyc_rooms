<?php 
/* Template Name: Admin All Tenants */
nyc_property_admin_authority();
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
                <div class="admin-advanced-searchfilter">
					<h2>Teanent filter</h2>
					<form>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Teanent Name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<input type="email" id="email" name="email" placeholder="Enter Email">
								</div>
								<div class="col-md-6">
									<input type="text" placeholder="Enter Phone" value=""/>
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

				<table class="manage-table responsive-table admin-teanent-maintable">
				<tbody>
				<tr>
					<th><i class="fa fa-file-text"></i> Teanent</th>
					<th class="expire-date"><i class="fa fa-user"></i> Username</th>
					<th><i class="fa fa-envelope"></i> Email</th>
					<th><i class="fa fa-phone" ></i> Phone</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>

				<!-- Item #1 -->
				<tr>
					<td class="title-container teanent-title-container">
						<img src="<?= get_stylesheet_directory_uri() ?>/images/agent-02.jpg" alt="">
						<div class="title">
							<h4><a href="<?= site_url()?>/tenant-details/">Gail Forcewind</a></h4>
						</div>
					</td>
					<td class="teanent--username">Gail1548</td>
					<td class="teanent--username">Gailforcewind@gmail.com</td>
					<td><div class="teanent-phone-no">9896546541</div></td>
					<td class="action">
						<a href="<?= site_url()?>/tenant-details/"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
                <tr>
					<td class="title-container teanent-title-container">
						<img src="<?= get_stylesheet_directory_uri() ?>/images/agent-02.jpg" alt="">
						<div class="title">
							<h4><a href="<?= site_url()?>/tenant-details/">Gail Forcewind</a></h4>
						</div>
					</td>
					<td class="teanent--username">Gail1548</td>
					<td class="teanent--username">Gailforcewind@gmail.com</td>
					<td><div class="teanent-phone-no">9896546541</div></td>
					<td class="action">
						<a href="<?= site_url()?>/tenant-details/"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>

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
									<li><a href="#" class="current-page">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li class="blank">...</li>
									<li><a href="#">22</a></li>
								</ul>
							</nav>

							<nav class="pagination-next-prev">
								<ul>
									<li><a href="#" class="prev">Previous</a></li>
									<li><a href="#" class="next">Next</a></li>
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
</div>
<!-- Wrapper / End -->
<?php
get_footer();
?>