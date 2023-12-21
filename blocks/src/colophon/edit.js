import { __, _x } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, PanelRow, TextControl, CheckboxControl } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';

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
	if (attributes.pressableLink === '__' || !attributes.pressableLink) {
		// Set pressableLink to the value of linkText.
		attributes.pressableLink = __('Hosted by Pressable.', 'team51');
	}

	// If wpCLink is __ or not set
	if (attributes.wpComLink === '__' || !attributes.wpComLink) {
		// Set wpCLink to the value of linkText.
		attributes.wpComLink = __('Proudly powered by WordPress.', 'team51');
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

	// Handle any default link text replacements.
	attributes = replaceLinkTextPlaceHolders(attributes);

	return (

		<Fragment>
			<InspectorControls>
				<PanelBody title={__('Settings', 'team51')}>
					<PanelRow>
						<TextControl
							label={_x('Pressable Link Text', 'inspector control label for the Pressable Link Text setting', 'team51')}
							value={attributes.pressableLink.toString()}
							onChange={(value) => setAttributes({ pressableLink: value })}
							help={__('Enter the text that should be shown on the Pressable link, leave empty to hide link.', 'team51')}
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={_x('WordPress.com Link Text', 'inspector control label for the WordPress.com Link Text setting', 'team51')}
							value={attributes.wpComLink.toString()}
							onChange={(value) => setAttributes({ wpComLink: value })}
							help={__('Enter the text that should be shown on the WordPress.com link, leave empty to hide link.', 'team51')}
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={_x('Separator', 'inspector control label for the separator setting', 'team51')}
							value={attributes.separator.toString()}
							onChange={(value) => setAttributes({ separator: value })}
							help={__('Please enter the separator character(s) to be used between the links. Plain text ONLY, no HTML.', 'team51')}
						/>
					</PanelRow>
					<PanelRow>
						<CheckboxControl
							label={_x('Wrap links in a <span> tag', 'inspector control label for the wrap links setting', 'team51')}
							checked={attributes.hasWrapper}
							onChange={(value) => setAttributes({ hasWrapper: value })}
							help={__('Wrap the links in a <span> tag to allow for styling.', 'team51')}
						/>
					</PanelRow>

					{attributes.hasWrapper &&
						<PanelRow>
							<TextControl
								label={_x('Wrapper Class', 'inspector control label for the CSS class setting', 'team51')}
								value={attributes.wrapperClassName.toString()}
								onChange={(value) => setAttributes({ wrapperClassName: value })}
								help={__('Please enter the CSS class to be used for the <span> tag.', 'team51')}
							/>
						</PanelRow>
					}
				</PanelBody>
			</InspectorControls>
			<p {...useBlockProps()}>
				<ServerSideRender
					block={'team51/colophon'}
					attributes={attributes}
				/>
			</p>
		</Fragment>
	);
}
