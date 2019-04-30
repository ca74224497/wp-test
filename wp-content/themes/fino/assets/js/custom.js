(function($) {
  "use strict";

  var $main_window = $(window);

  /*====================================
	preloader js
	======================================*/
  $main_window.on("load", function() {
    $("#preloader").fadeOut("slow");
  });

  
  /*====================================
		scroll to top js
	======================================*/
    $main_window.on("scroll", function() {
    if ($(this).scrollTop() > 250) {
      $("#finoScroll").fadeIn(200);
    } else {
      $("#finoScroll").fadeOut(200);
    }
  });
  $("#finoScroll").on("click", function() {
    $("html, body").animate(
      {
        scrollTop: 0
      },
      "slow"
    );
    return false;
  });


  /*=======================================
  affix  menu js
  ======================================= */

$main_window.on('scroll', function () {  
    var scroll = $main_window.scrollTop();
  if (scroll >= 200) {
      $(".menubar").addClass("sticky-menu");
  } else {
      $(".menubar").removeClass("sticky-menu");
  }
});
$main_window.on('scroll', function () {  
    var scroll = $main_window.scrollTop();
  if (scroll >= 200) {
      $(".fino-mobile-menu").addClass("sticky-menu");
  } else {
      $(".fino-mobile-menu").removeClass("sticky-menu");
  }
});


  /*====================================
	mobile menu js
	======================================*/

  $(".menu-wrap")
    .clone()
    .appendTo(".mobile-menu");

    var $mob_menu = $("#mobile-m");
    $(".close-menu").on("click", function() {
      $mob_menu.toggleClass("menu-show");
    });
 

  $(".menu-toggle").on("click", function() {
    $mob_menu.toggleClass("menu-show");
  });
  $(".mobile-menu .has-sub .menu-link, .mobile-menu .sub-menu-link").on("click", function(e) {
      e.preventDefault();
      $(this)
        .parent()
        .toggleClass("current");
      $(this)
        .next()
        .slideToggle();
    }
  );


    /*====================================
    main slider
    ======================================*/
    $('.main-slider').each(function () {
      var carousel = $(this),
          loop = carousel.data('loop'),
          items = carousel.data('items'),
          margin = carousel.data('margin'),
          stagePadding = carousel.data('stage-padding'),
          autoplay = carousel.data('autoplay'),
          autoplayTimeout = carousel.data('auto  play-timeout'),
          smartSpeed = carousel.data('smart-speed'),
          dots = carousel.data('dots'),
          nav = carousel.data('nav'),
          navSpeed = carousel.data('nav-speed'),
          rXsmall = carousel.data('r-x-small'),
          rXsmallNav = carousel.data('r-x-small-nav'),
          rXsmallDots = carousel.data('r-x-small-dots'),
          rXmedium = carousel.data('r-x-medium'),
          rXmediumNav = carousel.data('r-x-medium-nav'),
          rXmediumDots = carousel.data('r-x-medium-dots'),
          rSmall = carousel.data('r-small'),
          rSmallNav = carousel.data('r-small-nav'),
          rSmallDots = carousel.data('r-small-dots'),
          rMedium = carousel.data('r-medium'),
          rMediumNav = carousel.data('r-medium-nav'),
          rMediumDots = carousel.data('r-medium-dots'),
          rLarge = carousel.data('r-large'),
          rLargeNav = carousel.data('r-large-nav'),
          rLargeDots = carousel.data('r-large-dots'),
          center = carousel.data('center'),
          pauseonhover = carousel.data('pause-on-hover');

      carousel.owlCarousel({
          loop: (loop ? true : false),
          items: (items ? items : 1),
          lazyLoad: true,
          margin: (margin ? margin : 0),
          autoplay: (autoplay ? true : false),
          autoplayTimeout: (autoplayTimeout ? autoplayTimeout :4000),
          smartSpeed: (smartSpeed ? smartSpeed :600),
          dots: (dots ? true : false),
          nav: (nav ? true : false),
          navText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"],
          navSpeed: (navSpeed ? true : false),
          autoplayHoverPause:(pauseonhover ? true : false),
          center: (center ? true : false),
          responsiveClass: true,
          responsive: {
              0: {
                  items: (rXsmall ? rXsmall : 1),
                  nav: (rXsmallNav ? true : false),
                  dots: (rXsmallDots ? true : false)
              },
              480: {
                  items: (rXmedium ? rXmedium : 1),
                  nav: (rXmediumNav ? true : false),
                  dots: (rXmediumDots ? true : false)
              },
              768: {
                  items: (rSmall ? rSmall : 1),
                  nav: (rSmallNav ? true : false),
                  dots: (rSmallDots ? true : false)
              },
              992: {
                  items: (rMedium ? rMedium : 1),
                  nav: (rMediumNav ? true : false),
                  dots: (rMediumDots ? true : false)
              },
              1199: {
                  items: (rLarge ? rLarge : 1),
                  nav: (rLargeNav ? true : false),
                  dots: (rLargeDots ? true : false)
              }
          }
      });

  });


  /*====================================
		TEAM REDEINED TAB PANEL
	======================================*/
  if ($(".service-01").length > 0) {
    $(".service-wrap").on("click", function() {
      var tab_id = $(this).attr("data-tab");

      $(".service-wrap").removeClass("current");
      $(".panel-content").removeClass("current");

      $(this).addClass("current");
      $("#" + tab_id).addClass("current");
    });
  }

  /*====================================
		CASE STUDY TAB PANEL
    ======================================*/
  if ($(".case-study").length > 0) {
    $(".case-tab").on("click", function() {
      var tab_id = $(this).attr("data-tab");

      $(".case-tab").removeClass("active");
      $(".case-content").removeClass("active");

      $(this).addClass("active");
      $("#" + tab_id).addClass("active");
    });
  }

  
 /*====================================
		CASE STUDY FILTERING AND MASONARY / GRID
    ======================================*/
    /* activate jquery isotope */
    $main_window.on('load', function () {
      var $container = $('.case-study-items').isotope({
          itemSelector: '.case-item',
          masonry: {
              columnWidth: '.case-item'
          }
      });
  });
  // bind filter button click
  var filters = $('.sorting li');
  filters.on('click', function () {
      filters.removeClass('active');
      $(this).addClass('active');
      var filterValue = $(this).attr('data-filter');
      // use filterFn if matches value
      $('.case-study-items').isotope({
          filter: filterValue
      });
  });

  
  /*====================================
	  BLOG FILTERING AND MASONARY / GRID
  ======================================*/
  $('.blog-isotope').imagesLoaded(function () {
      var $blogisotope = $('.blog-isotope').isotope({
          itemSelector: '.blog-iso-item',
          percentPosition: true,
          masonry: {
              columnWidth: '.blog-iso-item'
          }
      });
  });


  /*=======================================
	    counter
    ======================================= */
  if ($(".count").length > 0) {
    $(".count").counterUp({
      delay: 10,
      time: 2000
    });
  }

  if ($(".progres").length > 0) {
    $("h5.prog-count").counterUp({
      delay: 15,
      time: 2000
    });
  }




  /*====================================
	attach file js
	======================================*/

  var inputs = document.querySelectorAll( '.attach' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
  });
  


})(jQuery);


    /*======================================
        Google map
    ====================================== */
    if (document.getElementById("fino-map")) {
      var myCenter = new google.maps.LatLng(-37.813628, 144.963058);
  
      function initialize() {
          var mapProp = {
              center: myCenter,
              scrollwheel: false,
              zoom: 13,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };
          var map = new google.maps.Map(document.getElementById("fino-map"), mapProp);
          var marker = new google.maps.Marker({
              position: myCenter,
              animation: google.maps.Animation.BOUNCE,
              icon: 'img/map-icon.png',
              map: map,
          });
          marker.setMap(map);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
  }
  // map initialization code  ends