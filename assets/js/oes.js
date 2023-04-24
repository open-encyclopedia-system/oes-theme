jQuery(document).ready(function () {

    /* Smooth loading ------------------------------------------------------------------------------------------------*/
    jQuery('.oes-smooth-loading').addClass('oes-smooth-loading-loaded');


    /* Check for links of current page -------------------------------------------------------------------------------*/
    jQuery("[href]").each(function () {
        if (this.id !== 'oes-search' &&
            this.href === location.protocol + '//' + location.host + location.pathname) {
            jQuery(this).addClass("active");
            if(jQuery(this.parentElement).is('li')) jQuery(this.parentElement).addClass("active");
        }
    });

    /* Back to top jump ----------------------------------------------------------------------------------------------*/
    jQuery("body").append('<a href="#top" class="oes-back-to-top oes-icon"></a>');
    jQuery(".oes-back-to-top").hide();


    /* Add search text to input --------------------------------------------------------------------------------------*/
    const search_box = document.getElementById('s'),
        caret_post = 10;
    if (search_box) {
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

    /* Open and close search panel -----------------------------------------------------------------------------------*/
    const search_button = jQuery("#oes-search");
    if(search_button.length > 0){
        search_button[0].href = "javascript:void(0);";
        search_button.on("click", function (event) {
            jQuery(this).toggleClass('active');
            jQuery("#oes-search-panel").toggle();
        });
    }

    jQuery("#oes-search-panel-close").on("click", function (event) {
        jQuery("#oes-search-panel").toggle();
    });


    /* Archive: check for pre-filter from url after loading page -----------------------------------------------------*/
    oesPreFilterArchive();


    /* Resize columns ------------------------------------------------------------------------------------------------*/
    jQuery(".oes-resize-columns-6-6").on("click", function (event) {
        if(jQuery(this).attr('aria-expanded') === 'false') {
            jQuery('.oes-main-content').removeClass('col-lg-8').addClass('col-lg-6');
            jQuery('.oes-sidebar').removeClass('col-lg-4').addClass('col-lg-6');
        }
        else{
            jQuery('.oes-main-content').removeClass('col-lg-6').addClass('col-lg-8');
            jQuery('.oes-sidebar').removeClass('col-lg-6').addClass('col-lg-4');
        }
    });


    /* Accordion -----------------------------------------------------------------------------------------------------*/
    jQuery(".oes-accordion").on("click", function (event) {
        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("active");
    });
});


/* On scroll function ------------------------------------------------------------------------------------------------*/
jQuery(window).scroll(function () {
    /* jump icon */
    if (jQuery(window).width() > 991) {
        if (jQuery(this).scrollTop() > 65) {
            jQuery('.oes-back-to-top').fadeIn();
            jQuery('body').addClass('oes-scrolled');
            jQuery('.oes-show-on-shrink').show();
        } else {
            jQuery('.oes-back-to-top').fadeOut();
            jQuery('body').removeClass('oes-scrolled');
            jQuery('.oes-show-on-shrink').hide();
        }
    }
});


/* Responsive --------------------------------------------------------------------------------------------------------*/
if (jQuery(window).width() < 992) {

    jQuery('body').addClass('oes-scrolled');
    jQuery('.oes-show-on-shrink').show();

    /* swap navigation */
    const utility_nav = jQuery('#oes-utility-nav');
    if (utility_nav) jQuery('#oes-main-nav').insertBefore(utility_nav);

    /* sub menu navigation */
    jQuery('<div class="oes-nav-responsive-submenu"></div>').appendTo('.menu-item-has-children').on("click", function () {
        this.classList.toggle("active");
        this.previousElementSibling.classList.toggle("active");
    });

    /* sidebar toggle */
    jQuery('.oes-sidebar-with-toggle #oes-sidebar').addClass('collapse').remove('show');

    /* add search input to navigation */
    const search_input_el = jQuery('#s');
    if (search_input_el.length < 2) {
        const getUrl = window.location;
        const baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

        const urlSearchParams = new URLSearchParams(window.location.search),
            params = Object.fromEntries(urlSearchParams.entries());
        let search_term = '';
        if ('s' in params) search_term = params['s'];

        jQuery('<li class="oes-search-form-responsive-li menu-item">' +
            '<form action="' + baseUrl + '" method="get" id="oes-search-form">' +
            '<label for="s"></label>' +
            '<input type="text" name="s" id="s" value="' + search_term + '" required>' +
            '<button type="submit"></button>' +
            '</form></li>').appendTo('#oes-main-nav ul.navbar-nav');
    }
}

function oesSetCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function oesGetCookie(name) {
    const name_eq = name + "=",
        cookies_array = document.cookie.split(';');
    for (let i = 0; i < cookies_array.length; i++) {
        let cookie = cookies_array[i];
        while (cookie.charAt(0) === ' ') cookie = cookie.substring(1, cookie.length);
        if (cookie.indexOf(name_eq) === 0) return cookie.substring(name_eq.length, cookie.length);
    }
    return null;
}

function oesDeleteCookie(name) {
    document.cookie = name + '=; max-age=0;';
}

function oesSortTable(n, ascending = true) {

    /* get table and sortable rows */
    const table = jQuery('table.oes-sortable-table');

    if(table.length > 0) {

        const rows = jQuery('tr.oes-table-archive-item'),
            toggle = jQuery('#oes-table-toggle-' + n),
            toggle_up = jQuery('#oes-table-toggle-' + n + '-up');

        /* prepare sorting array */
        let x, y = 0;
        let sorted_rows = [];
        for (let i = 0; i < rows.length; i++) {
            x = rows[i];
            if (i + 1 in rows) y = rows[i + 1].previousElementSibling;
            else y = x.parentElement.lastChild;
            const obj = {
                sort: x.getElementsByTagName("TD")[n].textContent.toLowerCase(),
                range: document.createRange()
            };
            obj.range.setStartBefore(x);
            obj.range.setEndAfter(y);
            sorted_rows.push(obj);
        }

        /* sort rows */
        if(ascending === true) {

            /* check if already sorted */
            if (toggle.hasClass('oes-toggle-active') || toggle_up.hasClass('oes-toggle-active')) {
                const compare1 = rows[0].getElementsByTagName("TD")[n].textContent.toLowerCase(),
                    compare2 = rows[rows.length - 1].getElementsByTagName("TD")[n].textContent.toLowerCase();
                if (compare1 < compare2) {
                    sorted_rows = sorted_rows.sort(oesSortArrDesc);
                    ascending = false;
                } else {
                    sorted_rows = sorted_rows.sort(oesSortArrAsc);
                }
            } else {
                sorted_rows = sorted_rows.sort(oesSortArrAsc);
            }
        }
        else {

            /* check if already sorted */
            if (toggle.hasClass('oes-toggle-active') || toggle_up.hasClass('oes-toggle-active')) {
                const compare1 = rows[0].getElementsByTagName("TD")[n].textContent.toLowerCase(),
                    compare2 = rows[rows.length - 1].getElementsByTagName("TD")[n].textContent.toLowerCase();
                if (compare1 < compare2) {
                    sorted_rows = sorted_rows.sort(oesSortArrAsc);
                } else {
                    sorted_rows = sorted_rows.sort(oesSortArrDesc);
                    ascending = false;
                }
            } else {
                sorted_rows = sorted_rows.sort(oesSortArrDesc);
                ascending = false;
            }
        }

        /* redo table */
        let sorted_table = document.createDocumentFragment();
        for (let i = 0; i < sorted_rows.length; i++) {
            x = sorted_rows[i];
            sorted_table.appendChild(x.range.extractContents());
        }
        table.append(jQuery(sorted_table));

        /* activate toggle */
        jQuery('.oes-sorting-toggle').removeClass('oes-toggle-active');
        if (ascending) toggle.addClass('oes-toggle-active');
        else toggle_up.addClass('oes-toggle-active');
    }
}

function oesSortArrAsc(a, b) {
    if (a.sort > b.sort) return 1;
    else if (a.sort < b.sort) return -1;
    else return 0;
}

function oesSortArrDesc(a, b) {
    if (a.sort < b.sort) return 1;
    else if (a.sort > b.sort) return -1;
    else return 0;
}