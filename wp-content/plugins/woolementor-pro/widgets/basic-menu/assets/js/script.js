jQuery(function($){
	$('.woolementor-nav-menu').smartmenus();
	$('.woolementor-menu-toggle').click(function(e) {
		$(this).toggleClass('elementor-active');

		var width 		= $(window).width();
		var nav_width 	= $('.woolementor-basic-menu-wrapper').width();
		var left 		= nav_width - width;

		$('.wl .elementor-nav-menu--stretch .woolementor-nav-menu__container.woolementor-nav-menu--dropdown').css({
			width: width + 10,
			left: left,
		})
	});

	$(window).resize(function() {
        var width 		= $(window).width();
		var nav_width 	= $('.woolementor-basic-menu-wrapper').width();
		var left 		= nav_width - width;

		$('.wl .elementor-nav-menu--stretch .woolementor-nav-menu__container.woolementor-nav-menu--dropdown').css({
			width: width + 10,
			left: left,
		})
    }).resize();

	$('.woolementor-nav-menu--main .has-submenu .sub-arrow, .woolementor-nav-menu--dropdown .sub-arrow').html('<i class="fa"></i>');
	$('.woolementor-nav-menu--main .has-submenu').hover(function(){
		$(this).toggleClass('highlighted');
	})

	$('.woolementor-basic-menu-wrapper:not(.elementor-pro) .woolementor-nav-menu--dropdown .sub-arrow').click(function(e) {
		e.preventDefault();
		$(this).parent('.has-submenu').next('.sub-menu').slideToggle();
	});
})