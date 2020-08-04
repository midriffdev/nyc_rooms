<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package zakra
 */

?>

	<?php
	/**
	 * Hook - zakra_action_after_content.
	 *
	 * @hooked zakra_content_end - 10
	 * @hooked zakra_main_end - 15
	 */
	do_action( 'zakra_action_after_content' );
	?>

	<?php
	/**
	 * Hook - zakra_action_before_footer
	 *
	 * @hooked zakra_footer_start - 10
	 */
	do_action( 'zakra_action_before_footer' );
	?>

		<?php
		/**
		 * Hook - zakra_action_footer_widgets
		 *
		 * @hooked zakra_footer_widgets - 10
		 */
		do_action( 'zakra_action_footer_widgets' );
		?>

		<?php
		/**
		 * Hook - zakra_action_footer_bottom_bar
		 *
		 * @hooked zakra_footer_bottom_bar - 10
		 */
		do_action( 'zakra_action_footer_bottom_bar' );
		?>

	<?php
		/**
		 * Hook - zakra_action_after_footer
		 *
		 * @hooked zakra_footer_end - 10
		 * @hooked zakra_mobile_navigation - 15
		 * @hooked zakra_scroll_to_top - 20
		 */
		do_action( 'zakra_action_after_footer' );
	?>

<?php
/**
 * Hook - zakra_action_after
 *
 * @hooked zakra_page_end- 10
 */
do_action( 'zakra_action_after' );
?>
<div class="modal fade popup-main--section" id="bookappntmntpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bookappointment--popup" role="document">
    <div class="modal-content">
	 <form  method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="fillamount-popup">
        	<h3>Book an Appointment</h3>
 			
        	
        		<fieldset>
        		<ul>
        			<li>
        				<label for="name">Name*:</label>
		        		<input type="text" id="name" name="user_name" placeholder="Enter Name" required>
        			</li>
        			<li>
        				<label for="mail">Email*:</label>
		        		<input type="email" id="mail" name="user_email" placeholder="Enter Email" required>
        			</li>
        			<li>
        				<label for="tel">Contact Number*:</label>
		        		<input type="text" id="tel" placeholder="Enter Phone With +1.." name="user_num"  pattern="[+1]{2}[0-9]{10}"  oninvalid="setCustomValidity('Please Enter Valid No With Country Code +1.')" onchange="try{setCustomValidity('')}catch(e){}" maxlength="12" required>
        			</li>
        			<li>
        				<label for="date">Date*:</label>
        				<input type="date" name="date"  value="<?php echo date("Y-m-d"); ?>" required>
        			</li>
        			<li>
        				<label for="time">Time*:</label>
        				<input type="time" name="time" value="<?php echo date("H:i"); ?>" required>
        			</li>
        			<li>
        				<label for="appointment_description">Appointment Description*:</label>
        				<textarea id="appointment_description" name="appointment_description"  required ></textarea>
        			</li>
        		</ul>
		      </fieldset>
    		
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-secondary dealdetail-popupsub" name="book_appointment">Submit</button>
      </div>
	</form>
    </div>
  </div>
</div>
<div class="modal fade" id="successModal" role="dialog">
    <div class="modal-dialog"> 
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p> </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>   
    </div>
</div>
<div class="loading"></div>


<style>
<?php
 $currentuser = wp_get_current_user();
 if($currentuser->roles[0] == 'administrator'){
 ?>
.menu-item-object-page.menu-item-266{
     display:none;
}
.menu-item-object-page.menu-item-509{
   display:none;
}
<?php    
 }
 ?>
 <?php
 if($currentuser->roles[0] == 'property_owner'){
 ?>
 
.menu-item-object-page.menu-item-509{
     display:none;
}

.menu-item-object-page.menu-item-267{
     display:none;
}

<?php    
 }
 ?>
 
 <?php
 if($currentuser->roles[0] == 'tenant' ){
 ?>
 
.menu-item-object-page.menu-item-266{
     display:none;
}

.menu-item-object-page.menu-item-267{
     display:none;
}
<?php    
 }
 ?>
 
 
 
 
</style>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/jquery-migrate-3.1.0.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<?php wp_footer(); ?>
<!-- Scripts
================================================== -->
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/chosen.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/magnific-popup.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/rangeSlider.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/sticky-kit.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/slick.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/masonry.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/mmenu.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/tooltips.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/custom.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/main.js"></script>
<script type="text/javascript"  src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/moment.min.js"></script>
<script type="text/javascript"  src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/daterangepicker.js"></script>
</body>
</html>
