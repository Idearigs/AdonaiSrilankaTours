;(function( $ ){

/* Fixed header nav */
document.addEventListener("DOMContentLoaded", function(){
  var masthead = document.getElementById('masthead');
  if (!masthead) return;
  window.addEventListener('scroll', function() {
    var headerHeight = masthead.offsetHeight;
    if (window.scrollY > headerHeight) {
      masthead.classList.add('fixed-header');
    } else {
      masthead.classList.remove('fixed-header');
    }
  });
});

$( document ).ready(function() {
  /* header postion absolute to banner */
  $PositionheaderHeight = $( '#masthead' ).outerHeight();
  $('.home-banner').css( 'padding-top', $PositionheaderHeight );
  $('.inner-baner-container').css( 'padding-top', $PositionheaderHeight );
  
  /* Date picker */
  $( ".input-date-picker" ).datepicker();

  /* Count down */
  $('.counter').counterUp();

  // input increase and decrease js
  $('.minus-btn').click(function () {
    var $input = $(this).parent().find('input.quantity');
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
  });
  $('.plus-btn').click(function () {
    var $input = $(this).parent().find('input.quantity');
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
  });
});

/* Show or Hide Search field on clicking search icon */
$( document ).on( 'click', '.header-search-icon a', function(e){
	e.preventDefault();
	$( '.header-search-form' ).addClass( 'search-in' );
});

$( '.header-search-form, .search-close' ).click(function(e) {   
  e.preventDefault();
  if(!$(e.target).is( '.header-search-form input' )) {
      $( '.header-search-form' ).removeClass( 'search-in' );
  }
});

/* Mobile nav is now handled by custom inline script in the navbar */

/* Home Featured slider */
$('.home-banner-slider').slick({
  dots: true,
  infinite: true,
  autoplay: false,
  speed: 1200,
  fade: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  adaptiveHeight: false,
});

/* Home client slider */
$('.testimonial-slider').slick({
  dots: true,
  infinite: true,
  speed: 1000,
  prevArrow: false,
  nextArrow: false,
  slidesToShow: 3,
  autoplay: true,
  responsive: [{
    breakpoint: 768,
      settings: {
        slidesToShow: 2,
      }
    }, {
    breakpoint: 479,
      settings: {
        slidesToShow: 1,
      }
  }]
});

/* Home client slider */
$('.client-slider').slick({
  dots: false,
  infinite: true,
  speed: 1000,
  prevArrow: false,
  nextArrow: false,
  slidesToShow: 4,
  autoplay: true,
  responsive: [{
    breakpoint: 768,
      settings: {
        slidesToShow: 3,
      }
    }, {
    breakpoint: 479,
      settings: {
        slidesToShow: 2,
      }
  }]
});

/* Home client slider */
$('.related-package-slide').slick({
  dots: true,
  infinite: true,
  speed: 1000,
  prevArrow: false,
  nextArrow: false,
  slidesToShow: 2,
  autoplay: true,
});

/* Show or Hide topbar offcanvas on clicking topbar */
$( document ).on( 'click', '.offcanvas-menu a', function(e){
  e.preventDefault();
  $( '#offCanvas' ).addClass( 'offcanvas-show' );
});

$( '#offCanvas .overlay, .offcanvas-close' ).click(function(e) {   
  e.preventDefault();
  $( '#offCanvas' ).removeClass( 'offcanvas-show' );
});


$(window).scroll(function() {
  /* back to top */
  if ($(this).scrollTop() > 300) {
    $('#backTotop').fadeIn(200);
  } else {
    $('#backTotop').fadeOut(200);
  }
});
 /* back to top */
$("#backTotop").click(function(e) {
  e.preventDefault();
  $("html, body").animate({scrollTop: 0}, 100);
});

/* preloader */
$( window ).on( "load", function() {
  $( '#siteLoader' ).fadeOut( 500 );
  /* masonry */
  var $grid = $(".grid").imagesLoaded(function() {
    $grid.masonry({
      itemSelector: '.grid-item',
      percentPosition: true,
    });
  });
});


})( jQuery );