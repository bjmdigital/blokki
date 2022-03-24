import {registerBlockType} from '@wordpress/blocks';
import {__} from '@wordpress/i18n';
import './style.scss';

import Edit from './edit';
import save from './save';

registerBlockType('blokki/content-grid', {
    apiVersion: 2,
    title: __('Blokki Content Grid', 'blokki'),
    description: __(
        'A grid of child grid elements',
        'blokki'
    ),
    category: 'theme',
    icon: 'screenoptions',
    keywords: [
        __( 'blokki', 'blokki' ),
        __( 'bjm', 'blokki' ),
    ],
    supports: { align: [ 'wide', 'full' ], default: '' },
    attributes: {
        align: {
            type: 'string',
            default: 'wide',
        },
        className: {
            type: 'string',
            default: 'whatever',
        },
        alignHoriz: {
            type: 'string',
            default: 'left',
        },
        columns: {
            type: 'integer',
            default: 3,
        },
        columnsMedium: {
            type: 'integer',
            default: 2,
        },
        columnsSmall: {
            type: 'integer',
            default: 1,
        },
        minHeight: {
            type: 'string',
            default: null,
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
