import {__} from '@wordpress/i18n'
import {
    InspectorControls,
    BlockControls,
    BlockVerticalAlignmentToolbar,
    useBlockProps,
    useInnerBlocksProps
} from '@wordpress/block-editor'

import {
    PanelBody,
    RangeControl
} from '@wordpress/components'

import {getGridClasses} from '../../helpers'

import './editor.scss'


export default function Edit(props) {
    const {
        attributes,
        setAttributes,
    } = props;

    const {
        alignItems,
        largeUp,
        mediumUp,
        smallUp
    } = attributes;

    const blockProps = useBlockProps({className: getGridClasses(attributes)});

    const innerBlocksProps = useInnerBlocksProps(blockProps, {
        allowedBlocks: ["blokki/grid-column"],
        template: [["blokki/grid-column"], ["blokki/grid-column"], ["blokki/grid-column"]],
    });

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Columns', 'blokki')}>
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
            </InspectorControls>
            <BlockControls>
                <BlockVerticalAlignmentToolbar
                    value={alignItems}
                    onChange={alignItems => setAttributes({alignItems})}
                />
            </BlockControls>
            <div {...innerBlocksProps} />
        </>
    )
}
