import {InnerBlocks, useBlockProps} from '@wordpress/block-editor'
import {mapAlignment} from '../helpers'

export default function Save({attributes}) {

    const {colWidth, gridGap, alignItems} = attributes;
    console.log(gridGap);
    const style = {};
    if (colWidth) {
        style.gridTemplateColumns = `repeat(auto-fit, minmax(${colWidth}px, 1fr))`;
    }
    if ('' !== gridGap) {
        style.gridGap = gridGap;
    }
    if (undefined !== alignItems) {
        style.alignItems = mapAlignment(alignItems);
    }
    return (
        <div className="blokki-grid" style={style}>
            <InnerBlocks.Content/>
        </div>
    )
}
