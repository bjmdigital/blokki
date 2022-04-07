import {
    TextControl,
    PanelBody,
    ToggleControl,
    SelectControl,
} from '@wordpress/components';

import {__} from '@wordpress/i18n';

import {
    InnerBlocks,
    InspectorControls,
    PanelColorSettings,
} from '@wordpress/block-editor'


export default function Edit(props) {

    const {
        attributes,
        setAttributes,
        textColor,
        backgroundColor,
        setTextColor,
        setBackgroundColor
    } = props;

    const {
        hasColumnLink,
        columnLinkURL,
        columnLinkTitle,
        columnLinkTarget,
    } = attributes;

    let divClasses = [];

    let divStyles = {};
    if (textColor !== undefined) {
        if (textColor.class !== undefined) {
            divClasses.push(textColor.class);
        } else {
            divStyles.color = textColor.color;
        }
    }

    if (backgroundColor !== undefined) {
        if (backgroundColor.class !== undefined) {
            divClasses.push(backgroundColor.class);
        } else {
            divStyles.backgroundColor = backgroundColor.color;
        }
    }

    return [
        <InspectorControls>
            <PanelColorSettings
                title={__('Color settings')}
                colorSettings={[
                    {
                        value: textColor.color,
                        onChange: setTextColor,
                        label: __('Text color')
                    },
                    {
                        value: backgroundColor.color,
                        onChange: setBackgroundColor,
                        label: __('Background color')
                    },
                ]}
            />
            <PanelBody title={__('Link Settings', 'blokki')}>
                <ToggleControl
                    label={__("Link Column ?", "blokki")}
                    checked={hasColumnLink}
                    onChange={hasColumnLink => setAttributes({hasColumnLink})}
                />
                {
                    hasColumnLink && [
                        <TextControl
                            label={__('Link URL', 'blokki')}
                            type={'url'}
                            value={columnLinkURL}
                            onChange={columnLinkURL => setAttributes({columnLinkURL})}
                        />,
                        <TextControl
                            label={__('Link Title', 'blokki')}
                            value={columnLinkTitle}
                            onChange={columnLinkTitle => setAttributes({columnLinkTitle})}
                        />,
                        <SelectControl
                            label={__("Link Target", "blokki")}
                            value={columnLinkTarget}
                            options={[
                                {value: "_self", label: __("_self", "blokki")},
                                {value: "_blank", label: __("_blank", "blokki")},
                                {value: "_top", label: __("_top", "blokki")},
                                {value: "_parent", label: __("_parent", "blokki")}
                            ]}
                            onChange={columnLinkTarget => setAttributes({columnLinkTarget})}
                        />
                    ]
                }

            </PanelBody>
        </InspectorControls>,
        <div className={divClasses.join(' ')} style={divStyles}>
            <InnerBlocks/>
        </div>
    ];
}
