<?php
/*
Template Name: Admin Add Tenant
*/
nyc_property_admin_authority();
$errors = array();
$usererror = '';
$usersuccess = '';
if(isset($_POST['add_tenant'])){
       
           $phone = $_POST['phone'];
           $username = esc_sql($_POST['username']);
		   $email    = esc_sql($_POST['email']);
		   
  if( email_exists( $email ) ) {
        $errors['email'] ="Sorry!! Email Already Exists";
  }
 
  if ( strpos($username, ' ') !== false )
  {   
  
        $errors['username'] = "Sorry, no spaces allowed in usernames";
		
  } elseif( username_exists( $username ) ) 
  {  
  
        $errors['username'] = "Username already exists, please try another";  
		
  }  
  
    


   if(0 === count($errors)) {
      $userdata = array(
					'user_login'  => $_POST['username'],
					'user_pass'   =>  wp_generate_password(), // random password, you can also send a notification to new users, so they could set a password themselves
					'user_email' => $_POST['email'],
					'first_name' => $_POST['first_name'],
					'last_name' => $_POST['last_name'],
					'role'  => 'tenant'
				);
	   $user_id = wp_insert_user( $userdata );
	   
	   if( isset($_FILES['profilepicture']['name']) && !empty($_FILES['profilepicture']['name'])){
	         
			 nyc_property_profile_all_image_upload($_FILES,$user_id);
			 
	   }
	   
	    if($user_id){
		
		     update_user_meta($user_id,'first_name', $_POST['first_name'] );
			 update_user_meta($user_id,'last_name', $_POST['last_name'] );
			 update_user_meta($user_id,'user_full_name', $_POST['first_name'] .' '.$_POST['last_name']);
			 update_user_meta($user_id,'user_phone',$phone);
			 update_user_meta($user_id, 'user_personal_address',$_POST['address']);
			 update_user_meta($user_id,'user_email', $_POST['email']);
			 update_user_meta($user_id,'user_about', $_POST['about']);
			 update_user_meta($user_id,'user_twitter', $_POST['twitter']);
			 update_user_meta($user_id,'user_facebook', $_POST['facebook']);
			 update_user_meta($user_id,'user_googleplus', $_POST['googleplus']);
			 update_user_meta($user_id,'user_linkedin', $_POST['linkedin']); 
			 $usersuccess = "Tenant Added Successfully";	
			
	   }
	   
  
  }
  
}
get_header();
?>
<!-- Wrapper -->
<div id="wrapper" class="dashbaord__wrapper">

<!-- Titlebar
================================================== -->


