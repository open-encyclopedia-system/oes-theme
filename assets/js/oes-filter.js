$(document).ready(function () {

    /* Toggle sidebar ------------------------------------------------------------------------------------------------*/
    $('#oes-filter-panel-button').on('click', function () {
        $('#oes-sidebar-filter-panel').toggleClass('active');
        $('#oes-sidebar-filter-panel-content').toggleClass('active');
        $('#oes-filter-panel-button').toggleClass('active');
    });
    $('#oes-sidebar-filter-header-close').on('click', function () {
        $('#oes-sidebar-filter-panel').toggleClass('active');
        $('#oes-sidebar-filter-panel-content').toggleClass('active');
        $('#oes-filter-panel-button').toggleClass('active');
    });


    /* Alphabet filter -----------------------------------------------------------------------------------------------*/
    $(".oes-filter-abc").on("click", function (event) {

        var filter = this.dataset.filter,
            amount = 0,
            count = $(".oes-archive-count-number");

        if (filter === 'all') {
            oesClearAllFilter();
        } else {
            var filter_container = $(".filter-" + filter);

            /* hide all except filtered container */
            $(".oes-archive-wrapper").hide();
            filter_container.show();
            amount = filter_container.children('.oes-alphabet-container').children(':visible').length;

            /* update count */
            if(count[0]){
                count[0].innerText = amount + ' ';
                if (amount === 1) {
                    $(".oes-archive-count-label-singular").show();
                    $(".oes-archive-count-label-plural").hide();
                } else {
                    $(".oes-archive-count-label-singular").hide();
                    $(".oes-archive-count-label-plural").show();
                }
            }
        }


        /* update active filter */
        $(".oes-filter-abc").removeClass("active");
        this.classList.toggle("active");
    });
    
});


/* Facet filter ------------------------------------------------------------------------------------------------------*/
let current_post_ids = [];
function oesFilterProcessing(filter, type){

    /* add filter to active list */
    const sidebar_filter = $(".oes-archive-filter-" + type + "-" + filter),
    name = sidebar_filter[0].childNodes[0].data;
    $(".oes-active-filter-" + type).append('<li><a class="oes-active-filter-item oes-active-filter-item-' + type +
        ' oes-active-filter-item-' + filter +
        '" href="javascript:void(0)" data-filter="' + filter + '"' +
        'onClick=oesRemoveActiveFilter(\'' + filter + '\',\'' + type + '\')><span>' +
        name + '</span></a></li>');

    /* prepare matching array (perform "OR" operation) */
    if (!current_post_ids[type]) {
        current_post_ids[type] = oes_filter[type][filter];
    } else {
        current_post_ids[type] = current_post_ids[type].concat(oes_filter[type][filter]);
    }

    /* hide item from selection list */
    sidebar_filter.parent().toggleClass("active");

    /* get result list */
    oesFilterResultList();
}


/* add remove action: remove item from active filter in html and global variable, add to filter in sidebar */
function oesRemoveActiveFilter(filter_inner, type_inner){

    /* remove active filter item */
    const active_filter_item = $(".oes-active-filter-item-" + filter_inner);
    active_filter_item.parent().remove();

    /* show in sidebar */
    $(".oes-archive-filter-" + type_inner + "-" + filter_inner).parent().toggleClass("active");

    /* remove data from current post_ids */
    if (current_post_ids.hasOwnProperty(type_inner)) {

        /* redo current post ids for this type :( (no easier way...? TODO @nextRelease ) */
        let update_post_ids = [];
        const active_filter = $(".oes-active-filter-item-" + type_inner);

        for (let filter_item of active_filter){
            let update_post_ids_temp = update_post_ids,
            filter_id = filter_item.dataset.filter;
            update_post_ids = update_post_ids_temp.concat(oes_filter[type_inner][filter_id]);
        }

        if (update_post_ids.length !== 0) {
            current_post_ids[type_inner] = update_post_ids;
        } else {
            delete current_post_ids[type_inner];
        }
    }

    oesFilterResultList();
}

