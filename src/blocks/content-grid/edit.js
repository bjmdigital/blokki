import {
    TextControl,
    PanelBody,
    RangeControl,
} from '@wordpress/components';

import {__} from '@wordpress/i18n';
import {
    useBlockProps,
    InnerBlocks,
    InspectorControls,
    BlockControls,
    BlockAlignmentToolbar
} from '@wordpress/block-editor';

import './editor.scss';

export default function Edit({attributes, className, setAttributes, isSelected}) {

    const ALLOWED_BLOCKS = ['blokki/content-cell'];

    const TEMPLATE = [
        ['blokki/content-cell', {}],
    ];

    const blockProps = useBlockProps({className: 'wp-block-blokki-content-grid'});

    return [
        <InspectorControls>
            <PanelBody title={__('Layout Settings', 'blokki')}>
                <div className="components-base-control">
                    <div className="components-base-control__field">
                        <label className="components-base-control__label">
                            {__('Columns Setting', 'blokki')}
                        </label>
                        <RangeControl
                            label={__('Desktop', 'blokki')}
                            value={attributes.columns}
                            min={1}
                            max={8}
                            onChange={(columns) => setAttributes({columns})}

                        />
                        <RangeControl
                            label={__('Tablet', 'blokki')}
                            value={attributes.columnsMedium}
                            min={1}
                            max={8}
                            onChange={(columnsMedium) => setAttributes({columnsMedium})}

                        />
                        <RangeControl
                            label={__('Phone', 'blokki')}
                            value={attributes.columnsSmall}
                            min={1}
                            max={2}
                            onChange={(columnsSmall) => setAttributes({columnsSmall})}

                        />
                        <TextControl
                            label={__('Minimum height of each block in pixels')}
                            value={attributes.minHeight}
                            type={'number'}
                            min={50}
                            step={1}
                            onChange={(minHeight) => setAttributes({minHeight})}

                        />
                    </div>
                </div>
            </PanelBody>
        </InspectorControls>,
        <div {...blockProps}>
            <BlockControls>
                <BlockAlignmentToolbar
                    controls={['left', 'center', 'right']}
                    value={attributes.alignHoriz}
                    onChange={(alignHoriz) => setAttributes({alignHoriz})}
                />
            </BlockControls>
            <div>{__('Add Blocks Here...', 'blokki')}</div>
            <div className={'grid-x' + ' large-up-' + attributes.columns}>
                <InnerBlocks
                    allowedBlocks={ALLOWED_BLOCKS}
                    template={TEMPLATE}
                    templateLock={false}
                />
            </div>
        </div>
    ];

}

