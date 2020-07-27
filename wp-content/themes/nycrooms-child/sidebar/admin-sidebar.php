<!-- Widget -->
		<div class="col-md-3">
			<div class="sidebar left admin-dashboard-sidebar">

				<div class="my-account-nav-container">
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Account</li>
						<li><a href="<?= home_url();?>/admin/" id="sidebar-dashboard"><i class="sl sl-icon-screen-desktop"></i> Dashboard</a></li>

					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Listings</li>
						<li class="list-has--submenu admin-propertieslistings">
							<a href="#">
								<i class="sl sl-icon-docs"></i>Properties <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu show--submenu">
								<li><a href="<?php echo get_site_url(); ?>/admin-properties" id="sidebar-all_propert">All Properties <span class="all-listing-no active-listing-no"><?php echo nyc_get_properties_admin_by_status(array('draft', 'available', 'rented','Pending Review'))->post_count; ?></span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/admin-available-properties" id="sidebar-available_propert">Available <span class="active-listing-no"><?php echo nyc_get_properties_admin_by_status(array('available'))->post_count; ?></span></a></li>
								<li ><a href="<?php echo get_site_url(); ?>/admin-rented-properties" id="sidebar-rented_propert">Rented <span class="rented-listing-no"><?php echo nyc_get_properties_admin_by_status(array('rented'))->post_count; ?></span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/approved-properties-admin/" id="sidebar-approved_propert">Approved Properties<span class="unapproved-listing-no"><?php echo  nyc_get_admin_approved_properties(); ?></span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/admin-recently-properties" id="sidebar-unapproved_propert">UnApproved Properties<span class="unapproved-listing-no"><?php echo nyc_get_recent_properties(); ?></span></a></li>
							</ul>
						</li>
						<li><a href="<?= home_url() ?>/add-property-admin/"><i class="sl sl-icon-action-redo"></i> Submit New Property</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Property Owners</li>
						<li class="list-has--submenu admin-propertiesowner">
							<a href="#">
								<i class="sl sl-icon-docs"></i>Property Owners <i class="sl sl-icon-arrow-down listing-dropdown-icon"></i>
							</a>
							<ul class="list--submenu">
								<li><a href="<?php echo get_site_url(); ?>/admin-property-owner-all/" id="sidebar-propertiesowner">All Owners <span class="all-listing-no active-listing-no"><?=get_all_property_owner_counts() ?> </span></a></li>
								<li><a href="<?php echo get_site_url(); ?>/recent-property-owner/" id="sidebar-recentowner">Recently Added<span class="active-listing-no"><?=get_all_property_owner_recent_counts() ?></span></a></li>
							</ul>
						</li>
						<li><a href="<?php echo get_site_url(); ?>/add-property-owner/"><i class="sl sl-icon-action-redo"></i> Add New Owner</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Tenants</li>
						<li class="admin-propertieslistings">
							<a href="<?php echo get_site_url(); ?>/admin/all-tenants/" id="sidebar-alltenant">All Tenants <span class="all-listing-no active-listing-no"><?php echo nyc_count_user_by_role('tenant'); ?></span></a>
						</li>
						<li><a href="<?php echo get_site_url(); ?>/admin/add-tenant/" id="sidebar-addtenant"><i class="sl sl-icon-action-redo"></i> Add New Tenant</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Agents</li>
						<li class="admin-propertieslistings"><a href="<?= home_url();?>/all-agent/" id="sidebar-allagent">All Agents <span class="all-listing-no active-listing-no"><?= get_all_agents() ?></span></a></li>
						<li><a href="<?= home_url();?>/add-agent/"><i class="sl sl-icon-action-redo"></i> Add New Agent</a></li>
					</ul>

					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Property Leads</li>
						<li class="admin-propertieslistings"><a href="<?= home_url();?>/all-leads/" id="sidebar-allleads">All leads <span class="all-listing-no active-listing-no"><?= get_all_leads() ?></span></a></li>
						<!--li class="admin-propertieslistings"><a href="<?php //home_url();?>/recent-leads/" id="sidebar-recentleads">Recently Added Lead<span class="active-listing-no">
						<?php //get_recent_leads()?>
						</span></a></li--->
						<li><a href="<?= home_url() ?>/add-new-lead/"><i class="sl sl-icon-action-redo"></i>Add New Lead</a></li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Deals</li>
						<li class="admin-propertieslistings">
							<a href="<?php echo get_site_url(); ?>/admin/deals/" id="sidebar-alldeals">All Deals <span class="all-listing-no active-listing-no"><?php echo nyc_get_count_custom_post_type('deals'); ?></span></a>
						</li>
						<li><a href="<?php echo get_site_url(); ?>/admin/add-deal"><i class="sl sl-icon-action-redo"></i> Add New Deal</a></li>
					</ul>
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Payments</li>
						<li class="admin-propertieslistings">
							<a href="<?php echo get_site_url(); ?>/admin/dealsorders/" id="sidebar-allorders">All Payments<span class="all-listing-no active-listing-no"><?= nyc_get_count_custom_post_type('dealsorders') ?></span></a>
						</li>
					</ul>
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Contracts</li>
						<li class="admin-propertieslistings">
							<a href="<?php echo get_site_url(); ?>/admin/all-contracts/" id="sidebar-allcontracts">All Contracts<span class="all-listing-no active-listing-no"><?= nyc_get_count_custom_post_type('contracts') ?></span></a>
						</li>
					</ul>
					
					<ul class="my-account-nav">
						<li class="sub-nav-title">Manage Notifications</li>
						<li><a href="<?php echo get_site_url(); ?>/admin/all-notifications/">All Notifications <span class="all-listing-no active-listing-no"><?= get_notification_count() ?></span></a></li>
					</ul>
					
					<ul class="my-account-nav">
					    <li class="sub-nav-title">Manage Account</li>
					    <li><a href="<?= home_url();?>/profile-admin/" id="sidebar-profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
						<li><a href="<?php echo home_url(); ?>/change-password/?ppage=admin"><i class="sl sl-icon-lock"></i> Change Password</a></li>
						<li><a href="<?php echo wp_logout_url(home_url().'/login-admin/'); ?>"><i class="sl sl-icon-power"></i> Log Out</a></li>
						
					</ul>

				</div>

			</div>
		</div>