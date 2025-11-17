(function (wp) {
  const { registerBlockType } = wp.blocks;
  const { InspectorControls, useBlockProps } = wp.blockEditor;
  const { PanelBody, TextControl, SelectControl } = wp.components;
  const el = wp.element.createElement;

  registerBlockType("proevent/event-grid", {
    edit: (props) => {
      const { attributes, setAttributes } = props;

      return el("div", useBlockProps(), [
        el(
          InspectorControls,
          {},
          el(PanelBody, { title: "Event Grid Settings", initialOpen: true }, [
            el(TextControl, {
              label: "Limit",
              type: "number",
              value: attributes.limit,
              onChange: (value) =>
                setAttributes({ limit: parseInt(value) || 0 }),
            }),
            el(TextControl, {
              label: "Category (slug)",
              value: attributes.category,
              onChange: (value) => setAttributes({ category: value }),
            }),
            el(SelectControl, {
              label: "Sorting",
              value: attributes.order,
              options: [
                { label: "DESC (Newest First)", value: "DESC" },
                { label: "ASC (Oldest First)", value: "ASC" },
              ],
              onChange: (value) => setAttributes({ order: value }),
            }),
          ]),
        ),

        el(
          "div",
          { className: "event-grid-placeholder" },
          "Event Grid preview will appear on the front-end.",
        ),
      ]);
    },
    save: () => null,
  });
})(window.wp);
