/**
 * Internal block libraries
 */
// const { __ } = wp.i18n;
// const { Component } = wp.element;

import {__} from '@wordpress/i18n';

import{
    Component
} from '@wordpress/element'

import {
    SelectControl,
    __experimentalGrid as Grid,
} from '@wordpress/components';

/**
 * Create an Inspector Controls wrapper Component
 */
export default class PaddingControl extends Component {


    constructor() {
        super(...arguments);
    }

    render() {

        const paddingOptions = [
            {value: "", label: __("-", "blokki")},
            {value: "small", label: __("S", "blokki")},
            {value: "medium", label: __("M", "blokki")},
            {value: "large", label: __("L", "blokki")}
        ];

        const {
            attributes: {
                paddingTop,
                paddingBottom,
                paddingLeft,
                paddingRight
            },
            setAttributes
        } = this.props;

        return (
            <Grid columns={4}>
                <SelectControl
                    label={__("Top", "blokki")}
                    value={paddingTop}
                    options={paddingOptions}
                    onChange={ paddingTop => setAttributes({paddingTop}) }
                />
                <SelectControl
                    label={__("Bottom", "blokki")}
                    value={paddingBottom}
                    options={paddingOptions}
                    onChange={paddingBottom => setAttributes({paddingBottom})}
                />
                <SelectControl
                    label={__("Left", "blokki")}
                    value={paddingLeft}
                    options={paddingOptions}
                    onChange={paddingLeft => setAttributes({paddingLeft})}
                />
                <SelectControl
                    label={__("Right", "blokki")}
                    value={paddingRight}
                    options={paddingOptions}
                    onChange={paddingRight => setAttributes({paddingRight})}
                />
            </Grid>
        );
    }
}
