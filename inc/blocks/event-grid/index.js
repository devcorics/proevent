const { registerBlockType } = wp.blocks;
const { TextControl, SelectControl } = wp.components;
const { useBlockProps } = wp.blockEditor || wp.editor;
const { Fragment, useEffect, useState } = wp.element;

registerBlockType('proevent/event-grid', {
    edit: ({ attributes, setAttributes }) => {
        const { limit, category, order } = attributes;

        return (
            <div {...useBlockProps()} style={{ border: "1px dashed #ccc", padding: "20px" }}>
                <TextControl
                    label="Number of Events"
                    type="number"
                    value={limit}
                    onChange={(value) => setAttributes({ limit: parseInt(value) })}
                />
                <TextControl
                    label="Category Slug (optional)"
                    value={category}
                    onChange={(value) => setAttributes({ category: value })}
                />
                <SelectControl
                    label="Order"
                    value={order}
                    options={[
                        { label: "Ascending", value: "ASC" },
                        { label: "Descending", value: "DESC" }
                    ]}
                    onChange={(value) => setAttributes({ order: value })}
                />
                <p>Preview not available in editor. Save to view on frontend.</p>
            </div>
        );
    },
    save: ({ attributes }) => {
        const { limit, category, order } = attributes;
        // Frontend rendering via PHP
        return null;
    }
});
