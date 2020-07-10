<?php
get_header();
?>
<!-- Wrapper -->
<div id="wrapper">

<!-- Content
================================================== -->
<div class="deal-detail-container">		
	<div class="container">
		<!------Stage 1---->
		<div class="dealdetail--stageonecont addnewdeal-stageone">

			<div class="row dealdetail--stageinnersection">

				<div class="col-md-6">
					<div class="addnew-deal-tenantsec">
						<h3>Tenant Details</h3>
						<ul>
							<li>
								<h5>Name </h5>
								<input class="search-field" type="text" id="t_name" value=""/>
							</li>
							<li>
								<h5>Phone</h5>
								<input  type="number" id="t_phone" value=""/>
							</li>
							<li>
								<h5>E-Mail</h5>
								<input id="t_email" type="text" value="">
							</li>
							<li>
								<h5>Description</h5>
								<textarea class="WYSIWYG" id="t_description" name="summary" cols="40" rows="3" spellcheck="true"></textarea>
							</li>
						</ul>
					</div>
					<div class="dealdetail--selectprice">
						<h2>Select Price</h2>
						<!-- Select Input -->
						<div class="select-input disabled-first-option">
							<input type="text" placeholder="Select Price" id="deal_price" data-unit="USD">
							<select>		
								<option>Price</option>
								<option>100</option>
								<option>200</option>	
								<option>300</option>	
								<option>400</option>	
								<option>500</option>	
								<option>600</option>	
								<option>700</option>	
								<option>800</option>	
								<option>900</option>
								<option>1000</option>
								<option>1100</option>
								<option>1200</option>
								<option>1300</option>
							</select>
						</div>
						<!-- Select Input / End -->
					</div>
				</div>

				<div class="col-md-6">
					<div class="deal-detail-adminnotes-sec">
						<h3>Admin Notes</h3>
						<textarea class="WYSIWYG" name="summary" cols="40" rows="3" id="admin_notes" spellcheck="true"></textarea>
					</div>
				</div>
			</div>

			<div class="deal-stage-property-suggest">
				<div class="deal-proprtysug-title">
					<h2>Select Property</h2>
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
					<button type="button" class="btn btn-primary popup__button add_deal">
					 Add Deal
					</button>
				</div>

			</div>
		
		</div>
	</div>
</div>

<!--Modal for Show Errors -->
<div class="modal fade popup-main--section" id="add_deal_field_errors" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="errorshow-popup">
			<span></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="margin-top-55"></div>

</div>
<script>
jQuery(document).ready(function($) {
	// This is required for AJAX to work on our page
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	
	function cvf_load_all_posts(page){ 
		var data = {
			page: page,
			action: "demo-pagination-load-posts"
		};

		$.post(ajaxurl, data, function(response) {
			$(".nyc_load_property").html(response);
		});
	}		
	
	cvf_load_all_posts(1);
	
	$('.cvf-universal-pagination li.active').live('click',function(){
		var page = $(this).attr('p');
		cvf_load_all_posts(page);
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
				search_name: search_name,
				search_status: search_status,
				search_type: search_type,
				search_accom: search_accom,
				search_rooms: search_rooms,
				search_min_price: search_min_price,
				search_max_price: search_max_price,
				action: "add-deal-pagination-load-posts"
			};

			// Send the data
			$.post(ajaxurl, data, function(response) {
				// If successful Append the data into our html container
				$(".nyc_load_property").html(response);
				jQuery('.loading').hide();
			}); 
	});	

	$(".select_property input:checkbox").live('change', function() {
		$('.select_property input:checkbox').not(this).prop('checked', false);  
	});		

	$(".add_deal").live('click', function() {
		var errors = false;
		var html='';
		var t_name = jQuery('#t_name').val();
		var t_phone = jQuery('#t_phone').val();
		var t_email = jQuery('#t_email').val();
		var t_description = jQuery('#t_description').val();
		var deal_price = jQuery('#deal_price').val();
		var admin_notes = jQuery('#admin_notes').val();
		var property_id = jQuery(".check_property:checked").val();
		if(t_name == ''){
			errors = true;
			html += 'Tenant Name is rquired!</br>';
		}
		if(t_phone == ''){
			errors = true;
			html += 'Tenant Phone is rquired!</br>';
		}
		if(t_email == ''){
			errors = true;
			html += 'Tenant Email is rquired!';
		}
		if(errors == false){
			jQuery('.loading').show();
			var data = {
				t_name: t_name,
				t_phone: t_phone,
				t_email: t_email,
				t_description: t_description,
				deal_price: deal_price,
				admin_notes: admin_notes,
				property_id: property_id,
				action: "add-new-custom-deal"
			};		
			// Send the data
			$.post(ajaxurl, data, function(response) {			
				jQuery('.loading').hide();
				if(response == 'success'){
					countDown();
					jQuery('#add_deal_field_errors').modal('show');						
				}
			}); 
   			
		}else{
			jQuery('.errorshow-popup span').html(html);
			jQuery('.errorshow-popup span').css('color','#c31010');
			jQuery('#add_deal_field_errors').modal('show');	
		}
	});	
	
});

var count = 4;
var redirect = '<?php echo get_site_url(); ?>/admin/deals/';		
function countDown(){
	if(count > 0){
		count--;
		jQuery('.errorshow-popup span').html("<span style='color:green;'>Deal Created Successfully. This page will redirect in <span style='color:red;'>"+count+"</span> seconds.</span>");
		setTimeout("countDown()", 1000);
	}else{
		window.location.href = redirect;
	}
}	
</script>
<?php
get_footer();
?>
