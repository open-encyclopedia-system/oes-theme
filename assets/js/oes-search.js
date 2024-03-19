jQuery(document).ready(function () {
    const result_div = jQuery('#oes-search-results');
    if (result_div.length > 0) {
        oes_search_results['search_term_id'] = jQuery('#s').val();
        result_div.hide();
        jQuery.ajax({
            type: "POST",
            url: oesSearchAJAX.ajax_url,
            data: {
                action: 'oes_theme__fetch_search_result_data',
                nonce: oesSearchAJAX.ajax_nonce,
                search_params: oes_search_results
            },
            success: function (data) {
                jQuery('#oes-search-results').html(data).fadeIn();
                jQuery('.oes-loading-spinner-wrapper').fadeOut();
                oesFilter.updateCount();
            }
        });
    }
});
