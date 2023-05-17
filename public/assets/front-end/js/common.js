// Header Fixed
jQuery(window).scroll(function() {
    if (jQuery(window).scrollTop() >= 100) {
        jQuery(".site-header").addClass("fixed-header");
    } else {
        jQuery(".site-header").removeClass("fixed-header");
    }
});



$(".head-toggle").click(function() {
    $(".header-toggle").toggleClass("show");
});

$('.mark-content input:radio').click(function () {
  $('.mark-content input:radio').parent().removeClass('checked');
  $(this).parent(this).addClass('checked');
  return false;
});


$("#ts-big-img").owlCarousel({
    navigation: true, 
    slideSpeed: 300,
    paginationSpeed: 400,
    singleItem: true,
    loop:true
});
$(".ts-small-img").owlCarousel({
    navigation: true, 
    slideSpeed: 300,
    paginationSpeed: 400,
    singleItem: true,
    loop:true
});

// Redirect Rules Tab
$(".rulebtn").click(function() {
    $(".ruletab").toggleClass("active");
});



