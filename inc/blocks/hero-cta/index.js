const { registerBlockType } = wp.blocks;
const { TextControl, URLInputButton, MediaUpload, MediaUploadCheck, Button } = wp.blockEditor || wp.editor;
const { Fragment } = wp.element;

registerBlockType('proevent/hero-cta', {
    edit: ({ attributes, setAttributes }) => {
        const { title, imageUrl, buttonText, buttonUrl } = attributes;

        return (
            <Fragment>
                <div style={{ border: "1px dashed #ccc", padding: "20px", textAlign: "center" }}>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={(media) => setAttributes({ imageUrl: media.url })}
                            allowedTypes={['image']}
                            render={({ open }) => (
                                <Button onClick={open}>
                                    {imageUrl ? <img src={imageUrl} alt="Hero Image" style={{ maxWidth: "100%" }} /> : 'Select Hero Image'}
                                </Button>
                            )}
                        />
                    </MediaUploadCheck>
                    <TextControl
                        label="Heading"
                        value={title}
                        onChange={(value) => setAttributes({ title: value })}
                    />
                    <TextControl
                        label="Button Text"
                        value={buttonText}
                        onChange={(value) => setAttributes({ buttonText: value })}
                    />
                    <URLInputButton
                        label="Button URL"
                        url={buttonUrl}
                        onChange={(url) => setAttributes({ buttonUrl: url })}
                    />
                </div>
            </Fragment>
        );
    },
    save: ({ attributes }) => {
        const { title, imageUrl, buttonText, buttonUrl } = attributes;
        return (
            <div className="hero-cta" style={{ textAlign: "center", padding: "50px", backgroundImage: imageUrl ? `url(${imageUrl})` : 'none', backgroundSize: "cover", backgroundPosition: "center" }}>
                <h1>{title}</h1>
                <a href={buttonUrl} className="hero-btn" style={{ padding: "10px 20px", background: "#0073aa", color: "#fff", textDecoration: "none" }}>
                    {buttonText}
                </a>
            </div>
        );
    }
});
