import MicroModal from 'micromodal';

// noinspection JSUnusedLocalSymbols,JSUnresolvedVariable
(function ($) {
    'use strict';

    /**
     * Handles accordion functionality.
     */
    const toggleAccordion = function () {
        const accordionButton = $(this);
        const accordionContent = $('#' + accordionButton.attr('aria-controls'));
        const toggleAria = (element, attribute) => {
            const newValue = element.attr(attribute) === 'true' ? 'false' : 'true';
            element.attr(attribute, newValue);
        };

        accordionContent.toggleClass('open').slideToggle(350);
        accordionButton.closest('.accordion-cell').toggleClass('is-active');
        toggleAria(accordionButton, 'aria-expanded');
        toggleAria(accordionContent, 'aria-hidden');
    };

    /**
     * Sets up the video modal with unified logic for Vimeo, YouTube, and other video types.
     */
    const setupVideoModal = function () {
        const modalID = 'modal-video';

        document.addEventListener('click', function (event) {
            const videoLink = event.target.closest('.link-type-lightboxvideo a');
            if (!videoLink) return;

            event.preventDefault();
            MicroModal.init();

            const href = videoLink.getAttribute('href');
            const modal = document.getElementById(modalID);
            const modalContent = modal.querySelector('.modal__content');
            let player;

            modalContent.innerHTML = '';

            // --- VIMEO LOGIC ---
            if (href.includes('vimeo.com')) {
                const vimeoId = href.split('/').pop();
                const videoContainerHtml = `
                    <div class="responsive-iframe">
                        <iframe id="video-player-iframe" src="https://player.vimeo.com/video/${vimeoId}?byline=0&portrait=0"
                                frameborder="0" allow="autoplay; fullscreen"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>`;
                modalContent.innerHTML = videoContainerHtml;

                const iframe = document.getElementById('video-player-iframe');
                player = new Vimeo.Player(iframe);
                
                player.ready().then(() => {
                    const isDesktop = !('ontouchstart' in window || navigator.maxTouchPoints > 0);
                    if (isDesktop) {
                        player.play();
                    } else {
                        // On mobile, wait for the user to tap play, then go fullscreen.
                        player.on('play', () => player.requestFullscreen());
                    }
                });

            // --- YOUTUBE LOGIC ---
            } else if (href.includes('youtube.com') || href.includes('youtu.be')) {
                const url = new URL(href);
                const youtubeId = url.searchParams.get('v') || url.pathname.split('/').pop();
                const videoContainerHtml = `
                    <div class="responsive-iframe">
                        <iframe id="video-player-iframe" src="https://www.youtube.com/embed/${youtubeId}?enablejsapi=1"
                                frameborder="0" allow="autoplay; fullscreen"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>`;
                modalContent.innerHTML = videoContainerHtml;

                window.onYouTubeIframeAPIReady = function() {
                    player = new YT.Player('video-player-iframe', {
                        events: {
                            'onReady': (event) => {
                                const isDesktop = !('ontouchstart' in window || navigator.maxTouchPoints > 0);
                                if (isDesktop) {
                                    event.target.playVideo();
                                }
                            },
                            'onStateChange': (event) => {
                                const isDesktop = !('ontouchstart' in window || navigator.maxTouchPoints > 0);
                                // When the video starts playing (state=1), go fullscreen on mobile.
                                if (!isDesktop && event.data === YT.PlayerState.PLAYING) {
                                    const iframe = event.target.getIframe();
                                    if (iframe.requestFullscreen) iframe.requestFullscreen();
                                }
                            }
                        }
                    });
                };
                if (window.YT && window.YT.Player) {
                    window.onYouTubeIframeAPIReady();
                }
            
            // --- DEFAULT FALLBACK ---
            } else {
                const videoHtml = `<video src="${href}" controls autoplay style="width:100%; height:auto;"></video>`;
                modalContent.innerHTML = videoHtml;
            }

            // This single block now handles showing the modal and closing it correctly for all cases.
            MicroModal.show(modalID, {
                onClose: (modal) => {
                    // Destroy the player if it exists to stop playback.
                    if (player && typeof player.destroy === 'function') {
                        player.destroy();
                    }
                    modal.querySelector('.modal__content').innerHTML = ''; // Always clear content
                }
            });
        });
    };

    /**
     * Handles screen orientation changes.
     */
    const handleFullscreenChange = () => {
        const isFullscreen = !!document.fullscreenElement;
        const canControlOrientation = screen.orientation && typeof screen.orientation.lock === 'function';

        if (isFullscreen && canControlOrientation) {
            screen.orientation.lock('landscape').catch(error => {
                console.warn("Could not lock screen to landscape:", error);
            });
        } else if (canControlOrientation) {
            screen.orientation.unlock();
        }
    };

    $(document).ready(function () {
        $(document).on('click', '.accordion-button', toggleAccordion);
        setupVideoModal();
        document.addEventListener('fullscreenchange', handleFullscreenChange);
    });

})(jQuery);