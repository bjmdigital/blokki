import {__} from '@wordpress/i18n'
import {addFilter, applyFilters} from '@wordpress/hooks'
import {Fragment} from '@wordpress/element'
import {createHigherOrderComponent} from '@wordpress/compose'
import {InspectorControls} from '@wordpress/block-editor'
import {PanelBody, ToggleControl} from '@wordpress/components'


import {getBlockTypesForBlokkiControls, getVisibilityClasses, getBlokkiACFOptions} from "../helpers";

// Enable control on the following block types
let enableVisibilityControlOnBlockTypes = getBlockTypesForBlokkiControls();

enableVisibilityControlOnBlockTypes =
    applyFilters(
        'blokki_block_types_visibility_control', enableVisibilityControlOnBlockTypes
    );


let disableBlockControlVisibility = null;


/**
 * So that we call this API request to fetch options only once for a page load.
 * @returns {Promise<void>}
 */
async function initializeBlockControlValueSet() {
    disableBlockControlVisibility = await getBlokkiACFOptions(disableBlockControlVisibility, 'blokki_disable_block_control_visibility');
}

// Call the function to initialize spacing control
initializeBlockControlValueSet();

const shouldBlockHaveVisibilityControl = function (blockName) {

    if (disableBlockControlVisibility) {
        return false;
    }
    return enableVisibilityControlOnBlockTypes.find(element => {
        if (blockName && blockName.includes(element)) {
            return true;
        }
    });
}


/**
 * Add options for visibility.
 */
addFilter("blocks.registerBlockType", "blokki/visibility", (props, name) => {
    if (!shouldBlockHaveVisibilityControl(name)) {
        return props;
    }
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
        // Do nothing if it's another block type than our defined ones.
        if (!shouldBlockHaveVisibilityControl(props.name)) {
            return (
                <BlockEdit {...props} />
            );
        }

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


    if (!shouldBlockHaveVisibilityControl(block.name)) {
        return props;
    }

    const visibilityClasses = getVisibilityClasses(attributes, props.className);

    if (visibilityClasses.length) {
        return Object.assign(props, {
            className: `${props.className} ${visibilityClasses.join(' ')}`,
        });
    }

    return props;
});
