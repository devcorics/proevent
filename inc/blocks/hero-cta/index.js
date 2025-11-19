(function (blocks, element, blockEditor, components) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var MediaUpload = blockEditor.MediaUpload;
    var TextControl = components.TextControl;
    var Button = components.Button;
    var PanelBody = components.PanelBody;
    
    blocks.registerBlockType('proevent/hero-cta', {
        title: 'Hero with CTA',
        icon: 'cover-image',
        category: 'layout',
        attributes: {
            heroImage: { type: 'string', default: '' },
            heroHeading: { type: 'string', default: 'Your Heading Here' },
            heroButtonText: { type: 'string', default: 'Click Here' },
            heroButtonUrl: { type: 'string', default: '#' },
        },
        edit: function (props) {
            var attributes = props.attributes;

            return [
                // Sidebar controls
                el(InspectorControls, { key: 'inspector' },
                    el(PanelBody, { title: 'Hero Settings', initialOpen: true },
                        // Image upload
                        el('div', { style: { marginBottom: '20px' } },
                            el(MediaUpload, {
                                onSelect: function (media) { props.setAttributes({ heroImage: media.url }); },
                                allowedTypes: ['image'],
                                render: function (obj) {
                                    return el('div', {},
                                        el(Button, { onClick: obj.open, isPrimary: true },
                                            attributes.heroImage ? 'Change Image' : 'Select Image'
                                        ),
                                        // Remove button
                                        attributes.heroImage && el(Button, {
                                            onClick: function () { props.setAttributes({ heroImage: '' }); },
                                            isDestructive: true,
                                            style: { marginLeft: '10px' }
                                        }, 'Remove Image')
                                    );
                                }
                            }),
                            // Preview thumbnail
                            attributes.heroImage && el('img', {
                                src: attributes.heroImage,
                                style: { maxWidth: '100%', marginTop: '10px' }
                            })
                        ),
                        // Heading input
                        el(TextControl, {
                            label: 'Heading',
                            value: attributes.heroHeading,
                            onChange: function (value) { props.setAttributes({ heroHeading: value }); }
                        }),
                        // Button text input
                        el(TextControl, {
                            label: 'Button Text',
                            value: attributes.heroButtonText,
                            onChange: function (value) { props.setAttributes({ heroButtonText: value }); }
                        }),
                        // Button URL input
                        el(TextControl, {
                            label: 'Button URL',
                            value: attributes.heroButtonUrl,
                            onChange: function (value) { props.setAttributes({ heroButtonUrl: value }); }
                        })
                    )
                ),
                
                // Block preview in editor
                el('section', { className: 'hero-cta text-center py-16 bg-gray-100', key: 'preview' },
                    attributes.heroImage && el('img', { src: attributes.heroImage, className: 'mx-auto mb-6' }),
                    el('h1', { className: 'text-4xl font-bold mb-4 text-black' }, attributes.heroHeading),
                    el('a', {
                        className: 'inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition',
                        href: attributes.heroButtonUrl
                    }, attributes.heroButtonText)
                )
            ];
        },
        save: function () {
            return null; // Rendered via PHP
        }
    });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
