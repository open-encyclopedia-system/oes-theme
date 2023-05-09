(function (jQuery) {

    window.SearchResults = {};


    /* print next link */
    SearchResults.printLink = function (element, postID) {
        if (postID) {
            jQuery(element).removeClass('disabled');
            jQuery(element).attr('href', '?p=' + postID);
        } else {
            jQuery(element).addClass('disabled');
        }
    };

    /* print the current result position */
    SearchResults.printCurrentResultPosition = function (element, position, results) {
        if (!isNaN(position) && position < results) {
            jQuery(element).children('.oes-result-navigation-position-first').html(position + 1);
            jQuery(element).children('.oes-result-navigation-position-last').html(results);
        }
    }

    /* print return to results link */
    SearchResults.printReturnToResultsLink = function (element) {
        const returnToSearchLink = localStorage.getItem('oesSearchResultsURL');
        if (returnToSearchLink) {
            jQuery(element).attr('href', returnToSearchLink);
        } else {
            jQuery(element).addClass('disabled');
        }
    };

})(jQuery);

jQuery(document).ready(function () {

    /* check for navigation element */
    const navigation = jQuery('.oes-result-navigation');

    if(navigation.length > 0){

        /* hide navigation per default*/
        navigation.hide();

        /* check if current post is part of last search result */
        const displayed_ids = localStorage.getItem("oesDisplayedIds");

        if(displayed_ids.length > 0){
            const results = JSON.parse(displayed_ids);
            const current_id = parseInt(oesPaging.current_id);
            let position = results.indexOf(current_id);

            /* show navigation or hide if not part of search results */
            if (!isNaN(position) && results.length > 0 && position > -1) {

                /* get next and previous post id */
                let next_id = false;
                let previous_id = false;
                if(results[position + 1] !== undefined) next_id = results[position + 1];
                if(position > 0) previous_id = results[position - 1];

                SearchResults.printLink('.oes-result-navigation-next', next_id);
                SearchResults.printCurrentResultPosition('.oes-result-navigation-position', position, results.length);
                SearchResults.printLink('.oes-result-navigation-previous', previous_id);
                SearchResults.printReturnToResultsLink('.oes-result-navigation-back');

                navigation.show();
            }
        }
    }


    /* check reset navigation */
    jQuery('.oes-reset-filter').on("click", function (event){
        localStorage.setItem('oesSelectedFilter', null);
    });
});
