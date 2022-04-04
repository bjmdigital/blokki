import {
	TextControl,
	PanelBody,
	ColorIndicator,
	RadioControl,
	ButtonGroup,
	Button,
	IconButton
} from '@wordpress/components';

import {__} from '@wordpress/i18n';

import {
	InnerBlocks,
	useBlockProps,
	RichText,
	InspectorControls,
	ColorPalette,
	BlockControls,
	AlignmentToolbar

} from '@wordpress/block-editor'

import classnames from 'classnames';

export default function Edit({attributes, className, setAttributes}) {

	const blockProps = useBlockProps();

	console.log(attributes);

	return [
		<InspectorControls>
			<PanelBody title={__('Color Settings', 'blokki')}>
				<div className="components-base-control">
					<div className="components-base-control__field">
						<label className="components-base-control__label">
							{__('Background Color', 'blokki')}
							<ColorIndicator colorValue={attributes.backgroundColor}/>
						</label>
						<ColorPalette
							value={attributes.backgroundColor}
							onChange={backgroundColor => setAttributes({backgroundColor})}
						/>
					</div>
				</div>
			</PanelBody>
		</InspectorControls>,
		<div {...blockProps} style={{
			backgroundColor: attributes.backgroundColor
		}}>
			<InnerBlocks />
		</div>
	];
	// return (
	// 	<div className="wp-block-blokki-grid-column">
	// 		<InnerBlocks />
	// 	</div>
	// )
}
