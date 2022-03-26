// noinspection JSUnusedLocalSymbols,JSUnresolvedVariable
(function ($) {
    'use strict';

    $(document).ready(function () {
        $('.accordions-grid .card-title').click(function (e) {

            let $this = $(this);

            if ($this.next().hasClass('show')) {
                $this.next().removeClass('show');
                $this.next().slideUp(350);
                $this.closest('.cell').removeClass('is-active')
            } else {
                $this.parent().find('.card-content').removeClass('show');
                $this.parent().find('.card-content').slideUp(350);
                $this.next().toggleClass('show');
                $this.next().slideToggle(350);
                $this.closest('.cell').addClass('is-active');
            }
        });
    });


})(jQuery);
