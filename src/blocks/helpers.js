/**
 * Get a usable value from the BlockVerticalAlignmentToolbar.
 */
export function mapAlignment(value) {
	const alignment = {
		'top': 'start',
		'center': 'center',
		'bottom': 'end'
	}

	return alignment[value]
}
