<?php
use Dompdf\Dompdf;
$contract_id = base64_decode(get_query_var('id')); 
$post = get_post($contract_id);
if(empty($post) || ($post->post_type != 'contracts')){
	wp_redirect(get_site_url().'/admin/all-contracts'); 
}
$post_id = get_post_meta($contract_id,'deal_id',true); 
nyc_property_admin_authority();
get_header();
$property_id = get_post_meta($post_id,'property_id',true);
$auth = get_post($property_id);
$authid = $auth->post_author;
$email = get_post_meta($post_id,'email',true);
$name = get_post_meta($post_id,'name',true);
$contract_created = get_post_meta($post_id,'deal_created',true);
if(isset($_POST['create_contract']) && $contract_created == false){
	$contract_data = array();
	$contract_data['contact_no'] = $_POST['contact_no'];
	$contract_data['contact_file_no'] = $_POST['contact_file_no'];
	$contract_data['contact_date'] = $_POST['contact_date'];
	$contract_data['agreement_between'] = $_POST['agreement_between'];
	$contract_data['and_customer'] = $_POST['and_customer'];
	$contract_data['customer_date_available'] = $_POST['customer_date_available'];
	$contract_data['customer_rental_range'] = $_POST['customer_rental_range'];
	$contract_data['customer_geo_location'] = $_POST['customer_geo_location'];
	$contract_data['accomodation'] = $_POST['accomodation'];
	$contract_data['customer_elevator'] = $_POST['customer_elevator'];
	$contract_data['customer_other_requirement'] = $_POST['customer_other_requirement'];
	$contract_data['vender_address'] = $_POST['vender_address'];
	$contract_data['vender_name_of_owner'] = $_POST['vender_name_of_owner'];
	$contract_data['vender_geo_location'] = $_POST['vender_geo_location'];
	$contract_data['vender_phone_owner'] = $_POST['vender_phone_owner'];
	$contract_data['vender_utility'] = $_POST['vender_utility'];
	$contract_data['vender_floor_location'] = $_POST['vender_floor_location'];
	$contract_data['vender_elevator'] = $_POST['vender_elevator'];
	$contract_data['vender_date'] = $_POST['vender_date'];
	$contract_data['non_refundable_free_paid'] = $_POST['non_refundable_free_paid'];
	$contract_data['contact_start_date'] = $_POST['contact_start_date'];
	$contract_data['approximate_duration'] = $_POST['approximate_duration'];
	$contract_data['agent_name'] = $_POST['agent_name'];
	$contract_data['customer_name'] = $_POST['customer_name'];
	$contract_data['agent_signature'] = $_POST['agent_signature'];
	$contract_data['customer_signature'] = $_POST['customer_signature'];
	$contract_data['agent_date'] = $_POST['agent_date'];
	$contract_data['customer_date'] = $_POST['customer_date'];
	$contract_data['additional_notes'] = $_POST['additional_notes'];
	$contract_data['agent_name_two'] = $_POST['agent_name_two'];
	$contract_data['customer_name_two'] = $_POST['customer_name_two'];
	$contract_data['agent_signature_two'] = $_POST['agent_signature_two'];
	$contract_data['customer_signature_two'] = $_POST['customer_signature_two'];
	$contract_data['agent_date_two'] = $_POST['agent_date_two'];
	$contract_data['customer_date_two'] = $_POST['customer_date_two'];
	
	$text = trim($_POST['additional_notes']);
	$textAr = explode("\n", $text);
	$textAr = array_filter($textAr, 'trim');	
	$html='<html>
		   <head>
			  <meta http-equiv="Content-Type" content="charset=utf-8" />
			  <style type="text/css">
				 @page {
				 margin: 0;
				 }
				 * { padding: 0; margin: 0; }
				 @font-face {
				 font-family: "varelaround";           
				 src: local("VarelaRound-Regular"), url("'.get_stylesheet_directory_uri().'/fonts/VarelaRound-Regular.ttf") format("truetype");
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
				 .page_break { page-break-before: always; }
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
										 <td colspan="2">
											<table style="width:100%;">
											   <tbody>
												  <tr>
													 <td style="width:45%;">
														'.get_custom_logo().'
													 </td>
													 <td style="width:55%;padding: 0 0px 0 10%;">
														<h2 style="text-align: right;margin-top: 0;margin-bottom: 0;">Apartment Sharing Contract</h2>
														<table style="width:100%;margin-top:10px;border:1px solid #000;">
														   <tbody>
															  <tr>
																 <td style="padding:10px;">
																	<table style="width:100%;">
																	   <tbody>
																		  <tr>
																			 <td style="width:30%;">
																				<p style="margin:0;font-weight:500;font-size:17px;">Contract #</p>
																			 </td>
																			 <td style="width:70%;">
																				<p style="border-bottom: 1px solid #000;margin: 0px;font-size: 14px;">'.$_POST['contact_no'].'</p>
																			 </td>
																		  </tr>
																	   </tbody>
																	</table>
																	<table style="width:100%;">
																	   <tbody>
																		  <tr>
																			 <td style="width:30%;">
																				<p style="margin:0;font-weight:500;font-size:17px;">File No.</p>
																			 </td>
																			 <td style="width:70%;">
																				<p style="border-bottom: 1px solid #000;margin: 0px;font-size: 14px;">'.$_POST['contact_file_no'].'</p>
																			 </td>
																		  </tr>
																	   </tbody>
																	</table>
																	<table style="width:100%;">
																	   <tbody>
																		  <tr>
																			 <td style="width:30%;">
																				<p style="margin:0;font-weight:500;font-size:17px;">Date</p>
																			 </td>
																			 <td style="width:70%;">
																				<p style="border-bottom: 1px solid #000;margin: 0px;font-size: 14px;">'.$_POST['contact_date'].'</p>
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
								<table style="width:100%;border-collapse: collapse;">
								   <tbody>
									  <tr>
										 <td>
											<table style="width:100%;margin-top:15px;">
											   <tbody>
												  <tr>
													 <td style="padding: 0 0 0px 0;width:20%;"><span style="font-size:14px;">Agreement between:</span></td>
													 <td style="width:80%">
														<p style="font-size:14px;margin:2px 0;border-bottom: 1px solid #000;text-transform:uppercase;font-weight:500;">'.$_POST['agreement_between'].'</p>
													 </td>
												  </tr>
												  <tr>
													 <td colspan="2">
														<table style="width:100%;">
														   <tbody>
															  <tr>
																 <td style="width:16%;"><span style="font-size: 14px;">And (customer)</span></td>
																 <td style="width:84%;">
																	<p style="border-bottom: 1px solid #000;color: #333;font-weight: 600;margin: 2px 0px;font-size: 14px;text-transform: uppercase;">'.$_POST['and_customer'].'</p>
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
								<table style="width:100%;border-collapse:collapse;">
								   <tbody>
									  <tr>
										 <td colspan="2">
											<table style="width:100%;margin-top:10px;">
											   <tbody>
												  <tr>
													 <td colspan="2">
														<table style="width:100%;">
														   <tr>
															  <td style="padding: 0 0 5px 0;">
																 <p style="color: #333;margin: 0px;font-size:15px;font-weight: 600;">(1) Customer seeks information regarding shared living accomodations with the following:</p>
															  </td>
														   </tr>
														</table>
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
																									 <td style="width:30%;padding: 0;"><span style="font-size: 14px;">Date Available:</span></td>
																									 <td style="width:70%;padding: 0;">
																										<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['customer_date_available'].'</p>
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
																						 <td style="width:45%;padding: 0;"><span style="font-size: 14px;">Geographical Location:</span></td>
																						 <td style="width:55%;padding: 0;">
																							<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['customer_geo_location'].'</p>
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
																						 <td style="width:50%;padding: 0;"><span style="font-size: 14px;">Elevator Service required:</span></td>
																						 <td style="width:50%;padding: 0;">
																							<table style="width:100%;">
																							   <td>
																								  <p style="display:inline-flex;color: #333;margin: 0px;font-size: 14px;"><input type="radio" style="" name="elevateor_service" '.(($_POST['customer_elevator']=='Yes')?'Checked':"").' ><label style="padding-left:20px;">Yes</label></p>
																							   </td>
																							   <td>
																								  <p style="margin-left:-40px;display:inline-flex;color: #333;margin: 0px;font-size: 14px;"><input type="radio" style="width:100px;" name="elevateor_service" '.(($_POST['customer_elevator']=='No')?'Checked':"").'><label style="padding-left:20px;">No</label></p>
																							   </td>
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
																									 <td style="width:65%;padding: 0;"><span style="font-size: 14px;">Monthly/ Weekly rental Range $: </span>
																									 </td>
																									 <td style="width:35%;padding: 0;">
																										<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['customer_rental_range'].'</p>
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
																									 <td style="width:48%;padding: 0;"><span style="font-size: 14px;">Type of Accomodation:</span>
																									 </td>
																									 <td style="width:52%;padding: 0;">
																										<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['accomodation'].'</p>
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
																				<table style="width:100%;margin-top:-30px;">
																				   <tbody>
																					  <tr>
																						 <td style="width:20%;padding: 0;"><span style="font-size: 14px;">Other Requirements:</span></td>
																						 <td style="width:80%;padding: 0;">
																							<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['customer_other_requirement'].'</p>
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
											<table style="width:100%;margin-top:10px;">
											   <tbody>
												  <tr>
													 <td colspan="2">
														<table style="width:100%;">
														   <tr>
															  <td style="padding: 0 0 5px 0;">
																 <p style="color: #333;margin: 0px;font-size:15px;font-weight: 600;">(2) Vender represent that the following listings Meet customers specification as set forth in Paragraph(1):</p>
															  </td>
														   </tr>
														</table>
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
																									 <td style="width:6%;padding: 0;"><span style="font-size: 14px;">Address:</span></td>
																									 <td style="width:94%;padding:0;">
																										<p style="color: #333;margin: 0px;font-size:14px;border-bottom:1px solid #000;">'.$_POST['vender_address'].'</p>
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
																						 <td style="width:35%;padding: 0;"><span style="font-size: 14px;">Phone # of Owner:</span></td>
																						 <td style="width:65%;padding: 0;">
																							<p style="color: #333;margin: 0px;font-size:14px;border-bottom:1px solid #000;">'.$_POST['vender_phone_owner'].'</p>
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
																						 <td style="width:30%;padding:2px 0 0 0;"><span style="font-size: 14px;">Utility required:</span></td>
																						 <td style="width:70%;padding: 0;">
																							<table style="width:100%;">
																							   <td>
																								  <input type="radio" name="elevateor_service" style="margin-top:3px;" '.(($_POST['vender_utility']=='Yes')?'Checked':"").'><span style="color: #333;margin: 0px;font-size: 14px;">Yes</span>
																								  <input type="radio" name="elevateor_service" style="margin-top:3px;" '.(($_POST['vender_utility']=='No')?'Checked':"").'><span style="color: #333;margin: 0px;font-size: 14px;">No</span>
																							   </td>
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
																						 <td style="width:50%;padding: 0;"><span style="font-size: 14px;">Elevator Service required:</span></td>
																						 <td style="width:50%;padding: 0;">
																							<table style="width:100%;">
																							   <td>
																								  <p style="display:inline-flex;color: #333;margin: 0px;font-size: 14px;"><input type="radio" style="" name="elevateor_service" '.(($_POST['vender_elevator']=='Yes')?'Checked':"").'><label style="padding-left:20px;">Yes</label></p>
																							   </td>
																							   <td>
																								  <p style="margin-left:-40px;display:inline-flex;color: #333;margin: 0px;font-size: 14px;"><input type="radio" style="width:100px;" name="elevateor_service" '.(($_POST['vender_elevator']=='No')?'Checked':"").'><label style="padding-left:20px;">No</label></p>
																							   </td>
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
																 <td style="width:50%;padding-left: 10px;">
																	<table style="width:100%;">
																	   <tbody>
																		  <tr>
																			 <td colspan="2">
																				<table style="width:100%;">
																				   <tbody>
																					  <tr>
																						 <td style="width:68%;padding: 0;"><span style="font-size: 14px;">Name of Owner or Primary Tenant:</span>
																						 </td>
																						 <td style="width:32%;padding: 0;">
																							<p style="color: #333;margin: 0px;font-size:14px;border-bottom:1px solid #000;">'.$_POST['vender_name_of_owner'].'</p>
																						 </td>
																					  </tr>
																					  <tr>
																						 <td colspan="2">
																							<table style="width:100%;">
																							   <tbody>
																								  <tr>
																									 <td style="width:40%;padding: 0;"><span style="font-size: 14px;">Phone # of Owner: </span>
																									 </td>
																									 <td style="width:60%;padding: 0;">
																										<p style="color: #333;margin: 0px;font-size:14px;border-bottom:1px solid #000;">'.$_POST['vender_phone_owner'].'</p>
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
																									 <td style="width:30%;padding: 0;"><span style="font-size: 14px;">Floor Location:</span>
																									 </td>
																									 <td style="width:70%;padding: 0;">
																										<p style="color: #333;margin: 0px;font-size:14px;border-bottom:1px solid #000;">'.$_POST['vender_floor_location'].'</p>
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
																									 <td style="width:12%;padding: 0;"><span style="font-size: 14px;">Date:</span>
																									 </td>
																									 <td style="width:88%;padding: 0;">
																										<p style="color: #333;margin: 0px;font-size:14px;border-bottom:1px solid #000;">'.$_POST['vender_date'].'</p>
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
									  <tr>
										 <td colspan="2">
											<table style="width:100%;margin-top:-15px;">
											   <tbody>
												  <tr>
													 <td style="padding: 0 0 5px 0;width:100%;">
														<table>
														   <tr>
															  <td style="width:44%;padding:0 0 0 0;">
																 <p style="color: #333;margin: 0px;font-size:15px;font-weight: 600;text-transform: capitalize;">(3) Non-Refundable Fee Paid:$</p>
															  </td>
															  <td style="width:56%;padding:0px 0;">
																 <p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['non_refundable_free_paid'].'</p>
															  </td>
														   </tr>
														</table>
												  </tr>
											   </tbody>
											</table>
										 </td>
									  </tr>					   
									  <tr>
										 <td colspan="2">
											<table style="width:100%;margin-top:0px;">
											   <tbody>
												  <tr>
													 <td style="padding: 0 0 5px 0;width:100%;">
														<p style="color: #333;margin: 0px;font-size:15px;font-weight: 600;text-transform: capitalize;">(4) Contract Terms:</p>
													 </td>
												  </tr>
												  <tr>
													 <td colspan="2" style="width:50%;padding-right:10px;">
														<table style="width: 100%;">
														   <tbody>
															  <tr>
																 <td colspan="2" style="width:35%;">
																	<table style="width:100%;">
																	   <tbody>
																		  <tr>
																			 <td style="width:58%;padding: 2px 0;"><span style="font-size: 14px;">Contract start Date:</span></td>
																			 <td style="width:42%;padding:2px 0;">
																				<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['contact_start_date'].'</p>
																			 </td>
																		  </tr>
																	   </tbody>
																	</table>
																 </td>
																 <td colspan="2" style="width:65%;padding-left:20px;">
																	<table style="width: 100%;">
																	   <tbody>
																		  <tr>
																			 <td colspan="2">
																				<table style="width:100%;">
																				   <tbody>
																					  <tr>
																						 <td style="width:36%;padding: 2px 0;"><span style="font-size: 14px;">Approximate Duration:</span></td>
																						 <td style="width:64%;padding: 0;">
																							<input type="radio" style="margin-top:3px;color: #333;" value="1 Month" '.(($_POST['approximate_duration']=='1 Month')?'Checked':"").' /><span style="font-size:13px;">1 month</span>
																							<input type="radio" style="margin-top:3px;color: #333;" value="2 Months" '.(($_POST['approximate_duration']=='2 Months')?'Checked':"").' /><span style="font-size:13px;">2 months</span>
																							<input type="radio" style="margin-top:3px;color: #333;" value="3 Months" '.(($_POST['approximate_duration']=='3 Months')?'Checked':"").' /><span style="font-size:13px;">3 months</span>
																							<input type="radio" style="margin-top:3px;color: #333;" value="1 Year" '.(($_POST['approximate_duration']=='1 Year')?'Checked':"").' /><span style="font-size:13px;">1 year</span>
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
											<table style="width:100%;margin-top:0px;">
											   <tbody>
												  <tr>
													 <td style="padding: 0 0 5px 0;width:100%;padding:0;">
														<p style="color: #333;margin: 0px;font-size:15px;font-weight: 600;text-transform: capitalize;">(5) The vendor agrees to be personally responsible And liable for carrying out the terms of this agreement.</p>
													 </td>
												  </tr>
											   </tbody>
											</table>
										 </td>
									  </tr>
									  <tr>
										 <td colspan="2">
											<table style="width:100%;margin-top:20px;">
											   <tbody>
												  <tr>
													 <td style="padding: 0 0 5px 0;width:100%;">
														<p style="color: #333;margin: 0px;font-size:15px;font-weight: 600;text-transform: capitalize;">(6) Any Complaints about this apartment sharing, AGENT SHOULD BE MADE TO:</p>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<p style="font-size:14px;">New York State, Department of state office of the New York State, 123 William Street 19th FL Department of State New York, NY 10038.<br>Telephone:</b> (212) - 417-5747</p>
													 </td>
												  </tr>
											   </tbody>
											</table>
										 </td>
									  </tr>
									  <tr>
										 <td colspan="2">
											<table style="width:100%;margin-top:20px;">
											   <tbody>
												  <tr>
													 <td style="padding: 0 0 5px 0;width:100%;">
														<p style="color: #333;margin: 0px;font-size:15px;font-weight: 600;text-transform: capitalize;">(7) This document has been filled out and signed by:</p>
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
																			 <td style="width:28%;padding: 0;"><span style="font-size: 14px;">Agent Name:</span></td>
																			 <td style="width:72%;padding: 0;">
																				<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['agent_name'].'</p>
																			 </td>
																		  </tr>
																		  <tr>
																			 <td colspan="2">
																				<table style="width:100%;">
																				   <tbody>
																					  <tr>
																						 <td style="width:35%;padding: 0;"><span style="font-size: 14px;">Agent Signature:</span></td>
																						 <td style="width:65%;padding: 0;">
																							<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['agent_signature'].'</p>
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
																						 <td style="width:11%;padding: 0;"><span style="font-size: 14px;">Date:</span></td>
																						 <td style="width:89%;padding: 0;">
																							<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['agent_date'].'</p>
																						 </td>
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
																						 <td style="width:36%;padding: 0;"><span style="font-size: 14px;">Customer Name:</span></td>
																						 <td style="width:64%;padding: 0;">
																							<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['customer_name'].'</p>
																						 </td>
																					  </tr>
																					  <tr>
																						 <td colspan="2">
																							<table style="width:100%;">
																							   <tbody>
																								  <tr>
																									 <td style="width:43%;padding: 0;"><span style="font-size: 14px;">Customer Signature:</span></td>
																									 <td style="width:57%;padding: 0;">
																										<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['customer_signature'].'</p>
																									 </td>
																								  </tr>
																								  <tr>
																									 <td colspan="2">
																										<table style="width:100%;">
																										   <tbody>
																											  <tr>
																												 <td style="width:11%;padding: 0;"><span style="font-size: 14px;">Date:</span></td>
																												 <td style="width:89%;padding: 0;">
																													<p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">'.$_POST['customer_date'].'</p>
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
										 </td>
									  </tr>
								   </tbody>
								</table>
							 </td>
						  </tr>
					</table>
					<div class="page_break"></div>
					<table style="width:100%;">
					   <tr>
						  <td colspan="2" style="padding-bottom:10px;">
							 <table style="width:100%;">
								<tbody>
								   <tr>
									  <td colspan="2" style="padding-bottom:30px;">
										 <table style="width:100%;">
											<tbody>
											   <tr>
												  <td style="width:45%;padding-top:10px;">
													'.get_custom_logo().'
												  </td>
												  <td style="width:55%;padding: 20px 0px 0 10%;">
													 <h2 style="text-align: right;margin-top: 0;margin-bottom: 0;">Apartment Sharing Contract</h2>
													 <table style="width:100%;margin-top:10px;border:1px solid #000;">
														<tbody>
														   <tr>
															  <td style="padding:10px;">
																 <table style="width:100%;">
																	<tbody>
																	   <tr>
																		  <td style="width:30%;">
																			 <p style="margin:0;font-weight:500;font-size:17px;">Contract #</p>
																		  </td>
																		  <td style="width:70%;">
																			 <p style="border-bottom: 1px solid #000;margin: 0px;font-size: 14px;">'.$_POST['contact_no'].'</p>
																		  </td>
																	   </tr>
																	</tbody>
																 </table>
																 <table style="width:100%;">
																	<tbody>
																	   <tr>
																		  <td style="width:30%;">
																			 <p style="margin:0;font-weight:500;font-size:17px;">File No.</p>
																		  </td>
																		  <td style="width:70%;">
																			 <p style="border-bottom: 1px solid #000;margin: 0px;font-size: 14px;">'.$_POST['contact_file_no'].'</p>
																		  </td>
																	   </tr>
																	</tbody>
																 </table>
																 <table style="width:100%;">
																	<tbody>
																	   <tr>
																		  <td style="width:30%;">
																			 <p style="margin:0;font-weight:500;font-size:17px;">Date</p>
																		  </td>
																		  <td style="width:70%;">
																			 <p style="border-bottom: 1px solid #000;margin: 0px;font-size: 14px;">'.$_POST['contact_date'].'</p>
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
							 <table style="width:100%;margin-top:35px;">
								<tbody>
								   <tr>
									  <td style="padding: 0 0 10px 0;width:100%;">
										 <p style="color: #333;margin: 0px;font-size:20px;font-weight: 600;text-transform: capitalize;text-align: center;"> Additional Notes:</p>
									  </td>
								   </tr>
								   <tr>
									  <td>';
										foreach ($textAr as $line) { 
										 $html .= '<p style="border-bottom:1px solid #000;margin-bottom:5px;color:#333;font-size:14px;">'.$line.'</p>';
										}								
									 $html .= '</td>
								   </tr>
								   <tr>
									  <td colspan="2" style="padding-top:30px;">
										 <table style="width: 100%;">
											<tbody>
											   <tr>
												  <td style="width:50%;padding-right:10px;">
													 <table style="width:100%;">
														<tbody>
														   <tr>
															  <td style="width:28%;padding: 0;"><span style="font-size: 14px;">Agent Name:</span></td>
															  <td style="width:72%;padding: 0;">
																 <p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">test12</p>
															  </td>
														   </tr>
														   <tr>
															  <td colspan="2">
																 <table style="width:100%;">
																	<tbody>
																	   <tr>
																		  <td style="width:35%;padding: 0;"><span style="font-size: 14px;">Agent Signature:</span></td>
																		  <td style="width:65%;padding: 0;">
																			 <p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">test123</p>
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
																		  <td style="width:11%;padding: 0;"><span style="font-size: 14px;">Date:</span></td>
																		  <td style="width:89%;padding: 0;">
																			 <p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">23 jun, 2020</p>
																		  </td>
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
																		  <td style="width:35%;padding: 0;"><span style="font-size: 14px;">Customer Name:</span></td>
																		  <td style="width:65%;padding: 0;">
																			 <p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">abc</p>
																		  </td>
																	   </tr>
																	   <tr>
																		  <td colspan="2">
																			 <table style="width:100%;">
																				<tbody>
																				   <tr>
																					  <td style="width:42%;padding: 0;"><span style="font-size: 14px;">Customer Signature:</span></td>
																					  <td style="width:58%;padding: 0;">
																						 <p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">abc</p>
																					  </td>
																				   </tr>
																				   <tr>
																					  <td colspan="2">
																						 <table style="width:100%;">
																							<tbody>
																							   <tr>
																								  <td style="width:12%;padding: 0;"><span style="font-size: 14px;">Date:</span></td>
																								  <td style="width:88%;padding: 0;">
																									 <p style="font-size:14px;margin:0;border-bottom: 1px solid #000;">23 jun, 2020</p>
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
						  </td>
					   </tr>
					   </td>
					   </tr>
					</table>
					</div>
		   </body>
		</html>';


       	//require_once get_stylesheet_directory_uri().'vendor/autoload.php';
		

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
		$uploadfile = $uploaddir['path'].'/contract_file_'.$post_id.'.pdf';
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
		$contract_id = wp_insert_post(
				array(
					'post_type'		=> 'contracts',
					'post_title' 	=> 'Contract Created',
					'post_content' 	=> 'Contracts',
					'post_status'   => 'publish'
				));		
		if($contract_id){
			update_post_meta($contract_id,'contract_data', $contract_data); 
			update_post_meta($contract_id,'contract_pdf',$attach_id);
			update_post_meta($contract_id,'deal_id',$post_id);
			update_post_meta($contract_id,'tenant_email',$email);
			update_post_meta($contract_id,'property_owner_email',get_the_author_meta( 'user_email' , $authid));
			update_post_meta($post_id,'contract_id',$contract_id);		
			update_post_meta($post_id,'deal_created', 1);		
			$args = array(
				'ID'             => $property_id,
				'post_status' => 'rented',
			);
			wp_update_post( $args );			
			contract_created_notification_tenant($email,get_the_title($property_id),$attach_id);
			contract_created_notification_property_owner(get_the_author_meta( 'user_email' , $authid),get_the_title($property_id),$name,$attach_id);
		}
		?>
		<script>
				jQuery(document).ready(function($) {
					jQuery('.contract-popup').html('Contract Created Successfully');
					jQuery('#create_contract_alert').modal('show');	
				});
		</script>
		<?php 	
}

$contract_data = '';
$contract_file_id = '';
$contract_id = get_post_meta($post_id,'contract_id',true);
if($contract_id){
	$contract_data = get_post_meta($contract_id,'contract_data', true); 
	$contract_file_id = get_post_meta($contract_id,'contract_pdf', true);
}

$lead_source = get_post_meta($post_id,'lead_source',true);
$phone = get_post_meta($post_id,'phone',true);
$description = get_post_meta($post_id,'description',true);
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
<style>
.agent-space {
    width: 78%;
}
.top-right-heading.date-space {
    width: 80%;
}
.agent-sign-space {
    width: 73%;
}
.date-last-space {
    width: 90%;
}
.customer-space {
    width: 75%;
}
.customer-sign-space {
    width: 70%;
}
.address-space {
    width: 75%;
}
.set-space {
    margin-top: 20px;
}
.set-space textarea {
    margin-bottom: 50px;
}
.image_wrapper {
    display: flex;
    justify-content: space-between;
}
.logo_pannel img {
	width:100%;
}
.top_heading h3 {
    margin: 0;
}
.header_top_content_pannel {
    border: 1px solid #000;
    padding: 20px;
    margin-top: 20px;
}
.header_top_content {
    display: flex;
    justify-content: space-between;
}
.header_top_content .top-right-heading {
    display: inline-block;
}
.form-input {
    width: 100% !important;
    border: none !important;
    background-color: #fff !important;
    border-bottom: 1px solid #000 !important;
    border-radius: unset !important;
    margin-bottom: 0 !important;
    color: #333;
    height: 20px !important;
    font-size: 15px;
    padding: 0 2px !important;
}
.top-right-heading span {
    font-size: 17px;
}
.agreement-pannel {
    clear: both;
    margin-top: 20px;
}
.agreement-pannel .agreement-pannel-content {
    float: left;
}
.agreement-pannel .agreement-pannel-content.first {
    width:15%;
    margin-bottom:10px;
}
.agreement-pannel .agreement-pannel-content.second {
    width:85%;
}
.agreement-pannel-content span {
    font-size: 16px;
}
.form-content {
    clear: both;
    padding-top: 20px;
}
p.sub-heading {
    font-size: 16px;
    font-weight: 600;
}
sub-heading2{
    font-size: 14px;
}
.form-content-pannel {
    display: flex;
    justify-content: space-between;
}

.form-content-inner-pannel {
    width: 100%;
}

.form-content-inner-pannel:first-child {
    padding-right: 15px;
}
.form-content-inner-pannel:last-child {
    padding-left: 15px;
}
.form-content-inner-pannel.form-pannel-1 .pannel2 {
    width: 75%;
}
.form-content-pannel select {
    border: unset !important;
    background-color: #fff !important;
    border-bottom: 1px solid #000 !important;
    border-radius: unset !important;
    padding: 0 20px !important;
    height: 20px !important;
}
.form-content-pannel .radio-inline span {
    width: 60px;
}
.form-content-pannel .radio-inline {
    display: flex;
    padding-left: 0;
    margin-left: 30px;
}
.form-content-pannel .radio-inline span input {
    width: 15px !important;
    height: 15px !important;
}
.agreement-pannel-content.second-1 {
    width: 85%;
}
.chk-inline span {
    width: unset !important;
    font-size: 14px !important;
    padding-right: 10px;
}
.form-content textarea {
    background-color: #fff !important;
}
.create_contract {
    margin: 25px;
    text-align: center;
}

input:required:focus {
  border: 1px solid red;
  outline: none;
}

textarea:required:focus {
 border: 1px solid red;
 outline: none;
}
</style>
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
			
			<?php if(!empty($contract_file_id)){ ?>
			<div class="col-md-6">
				<div class="deal-detail-paymentstatus">
						<h3>Contract Created <span> <a href="<?php echo wp_get_attachment_url($contract_file_id); ?>" download><i class="fa fa-download" aria-hidden="true"></i></a> <a href="<?php echo wp_get_attachment_url($contract_file_id); ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></span></h3>
				</div>
			</div>
			<?php } ?>
			
		</div>
        <form action="" id="contract_form" method="post">
		<div class="row contract-detail-formsection">
						<div class="image_wrapper">
							<div class="logo_pannel">
								<?php echo get_custom_logo(); ?>
							</div>
							<div class="top_heading">
								<h3>Apartment Sharing Contract</h3>
								<div class="header_top_content_pannel">
									<div class="header_top_content">
										<div class="top-right-heading"><span>Contact #</span></div>
										<div class="top-right-heading"><input type="text" class="form-input" id="contact_no" value="<?php if(!empty($contract_data)) { echo $contract_data['contact_no']; }  ?>" name="contact_no" required></div>
									</div>
									<div class="header_top_content">
										<div class="top-right-heading"><span>File No.</span></div>
										<div class="top-right-heading"><input type="text" class="form-input" id="contact_file_no" name="contact_file_no" value="<?php if(!empty($contract_data)) { echo $contract_data['contact_file_no']; }  ?>" required></div>
									</div>
									<div class="header_top_content">
										<div class="top-right-heading"><span>Date</span></div>
										<div class="top-right-heading date-space"><input type="date" class="form-input" id="contact_date" name="contact_date" value="<?php if(!empty($contract_data)) { echo $contract_data['contact_date']; }  ?>" required></div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-main">
							<div class="agreement-pannel">
							<div class="agreement-pannel-content first">
								<span>Agreement between:</span>
							</div>
							<div class="agreement-pannel-content second">
								<span><input type="text" class="form-input" name="agreement_between" value="<?php if(!empty($contract_data)) { echo $contract_data['agreement_between']; }  ?>" required></span></div>
							</div>
							<div class="agreement-pannel">
							<div class="agreement-pannel-content first">
								<span>And (customer):</span>
							</div>
							<div class="agreement-pannel-content second">
								<span><input type="text" class="form-input" name="and_customer" value="<?php if(!empty($contract_data)) { echo $contract_data['and_customer']; }  ?>" required></span></div>
							</div>
						</div>
						<div class="form-content">
							<p class="sub-heading">(1)Customer seeks information regarding shared living accomodations with the following:</p>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Date Available:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
										<span><input type="date" class="form-input" name="customer_date_available" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_date_available']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Monthly/ Weekly rental Range $:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="text" class="form-input" name="customer_rental_range" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_rental_range']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Geographical Location:</span>
										</div>
										<div class="agreement-pannel-content pannel2 location-space">
										<span><input type="text" class="form-input" name="customer_geo_location" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_geo_location']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Type of Accomodation:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><select name="accomodation"><option <?php if(!empty($contract_data)) { if($contract_data['accomodation'] == "Appartment" ){ echo "selected"; } } ?> value="Appartment">Appartment</option><option  <?php if(!empty($contract_data)) { if($contract_data['accomodation'] == "Room" ){ echo "selected"; } } ?> value="Room">Room</option></select></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Elevator Service required:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
											<div class="radio-inline">
										<span><input type="radio" class="form-input" value="Yes" name="customer_elevator" <?php if(!empty($contract_data)) { if($contract_data['customer_elevator'] == "Yes" ){ echo "checked"; } } ?> required>Yes</span>
										<span><input type="radio" class="form-input" value="No" name="customer_elevator"  <?php if(!empty($contract_data)) { if($contract_data['customer_elevator'] == "No" ){ echo "checked"; } } ?> required>No</span></div>
									</div>
									</div>
								</div>
						</div>
						<div class="form-main">
							<div class="agreement-pannel">
							<div class="agreement-pannel-content first-1">
								<span>Other Requirements:</span>
							</div>
							<div class="agreement-pannel-content second-1">
								<span><input type="text" class="form-input" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_other_requirement']; }  ?>" name="customer_other_requirement" required></span></div>
							</div>
						</div>
						<div class="form-content form-content2">
							<p class="sub-heading">
