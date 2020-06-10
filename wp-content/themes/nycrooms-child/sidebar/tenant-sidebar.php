<div class="col-md-4">
			<div class="sidebar left">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>
						<li><a href="#"><i class="sl sl-icon-screen-desktop"></i> Dashboard</a></li>
						<li><a href="<?php echo home_url(); ?>/my-profile-tenant/" class="current"><i class="sl sl-icon-user"></i> My Profile</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li class="list-has--submenu">
							<a href="#">
								<i class="sl sl-icon-docs"></i> Hired Properties <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu">
								<li><a href="active-properties-teanent.html" >Active <span class="active-listing-no">4</span></a></li>
								<li><a href="past-properties-teanent.html">Past <span class="rented-listing-no">3</span></a></li>
							</ul>
						</li>
						<li><a href="my-bookmarks.html"><i class="sl sl-icon-star"></i> Bookmarked Properties</a></li>
					</ul>

					<ul class="my-account-nav">
					    <li><a href="contracts-teanent.html"><i class="sl sl-icon-book-open"></i> Contracts</a></li>
						<li><a href="<?php echo home_url(); ?>/change-password/"><i class="sl sl-icon-lock"></i> Change Password</a></li>
						<li><a href="<?php echo wp_logout_url(home_url().'/tenant-registration/'); ?>"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>
				</div>

			</div>
		</div>