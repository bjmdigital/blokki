import {__} from '@wordpress/i18n';
import {
    useBlockProps,
    RichText,
    InnerBlocks
} from '@wordpress/block-editor';

import './editor.scss';

export default function Edit({attributes, setAttributes, clientId}) {

    const {blockId} = attributes;
    const blockProps = useBlockProps({className: 'accordion-cell'});

    /**
     * We need a unique block id for aria-content to work properly
     */
    React.useEffect(() => {
        if (!blockId) {
            setAttributes({blockId: clientId});
        }
    }, []);

    return (
        <div {...blockProps}>
            <button className="accordion-button"
                    aria-controls={`accordion-content-${attributes.blockId}`}
                    aria-expanded="false">
                <span className="accordion-title">
                    <RichText
                        placeholder={__('Accordion Card Title', 'blokki')}
                        value={attributes.cardTitle}
                        onChange={cardTitle => setAttributes({cardTitle})}
                    />
                </span>
                <span className="accordion-icon">
                    <span className="icon-open"><i className="fa far fa-chevron-up" aria-hidden="true"></i></span>
                    <span className="icon-close"><i className="fa far fa-chevron-down" aria-hidden="true"></i></span>
                </span>
            </button>
            <div className="accordion-content-editor"
                 id={`accordion-content-${attributes.blockId}`}
                 aria-hidden="false">
                <InnerBlocks/>
            </div>
        </div>
    );
}

