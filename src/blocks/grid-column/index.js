import { __ } from '@wordpress/i18n'
import { registerBlockType } from '@wordpress/blocks'
import icon from './icon'
import edit from './edit'
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
		backgroundColor: {
			type: 'string'
		}
	},
    edit,
    save
})
