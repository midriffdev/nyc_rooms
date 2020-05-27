/*---------Query for listing submenu---------*/
$( document ).ready(function() {
    $(".list-has--submenu > a").click(function(){
    event.preventDefault();
  	$(".list--submenu").toggleClass("show--submenu");
	});
});