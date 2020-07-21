<?php
get_header();
?>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">
 <div class="container">
	<div class="row">
	  <?php include(locate_template('sidebar/admin-sidebar.php')); ?>
         <div class="col-md-9">
		  <div class="recent-activity">	
						<div class="act-title">
							<h5>Recent Activities</h5>
						</div>					
						<ul class="act-wrap">
						<?php 
						global $wpdb;
						$get_notification = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."notification ORDER BY id DESC LIMIT 8;");
						if($get_notification){
							foreach($get_notification as $notification){
						?>
							<li class="alert br-o fade show noti-row-<?php echo $notification->id; ?>">
								<?php echo $notification->message; ?>
								<button type="button" data-id="<?php echo $notification->id; ?>" class="close close_notification" >
									<span aria-hidden="true"><i class="sl sl-icon-close"></i></span>
								</button>
								<p><?php echo nyc_time_elapsed_string($notification->created_at); ?></p>
							</li>
						<?php } } else{ ?>
							<li class="alert br-o fade show">
							   No Notification Found
							</li>					
						<?php } ?>
						</ul>
		   </div>
		 </div>
	   </div>
	  
	</div>
 </div>
</div>
<?php
get_footer();
?>
<script>
jQuery(document).ready(function($) {
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';	
	jQuery(".close_notification").click(function(e){
		e.preventDefault();
		var noti_id = jQuery(this).attr("data-id");
		jQuery(".noti-row-"+noti_id).remove();
		var data = {
			noti_id: noti_id,
			action: "nyc_remove_notification",
		};	   
		$.post(ajaxurl, data, function(response) {
		});
	});
	jQuery('#sidebar-dashboard').addClass('current');
});
</script>