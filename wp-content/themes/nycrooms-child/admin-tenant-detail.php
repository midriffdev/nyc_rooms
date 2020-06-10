<?php 
/* Template Name: Admin Tenant Detail */
nyc_property_admin_authority();
get_header();
?>
<!-- Wrapper -->
<div id="wrapper">

<!-- Content
================================================== -->
<div class="admin-teanent-detailpage">
	<div class="container">

	<div class="admin-teanent-account-details">
		<div class="row">
			<div class="col-md-12">
				<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Account Details</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 my-profile">
				
				<div class="row">
					<div class="col-md-6">
						<label>Your Name</label>
						<input value="Jennie Wilson" type="text">
					</div>
					<div class="col-md-6">
						<label>Phone</label>
						<input value="(123) 123-456" type="text">
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<label>Email</label>
						<input value="jennie@example.com" type="text">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
						<textarea name="about" id="about" cols="30" rows="10">Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet ullamcorper phasellus semper</textarea>
					</div>
				</div>
				<button class="button margin-top-20 margin-bottom-20">Save Changes</button>
			</div>

			<div class="col-md-6 admin-teanent-right">

				<div class="row">
					<div class="col-md-12">
						<!-- Avatar -->
						<div class="edit-profile-photo">
							<img src="images/agent-02.jpg" alt="">
							<div class="change-photo-btn">
								<div class="photoUpload">
								    <span><i class="fa fa-upload"></i> Upload Photo</span>
								    <input type="file" class="upload" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h4 class="margin-top-50">Social</h4>
					</div>
					<div class="col-md-6">
						<label><i class="fa fa-twitter"></i> Twitter</label>
						<input value="https://www.twitter.com/" type="text">
					</div>
					<div class="col-md-6">
						<label><i class="fa fa-facebook-square"></i> Facebook</label>
						<input value="https://www.facebook.com/" type="text">
					</div>
					<div class="col-md-6">
						<label><i class="fa fa-google-plus"></i> Google+</label>
						<input value="https://www.google.com/" type="text">
					</div>
					<div class="col-md-6">
						<label><i class="fa fa-linkedin"></i> Linkedin</label>
						<input value="https://www.linkedin.com/" type="text">
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="admin-teanent-contract-details">
		<div class="row">
			<div class="col-md-12">
				<h4 class="margin-top-50 margin-bottom-30 admin-teanentdetail-title">Contract Details</h4>
			</div>
		</div>
		<table class="manage-table responsive-table contracts--table">
			<tr>
				<th><i class="fa fa-list-ol"></i> Contract No</th>
				<th><i class="fa fa-file-text"></i> Contract Name</th>
				<th class="expire-date"><i class="fa fa-calendar"></i> Date</th>
				<th><i class="fa fa-hand-pointer-o"></i> Action</th>
			</tr>

			<!-- Item #1 -->
			<tr>
				<td class="contact-number">#101</td>
				<td class="title-container-contract">
					<div class="title">
						<h4><a href="#">Contract Name 1</a></h4>
					</div>
				</td>
				<td class="expire-date">December 30, 2016</td>
				<td class="action">
					<a href="#"><i class="fa fa-eye"></i> View</a>
					<a href="#"><i class="fa fa-download"></i> Download</a>
				</td>
			</tr>

			<!-- Item #2 -->
			<tr>
				<td class="contact-number">#110</td>
				<td class="title-container-contract">
					<div class="title">
						<h4><a href="#">Contract Name 2</a></h4>
					</div>
				</td>
				<td class="expire-date">December 30, 2016</td>
				<td class="action">
					<a href="#"><i class="fa fa-eye"></i> View</a>
					<a href="#"><i class="fa fa-download"></i> Download</a>
				</td>
			</tr>

			<!-- Item #3 -->
			<tr>
				<td class="contact-number">#151</td>
				<td class="title-container-contract">
					<div class="title">
						<h4><a href="#">Contract Name 3</a></h4>
					</div>
				</td>
				<td class="expire-date">December 30, 2016</td>
				<td class="action">
					<a href="#"><i class="fa fa-eye"></i> View</a>
					<a href="#"><i class="fa fa-download"></i> Download</a>
				</td>
			</tr>

			<!-- Item #4 -->
			<tr>
				<td class="contact-number">#105</td>
				<td class="title-container-contract">
					<div class="title">
						<h4><a href="#">Contract Name 4</a></h4>
					</div>
				</td>
				<td class="expire-date">December 30, 2016</td>
				<td class="action">
					<a href="#"><i class="fa fa-eye"></i> View</a>
					<a href="#"><i class="fa fa-download"></i> Download</a>
				</td>
			</tr>

		</table>
	</div>

	<div class="admin-teanent-property-details">
		<div class="row">
			<div class="col-md-12">
				<h4 class="margin-top-50 margin-bottom-30 admin-teanentdetail-title">Property Details</h4>
			</div>
		</div>
		<table class="manage-table responsive-table">
				<tbody>
				<tr>
					<th><i class="fa fa-file-text"></i> Property</th>
					<th><i class="fa fa-user"></i> Owner</th>
					<th><i class="fa fa-hand-pointer-o"></i> Action</th>
				</tr>

				<!-- Item #1 -->
				<tr>
					<td class="title-container">
						<img src="images/listing-02.jpg" alt="">
						<div class="title">
							<h4><a href="#">Serene Uptown</a></h4>
							<span>6 Bishop Ave. Perkasie, PA </span>
							<span class="table-property-price">$900 / monthly</span> <span class="rented--property">Rented</span>
						</div>
					</td>
					<td>
						<div class="owner--name"><a href="#">Aida Bugg</a></div>
					</td>
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
					<td>
						<div class="owner--name"><a href="#">Aida Bugg</a></div>
					</td>
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
							<span class="table-property-price">$200 / monthly</span> <span class="rented--property">Rented</span>
						</div>
					</td>
					<td>
						<div class="owner--name"><a href="#">Aida Bugg</a></div>
					</td>
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
					<td>
						<div class="owner--name"><a href="#">Aida Bugg</a></div>
					</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>

				</tbody>
		</table>
		
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