<?php
/* Template Name: Lead Details */
$leadid = $_GET['leadid'];
$property_id = get_post_meta($leadid,'lead_checkout_property',true);

get_header();
?>
<!-- Wrapper -->
<div id="wrapper">

<!-- Titlebar
================================================== -->


<!-- Content
================================================== -->
<div class="lead-detail-container">		
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>Property Details</h2>
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
						?>
						
						<div class="title">
						<h4><a href="<?= site_url().'/single-property/?property_id='.$property_id ?>"><?= get_the_title($property_id) ?></a></h4>
						<span><?= get_post_meta($property_id,'address',true); ?></span>
						<p>Owner: <span><?=get_post_meta($property_id,'contact_name',true) ?></span></p>
						<span class="table-property-price"><?= get_post_meta($property_id,'price',true); ?> / <?= get_post_meta($property_id,'payment_method',true); ?></span> <span class="active--property"><?= get_post_meta($property_id,'status',true); ?></span>
						</div>
						</td>
						</tr>
					</tbody>
				</table>
				<div class="create-deal-btnsec">
					<button>Create Deal</button>
				</div>
			</div>
			<div class="col-md-6">
				<div class="leaddetail-teanentdetail">
				<h2>Tenant Details</h2>
				<div class="lead-teanent_details">
					<ul>
						<li>
							<p>Name: </p>
							<span><?=  get_post_meta($leadid, 'lead_name', true) ?></span>
						</li>
						<li>
							<p>Email:</p>
							<span><?=  get_post_meta($leadid, 'lead_email', true) ?></span>
						</li>
						<li>
							<p>Phone:</p>
							<span><?=  get_post_meta($leadid, 'lead_phone', true) ?></span>
						</li>
						<li>
							<p>Description:</p>
							<span><?=  get_post_meta($leadid, 'lead_summary', true) ?></span>
						</li>
					</ul>
				</div>
				</div>
				
			</div>
		</div>
	</div>
</div>


<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>


<!-- Scripts
================================================== -->


</div>
<!-- Wrapper / End -->
<?php
get_footer();