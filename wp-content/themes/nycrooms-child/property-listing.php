<?php
/* Template Name: Property Listing */

$argarray = array();
if(isset($_GET['submit'])){
$cityname = '';
if(isset($_GET['city_other']) && !empty($_GET['city_other'])){
	    $cityname = $_GET['city_other'];
} else {
	     if(isset($_GET['city_name'])){    
	        $cityname = $_GET['city_name'];
		 }
		
}
 
 if(isset($_GET['gender']) && $_GET['gender'] != 'other'){
 
       $argarray =  array(
        //comparison between the inner meta fields conditionals
        'relation'    => 'AND',
        //meta field condition one
        array(
            'key'          => 'gender',
            'value'        => $_GET['gender'],
            'compare'      => 'LIKE',
        ),
		array(
            'key'          => 'city',
            'value'        => $cityname,
            'compare'      => 'LIKE',	
        ),
        //meta field condition one
        array(
            'key'          => 'state',
            'value'        => $_GET['state'],
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => 'LIKE',
        ),
		array(
            'key'          => 'accomodation',
            'value'        => $_GET['property_type'] ,
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => 'LIKE',
        ),
		array(
            'key'          => 'people_living_count',
            'value'        => $_GET['people_living_count'] ,
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => 'LIKE',
        )
		
		
		
    );
    
 } else {
 
        $argarray =  array(
								//comparison between the inner meta fields conditionals
								'relation'    => 'AND',
								array(
										'key'          => 'city',
										'value'        => $cityname,
										'compare'      => 'LIKE',
                                 ),
								//meta field condition one
								array(
									'key'          => 'state',
									'value'        => $_GET['state'],
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								),
								array(
									'key'          => 'accomodation',
									'value'        => isset($_GET['property_type']) ? $_GET['property_type'] : '' ,
									//I think you really want != instead of NOT LIKE, fix me if I'm wrong
									//'compare'      => 'NOT LIKE',
									'compare'      => 'LIKE',
								),
								array(
										'key'          => 'people_living_count',
										'value'        => $_GET['people_living_count'] ,
										//I think you really want != instead of NOT LIKE, fix me if I'm wrong
										//'compare'      => 'NOT LIKE',
										'compare'      => 'LIKE',
                                )
		
                    );
       
	 
		 
 }
 
 
  




}

if(isset($_GET['update_search'])){

   $argarray =  array(
        //comparison between the inner meta fields conditionals
        'relation'    => 'AND',
        //meta field condition one
        array(
		   'relation'    => 'OR',
		   array(
            'key'          => 'address',
            'value'        =>  $_GET['address'],
            'compare'      => 'LIKE'
			),
			array(
            'key'          => 'city',
            'value'        => $_GET['address'],
            'compare'      => 'LIKE'
			),
			array(
            'key'          => 'state',
            'value'        => $_GET['address'],
            'compare'      => 'LIKE'
			)
			
        ),
		array(
            'key'          => 'accomodation',
            'value'        => $_GET['property_type'],
            'compare'      => 'LIKE',	
        ),
        //meta field condition one
        array(
            'key'          => 'rooms',
            'value'        => $_GET['rooms'],
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => 'LIKE',
        ),
		array(
            'key'          => 'gender',
            'value'        => $_GET['gender'] ,
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => 'LIKE',
        ),
		array(
            'key'          => 'rm_lang',
            'value'        => $_GET['rm_lang'] ,
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => 'LIKE',
        ),
		
	);
	
	if(!empty($_GET['min-price-input']) && empty($_GET['max-price-input']) ){
     $argarray[] =  array(
            'key'          => 'price',
            'value'        => str_replace(' ', '', $_GET['min-price-input']),
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => '<=',
			'type'          => 'NUMERIC'
                   );
	}
	
	if(empty($_GET['min-price-input']) && !empty($_GET['max-price-input']) ){
     $argarray[] =  array(
            'key'          => 'price',
            'value'        => str_replace(' ', '', $_GET['max-price-input']),
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => '<=',
			'type'          => 'NUMERIC'
                   );
	}
	
	if(!empty($_GET['min-price-input']) && !empty($_GET['max-price-input']) ){
     $argarray[] =  array(
							'key'          => 'price',
							'value'        => str_replace(' ', '', $_GET['min-price-input']),
							//I think you really want != instead of NOT LIKE, fix me if I'm wrong
							//'compare'      => 'NOT LIKE',
							'compare'      => '>=',
							'type'          => 'NUMERIC'
                   );
	
    $argarray[] =  array(
					'key'          => 'price',
					'value'        => str_replace(' ', '', $_GET['max-price-input']),
					//I think you really want != instead of NOT LIKE, fix me if I'm wrong
					//'compare'      => 'NOT LIKE',
					'compare'      => '<=',
					'type'          => 'NUMERIC'
                   );	
				   
	}
		
		
	
	if(isset($_GET['amenities']) && !empty($_GET['amenities'])){
	    $argarray[] = array(
            'key'          => 'amenities',
            'value'        => implode(',',$_GET['amenities']),
            //I think you really want != instead of NOT LIKE, fix me if I'm wrong
            //'compare'      => 'NOT LIKE',
            'compare'      => 'LIKE',
        );
	   
	}

}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
         'post_type'        => 'property',
		 'post_status'       => array('available','rented'),
         'posts_per_page'   => 6,
         //'no_found_rows'    => true,
         'suppress_filters' => false,
		 'paged' => $paged

        );
		
