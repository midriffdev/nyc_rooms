<?php 
/*
Template Name: Admin Recent Property Owner
*/
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
					<h2>Property Owner filter</h2>
					<form>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Owner Name" value=""/>
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
					<th><i class="fa fa-file-text"></i> Owner</th>
					<th class="expire-date"><i class="fa fa-home" ></i>Properties</th>
					<th><i class="fa fa-envelope"></i> Email</th>
					<th><i class="fa fa-phone" ></i> Phone</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>

				<!-- Item #3 -->
				<tr>
					<td class="title-container teanent-title-container">
						<img src="images/agent-03.jpg" alt="">
						<div class="title">
							<h4><a href="#">Bob Frapples</a></h4>
						</div>
					</td>
					<td class="admin-owner-propertycount">15</td>
					<td class="owner--username">Gailforcewind@gmail.com</td>
					<td><div class="owner-phone-no">9896546541</div></td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
				 
				 <tr>
					<td class="title-container teanent-title-container">
						<img src="images/agent-03.jpg" alt="">
						<div class="title">
							<h4><a href="#">Bob Frapples</a></h4>
						</div>
					</td>
					<td class="admin-owner-propertycount">15</td>
					<td class="owner--username">Gailforcewind@gmail.com</td>
					<td><div class="owner-phone-no">9896546541</div></td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
				<tr>
					<td class="title-container teanent-title-container">
						<img src="images/agent-03.jpg" alt="">
						<div class="title">
							<h4><a href="#">Bob Frapples</a></h4>
						</div>
					</td>
					<td class="admin-owner-propertycount">15</td>
					<td class="owner--username">Gailforcewind@gmail.com</td>
					<td><div class="owner-phone-no">9896546541</div></td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
				<tr>
					<td class="title-container teanent-title-container">
						<img src="images/agent-03.jpg" alt="">
						<div class="title">
							<h4><a href="#">Bob Frapples</a></h4>
						</div>
					</td>
					<td class="admin-owner-propertycount">15</td>
					<td class="owner--username">Gailforcewind@gmail.com</td>
					<td><div class="owner-phone-no">9896546541</div></td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
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