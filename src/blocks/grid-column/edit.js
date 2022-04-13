import {
    useBlockProps,
    useInnerBlocksProps,
    __experimentalLinkControl as LinkControl,
    BlockControls
} from "@wordpress/block-editor";
import {
    ToolbarButton,
    Popover,
} from '@wordpress/components';
import {useState} from '@wordpress/element';
import {link, linkOff} from '@wordpress/icons';
import {__} from '@wordpress/i18n'

export default function Edit(props) {
    const {attributes, isSelected, setAttributes} = props;
    const {linkUrl, linkTarget} = attributes;
    const [isEditingURL, setIsEditingURL] = useState(false);
    const blockProps = useBlockProps({className: "blokki-grid-column"});

    const innerBlocksProps = useInnerBlocksProps(blockProps, {
        template: [["core/paragraph"]],
    });

    const opensInNewTab = linkTarget === '_blank';

    return <>
        <BlockControls>
            <ToolbarButton
                name="link"
                icon={linkUrl ? linkOff : link}
                title={__('Link', 'blokki')}
                onClick={() => setIsEditingURL(!isEditingURL)}
            />
        </BlockControls>
        {(isSelected && isEditingURL) && (
            <Popover
                position="bottom center"
                onClose={() => setIsEditingURL(false)}
                focusOnMount={isEditingURL ? 'firstElement' : false}
            >
                <LinkControl
                    className="wp-block-navigation-link__inline-link-input"
                    value={{url: linkUrl, opensInNewTab}}
                    onChange={({ url: newURL, opensInNewTab: newOpensInNewTab  }) => {
                        setAttributes({
                            linkUrl: newURL,
                            linkTarget: newOpensInNewTab ? '_blank' : undefined
                        });
                    }}
                    onRemove={() => {
                        setAttributes({
                            linkUrl: undefined,
                            linkTarget: undefined,
                        });
                        setIsEditingURL(false);
                    }}
                    forceIsEditingLink={isEditingURL}
                />
            </Popover>
        )}
        <div {...innerBlocksProps} />
    </>
}
