$(document).ready(function() {

    /* Smooth loading ------------------------------------------------------------------------------------------------*/
    $('.oes-smooth-loading').addClass('oes-smooth-loading-loaded');


    /* Check for links of current page -------------------------------------------------------------------------------*/
    $("[href]").each(function() {
        if (this.href === window.location.href) {
            $(this).addClass("active");
        }
    });

    /* Back to top jump ----------------------------------------------------------------------------------------------*/
    $("body").append('<a href="#top" class="oes-back-to-top"></a>');
    $(".oes-back-to-top").hide();


    /* Open and close search panel -----------------------------------------------------------------------------------*/
    $("#oes-search").on("click", function (event) {
        $("#oes-search-panel").toggle();
    });

    $("#oes-search-panel-close").on("click", function (event) {
        $("#oes-search-panel").toggle();
    });


    /* Archive: open and close archive data --------------------------------------------------------------------------*/
    $(".oes-archive-plus").on("click", function (event) {
        this.classList.toggle("active");
    });

    $(".oes-search-occurrences").on("click", function (event) {
        this.parentElement.parentElement.firstChild.firstChild.classList.toggle("active");
    });
});


/* On scroll function ------------------------------------------------------------------------------------------------*/
$(window).scroll(function () {

    /* Load and shrink logo on top */
    var home_picture = $(".oes-home-img"),
        img_src = home_picture[0].src;
    if ($(window).width() < 1000) {
        if (($(window).scrollTop() > 0) && img_src.endsWith('logo.png'))
            home_picture.attr("src", img_src.replace('logo.png', 'logo_small.png'));
        else if(($(window).scrollTop() === 0) && img_src.endsWith('logo_small.png'))
            home_picture.attr("src", img_src.replace('logo_small.png', 'logo.png'));
    } else {
        if (($(window).scrollTop() > 0) && img_src.endsWith('logo_large.png'))
            home_picture.attr("src", img_src.replace('logo_large.png', 'logo.png')).height("40");
        else if(($(window).scrollTop() === 0) && img_src.endsWith('logo.png'))
            home_picture.attr("src", img_src.replace('logo.png', 'logo_large.png')).height("80");
    }

    /* jump icon */
    if ($(this).scrollTop() > 65) $('.oes-back-to-top').fadeIn();
    else $('.oes-back-to-top').fadeOut();
});