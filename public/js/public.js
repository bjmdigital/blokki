import MicroModal from 'micromodal';

// noinspection JSUnusedLocalSymbols,JSUnresolvedVariable
(function ($) {
    'use strict';

    const toggleAria = function (element, attribute) {
        const currentValue = element.attr(attribute);
        const newValue = currentValue === 'true' ? 'false' : 'true';
        element.attr(attribute, newValue);
    }

    const toggleAccordion = function (evt) {
        let accordionButton = $(this);
        let accordionContent = $('#' + accordionButton.attr('aria-controls'));

        // set Classes
        accordionContent.toggleClass('open').slideToggle(350);
        accordionButton.closest('.accordion-cell').toggleClass('is-active');

        // set Aria
        toggleAria(accordionButton, 'aria-expanded');
        toggleAria(accordionContent, 'aria-hidden');
    }

    const setupVideoModal = function(){

        console.log('setup Video Modal');

    }

    $(document).ready(function () {
        /**
         * Accordions Button Click Function
         */
        $('button').click('.accordion-button', toggleAccordion)
        setupVideoModal();

    });


})(jQuery);

