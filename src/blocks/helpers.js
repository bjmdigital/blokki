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

export function getSpacingClasses(attributes){
	const cssClasses = [];

	const{
		paddingTop,
		paddingBottom,
		paddingLeft,
		paddingRight,
		marginTop,
		marginBottom,
		marginLeft,
		marginRight
	} = attributes

	if (paddingTop) {
		cssClasses.push('has-padding-top-' + paddingTop)
	}
	if (paddingBottom) {
		cssClasses.push('has-padding-bottom-' + paddingBottom)
	}
	if (paddingLeft) {
		cssClasses.push('has-padding-left-' + paddingLeft)
	}
	if (paddingRight) {
		cssClasses.push('has-padding-right-' + paddingRight)
	}
	if (marginTop) {
		cssClasses.push('has-margin-top-' + marginTop)
	}
	if (marginBottom) {
		cssClasses.push('has-margin-bottom-' + marginBottom)
	}
	if (marginLeft) {
		cssClasses.push('has-margin-left-' + marginLeft)
	}
	if (marginRight) {
		cssClasses.push('has-margin-right-' + marginRight)
	}

	return cssClasses;
}

export function getVisibilityClasses(attributes){
	const cssClasses = [];

	const{
		hideOnLarge,
		hideOnMedium,
		hideOnSmall
	} = attributes

	if (hideOnLarge) {
		cssClasses.push('blokki-hidden-large')
	}
	if (hideOnMedium) {
		cssClasses.push('blokki-hidden-medium')
	}
	if (hideOnSmall) {
		cssClasses.push('blokki-hidden-small')
	}

	return cssClasses;
}