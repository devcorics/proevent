import { registerBlockType } from '@wordpress/blocks';
import { MediaUpload, MediaUploadCheck, RichText, URLInputButton } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import './style.css';

registerBlockType('proevent/hero-cta', {
    edit: ({ attributes, setAttributes }) => {
        const { heroImage, heading, buttonText, buttonURL } = attributes;

        return (
            <div className="hero-cta-block" style={{ textAlign: 'center', padding: '50px 20px' }}>
                <MediaUploadCheck>
                    <MediaUpload
                        onSelect={(media) => setAttributes({ heroImage: media.url })}
                        allowedTypes={['image']}
                        value={heroImage}
                        render={({ open }) => (
                            <Button onClick={open} isPrimary>
                                {heroImage ? 'Change Hero Image' : 'Select Hero Image'}
                            </Button>
                        )}
                    />
                </MediaUploadCheck>

                {heroImage && (
                    <div style={{ margin: '20px 0' }}>
                        <img src={heroImage} alt="Hero Image" style={{ maxWidth: '100%' }} />
                    </div>
                )}

                <RichText
                    tagName="h1"
                    placeholder="Hero Heading"
                    value={heading}
                    onChange={(value) => setAttributes({ heading: value })}
                    style={{ fontSize: '2rem', margin: '20px 0' }}
                />

                <RichText
                    tagName="div"
                    placeholder="Button Text"
                    value={buttonText}
                    onChange={(value) => setAttributes({ buttonText: value })}
                    style={{ marginBottom: '10px' }}
                />

                <URLInputButton
                    url={buttonURL}
                    onChange={(url) => setAttributes({ buttonURL: url })}
                />
            </div>
        );
    },

    save: ({ attributes }) => {
        const { heroImage, heading, buttonText, buttonURL } = attributes;

        return (
            <section className="hero-cta" style={{ 
                backgroundImage: `url(${heroImage})`, 
                padding: '100px 20px', 
                textAlign: 'center', 
                color: '#fff', 
                backgroundSize: 'cover', 
                backgroundPosition: 'center' 
            }}>
                {heading && <h1>{heading}</h1>}
                {buttonText && buttonURL && (
                    <a href={buttonURL} className="hero-button" style={{ 
                        display: 'inline-block', 
                        marginTop: '20px', 
                        padding: '10px 20px', 
                        background: '#ff0000', 
                        color: '#fff', 
                        textDecoration: 'none', 
                        borderRadius: '5px' 
                    }}>
                        {buttonText}
                    </a>
                )}
            </section>
        );
    }
});
