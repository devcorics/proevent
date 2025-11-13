const { registerBlockType } = wp.blocks;
const { TextControl, SelectControl } = wp.components;
const { InspectorControls } = wp.blockEditor;
const { __ } = wp.i18n;

registerBlockType('proevent/event-grid', {
    title: __('Event Grid', 'proevent'),
    icon: 'calendar',
    category: 'widgets',
    attributes: {
        limit: { type: 'number', default: 6 },
        category: { type: 'string', default: '' },
        sort: { type: 'string', default: 'ASC' }
    },
    edit: ({ attributes, setAttributes }) => (
        <>
            <InspectorControls>
                <TextControl
                    label="Number of Events"
                    value={attributes.limit}
                    type="number"
                    onChange={(value) => setAttributes({ limit: parseInt(value) })}
                />
                <TextControl
                    label="Category Slug"
                    value={attributes.category}
                    onChange={(value) => setAttributes({ category: value })}
                />
                <SelectControl
                    label="Sort Order"
                    value={attributes.sort}
                    options={[
                        { label: 'Ascending', value: 'ASC' },
                        { label: 'Descending', value: 'DESC' }
                    ]}
                    onChange={(value) => setAttributes({ sort: value })}
                />
            </InspectorControls>
            <div className="event-grid-placeholder">
                <p>{`Event Grid: ${attributes.limit} posts, category: ${attributes.category || 'All'}, sorted ${attributes.sort}`}</p>
            </div>
        </>
    ),
    save: () => null
});
