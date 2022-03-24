import {registerBlockType} from '@wordpress/blocks';
import {__} from '@wordpress/i18n';
import './style.scss';

import Edit from './edit';
import save from './save';

registerBlockType('blokki/content-cell', {
    apiVersion: 2,
    title: __('Blokki Content Cell', 'blokki'),
    description: __(
        'Content Cell to be used in Blokki content grid',
        'blokki'
    ),
    parent: [ 'blokki/content-grid' ],
    category: 'theme',
    icon: 'screenoptions',
    keywords: [
        __( 'blokki' ),
    ],
    attributes: {
        url: {
            type: 'string',
            default: ''
        },
        alignHoriz: {
            type: 'string',
            default: ''
        },
        minHeight: {
            type: 'string',
            default: ''
        },
        backgroundColor: {
            type: 'string',
            default: '#fff'
        },
        customBackgroundColor: {
            type: 'string',
            default: ''
        },
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
