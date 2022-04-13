import {useBlockProps, useInnerBlocksProps} from '@wordpress/block-editor'
import {getGridClasses} from '../../helpers'

export default function Save({attributes}) {
    const blockProps = useBlockProps.save({className: getGridClasses(attributes)});
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return <div {...innerBlocksProps} />
}