if(isset($_GET['property_status']) && $_GET['property_status'] == 'rented'){
      $args['post_status'] = 'rented';
}

if(isset($_GET['furnish-unfurnish-type']) && !empty($_GET['furnish-unfurnish-type'])){

   
			  $args['tax_query'] = array(
												array(
													'taxonomy' => 'types',
													'field' => 'slug',
													'terms' => $_GET['furnish-unfurnish-type'],
												),
								   );
						  
	   
	   
						   
}

if(!empty($argarray)){
   
  $argarray[] =  array(
            'key'          => 'property_activation',
            'value'        => 1,
            'compare'      => '=',
        );
   
   $args['meta_query'] = $argarray;
   
   
}

if(empty($_GET)){
   $argarray[] =  array(
            'key'          => 'property_activation',
            'value'        => 1,
            'compare'      => '=',
        );
   
   $args['meta_query'] = $argarray;
}



$properties = new WP_Query( $args );

get_header();
?>
<div id="wrapper">

<!-- Content
================================================== -->
<div class="fs-container" style="height:100vh;">

	<div class="fs-inner-container">

		<!-- Map -->
		<div id="map-container">
		    <div id="map" data-map-zoom="4" data-map-scroll="true">
		        <!-- map goes here -->
		    </div>

		    <!-- Map Navigation -->
			<a href="#" id="geoLocation" title="Your location"></a>
			<ul id="mapnav-buttons" class="top">
			    <li><a href="#" id="prevpoint" title="Previous point on map">Prev</a></li>
			    <li><a href="#" id="nextpoint" title="Next point on mp">Next</a></li>
			</ul>
		</div>

	</div>


	<div class="fs-inner-container">
		<div class="fs-content">

			<!-- Search -->
			<section class="search margin-bottom-30">

				<div class="row">
					<div class="col-md-12">

						<!-- Title -->
						<h4 class="search-title">Find Your Home</h4>
                           
						<form method="get" id="advance-search">
								<!-- Form -->
								<div class="main-search-box no-shadow">

									<!-- Row With Forms -->
									<div class="row with-forms">

										<!-- Main Search Input -->
										<div class="col-fs-6">
											<input type="text" placeholder="Enter address e.g. street, city or state" value="<?= (isset($_GET['address']) && !empty($_GET['address'])) ? $_GET['address'] : '' ?>" name="address"/>
										</div>

										<!-- Status -->
										<div class="col-fs-3">
											<select data-placeholder="Any Status" class="chosen-select-no-single" name="property_status" >
												<option value="">Any Status</option>	
												<option value="available" <?= (isset($_GET['property_status']) && !empty($_GET['property_status']) && $_GET['property_status'] == 'available') ? 'selected' : '' ?> >Available</option>
												<option value="rented" <?= (isset($_GET['property_status']) && !empty($_GET['property_status']) &&  $_GET['property_status'] == 'rented') ? 'selected' : '' ?> >Rented</option>
											</select>
										</div>

										<!-- Property Type -->
										<div class="col-fs-3">
											<select data-placeholder="Any Type" class="chosen-select-no-single" name="furnish-unfurnish-type" >
												<option value="">Any Type</option>	
												<option value="furnished" <?= (isset($_GET['furnish-unfurnish-type']) && !empty($_GET['furnish-unfurnish-type']) && $_GET['furnish-unfurnish-type'] == 'furnished') ? 'selected' : '' ?> >Furnished</option>
												<option value="unfurnished <?= (isset($_GET['furnish-unfurnish-type']) && !empty($_GET['furnish-unfurnish-type']) && $_GET['furnish-unfurnish-type'] == 'unfurnished') ? 'selected' : '' ?>">Unfurnished</option>
											</select>
										</div>

									</div>
									<!-- Row With Forms / End -->


									<!-- Row With Forms -->
									<div class="row with-forms">

										<div class="col-fs-3">
											<select data-placeholder="Any Status" class="chosen-select-no-single" name="property_type" >
												<option value="">Type of Accomodation</option>	
												<option value="apartment" <?= (isset($_GET['property_type']) && !empty($_GET['property_type']) && $_GET['property_type'] == 'apartment')? 'selected':'' ?>>Apartment</option>
												<option value="room" <?= (isset($_GET['property_type']) && !empty($_GET['property_type']) && $_GET['property_type'] == 'room')? 'selected':'' ?> >Room</option>
											</select>
										</div>
										<div class="col-fs-3">
											<select data-placeholder="Any Status" class="chosen-select-no-single" name="rooms" >
												<option value="">Rooms</option>	
												<option value="1"  <?= (isset($_GET['rooms']) && !empty($_GET['rooms']) && $_GET['rooms'] == '1')? 'selected':'' ?> >1</option>
												<option value="2" <?= (isset($_GET['rooms']) && !empty($_GET['rooms']) && $_GET['rooms'] == '2')? 'selected':'' ?>>2</option>
												<option value="3" <?= (isset($_GET['rooms']) && !empty($_GET['rooms']) && $_GET['rooms'] == '3')? 'selected':'' ?>>3</option>
												<option value="4" <?= (isset($_GET['rooms']) && !empty($_GET['rooms']) && $_GET['rooms'] == '4')? 'selected':'' ?>>4</option>
												<option value="5" <?= (isset($_GET['rooms']) && !empty($_GET['rooms']) && $_GET['rooms'] == '5')? 'selected':'' ?> >5</option>
												<option value="more than 5" <?= (isset($_GET['rooms']) && !empty($_GET['rooms']) && $_GET['rooms'] == 'more than 5')? 'selected':'' ?> >More than 5</option>
											</select>
										</div>
										<!-- Min Price -->
										<div class="col-fs-3">
											
											<!-- Select Input -->
											<div class="select-input disabled-first-option">
												<input type="text" placeholder="Min Price" data-unit="USD" name="min-price-input" value="<?=(isset($_GET['min-price-input']) && !empty($_GET['min-price-input']))? $_GET['min-price-input']:'' ?>">
												<select name="min-price">		
													<option value="">Min Price</option>
													<option value="1000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '1 000')? 'selected':'' ?> >1 000</option>
													<option value="2000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '2 000')? 'selected':'' ?> >2 000</option>	
													<option value="3000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '3 000')? 'selected':'' ?> >3 000</option>	
													<option value="4000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '4 000')? 'selected':'' ?> >4 000</option>	
													<option value="5000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '5 000')? 'selected':'' ?> >5 000</option>	
													<option value="10000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '10 000')? 'selected':'' ?> >10 000</option>	
													<option value="15000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '15 000')? 'selected':'' ?> >15 000</option>	
													<option value="20000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '20 000')? 'selected':'' ?> >20 000</option>	
													<option value="30000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '30 000')? 'selected':'' ?> >30 000</option>
													<option value="40000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '40 000')? 'selected':'' ?> >40 000</option>
													<option value="50000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '50 000')? 'selected':'' ?> >50 000</option>
													<option value="60000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '60 000')? 'selected':'' ?> >60 000</option>
													<option value="70000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '70 000')? 'selected':'' ?> >70 000</option>
													<option value="80000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '80 000')? 'selected':'' ?> >80 000</option>
													<option value="90000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '90 000')? 'selected':'' ?> >90 000</option>
													<option value="100000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '100 000')? 'selected':'' ?> >100 000</option>
													<option value="110000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '110 000')? 'selected':'' ?> >110 000</option>
													<option value="120000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '120 000')? 'selected':'' ?> >120 000</option>
													<option value="130000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '130 000')? 'selected':'' ?> >130 000</option>
													<option value="140000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '140 000')? 'selected':'' ?> >140 000</option>
													<option value="150000" <?= (isset($_GET['min-price-input']) && !empty($_GET['min-price-input']) && $_GET['min-price-input'] == '150 000')? 'selected':'' ?> >150 000</option>
												</select>
											</div>
											<!-- Select Input / End -->

										</div>


										<!-- Max Price -->
										<div class="col-fs-3">
											
											<!-- Select Input -->
											<div class="select-input disabled-first-option">
												<input type="text" placeholder="Max Price" data-unit="USD" name="max-price-input" value="<?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input'])) ? $_GET['max-price-input']:'' ?>" >
												<select name="max-price">		
													<option value="">Max Price</option>
													<option value="1000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '1 000')? 'selected':'' ?> >1 000</option>
													<option value="2000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '2 000')? 'selected':'' ?> >2 000</option>	
													<option value="3000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '3 000')? 'selected':'' ?> >3 000</option>	
													<option value="4000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '4 000')? 'selected':'' ?> >4 000</option>	
													<option value="5000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '5 000')? 'selected':'' ?> >5 000</option>	
													<option value="10000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '10 000')? 'selected':'' ?> >10 000</option>	
													<option value="15000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '15 000')? 'selected':'' ?> >15 000</option>	
													<option value="20000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '20 000')? 'selected':'' ?> >20 000</option>	
													<option value="30000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '30 000')? 'selected':'' ?> >30 000</option>
													<option value="40000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '40 000')? 'selected':'' ?> >40 000</option>
													<option value="50000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '50 000')? 'selected':'' ?> >50 000</option>
													<option value="60000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '60 000')? 'selected':'' ?> >60 000</option>
													<option value="70000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '70 000')? 'selected':'' ?> >70 000</option>
													<option value="80000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '80 000')? 'selected':'' ?> >80 000</option>
													<option value="90000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '90 000')? 'selected':'' ?> >90 000</option>
													<option value="100000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '100 000')? 'selected':'' ?> >100 000</option>
													<option value="110000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '110 000')? 'selected':'' ?> >110 000</option>
													<option value="120000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '120 000')? 'selected':'' ?> >120 000</option>
													<option value="130000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '130 000')? 'selected':'' ?> >130 000</option>
													<option value="140000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '140 000')? 'selected':'' ?> >140 000</option>
													<option value="150000" <?= (isset($_GET['max-price-input']) && !empty($_GET['max-price-input']) && $_GET['max-price-input'] == '150 000')? 'selected':'' ?> >150 000</option>
												</select>
											</div>
											<!-- Select Input / End -->

										</div>

									</div>
									<!-- Row With Forms / End -->


									

									<!-- More Search Options -->
									<a href="#" class="more-search-options-trigger margin-top-20" data-open-title="More Options" data-close-title="Less Options"></a>

									<div class="more-search-options relative">
										<div class="more-search-options-container margin-top-30">

											<!-- Row With Forms -->
											<div class="row with-forms">

												<!-- Age of Home -->
												<div class="col-fs-3">
													<select data-placeholder="Gender preference" class="chosen-select-no-single" name="gender" >
														<option label="blank"></option>	
														<option>Gender preference</option>	
														<option value="female" <?= (isset($_GET['gender']) && !empty($_GET['gender']) && $_GET['gender'] == 'female')? 'selected': '' ?>>Female</option>
														<option value="male" <?= (isset($_GET['gender']) && !empty($_GET['gender']) && $_GET['gender'] == 'male')? 'selected': '' ?>>Male</option>
														<option value="any" <?= (isset($_GET['gender']) && !empty($_GET['gender']) && $_GET['gender'] == 'other')? 'selected': '' ?> >Any</option>
													</select>
												</div>

												<!-- Rooms Area -->
												<div class="col-fs-3">
													<select data-placeholder="Preferred Language of Roommate" class="chosen-select-no-single" name="rm_lang">
														<option label="blank"></option>	
														<option value="English" <?= (isset($_GET['rm_lang']) && !empty($_GET['rm_lang']) && $_GET['rm_lang'] == 'English')? 'selected':'' ?>>English</option>
														<option value="Spanish" <?= (isset($_GET['rm_lang']) && !empty($_GET['rm_lang']) && $_GET['rm_lang'] == 'Spanish')? 'selected':'' ?>>Spanish</option>
														<option value="Any" <?= (isset($_GET['rm_lang']) && !empty($_GET['rm_lang']) && $_GET['rm_lang'] == 'Any')? 'selected':'' ?> >Any</option>
													</select>
												</div>

												<!-- Min Area -->
												<div class="col-fs-3">
													<select data-placeholder="Beds" class="chosen-select-no-single" name="Beds">
														<option label="blank"></option>	
														<option value="Any" <?= (isset($_GET['Beds']) && !empty($_GET['Beds']) && $_GET['Beds'] == 'Any')? 'selected':'' ?> >Beds (Any)</option>	
														<option value="1" <?= (isset($_GET['Beds']) && !empty($_GET['Beds']) && $_GET['Beds'] == '1')? 'selected':'' ?> >1</option>
														<option value="2" <?= (isset($_GET['Beds']) && !empty($_GET['Beds']) && $_GET['Beds'] == '2')? 'selected':'' ?> >2</option>
														<option value="3" <?= (isset($_GET['Beds']) && !empty($_GET['Beds']) && $_GET['Beds'] == '3')? 'selected':'' ?>>3</option>
														<option value="4" <?= (isset($_GET['Beds']) && !empty($_GET['Beds']) && $_GET['Beds'] == '4')? 'selected':'' ?>>4</option>
														<option value="5" <?= (isset($_GET['Beds']) && !empty($_GET['Beds']) && $_GET['Beds'] == '5')? 'selected':'' ?> >5</option>
													</select>
												</div>

												<!-- Max Area -->
												<div class="col-fs-3">
													<select data-placeholder="Baths" class="chosen-select-no-single" name="baths">
														<option label="blank"></option>	
														<option value="Any" <?= (isset($_GET['baths']) && !empty($_GET['baths']) && $_GET['baths'] == 'Any')? 'selected':'' ?>>Baths (Any)</option>	
														<option value="1" <?= (isset($_GET['baths']) && !empty($_GET['baths']) && $_GET['baths'] == '1')? 'selected':'' ?> >1</option>
														<option value="2" <?= (isset($_GET['baths']) && !empty($_GET['baths']) && $_GET['baths'] == '2')? 'selected':'' ?> >2</option>
														<option value="3" <?= (isset($_GET['baths']) && !empty($_GET['baths']) && $_GET['baths'] == '3')? 'selected':'' ?> >3</option>
														<option value="4" <?= (isset($_GET['baths']) && !empty($_GET['baths']) && $_GET['baths'] == '4')? 'selected':'' ?> >4</option>
														<option value="5" <?= (isset($_GET['baths']) && !empty($_GET['baths']) && $_GET['baths'] == '5')? 'selected':'' ?> >5</option>
													</select>
												</div>

											</div>
											<!-- Row With Forms / End -->


											<!-- Checkboxes -->
											<div class="checkboxes in-row">
										
												<input id="check-2" type="checkbox" name="amenities[]" value="Bed" <?= (isset($_GET['amenities']) && in_array('Bed',$_GET['amenities'])) ? 'checked' : ''?>>
												<label for="check-2">Bed</label>

												<input id="check-3" type="checkbox" name="amenities[]" value="Share Kitchen" <?= (isset($_GET['amenities']) && in_array('Share Kitchen',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-3">Share Kitchen</label>

												<input id="check-4" type="checkbox" name="amenities[]" value="Closet" <?= (isset($_GET['amenities']) && in_array('Closet',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-4">Closet</label>

												<input id="check-5" type="checkbox" name="amenities[]" value="Night Stand" <?= (isset($_GET['amenities']) && in_array('Night Stand',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-5">Night Stand</label>	

												<input id="check-6" type="checkbox" name="amenities[]" value="Dresser" <?= (isset($_GET['amenities']) && in_array('Dresser',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-6">Dresser</label>

												<input id="check-7" type="checkbox" name="amenities[]" value="Wi-fi" <?= (isset($_GET['amenities']) && in_array('Wi-fi',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-7">Wi-fi</label>

												<input id="check-8" type="checkbox" name="amenities[]" value="Cable" <?= (isset($_GET['amenities']) && in_array('Cable',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-8">Cable</label>
												
												<input id="check-9" type="checkbox" name="amenities[]" value="TV" <?= (isset($_GET['amenities']) && in_array('TV',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-9">TV</label>
												
												<input id="check-10" type="checkbox" name="amenities[]" value="Refrigerator"<?= (isset($_GET['amenities']) && in_array('Refrigerator',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-10">Refrigerator</label>
												
												<input id="check-11" type="checkbox" name="amenities[]" value="AC" <?= (isset($_GET['amenities']) && in_array('AC',$_GET['amenities'])) ? 'checked' : ''?> >
												<label for="check-11">AC</label>
												
										
											</div>
											<!-- Checkboxes / End -->

										</div>
										
									</div>
									<!-- More Search Options / End -->
									 <!-- Search Button -->
									<button class="button fs-map-btn" name="update_search" type="submit">Update</button>

								</div>
								<!-- Box / End -->
						</form>
					</div>
				</div>

			</section>
			<!-- Search / End -->

			<!-- Listings Container -->
			<div class="row fs-listings">

				<!-- Displaying -->
				<div class="col-md-12">
					<p class="showing-results"><?= $properties->post_count; ?> Results Found On Page <?php echo $paged ;?> of <?php echo $properties->max_num_pages ;?> </p>
				</div>

				<!-- Listing Item / End -->

				<!-- Listing Item -->
				<?php
				 if ( $properties->have_posts() ) { 

                 while ( $properties->have_posts() ) { 
                      $properties->the_post();
                    ?> 
                     <div class="col-lg-6 col-md-12">
					<div class="listing-item compact">
                  
						<a href="<?= get_post_permalink( get_the_ID()) ?>" class="listing-img-container">
							<div class="listing-badges">
								<span>For Rent</span>
							</div>

							<div class="listing-img-content">
								<span class="listing-compact-title"> <?= get_the_title() ?> <i> $<?= get_post_meta(get_the_ID(),'price',true) ?> / Weekly</i></span>

								<ul class="listing-hidden-content">
									<li>Rooms <span><?= get_post_meta(get_the_ID(),'rooms',true) ?></span></li>
									
								</ul>
							</div>
                             <?php
							    $galleryfiles =  get_post_meta(get_the_ID(),'gallery_files',true);
								if($galleryfiles){
								$galleryfiles = explode(',',$galleryfiles);
								    $attachment_id = get_post_meta(get_the_ID(),$galleryfiles[0],true);
									$imgsrc = wp_get_attachment_image_src( $attachment_id,array('300', '200'));
								               
									
									
									echo wp_get_attachment_image( $attachment_id, array('768', '512'), "", array( "class" => "img-responsive" ) );
								}
								
								//echo $latlong    =   get_lat_long(get_post_meta(get_the_ID(),'address',true));
								
							 ?>
						</a>
                         <input type="hidden" class="property_link" value="<?= home_url().'/single-property/?property_id='.get_the_ID() ?>">
						 <input type="hidden" class="property_price" value="<?= get_post_meta(get_the_ID(),'price',true) ?>">
						 <input type="hidden" class="property_image" value="<?= $imgsrc[0] ?>">
						 <input type="hidden" class="property_title" value="<?= get_the_title() ?>">
						 <input type="hidden" class="property_address" value="<?= get_post_meta(get_the_ID(),'address',true) ?>">
						<?php
						 $propertyaddress = get_post_meta(get_the_ID(),'address',true);
						 $region = get_post_meta(get_the_ID(),'state',true);
						 $longlat = get_lat_long($propertyaddress,$region);
						 $longitude  =   $longlat['longitude'];
						 $latitude   =   $longlat['latitude'];
						?>
						<input type="hidden" class="property_longitude" value="<?= $longitude ?>">
						<input type="hidden" class="property_latitude" value="<?= $latitude ?>">
					</div>
				</div>
				

                 <?php  } 

               } else { ?>

                      <li><h3>No Property Found</h3></li>

        <?php } ?> 

                <?php 
				wp_reset_query();
                 ?> 

				
				
				<!-- Listing Item / End -->

			</div>
			<!-- Listings Container / End -->


			<!-- Pagination Container -->
			<div class="row fs-listings">
				<div class="col-md-12">

					<!-- Pagination -->
					<div class="clearfix"></div>
					<div class="pagination-container margin-top-10 margin-bottom-45">
						<nav class="pagination">
							<?php 
									echo paginate_links( array(
											'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
											'total'        => $properties->max_num_pages,
											'current'      => max( 1, get_query_var( 'paged' ) ),
											'format'       => '?paged=%#%',
											'show_all'     => false,
											'type'         => 'list',
											'end_size'     => 2,
											'mid_size'     => 1,
											'prev_next'    => false,
											'add_args'     => false,
											'add_fragment' => '',
										) );
                              ?>
						</nav>

						<nav class="pagination-next-prev">
							<ul>
								<li class="prev"><!--a href="#" class="prev">Previous</a--> <?php previous_posts_link( 'Previous',$properties->max_num_pages ); ?> </li>
								<li class="next"><!--a href="#" class="next">Next</a--> <?php next_posts_link( 'Next', $properties->max_num_pages);  ?> </li>
							</ul>
						</nav>
					</div>

				</div>
			</div>
			<!-- Pagination Container / End -->

		</div>
	</div>

</div>
</div>
<style>
.pagination-next-prev ul li.prev a {
    left: 0;
    position: absolute;
    top: 0;
}
.pagination-next-prev ul li.next a {
    right: 0;
    position: absolute;
    top: 0;
}

.pagination ul span.page-numbers.current {
    background: #274abb;
    color: #fff;
    padding: 8px 0;
    width: 42px;
    display: inline-block;
    border-radius: 3px;
}
#wrapper {
    width: 100%;
}
.tg-container.search_prop_tnt {
    max-width: 100% !important;
	display: block;
}
</style>
<?php
get_footer();
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkB8x8TIEGgMQIeZjIEJILbKOn_5uEP8I"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/infobox.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/markerclusterer.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/maps.js"></script>
<script>
 jQuery(document).ready(function(){
 jQuery('.page-id-74 .site-content .tg-container.tg-container--flex.tg-container--flex-space-between').addClass('search_prop_tnt');
 });
</script>