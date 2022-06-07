jQuery(document).ready(function() {

    /* Smooth loading ------------------------------------------------------------------------------------------------*/
    jQuery('.oes-smooth-loading').addClass('oes-smooth-loading-loaded');


    /* Check for links of current page -------------------------------------------------------------------------------*/
    jQuery("[href]").each(function() {
        if (this.href === window.location.href) {
            jQuery(this).addClass("active");
        }
    });

    /* Back to top jump ----------------------------------------------------------------------------------------------*/
    jQuery("body").append('<a href="#top" class="oes-back-to-top"></a>');
    jQuery(".oes-back-to-top").hide();


    /* Open and close search panel -----------------------------------------------------------------------------------*/
    jQuery("#oes-search").on("click", function (event) {

        jQuery(this).toggleClass('active');
        jQuery("#oes-search-panel").toggle();

        const search_box = document.getElementById('s'),
            caret_post = 10;
        if(search_box){
            if (search_box.createTextRange) {
                const range = search_box.createTextRange();
                range.move('character', caret_post);
                range.select();
            } else {
                if (search_box.selectionStart) {
                    search_box.focus();
                    search_box.setSelectionRange(caret_post, caret_post);
                } else
                    search_box.focus();
            }
        }

    });

    jQuery("#oes-search-panel-close").on("click", function (event) {
        jQuery("#oes-search-panel").toggle();
    });


    /* Toggle sidebar ------------------------------------------------------------------------------------------------*/
    jQuery('#oes-filter-panel-button').on('click', function () {
        jQuery('#oes-sidebar-filter-panel').toggleClass('active');
        jQuery('#oes-sidebar-filter-panel-content').toggleClass('active');
        jQuery('#oes-filter-panel-button').toggleClass('active');
        jQuery('.oes-sidebar-filter-wrapper').toggleClass('active');
    });
    jQuery('#oes-sidebar-filter-header-close').on('click', function () {
        jQuery('#oes-sidebar-filter-panel').toggleClass('active');
        jQuery('#oes-sidebar-filter-panel-content').toggleClass('active');
        jQuery('#oes-filter-panel-button').toggleClass('active');
        jQuery('.oes-sidebar-filter-wrapper').toggleClass('active');
    });


    /* Archive: open and close archive data --------------------------------------------------------------------------*/
    jQuery(".oes-archive-plus").on("click", function (event) {
        this.classList.toggle("active");
    });

    jQuery(".oes-search-occurrences").on("click", function (event) {
        this.parentElement.parentElement.firstChild.firstChild.classList.toggle("active");
    });


    /* Archive: check for pre-filter from url after loading page -----------------------------------------------------*/
    if(typeof oes_filter !== 'undefined'){
        const urlSearchParams = new URLSearchParams(window.location.search),
            params = Object.fromEntries(urlSearchParams.entries());
        for (const k in params) {
            const values = params[k].split(',');
            for (let i = 0; i < values.length; i++) {
                let filterName = k;
                if(k.substr(0, 5) === 'oesf_') filterName = k.substr(5);
                if(oes_filter.hasOwnProperty(filterName)) oesApplyFilter(values[i], filterName);
            }
        }
    }


    /* Accordion -----------------------------------------------------------------------------------------------------*/
    jQuery(".oes-accordion").on("click", function (event) {
        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("active");
    });
});


/* On scroll function ------------------------------------------------------------------------------------------------*/
jQuery(window).scroll(function () {

    /* Load and shrink logo on top */
    const home_picture = jQuery(".oes-home-img");
    if(home_picture.length > 0){
        const img_src = home_picture[0].src;
        if(typeof img_src !== 'undefined'){
            if (jQuery(window).width() < 992) {
                if ((jQuery(window).scrollTop() > 0) && img_src.endsWith('logo.png'))
                    home_picture.attr("src", img_src.replace('logo.png', 'logo_small.png'));
                else if((jQuery(window).scrollTop() === 0) && img_src.endsWith('logo_small.png'))
                    home_picture.attr("src", img_src.replace('logo_small.png', 'logo.png'));
            } else {
                if ((jQuery(window).scrollTop() > 0) && img_src.endsWith('logo_large.png'))
                    home_picture.attr("src", img_src.replace('logo_large.png', 'logo.png')).height("40");
                else if((jQuery(window).scrollTop() === 0) && img_src.endsWith('logo.png'))
                    home_picture.attr("src", img_src.replace('logo.png', 'logo_large.png')).height("80");
            }
        }
    }

    /* jump icon */
    if (jQuery(this).scrollTop() > 65) jQuery('.oes-back-to-top').fadeIn();
    else jQuery('.oes-back-to-top').fadeOut();
});


/* Responsive --------------------------------------------------------------------------------------------------------*/
if(jQuery(window).width() < 992){

    jQuery('.oes-sidebar-filter-dropdowns').addClass('container');

    jQuery('<div class="oes-nav-responsive-submenu"></div>').appendTo('.menu-item-has-children').on("click", function () {
        this.classList.toggle("active");
        this.previousElementSibling.classList.toggle("active");
    });

    /* add search input to navigation */
    const search_input_el = jQuery('#s');
    if(search_input_el.length < 2){
        const getUrl = window.location;
        const baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

        const urlSearchParams = new URLSearchParams(window.location.search),
            params = Object.fromEntries(urlSearchParams.entries());
        let search_term = '';
        if('s' in params ) search_term = params['s'];

        jQuery('<li class="oes-search-form-responsive-li menu-item">' +
            '<form action="' + baseUrl + '" method="get" id="oes-search-form">' +
            '<label for="s"></label>' +
            '<input type="text" name="s" id="s" value="' + search_term + '" required>' +
            '<button type="submit"></button>' +
            '</form></li>').appendTo('#oes-main-nav ul.navbar-nav');
    }

    jQuery('.navbar-toggler-icon').on("click", function () {
        this.classList.toggle("active");
    });
}

jQuery(window).resize(function () {
    if(jQuery(window).width() < 992) jQuery('.oes-sidebar-filter-dropdowns').addClass('container');
    else jQuery('.oes-sidebar-filter-dropdowns').removeClass('container');
});