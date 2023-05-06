<?php


if ( ! function_exists( 'blokki_acf_get_block_classname' ) ) {

	/**
	 * Helper function to get css classes from ACF block
	 *
	 * @param $block
	 * @param $default_classname
	 *
	 * @return string
	 */
	function blokki_acf_get_block_classname( $block, $default_classname = '' ) {
		$classes = [];

		$classes[] = $default_classname;

		$classes[] = $block['className'] ?? '';

		if ( ! empty( $block['align'] ) ) {
			$classes[] = 'align' . $block['align'];
		}
		if ( ! empty( $block['align_text'] ) ) {
			$classes[] = 'has-text-align-' . $block['align_text'];
		}

		if ( ! empty( $block['align_content'] ) ) {
			$classes[] = 'align-' . $block['align_content'];
		}

		if ( ! empty( $block['textColor'] ) ) {
			$classes[] = 'has-text-color';
			$classes[] = 'has-' . $block['textColor'] . '-color';
		}

		if ( ! empty( $block['backgroundColor'] ) ) {
			$classes[] = 'has-background';
			$classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
		}

		/**
		 * Add blokki spacing classes
		 */
		$classes = blokki_acf_block_add_spacing_classes( $classes, $block );

		/**
		 * Add blokki visibility classes
		 */
		$classes = blokki_acf_block_add_visibility_classes( $classes, $block );

		/**
		 * Remove empty values
		 */
		$classes = array_filter( $classes );

		/**
		 * Sanitize css classes
		 */
		$classes = array_map( 'sanitize_html_class', $classes );

		$classes = apply_filters( 'blokki_acf_block_css_classes', $classes, $block );

		return implode( ' ', $classes );
	}
}
if ( ! function_exists( 'blokki_acf_block_add_spacing_classes' ) ) {

	/**
	 * Extract blokki related spacing classes from block attributes
	 * and add to classes array
	 *
	 * @param array $classes
	 * @param $block
	 *
	 * @return array
	 */
	function blokki_acf_block_add_spacing_classes( array $classes, $block ) {

		if ( ! is_array( $block ) ) {
			return $classes;
		}

		$spacing_attributes = [
			'paddingAll'    => null,
			'paddingTop'    => null,
			'paddingBottom' => null,
			'paddingLeft'   => null,
			'paddingRight'  => null,
			'marginAll'     => null,
			'marginTop'     => null,
			'marginBottom'  => null,
			'marginLeft'    => null,
			'marginRight'   => null
		];

		$spacing_classes_for_attributes = [
			'paddingAll'    => 'has-padding-all-',
			'paddingTop'    => 'has-padding-top-',
			'paddingBottom' => 'has-padding-bottom-',
			'paddingLeft'   => 'has-padding-left-',
			'paddingRight'  => 'has-padding-right-',
			'marginAll'     => 'has-margin-all-',
			'marginTop'     => 'has-margin-top-',
			'marginBottom'  => 'has-margin-bottom-',
			'marginLeft'    => 'has-margin-left-',
			'marginRight'   => 'has-margin-right-'
		];

		$block_spacing_attributes = array_intersect_key( $block, $spacing_attributes );

		if ( empty( $block_spacing_attributes ) ) {
			return $classes;
		} else {
			foreach ( $block_spacing_attributes as $attribute => $value ):
				if ( isset( $spacing_classes_for_attributes[ $attribute ] ) ) {
					$classes[] = $spacing_classes_for_attributes[ $attribute ] . $value;;
				}
			endforeach;
		}

		return $classes;

	}
}


if ( ! function_exists( 'blokki_acf_block_add_visibility_classes' ) ) {

	/**
	 * Extract blokki related visibility classes from block attributes
	 * and add to classes array
	 *
	 * @param array $classes
	 * @param $block
	 *
	 * @return array
	 */
	function blokki_acf_block_add_visibility_classes( array $classes, $block ) {

		if ( ! is_array( $block ) ) {
			return $classes;
		}


		$visibility_attributes = [
			'hideOnLarge'  => false,
			'hideOnMedium' => false,
			'hideOnSmall'  => false,
		];

		$visibility_classes_for_attributes = [
			'hideOnLarge'  => 'blokki-hidden-large',
			'hideOnMedium' => 'blokki-hidden-medium',
			'hideOnSmall'  => 'blokki-hidden-small'
		];

		$block_visibility_attributes = array_intersect_key( $block, $visibility_attributes );

		if ( empty( $block_visibility_attributes ) ) {
			return $classes;
		} else {
			foreach ( $block_visibility_attributes as $attribute => $value ):
				if (
					isset( $spacing_classes_for_attributes[ $attribute ] )
					&& $spacing_classes_for_attributes[ $attribute ]
				) {
					$classes[] = $visibility_classes_for_attributes[ $attribute ];
				}
			endforeach;
		}

		return $classes;

	}
}