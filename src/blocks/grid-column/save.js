import {useBlockProps, useInnerBlocksProps} from "@wordpress/block-editor";
import {getGridColumnClasses} from "../../helpers";
import {_x} from '@wordpress/i18n'

export default function Save({attributes}) {
    const {linkUrl, linkTarget} = attributes;
    const blockProps = useBlockProps.save({className: getGridColumnClasses(attributes)});
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return <div {...blockProps}>
        {linkUrl && <a
            className="blokki-grid-column-link"
            href={linkUrl}
            target={linkTarget}
            aria-label={_x(`Go to`, 'go to link url', 'blokki') + ' ' + linkUrl}
        ></a>}
        {innerBlocksProps.children}
    </div>
}
