import {InnerBlocks, useBlockProps} from '@wordpress/block-editor'
import {mapAlignment} from '../helpers'


export default function Save({attributes}) {

    const {
        colWidth, gridGap, alignItems, largeUp, mediumUp, smallUp
    } = attributes;

    const gridClasses = ['blokki-grid'];
    gridClasses.push('large-up-' + largeUp);
    gridClasses.push('medium-up-' + mediumUp);
    gridClasses.push('small-up-' + smallUp);

    const blockProps = useBlockProps.save({
        className: gridClasses.join(' '),
    });


    const style = {};
    if ('' !== colWidth) {
        style.gridTemplateColumns = `repeat(auto-fit, minmax(${colWidth}, 1fr))`;
    }
    if ('' !== gridGap) {
        style.gridGap = gridGap;
    }
    if (undefined !== alignItems) {
        style.alignItems = mapAlignment(alignItems);
    }
    return (
        <div {...blockProps} style={style}>
            <InnerBlocks.Content/>
        </div>
    )
}
