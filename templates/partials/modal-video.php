<div class="modal micromodal-slide" id="modal-video" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-video-title">
            <header class="modal__header">
                <div class="modal__title" id="modal-video-title">
					<?php do_action( 'blokki_modal_video_title' ); ?>
                </div>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close>
					<?php echo apply_filters( 'blokki_modal_video_close_button_content', '<i class="fa fa-times"></i>' ); ?>
                </button>
            </header>
            <main class="modal__content" id="modal-video-content"></main>
            <footer class="modal__footer">
				<?php do_action( 'blokki_modal_video_footer' ); ?>
            </footer>
        </div>
    </div>
</div>
