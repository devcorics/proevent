(function (blocks, editor, components, element) {
  const { registerBlockType } = blocks;
  const { RichText, InspectorControls, PanelColorSettings } = editor;
  const { PanelBody, SelectControl } = components;
  const { createElement: el } = element;

  registerBlockType("custom/notice-box", {
    title: "Notice Box",
    icon: "info",
    category: "common",

    attributes: {
      message: { type: "string", source: "html", selector: "p" },
      noticeType: { type: "string", default: "info" },
      bgColor: { type: "string", default: "#d8ebff" },
      textColor: { type: "string", default: "#333333" },
    },

    edit: function (props) {
      const { attributes, setAttributes } = props;

      return el(
        "div",
        {},
        el(
          InspectorControls,
          {},
          el(
            PanelBody,
            { title: "Notice Settings" },
            el(SelectControl, {
              label: "Notice Type",
              value: attributes.noticeType,
              options: [
                { label: "Info", value: "info" },
                { label: "Success", value: "success" },
                { label: "Warning", value: "warning" },
                { label: "Error", value: "error" },
              ],
              onChange: (newType) => setAttributes({ noticeType: newType }),
            }),
          ),
          el(PanelColorSettings, {
            title: "Colors",
            colorSettings: [
              {
                value: attributes.bgColor,
                onChange: (newColor) => setAttributes({ bgColor: newColor }),
                label: "Background Color",
              },
              {
                value: attributes.textColor,
                onChange: (newColor) => setAttributes({ textColor: newColor }),
                label: "Text Color",
              },
            ],
          }),
        ),
        el(
          "div",
          {
            style: {
              padding: "15px",
              backgroundColor: attributes.bgColor,
              color: attributes.textColor,
              borderLeft: `5px solid ${getBorderColor(attributes.noticeType)}`,
              borderRadius: "5px",
            },
          },
          el(RichText, {
            tagName: "p",
            value: attributes.message,
            onChange: (newMessage) => setAttributes({ message: newMessage }),
            placeholder: "Write your notice...",
          }),
        ),
      );
    },

    save: function (props) {
      const { attributes } = props;
      return el(
        "div",
        {
          style: {
            padding: "15px",
            backgroundColor: attributes.bgColor,
            color: attributes.textColor,
            borderLeft: `5px solid ${getBorderColor(attributes.noticeType)}`,
            borderRadius: "5px",
          },
        },
        el("p", {}, attributes.message),
      );
    },
  });

  function getBorderColor(type) {
    switch (type) {
      case "success":
        return "#28a745";
      case "warning":
        return "#ffc107";
      case "error":
        return "#dc3545";
      default:
        return "#4a90e2";
    }
  }
})(window.wp.blocks, window.wp.editor, window.wp.components, window.wp.element);
