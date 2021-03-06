/*---------Query for listing submenu---------*/
jQuery( document ).ready(function() {
    $(".list-has--submenu > a").click(function(event){
		event.preventDefault();
	});
    $(".list-has--submenu ").click(function(){
		$(this).toggleClass("show--submenu");
	});
});
/*---------Query for listing submenu closed---------*/

/*---------Query for tenant question---------*/
jQuery(document).ready(function($){
	//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	var stateval = current_fs.find('select[name="state"]').val();
	if(typeof stateval == 'undefined'){
	   next_fs = $(this).parent().next();
	} else if(stateval != 'new york'){
	  next_fs = $(this).parent().next().next();
	} else if(stateval == 'new york') {
	   next_fs = $(this).parent().next();
	}
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			
			/* current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
			next_fs.css({'left': left, 'opacity': opacity}); */
			
			
			current_fs.css({
				'display': 'none',
				'position': 'relative'
            });
            next_fs.css({'opacity': opacity});

			
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs   = $(this).parent();
	var stateval = current_fs.prev().prev().find('select[name="state"]').val();
	  console.log(stateval);
	if(typeof stateval == 'undefined'){
	   previous_fs = current_fs.prev();
	} else if(stateval != 'new york'){
	   previous_fs = current_fs.prev().prev();
	} else if(stateval == 'new york') {
	   previous_fs = current_fs.prev();
	}
	
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			
			/* current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity}); */
			//previous_fs.css({'position':''});
			current_fs.css({
				'display': 'none',
				'position': 'relative'
				});
            previous_fs.css({'opacity': opacity});
			
			
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
})


  $(".teanent-question-innersec").click(function() {
        $(".teanent-question-innersec").removeClass("click_effect");
        $(this).toggleClass("click_effect");
    });
	
	

});
/*---------Query for tenant question closed---------*/


/*---------Query for display block none closed---------*/