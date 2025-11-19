(function (blocks, element, blockEditor, components) {
  const { __ } = wp.i18n;
  const { registerBlockType } = blocks;
  const { InspectorControls, useBlockProps } = blockEditor;
  const { PanelBody, TextControl, SelectControl } = components;
  const { createElement: el } = element;

  registerBlockType("proevent/event-grid", {
    title: __("Event Grid", "proevent"),
    icon: "grid-view",
    category: "widgets",
    supports: { html: false },

    attributes: {
      limit: { type: "number", default: 6 },
      category: { type: "string", default: "" },
      order: { type: "string", default: "DESC" },
    },

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const blockProps = useBlockProps(); // <-- critical for selection/removal

      // Single root element only
      return el(
        "div",
        blockProps,
        [
          // Inspector controls
          el(
            InspectorControls,
            {},
            el(
              PanelBody,
              { title: __("Settings", "proevent"), initialOpen: true },
              el(TextControl, {
                label: __("Limit", "proevent"),
                type: "number",
                value: attributes.limit,
                onChange: (v) => setAttributes({ limit: parseInt(v) || 1 }),
              }),
              el(TextControl, {
                label: __("Category Slug", "proevent"),
                value: attributes.category,
                onChange: (v) => setAttributes({ category: v }),
              }),
              el(SelectControl, {
                label: __("Order", "proevent"),
                value: attributes.order,
                options: [
                  { label: "DESC (Newest first)", value: "DESC" },
                  { label: "ASC (Oldest first)", value: "ASC" },
                ],
                onChange: (v) => setAttributes({ order: v }),
              })
            )
          ),

          // Placeholder for preview
          el(
            "div",
            { className: "event-grid-placeholder" },
            __("Event Grid Preview (Server-rendered)", "proevent")
          ),
        ]
      );
    },

    save: function () {
      return null; // server-side render only
    },
  });
})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components
);
