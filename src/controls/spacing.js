import {__} from '@wordpress/i18n'
import {addFilter} from '@wordpress/hooks'
import {Fragment} from '@wordpress/element'
import {createHigherOrderComponent} from '@wordpress/compose'
import {InspectorControls} from '@wordpress/block-editor'
import {
    PanelBody,
    SelectControl,
    __experimentalGrid as Grid
} from '@wordpress/components'


import {getSpacingClasses} from "../helpers";

/**
 * Add options for visibility.
 */
addFilter("blocks.registerBlockType", "blokki/spacing", (props, name) => {
    const attributes = {
        ...props.attributes,
        paddingAll: {
            type: "string",
            default: ""
        },
        paddingTop: {
            type: "string",
            default: ""
        },
        paddingBottom: {
            type: "string",
            default: ""
        },
        paddingLeft: {
            type: "string",
            default: ""
        },
        paddingRight: {
            type: "string",
            default: ""
        },
        marginAll: {
            type: "string",
            default: ""
        },
        marginTop: {
            type: "string",
            default: ""
        },
        marginBottom: {
            type: "string",
            default: ""
        },
        marginLeft: {
            type: "string",
            default: ""
        },
        marginRight: {
            type: "string",
            default: ""
        }
    };

    return {...props, attributes};
});

/**
 * Add new visibility controls.
 */
addFilter("editor.BlockEdit", "blokki/spacing",
    createHigherOrderComponent((BlockEdit) => (props) => {
        const {
            attributes: {
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
            },
            setAttributes
        } = props;

        const spacingOptions = [
            {value: "", label: __("-", "blokki")},
            {value: "small", label: __("S", "blokki")},
            {value: "medium", label: __("M", "blokki")},
            {value: "large", label: __("L", "blokki")}
        ];

        return (
            <Fragment>
                <BlockEdit {...props} />
                <InspectorControls>
                    <PanelBody title={__("Spacing")} initialOpen={false}>
                        <h5>{__("Padding", "blokki")}</h5>
                        <SelectControl
                            label={__("All", "blokki")}
                            value={paddingAll}
                            options={spacingOptions}
                            onChange={paddingAll => setAttributes({paddingAll})}
                        />
                        <Grid columns={4}>
                            <SelectControl
                                label={__("Top", "blokki")}
                                value={paddingTop}
                                options={spacingOptions}
                                onChange={paddingTop => setAttributes({paddingTop})}
                            />
                            <SelectControl
                                label={__("Bottom", "blokki")}
                                value={paddingBottom}
                                options={spacingOptions}
                                onChange={paddingBottom => setAttributes({paddingBottom})}
                            />
                            <SelectControl
                                label={__("Left", "blokki")}
                                value={paddingLeft}
                                options={spacingOptions}
                                onChange={paddingLeft => setAttributes({paddingLeft})}
                            />
                            <SelectControl
                                label={__("Right", "blokki")}
                                value={paddingRight}
                                options={spacingOptions}
                                onChange={paddingRight => setAttributes({paddingRight})}
                            />
                        </Grid>
                        <h5>{__("Margin", "blokki")}</h5>
                        <SelectControl
                            label={__("All", "blokki")}
                            value={marginAll}
                            options={spacingOptions}
                            onChange={marginAll => setAttributes({marginAll})}
                        />
                        <Grid columns={4}>
                            <SelectControl
                                label={__("Top", "blokki")}
                                value={marginTop}
                                options={spacingOptions}
                                onChange={marginTop => setAttributes({marginTop})}
                            />
                            <SelectControl
                                label={__("Bottom", "blokki")}
                                value={marginBottom}
                                options={spacingOptions}
                                onChange={marginBottom => setAttributes({marginBottom})}
                            />
                            <SelectControl
                                label={__("Left", "blokki")}
                                value={marginLeft}
                                options={spacingOptions}
                                onChange={marginLeft => setAttributes({marginLeft})}
                            />
                            <SelectControl
                                label={__("Right", "blokki")}
                                value={marginRight}
                                options={spacingOptions}
                                onChange={marginRight => setAttributes({marginRight})}
                            />
                        </Grid>
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    })
);

/**
 * Add a new properties i.e. spacing classes to the props object.
 */
addFilter("blocks.getSaveContent.extraProps", "blokki/spacing", (props, block, attributes) => {

    const spacingClasses = getSpacingClasses(attributes, props.className);

    if (spacingClasses.length) {
        return Object.assign(props, {
            className: `${props.className} ${spacingClasses.join(' ')}`,
        });
    }

    return props;
});

/**
 * Add spacing classes to editor side as well.
 */
addFilter("editor.BlockListBlock", "blokki/spacing",
    createHigherOrderComponent((BlockListBlock) => (props) => {
        const spacingClasses = getSpacingClasses(props.attributes);

        if (spacingClasses.length) {
            return <BlockListBlock {...props} className={ spacingClasses.join(' ') }/>
        }

        return <BlockListBlock {...props} />
    })
);