<?php


namespace Blokki\Blocks;
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// if class already defined, bail out
if ( class_exists( 'Blokki\Blocks\Cards' ) ) {
	return;
}


/**
 * This class is for blokki/cards block
 *
 * @package    Blokki
 * @subpackage Blokki/blocks
 */
class Cards extends BaseBlock {

	public function __construct($block) {
		parent::__construct($block);

	}

	/**
	 * Render the Block
	 */
	public function render() {

		$loop = $this->get_posts_args();

		if ( $loop->have_posts() ) :
			while ( $loop->have_posts() ) :
				$loop->the_post();
				// Code Here
				the_title();
				blokki_get_template( 'card.php');
			endwhile;
		endif;


	}



}