(2) Vender represent that the following listings meet customers specification as set forth in Paragraph(1):</p>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Address:</span>
										</div>
										<div class="agreement-pannel-content pannel2 address-space">
										<span><input type="text" class="form-input" name="vender_address" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_address']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Name of Owner or Primary Tenant:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="text" class="form-input" name="vender_name_of_owner" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_name_of_owner']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Geographical Location:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
										<span><input type="text" class="form-input" name="vender_geo_location" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_geo_location']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Phone # of Owner:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="text" class="form-input" name="vender_phone_owner" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_phone_owner']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Utility required:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
											<div class="radio-inline">
										<span><input type="radio" class="form-input" name="vender_utility" value="Yes" <?php if(!empty($contract_data)) { if($contract_data['vender_utility'] == "Yes" ){ echo "checked"; } } ?> required>Yes</span>
										<span><input type="radio" class="form-input" name="vender_utility" value="No" <?php if(!empty($contract_data)) { if($contract_data['vender_utility'] == "No" ){ echo "checked"; } } ?> required>No</span></div>
									</div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Floor Location:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="text" class="form-input" name="vender_floor_location" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_floor_location']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Elevator Service required:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
											<div class="radio-inline">
										<span><input type="radio" class="form-input" name="vender_elevator" value="Yes" <?php if(!empty($contract_data)) { if($contract_data['vender_elevator'] == "Yes" ){ echo "checked"; } } ?> required>Yes</span>
										<span><input type="radio" class="form-input" name="vender_elevator" value="No" <?php if(!empty($contract_data)) { if($contract_data['vender_elevator'] == "No" ){ echo "checked"; } } ?> required>No</span></div>
									</div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Date:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="date" class="form-input" name="vender_date" value="<?php if(!empty($contract_data)) { echo $contract_data['vender_date']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
						</div>
						<div class="form-content form-content2">
							<div class="form-content-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<p class="sub-heading">(3)Non-Refundable Fee Paid:$</p>
										</div>
										<div class="agreement-pannel-content pannel2">
										<span><input type="text" class="form-input" name="non_refundable_free_paid" value="<?php if(!empty($contract_data)) { echo $contract_data['non_refundable_free_paid']; }  ?>" required></span></div>
									</div>
								</div>
						</div>
						<div class="form-content form-content2">
							<p class="sub-heading">(4)Contract Terms:</p>
						
							
							<div class="form-content-pannel">

								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>Contract start Date:</span>
							</div>
							<div class="agreement-pannel-content pannel2">
								<span><input type="date" class="form-input" name="contact_start_date" value="<?php if(!empty($contract_data)) { echo $contract_data['contact_start_date']; }  ?>" required></span></div>
							</div>
								</div>
								<div class="form-content-inner-pannel">

									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Approximate Duration:</span>
										</div>
										<div class="agreement-pannel-content pannel2">
											<div class="radio-inline chk-inline">
										<span><input type="radio" class="form-input" name="approximate_duration" value="1 Month" <?php if(!empty($contract_data)) { if($contract_data['approximate_duration'] == "1 Month" ){ echo "checked"; } } ?> required>1 Month</span>
										<span><input type="radio" class="form-input" name="approximate_duration" value="2 Months" <?php if(!empty($contract_data)) { if($contract_data['approximate_duration'] == "2 Months" ){ echo "checked"; } } ?> required>2 Months</span>
										<span><input type="radio" class="form-input" name="approximate_duration" value="3 Months" <?php if(!empty($contract_data)) { if($contract_data['approximate_duration'] == "3 Months" ){ echo "checked"; } } ?> required>3 Months</span>
										<span><input type="radio" class="form-input" name="approximate_duration" value="1 Year" <?php if(!empty($contract_data)) { if($contract_data['approximate_duration'] == "1 Year" ){ echo "checked"; } } ?> required>1 Year</span></div>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-content form-content2">
							<p class="sub-heading">(5) The Vendor Agrees To Be Personally Responsible And Liable For Carrying Out The Terms Of This Agreement.</p>
						
						</div>
						<div class="form-content form-content2">
							<p class="sub-heading">(6) Any Complaints About This Apartment Sharing, AGENT SHOULD BE MADE TO:</p>
							<p class="sub-heading2">New York State, Department of state office of the New York State, 123 William Street 19th FL Department of State New York, NY 10038 .<br><b>Telephone:</b> (212) - 417-5747</p>
						
						</div>
						<div class="form-content">
							<p class="sub-heading">
