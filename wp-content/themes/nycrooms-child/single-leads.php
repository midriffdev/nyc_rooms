<?php
/* 
 * Template Name: Lead Details 
 * Template Post Type: leads
 */
$leadid      = get_the_ID();
$checkdeal   = get_post_meta($leadid,'is_deal_created',true);
$checkdealid = get_post_meta($leadid,'deal_id',true);
	
$lead_source = get_post_meta(get_the_ID(),'lead_source',true);
if($lead_source == "Property Form"){
$property_id = get_post_meta($leadid,'lead_checkout_property',true);
}
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
		     <?php if($lead_source == "Property Form"){ ?>
			 <div class="col-md-12">
			   <h4>Lead by Property Form</h4>
			 </div>
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
						<h4><a href="<?= get_post_permalink($property_id) ?>"><?= get_the_title($property_id) ?></a></h4>
						<span><?= get_post_meta($property_id,'address',true); ?></span>
						<p>Owner: <span><?=get_post_meta($property_id,'contact_name',true) ?></span></p>
						<span class="table-property-price"><?= get_post_meta($property_id,'price',true); ?> / <?= get_post_meta($property_id,'payment_method',true); ?></span> <span class="active--property"><?= get_post_meta($property_id,'status',true); ?></span>
						</div>
						</td>
						</tr>
					</tbody>
				</table>
				<div class="create-deal-btnsec">
                <?php
				    if($checkdeal && $checkdealid){
				?>
				     <button class="deal_done" disabled>Deal Done</button>
				<?php
				   } else {
				?>
			         <button class="into_deal" data-id="<?= $leadid ?>" >Create Deal</button>
				<?php
				   }
				?>
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
			<?php 
			}
			?>
			 <?php if($lead_source == "Appointment Form"){ ?>
			 <div class="col-md-12">
			   <h4>Lead by Appointment Form</h4>
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
							<p>Date:</p>
							<span><?php 
							$strtotime = get_post_meta($leadid, 'lead_datetime', true);
                            $date =  date("F j, Y", $strtotime); 
                            echo $date;
							?></span>
						</li>
						<li>
							<p>Date:</p>
							<span><?php 
							$strtotime = get_post_meta($leadid, 'lead_datetime', true);
                            $time =  date("h:i A", $strtotime); 
							 echo $time;
                            ?></span>
						</li>
						
						<li>
							<p>Phone:</p>
							<span><?=  get_post_meta($leadid, 'lead_phone', true) ?></span>
						</li>
						
						<li>
							<p>Description:</p>
							<span><?php  $leadSumary = get_post_meta($leadid, 'lead_summary', true); if($leadSumary){echo $leadSumary;} else { echo "N.A";} ?></span>
						</li>
					</ul>
				</div>
				</div>
				<div class="create-deal-btnsec">
				<?php
				    if($checkdeal && $checkdealid){
				?>
				 <button class="deal_done" disabled>Deal Done</button>
				<?php
				} else {
				?>
			     <button class="into_deal" data-id="<?= $leadid ?>" >Create Deal</button>
				<?php
				}
				?>
			    </div>
			</div>
			
			 <?php 
			 }
			 ?>
		</div>
	</div>
</div>


<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>


<!-- Scripts
================================================== -->


</div>
<!-- Modal -->
<div class="modal fade" id="ModalDeals" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Deals Created Successfully</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- Wrapper / End -->
<?php
get_footer();
?>
<script>
jQuery(document).ready(function(){
 jQuery('.into_deal').click(function(){
	        $(this).prop('disabled', true);
	        var myarrayleads = new Array();
	        var id = jQuery(this).data('id');
			myarrayleads.push(id);
			var data = {
						 'action': 'adding_multiple_deals',
						 'data':   myarrayleads
			           };
						   
						 
			  // We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.post(my_ajax_object.ajax_url, data, function(response) {
					            
				if(response == "true"){
						$('#ModalDeals').modal('show');
						setTimeout(function(){
						   window.location.reload();
						   // or window.location = window.location.href; 
						}, 2000);
				}
				
			}); 
			
	    
	});
});
</script>
