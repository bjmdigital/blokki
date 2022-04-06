import {
    InnerBlocks,
    useBlockProps,
    getColorClassName
} from '@wordpress/block-editor'


import classnames from 'classnames';

export default function Save({attributes}) {
    const blockProps = useBlockProps.save();

    const{
        textColor,
        customTextColor,
        backgroundColor,
        customBackgroundColor
    } = attributes;

    let divClass = [];
    let divStyles = {};

    if (textColor !== undefined) {
        divClass.push(getColorClassName('color', textColor));
    }
    if (backgroundColor !== undefined) {
        divClass.push(getColorClassName('background-color', backgroundColor));
    }

    if (customTextColor !== undefined) {
        divStyles.color = customTextColor;
    }
    if (customBackgroundColor !== undefined) {
        divStyles.backgroundColor = customBackgroundColor;
    }


    return (
        <div className={divClass.join(' ')} style={divStyles}>
            <InnerBlocks.Content/>
        </div>
    )
}
