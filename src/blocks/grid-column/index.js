import {__} from '@wordpress/i18n'
import {registerBlockType} from '@wordpress/blocks'
import {
    withColors
} from '@wordpress/block-editor'

import './style.scss';

import icon from './icon'
import Edit from './edit'
import save from './save'

registerBlockType('blokki/grid-column', {
    icon,
    title: __('Grid Column', 'blokki'),
    description: __('Blokki Grid columns', 'blokki'),
    parent: ['blokki/grid'],
    category: 'layout',
    supports: {
        html: false
    },
    attributes: {
        textColor: {
            type: 'string'
        },
        customTextColor: {
            type: 'string'
        },
        backgroundColor: {
            type: 'string'
        },
        customBackgroundColor: {
            type: 'string'
        },
        hasColumnLink: {
            type: "boolean",
            default: false
        },
        columnLinkURL: {
            type: "string"
        },
        columnLinkTitle: {
            type: "string",
            default: ''
        },
        columnLinkTarget: {
            type: "string",
            default: "_self"
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
        }

    },
    edit: withColors({textColor: 'color', backgroundColor: 'background-color'})(Edit),
    save
})
