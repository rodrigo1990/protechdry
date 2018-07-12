	
$jQuery_3_2_1( "body" ).prepend( '<div id="preloader"><div class="spinner-sm spinner-sm-1" id="status"> </div></div>' );
$jQuery_3_2_1(window).on('load', function() { // makes sure the whole site is loaded 
  $jQuery_3_2_1('#status').fadeOut(); // will first fade out the loading animation 
$jQuery_3_2_1('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
 $jQuery_3_2_1('body').delay(350).css({'overflow':'visible'});
})