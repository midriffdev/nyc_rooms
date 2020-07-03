<?php
require_once get_stylesheet_directory().'/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
if(isset($_GET['create-contract'])){
	$invoice_html = '';
	$options = new Options();
	$options->set('isRemoteEnabled', TRUE);	
	$file_name = uniqid().'.pdf';		
	$pdf  = new Dompdf($options);
	$pdf->load_html($invoice_html);
	$pdf->set_paper('A4', 'landscape');
	$pdf->render();
	ob_end_clean();
	$pdf->stream($file_name);
	$pdf->output();	
}
nyc_property_admin_authority();
$post_id = base64_decode(get_query_var( 'id' )); 
$post = get_post($post_id);
if(empty($post) || ($post->post_type != 'deals')){
	wp_redirect(get_site_url().'/admin/deals'); 
}
get_header();

$lead_source = get_post_meta($post_id,'lead_source',true);
$name = get_post_meta($post_id,'name',true);
$email = get_post_meta($post_id,'email',true);
$phone = get_post_meta($post_id,'phone',true);
$description = get_post_meta($post_id,'description',true);
$property_id = get_post_meta($post_id,'property_id',true);
$auth = get_post($property_id);
$authid = $auth->post_author;
$tenant_application = get_post_meta($post_id,'document_files',true);
$deal_price = get_post_meta($post_id,'deal_price',true);
$admin_notes = get_post_meta($post_id,'admin_notes',true);
$selected_property = get_post_meta($post_id, 'selected_property', true);
$selectedAgent = get_post_meta($post_id, 'selectedAgent', true);
$request_an_agent = get_post_meta($post_id, 'request_an_agent', true);
$document_files = get_post_meta($post_id, 'document_files', true);
$query_args = array(
	'post_type'  => 'dealsorders',
	'meta_query' => array(
	    array(
			'key'   => 'deal_id',
			'value' => $post_id,
	    ),
	)
);
$check_deal_orders = new WP_Query( $query_args );
if(count($check_deal_orders->posts) == 1){
	$dealorderid        = $check_deal_orders->posts[0]->ID;
	$payment_status     = get_post_meta($dealorderid,'payment_status',true);
	$payment_amount     = get_post_meta($dealorderid,'payment_amount',true);
	$payment_created_at = get_post_meta($dealorderid,'payment_created_at',true);
	$payment_source_type = get_post_meta($dealorderid,'payment_source_type',true);
	$payment_mode = get_post_meta($dealorderid,'payment_mode',true);
	$strtotime          = strtotime($payment_created_at);
	$date =  date("F j, Y", $strtotime); 
	$time =  date("h:i A", $strtotime); 
	
} else {
   $payment_status = get_post_meta($post_id,'payment_status',true);
}
?>
<!-- Wrapper -->
<div id="wrapper">

