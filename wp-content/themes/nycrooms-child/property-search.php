<?php
/* Template Name: Property Search */
get_header();
?>
<div class="wrapper">
		<div class="tenant-questionary-cont">
			<div class="container">
				<div class="row">
					<div class="tenant-questionary-mainsec">
						<!-- multistep form -->
						<form action="<?= site_url() ?>/property-listing/" method="get" id="msform">
						  <!-- fieldsets -->
						  <fieldset>
							    <div class="teanent-question-wrapper">
							    	<div class="teanent-question--title">
							    		<h2 class="fs-title">What is your Gender?</h2>
							    	</div>
							    	<ul class="genDer-qestions">
							    		<li>
							    			<div class="teanent-question-innersec">
							    				<img src="<?= get_stylesheet_directory_uri() ?>/images/male-icon.png" alt="male">
									    		<input class="radio__select" type="radio" id="male" name="gender" value="male">
												<label for="male">Male</label>
									    	</div>


							    		</li>
							    		<li>
							    			<div class="teanent-question-innersec">
							    				<img src="<?= get_stylesheet_directory_uri() ?>/images/female-icon.png" alt="female">
								    			<input class="radio__select" type="radio" id="female" name="gender" value="female">
												<label for="female">Female</label>
											</div>
										</li>
							    		<li>
							    			<div class="teanent-question-innersec">
							    				<img src="<?= get_stylesheet_directory_uri() ?>/images/prefer-notanswer.png" alt="not-to-answer">
								    			<input class="radio__select" type="radio" id="other" name="gender" value="other">
												<label for="other">Prefer not to Answer</label>
											</div>
							    		</li>
							    	</ul>
							    </div>
							    <input type="button" name="next" class="next action-button" value="Next" />
						  </fieldset>
						  <fieldset>
						   		<div class="teanent-question-wrapper">
							    	<div class="teanent-question--title">
							    		<h2 class="fs-title">State</h2>
							    	</div>
							    	<ul class="state-qestions ">
							    		<li>
							    			<div class="teanent-question-innersec ">
							    				<select class="chosen-select-no-single" name="state">
													<option label="blank"></option>		
													<option value="new york" >New York</option>
													<option value="connecticut" >Connecticut</option>
													<option value="new jersey" >New Jersey</option>
												</select>
									    	</div>
							    		</li>
							    	</ul>
							    </div>
						    	<input type="button" name="previous" class="previous action-button" value="Previous" />
						    	<input type="button" name="next" class="next action-button" value="Next" />
						  </fieldset>
						  <fieldset class="cities_all">
							    <div class="teanent-question-wrapper">
							    	<div class="teanent-question--title">
							    		<h2 class="fs-title">What City would you like To Live in? </h2>
							    	</div>
							    	<ul class="city-u-live">
							    		<li>
							    			<div class="teanent-question-innersec">
									    		<input class="radio__select" type="radio" id="male" name="city_name" value="bronx">
												<label for="male">Bronx</label>
									    	</div>
							    		</li>
							    		<li>
							    			<div class="teanent-question-innersec">
								    			<input class="radio__select" type="radio" id="female" name="city_name" value="manhattan">
												<label for="female">Manhattan</label>
											</div>
										</li>
							    		<li>
							    			<div class="teanent-question-innersec">
								    			<input class="radio__select" type="radio" id="other" name="city_name" value="queens">
												<label for="other">Queens</label>
											</div>
							    		</li>
							    		<li>
							    			<div class="teanent-question-innersec">
								    			<input class="radio__select" type="radio" id="other" name="city_name" value="brooklyn">
												<label for="other">Brooklyn</label>
											</div>
							    		</li>
							    		<li>
							    			<div class="teanent-question-innersec">
								    			<input class="radio__select" type="radio" id="other" name="city_name" value="staten island">
												<label for="other">Staten Island</label>
											</div>
							    		</li>
							    		<li>
							    			<div class="teanent-question-innersec">
								    			<input class="radio__select" type="radio" id="other" name="city_name" value="westchester county">
												<label for="other">Westchester County</label>
											</div>
							    		</li>
							    		<li>
							    			<div class="teanent-question-innersec">
								    			<input class="radio__select" type="radio" id="other" name="city_name" value="long island">
												<label for="other">Long Island</label>
											</div>
							    		</li>
							    		<li>
							    			<div class="teanent-question-innersec">
								    			<input class="radio__select" type="radio" id="other" name="city_name" value="other">
												<label for="other">Other City</label>
												<input type="text" name="city_other" class="tenant-other-city">
											</div>
							    		</li>
							    	</ul>
							    </div>
							    <input type="button" name="previous" class="previous action-button" value="Previous" />
							    <input type="button" name="next" class="next action-button" value="Next" />
						  </fieldset>
						  <fieldset>
						   		<div class="teanent-question-wrapper">
							    	<div class="teanent-question--title">
							    		<h2 class="fs-title">Property Type</h2>
							    	</div>
							    	<ul class="room-apartment-qestions">
							    		<li>
							    			<div class="teanent-question-innersec">
							    				<img src="<?= get_stylesheet_directory_uri() ?>/images/room-icon.png" alt="male">
									    		<input class="radio__select" type="radio" id="male" name="property_type" value="room">
												<label for="male">Room</label>
									    	</div>
							    		</li>
							    		<li>
							    			<div class="teanent-question-innersec">
							    				<img src="<?= get_stylesheet_directory_uri() ?>/images/apartment-icon.png" alt="female">
								    			<input class="radio__select" type="radio" id="female" name="property_type" value="apartment">
												<label for="female">Apartment</label>
											</div>
										</li>
							    	</ul>
							    </div>
						    	<input type="button" name="previous" class="previous action-button" value="Previous" />
						    	<input type="button" name="next" class="next action-button" value="Next" />
						  </fieldset>
						  <fieldset>
						    <div class="teanent-question-wrapper">
							    	<div class="teanent-question--title">
							    		<h2 class="fs-title">How many people will living the property?</h2>
							    	</div>
							    	<ul class="state-qestions ">
							    		<li>
							    			<div class="teanent-question-innersec ">
							    				<select class="chosen-select-no-single" name="people_living_count"  >
													<option label="blank"></option>		
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="not sure">Not sure </option>
												</select>
									    	</div>
							    		</li>
							    	</ul>
							    </div>
						    <input type="button" name="previous" class="previous action-button" value="Previous" />
						    <input type="submit" name="submit" class="action-button" value="Submit" />
						  </fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<style>
.tenant-questionary-cont{
  height: 120vh;
}
.tg-container.search_prop_tnt {
    max-width: 100% !important;
	display: block;
}
</style>
<?php
get_footer();
?>
<script>
 jQuery(document).ready(function(){
 jQuery('.page-id-72 .site-content .tg-container.tg-container--flex.tg-container--flex-space-between').addClass('search_prop_tnt');
 });
 
 
 
</script>