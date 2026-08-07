/**
 * Import the ServerSideRender component from the @wordpress/server-side-render package.
 * This component is used to render the block on the server side.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-server-side-render/
 */
import ServerSideRender from "@wordpress/server-side-render";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from "@wordpress/block-editor";

/**
 * Import the block.json to get the block meta.
 */
import blockMeta from "./block.json";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit(props) {
    return (
        <div {...useBlockProps()}>
            <ServerSideRender
                block={blockMeta.name}
                attributes={props.attributes}
            />
        </div>
    );
}
