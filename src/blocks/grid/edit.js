import {__} from '@wordpress/i18n'
import {InspectorControls, BlockControls, BlockVerticalAlignmentToolbar, InnerBlocks} from '@wordpress/block-editor'

import {
    PanelBody,
    TextControl,
    RangeControl
} from '@wordpress/components'

import {mapAlignment} from '../helpers'
import './editor.scss'

export default function Edit({attributes, setAttributes}) {
    const {
        colWidth,
        gridGap,
        alignItems,
        largeUp,
        mediumUp,
        smallUp

    } = attributes
    const TEMPLATE = [['blokki/grid-column'], ['blokki/grid-column'], ['blokki/grid-column']];
    const ALLOWED_BLOCKS = ['blokki/grid-column'];
    return (
        <>
            <InspectorControls>

                <PanelBody title={__('Cards Per Row', 'blokki')}>
                    <RangeControl
                        label={__("Desktop", "blokki")}
                        value={largeUp}
                        onChange={largeUp => setAttributes({largeUp})}
                        min={1}
                        max={6}
                    />
                    <RangeControl
                        label={__("Tablet", "blokki")}
                        value={mediumUp}
                        onChange={mediumUp => setAttributes({mediumUp})}
                        min={1}
                        max={6}
                    />
                    <RangeControl
                        label={__("Mobile", "blokki")}
                        value={smallUp}
                        onChange={smallUp => setAttributes({smallUp})}
                        min={1}
                        max={6}
                    />
                </PanelBody>
                <PanelBody title={__('Display', 'blokki')}>
                    <TextControl
                        label={__('Column spacing', 'blokki')}
                        value={gridGap}
                        onChange={gridGap => setAttributes({gridGap})}
                        help = {__('with units i.e 10px, 1rem', 'blokki')}
                    />
                    <TextControl
                        label={__('Columns minimum width', 'blokki')}
                        value={colWidth}
                        onChange={colWidth => setAttributes({colWidth})}
                        help = {__('with units i.e 200px, 10rem', 'blokki')}
                    />
                </PanelBody>
            </InspectorControls>
            <BlockControls>
                <BlockVerticalAlignmentToolbar
                    value={alignItems}
                    onChange={alignItems => setAttributes({alignItems})}
                />
            </BlockControls>
            <div className="wp-block-blokki-grid" style={{
                '--blokki-grid-gap': `${gridGap}`,
                '--blokki-col-width': `${colWidth}`,
                '--blokki-align-items': `${mapAlignment(alignItems)}`,
            }}>
                <InnerBlocks template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
            </div>
        </>
    )
}
