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

export function getSpacingClasses(attributes, className = '') {

    const cssClasses = [];

    const {
        paddingAll,
        paddingTop,
        paddingBottom,
        paddingLeft,
        paddingRight,
        marginAll,
        marginTop,
        marginBottom,
        marginLeft,
        marginRight
    } = attributes

    /**
     * Avoid duplication of classes as well
     */
    if (paddingAll && !className.includes('has-padding-all-' + paddingAll)) {
        cssClasses.push('has-padding-all-' + paddingAll)
    }
    if (paddingTop && !className.includes('has-padding-top-' + paddingTop)) {
        cssClasses.push('has-padding-top-' + paddingTop)
    }
    if (paddingBottom && !className.includes('has-padding-bottom-' + paddingBottom)) {
        cssClasses.push('has-padding-bottom-' + paddingBottom)
    }
    if (paddingLeft && !className.includes('has-padding-left-' + paddingLeft)) {
        cssClasses.push('has-padding-left-' + paddingLeft)
    }
    if (paddingRight && !className.includes('has-padding-right-' + paddingRight)) {
        cssClasses.push('has-padding-right-' + paddingRight)
    }
    if (marginAll && !className.includes('has-margin-all-' + marginAll)) {
        cssClasses.push('has-margin-all-' + marginAll)
    }
    if (marginTop && !className.includes('has-margin-top-' + marginTop)) {
        cssClasses.push('has-margin-top-' + marginTop)
    }
    if (marginBottom && !className.includes('has-margin-bottom-' + marginBottom)) {
        cssClasses.push('has-margin-bottom-' + marginBottom)
    }
    if (marginLeft && !className.includes('has-margin-left-' + marginLeft)) {
        cssClasses.push('has-margin-left-' + marginLeft)
    }
    if (marginRight && !className.includes('has-margin-right-' + marginRight)) {
        cssClasses.push('has-margin-right-' + marginRight)
    }

    return cssClasses;
}

export function getVisibilityClasses(attributes, className = '') {
    const cssClasses = [];

    const {
        hideOnLarge,
        hideOnMedium,
        hideOnSmall
    } = attributes

    if (hideOnLarge && !className.includes('blokki-hidden-large')) {
        cssClasses.push('blokki-hidden-large')
    }
    if (hideOnMedium && !className.includes('blokki-hidden-medium')) {
        cssClasses.push('blokki-hidden-medium')
    }
    if (hideOnSmall && !className.includes('blokki-hidden-small')) {
        cssClasses.push('blokki-hidden-small')
    }

    return cssClasses;
}