<!-- Widget -->
		<div class="col-md-3">
			<div class="sidebar left admin-dashboard-sidebar">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>
						<li><a href="admin-dashboard.html"><i class="sl sl-icon-screen-desktop"></i> Dashboard</a></li>
						<li><a href="my-profile.html"><i class="sl sl-icon-user"></i> My Profile</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li class="list-has--submenu admin-propertieslistings">
							<a href="#">
								<i class="sl sl-icon-docs"></i>Properties <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu">
								<li><a href="admin-all-properties.html" >All Properties <span class="all-listing-no active-listing-no">2000</span></a></li>
								<li><a href="admin-available-properties.html" >Available <span class="active-listing-no">200</span></a></li>
								<li><a href="admin-rented-properties.html">Rented <span class="rented-listing-no">500</span></a></li>
								<li><a href="admin-recently-property">Recently Submitted <span class="unapproved-listing-no">50</span></a></li>
							</ul>
						</li>
						<li><a href="submit-property.html"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Property Owners</li>
						<li class="list-has--submenu admin-propertieslistings ">
							<a href="#">
								<i class="sl sl-icon-docs"></i>Property Owners <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu">
								<li><a href="admin-property-owners.html" >All Owners <span class="all-listing-no active-listing-no">2000</span></a></li>
								<li><a href="admin-recently-propertyowners.html" >Recently Added<span class="active-listing-no">20</span></a></li>
							</ul>
						</li>
						<li><a href="admin-add-propertyowner.html"><i class="sl sl-icon-action-redo"></i> Add New Owner</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Tenants</li>
						<li class="list-has--submenu admin-propertieslistings">
							<a href="#">
								<i class="sl sl-icon-docs"></i>Tenants <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu ">
								<li><a href="admin-tenants.html" >All Tenants <span class="all-listing-no active-listing-no">1000</span></a></li>
								<li><a href="admin-recently-tenant.html" >Recently Added<span class="active-listing-no">20</span></a></li>
							</ul>
						</li>
						<li><a href="admin-add-teanent.html"><i class="sl sl-icon-action-redo"></i> Add New Teanent</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Agents</li>
						<li class="admin-propertieslistings"><a href="admin-agents.html">All Agents <span class="all-listing-no active-listing-no">1000</span></a></li>
						<li><a href="admin-add-agent.html"><i class="sl sl-icon-action-redo"></i> Add New Agent</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Property Leads</li>
						<li class="admin-propertieslistings"><a href="<?= home_url();?>/all-leads/" >All leads <span class="all-listing-no active-listing-no">2000</span></a></li>
						<li class="admin-propertieslistings"><a href="<?= home_url();?>/recent-leads/" class="current">Recently Added Lead<span class="active-listing-no">20</span></a></li>
					</ul>

					<ul class="my-account-nav">
						<li><a href="<?php echo home_url(); ?>/change-password/"><i class="sl sl-icon-lock"></i> Change Password</a></li>
						<li><a href="<?php echo wp_logout_url(home_url().'/login-admin/'); ?>"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>

				</div>

			</div>
		</div>