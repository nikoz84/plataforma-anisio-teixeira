const configEditor = {
  el: document.querySelector("#description"),
  initialEditType: "wysiwyg",
  previewStyle: "vertical",
  heigth: "450px",
  usageStatistic: false,
  toolbarItems: [
    "heading",
    "bold",
    "italic",
    "strike",
    "divider",
    "hr",
    "quote",
    "divider",
    "ul",
    "ol",
    "task",
    "indent",
    "outdent",
    "divider",
    "table",
    "image",
    "link",
    "divider",
    "code",
    "codeblock"
  ]
};

module.exports = configEditor;
