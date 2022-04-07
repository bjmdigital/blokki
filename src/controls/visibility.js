import {__} from '@wordpress/i18n'
import {addFilter} from '@wordpress/hooks'
import {Fragment} from '@wordpress/element'
import {createHigherOrderComponent} from '@wordpress/compose'
import {InspectorControls} from '@wordpress/block-editor'
import {PanelBody, ToggleControl} from '@wordpress/components'


import {getVisibilityClasses} from "../blocks/helpers";

/**
 * Add options for visibility.
 */
addFilter("blocks.registerBlockType", "blokki/visibility", (props, name) => {
    const attributes = {
        ...props.attributes,
        hideOnLarge: {
            type: "boolean",
            default: false
        },
        hideOnMedium: {
            type: "boolean",
            default: false
        },
        hideOnSmall: {
            type: "boolean",
            default: false
        }
    };

    return {...props, attributes};
});

/**
 * Add new visibility controls.
 */
addFilter("editor.BlockEdit", "blokki/visibility",
    createHigherOrderComponent((BlockEdit) => (props) => {
        const {
            attributes: {
                hideOnLarge,
                hideOnMedium,
                hideOnSmall
            },
            setAttributes
        } = props;

        return (
            <Fragment>
                <BlockEdit {...props} />
                <InspectorControls>
                    <PanelBody title={__("Visibility")} initialOpen={false}>
                        <ToggleControl
                            label={__("Hide on Large", "blokki")}
                            checked={hideOnLarge}
                            onChange={hideOnLarge => setAttributes({hideOnLarge})}
                        />
                        <ToggleControl
                            label={__("Hide on Medium", "blokki")}
                            checked={hideOnMedium}
                            onChange={hideOnMedium => setAttributes({hideOnMedium})}
                        />
                        <ToggleControl
                            label={__("Hide on Small", "blokki")}
                            checked={hideOnSmall}
                            onChange={hideOnSmall => setAttributes({hideOnSmall})}
                        />
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    })
);

/**
 * Add a new properties i.e. visibility classes to the props object.
 */
addFilter("blocks.getSaveContent.extraProps", "blokki/visibility", (props, block, attributes) => {

    const visibilityClasses = getVisibilityClasses(attributes, props.className);

    if (visibilityClasses.length) {
        return Object.assign(props, {
            className: `${props.className} ${visibilityClasses.join(' ')}`,
        });
    }

    return props;
});
