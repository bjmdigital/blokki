import {__} from '@wordpress/i18n'
import {registerBlockType} from '@wordpress/blocks'
import attrs from './attrs'

import './style.scss';

import icon from './icon'
import edit from './edit'
import save from './save'

registerBlockType('blokki/grid-column', {
    icon,
    apiVersion: 2,
    title: __('Grid Column', 'blokki'),
    description: __('Blokki Grid columns', 'blokki'),
    parent: ['blokki/grid'],
    category: 'layout',
    supports: {
        html: false,
        color: {
            background: true,
            text: true,
        },
    },
    attributes: attrs,
    edit,
    save
})
