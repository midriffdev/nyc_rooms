<?php
nyc_property_admin_authority();
get_header();
?>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<div class="container">
	<div class="row">
		<?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">

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
									<input type="text" placeholder="Enter Deal Number" value=""/>
								</div>
								<div class="col-md-6">
									<input type="text" placeholder="Enter Property Name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-6">
									<input type="text" placeholder="Enter Name" value=""/>
								</div>
								<div class="col-md-6">
									<select data-placeholder="Any Status" class="chosen-select-no-single" >
										<option>Select Stage</option>	
										<option>Stage 1</option>
										<option>Stage 2</option>
										<option>Stage 3</option>
									</select>
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

				<table class="manage-table responsive-table deal--table">
				<tbody>
				<tr>
					<th><i class="fa fa-list-ol"></i> Deal No</th>
					<th><i class="fa fa-user"></i>Name</th>
					<th><i class="fa fa-envelope"></i> Email</th>
					<th><i class="fa fa-phone" ></i> Phone</th>
					<th><i class="fa fa-user"></i>Agent</th>
					<th class="expire-date"><i class="fa fa-bars" aria-hidden="true"></i> Stage</th>
					<th></th>
				</tr>

				<!-- Item #1 -->
				<tr class="deal__stage-one">
					<td class="deal_number">#101</td>
					<td class="deal-member-name">Teri Dactyl</td>
					<td class="deal-email-address">teridactyl@gmail.com</td>
					<td class="deal-phone-number">+91869565478</td>
					<td class="deal-agent-name">Olive Yew</td>
					<td class="deal-stage-number">Stage 1</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
						<a href="#" class="deal__link"><i class="fa fa-clone"></i> Deal Link</a>
					</td>
				</tr>

				<!-- Item #2 -->
				<tr class="deal__stage-two">
					<td class="deal_number">#101</td>
					<td class="deal-member-name">Teri Dactyl</td>
					<td class="deal-email-address">teridactyl@gmail.com</td>
					<td class="deal-phone-number">+91869565478</td>
					<td class="deal-agent-name">Olive Yew</td>
					<td class="deal-stage-number">Stage 2</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
						<a href="#" class="deal__link"><i class="fa fa-clone"></i> Deal Link</a>
					</td>
				</tr>

				<!-- Item #3 -->
				<tr class="deal__stage-three">
					<td class="deal_number">#101</td>
					<td class="deal-member-name">Teri Dactyl</td>
					<td class="deal-email-address">teridactyl@gmail.com</td>
					<td class="deal-phone-number">+91869565478</td>
					<td class="deal-agent-name">Olive Yew</td>
					<td class="deal-stage-number">Stage 3</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
						<a href="#" class="deal__link"><i class="fa fa-clone"></i> Deal Link</a>
					</td>
				</tr>

				<!-- Item #4 -->
				<tr class="deal__stage-one">
					<td class="deal_number">#101</td>
					<td class="deal-member-name">Teri Dactyl</td>
					<td class="deal-email-address">teridactyl@gmail.com</td>
					<td class="deal-phone-number">+91869565478</td>
					<td class="deal-agent-name">Olive Yew</td>
					<td class="deal-stage-number">Stage 1</td>
					<td class="action">
						<a href="#"><i class="fa fa-eye"></i> View</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
						<a href="#" class="deal__link"><i class="fa fa-clone"></i> Deal Link</a>
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
</div>
<script>
jQuery(document).ready(function($) {
	jQuery('#sidebar-alldeals').addClass('current');
});
</script>
<?php 
get_footer();
?>