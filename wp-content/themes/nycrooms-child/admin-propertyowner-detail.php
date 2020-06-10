<?php 
/*
Template Name: Owner Detail
*/
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
		<?php
		$user_id = $_GET['uid'];
		$data = get_userdata($user_id);
		//echo '<pre>';print_r($data); echo '</pre>';
		$name =  $data->user_nicename;
		$phone = get_user_meta($user_id,'phone',true);
		$email = $data->user_email;
		?>
		<div class="row">
			<div class="col-md-6 my-profile">
				
				<div class="row">
					<div class="col-md-6">
						<label>Your Name</label>
						<input value="<?php echo $name;?>" type="text">
					</div>
					<div class="col-md-6">
						<label>Phone</label>
						<input value="<?php echo $phone;?>" type="text">
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<label>Email</label>
						<input value="<?php echo $email;?>" type="text">
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
							<img src="<?php echo get_stylesheet_directory_uri();?>/images/agent-03.jpg" alt="">
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
				<?php
				$properties = nyc_get_properties_by_property_owner($user_id);
				if ( $properties->have_posts() ) {

						while ( $properties->have_posts() ) {
							$properties->the_post(); 
						    $post_id = get_the_ID();
							$address = get_post_meta($post_id, 'address',true)." ";
							$address .= get_post_meta($post_id, 'city',true)." ";
							$address .= get_post_meta($post_id, 'state',true).", ";
							$address .= get_post_meta($post_id, 'zip',true)." ";
							$price = get_post_meta($post_id, 'price',true);
							$payment_method = get_post_meta($post_id, 'payment_method',true);
							$prop_image = wp_get_attachment_url(get_post_meta($post_id, 'file_0',true));
							
				?>

				<!-- Item #1 -->
				<tr>
					<td class="title-container">
						<img src="<?php if($prop_image){ echo $prop_image; } ?>" alt="">
						<div class="title">
							<h4><a href="<?php echo get_the_guid(); ?>"><?php echo get_the_title(); ?></a></h4>
							<span><?php echo $address; ?> </span>
							<span class="table-property-price"><?php echo $price; ?></span> <span class="rented--property">Rented</span>
						</div>
					</td>
					<td>
						<div class="owner--name"><a href="#"><?php echo $name;?></a></div>
					</td>
					<td class="action">
						<a href="#"><i class="fa fa-pencil"></i> Edit</a>
						<a href="#"><i class="fa  fa-eye-slash"></i> Hide</a>
						<a href="#" class="delete delete-property" data-id="<?php echo $post_id; ?>"><i class="fa fa-remove"></i> Delete</a>
					</td>
				</tr>
<?php 
						}

					}else{
					    echo "<tr class='nyc-no-properties'><td>No Properties Found !</td></tr>";
					}
				?>
				</tbody>
		</table>
		<a href="<?php echo get_site_url(); ?>/add-property" class="margin-top-40 button">Submit New Property</a>
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

<?php
get_footer();
?>