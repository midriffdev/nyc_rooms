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
						<li><a href="<?php echo get_site_url(); ?>/active-properties">Active <span class="active-listing-no"><?php echo nyc_get_properties_by_status(array('available'))->post_count; ?></span></a></li>
						<li><a href="<?php echo get_site_url(); ?>/rented-properties">Rented <span class="rented-listing-no"><?php echo nyc_get_properties_by_status(array('rented'))->post_count; ?></span></a></li>
						<li><a href="<?php echo get_site_url(); ?>/unapproved-properties">Unapproved <span class="unapproved-listing-no"><?php echo nyc_get_properties_by_status(array('draft'))->post_count; ?></span></a></li>
					</ul>
				</li>
				<li><a href="<?php echo get_site_url(); ?>/add-property/"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
			</ul>

			<ul class="my-account-nav">
				<li><a href="change-password.html"><i class="sl sl-icon-lock"></i> Change Password</a></li>
				<li><a href="#"><i class="sl sl-icon-power"></i> Log Out</a></li>
			</ul>

		</div>

	</div>
</div>