(7) This Document Has Been Filled Out And Signed By:</p>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Agent Name:</span>
										</div>
										<div class="agreement-pannel-content pannel2 agent-space">
										<span><input type="text" class="form-input" name="agent_name" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_name']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Customer Name:</span>
							</div>
							<div class="agreement-pannel-content pannel2 customer-space">
								<span><input type="text" class="form-input" name="customer_name" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_name']; }  ?>" required></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>
Agent Signature:</span>
										</div>
										<div class="agreement-pannel-content pannel2 agent-sign-space">
										<span><input type="text" class="form-input" name="agent_signature" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_signature']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Customer Signature:</span>
							</div>
							<div class="agreement-pannel-content pannel2 customer-sign-space">
								<input type="text" class="form-input" name="customer_signature" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_signature']; }  ?>" required></span></div></div>
							</div>
								</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>
Date:</span>
										</div>
										<div class="agreement-pannel-content pannel2 date-last-space">
										<span><input type="date" class="form-input" name="agent_date" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_date']; }  ?>" required></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Date:</span>
							</div>
							<div class="agreement-pannel-content pannel2 date-last-space">
								<input type="date" class="form-input" name="customer_date" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_date']; }  ?>" required></span></div></div>
							</div>
								</div>
							</div>
								<div class="form-content set-space">
							<p class="sub-heading text-center">Additional Notes</p>
							<textarea cols="20" rows="10" name="additional_notes"><?php if(!empty($contract_data)) { echo $contract_data['additional_notes']; }  ?></textarea>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>Agent Name:</span>
										</div>
										<div class="agreement-pannel-content pannel2 agent-space">
										<span><input type="text" class="form-input" name="agent_name_two" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_name_two']; }  ?>"></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Customer Name:</span>
							</div>
							<div class="agreement-pannel-content pannel2 customer-space">
								<span><input type="text" class="form-input" name="customer_name_two" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_name_two']; }  ?>"></span></div>
							</div>
								</div>
							</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>
