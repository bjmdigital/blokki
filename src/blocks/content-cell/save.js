import {useBlockProps, InnerBlocks} from '@wordpress/block-editor';

export default function Save({attributes, className}) {
    const blockProps = useBlockProps.save({className: 'cell'});

    const inner = attributes.url ? (
        <a
            href={attributes.url}
        >
            {<InnerBlocks.Content />}
        </a>
    ) : (
        <InnerBlocks.Content />
    );
    return (
        <div {...blockProps}>
            {inner}
        </div>
    );
}
