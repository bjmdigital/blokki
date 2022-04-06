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
	AlignmentToolbar,
	PanelColorSettings,
	withColors
} from '@wordpress/block-editor'

import { useState } from '@wordpress/element';

import classnames from 'classnames';

export default function Edit({attributes, className, setAttributes, textColor, backgroundColor ,setTextColor, setBackgroundColor}) {

	let divClass = [];
	let divStyles = {};
	if (textColor !== undefined) {
		if (textColor.class !== undefined) {
			divClass.push(textColor.class);
		} else {
			divStyles.color = textColor.color;
		}
	}

	if (backgroundColor !== undefined) {
		if (backgroundColor.class !== undefined) {
			divClass.push(backgroundColor.class);
		} else {
			divStyles.backgroundColor = backgroundColor.color;
		}
	}

	const blockProps = useBlockProps();

	return [
		<InspectorControls>
			<PanelColorSettings
				title={__('Color settings')}
				colorSettings={[
					{
						value: textColor.color,
						onChange: setTextColor,
						label: __('Text color')
					},
					{
						value: backgroundColor.color,
						onChange: setBackgroundColor,
						label: __('Background color')
					},
				]}
			/>

		</InspectorControls>,
		<div className={divClass.join(' ')} style={divStyles}>
			<InnerBlocks />
		</div>
	];
	// return (
	// 	<div className="wp-block-blokki-grid-column">
	// 		<InnerBlocks />
	// 	</div>
	// )
}
