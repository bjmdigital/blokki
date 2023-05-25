import {assign} from 'lodash';
import apiFetch from '@wordpress/api-fetch';

import {createHigherOrderComponent} from '@wordpress/compose';
import {Fragment} from '@wordpress/element';
import {InspectorControls} from '@wordpress/block-editor';
import {PanelBody, PanelRow, SelectControl} from '@wordpress/components';
import {addFilter} from '@wordpress/hooks'
import {__} from '@wordpress/i18n'

import {getBlokkiACFOptions} from "../helpers";

/**
 * the flag to store the control value
 * @type {null}
 */
let disableBlockControlLightbox = null;

/**
 * So that we call this API request to fetch options only once for a page load.
 * @returns {Promise<void>}
 */
async function initializeBlockControlValueSet() {
    disableBlockControlLightbox = await getBlokkiACFOptions(disableBlockControlLightbox, 'blokki_disable_block_control_lightbox');
}

// Call the function to initialize spacing control
initializeBlockControlValueSet();

// Enable control on the following blocks
const enableControlOnBlocks = [
    'core/button',
    'core/image',
];

// Available control options
const lightboxControlOptions = [
    {
        label: __('Normal'),
        value: '',
    },
    {
        label: __('Lightbox - General'),
        value: 'lightbox',
    },
    {
        label: __('Lightbox - Video'),
        value: 'lightboxvideo',
    }
];
let allOptions = [];
let reusableBlockOptions;


/**
 * Add control attribute to block.
 *
 * @param {object} settings Current block settings.
 * @param {string} name Name of block.
 *
 * @returns {object} Modified block settings.
 */
const addLightboxControlAttribute = (settings, name) => {
    // Do nothing if it's another block than our defined ones.
    if (disableBlockControlLightbox || !enableControlOnBlocks.includes(name)) {
        return settings;
    }

    // Use Lodash's assign to gracefully handle if attributes are undefined
    settings.attributes = assign(settings.attributes, {
        lightbox: {
            type: 'string',
            default: lightboxControlOptions[0].value,
        },

    });

    return settings;
};

addFilter('blocks.registerBlockType', 'blokki/attribute/lightbox', addLightboxControlAttribute);

/**
 * Create HOC to add control to inspector controls of block.
 */
const withLightboxControl = createHigherOrderComponent((BlockEdit) => {
    return (props) => {
        // Do nothing if it's another block than our defined ones.
        if (disableBlockControlLightbox || !enableControlOnBlocks.includes(props.name)) {
            return (
                <BlockEdit {...props} />
            );
        }

        const {lightbox} = props.attributes;

        if (!reusableBlockOptions) {
            allOptions = lightboxControlOptions;
            reusableBlockOptions = [];

            apiFetch({
                path: '/blokki/v1/wp-blocks',
                headers: {
                    'X-WP-Nonce': blokki.nonce
                }
            }).then(data => {

                if (data.posts) {
                    data.posts.map(function (post) {
                        reusableBlockOptions.push({
                            value: 'blokkireusableblock' + post.ID,
                            label: 'Reusable Block - ' + post.post_title
                        });
                    });
                    allOptions = lightboxControlOptions.concat(reusableBlockOptions);

                }
            });
        }

        if (!props.attributes.className) {
            props.attributes.className = '';
        }

        const lightboxClass = (lightbox) ? `link-type-${lightbox}` : '';

        if (props.attributes.className.indexOf('link-type-') !== -1) {
            props.attributes.className = props.attributes.className.replace(/link-type-[a-z0-9]*/, lightboxClass);
        } else {
            props.attributes.className += ` ${lightboxClass}`;
        }


        return (
            <Fragment>
                <BlockEdit {...props} />
                <InspectorControls>
                    <PanelBody
                        title={__('Link Type')}
                        initialOpen={true}
                    >
                        <PanelRow
                            className={'panel-row-blokki-attributes '}
                        >
                            <SelectControl
                                label={__('Type')}
                                value={lightbox}
                                options={allOptions}
                                onChange={(selectedLightboxOption) => {
                                    props.setAttributes({
                                        lightbox: selectedLightboxOption,
                                    });
                                }}
                            />
                        </PanelRow>
                    </PanelBody>
                </InspectorControls>
            </Fragment>
        );
    };
}, 'withLightboxControl');

addFilter('editor.BlockEdit', 'blokki/lightbox', withLightboxControl);