/* clear all filter (alphabet and facet filter) */
function oesClearAllFilter(){

    var items = $(".oes-post-filter-wrapper"),
        alphabet_wrapper = $(".oes-archive-wrapper"),
        count_container = $(".oes-active-filter-container"),
        count = $(".oes-archive-count-number"),
        amount = 0,
        item_counts = $(".oes-filter-item-count");

    /* reset ids */
    current_post_ids = [];

    /* show all items */
    items.show();
    item_counts.show();
    alphabet_wrapper.show();
    amount = items.length;
    count_container.hide();

    /* update count */
    if(count[0]) count[0].innerText = amount + ' ';

    if(amount === 0) $(".oes-archive-container-no-entries").show();
    else $(".oes-archive-container-no-entries").hide();

    if (amount === 1) {
        $(".oes-archive-count-label-singular").show();
        $(".oes-archive-count-label-plural").hide();
    } else {
        $(".oes-archive-count-label-singular").hide();
        $(".oes-archive-count-label-plural").show();
    }
}

/* apply filter to result list */
function oesFilterResultList() {

    var items = $(".oes-post-filter-wrapper"),
        alphabet_wrapper = $(".oes-archive-wrapper"),
        count_container = $(".oes-active-filter-container"),
        count = $(".oes-archive-count-number"),
        amount = 0,
        item_counts = $(".oes-filter-item-count");

    /* show all if no filter active */
    if (Object.keys(current_post_ids).length === 0) {
        items.show();
        item_counts.show();
        alphabet_wrapper.show();
        amount = items.length;
        count_container.hide();
    } else {

        /* hide all counts TODO @nextRelease: figure out how to get counts with good performance */
        item_counts.hide();

        /* get results (perform "AND" operation) */
        let post_ids = [];
        if (Object.keys(current_post_ids).length === 1) {
            post_ids = current_post_ids[Object.keys(current_post_ids)[0]];
        } else if (Object.keys(current_post_ids).length !== 0) {

            /* get first element */
            let first_key = Object.keys(current_post_ids)[0],
                post_ids_temp = current_post_ids[first_key];

            /* skip first element and get intersection */
            for (let type in current_post_ids) {
                if (type !== first_key) {
                    post_ids = post_ids_temp.filter(value => current_post_ids[type].includes(value));
                }
            }
        }

        /* add active filter */
        count_container.show();

        /* hide all items */
        items.hide();
        alphabet_wrapper.hide();

        /* display filtered results */
        for (var k = 0; k < post_ids.length; k++) {
            var item = $(".oes-post-filter-" + post_ids[k]);
            item.show();
            item.parent().parent().show();
        }

        /* update count */
        amount = $(".oes-post-filter-wrapper:visible").length;
    }

    /* update count */
    count[0].innerText = amount + ' ';

    if(amount === 0) $(".oes-archive-container-no-entries").show();
    else $(".oes-archive-container-no-entries").hide();

    if (amount === 1) {
        $(".oes-archive-count-label-singular").show();
        $(".oes-archive-count-label-plural").hide();
    } else {
        $(".oes-archive-count-label-singular").hide();
        $(".oes-archive-count-label-plural").show();
    }
}


/* post type filter */
function oesFilterPostTypes(filter) {

    var amount = 0,
        count = $(".oes-archive-count-number"),
        results = $(".oes-post-type-filter");

    if (filter === 'all') {
        results.show();
        amount = results.length;
    } else {
        /* hide all except filtered container */
        results.hide();
        $(".oes-post-type-filter-" + filter).show();
        amount = $(".oes-post-type-filter:visible").length;
    }

    /* update count */
    count[0].innerText = amount + ' ';
    if (amount === 1) {
        $(".oes-archive-count-label-singular").show();
        $(".oes-archive-count-label-plural").hide();
    } else {
        $(".oes-archive-count-label-singular").hide();
        $(".oes-archive-count-label-plural").show();
    }

    /* update active filter */
    $(".oes-filter-post-type").removeClass("active");
    $(".oes-filter-post-type-" + filter).addClass("active");
}