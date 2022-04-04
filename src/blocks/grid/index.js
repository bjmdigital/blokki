import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'
import attrs from './attrs'
import icon from './icon'
import edit from './edit'
import save from './save'

import './style.scss';

registerBlockType('blokki/grid', {
    icon,
    title: __('Blokki Grid', 'blokki'),
    description: __('Blokki blocks grid.', 'blokki'),
	attributes: attrs,
	category: 'theme',
	supports: {
		align: true,
		html: false
	},
    edit,
    save
})
