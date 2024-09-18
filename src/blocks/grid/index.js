import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'
import attrs from './attrs'
import icon from './icon'
import edit from './edit'
import save from './save'

import './style.scss';

registerBlockType('blokki/grid', {
    icon,
    apiVersion: 2,
    title: __('Blokki Grid', 'blokki'),
    description: __('Blokki blocks grid.', 'blokki'),
    attributes: attrs,
    category: 'theme',
    supports: {
        align: true,
        html: false,
        anchor: true,
        color: {
            background: true,
            text: true,
        },
        "spacing": {
            "padding": true,
            "margin": true,
        }
    },
    edit,
    save
})