<!-- Content
================================================== -->
<div class="container">
	<div class="row">
         <!-- Widget -->
		 <?php include(locate_template('sidebar/admin-sidebar.php')); ?>
		<div class="col-md-9">
			<div class="dashboard-main--cont">
               <p style="color:#274abb"><a href="<?= site_url().'/admin/' ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Dashboard</a></p>
			<div class="admin-teanent-account-details">
				<div class="row">
					<div class="col-md-12">
						<h4 class="margin-top-0 margin-bottom-30 admin-teanentdetail-title">Account Details</h4>
					</div>
				</div>
				<div class="row">
				        
						
				    <form method="post" enctype="multipart/form-data" id="add_tenant_form">
						<div class="col-md-6 my-profile">
							
							<div class="row">
								<div class="col-md-6">
									<label>First Name</label>
									<input  type="text" name="first_name" placeholder="First Name" required>
								</div>
								<div class="col-md-6">
									<label>Last Name</label>
									<input type="text" name="last_name" placeholder="Last Name" required>
								</div>
								
							</div>
							
							
							<div class="row">
							   <div class="col-md-6">
									<label for="phone">Phone</label>
									<input type="text" name="phone" id="phone" class="phone" placeholder="Enter Phone With +1.." required pattern="[+1]{2}[0-9]{10}" maxlength=12>
								</div>
								<div class="col-md-6">
									<label for="username">Username</label>
									<input type="text" class="input-text" name="username" id="username" class="username" Placeholder="Username" required />
									<p><label class="form_errors"><?php if(!empty($errors['username'])){ echo $errors['username'];} ?></label></p>
								</div>
								<div class="col-md-12">
									<label for="email">Email</label>
									<input type="email" name="email" id="email" class="email" placeholder="Email" required>
									<p><label class="form_errors"><?php if(!empty($errors['email'])){ echo $errors['email'];} ?></label></p>
								</div>
							</div>
							

							<div class="row">
							    <div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">Address</h4>
									<textarea name="address" id="address" cols="30" rows="10" name="address" placeholder="Address"></textarea>
								</div>
								<div class="col-md-12">
									<h4 class="margin-top-50 margin-bottom-25">About Me</h4>
									<textarea name="about" id="about" cols="30" rows="10" placeholder="About"></textarea>
								</div>
							</div>
							
						</div>

						<div class="col-md-6 admin-teanent-right">

							<div class="row">
								<div class="col-md-12">
									<!-- Avatar -->
									<div class="edit-profile-photo">
										<img src="<?= get_stylesheet_directory_uri() ?>/images/male-icon.png" alt="">
										<div class="change-photo-btn">
											<div class="photoUpload">
												<span><i class="fa fa-upload"></i> Upload Photo</span>
												<input type="file" class="upload" name="profilepicture" id="imgupload">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="margin-top-50">Social</h4>
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-twitter"></i> Twitter</label>
									<input  type="text" placeholder="Twitter" name="twitter">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-facebook-square"></i> Facebook</label>
									<input type="text" placeholder="Facebook" name="facebook">
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-google-plus"></i> Google+</label>
									<input type="text" placeholder="Googleplus" name="googleplus" >
								</div>
								<div class="col-md-6">
									<label><i class="fa fa-linkedin"></i> Linkedin</label>
									<input type="text" placeholder="linkedin" name="linkedin">
								</div>
							</div>
							<button class="button margin-top-20 margin-bottom-20" type="submit" name="add_tenant">Save Changes</button>
						</div>
					</form>
				</div>
			</div>

			</div>
		</div>

	</div>
</div>

<div class="margin-top-55"></div>

<!-- Back To Top Button -->
<div id="backtotop"><a href="#"></a></div>

</div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>
		  <?php	
		    if(!empty($usersuccess)){
	          echo $usersuccess; 
			}
		    ?>
		  </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <style>
   label.form_errors {
    color: red;
	margin: 0;
   }
  </style>
<!-- Wrapper / End -->
<script>
jQuery(document).ready(function(){
 jQuery(document).on('change', '.upload', function(){
  var name = document.getElementById("imgupload").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  var error = false;
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
  {
   alert("Invalid Image File");
   error = true;
  }
  var oFReader = new FileReader();
	oFReader.onload = (function(imgupload){ //trigger function on successful read
	return function(e) {
		var img = jQuery('.edit-profile-photo img').attr('srcset', e.target.result); //create image element 
	};
	})(imgupload);
  oFReader.readAsDataURL(document.getElementById("imgupload").files[0]);
  });
  jQuery('#sidebar-profile').addClass('current');
});
</script>
<?php
get_footer();
if(!empty($usersuccess)){
   echo "<script>
         jQuery(window).load(function(){
             $('#myModal').modal('show');
         });
    </script>";
}
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/scripts/jquery.validate.min.js"></script>
<script>
jQuery(document).ready(function(){
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
jQuery('#add_tenant_form').validate({
rules: {
        phone:{
		  phoneUS: true,
		  minlength:12,
		},
		username: {
           remote: {
               url: ajaxurl,
               type: "post",
			   data: {
			      action : function(){
						return "nyc_check_user_name";
				  }
			   }
			   
           }
        },
        email: {
           remote: {
               url: ajaxurl,
               type: "post",
			   data: {
			      action : function(){
						return "nyc_check_user_email";
				  }
			   }
			   
           }
        }
    },
    messages: {
        email: {
            remote: "Email already in use!"
        },
		username: {
		   remote: "UserName Already Exists"
		}
    },
    submitHandler: function(form) {
       form.submit();
	   
   }
   
   
});

jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return this.optional(element) || phone_number.length > 9 && 
    phone_number.match(/^[+1]{2}[0-9]{10}$/);
}, "Please Enter Valid No With Country Code +1");


});
</script>