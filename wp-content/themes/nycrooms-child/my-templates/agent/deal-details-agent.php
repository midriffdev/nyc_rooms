<?php
require get_stylesheet_directory(). '/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
$dealid = base64_decode(get_query_var( 'id' ));
$get_post = get_post($dealid);
if(!$get_post){
       wp_redirect(home_url());
}
$deal_source  =   get_post_meta($dealid,'lead_source',true);
$deal_stage   =   get_post_meta($dealid,'deal_stage',true);
$lead_source  =   get_post_meta($dealid,'lead_source',true);
$name         =   get_post_meta($dealid,'name',true);
$email        =   get_post_meta($dealid,'email',true);
$phone        =   get_post_meta($dealid,'phone',true);
$description  =   get_post_meta($dealid,'description',true);
$property_id  =   get_post_meta($dealid,'property_id',true);
$admin_notes  =   get_post_meta($dealid,'admin_notes',true);
$deal_price   =   get_post_meta($dealid,'deal_price',true);

$agent_notes = '';
if(isset($_POST['save_notes'])){
  update_post_meta($_POST['deal_id'],'agent_notes',$_POST['summary']);
  $agent_notes = "Notes saved successfully";
}
$agent_saved_notes  =  get_post_meta($dealid,'agent_notes',true);
$successorder = '';
if(isset($_POST['deal_ordersubmit'])){
          $invoice_id                =   uniqid();
          $deal_id                   =   $_POST['deal_id'];
		  $name_teanant              =   get_post_meta($deal_id,'name',true);
		  $email_teanant             =   get_post_meta($deal_id,'email',true);
		  $phone_teanant             =   get_post_meta($deal_id,'phone',true);
		  $get_selected_agent             =   get_post_meta($deal_id,'selectedAgent',true);
		  $payment_created_at        =   $_POST['deal_order_date'] .' '.$_POST['deal_order_time'];
		  $paymentamount             =   (int)$_POST['deal_order_price'];
		  $paymentcurrency           =   'USD';
		  $paymentstatus             =   'COMPLETED';
		  $payment_source_type       =   'CASH';
          $dealorderid = wp_insert_post(array (
								'post_type'		=> 'dealsorders',
								'post_title' 	=> '#'.$invoice_id,
								'post_content' 	=> 'New Order Created',
								'post_author' 	=> 1,
								'post_status' 	=> 'publish',
		                  ));
		  
		  if($dealorderid){
		     
		     update_post_meta($dealorderid, 'deal_id', $deal_id);
			 update_post_meta($dealorderid, 'invoice_id', $invoice_id);
			 if($get_selected_agent){
			    $agent_name = get_user_meta($get_selected_agent, 'user_full_name', true);
			    $agent_email = get_user_meta($get_selected_agent, 'user_agent_email', true);
			    $agent_phone = get_user_meta($get_selected_agent, 'user_phone', true);
				update_post_meta($dealorderid, 'agent_involved', $get_selected_agent);
			    update_post_meta($dealorderid, 'agent_name', $agent_name);
				update_post_meta($dealorderid, 'agent_email', $agent_email);
				update_post_meta($dealorderid, 'agent_phone', $agent_phone); 
			 }
			 
			 update_post_meta($dealorderid, 'name_teanant', $name_teanant);
			 update_post_meta($dealorderid, 'phone_teanant', $phone_teanant);
			 update_post_meta($dealorderid, 'email_teanant', $email_teanant);
			 update_post_meta($dealorderid, 'payment_created_at', $payment_created_at);
			 update_post_meta($dealorderid, 'payment_amount', $paymentamount);
			 update_post_meta($dealorderid, 'payment_currency', $paymentcurrency);
			 update_post_meta($dealorderid, 'payment_status', $paymentstatus);
			 update_post_meta($dealorderid, 'payment_source_type', $payment_source_type);
			 update_post_meta($dealorderid, 'payment_mode', 'Cash_payment');
			$notification = "A Payment has been Done by Agent on Deal no ".$deal_id;
			nyc_add_noticication($notification);				 
			  /*----------------Start creating invoice ---------------------------- */
														  $html = '<html>
										<head>
											<meta http-equiv="Content-Type" content="charset=utf-8" />
											<style type="text/css">
												@page {
													margin: 0;
												}
												* { padding: 0; margin: 0; }
												@font-face {
													font-family: "varelaround";           
													src: local("VarelaRound-Regular"), url("fonts/VarelaRound-Regular.ttf") format("truetype");
													font-weight: normal;
													font-style: normal;
												}
												body{
													font-family: "varelaround";
													color: #333;
													background-color: #fff;
													height:100%;
												}
												body b, table th{
													font-weight: normal;
													font-family: "varelaround";
												}
												table td, table th{
													vertical-align: top;
												}
												span{
													font-family: "varelaround";
													color: #333;
													font-size:14px;
												}
												h2,p{
												  font-family: "varelaround";
												  color: #333;  
												}
											</style>
										</head>
										<body>
										<table style="width:100%;padding:20px;">
										   <tr>
											  <td colspan="2">
												 <table style="width:100%;">
													<tbody>
													   <tr>
														  <td colspan="2" style="padding-bottom:10px;">
															 <table style="width:100%;">
																<tbody>
																   <tr>
																	  <td style="width:50%;">
																		 <img src="https://nycrooms.midriffdevelopers.live/wp-content/uploads/2020/06/logo.png" style="width:150px;">
																	  </td>
																	  <td style="width:50%;padding: 0 0px 0 10%;text-align: right;">
																		 <h2 style="text-align: right;margin-top: 0;margin-bottom: 0;">NYC Room 4 Rent</h2>
																		 <p>606 WEST 145TH STREET NY NY 10031<br>212-368-2685<br>WWW.NYCROOMS4RENT.COM
																		 </p>
																	  </td>
																   </tr>
																   </tbody>
															 </table>
														  </td>
													   </tr>
													   <tr>
														  <td colspan="2" style="border-top:1px solid #000;padding-top:10px;">
																<table style="width:100%;border-collapse: collapse;">
																   <tbody>
																	  <tr>
																		 <td>
																			<h2 style="margin: 0;font-weight:normal;font-size: 1.4em;">INVOICE TO:</h2>
																			<p style="font-size: 1em;font-weight: normal;margin: 0;">'.$name_teanant.'</p>
																			<p style="font-size: 1em;font-weight: normal;margin: 0;">Phone No: '.$phone_teanant.'</p>
																			<p font-size: 1em;font-weight: normal;margin: 0;">'.$email_teanant.'</p>
																		 </td>
																		 <td style="text-align: right;">
																		 <h2 style="margin: 0;font-weight:normal;font-size: 1.4em;">INVOICE DETAIlS:</h2>
																		 <p style="font-size: 1em;font-weight: normal;margin: 0;">Invoice No. '.$invoice_id.'</p>
																		 <p style="font-size: 1em;font-weight: normal;margin: 0;">Date: '.date("F j, Y").'</p>
																		 </td>
																	  </tr>
																  </tbody>
																</table>
														  </td>
													   </tr>
													   <tr>
														  <td colspan="2" style="padding-top:50px;padding-right:5px;">
															 <table style="width:100%;border-collapse:collapse;">
																<tbody>
																   <tr>
																	  <td colspan="2">
																		 <table style="width:100%;border-collapse:collapse;">
																			<tr style="background-color:#a3b687;">
																			   <td style="90%;padding:0 2px;">
																			   <p style="text-align:left;color:#fff;margin:0px 0px 4px 0px;">Description</p>
																			   </td>
																			   <td style="10%;padding:0 2px;">
																			   <p style="text-align:right;color:#fff;margin:0px 0px 4px 0px;">Amount</p>
																			   </td>
																			</tr>
																		 </table>
																	  </td>
																   </tr>
																   <tr>
																	   <td style="width:90%;padding:0 2px;">
																		 <table style="width:100%;">
																			<tr>
																			   <td><p style="font-size: 14px;font-weight: normal;margin: 0;">Deal #'.$deal_id.':</p></td>
																			</tr>
																		 </table>
																	   </td>
																	   <td  style="width:10%;padding:0 2px;">
																		 <table style="width:100%;">
																			<tr>
																			   <td><p style="font-size: 14px;text-align:right;font-weight: normal;margin: 0;">$'.$paymentamount.'</p></td>
																			</tr>
																		 </table>
																	   </td>
																   </tr>
																   <tr>
																   <td style="width:90%;padding:0 2px;">
																		 <table style="width:100%;">
																			<tr>
																			   <td><p style="font-size: 14px;font-weight: normal;margin: 0;">Transaction ID : N.A</p></td>
																			</tr>
																			
																		 </table>
																	   </td>
																	   <td  style="width:10%;padding:0 2px;">
																		 <table style="width:100%;">
																			<tr>
																			    <td><p style="font-size: 14px;text-align:right;font-weight: normal;margin: 0;"></p></td>
																			   
																			</tr>
																			
																		 </table>
																	   </td>
																	</tr>
																	<tr>
																		   <td style="width:90%;padding:0 2px;">
																			 <table style="width:100%;">
																				<tr>
																				   <td><p style="font-size: 14px;font-weight: normal;margin: 0;">Payment Mode : Cash</p></td>
																				</tr>
																				
																			 </table>
																		   </td>
																		   <td  style="width:10%;padding:0 2px;">
																			 <table style="width:100%;">
																				<tr>
																					<td><p style="font-size: 14px;text-align:right;font-weight: normal;margin: 0;"></p></td>
																				   
																				</tr>
																				
																			 </table>
																		   </td>
																	</tr>
																   <tr>
																	   <td colspan="2" style="padding-right:5px;padding-top:5px">
																	   <table style="width:100%;border-top:1px solid #000;">
																	   <tr>
																	   <td style="width:70%;"></td>
																	   <td style="width:20%;">
																	   <p style="font-size: 14px;font-weight: normal;margin: 0;"><b>Total:</b></p>
																	   </td>
																	   <td style="width:10%;">
																	   <p style="font-size: 14px;font-weight: normal;margin: 0;text-align:right">$'.$paymentamount.'</p>
																	   </tr>
																	   </table>
																	   </td>
																   </tr>
																   
																</tbody>
															 </table>
														  </td>
													   </tr>
													   <tr>
													   <td colspan="2" style="">
													   <table style="width:100%;margin-top:50px;">
													   <tr><td>
										<p style="font-size: 16px;font-weight: 500;margin: 20px 0 15px 0 ;"><span style="font-weight:bold">Payments Terms:</span></p>
										<ul style="padding-left:10px;"><li style="font-size: 14px;font-weight: normal;margin: 0;">You are paying a service fee to NYC Rooms For Rent Inc. to provide listings of available rooms. </li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">NYC Rooms for Rent will arrange, conduct, coordinate, handles or cause meetings between you and the current occupant of a legally occupied property, including apartment housing, who wishes to share that housing with you or more individuals as a private dwelling.</li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">NYC Rooms For Rent Inc. will do the aforementioned for an unlimited amount of time until you are placed in a room of your likings.</li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">NYC Rooms for Rent Inc. is not responsible if landlord rejects you for not meeting the landlord qualifications, however NYC Rooms for Rent Inc. will continue to provide you listings. </li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">After you move into one of our listings NYC Rooms For Rent Inc. is not responsible for furnishing further listings.</li>
										<li style="font-size: 14px;font-weight: normal;margin: 0;">The service fee paid to NYC Rooms For Rent is non-refundable.</li></ul>
													   </td></tr>
													   </table>
													   </td>
													   </tr>
													</tbody>
												 </table>
											  </td>
										   </tr>
										</table>
										</div>
										</body>
										</html>';
										
										// instantiate and use the dompdf class
										$dompdf = new Dompdf();
										$dompdf->loadHtml($html, 'UTF-8');
                                        $dompdf->set_option('isRemoteEnabled', TRUE);
										// (Optional) Setup the paper size and orientation
										$dompdf->setPaper('A4');

										$dompdf->set_option('defaultMediaType', 'all');
										$dompdf->set_option('isFontSubsettingEnabled', true);

										// Render the HTML as PDF
										$dompdf->render();
										$uploaddir = wp_upload_dir();
										$uploadfile = $uploaddir['path'].'/invoice_'.$invoice_id.'_'.$deal_id.'.pdf';
										//save the pdf file on the server
										file_put_contents($uploadfile, $dompdf->output()); 
										$wp_filetype = wp_check_filetype(basename($uploadfile), null);
										$attachment = array(
															'post_mime_type' => $wp_filetype['type'],
															'post_title' => preg_replace('/\.[^.]+$/', '', basename($uploadfile)),
															'post_status' => 'inherit',
														);
										$attach_id = wp_insert_attachment($attachment, $uploadfile); // adding the image to th media
										require_once(ABSPATH . 'wp-admin/includes/image.php');
										$attach_data = wp_generate_attachment_metadata($attach_id, $uploadfile); 
										$update = wp_update_attachment_metadata($attach_id, $attach_data); // Updated the image details
										update_post_meta($deal_id,'payment_invoice_doc', $attach_id);
                                        update_post_meta($dealorderid, 'payment_invoice', $attach_id);
										
										
			 /*----------------End creating invoice ---------------------------- */
			 
			 
			 
			 
			 
			/*----------- start sending mail to admin -----------------------*/
			$attachment_id = get_post_meta($deal_id,'payment_invoice_doc',true);
			$invoice_attchment = '<a href="'. wp_get_attachment_url($attachment_id) . '" download >'.wp_get_attachment_url($attachment_id).'</a>';
			$subject = "New payment created on deal no -".$deal_id;
			$to = get_option('admin_email');
			$msg  = __( 'Hello Admin,') . "\r\n\r\n";
			$msg .= "<p>New Payment has been done on Deal no. : ".$deal_id." with Following Invoice No. : ".$invoice_id." via Cash Payment.<p><p>Following are Details of Payment.</p>";
			$msg .= sprintf( __("<p>Invoice No. : %s</p>"),$invoice_id);
			$msg .= sprintf( __("<p>Deal No. : %s</p>"),$deal_id);
			$msg .= sprintf( __("<p> Invoice Attachment Url : %s</p>"),$invoice_attchment);
			$msg .= "<p>Admin Deal link : <a href='". get_site_url() ."/admin/deals/details/". $deal_id . "'>".get_site_url()."/admin/deals/details/".$deal_id."</a></p>";
			$msg .= sprintf( __("<p>Payment By Tenant: %s</p>"),$name_teanant);
			$msg .= sprintf( __("<p>Tenant Email : %s</p>"),$email_teanant);
			$msg .= sprintf( __("<p>Tenant Phone : %s</p>"),$phone_teanant);
			if($get_selected_agent){
			
			   $msg .= sprintf( __("<p>Agent Involved : %s</p>"),$agent_name);
			   $msg .= sprintf( __("<p>Agent Email : %s</p>"),$agent_email);
			   $msg .= sprintf( __("<p>Agent Phone : %s</p>"),$agent_phone);
			   
			}
			
			$msg .= sprintf( __("<p>Payment Date : %s</p>"),date("F j, Y",strtotime($payment_created_at)));
			$msg .= sprintf( __("<p>Payment Amount : %s</p>"),$paymentamount);
			$msg .= sprintf( __("<p>Payment Currency : %s</p>"),$paymentcurrency);
			$msg .= sprintf( __("<p>Payment Status : %s</p>"),$paymentstatus);
			$msg .= sprintf( __("<p>Payment Source Type : %s</p>"),$payment_source_type);
			$msg .= sprintf( __("<p>Payment Mode : %s</p>"),'Cash Payment');
		    $msg .= sprintf( __("<p>Collection Method : %s</p>"),'Offline');
			$msg .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
			$headers = array('Content-Type: text/html; charset=UTF-8');
		    $sent = wp_mail($to, $subject, $msg,$headers);
			
			/* ----------- End Sending mail to admin  ---------------- */
			
			/* ----------- Start Sending mail to Tenant  ---------------- */
			
			$subject1 = "Payment Done On Deal No. -".$deal_id;
			$to1 = $email_teanant;
			$msg1  = sprintf( __('Hello %s',$name_teanant));
			$msg1 .= "<p>Your Payment has been done on Deal no. : ".$deal_id." with Following Invoice No. : ".$invoice_id." via Cash Payment.<p><p>Following are Details of Payment.</p>";
			$msg1 .= sprintf( __("<p>Invoice No. : %s</p>"),$invoice_id);
			$msg1 .= sprintf( __("<p>Deal No. : %s</p>"),$deal_id);
			$msg1 .= sprintf( __("<p> Invoice Attachment Url : %s</p>"),$invoice_attchment);
			$msg1 .= sprintf( __("<p>Payment Date : %s</p>"),date("F j, Y",strtotime($payment_created_at)));
			$msg1 .= sprintf( __("<p>Payment Amount : %s</p>"),$paymentamount);
			$msg1 .= sprintf( __("<p>Payment Currency : %s</p>"),$paymentcurrency);
			$msg1 .= sprintf( __("<p>Payment Status : %s</p>"),$paymentstatus);
			$msg1 .= sprintf( __("<p>Payment Source Type : %s</p>"),$payment_source_type);
			$msg1 .= sprintf( __("<p>Payment Mode : %s</p>"),'Cash Payment');
		    $msg1 .= sprintf( __("<p>Collection Method : %s</p>"),'Offline');
			$msg1 .= sprintf( __("<p>Download  Payment invoice By clicking on button Below:</p><p>%s</p>"),$invoice_attchment);
			$msg1 .= __( 'Thanks!', 'personalize-login' ) . "\r\n";
			$headers1 = array('Content-Type: text/html; charset=UTF-8');
		    $sent1 = wp_mail($to1, $subject1, $msg1,$headers1);
			
			/* ----------- End Sending mail to Tenant  ---------------- */
			
			$successorder = "Payment Created Successfully";
			
		  }
		  
  
}

