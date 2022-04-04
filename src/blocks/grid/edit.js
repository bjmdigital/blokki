import {__} from '@wordpress/i18n'
import {InspectorControls, BlockControls, BlockVerticalAlignmentToolbar, InnerBlocks} from '@wordpress/block-editor'
import {PanelBody, TextControl} from '@wordpress/components'
import {mapAlignment} from '../helpers'
import './editor.scss'

export default function Edit({attributes, setAttributes}) {
    const {colWidth, gridGap, alignItems} = attributes
    const TEMPLATE = [['blokki/grid-column'], ['blokki/grid-column'], ['blokki/grid-column']];
    const ALLOWED_BLOCKS = ['blokki/grid-column'];
    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Display', 'blokki')}>
                    <TextControl
                        label={__('Column widths', 'blokki')}
                        type="number"
                        value={colWidth}
                        onChange={colWidth => setAttributes({colWidth: Number(colWidth)})}
                    />
                    <TextControl
                        label={__('Column spacing', 'blokki')}
                        type="number"
                        value={gridGap}
                        onChange={gridGap => setAttributes({gridGap: Number(gridGap)})}
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
                '--blokki-grid-gap': `${gridGap}px`,
                '--blokki-col-width': `${colWidth}px`,
                '--blokki-align-items': `${mapAlignment(alignItems)}`,
            }}>
                <InnerBlocks template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
            </div>
        </>
    )
}
