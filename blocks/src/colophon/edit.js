/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __, _x } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow } from '@wordpress/components';
import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import { TextControl, CheckboxControl } from '@wordpress/components';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * Replace any default link texts.
 *
 * @since 1.0.0
 *
 * @param {object} attributes The block attributes.
 *
 * @return {object} The modified attributes.
 */
const replaceLinkTextPlaceHolders = (attributes) => {
	// If pressableLink is __ or not set
	if (attributes.pressableLink === '__' || !attributes.pressableLink ) {
		// Set pressableLink to the value of linkText.
		attributes.pressableLink = __('Hosted by Pressable.', 'wpcomsp-donations');
	}

	// If wpCLink is __ or not set
	if (attributes.wpComLink === '__' || !attributes.wpComLink) {
		// Set wpCLink to the value of linkText.
		attributes.wpComLink = __('Proudly powered by WordPress.', 'wpcomsp-donations');
	}

	return attributes;
}

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	attributes = replaceLinkTextPlaceHolders(attributes);

	console.log(attributes);
	return (

		<Fragment>
			<InspectorControls>
				<PanelBody title={__('Settings', 'textdomain')}>
					<PanelRow>
						<p>HI</p>
					</PanelRow>
					<PanelRow>
							<TextControl
								label={ _x(
									'Pressable Link Text',
									'inspector control label for the Pressable Link Text setting',
									'wpcomsp-donations'
								) }
								value={ attributes.pressableLink.toString() }
								onChange={ ( value ) => {
									setAttributes( { pressableLink: value } );
								} }
								help={ __(
									'Enter the text that should be shown on the Pressable link, leave empty to hide link.',
									'wpcomsp-donations'
								) }
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label={ _x(
									'WordPress.com Link Text',
									'inspector control label for the WordPress.com Link Text setting',
									'wpcomsp-donations'
								) }
								value={ attributes.wpComLink.toString() }
								onChange={ ( value ) => {
									setAttributes( { wpComLink: value } );
								} }
								help={ __(
									'Enter the text that should be shown on the WordPress.com link, leave empty to hide link.',
									'wpcomsp-donations'
								) }
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label={ _x(
									'Separator',
									'inspector control label for the separator setting',
									'wpcomsp-donations'
								) }
								value={ attributes.separator.toString() }
								onChange={ ( value ) => {
									setAttributes( { separator: value } );
								} }
								help={ __(
									'Please enter the separator character(s) to be used between the links. Plain text ONLY, no HTML.',
									'wpcomsp-donations'
								) }
							/>
						</PanelRow>
						<PanelRow>
							<CheckboxControl
								label={ _x(
									'Wrap links in a <span> tag',
									'inspector control label for the wrap links setting',
									'wpcomsp-donations')}
								checked={ attributes.wrapLinks }
								onChange={ ( value ) => {
									setAttributes( { wrapLinks: value } );
								} }
								help={ __(
									'Wrap the links in a <span> tag to allow for styling.',
									'wpcomsp-donations'
								) }
							/>
						</PanelRow>
				</PanelBody>
			</InspectorControls>
			<p {...useBlockProps()}>Hello from the editor!</p>
		</Fragment>
	);
}