Agent Signature:</span>
										</div>
										<div class="agreement-pannel-content pannel2 agent-sign-space">
										<span><input type="text" class="form-input" name="agent_signature_two" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_signature_two']; }  ?>"></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Customer Signature:</span>
							</div>
							<div class="agreement-pannel-content pannel2 customer-sign-space">
								<input type="text" class="form-input" name="customer_signature_two" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_signature_two']; }  ?>"></div></div>
							</div>
								</div>
							<div class="form-content-pannel">
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
										<div class="agreement-pannel-content pannel1">
											<span>
Date:</span>
										</div>
										<div class="agreement-pannel-content pannel2 date-last-space">
										<span><input type="date" class="form-input" name="agent_date_two" value="<?php if(!empty($contract_data)) { echo $contract_data['agent_date_two']; }  ?>"></span></div>
									</div>
								</div>
								<div class="form-content-inner-pannel">
									<div class="agreement-pannel">
							<div class="agreement-pannel-content pannel1">
								<span>
Date:</span>
							</div>
							<div class="agreement-pannel-content pannel2 date-last-space">
								<input type="date" class="form-input" name="customer_date_two" value="<?php if(!empty($contract_data)) { echo $contract_data['customer_date_two']; }  ?>"></div></div>
							</div>
								</div>
							</div>
						</div>		
    </form>
