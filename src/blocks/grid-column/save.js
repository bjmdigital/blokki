import {useBlockProps, useInnerBlocksProps} from "@wordpress/block-editor";
import {getGridColumnClasses} from "../../helpers";
import {__} from '@wordpress/i18n'

export default function Save({attributes}) {
    const {linkUrl, linkTarget} = attributes;
    const blockProps = useBlockProps.save({className: getGridColumnClasses(attributes)});
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return <div {...blockProps}>
        {linkUrl && <a
            className="blokki-grid-column-link"
            href={linkUrl}
            target={linkTarget}
            aria-label={__(`Go to ${linkUrl}`, 'blokki')}
        ></a>}
        <div {...innerBlocksProps} />
    </div>
}
