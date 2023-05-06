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

    const modalOnClose = function (modal) {
        $(modal).find('.modal__content').html('');
    }

    const setupVideoModal = function () {

        MicroModal.init();

        const modalID = 'modal-video';
        const modal = $('#modal-video');

        $('.link-type-lightboxvideo a').on('click', function (e) {
            e.preventDefault();
            const href = $(this).attr('href');

            if (href.includes('vimeo.com')) {
                const vimeoId = href.split('/').pop();
                modal.find('.modal__content').append(`<div class="responsive-iframe"><iframe src="https://player.vimeo.com/video/${vimeoId}?autoplay=1&byline=0&portrait=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>`);
            } else if (href.includes('youtube.com')) {
                const youtubeId = href.split('watch?v=').pop();
                modal.find('.modal__content').append(`<div class="responsive-iframe"><iframe width="560" height="315" src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`);
            } else {
                modal.find('.modal__content').append(`<video src="${href}" controls></video>`);
                modal.find('video')[0].play();
            }

            MicroModal.show(modalID, {
                onClose: modalOnClose
            });
        });

    }

    $(document).ready(function () {
        /**
         * Accordions Button Click Function
         */
        $(document).on('click', '.accordion-button', toggleAccordion);

        /**
         * Video Modals Setup
         */
        setupVideoModal();

    });


})(jQuery);