</div>
</div>
<div class="margin-top-55"></div>
</div>

<!--Modal for Contract Create -->
<div class="modal fade popup-main--section" id="create_contract_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="contract-popup">
        	<h3></h3>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/dropzone.js"></script>
<script>
	jQuery(".dropzone").dropzone({
		dictDefaultMessage: "<i class='sl sl-icon-plus'></i> Click here or drop files to upload",
	});
</script>
<script type="text/javascript">
function lockForm(objForm) {
  var elArr = objForm.elements;
  for(var i=0; i<elArr.length; i++) { 
    switch (elArr[i].type) {
      case 'radio': elArr[i].disabled = true; break;
      case 'checkbox': elArr[i].disabled = true; break;
      case 'select-one': elArr[i].disabled = true; break;
      case 'select-multiple': elArr[i].disabled = true; break;
      case 'text': elArr[i].readOnly = true; break;
      case 'textarea': elArr[i].readOnly = true; break;
      case 'button': elArr[i].disabled = true; break;
      case 'submit': elArr[i].disabled = true; break;
      case 'reset': elArr[i].disabled = true; break;
      default: elArr[i].disabled = true; break;
    }
  }
}
jQuery(document).ready(function($) {
	<?php 
		if(!empty($contract_file_id)){
			?>
			lockForm(contract_form);
			<?php 
		}
	?>
});
</script>
<?php
get_footer();
?>
