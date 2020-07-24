<?php
nyc_property_admin_authority();
$post_id = get_query_var( 'orderid' ); 
$post = get_post($post_id);


if(empty($post) || ($post->post_type != 'dealsorders')){
	wp_redirect(get_site_url().'/admin/dealsorders'); 
}

get_header();
?>
<!-- Wrapper -->
<div id="wrapper">
  <div class="container">
   <div class="row">
     <p style="color:#274abb"><a href="<?= site_url().'/admin/dealsorders/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></p>
   <div class="col-md-12">
   <table>
   <?php 
      $checkorderno = get_post_meta($post->ID,'order_id',true);
	  $checkpaymentno = get_post_meta($post->ID,'payment_id',true);
	  $checkagent = get_post_meta($post->ID,'agent_involved',true); 
							
	  
   ?>
   <tr>
    <th> Invoice No . </th>
	<td class="deal_order_number"><?php echo get_post_meta($post->ID,'invoice_id',true); ?></td>
   </tr>
   <tr>
    <th> Invoice Pdf Link </th>
	<td class="deal_order_number"><?php
	$attachment_id = get_post_meta($post->ID,'payment_invoice',true);
	echo '<a href="'.wp_get_attachment_url($attachment_id).'" target="_blank">View Invoice<a>';

	?></td>
   </tr>
   
  <?php if($checkorderno): ?>
   <tr>
    <th> Order No . </th>
	<td class="deal_order_number"><?php echo get_post_meta($post->ID,'order_id',true); ?></td>
   </tr>
   <?php endif; ?>
   
   <tr>
		<th>Deal No.</th>
		<td class="deal_number"><?php echo get_post_meta($post->ID,'deal_id',true); ?></td>
   </tr>
   
   <tr>
		<th>Payment By </th>
		<td class="tenant_email"><?php echo get_post_meta($post->ID,'email_teanant',true); ?></td>
   </tr>
   
   <tr>
		<th>Agent Involved </th>
		<td class="tenant_email"><?php
		                        if($checkagent){
					                    echo get_post_meta($post->ID,'agent_name',true);
							    } else {
							            echo "N . A";
							     } 
							    ?>
		</td>
   </tr>
   
   <?php if($checkorderno): ?>
   <tr>
		<th>Payment No.</th>
		<td class="payment_number"><?php echo get_post_meta($post->ID,'payment_id',true); ?></td>
   </tr>
   <?php endif; ?>
   <tr>
		<th> Payment Amount</th>
		<td class="deal_phone_number"><?php echo get_post_meta($post->ID,'payment_amount',true); "/Week" ?></td>
   </tr>
   <tr>
		<th> Payment currency</th>
		<td class="deal_phone_number"><?php echo get_post_meta($post->ID,'payment_currency',true); "/Week" ?></td>
   </tr>
   <tr>
		<th>Collection Method</th>
		<td class="deal_phone_number">
		<?php 
		$payment_mode =  get_post_meta($post->ID,'payment_mode',true); 
		if($payment_mode == 'square_payment'){
			echo "Online";
		} else {
			echo "Offline";
		} 
		?>
		</td>
   </tr>
   <tr>
	    <th>Payment Source</th>
		<td class="deal-stage-number"><?php echo get_post_meta($post->ID,'payment_source_type',true); ?></td>
   </tr>
   <tr>
		<th></i>Payment Status</th>
		<td class="deal-stage-number"><?php echo get_post_meta($post->ID,'payment_status',true); ?></td>
   </tr>
   <tr>
		<th></i>Payment Date</th>
		<td class="deal-stage-number"><?php echo date("F j, Y h:i A",strtotime(get_post_meta($post->ID,'payment_created_at',true))); ?></td>
   </tr>
    <?php
	$payment_mode  =	get_post_meta($post->ID,'payment_mode',true);
     if($payment_mode == 'square_payment'){
	?>
    <tr>
		<th>Square Reciept No. </th>
		<td class="deal-stage-number"><?php echo get_post_meta($post->ID,'receipt_number',true); ?></td>
   </tr>
    <tr>
		<th>Sqaure Receipt Url </th>
		<td class="deal-stage-number"><?php echo get_post_meta($post->ID,'receipt_url',true); ?></td>
   </tr>
   
   <?php
   }
   ?>
   </table>
   </div>
  </div>
</div>
<!-- Wrapper / End -->
<?php
get_footer();
?>