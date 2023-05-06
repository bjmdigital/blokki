import {useBlockProps, RichText, InnerBlocks} from '@wordpress/block-editor';

export default function Save({attributes, className}) {
    const blockProps = useBlockProps.save({
        className: 'accordion-cell',
    });
    return (
        <div {...blockProps}>
            <button aria-controls={`accordion-content-${attributes.blockId}`} className="accordion-button"
                    aria-expanded="false">
                <span className="accordion-title">
                   <RichText.Content value={attributes.cardTitle}/>
                </span>
                <span className="accordion-icon">
                    <span className="icon-open"><i className="fa far fa-chevron-up" aria-hidden="true"></i></span>
                    <span className="icon-close"><i className="fa far fa-chevron-down" aria-hidden="true"></i></span>
                </span>
            </button>
            <div id={`accordion-content-${attributes.blockId}`} className="accordion-content" aria-hidden="true">
                <InnerBlocks.Content/>
            </div>
        </div>
    );
}
