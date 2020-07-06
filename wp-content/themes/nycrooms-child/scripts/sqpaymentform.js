// Set the application ID
var applicationId = "sandbox-sq0idb-RDFgUG9i1wn6qFCnAjIvoA";

// Set the location ID
var locationId = "6AJFCYM7H7Q1A";


function buildForm(form) {
  if (SqPaymentForm.isSupportedBrowser()) {
    form.build();
    form.recalculateSize();
  }
}
function buildForm1() {
    if (SqPaymentForm.isSupportedBrowser()) {
      var paymentDiv = document.getElementById("form-container");
      if (paymentDiv.style.display === "none") {
          paymentDiv.style.display = "block";
      }
      paymentform.build();
      paymentform.recalculateSize();
    } else {
      // Show a "Browser is not supported" message to your buyer
    }
  }
/*
 * function: requestCardNonce
 *
 * requestCardNonce is triggered when the "Pay with credit card" button is
 * clicked
 *
 * Modifying this function is not required, but can be customized if you
 * wish to take additional action when the form button is clicked.
 */
function requestCardNonce(event) {
  
  // Don't submit the form until SqPaymentForm returns with a nonce
  event.preventDefault();
  // Request a nonce from the SqPaymentForm object
  paymentForm.requestCardNonce();
}

// Create and initialize a payment form object
var paymentForm = new SqPaymentForm({

  // Initialize the payment form elements
  applicationId: applicationId,
  locationId: locationId,
  inputClass: 'sq-input',
  autoBuild: false,

  // Customize the CSS for SqPaymentForm iframe elements
  inputStyles: [{
    fontSize: '16px',
    fontFamily: 'Helvetica Neue',
    padding: '16px',
    color: '#373F4A',
    backgroundColor: 'transparent',
    lineHeight: '24px',
    placeholderColor: '#CCC',
    _webkitFontSmoothing: 'antialiased',
    _mozOsxFontSmoothing: 'grayscale'
  }],

  // Initialize Apple Pay placeholder ID
  applePay: false,

  // Initialize Masterpass placeholder ID
  masterpass: false,

  // Initialize the credit card placeholders
  cardNumber: {
    elementId: 'sq-card-number',
    placeholder: 'XXXX XXXX XXXX XXXX'
  },
  cvv: {
    elementId: 'sq-cvv',
    placeholder: 'CVV'
  },
  expirationDate: {
    elementId: 'sq-expiration-date',
    placeholder: 'MM/YY'
  },
  postalCode: {
    elementId: 'sq-postal-code',
    placeholder: '12345'
  },

  // SqPaymentForm callback functions
  callbacks: {
    /*
     * callback function: createPaymentRequest
     * Triggered when: a digital wallet payment button is clicked.
     * Replace the JSON object declaration with a function that creates
     * a JSON object with Digital Wallet payment details
     */
    createPaymentRequest: function () {
	   var amount = document.getElementById('amount').value;   
      return {
        requestShippingAddress: false,
        requestBillingInfo: true,
        currencyCode: "USD",
        countryCode: "US",
        total: {
          label: "MERCHANT NAME",
          amount: amount,
          pending: false
        },
        lineItems: [
          {
            label: "Subtotal",
            amount: amount,
            pending: false
          }
        ]
      }
    },

    /*
     * callback function: cardNonceResponseReceived
     * Triggered when: SqPaymentForm completes a card nonce request
     */
    cardNonceResponseReceived: function (errors, nonce, cardData) {
      if (errors) {
        // Log errors from nonce generation to the Javascript console
        console.log("Encountered errors:");
        errors.forEach(function (error) {
          console.log(' er= ' + error.message);
          alert(error.message);
        });

        return;
      }
	  
      // Assign the nonce value to the hidden form field
      document.getElementById('card-nonce').value = nonce;
	  var amountvalue             = document.getElementById('amount').value;
	  var deal_id                 =  document.getElementById('deal_id_square_tenant').value;
	  var email_teanant           =  document.getElementById('email_square_teanant').value;
	  var name_teanant           =  document.getElementById('name_square_teanant').value;
	  var phone_teanant           =  document.getElementById('phone_square_teanant').value;
	  
	  
	  jQuery('#Square_payment_form_js').modal('hide');
      jQuery('.loading').show();
		
	    jQuery.ajax({
		
					  type: 'post',
					  url: payment_ajax_object.ajax_url,
					  data: {action:'nyc_tenant_payment_square_ajax',amountvalue:amountvalue,nonce:nonce,deal_id:deal_id,email_teanant:email_teanant,name_teanant:name_teanant,phone_teanant:phone_teanant},
					  success: function(response){
							   if(response == "success"){
								jQuery('.loading').hide();
								jQuery('.square-payment-success-popup h3').html('Payment Successfully Done');
								jQuery('#square_payment_success_popup').modal('show');
									setTimeout(function(){
										 window.location.reload();
									}, 2000);
							   
					         } else {
							     jQuery('.loading').hide();
								 jQuery('.square-payment-success-popup h3').html('Something Went Wrong in Payment. Please try After sometime');
								 jQuery('#square_payment_success_popup').modal('show');
									setTimeout(function(){
										 window.location.reload();
									}, 2000);   								 
							 }
							 
					  }
					  
		 }); 
	  
 
      // POST the nonce form to the payment processing page
      //document.getElementById('nonce-form').submit();

    },

    /*
     * callback function: unsupportedBrowserDetected
     * Triggered when: the page loads and an unsupported browser is detected
     */
    unsupportedBrowserDetected: function () {
      /* PROVIDE FEEDBACK TO SITE VISITORS */
    },

    /*
     * callback function: inputEventReceived
     * Triggered when: visitors interact with SqPaymentForm iframe elements.
     */
    inputEventReceived: function (inputEvent) {
      switch (inputEvent.eventType) {
        case 'focusClassAdded':
          /* HANDLE AS DESIRED */
          break;
        case 'focusClassRemoved':
          /* HANDLE AS DESIRED */
          break;
        case 'errorClassAdded':
          document.getElementById("error").innerHTML = "Please fix card information errors before continuing.";
          break;
        case 'errorClassRemoved':
          /* HANDLE AS DESIRED */
          document.getElementById("error").style.display = "none";
          break;
        case 'cardBrandChanged':
          /* HANDLE AS DESIRED */
          break;
        case 'postalCodeChanged':
          /* HANDLE AS DESIRED */
          break;
      }
    },

    /*
     * callback function: paymentFormLoaded
     * Triggered when: SqPaymentForm is fully loaded
     */
    paymentFormLoaded: function () {
      /* HANDLE AS DESIRED */
      console.log("The form loaded!");
	  
    }
  }
});