import {
    PanelBody,
    ColorIndicator,
    Toolbar
} from '@wordpress/components';

import {__} from '@wordpress/i18n';
import {
    useBlockProps,
    InnerBlocks,
    InspectorControls,
    BlockControls,
    ColorPalette,
    URLInputButton
} from '@wordpress/block-editor';

import './editor.scss';

export default function Edit({attributes, className, setAttributes, isSelected, props}) {

    const blockProps = useBlockProps({className: 'cell'});

    const TEMPLATE = [
        ['core/paragraph', {}],
    ];

    const inner = attributes.url ? (
        <a>
            {<InnerBlocks
                template={TEMPLATE}
                templateLock={false}
            />}
        </a>
    ) : (
        <InnerBlocks
            template={TEMPLATE}
            templateLock={false}
        />
    );

    return [
        <InspectorControls>
            <PanelBody title={__('Color Settings', 'blokki')}>
                <div className="components-base-control">
                    <div className="components-base-control__field">
                        <label className="components-base-control__label">
                            {__('Background Color', 'gutenberg-block-examples')}
                        </label>
                        <ColorPalette
                            value={attributes.backgroundColor}
                            onChange={backgroundColor => setAttributes({backgroundColor})}
                        />
                    </div>
                </div>
            </PanelBody>
        </InspectorControls>,
        <div {...blockProps}>
            <BlockControls>
                <Toolbar>
                    <URLInputButton
                        url={attributes.url}
                        onChange={(url) => setAttributes({url})}
                    />
                </Toolbar>
            </BlockControls>
            {inner}
        </div>
    ];

}