<!-- Content
================================================== -->
<div class="contract-detail-container">		
	<div class="container">

		<div class="row contractdetail--stageinnersection">
			<div class="col-md-12">
				<div class="contract-property_detail">
					<?php 
					if($property_id){ 
					$auth = get_post($property_id);
					$authid = $auth->post_author;
					$address = get_post_meta($property_id, 'address',true)." ";
					$address .= get_post_meta($property_id, 'city',true)." ";
					$address .= get_post_meta($property_id, 'state',true).", ";
					$address .= get_post_meta($property_id, 'zip',true)." ";	
					$price = get_post_meta($property_id, 'price',true);				
					$status = get_post_meta($property_id, 'status',true);	
					$images = get_post_meta($property_id, 'images',true);	
					$gallery_files_meta = get_post_meta($property_id,'gallery_files',true);
					$gallery_files = explode(',',$gallery_files_meta);
					?>
					<h2>Property Details</h2>
					<div class="listings-container list-layout">
					<!-- Listing Item -->
						<div class="listing-item">
							<a href="<?php echo get_post_permalink($property_id); ?>" class="listing-img-container">
								<div class="listing-img-content">
									<span class="listing-price">$<?php echo $price; ?> / Weekly</span>
								</div>
								<div class="listing-carousel">
								    <?php
									foreach($gallery_files as $key => $metakeyattach){
								    ?>
									<div><img src="<?php echo wp_get_attachment_url(get_post_meta($property_id,$metakeyattach,true)); ?>" alt=""></div>
									<?php
									} 
									?>
								</div>
							</a>
							<div class="listing-content">
								<div class="listing-title">
									<h4><a href="<?php echo get_post_permalink($property_id); ?>"><?php echo get_the_title($property_id); ?></a></h4>
									<a href="https://maps.google.com/maps?q=<?php echo $address; ?>" class="listing-address popup-gmaps">
										<i class="fa fa-map-marker"></i>
										<?php echo $address; ?>
									</a>
									<a href="<?php echo get_post_permalink($property_id); ?>" target="_blank" class="details button border">Details</a>
								</div>
								<ul class="listing-details">
									<li>Rooms <?php echo get_post_meta($property_id,'rooms',true); ?></li>
								</ul>
								<div class="listing-footer">
									<a><i class="fa fa-user"></i> <?php echo get_the_author_meta( 'display_name' , $authid); ?></a>
								</div>
							</div>
						</div>
					<!-- Listing Item / End -->
					</div>
					<?php } ?>
				</div>
			</div>
			<?php  if($lead_source == "Property Form"){ ?>
			<div class="col-md-6">
				<div class="leaddetail-teanentdetail dealdetail__tenantdetail contract-tenantdetail">
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
			<?php } ?>
		<?php if($lead_source == "Appointment Form" || $lead_source == "Custom Deal"){ ?>		
			<div class="col-md-6">
				<div class="dealdetal__appointmentdetail-sec">
					<div class="leaddetail-teanentdetail dealdetail__tenantdetail">
						<h2>Appointment Details</h2>
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
									<span><?php echo get_the_date('l F j, Y',$post_id); ?></span>
								</li>
								<li>
									<p>Description:</p>
									<span><?php echo $description; ?></span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>			
			<div class="col-md-6">
				<div class="contract-owner-detail">
					<h2>Property Owner Detail</h2>
					<?php 
					$property_owner = get_userdata($authid);
					$owner_id = $property_owner->data->ID;
					?>
					<div class="contract-ownerdetail-cont">
						<ul>
						<li>
							<p>Name: </p>
							<span><?php echo $property_owner->data->display_name; ?></span>
						</li>
						<li>
							<p>Email:</p>
							<span><?php echo $property_owner->data->user_email; ?></span>
						</li>
						<li>
							<p>Phone:</p>
							<span><?php echo get_user_meta($owner_id,'user_phone',true); ?></span>
						</li>
					</ul>
					</div>
				</div>
			</div>

			<?php if($selectedAgent){ ?>
			<div class="col-md-6">
				<div class="dealdetail-allocateagent-section">
					<h2>Agent Details</h2>
					<ul>
						<li>
							<p>Name: </p>
							<span><?php the_author_meta( 'display_name' , $selectedAgent ); ?></span>
						</li>
						<li>
							<p>Email:</p>
							<span><?php the_author_meta( 'user_email' , $selectedAgent ); ?></span>
						</li>
						<li>
							<p>Phone:</p>
							<span><?php the_author_meta( 'user_phone' , $selectedAgent ); ?></span>
						</li>

					</ul>
				</div>
			</div>
			<div class="dealdetail--agentnotes-sec col-md-6">
				<h2>Agent Notes:</h2>
				<p><?php echo get_post_meta($post_id,'agent_notes',true);  ?></p>
			</div>
			<?php } ?>


			<div class="col-md-6">
				<div class="contract-admin-notes">
					<h2>Admin Notes</h2>
					<p><?php echo $admin_notes; ?></p>
				</div>
			</div>

			<div class="col-md-6">
				<div class="dealdetail-signapplicationform">
						<h3>Application Form Status <span> <?php echo ($tenant_application) ? 'Complete <a href="'.wp_get_attachment_url($tenant_application).'" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>' : 'Pending'; ?> </span></h3>
				</div>
			</div>

			<div class="col-md-6">
				<div class="deal-detail-paymentstatus">
						<h3>Payment Status
						<span><?php echo ($payment_status) ? $payment_status : 'Pending'; ?> <i class="fa fa-check" aria-hidden="true"></i></span></h3>
						<?php if($payment_status){ ?>
						<ul>
							<li>Payment: <span><?= '$'.$payment_amount ?></span></li>
							<li>Payment Source : <span><?= ucfirst($payment_source_type) ?></span></li>
							<li>Payment mode : <span><?= ucfirst(str_replace('_',' ',$payment_mode)) ?></span></li>
							
							<li>Date: <span><?= $date ?></span></li>
							<li>Time: <span><?= $time ?></span></li>
						</ul>
						<?php } ?>
				</div>
			</div>

		</div>
		
<div class="row contract-detail-formsection">
   <div class="col-md-12">
      <h3>Form Details</h3>
      <div class="pdf-wrapper" style="padding: 50px 50px;">
         <table style="width:100%;">
            <tbody>
               <tr>
                  <td colspan="2">
                     <table style="width:100%;">
                        <tbody>
                           <tr>
                              <td colspan="2">
                                 <table style="width:100%;">
                                    <tbody>
                                       <tr>
                                          <td style="width:40%;">
                                             <img src="https://nycrooms.midriffdevelopers.live/wp-content/uploads/2020/06/logo.png" style="width:250px;">
                                          </td>
                                          <td style="width:60%;padding: 0 0px 0 10%;">
                                             <h2 style="text-align: right;margin-top: 0;margin-bottom: 0;">Apartment Sharing Contract</h2>
                                             <table style="width:100%;margin-top:10px;border:1px solid #000;">
                                                <tbody>
                                                   <tr>
                                                      <td style="padding:20px;">
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:22%;">
                                                                     <h4 style="margin:0;">Contract #</h4>
                                                                  </td>
                                                                  <td style="width:78%;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:17%;">
                                                                     <h4 style="margin:0;">File No.</h4>
                                                                  </td>
                                                                  <td style="width:83%;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:10%;">
                                                                     <h4 style="margin:0;">Date</h4>
                                                                  </td>
                                                                  <td style="width:90%;"><input type="date" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <table style="width:100%;margin-top:35px;">
                        <tbody>
                           <tr>
                              <td style="padding: 0 0 11px 0;width:19%;"><span style="font-size: 18px;">Agreement between:</span></td>
                              <td style="padding: 0 0 11px 0;width:81%;padding:0;">
                                 <p style="background-color: #fff !important;border-radius: unset;border-bottom: 1px solid #000;color: #333;font-weight: 600;margin: 0px;font-size: 18px;text-transform: uppercase;">nyc rooms for rent inc. (606 west 145<sup>th</sup> street ny ny 10031)</p>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2">
                                 <table style="width:100%;">
                                    <tbody>
                                       <tr>
                                          <td style="width:15%;padding: 0 0 11px 0;"><span style="font-size: 18px;">And (customer)</span></td>
                                          <td style="width:85%;padding: 0 0 11px 0;">
                                             <p style="border-bottom: 1px solid #000;color: #333;font-weight: 600;margin: 0px;font-size: 18px;text-transform: uppercase;">nyc rooms for rent inc. (606 west 145<sup>th</sup> street ny ny 10031)</p>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <table style="width:100%;margin-top:35px;">
                        <tbody>
                           <tr>
                              <td style="padding: 0 0 10px 0;width:100%;">
                                 <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;">(1)Customer Seeks Information Regarding Shared Living Accomodations With The Following:</p>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2">
                                 <table style="width:100%;">
                                    <tbody>
                                       <tr>
                                          <td style="width:50%padding-left: 10px;">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td colspan="2">
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td colspan="2">
                                                                     <table style="width:100%;">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td style="width:28%;padding:0;"><span style="font-size: 18px;">Date Available:</span></td>
                                                                              <td style="width:72%;padding: 0;"><input type="date" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                                           </tr>
                                                                        </tbody>
                                                                     </table>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td colspan="2">
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:42%;padding: 0;"><span style="font-size: 18px;">Geographical Location:</span></td>
                                                                  <td style="width:56%;padding: 0;"><input type="text" name="" style="border: none;background-color: #fff !important;border-radius: unset;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td colspan="2">
                                                         <table style="width:100%;margin-top: 15px;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:48%;padding: 0;"><span style="font-size: 18px;">Elevator Service required:</span></td>
                                                                  <td style="width:52%;padding: 0;">
                                                                     <table style="width:100%;">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td>
                                                                                 <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="height: 15px;width: 15px;margin-right: 5px;" type="radio" name="elevateor_service" value="yes">Yes
                                                                                 </p>
                                                                              </td>
                                                                              <td>
                                                                                 <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="height: 15px;width: 15px;margin-right: 5px; " type="radio" name="elevateor_service" value="no">No</p>
                                                                              </td>
                                                                           </tr>
                                                                        </tbody>
                                                                     </table>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                          <td style="width:50%;padding-left: 10px;vertical-align: top;">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td colspan="2">
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td colspan="2">
                                                                     <table style="width:100%;">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td style="width:60%;padding: 0;"><span style="font-size: 18px;">Monthly/ Weekly rental Range $: </span>
                                                                              </td>
                                                                              <td style="width:40%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;background-color: #fff !important;border-radius: unset;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                                                                              </td>
                                                                           </tr>
                                                                        </tbody>
                                                                     </table>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <td colspan="2" style="padding-top: 15px;">
                                                                     <table style="width:100%;">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td style="width:42%;padding: 0;"><span style="font-size: 18px;">Type of Accomodation:</span>
                                                                              </td>
                                                                              <td style="width:58%;padding: 0;">
                                                                                 <table style="width:100%;">
                                                                                    <tbody>
                                                                                       <tr>
                                                                                          <td>
                                                                                             <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;">
                                                                                                <input style="height: 15px;width: 15px;margin-right: 5px; " type="radio" name="" value="">Apartment
                                                                                             </p>
                                                                                          </td>
                                                                                          <td>
                                                                                             <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="margin-right: 5px;height: 15px;width: 15px; " type="radio" name="" value="">Room</p>
                                                                                          </td>
                                                                                       </tr>
                                                                                    </tbody>
                                                                                 </table>
                                                                              </td>
                                                                           </tr>
                                                                        </tbody>
                                                                     </table>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td colspan="2">
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:20%;padding: 0;"><span style="font-size: 18px;">Other Requirements:</span></td>
                                                                  <td style="width:86%;padding: 0;"><input type="text" name="" style="background-color:#fff !important;border-radius:unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <table style="width:100%;margin-top:35px;">
                        <tbody>
                           <tr>
                              <td style="padding: 0 0 10px 0;width:100%;">
                                 <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;">(2) Vender represent that the following listings Meet customers specification as set forth in Paragraph(1):</p>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2">
                                 <table style="width:100%;">
                                    <tr>
                                       <td style="width:50%padding-left: 10px;">
                                          <table style="width:100%;">
                                             <tbody>
                                                <tr>
                                                   <td colspan="2">
                                                      <table style="width:100%;">
                                                         <tbody>
                                                            <tr>
                                                               <td colspan="2">
                                                                  <table style="width:100%;">
                                                                     <tr>
                                                                        <td style="width:6%;padding: 0;"><span style="font-size: 18px;">Address:</span></td>
                                                                        <td style="width:94%;padding: 0;"><input type="text" name="" style="border-radius:unset;background-color:#fff !important;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                                     </tr>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td colspan="2">
                                                      <table style="width:100%;">
                                                         <tr>
                                                            <td style="width:35%;padding: 0;"><span style="font-size: 18px;">Phone # of Owner:</span></td>
                                                            <td style="width:65%;padding: 0;"><input type="text" name="" style="border-radius:unset;background-color:#fff !important;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td colspan="2">
                                                      <table style="margin-top: 15px;width:100%;">
                                                         <tr>
                                                            <td style="width:22%;padding: 0;"><span style="font-size: 18px;">Utility Included:</span></td>
                                                            <td style="width:52%;padding: 0;">
                                                               <table style="width:100%;">
                                                                  <tbody>
                                                                     <tr>
                                                                        <td>
                                                                           <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="height: 15px;width: 15px;margin-right: 5px;" type="radio" name="elevateor_service" value="yes">Yes
                                                                           </p>
                                                                        </td>
                                                                        <td>
                                                                           <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="height: 15px;width: 15px;margin-right: 5px; " type="radio" name="elevateor_service" value="no">No</p>
                                                                        </td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td colspan="2">
                                                      <table style="margin-top: 15px;width:100%;">
                                                         <tr>
                                                            <td style="width:48%;padding: 0;"><span style="font-size: 18px;">Elevator Service required:</span></td>
                                                            <td style="width:52%;padding: 0;">
                                                               <table style="width:100%;">
                                                                  <tr>
                                                                     <td>
                                                                        <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="height: 15px;width: 15px;margin-right: 5px;" type="radio" name="elevateor_service" value="yes">Yes
                                                                        </p>
                                                                     </td>
                                                                     <td>
                                                                        <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="height: 15px;width: 15px;margin-right: 5px; " type="radio" name="elevateor_service" value="no">No</p>
                                                                     </td>
                                                                  </tr>
                                                               </table>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                       <td style="width:50%;padding-left: 10px;">
                                          <table style="width:100%;">
                                             <tbody>
                                                <tr>
                                                   <td colspan="2">
                                                      <table style="width:100%;">
                                                         <tbody>
                                                            <tr>
                                                               <td style="width:64%;padding: 0;"><span style="font-size: 18px;">Name of Owner or Primary Tenant:</span>
                                                               </td>
                                                               <td style="width:36%;padding: 0;"><input type="text" name="" style="border-radius:unset;background-color:#fff !important;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="2">
                                                                  <table style="width:100%;">
                                                                     <tr>
                                                                        <td style="width:45%;padding: 0;"><span style="font-size: 18px;">Monthly/Weekly Rent: $</span>
                                                                        </td>
                                                                        <td style="width:55%;padding: 0;"><input type="text" name="" style="border-radius:unset;background-color:#fff !important;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                                                                        </td>
                                                                     </tr>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="2">
                                                                  <table style="width:100%;">
                                                                     <tr>
                                                                        <td style="width:28%;padding: 0;"><span style="font-size: 18px;">Floor Location:</span>
                                                                        </td>
                                                                        <td style="width:62%;padding: 0;"><input type="text" name="" style="border-radius:unset;background-color:#fff !important;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                                                                        </td>
                                                                     </tr>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                            <tr>
                                                               <td colspan="2">
                                                                  <table style="width:100%;">
                                                                     <tr>
                                                                        <td style="width:9%;padding: 0;"><span style="font-size: 18px;">Date:</span>
                                                                        </td>
                                                                        <td style="width:91%;padding: 0;"><input type="date" name="" style="border-radius:unset;background-color:#fff !important;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                                                                        </td>
                                                                     </tr>
                                                                  </table>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </table>
                           </tr>
                        </tbody>
                     </table>
                     <table style="width:60%;margin-top:35px;">
                        <tbody>
                           <tr>
                              <td colspan="2">
                                 <table style="width:100%;">
                                    <tbody>
                                       <tr>
                                          <td style="width:56%;padding:0;"><span style="font-size: 20px;font-weight: 600;text-transform: capitalize;">(3) Non-refundable Fee Paid:<span style="color: #333;padding-left:3px;margin: 0px;font-size: 18px;">$<span ></span></span></span></td>
                                          <td style="width:42%;padding:0;"><input type="text" name="" style="border: none;
                                             background-color: #fff !important;
                                             border-radius: unset;
                                             border-bottom: 1px solid #000;
                                             color: #333;
                                             margin: 0px;
                                             font-size: 17px;
                                             width: 100%;"></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <table style="width:100%;margin-top:35px;">
                        <tbody>
                           <tr>
                              <td style="padding: 0 0 10px 0;width:100%;">
                                 <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;">(4) Contract Terms:</p>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" style="padding-right:10px;">
                                 <table style="width: 100%;">
                                    <tbody>
                                       <tr>
                                          <td colspan="2" style="width:50%;">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:37%;padding: 0;"><span style="font-size: 18px;">Contract start Date:</span></td>
                                                      <td style="width:63%;padding: 0;"><input type="date" name="" style="background-color:#fff !important;border-radius:unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                   </tr>
                                             </table>
                                          </td>
                                          <td colspan="2" style="width:50%;padding-left:20px;">
                                             <table style="width: 100%;">
                                                <tbody>
                                                   <tr>
                                                      <td colspan="2">
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:44%;padding: 0;"><span style="font-size: 18px;">Approximate Duration:</span></td>
                                                                  <td style="width:56%;padding: 0;">
                                                                     <table style="width:100%;">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td>
                                                                                 <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="height: 15px;width: 15px;margin-right: 5px;" type="radio" name="elevateor_service" value="yes">1 Month
                                                                                 </p>
                                                                              </td>
                                                                              <td>
                                                                                 <p style="color: #333;margin: 0px;font-size: 17px;width: 100%;display: inline-flex;"><input style="height: 15px;width: 15px;margin-right: 5px; " type="radio" name="elevateor_service" value="no">2 Month</p>
                                                                              </td>
                                                                           </tr>
                                                                        </tbody>
                                                                     </table>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                    </tbody>
                                 </table>
                                 <table style="width:100%;margin-top:35px;">
                                    <tbody>
                                       <tr>
                                          <td style="padding: 0 0 11px 0;width:100%;padding:0;">
                                             <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;">(5) The vendor agrees to be personally responsible And liable for carrying out the terms of this agreement.</p>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <!-- Wrapper / End -->
                  </td>
               </tr>
            </tbody>
         </table>
         </td></tr></tbody></table>
         <table style="width:100%;margin-top:35px;">
            <tbody>
               <tr>
                  <td style="padding: 0 0 10px 0;width:100%;">
                     <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;">(6) Any Complaints about this apartment sharing, AGENT SHOULD BE MADE TO:</p>
                  </td>
               </tr>
               <tr>
                  <td>
                     <p style="margin:0;font-size:18px;color: #333;">New York State, Department of state office of the New York State, 123 William Street 19th FL Department of State New York, NY 10038 .</p>
                     <p style="margin:0;font-size:18px;color: #333;"> <b>Telephone:</b> (212) - 417-5747</p>
                  </td>
               </tr>
            </tbody>
         </table>
         <table style="width:100%;margin-top:35px;">
            <tbody>
               <tr>
                  <td style="padding: 0 0 10px 0;width:100%;">
                     <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;">(7) This document has been filled out and signed by:</p>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">
                     <table style="width: 100%;">
                        <tbody>
                           <tr>
                              <td style="width:50%;padding-right:10px;">
                                 <table style="width:100%;">
                                    <tbody>
                                       <tr>
                                          <td style="width:25%;padding: 0;"><span style="font-size: 18px;">Agent Name:</span></td>
                                          <td style="width:75%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                       </tr>
                                       <tr>
                                          <td colspan="2">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:31%;padding: 0;"><span style="font-size: 18px;">Agent Signature:</span></td>
                                                      <td style="width:69%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:9%;padding: 0;"><span style="font-size: 18px;">Date:</span></td>
                                                      <td style="width:91%;padding: 0;"><input type="date" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                              <td style="width:50%;padding-left:10px;">
                                 <table style="width: 100%;">
                                    <tbody>
                                       <tr>
                                          <td colspan="2">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:32%;padding: 0;"><span style="font-size: 18px;">Customer Name:</span></td>
                                                      <td style="width:68%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                   </tr>
                                                   <tr>
                                                      <td colspan="2">
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:38%;padding: 0;"><span style="font-size: 18px;">Customer Signature:</span></td>
                                                                  <td style="width:62%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                               </tr>
                                                               <tr>
                                                                  <td colspan="2">
                                                                     <table style="width:100%;">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td style="width:9%;padding: 0;"><span style="font-size: 18px;">Date:</span></td>
                                                                              <td style="width:91%;padding: 0;"><input type="date" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                                           </tr>
                                                                        </tbody>
                                                                     </table>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
         </td>
         </tr>
         </tbody>
         </table>
         <div clas="page-break-after"></div>
         <table style="width:100%;margin-top:35px;">
            <tbody>
               <tr>
                  <td style="padding: 0 0 10px 0;width:100%;">
                     <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;text-align: center;"> Additional Notes:</p>
                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                     <input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;">
                  </td>
               </tr>
               <tr>
                  <td colspan="2" style="padding-top:70px;">
                     <table style="width: 100%;">
                        <tbody>
                           <tr>
                              <td style="width:50%;padding-right:10px;">
                                 <table style="width:100%;">
                                    <tbody>
                                       <tr>
                                          <td style="width:26%;padding: 0;"><span style="font-size: 18px;">Agent Name:</span></td>
                                          <td style="width:74%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                       </tr>
                                       <tr>
                                          <td colspan="2">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:32%;padding: 0;"><span style="font-size: 18px;">Agent Signature:</span></td>
                                                      <td style="width:68%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:9%;padding: 0;"><span style="font-size: 18px;">Date:</span></td>
                                                      <td style="width:92%;padding: 0;"><input type="date" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                              <td style="width:50%;padding-left:10px;">
                                 <table style="width: 100%;">
                                    <tbody>
                                       <tr>
                                          <td colspan="2">
                                             <table style="width:100%;">
                                                <tbody>
                                                   <tr>
                                                      <td style="width:32%;padding: 0;"><span style="font-size: 18px;">Customer Name:</span></td>
                                                      <td style="width:68%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                   </tr>
                                                   <tr>
                                                      <td colspan="2">
                                                         <table style="width:100%;">
                                                            <tbody>
                                                               <tr>
                                                                  <td style="width:38%;padding: 0;"><span style="font-size: 18px;">Customer Signature:</span></td>
                                                                  <td style="width:52%;padding: 0;"><input type="text" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                               </tr>
                                                               <tr>
                                                                  <td colspan="2">
                                                                     <table style="width:100%;">
                                                                        <tbody>
                                                                           <tr>
                                                                              <td style="width:9%;padding: 0;"><span style="font-size: 18px;">Date:</span></td>
                                                                              <td style="width:91%;padding: 0;"><input type="date" name="" style="background-color: #fff !important;border-radius: unset;border: none;border-bottom: 1px solid #000;color: #333;margin: 0px;font-size: 17px;width: 100%;"></td>
                                                                           </tr>
                                                                        </tbody>
                                                                     </table>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>		
<div class="contract-form-row">
	<div class="row">
		<a href="<?php echo get_site_url(); ?>/admin/deals/contract/Njgx?create-contract"><button class="contract-form-submit">Send Contract</button></a>
	</div>
</div>

</div>
</div>
</div>
<div class="margin-top-55"></div>
</div>

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/dropzone.js"></script>
<script>
	jQuery(".dropzone").dropzone({
		dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
	});
</script>

<?php
get_footer();
?>
