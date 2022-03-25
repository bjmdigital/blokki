<?php
$card_heading      = get_field( 'heading' );
$add_view_all_link = get_field( 'add_view_all_link' );
$view_all_link     = get_field( 'view_all_link' );

$has_link = ( $add_view_all_link && $view_all_link );

if ( ! $card_heading && ! $has_link ) {
	return;
}
$block = $block ?? [];

/** Column 1 */
$col_1_classes   = [ 'cell', 'small-12', 'heading-col' ];
$col_1           = $has_link ? 8 : 12;
$col_1           = (int) apply_filters( 'blokki_partial_header_info_col_1', $col_1, $block );
$col_1_classes[] = 'medium-' . $col_1;


/** Column 2 */
$col_2_classes   = [ 'cell', 'small-12', 'link-col' ];
$col_2           = $card_heading ? 4 : 12;
$col_2           = (int) apply_filters( 'blokki_partial_header_info_col_2', $col_2, $block );
$col_2_classes[] = 'medium-' . $col_2;


$container_classes = [ 'grid-x', 'partial-header-info' ];
$link_classes      = [ 'info-link' ];


/**
 * Filters
 */
$col_1_classes     = apply_filters( 'blokki_partial_header_info_col_1_classes', $col_1_classes, $block );
$col_2_classes     = apply_filters( 'blokki_partial_header_info_col_2_classes', $col_2_classes, $block );
$container_classes = apply_filters( 'blokki_partial_header_info_container_classes', $container_classes, $block );
$link_classes      = apply_filters( 'blokki_partial_header_info_link_classes', $link_classes, $block );

printf( '<div class="%s">',
	implode( ' ', $container_classes )
);

if ( $card_heading ) :
	printf( '<div class="%s">
                            <h3 class="info-heading">%s</h3>
                        </div>',
		implode( ' ', $col_1_classes ),
		$card_heading
	);

endif;
if ( $add_view_all_link && $view_all_link ) :
	printf( '<div class="%s">
            <a href="%s" class="%s">%s</a>
        </div>',
		implode( ' ', $col_2_classes ),
		$view_all_link['url'],
		implode( ' ', $link_classes ),
		$view_all_link['title']
	);

endif;
printf( '</div>' ); //.partial-header-info


