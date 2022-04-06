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

export function getPaddingClasses(attributes){
	const paddingClasses = [];

	const{
		paddingTop,
		paddingBottom,
		paddingLeft,
		paddingRight
	} = attributes

	if (paddingTop) {
		paddingClasses.push('has-padding-top-' + paddingTop)
	}
	if (paddingBottom) {
		paddingClasses.push('has-padding-bottom-' + paddingBottom)
	}
	if (paddingLeft) {
		paddingClasses.push('has-padding-left-' + paddingLeft)
	}
	if (paddingRight) {
		paddingClasses.push('has-padding-right-' + paddingRight)
	}

	return paddingClasses;
}