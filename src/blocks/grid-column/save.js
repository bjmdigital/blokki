import {
    InnerBlocks,
    getColorClassName
} from '@wordpress/block-editor'

export default function Save({attributes}) {

    const {
        textColor,
        customTextColor,
        backgroundColor,
        customBackgroundColor,
        hasColumnLink,
        columnLinkURL,
        columnLinkTitle,
        columnLinkTarget,
    } = attributes;

    let divClasses = [];
    let divStyles = {};

    if (textColor !== undefined) {
        divClasses.push(getColorClassName('color', textColor));
    }
    if (backgroundColor !== undefined) {
        divClasses.push(getColorClassName('background-color', backgroundColor));
    }

    if (customTextColor !== undefined) {
        divStyles.color = customTextColor;
    }
    if (customBackgroundColor !== undefined) {
        divStyles.backgroundColor = customBackgroundColor;
    }
    if (hasColumnLink) {
        divClasses.push('has-column-link');
    }
    const linkMarkup = !hasColumnLink ? '' : (
        <a className={"blokki-grid-column-link"} title={columnLinkTitle} href={columnLinkURL}
           target={columnLinkTarget} rel={"noopener"}></a>
    );

    return (
        <div className={divClasses.join(' ')} style={divStyles}>
            {linkMarkup}
            <InnerBlocks.Content/>
        </div>
    )
}