$query_args = array(
	'post_type'  => 'dealsorders',
	'meta_query' => array(
	    array(
			'key'   => 'deal_id',
			'value' => $dealid ,
	    ),
	)
);

$check_deal_orders = new WP_Query( $query_args );

$query_args1 = array(
	'post_type'  => 'contracts',
	'meta_query' => array(
	    array(
			'key'   => 'deal_id',
			'value' => $dealid ,
	    ),
	)
);

$check_contracts = new WP_Query( $query_args1 );


get_header();
?>
<!-- Wrapper -->
<div id="wrapper">


<!-- Content
================================================== -->
<div class="deal-detail-container">		
    <?php
    $userrole = wp_get_current_user();
	 if(!empty($userrole)){
	     if($userrole->roles[0] == "administrator"){
	?>
	   <p style="color:#274abb"><a href="<?= site_url().'/admin/deals/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></p>
	<?php     
		 }
	   }
	?>
	<div class="container">

		<!------Stage 1---->
		<div class="dealdetail--stageonecont">
			<div class="row">
				<div class="col-md-12">
					<div class="current-stage-title">
						<h3>Stage 1</h3>
					</div>
				</div>
			</div>

			<div class="row dealdetail--stageinnersection">
				 <?php  if($lead_source == "Property Form" || $lead_source == "Custom Deal"){
			   $property_id  =   get_post_meta($dealid,'property_id',true);

			   ?>
				   <div class="col-md-6">
						<div class="leaddetail-teanentdetail dealdetail__tenantdetail">
						<h2>Tenant Details</h2>
						<div class="lead-teanent_details">
							<ul>
								<li>
									<p>Name: </p>
									<span><?php echo $name; ?></span>
								</li>
								<li>
									<p>Email:</p>
									<span><?php echo $email; ?></span>
								</li>
								<li>
									<p>Phone:</p>
									<span><?php echo $phone; ?></span>
								</li>
								<li>
									<p>Description:</p>
									<span><?php echo $description; ?></span>
								</li>
							</ul>
						</div>
						</div>
					</div>
			    <?php if($property_id){ ?>
				<div class="col-md-6">
				
					<div class="dealdetail-propertydetail">
						<h2>Property In Reference</h2>
						<table class="manage-table responsive-table">
						<tbody>
						<!-- Item #1 -->
							<tr>
							   
							    <td class="title-container lead-detail-propertytitlesec">
									<?php 
									 $galleryfiles =  get_post_meta($property_id,'gallery_files',true);
									 if($galleryfiles){
										$galleryfiles = explode(',',$galleryfiles);
										$attachment_id = get_post_meta($property_id,$galleryfiles[0],true);
										$imgsrc = wp_get_attachment_image_src( $attachment_id,array('300', '200'));
										echo wp_get_attachment_image( $attachment_id, array('768', '512'), "", array( "class" => "img-responsive" ) );
									 }
									?>in
									<div class="title">
									<h4><a href="<?= get_post_permalink($property_id) ?>"><?php echo get_the_title($property_id); ?></a></h4>
									<span><?= get_post_meta($property_id,'address',true); ?> </span>
									<p>Owner: <span><?=get_post_meta($property_id,'contact_name',true) ?></span></p>
									<span class="table-property-price">$<?= get_post_meta($property_id,'price',true); ?> / Weekly</span> <span class="active--property"><?= get_post_meta($property_id,'status',true); ?></span>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
                <?php } ?>
                <?php } ?>
				<div class="col-md-12">
					<?php if($lead_source == "Appointment Form" || $lead_source == "Manual Added"){ ?>
					<div class="dealdetal__appointmentdetail-sec">
						<div class="leaddetail-teanentdetail dealdetail__tenantdetail">
						
							<?php if($lead_source == "Appointment Form"):?>
							<h2>Appointment Details</h2>
							<?php endif; ?>
							
							<?php if($lead_source == "Manual Added"):?>
							<h2>Deal Details</h2>
							<?php endif; ?>
							
							<div class="lead-teanent_details">
								<ul>
									<li>
										<p>Name: </p>
										<span><?php echo $name; ?></span>
									</li>
									<li>
										<p>Email:</p>
										<span><?php echo $email; ?></span>
									</li>
									<li>
										<p>Phone:</p>
										<span><?php echo $phone; ?></span>
									</li>
									<li>
										<p>Date:</p>
										<span><?php echo get_the_date('l F j, Y',$dealid); ?></span>
									</li>
									<li>
										<p>Description:</p>
										<?php 
										 if($description){
										?>
										<span><?php echo $description; ?></span>
										<?php
										} else {
										?>
										<span><?php echo "N . A"; ?></span>
										<?php 
										}
										?>
									</li>
								</ul>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>

				<div class="col-md-6">
					<div class="dealdetail-agent-addnotes">
						<h3>Agent Notes:</h3>
						<form method="post">
						<input type="hidden" name="deal_id" value="<?= $dealid ?>">
						<textarea class="WYSIWYG" name="summary" cols="40" rows="3" id="summary" spellcheck="true"><?php if($agent_saved_notes){echo $agent_saved_notes;}?></textarea>
						<?php if(empty($check_contracts->posts)): ?>
						<input type="submit" name="save_notes" value="Save notes">
						<?php endif; ?>
						</form>
					</div>
				</div>

				<div class="col-md-12">
					<div class="deal-detail-payment-tobedone">
						<?php if($deal_price): ?><h3>Amount to be Paid: <span>$<?= $deal_price ?></span></h3> <?php endif;  ?>
						<ul class="dealdetail-tenant-actionbuttons dealdetail-agent-actionbuttons">
							<li>
							<?php
							if(empty($check_deal_orders->posts)){
							  if(empty($check_contracts->posts)):  
							?>
							   <button class="dealdetail-tenant-paynowb" data-toggle="modal" data-target="#agentlogpayment">Log Payment</button>
							 <?php 
							   endif;
							 } else { ?>
							  <button class="dealdetail-tenant-paynowb" disabled>Payment Done</button>
							 <?php
							 }
							 ?>
							</li>
							<li>
							    <?php 
								if(empty($check_contracts->posts)):
								if(empty($check_deal_orders->posts)){ 
								?>
								<button class="dealdetail-tenant-reqagentb" data-toggle="modal" data-target="#send_payment_link_by_agent" >Send Payment Link</button>
								<?php 
								}
								endif;
								?>
							</li>
						</ul>
					</div>
				</div>
				
                <div class="col-md-12">
					 <?php if($admin_notes): ?>
					<div class="deal-detail-tenant-adminnotes">
						<h2>Admin Notes</h2>
						<p><?=$admin_notes ?></p>
					</div>
					<?php endif; ?>
				</div>
				
				<div class="col-md-12">
						<h3>Kindly Upload The Documents Here</h3>
						<div class="submit-section prop_req_docs">
						   <form action="<?= site_url() ?>/tenant/deal-details-tenant/<?php echo $dealid; ?>" class="dropzone dropzone_tenant_documents" ></form>
						  <?php if(empty($check_contracts->posts)): ?>
						   <p align=center><button type="button" class="button save_tenant_doc">Save Documents</button></p>
						   <?php endif; ?>
					   </div>
				  </div>
				  
				
				
				
				<div class="col-md-12">
					<div class="dealdetail-instruction section">
						<h3>Instructions</h3>
						<ul>
							<li>1. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
							<li>2. it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</li>
							<li>3. "On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment.</li>
							<li>4. "But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system.</li>
							<li>5. "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</li>
							<li>6. "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
							<li>7. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</li>
						</ul>
					</div>
				</div>

			</div>

		</div>

		<!----Stage 2---->
		 <?php if(empty($check_contracts->posts)): ?>
		<div class="row deal-stage-2">
             
			<div class="current-stage-title">
				<h3>Stage 2</h3>
			</div>

			<div class="deal-detail__suggestedpropertysec">
				<h3>Selected Properties</h3>
				<ul class='nyc_deal_selected_property_section'>
				
				</ul>
			</div>
            
			<div class="deal-stage-property-suggest">
				<div class="deal-proprtysug-title">
					<h2>Suggest Property</h2>
				</div>
				<div class="admin-advanced-searchfilter">
					<h2>Advanced filter</h2>
					<div class="row with-forms">
						<!-- Form -->
						<div class="main-search-box no-shadow">

							<!-- Row With Forms -->
							<div class="row with-forms">
								<!-- Main Search Input -->
								<div class="col-md-12">
									<input type="text" placeholder="Enter Property Name" id="search_name" value=""/>
								</div>
							</div>
							<!-- Row With Forms / End -->

							<!-- Row With Forms -->
							<div class="row with-forms">
								<div class="col-md-4">
									<select data-placeholder="Any Status" id="search_status" class="chosen-select-no-single" >
										<option value="">Any Status</option>	
										<option value="available">Available</option>
										<option value="rented">Rented</option>
									</select>
								</div>
								<div class="col-md-4">
									<select data-placeholder="Any Type" id="search_type" class="chosen-select-no-single" >
										<option value="">Any Type</option>	
										<?php 
										$types = get_terms([
											'taxonomy' => 'types',
											'hide_empty' => false,
										]); 
										
										foreach($types as $type)
										{
											echo '<option value="'.$type->term_id.'">'.$type->name.'</option>';
										}				
										?>
									</select>
								</div>
								<div class="col-md-4">
									<select data-placeholder="Any Status" id="search_accom" class="chosen-select-no-single" >
										<option value="">Type of Accomodation</option>	
										<option value="Apartment">Apartment</option>
										<option value="Room">Room</option>
									</select>
								</div>
							</div>
							<!-- Row With Forms / End -->	
							

							<!-- Row With Forms -->
							<div class="row with-forms">

								<div class="col-md-4">
									<select data-placeholder="Any Status" id="search_rooms" class="chosen-select-no-single" >
										<option value="">Rooms</option>	
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="5+">More than 5</option>
									</select>
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" id="search_min_price" placeholder="Min Price" data-unit="USD">
										<select>		
											<option>Min Price</option>
											<option>1000</option>
											<option>2000</option>	
											<option>3000</option>	
											<option>4000</option>	
											<option>5000</option>	
											<option>10000</option>	
											<option>15000</option>	
											<option>20000</option>	
											<option>30000</option>
											<option>40000</option>
											<option>50000</option>
											<option>60000</option>
											<option>70000</option>
											<option>80000</option>
											<option>90000</option>
											<option>100000</option>
											<option>110000</option>
											<option>120000</option>
											<option>130000</option>
											<option>140000</option>
											<option>150000</option>
										</select>
									</div>
									<!-- Select Input / End -->
								</div>
								<div class="col-md-4">
									<!-- Select Input -->
									<div class="select-input disabled-first-option">
										<input type="text" id="search_max_price" placeholder="Max Price" data-unit="USD">
										<select>		
											<option>Max Price</option>
											<option>1000</option>
											<option>2000</option>	
											<option>3000</option>	
											<option>4000</option>	
											<option>5000</option>	
											<option>10000</option>	
											<option>15000</option>	
											<option>20000</option>	
											<option>30000</option>
											<option>40000</option>
											<option>50000</option>
											<option>60000</option>
											<option>70000</option>
											<option>80000</option>
											<option>90000</option>
											<option>100000</option>
											<option>110000</option>
											<option>120000</option>
											<option>130000</option>
											<option>140000</option>
											<option>150000</option>
										</select>
									</div>
									<!-- Select Input / End -->
								</div>

							</div>
							<!-- Row With Forms / End -->

							<!-- Search Button -->
							<div class="row with-forms">
								<div class="col-md-12">
									<button class="button fs-map-btn deal_search_property">Search</button>
								</div>
							</div>

						</div>
						<!-- Box / End -->
					</div>
				</div>
				<div class='nyc_load_property'>

				</div>
				<div class="create-deal-btnsec deal-detail-dealbutton">
					<button type="button" class="btn btn-primary popup__button deal_select_property">
					 Select Properties
					</button>
				</div>

			</div>
			
		</div>
	    <?php endif; ?>
	</div>
</div>


<div class="margin-top-55"></div>


<!-- Modal for Amount details -->
<div class="modal fade popup-main--section" id="fillamountdetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="fillamount-popup">
        	<h3>Fill Amount Details</h3>
 			<ul>
 				<li>
 					<h5>Price <i class="tip" data-tip-content="Type overall or monthly price if property is for rent"></i></h5>
					<div class="select-input disabled-first-option">
						<input type="text" data-unit="USD">
					</div>
 				</li>
 				<li>
 					<h5>Date</h5>
 					<input class="search-field" type="text" value="<?php echo date("Y-m-d"); ?>"/>
 				</li>
 				<li>
 					<h5>Time</h5>
 					<input class="search-field" type="text" value="<?php echo date("H:i"); ?>"/>
 				</li>
 			</ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-secondary dealdetail-popupsub">Submit</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for Agent Log payment -->
<div class="modal fade popup-main--section" id="agentlogpayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form method="post">
      <div class="modal-body">
        <div class="fillamount-popup">
        	<h3>Fill Amount Details</h3>
 			<ul>
 				<li>
 					<h5>Price <i class="tip" data-tip-content="Type overall or monthly price if property is for rent"></i></h5>
					<div class="select-input disabled-first-option">
						<input type="text" data-unit="USD" value="<?= $deal_price ?>" name="deal_order_price">
					</div>
 				</li>
 				<li>
 					<h5>Date</h5>
 					<input class="search-field" type="date"  value="<?php echo date("Y-m-d"); ?>" name="deal_order_date"/>
 				</li>
 				<li>
 					<h5>Time</h5>
 					<input class="search-field" type="time" value="<?php echo date("H:i"); ?>" name="deal_order_time"/>
					<input type="hidden" name="deal_id" value="<?= $dealid ?>">
 				</li>
 			</ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-secondary dealdetail-popupsub" name="deal_ordersubmit">Submit</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!--Modal for Contact Details -->
<div class="modal fade popup-main--section" id="selected_property_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="dealsend-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Sign Application Form-->
<div class="modal fade popup-main--section" id="signapplicationform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered dealdetail-applicationform-modal" role="document">
    <div class="modal-content dealdetail-applicationformpop">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="dealdetail-applicationformpop-body">
        	<h3>Application Form Details</h3>
        	<ul>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Name: <span>Akash</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Contact Phone Number: <span>+918295585505</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Secondary Phone Number: <span>+91895689546</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Emergency Contact: <span>+91963654855</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Email Address: <span>shubham@gmail.com</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Employer/School: <span>DAV Public Sr. Sec School</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Address: <span>H.No- 145, Near hotel paris, Naraingarh.</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Manager’s Name: <span>Madrid</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Manager’s Contact: <span>+91659865685</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Monthly Income: <span>$1000</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Weekly Rent Budget: <span>$200</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>How many people will be living in the room?: <span>1</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>How long are you looking to stay in the room?: <span>1 Year</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Where did you see our advertisement? : <span>Google</span></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-singlerow">
        				<h5>Policy</h5>
        				<p><b>NYC ROOMS 4 RENT INC.</b> is a licensed apartment sharing agency whom for a non-refundable service fee refers you to a primary tenant or landlord for viewings of available rooms. Please be on time and wear proper attire when meeting with the primary tenant or landlord. We are not responsible for any negotiations agreed between you and the landlord or primary tenant. We will assist you until you find the first room that accommodates your needs. If you wish to transfer room we will assist you <b>ONE</b> time at no extra cost within the 30 days guaranteed service policy, except you’ve been evicted for illicit behavior or have a pending balance with the landlord. Our services expire 30 days after you have found a room. <b>Our service fee is non-refundable under no circumstances.</b></p>
        			</div>
        		</li>
        		<li>
        			<div class="application-row-mulisows">
        				<p>Signature: <span>Shubham</span></p>
        			</div>
        			<div class="application-row-mulisows">
        				<p>Date: <span> December 30, 2016</span></p>
        			</div>
        		</li>
        	</ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="modal_agent_notes_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="dealsend-popup">
        	<h3><?= $agent_notes ?></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="send_payment_link_by_agent" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="send-payment-link-by-agent">
		<h5>Select an option for send payment link</h5>
        	<select name="send_message_opt">
			    <option value="">Choose an option</option>
				<option value="send_as_email">Send As Email</option>
				<option value="send_as_text">Send As Text</option>
			</select>
			
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="button send_message_tenant">Send</button>
      </div>
    </div>
  </div>
</div>

<!--Modal for Contact Details -->
<div class="modal fade popup-main--section" id="selected_property_popup_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="dealsend-popup-message">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade popup-main--section" id="modal_agent_order_deal_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="modal-agent-order-deal-popup">
        	<h3><?= $successorder ?></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="applcation_docs_tenant_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="applcation-docs-tenant-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary applcation_docs_tenant_popup" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade popup-main--section" id="applcation_docs_tenant_delete_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="applcation-docs-tenant-delete-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary applcation_docs_tenant_delete_popup" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	// This is required for AJAX to work on our page
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	var deal_id = '<?php echo $dealid; ?>';
	
	function cvf_load_all_posts(page){ 
		var data = {
			page: page,
			deal_id: deal_id,
			action: "demo-pagination-load-posts"
		};

		$.post(ajaxurl, data, function(response) {
			$(".nyc_load_property").html(response);
		});
	}	
	
	function nyc_load_selcted_property(){
		var data = {
			deal_id: deal_id,
			action: "nyc_load_selcted_property"
		};
		$.post(ajaxurl, data, function(response) {
			$(".nyc_deal_selected_property_section").html(response);
		});
	}
	
	cvf_load_all_posts(1);
	nyc_load_selcted_property();
	// Handle the clicks
	$('.cvf-universal-pagination li.active').live('click',function(){
		var page = $(this).attr('p');
		cvf_load_all_posts(page);
	});
	$('.deal_select_property').live('click',function(){
		var myarray = [];  
		var checkedNum = jQuery('input[class="check_property"]:checked').length;
		if(checkedNum == 0){
			alert('Please choose one or more property');
		}else{
			jQuery('input[class="check_property"]:checked').each(function(){
				myarray.push(jQuery(this).val());
			});
			var data = {
				deal_id: deal_id,
				propertyArray: myarray,
				action: "nyc-deal-select-property-assign",
			};
			// Send the data
			$.post(ajaxurl, data, function(response) {
				cvf_load_all_posts(1);
				nyc_load_selcted_property();				
				jQuery('.dealsend-popup h3').html('Property Selected Successfully');
				jQuery('#selected_property_popup').modal('show');			
			});			
		}
	});
	$('.selected-property-close').live('click',function(){
			var property_id = jQuery(this).attr('data-id');
			var data = {
				deal_id: deal_id,
				property_id: property_id,
				action: "nyc-deal-remove-property-assign",
			};
			$.post(ajaxurl, data, function(response) {
				cvf_load_all_posts(1);	
				 nyc_load_selcted_property();
			});
	});
	$(".desellect-sellectedproperty").live('click',function(){
		jQuery(this).parent().addClass('selected-property-none'); 
	});	
	
	$('.deal_search_property').live('click',function(e){
			jQuery('.loading').show();
			var search_name = jQuery('#search_name').val();
			var search_status = jQuery('#search_status').val();
			var search_type = jQuery('#search_type').val();
			var search_accom = jQuery('#search_accom').val();
			var search_rooms = jQuery('#search_rooms').val();
			var search_min_price = jQuery('#search_min_price').val();
			var search_max_price = jQuery('#search_max_price').val();
			var data = {
				page: 1,
				deal_id: deal_id,
				search_name: search_name,
				search_status: search_status,
				search_type: search_type,
				search_accom: search_accom,
				search_rooms: search_rooms,
				search_min_price: search_min_price,
				search_max_price: search_max_price,
				action: "demo-pagination-load-posts"
			};

			// Send the data
			$.post(ajaxurl, data, function(response) {
				// If successful Append the data into our html container
				$(".nyc_load_property").html(response);
				jQuery('.loading').hide();
			}); 
	});	
	
	$('.send_message_tenant').live('click',function(e){
	   var optionval = $('select[name="send_message_opt"]').val();
	   if(optionval == ""){
	      alert("please choose an option to send Payment Link");
	   } else {
	       if(optionval == "send_as_email"){
		        jQuery('#send_payment_link_by_agent').modal('hide');
				jQuery('.loading').show();
				var data = {
					deal_id: deal_id,
					action: "nyc-deal-send-email",
				};
				$.post(ajaxurl, data, function(response) {
					jQuery('.loading').hide();
					jQuery('.dealsend-popup-message h3').html('Email sent successfully');
					jQuery('#selected_property_popup_message').modal('show');
				});
				
		   }
		   
		   if(optionval == "send_as_text"){
		        jQuery('#send_payment_link_by_agent').modal('hide');
				jQuery('.loading').show();
				var data = {
					deal_id: deal_id,
					action: "nyc-deal-send-sms",
				};
				var html='';
				$.post(ajaxurl, data, function(response) {
					var response = JSON.parse(response);
					if(response.tenant_status == true){
						html += "SMS sent successfully to tenant.</br>";
					}else{
						html += response.tenant_error;
					}
					if(response.agent_allowed== true){
						if(response.agent_status == true){
							html += "SMS sent successfully to agent.</br>";
						}else{
							html += response.agent_error;
						}
					}
					jQuery('.loading').hide();
					jQuery('.dealsend-popup-message h3').html(html);
					jQuery('#selected_property_popup_message').modal('show');
				});
				
		   }
		   
		   
	   }
	   
	});
	
	
	
	
});
</script>

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/dropzone.js"></script>
<script>
 var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
 var deal_id = '<?php echo $dealid; ?>';
