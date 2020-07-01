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
   <div class="col-md-12">
   <table>
   <tr>
    <th> Order No . </th>
	<td class="deal_order_number"><?php echo get_post_meta($post->ID,'order_id',true); ?></td>
   </tr>
   <tr>
		<th>Deal No.</th>
		<td class="deal_number"><?php echo get_post_meta($post->ID,'deal_id',true); ?></td>
   </tr>
   
   <tr>
		<th>Tenant Email</th>
		<td class="tenant_email"><?php echo get_post_meta($post->ID,'email_teanant',true); ?></td>
   </tr>
   
   <tr>
		<th>Payment No.</th>
		<td class="payment_number"><?php echo get_post_meta($post->ID,'payment_id',true); ?></td>
   </tr>
   <tr>
		<th> Payment Amount</th>
		<td class="deal_phone_number"><?php echo get_post_meta($post->ID,'payment_amount',true); "/Week" ?></td>
   </tr>
   <tr>
		<th> Payment currency</th>
		<td class="deal_phone_number"><?php echo get_post_meta($post->ID,'payment_currency',true); "/Week" ?></td>
   </tr>
   <tr>
		<th>Payment Mode</th>
		<td class="deal_phone_number"><?php echo ucfirst(str_replace("_"," ",get_post_meta($post->ID,'payment_mode',true))); ?></td>
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
		<th></i>Payment Created At</th>
		<td class="deal-stage-number"><?php echo date("F j, Y h:i A",strtotime(get_post_meta($post->ID,'payment_created_at',true))); ?></td>
   </tr>
    <?php
	$payment_mode  =	get_post_meta($post->ID,'payment_mode',true);
     if($payment_mode == 'square_payment'){
	?>
    <tr>
		<th>Reciept No. </th>
		<td class="deal-stage-number"><?php echo get_post_meta($post->ID,'receipt_number',true); ?></td>
   </tr>
    <tr>
		<th>Receipt Url </th>
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