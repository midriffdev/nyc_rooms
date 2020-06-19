<!-- Widget -->
		<div class="col-md-3">
			<div class="sidebar left admin-dashboard-sidebar">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>

						<li><a href="<?= home_url();?>/admin/" id="sidebar-dashboard"><i class="sl sl-icon-screen-desktop"></i> Dashboard</a></li>
						<li><a href="<?= home_url();?>/profile-admin/" id="sidebar-profile"><i class="sl sl-icon-user"></i> My Profile</a></li>

					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li class="list-has--submenu admin-propertieslistings">
							<a href="#">
								<i class="sl sl-icon-docs"></i>Properties <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu show--submenu">
								<li><a href="<?php echo get_site_url(); ?>/admin-properties" class="current">All Properties <span class="all-listing-no active-listing-no"><?php echo nyc_get_properties_admin_by_status(array('draft', 'available', 'rented','Pending Review'))->post_count; ?></span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/admin-available-properties" >Available <span class="active-listing-no"><?php echo nyc_get_properties_admin_by_status(array('available'))->post_count; ?></span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/admin-rented-properties" >Rented <span class="rented-listing-no"><?php echo nyc_get_properties_admin_by_status(array('rented'))->post_count; ?></span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/approved-properties-admin/">Approved Properties<span class="unapproved-listing-no"><?php echo  nyc_get_admin_approved_properties(); ?></span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/admin-recently-properties">UnApproved Properties<span class="unapproved-listing-no"><?php echo nyc_get_recent_properties(); ?></span></a></li>
							</ul>
						</li>
						<li><a href="<?= home_url() ?>/add-property-admin/"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Property Owners</li>
						<li class="list-has--submenu admin-propertieslistings ">
							<a href="#">
								<i class="sl sl-icon-docs"></i>Property Owners <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu">
								<li><a href="<?php echo get_site_url(); ?>/admin-property-owner-all/" >All Owners <span class="all-listing-no active-listing-no"><?=get_all_property_owner_counts() ?> </span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/recent-property-owner/" >Recently Added<span class="active-listing-no"><?=get_all_property_owner_recent_counts() ?></span></a></li>
							</ul>
						</li>
						<li><a href="<?php echo get_site_url(); ?>/add-property-owner/"><i class="sl sl-icon-action-redo"></i> Add New Owner</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Tenants</li>
						<li class="admin-propertieslistings">
							<a href="<?php echo get_site_url(); ?>/admin/all-tenants/" id="sidebar-alltenant">All Tenants <span class="all-listing-no active-listing-no"><?php echo nyc_count_user_by_role('tenant'); ?></span></a>
						</li>
						<li><a href="<?php echo get_site_url(); ?>/admin/add-tenant/" id="sidebar-addtenant"><i class="sl sl-icon-action-redo"></i> Add New Teanent</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Agents</li>
						<li class="admin-propertieslistings"><a href="<?= home_url();?>/all-agent/">All Agents <span class="all-listing-no active-listing-no"><?= get_all_agents() ?></span></a></li>
						<li><a href="<?= home_url();?>/add-agent/"><i class="sl sl-icon-action-redo"></i> Add New Agent</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Property Leads</li>
						<li class="admin-propertieslistings"><a href="<?= home_url();?>/all-leads/" >All leads <span class="all-listing-no active-listing-no"><?= get_all_leads() ?></span></a></li>
						<li class="admin-propertieslistings"><a href="<?= home_url();?>/recent-leads/" >Recently Added Lead<span class="active-listing-no">
						<?= get_recent_leads()?>
						</span></a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Deals</li>
						<li class="admin-propertieslistings">
							<a href="<?php echo get_site_url(); ?>/admin/deals/" id="sidebar-alldeals">All Deals <span class="all-listing-no active-listing-no"><?php echo nyc_get_count_custom_post_type('deals'); ?></span></a>
						</li>
						<li><a href="#"><i class="sl sl-icon-action-redo"></i> Add New Deal</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li><a href="<?php echo home_url(); ?>/change-password/"><i class="sl sl-icon-lock"></i> Change Password</a></li>
						<li><a href="<?php echo wp_logout_url(home_url().'/login-admin/'); ?>"><i class="sl sl-icon-power"></i> Log Out</a></li>
					</ul>

				</div>

			</div>
		</div>