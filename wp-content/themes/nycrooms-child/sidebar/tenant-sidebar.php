<?php 
$current_user = wp_get_current_user();
$no_of_bookmark = get_user_meta($current_user->ID,'nyc_bookmark',true);

?>
<div class="col-md-4">
	<div class="sidebar left">
		<div class="my-account-nav-container">	
			<ul class="my-account-nav">
				<li class="sub-nav-title">Manage Account</li>
				<li><a href="<?php echo home_url(); ?>/tenant/" id="sidebar-profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
			</ul>
			
			<ul class="my-account-nav">
				<li class="sub-nav-title">Manage Listings</li>
				<li><a href="<?php echo home_url(); ?>/tenant/hired-property/" id="sidebar-hiredproperty"><i class="sl sl-icon-docs"></i> Hired Properties <span class="all-listing-no active-listing-no"><?php echo count_tenant_hired_property(); ?></span></a></li>
				<li><a href="<?php echo home_url(); ?>/tenant/bookmarked-properties/" id="sidebar-bookmark"><i class="sl sl-icon-star"></i> Bookmarked Properties <span class="all-listing-no active-listing-no"><?php echo ($no_of_bookmark) ? count($no_of_bookmark) : 0; ?></span></a></li>
			</ul>
			<ul class="my-account-nav">
				<li class="sub-nav-title">Manage Deals</li>
				<li class="admin-propertieslistings">
					<a href="<?php echo get_site_url(); ?>/tenant/deals/" id="sidebar-alldeals">All Deals<span class="all-listing-no active-listing-no"><?php echo count_deal_of_tenant($current_user->user_email); ?></span></a>
				</li>
			</ul>
			<ul class="my-account-nav">
				<li class="sub-nav-title">Manage Contracts</li>
				<li class="admin-propertieslistings">
					<a href="<?php echo home_url(); ?>/tenant/all-contracts/" id="sidebar-allcontracts"><i class="sl sl-icon-book-open"></i> All Contracts <span class="all-listing-no active-listing-no"><?= nyc_get_count_post_type_meta('contracts','tenant_email',$current_user->user_email) ?></span></a>
				</li>
			</ul>
			<ul class="my-account-nav">
				<li><a href="<?php echo home_url(); ?>/change-password/?ppage=tenant"><i class="sl sl-icon-lock"></i> Change Password</a></li>
				<li><a href="<?php echo wp_logout_url(home_url().'/tenant-registration/'); ?>"><i class="sl sl-icon-power"></i> Log Out</a></li>
			</ul>
		</div>
	</div>
</div>