Dropzone.autoDiscover = false;		
jQuery(".dropzone").dropzone({
	dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
	<?php if(empty($check_contracts->posts)): ?>
	addRemoveLinks: true,
	<?php endif; ?>
	init: function() { 
			myDropzoneFiles = this; 		
			jQuery.ajax({
			  type: 'post',
			  dataType: 'json',
			  url: ajaxurl,
			  data: {action:'nyc_get_existing_doc_tenant_ajax',deal_id:deal_id},
			  success: function(response){
			  
				   $.each(response, function(key,value) {
                          if(value.size != false){
						  
						     var mockFile = { name: value.name, size: value.size };
							 var extension = value.name.substr( (value.name.lastIndexOf('.') +1) );
							 if(extension == 'jpg' || extension == 'png' || extension == 'gif' ){
								  myDropzoneFiles.emit("addedfile", mockFile);
								  myDropzoneFiles.emit("thumbnail", mockFile, value.path);
								  myDropzoneFiles.emit("complete", mockFile);
							 } else {
							      myDropzoneFiles.emit("addedfile", mockFile);
								  myDropzoneFiles.emit("complete", mockFile);
							 }
							  
							  
						  }
						 
				  }); 

			  }
			 });
			 
   },
   <?php if(empty($check_contracts->posts)): ?>
   removedfile: function(file) {
     var file_name    = file.name; 
	   jQuery.ajax({
			  type: 'post',
			  url: ajaxurl,
			  data: {action:'nyc_delete_existing_doc_tenant_ajax',deal_id:deal_id,file_name:file_name},
			  success: function(response){
                     if(response == "success"){
					    jQuery('.applcation-docs-tenant-delete-popup h3').html('Documents Removed successfully.</h3>');
						jQuery('#applcation_docs_tenant_delete_popup').modal('show');
					    setTimeout(function() {
							window.location.reload();
						}, 1000);
							
					 }
			  }
	  });
	var _ref;
	return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0; 
	
   }
   <?php endif; ?>
   
});	

