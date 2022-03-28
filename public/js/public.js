// noinspection JSUnusedLocalSymbols,JSUnresolvedVariable
(function ($) {
    'use strict';

    // const setupAccordions = function (accordionsBlock) {
    //
    //     const accordionItems = $(accordionsBlock).find('.accordions-grid .cell');
    //
    //     if (accordionItems) {
    //
    //         $(accordionItems).each(function (i, accordionItem) {
    //
    //             let title = $(accordionItem).find('.title-container');
    //             let content = $(accordionItem).find('.content-container');
    //
    //             $(content).hide();
    //
    //             $(title).click(function (e) {
    //                 content.slideToggle(350);
    //                 $(accordionItem).toggleClass('is-active');
    //             });
    //         });
    //     }
    //
    //
    // }
    //

    $(document).ready(function () {

        // const accordionsBlock = $('.wp-block-acf-blokki-accordions');
        // if (accordionsBlock) {
        //     setupAccordions(accordionsBlock);
        // }

        var accordion_buttons = document.querySelectorAll('.accordion-button');

        [].forEach.call(accordion_buttons, function(accordion_button) {
            accordion_button.addEventListener('click', () => {

                accordion_button.classList.toggle('open');

                var content_id = accordion_button.getAttribute('aria-controls');
                var accordion_content = document.getElementById(content_id);

                accordion_content.classList.toggle('open');

                toggleARIA(accordion_button, 'aria-expanded');
                toggleARIA(accordion_content, 'aria-hidden');

            })
        })

        function toggleARIA(element, attribute_name) {
            var current_value = element.getAttribute(attribute_name);
            var new_value = current_value == 'true' ? 'false' : 'true';
            element.setAttribute(attribute_name, new_value);
        }


    });


})(jQuery);

