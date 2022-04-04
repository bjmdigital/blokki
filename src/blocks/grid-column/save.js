import {
    InnerBlocks,
    useBlockProps
} from '@wordpress/block-editor'

export default function Save({attributes}) {
    const blockProps = useBlockProps.save();
    return (
        <div{...blockProps} style={{
            backgroundColor: attributes.backgroundColor
        }}>
            <InnerBlocks.Content/>
        </div>
    )
}
