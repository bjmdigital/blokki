import {useBlockProps, InnerBlocks} from '@wordpress/block-editor';

export default function Save({attributes, className}) {
    const blockProps = useBlockProps.save();
    return (
        <div {...blockProps}>
            <div className={ 'grid-x' + ' large-up-' + attributes.columns + ' medium-up-' + attributes.columnsMedium + ' small-up-' + attributes.columnsSmall }>
                <InnerBlocks.Content />
            </div>
        </div>
    );
}
