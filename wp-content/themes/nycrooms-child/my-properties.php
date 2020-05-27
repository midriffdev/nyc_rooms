<?php
/*
Template Name: My Properties
*/
nyc_property_owner_authority();
get_header();
?>

<!-- Wrapper -->
<div id="wrapper">
<!-- Content
================================================== -->
<div class="container">
	<div class="row">


		<!-- Widget -->
		<div class="col-md-4">
			<div class="sidebar left">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>
						<li><a href="#"><i class="sl sl-icon-screen-desktop"></i> Dashboard</a></li>
						<li><a href="my-profile.html"><i class="sl sl-icon-user"></i> My Profile</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li class="list-has--submenu">
							<a href="#">
								<i class="sl sl-icon-docs"></i> My Properties <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu">
								<li><a href="active-properties.html" >Active <span class="active-listing-no">4</span></a></li>
								<li><a href="rented-properties.html">Rented <span class="rented-listing-no">3</span></a></li>
							</ul>
						</li>
						<li><a href="submit-property.html"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li><a href="change-password.html"><i class="sl sl-icon-lock"></i> Change Password</a></li>
						<li><a href="#"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>

				</div>

			</div>
		</div>

		<div class="col-md-8">
			<table class="manage-table responsive-table">

				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th class="expire-date"><i class="fa fa-calendar"></i> Expiration Date</th>
					<th></th>
				</tr>

				<!-- Item #1 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-02.jpg" alt="">
						<div class="title">
							<h4><a href="#">Serene Uptown</a></h4>
							<span>6 Bishop Ave. Perkasie, PA </span>
							<span class="table-property-price">$900 / monthly</span> <span class="active--property">Active</span>
						</div>
					</td>
					<td class="expire-date">December 30, 2016</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>

				<!-- Item #2 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-05.jpg" alt="">
						<div class="title">
							<h4><a href="#">Oak Tree Villas</a></h4>
							<span>71 Lower River Dr. Bronx, NY</span>
							<span class="table-property-price">$700 / monthly</span> <span class="rented--property">Rented</span>
						</div>
					</td>
					<td class="expire-date">December 12, 2016</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>

				<!-- Item #3 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-04.jpg" alt="">
						<div class="title">
							<h4><a href="#">Selway Apartments</a></h4>
							<span>33 William St. Northbrook, IL </span>
							<span class="table-property-price">$200 / monthly</span> <span class="active--property">Active</span>
						</div>
					</td>
					<td class="expire-date">December 04, 2016</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>

				<!-- Item #4 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-06.jpg" alt="">
						<div class="title">
							<h4><a href="#">Old Town Manchester</a></h4>
							<span> 7843 Durham Avenue, MD  </span>
							<span class="table-property-price">$500 / monthly</span> <span class="rented--property">Rented</span>
						</div>
					</td>
					<td class="expire-date">November 27, 2016</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>

			</table>
			<a href="submit-property.html" class="margin-top-40 button">Submit New Property</a>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>
</div>
<?php
get_footer();
?>