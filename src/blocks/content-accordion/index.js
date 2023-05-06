import {registerBlockType} from '@wordpress/blocks';
import {__} from '@wordpress/i18n';

import Edit from './edit';
import save from './save';

registerBlockType('blokki/content-accordion', {
    apiVersion: 2,
    title: __('Blokki Content Accordion', 'blokki'),
    description: __(
        'Custom Content Accordion',
        'blokki'
    ),
    category: 'layout',
    icon: 'list-view',
    keywords: [
        __('Custom Content Accordion', 'blokki'),
    ],
    attributes: {
        cardTitle: {
            type: 'string',
            source: 'html',
            selector: '.accordion-title',
        },
        blockId: {
            type: 'string'
        }
    },

    /**
     * @see ./edit.js
     */
    edit: Edit,

    /**
     * @see ./save.js
     */
    save,
});
