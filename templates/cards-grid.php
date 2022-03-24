<?php if (!empty($card_posts)) { ?>

	<?php
	$grid_classes = '';

	if (isset($card_args['display_as_accordions']) && $card_args['display_as_accordions']) {
		$grid_classes .= ' accordion-cards ';
	}

	if (isset($card_args['post_type']) && $card_args['post_type']) {
		$grid_classes .= ' cards-grid-' . implode(' cards-grid-', (array) $card_args['post_type']);
	}

	if (!empty($card_args['card_style'])){
		$grid_classes .= ' card-style-' . $card_args['card_style'];
	}

	if (!empty($card_args['show_next_previous'])){
		$grid_classes .= ' cards-selection-next-previous';
	}

	if (isset($card_args['max_number_cards']) && $card_args['max_number_cards']) {
		$grid_classes .= ' cards-max-' . $card_args['max_number_cards'];
	}

	$medium_up = 2;
	// echo $card_args['card_style'];
	if ($card_args['card_style'] == 'recent'){
		$medium_up = '';
	}

	?>

	<?php
//	include __DIR__ . '/cards-heading-link.php';
	?>

	<div class="cards-grid-x grid-x grid-margin-x grid-margin-y small-up-1 medium-up-<?php echo $medium_up; ?> large-up-<?php echo $card_args['cards_per_row']; ?> <?php if ($card_args['feature_first_card']) { ?> feature-first <?php } ?> <?php echo $grid_classes; ?>">

		<?php foreach ($card_posts as $post){ ?>

			<?php if ($card_args['group_children'] && $post->post_parent != 0) { ?>
				<?php continue; ?>
			<?php } ?>
			<?php setup_postdata( $post ); ?>
			<?php
			blokki_render_card();
			?>

		<?php } ?>

		<?php wp_reset_postdata(); ?>

	</div>
<?php }
