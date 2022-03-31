<?php
$icon_open = sprintf( '<i class="fa %s" aria-hidden="true"></i>',
	get_field( 'accordion_icon_open', 'options' ) ?? 'fa-minus'
);

$icon_close = sprintf( '<i class="fa %s" aria-hidden="true"></i>',
	get_field( 'accordion_icon_close', 'options' ) ?? 'fa-plus'
);


printf( '<span class="accordion-icon">
		<span class="icon-open">%s</span>
		<span class="icon-close">%s</span>
		</span>',
	$icon_open,
	$icon_close
);