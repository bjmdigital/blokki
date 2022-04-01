import { InnerBlocks } from '@wordpress/block-editor'

export default function Save() {
	return (
		<div className="wp-block-blokki-grid-column">
			<InnerBlocks.Content />
		</div>
	)
}
