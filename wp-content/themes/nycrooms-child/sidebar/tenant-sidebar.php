<div class="col-md-4">
	<div class="sidebar left">
		<div class="my-account-nav-container">	
			<ul class="my-account-nav">
				<li class="sub-nav-title">Manage Account</li>
				<li><a href="<?php echo home_url(); ?>/tenant/" id="sidebar-profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
			</ul>
			
			<ul class="my-account-nav">
				<li class="sub-nav-title">Manage Listings</li>
				<li class="list-has--submenu">
					<a href="#">
						<i class="sl sl-icon-docs"></i> Hired Properties <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
					</a>
					<ul class="list--submenu">
						<li><a href="<?php echo home_url(); ?>/tenant/active-properties/" id="sidebar-active">Active <span class="active-listing-no">4</span></a></li>
						<li><a href="<?php echo home_url(); ?>/tenant/past-properties/" id="sidebar-past">Past <span class="rented-listing-no">3</span></a></li>
					</ul>
				</li>
				<li><a href="<?php echo home_url(); ?>/tenant/bookmarked-properties/" id="sidebar-bookmark"><i class="sl sl-icon-star"></i> Bookmarked Properties</a></li>
			</ul>

			<ul class="my-account-nav">
				<li><a href="<?php echo home_url(); ?>/tenant/contracts/"><i class="sl sl-icon-book-open"></i> Contracts</a></li>
				<li><a href="<?php echo home_url(); ?>/change-password/"><i class="sl sl-icon-lock"></i> Change Password</a></li>
				<li><a href="<?php echo wp_logout_url(home_url().'/tenant-registration/'); ?>"><i class="sl sl-icon-power"></i> Log Out</a></li>
			</ul>
		</div>
	</div>
</div>