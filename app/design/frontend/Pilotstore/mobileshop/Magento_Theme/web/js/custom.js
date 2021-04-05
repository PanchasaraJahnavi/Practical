require([
    'jquery',
    'owlcarousel'
], function($){
    $(document).ready(function() {
        $('.home-page-banner .owl-carousel ').owlCarousel({
            loop:false,
            nav:false,
            items:1,
            dots:true,
            autoplay:true,
            autoplayTimeout:3000
        })
    });
});