import { registerBlockType } from '@wordpress/blocks';
import { MediaUpload, RichText, URLInputButton } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

registerBlockType('proevent/hero-cta', {
    edit: ({ attributes, setAttributes }) => {
        const { imageUrl, imageAlt, heading, buttonText, buttonUrl } = attributes;

        return (
            <div className="hero-cta p-6 text-center bg-gray-100 rounded-lg">
                <MediaUpload
                    onSelect={(media) => setAttributes({ imageUrl: media.url, imageAlt: media.alt })}
                    allowedTypes={['image']}
                    value={imageUrl}
                    render={({ open }) => (
                        <Button onClick={open} isSecondary>
                            { imageUrl ? 'Change Image' : 'Upload Image' }
                        </Button>
                    )}
                />
                { imageUrl && (
                    <img src={imageUrl} alt={imageAlt || ''} className="my-4 mx-auto max-w-full h-auto rounded" />
                )}
                <RichText
                    tagName="h1"
                    placeholder="Enter heading..."
                    value={heading}
                    onChange={(value) => setAttributes({ heading: value })}
                    className="text-3xl font-bold mb-4"
                />
                <RichText
                    tagName="a"
                    placeholder="Button text..."
                    value={buttonText}
                    onChange={(value) => setAttributes({ buttonText: value })}
                    className="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                />
                <URLInputButton
                    url={buttonUrl}
                    onChange={(url) => setAttributes({ buttonUrl: url })}
                />
            </div>
        );
    },
    save: ({ attributes }) => {
        const { imageUrl, imageAlt, heading, buttonText, buttonUrl } = attributes;

        return (
            <div className="hero-cta p-6 text-center bg-gray-100 rounded-lg">
                { imageUrl ? (
                    <img src={imageUrl} alt={imageAlt || ''} className="my-4 mx-auto max-w-full h-auto rounded" />
                ) : (
                    <div className="bg-gray-300 w-full h-40 mb-4 rounded flex items-center justify-center text-gray-500">
                        Hero Image
                    </div>
                )}
                { heading ? <h1 className="text-3xl font-bold mb-4">{heading}</h1> : <h1 className="text-3xl font-bold mb-4 text-gray-400">Heading</h1>}
                { buttonText && buttonUrl ? (
                    <a href={buttonUrl} className="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        {buttonText}
                    </a>
                ) : (
                    <a href="#" className="inline-block px-6 py-3 bg-blue-400 text-white rounded cursor-not-allowed">Button</a>
                )}
            </div>
        );
    },
});