jQuery(document).ready(function($) {
   jQuery(".save_tenant_doc").click(function(e){
      e.preventDefault();
	  $(this).prop('disabled',true);
	  var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	  var deal_id = '<?php echo $dealid; ?>';
	  var tenant_docs = $('.dropzone.dropzone_tenant_documents')[0].dropzone.getAcceptedFiles();
	  jQuery('.loading').show();
	  var form_data = new FormData();
      form_data.append("deal_id", deal_id); 
	  var tenant_docs_all =[];
			for(var i = 0;i<tenant_docs.length;i++){
				form_data.append("doc_tenant_"+i, tenant_docs[i]);
				tenant_docs_all.push("doc_tenant_"+i);
	        }
		
	   form_data.append("tenant_docs_all", tenant_docs_all);
	   form_data.append( "action" , 'nyc_upload_tenant_docs');	
			 jQuery.ajax({
				type : "post",
				url : ajaxurl,
				data: form_data,
				processData: false,
				contentType: false,
				success: function(response) {
				        if(response == "success"){
					      jQuery('.loading').hide();
						  jQuery('.applcation-docs-tenant-popup h3').html('Documents uploaded successfully.</h3>');
					      jQuery('#applcation_docs_tenant_popup').modal('show');
						  setTimeout(function() {
								window.location.reload();
							}, 3000);
					   }
				}
			});
	   
			
			
       
   });
});


</script>
<?php
get_footer();

if(!empty($agent_notes)){
   echo "<script>
         jQuery(window).load(function(){
             $('#modal_agent_notes_popup').modal('show');
         });
    </script>";
}


if(!empty($successorder)){
   echo "<script>
         jQuery(window).load(function(){
             $('#modal_agent_order_deal_popup').modal('show');
         });
    </script>";
}
?>