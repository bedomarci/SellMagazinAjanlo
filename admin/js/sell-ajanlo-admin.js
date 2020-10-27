(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
	 *
	 * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
	 *
	 * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(window).load(function () {
        $('#recalculate-suggestion>button').on('click', function (e) {
            e.preventDefault();
            var postId = $(this).data('id');
            $('#recalculate-suggestion>.spinner').addClass('is-active');
            recalculateSuggestion(postId, function (response) {
                console.log(response);
                $('#recalculate-suggestion>.spinner').removeClass('is-active');
                });
        });

        $('.quick-recalculate-suggestion').on('click', function (e) {
            e.preventDefault();
            var span = $(this).children().first();
            var postId = $(this).data('id');

            span.text('...');
            recalculateSuggestion(postId, function (response) {
                span.text('');
            });
        });
    });


    function recalculateSuggestion(postId, success) {
        var data = {
            'action': 'recalculate_suggestion',
            'post_id': postId,
        };
        jQuery.post("/wp-admin/admin-ajax.php", data, success);
    }

    $(document).ready(function () {

    });


})(jQuery);

